<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Expense;
use App\Models\Experience;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Task;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'qualifications' => Qualification::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'services' => Service::count(),
            'assignments' => Assignment::count(),
            'tasks' => Task::count(),
            'tasks_pending' => Task::where('status', 'pending')->count(),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'visits_today' => Visit::today()->count(),
            'visits_total' => Visit::count(),
            'clients' => Client::count(),
            'meetings_upcoming' => Meeting::upcoming()->count(),
            'received_total' => (float) Payment::received()->sum('amount'),
            'pending_total' => (float) Payment::pending()->sum('amount'),
            'total_billed' => (float) Payment::sum('amount'),
            'pending_amount' => (float) Payment::pending()->sum('amount'),
        ];

        $visitTrend = Visit::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $trendLabels = collect(range(6, 0))->map(fn ($i) => Carbon::now()->subDays($i)->toDateString());
        $trendData = $trendLabels->map(fn ($date) => $visitTrend->get($date, 0));

        $recentVisits = Visit::latest()->limit(6)->get();
        $recentMessages = ContactMessage::ordered()->limit(5)->get();

        $recentlyCreated = DB::transaction(function () {
            return [
                'qualifications' => Qualification::latest('created_at')->limit(5)->get(),
                'assignments' => Assignment::latest()->limit(5)->get(),
            ];
        });

        $upcomingMeetings = Meeting::with('client')->upcoming()->ordered()->limit(5)->get();

        $period = $request->input('chart_period', 'week');
        $type = $request->input('chart_type', 'overlay');
        $financialData = $this->financialSeries($period, $type);

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentMessages' => $recentMessages,
            'recentlyCreated' => $recentlyCreated,
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
            'recentVisits' => $recentVisits,
            'upcomingMeetings' => $upcomingMeetings,
            'financialLabels' => $financialData['labels'],
            'financialExpenses' => $financialData['expenses'],
            'financialPayments' => $financialData['payments'],
            'financialPeriod' => $period,
            'financialType' => $type,
            ...$this->calendarData($request),
        ]);
    }

    public function financials(Request $request)
    {
        $period = $request->input('chart_period', 'week');
        $type = $request->input('chart_type', 'overlay');
        $data = $this->financialSeries($period, $type);

        return response()->json([
            'html' => view('admin.partials.financial-chart', [
                'financialLabels' => $data['labels'],
                'financialExpenses' => $data['expenses'],
                'financialPayments' => $data['payments'],
                'financialPeriod' => $period,
                'financialType' => $type,
            ])->render(),
            'period' => $period,
            'type' => $type,
        ]);
    }

    public function calendar(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));

        return response()->json([
            'html' => view('admin.partials.meeting-calendar', $this->calendarData($request, $month))->render(),
            'label' => $month->format('F Y'),
            'month' => $month->format('Y-m'),
        ]);
    }

    /** @return array<string, mixed> */
    private function calendarData(Request $request, ?Carbon $month = null): array
    {
        $month = $month ?? $this->resolveMonth($request->input('month'));

        $monthMeetings = Meeting::with('client')
            ->whereBetween('meeting_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
            ->ordered()
            ->get()
            ->groupBy(fn ($meeting) => $meeting->meeting_date->toDateString());

        $gridStart = $month->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = [];
        $cursor = $gridStart->copy();

        while ($cursor->lessThanOrEqualTo($gridEnd)) {
            $calendarDays[] = [
                'date' => $cursor->copy(),
                'inMonth' => $cursor->month === $month->month,
                'isToday' => $cursor->isToday(),
                'meetings' => $monthMeetings->get($cursor->toDateString(), collect()),
            ];
            $cursor->addDay();
        }

        return [
            'calendarMonth' => $month,
            'calendarDays' => $calendarDays,
            'calendarMonthLabel' => $month->format('F Y'),
        ];
    }

    private function resolveMonth(?string $value): Carbon
    {
        try {
            return $value
                ? Carbon::createFromFormat('Y-m', $value)->startOfMonth()
                : Carbon::now()->startOfMonth();
        } catch (\Throwable) {
            return Carbon::now()->startOfMonth();
        }
    }

    /** @return array{labels: string[], expenses: float[], payments: float[]} */
    private function financialSeries(string $period = 'week', string $type = 'overlay'): array
    {
        $now = Carbon::now();

        if ($period === 'year') {
            $labels = collect(range(11, 0))
                ->map(fn ($i) => $now->copy()->startOfMonth()->subMonths($i)->format('M y'))
                ->values()
                ->all();

            $expenses = collect(range(11, 0))->map(function ($i) use ($now) {
                $month = $now->copy()->startOfMonth()->subMonths($i);
                return (float) Expense::whereBetween('expense_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->sum('amount');
            })->all();

            $payments = collect(range(11, 0))->map(function ($i) use ($now) {
                $month = $now->copy()->startOfMonth()->subMonths($i);
                return (float) Payment::received()->whereBetween('payment_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->sum('amount');
            })->all();

            return compact('labels', 'expenses', 'payments');
        }

        if ($period === 'month') {
            $labels = collect(range(0, $now->day - 1))
                ->map(fn ($i) => $now->copy()->startOfMonth()->addDays($i)->format('d'))
                ->values()
                ->all();

            $expenses = collect(range(0, $now->day - 1))->map(function ($i) use ($now) {
                $day = $now->copy()->startOfMonth()->addDays($i);
                return (float) Expense::whereDate('expense_date', $day)->sum('amount');
            })->all();

            $payments = collect(range(0, $now->day - 1))->map(function ($i) use ($now) {
                $day = $now->copy()->startOfMonth()->addDays($i);
                return (float) Payment::received()->whereDate('payment_date', $day)->sum('amount');
            })->all();

            return compact('labels', 'expenses', 'payments');
        }

        $labels = collect(range(6, 0))
            ->map(fn ($i) => $now->copy()->subDays($i)->format('D'))
            ->values()
            ->all();

        $expenses = collect(range(6, 0))->map(function ($i) use ($now) {
            $day = $now->copy()->subDays($i);
            return (float) Expense::whereDate('expense_date', $day)->sum('amount');
        })->all();

        $payments = collect(range(6, 0))->map(function ($i) use ($now) {
            $day = $now->copy()->subDays($i);
            return (float) Payment::received()->whereDate('payment_date', $day)->sum('amount');
        })->all();

        return compact('labels', 'expenses', 'payments');
    }
}
