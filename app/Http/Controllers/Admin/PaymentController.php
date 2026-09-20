<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientWork;
use App\Models\Payment;
use App\Services\ExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = $this->filteredQuery($request)
            ->with(['client', 'work'])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totals = $this->totals($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.payments._table', ['payments' => $payments])->render(),
            ]);
        }

        return view('admin.payments.index', [
            'title' => 'Payments & Earnings',
            'payments' => $payments,
            'totals' => $totals,
            'clients' => Client::ordered()->get(),
            'filters' => $request->only(['search', 'client_id', 'status', 'month', 'year']),
        ]);
    }

    public function create(Request $request)
    {
        $selectedClient = $request->integer('client_id') ?: null;
        $client = $selectedClient ? Client::find($selectedClient) : null;

        return view('admin.payments.create', [
            'title' => 'Record Payment',
            'clients' => Client::ordered()->get(),
            'works' => ClientWork::with('client')->ordered()->get(),
            'selectedClient' => $selectedClient,
            'summary' => $client ? $this->clientSummary($client, null) : null,
        ]);
    }

    public function store(Request $request)
    {
        Payment::create($this->validatePayment($request));

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $work = $payment->client && $payment->client_work_id ? $payment->client->works()->find($payment->client_work_id) : null;

        return view('admin.payments.edit', [
            'title' => 'Edit Payment',
            'payment' => $payment,
            'clients' => Client::ordered()->get(),
            'works' => ClientWork::with('client')->ordered()->get(),
            'summary' => $payment->client ? $this->clientSummary($payment->client, $work, $payment->id) : null,
        ]);
    }

    public function summary(Request $request)
    {
        $client = $request->filled('client_id') ? Client::find($request->integer('client_id')) : null;
        $work = null;

        if ($client && $request->filled('client_work_id')) {
            $work = $client->works()->find($request->integer('client_work_id'));
        }

        $summary = $client ? $this->clientSummary($client, $work) : null;

        return response()->json([
            'summary' => $summary,
            'html' => $summary
                ? view('admin.payments._summary-partial', ['summary' => $summary])->render()
                : null,
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($this->validatePayment($request));

        return redirect()
            ->route('admin.payments.index')
            ->with('status', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back()->with('status', 'Payment deleted successfully.');
    }

    public function export(Request $request, string $format)
    {
        $payments = $this->filteredQuery($request)
            ->with(['client', 'work'])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->get();

        $headings = ['Date', 'Client', 'Work', 'Amount', 'Method', 'Status', 'Reference', 'Notes'];
        $rows = $payments->map(fn (Payment $payment) => [
            $payment->payment_date?->format('Y-m-d'),
            $payment->client?->name,
            $payment->work?->title,
            number_format((float) $payment->amount, 2, '.', ''),
            $payment->method_label,
            ucfirst((string) $payment->status),
            $payment->reference,
            $payment->notes,
        ]);

        $filename = 'payments-'.now()->format('Y-m-d-His');
        $filters = $request->only(['search', 'client_id', 'status', 'month', 'year']);

        return match ($format) {
            'csv' => ExportService::csv($filename.'.csv', $headings, $rows),
            'xlsx' => ExportService::xlsx($filename.'.xlsx', $headings, $rows),
            'pdf' => ExportService::pdf($filename.'.pdf', 'admin.payments.report-pdf', [
                'payments' => $payments,
                'totals' => $this->totals($request),
                'filters' => $filters,
                'generatedAt' => now(),
            ]),
            default => abort(404),
        };
    }

    private function filteredQuery(Request $request): Builder
    {
        return Payment::query()
            ->when($request->filled('search'), function (Builder $query) use ($request) {
                $search = $request->input('search');
                $query->where(function (Builder $inner) use ($search) {
                    $inner->where('reference', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")
                        ->orWhereHas('client', function (Builder $client) use ($search) {
                            $client->where('name', 'like', "%{$search}%")
                                ->orWhere('company', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('client_id'), fn (Builder $query) => $query->where('client_id', $request->integer('client_id')))
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->input('status')))
            ->when($request->filled('month'), fn (Builder $query) => $query->whereMonth('payment_date', $request->integer('month')))
            ->when($request->filled('year'), fn (Builder $query) => $query->whereYear('payment_date', $request->integer('year')));
    }

    /**
     * @return array{received: float, pending: float, billed: float, balance: float}
     */
    private function totals(Request $request): array
    {
        $received = (float) $this->filteredQuery($request)->received()->sum('amount');

        $clientQuery = Client::query()
            ->withSum(['works as total_billed' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'amount')
            ->withSum(['payments as received_total' => fn ($q) => $q->where('status', 'received')], 'amount');

        if ($request->filled('client_id')) {
            $clientQuery->whereKey($request->integer('client_id'));
        }

        $clients = $clientQuery->get();
        $billed = (float) $clients->sum('total_billed');
        $outstanding = (float) $clients->sum(fn (Client $client) => max(0, $client->total_billed - $client->received_total));

        return [
            'received' => $received,
            'billed' => $billed,
            'balance' => $outstanding,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function clientSummary(?Client $client, ?ClientWork $work, ?int $excludePaymentId = null): ?array
    {
        if (! $client) {
            return null;
        }

        $client->loadMissing(['works', 'payments.work']);

        $totalBilled = (float) $client->works->where('status', '!=', 'cancelled')->sum('amount');
        $received = (float) $client->payments->where('status', 'received')->sum('amount');
        $balance = max(0, $totalBilled - $received);

        $workSummary = null;
        if ($work) {
            $workReceived = (float) $client->payments
                ->where('client_work_id', $work->id)
                ->where('status', 'received')
                ->sum('amount');
            $workSummary = [
                'title' => $work->title,
                'amount' => (float) $work->amount,
                'received' => $workReceived,
                'balance' => max(0, (float) $work->amount - $workReceived),
            ];
        }

        $paymentHistory = $client->payments
            ->where('id', '!=', $excludePaymentId)
            ->sortByDesc('payment_date')
            ->take(5)
            ->values()
            ->map(fn (Payment $payment) => [
                'id' => $payment->id,
                'date' => $payment->payment_date?->format('d M Y'),
                'amount' => (float) $payment->amount,
                'status' => $payment->status,
                'method' => $payment->method_label,
            ]);

        return [
            'name' => $client->name,
            'total_billed' => $totalBilled,
            'received' => $received,
            'balance' => $balance,
            'work' => $workSummary,
            'history' => $paymentHistory->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayment(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'client_work_id' => ['nullable', 'exists:client_works,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_date' => ['required', 'date'],
            'method' => ['nullable', Rule::in(array_keys(Payment::METHODS))],
            'status' => ['required', Rule::in([Payment::STATUS_RECEIVED, Payment::STATUS_PENDING])],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
