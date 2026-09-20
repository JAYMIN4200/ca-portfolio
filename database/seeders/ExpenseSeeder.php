<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $expenses = [
            ['client' => 'ramesh@balajitraders.in', 'category' => 'travel', 'description' => 'Client site visit for annual books finalisation kickoff', 'amount' => 1850, 'method' => 'cash', 'reference' => 'EXP-2001', 'days' => -2],
            ['client' => 'priya@shahassociates.co.in', 'category' => 'software', 'description' => 'Tally GST audit pack yearly renewal', 'amount' => 4999, 'method' => 'upi', 'reference' => 'EXP-2002', 'days' => -25],
            ['client' => 'amit@desaiconsultants.com', 'category' => 'salary', 'description' => 'Data entry assistant overtime for scrutiny reply', 'amount' => 2500, 'method' => 'cash', 'reference' => 'EXP-2003', 'days' => -4],
            ['client' => 'kiran@kirantextiles.in', 'category' => 'travel', 'description' => 'Rail fare for GST registration document collection', 'amount' => 980, 'method' => 'upi', 'reference' => 'EXP-2004', 'days' => -40],
            ['client' => 'kiran@kirantextiles.in', 'category' => 'office', 'description' => 'Courier of original documents to GST office', 'amount' => 350, 'method' => 'cash', 'reference' => 'EXP-2005', 'days' => -12],
            ['client' => 'neel@trivedico.in', 'category' => 'software', 'description' => 'ClearTax E-filing combo plan - 1 year', 'amount' => 8999, 'method' => 'card', 'reference' => 'EXP-2006', 'days' => -55],
            ['client' => 'sunita@mehtaindustries.com', 'category' => 'marketing', 'description' => 'LinkedIn company page boost campaign', 'amount' => 2000, 'method' => 'upi', 'reference' => 'EXP-2007', 'days' => -6],
            ['client' => 'neel@trivedico.in', 'category' => 'travel', 'description' => 'Fuel for monthly MIS client meeting', 'amount' => 750, 'method' => 'card', 'reference' => 'EXP-2008', 'days' => -1],
            ['client' => 'ramesh@balajitraders.in', 'category' => 'utilities', 'description' => 'Printer ink and stationery for return packing', 'amount' => 1200, 'method' => 'cash', 'reference' => 'EXP-2009', 'days' => -18],
            ['client' => 'amit@desaiconsultants.com', 'category' => 'professional', 'description' => 'ICAI membership renewal 2026-27', 'amount' => 2200, 'method' => 'bank_transfer', 'reference' => 'EXP-2010', 'days' => -35],
            ['client' => 'sunita@mehtaindustries.com', 'category' => 'travel', 'description' => 'Taxi for ROC filing at Registrar office', 'amount' => 640, 'method' => 'upi', 'reference' => 'EXP-2011', 'days' => -9],
            ['client' => 'kiran@kirantextiles.in', 'category' => 'utilities', 'description' => 'Electricity bill share for practice office', 'amount' => 3250, 'method' => 'bank_transfer', 'reference' => 'EXP-2012', 'days' => -3],
        ];

        foreach ($expenses as $data) {
            $client = Client::where('email', $data['client'])->first();

            if (! $client) {
                continue;
            }

            Expense::updateOrCreate(
                ['client_id' => $client->id, 'reference' => $data['reference']],
                [
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'amount' => $data['amount'],
                    'expense_date' => Carbon::today()->addDays($data['days'])->toDateString(),
                    'method' => $data['method'],
                ]
            );
        }
    }
}
