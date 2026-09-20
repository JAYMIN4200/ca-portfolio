<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientWork;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientWorkController extends Controller
{
    public function store(Request $request, Client $client)
    {
        $validated = $this->validateWork($request);

        $client->works()->create($validated);

        return back()->with('status', 'Work added successfully.');
    }

    public function update(Request $request, Client $client, ClientWork $work)
    {
        abort_unless($work->client_id === $client->id, 404);

        $work->update($this->validateWork($request));

        return back()->with('status', 'Work updated successfully.');
    }

    public function destroy(Client $client, ClientWork $work)
    {
        abort_unless($work->client_id === $client->id, 404);

        $work->delete();

        return back()->with('status', 'Work deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateWork(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:4000'],
            'work_date' => ['nullable', 'date'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(array_keys(ClientWork::STATUSES))],
        ]);
    }
}
