<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientWork;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\ExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = $this->filteredQuery($request)->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.clients._table', ['clients' => $clients])->render(),
            ]);
        }

        return view('admin.clients.index', [
            'title' => 'Clients',
            'clients' => $clients,
            'clientsDropdown' => Client::ordered()->get(),
        ]);
    }

    /**
     * @return Builder<Client>
     */
    protected function filteredQuery(Request $request)
    {
        return Client::query()
            ->withCount(['works', 'payments'])
            ->withSum(['works as total_billed' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'amount')
            ->withSum(['payments as received_total' => fn ($q) => $q->where('status', 'received')], 'amount')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(fn ($clause) => $clause->where('name', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"));
            })
            ->when($request->filled('client_id'), fn ($query) => $query->whereKey($request->integer('client_id')))
            ->ordered();
    }

    public function create()
    {
        return view('admin.clients.create', [
            'title' => 'Add Client',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateClient($request);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        Client::create($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load(['works', 'payments' => fn ($q) => $q->with('work')->orderByDesc('payment_date')]);

        $received = (float) $client->payments->where('status', 'received')->sum('amount');
        $totalBilled = (float) $client->works->where('status', '!=', 'cancelled')->sum('amount');
        $balance = max(0, $totalBilled - $received);

        $receivedByWork = $client->payments
            ->where('status', 'received')
            ->groupBy('client_work_id')
            ->map(fn ($payments) => (float) $payments->sum('amount'));

        return view('admin.clients.show', [
            'title' => $client->name,
            'client' => $client,
            'totals' => [
                'total_billed' => $totalBilled,
                'received' => $received,
                'balance' => $balance,
                'works' => $client->works->count(),
            ],
            'receivedByWork' => $receivedByWork,
            'workStatuses' => ClientWork::STATUSES,
            'paymentMethods' => Payment::METHODS,
        ]);
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', [
            'title' => 'Edit Client',
            'client' => $client,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $this->validateClient($request);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $client->update($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with('status', 'Client deleted successfully.');
    }

    public function toggle(Client $client)
    {
        $client->update(['is_active' => ! $client->is_active]);

        return back()->with('status', 'Client status updated.');
    }

    public function invoice(Client $client)
    {
        $client->load(['works', 'payments.work']);

        $received = (float) $client->payments->where('status', 'received')->sum('amount');
        $totalBilled = (float) $client->works->where('status', '!=', 'cancelled')->sum('amount');
        $balance = max(0, $totalBilled - $received);

        $totals = [
            'total_billed' => $totalBilled,
            'received' => $received,
            'balance' => $balance,
        ];

        $filename = 'invoice-'.Str::slug('client-'.$client->id).'-'.now()->format('Ymd').'.pdf';

        return ExportService::pdf($filename, 'admin.clients.invoice-pdf', [
            'client' => $client,
            'works' => $client->works,
            'payments' => $client->payments,
            'totals' => $totals,
            'business' => [
                'name' => Setting::getValue('site_name', 'Jinendra Panchal'),
                'phone' => Setting::getValue('contact_phone'),
                'email' => Setting::getValue('contact_email'),
                'location' => Setting::getValue('contact_location'),
            ],
            'invoiceNumber' => 'INV-'.now()->format('Y').'-'.str_pad((string) $client->id, 3, '0', STR_PAD_LEFT),
            'generatedAt' => now(),
        ]);
    }

    public function export(Request $request, string $format)
    {
        $clients = $this->filteredQuery($request)->get();

        $headings = ['Name', 'Company', 'Email', 'Phone', 'Location', 'Works', 'Total Amount', 'Received', 'Pending Amount', 'Status'];
        $rows = $clients->map(fn (Client $client) => [
            $client->name,
            $client->company,
            $client->email,
            $client->phone,
            $client->location,
            $client->works_count,
            number_format($client->total_billed, 2, '.', ''),
            number_format($client->received_total, 2, '.', ''),
            number_format($client->balance, 2, '.', ''),
            $client->is_active ? 'Active' : 'Inactive',
        ]);

        $filename = 'clients-'.now()->format('Y-m-d-His');

        return match ($format) {
            'csv' => ExportService::csv($filename.'.csv', $headings, $rows),
            'xlsx' => ExportService::xlsx($filename.'.xlsx', $headings, $rows),
            'pdf' => ExportService::pdf($filename.'.pdf', 'admin.clients.report-pdf', [
                'clients' => $clients,
                'generatedAt' => now(),
            ]),
            default => abort(404),
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function validateClient(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'max:25', 'regex:/^\+?(?:[()\-\s]*\d){7,15}[()\-\s]*$/'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:4000'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
