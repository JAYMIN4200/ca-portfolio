<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Payment;
use App\Services\ExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = $this->filteredQuery($request)
            ->with('client')
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totals = $this->totals($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.expenses._table', ['expenses' => $expenses])->render(),
            ]);
        }

        return view('admin.expenses.index', [
            'title' => 'Expenses',
            'expenses' => $expenses,
            'totals' => $totals,
            'clients' => Client::ordered()->get(),
            'filters' => $request->only(['search', 'client_id', 'category', 'month', 'year']),
        ]);
    }

    public function create(Request $request)
    {
        $selectedClient = $request->integer('client_id') ?: null;

        return view('admin.expenses.create', [
            'title' => 'Add Expense',
            'clients' => Client::ordered()->get(),
            'selectedClient' => $selectedClient,
        ]);
    }

    public function store(Request $request)
    {
        Expense::create($this->validateExpense($request));

        return redirect()
            ->route('admin.expenses.index')
            ->with('status', 'Expense added successfully.');
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', [
            'title' => 'Edit Expense',
            'expense' => $expense,
            'clients' => Client::ordered()->get(),
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $expense->update($this->validateExpense($request));

        return redirect()
            ->route('admin.expenses.index')
            ->with('status', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return back()->with('status', 'Expense deleted successfully.');
    }

    public function export(Request $request, string $format)
    {
        $expenses = $this->filteredQuery($request)
            ->with('client')
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->get();

        $headings = ['Date', 'Category', 'Description', 'Client', 'Amount', 'Method', 'Reference'];
        $rows = $expenses->map(fn (Expense $expense) => [
            $expense->expense_date?->format('Y-m-d'),
            $expense->category_label,
            $expense->description,
            $expense->client?->name,
            number_format((float) $expense->amount, 2, '.', ''),
            $expense->method,
            $expense->reference,
        ]);

        $filename = 'expenses-'.now()->format('Y-m-d-His');
        $filters = $request->only(['search', 'client_id', 'category', 'month', 'year']);

        return match ($format) {
            'csv' => ExportService::csv($filename.'.csv', $headings, $rows),
            'xlsx' => ExportService::xlsx($filename.'.xlsx', $headings, $rows),
            'pdf' => ExportService::pdf($filename.'.pdf', 'admin.expenses.report-pdf', [
                'expenses' => $expenses,
                'totals' => $this->totals($request),
                'filters' => $filters,
                'generatedAt' => now(),
            ]),
            default => abort(404),
        };
    }

    private function filteredQuery(Request $request): Builder
    {
        return Expense::query()
            ->when($request->filled('search'), function (Builder $query) use ($request) {
                $search = $request->input('search');
                $query->where(function (Builder $inner) use ($search) {
                    $inner->where('description', 'like', "%{$search}%")
                        ->orWhere('reference', 'like', "%{$search}%")
                        ->orWhereHas('client', function (Builder $client) use ($search) {
                            $client->where('name', 'like', "%{$search}%")
                                ->orWhere('company', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('client_id'), fn (Builder $query) => $query->where('client_id', $request->integer('client_id')))
            ->when($request->filled('category'), fn (Builder $query) => $query->where('category', $request->input('category')))
            ->when($request->filled('month'), fn (Builder $query) => $query->whereMonth('expense_date', $request->integer('month')))
            ->when($request->filled('year'), fn (Builder $query) => $query->whereYear('expense_date', $request->integer('year')));
    }

    /**
     * @return array{total: float, this_month: float, count: int}
     */
    private function totals(Request $request): array
    {
        return [
            'total' => (float) $this->filteredQuery($request)->sum('amount'),
            'this_month' => (float) Expense::query()
                ->whereMonth('expense_date', now()->month)
                ->whereYear('expense_date', now()->year)
                ->sum('amount'),
            'count' => (int) $this->filteredQuery($request)->count(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validateExpense(Request $request): array
    {
        return $request->validate([
            'client_id' => ['nullable', 'exists:clients,id'],
            'category' => ['required', Rule::in(array_keys(Expense::CATEGORIES))],
            'custom_category' => ['nullable', 'required_if:category,other', 'string', 'max:60'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'method' => ['nullable', Rule::in(array_keys(Payment::METHODS))],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);
    }
}