<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $this->filteredQuery($request)
            ->dueOn($request->input('date'))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'all' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'done' => Task::where('status', 'done')->count(),
            'hold' => Task::where('status', 'hold')->count(),
        ];

        $categories = Task::distinct()->pluck('category')->filter()->sort()->values();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.tasks._table', ['tasks' => $tasks])->render(),
            ]);
        }

        return view('admin.tasks.index', [
            'title' => 'My Tasks',
            'tasks' => $tasks,
            'counts' => $counts,
            'categories' => $categories,
            ...$this->calendarData($request),
        ]);
    }

    public function calendar(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));

        return response()->json([
            'html' => view('admin.tasks._calendar', $this->calendarData($request, $month))->render(),
            'label' => $month->format('F Y'),
            'month' => $month->format('Y-m'),
        ]);
    }

    public function create()
    {
        return view('admin.tasks.create', [
            'title' => 'Add Task',
            'task' => new Task(['priority' => 'medium', 'status' => 'pending', 'is_active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateTask($request);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['completed_at'] = $validated['status'] === 'done' ? now() : null;

        Task::create($validated);

        return redirect()
            ->route('admin.tasks.index')
            ->with('status', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('admin.tasks.edit', [
            'title' => 'Edit Task',
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $this->validateTask($request);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['completed_at'] = $validated['status'] === 'done'
            ? ($task->completed_at ?? now())
            : null;

        $task->update($validated);

        return redirect()
            ->route('admin.tasks.index')
            ->with('status', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Task::STATUSES))],
        ]);

        $task->update([
            'status' => $validated['status'],
            'completed_at' => $validated['status'] === 'done' ? now() : null,
        ]);

        return back()->with('status', 'Task status updated.');
    }

    public function toggle(Task $task)
    {
        $task->update(['is_active' => ! $task->is_active]);

        return back()->with('status', 'Task visibility updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('status', 'Task deleted successfully.');
    }

    /** @return array<string, mixed> */
    private function validateTask(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::in(array_keys(Task::PRIORITIES))],
            'status' => ['required', Rule::in(array_keys(Task::STATUSES))],
            'due_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function filteredQuery(Request $request): Builder
    {
        $query = Task::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query
            ->status($request->input('status'))
            ->priority($request->input('priority'))
            ->category($request->input('category'));
    }

    /** @return array<string, mixed> */
    private function calendarData(Request $request, ?Carbon $month = null): array
    {
        $month = $month ?? $this->resolveMonth($request->input('month'));
        $selectedDate = $request->input('date');

        $monthTasks = $this->filteredQuery($request)
            ->whereBetween('due_date', [
                $month->copy()->startOfMonth()->toDateString(),
                $month->copy()->endOfMonth()->toDateString(),
            ])
            ->get()
            ->groupBy(fn (Task $task) => $task->due_date->toDateString());

        $gridStart = $month->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = [];
        $cursor = $gridStart->copy();

        while ($cursor->lessThanOrEqualTo($gridEnd)) {
            $calendarDays[] = [
                'date' => $cursor->copy(),
                'inMonth' => $cursor->month === $month->month,
                'isToday' => $cursor->isToday(),
                'isSelected' => $selectedDate === $cursor->toDateString(),
                'tasks' => $monthTasks->get($cursor->toDateString(), collect()),
            ];
            $cursor->addDay();
        }

        return [
            'calendarMonth' => $month,
            'calendarDays' => $calendarDays,
            'selectedDate' => $selectedDate,
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
}
