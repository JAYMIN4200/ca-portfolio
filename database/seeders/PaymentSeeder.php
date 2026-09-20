<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientWork;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            ['client' => 'ramesh@balajitraders.in', 'work' => 'Monthly GST returns (GSTR-1 & 3B)', 'amount' => 6000, 'status' => 'received', 'method' => 'upi', 'reference' => 'PAY-1001', 'days' => -18],
            ['client' => 'ramesh@balajitraders.in', 'work' => 'Annual books finalisation FY 2024-25', 'amount' => 12500, 'status' => 'pending', 'method' => 'bank_transfer', 'reference' => 'PAY-1002', 'days' => 5],
            ['client' => 'priya@shahassociates.co.in', 'work' => 'Statutory audit voucher testing', 'amount' => 18000, 'status' => 'received', 'method' => 'bank_transfer', 'reference' => 'PAY-1003', 'days' => -28],
            ['client' => 'amit@desaiconsultants.com', 'work' => 'Income tax scrutiny reply FY 2022-23', 'amount' => 20000, 'status' => 'received', 'method' => 'cheque', 'reference' => 'PAY-1004', 'days' => -10],
            ['client' => 'amit@desaiconsultants.com', 'work' => 'Advance tax computation Q3', 'amount' => 8000, 'status' => 'pending', 'method' => 'upi', 'reference' => 'PAY-1005', 'days' => 8],
            ['client' => 'kiran@kirantextiles.in', 'work' => 'GST registration and setup', 'amount' => 5000, 'status' => 'received', 'method' => 'cash', 'reference' => 'PAY-1006', 'days' => -55],
            ['client' => 'kiran@kirantextiles.in', 'work' => 'Input credit reconciliation', 'amount' => 9000, 'status' => 'received', 'method' => 'upi', 'reference' => 'PAY-1007', 'days' => -14],
            ['client' => 'neel@trivedico.in', 'work' => 'Monthly MIS report', 'amount' => 12000, 'status' => 'received', 'method' => 'bank_transfer', 'reference' => 'PAY-1008', 'days' => -2],
            ['client' => 'neel@trivedico.in', 'work' => null, 'amount' => 12000, 'status' => 'pending', 'method' => 'bank_transfer', 'reference' => 'PAY-1009', 'days' => 12],
            ['client' => 'sunita@mehtaindustries.com', 'work' => 'Quarterly TDS returns', 'amount' => 15000, 'status' => 'pending', 'method' => 'bank_transfer', 'reference' => 'PAY-1010', 'days' => 9],
            ['client' => 'sunita@mehtaindustries.com', 'work' => 'ROC annual filing AOC-4', 'amount' => 20000, 'status' => 'received', 'method' => 'card', 'reference' => 'PAY-1011', 'days' => -6],
            ['client' => 'sunita@mehtaindustries.com', 'work' => null, 'amount' => 7500, 'status' => 'pending', 'method' => 'upi', 'reference' => 'PAY-1012', 'days' => 15],
        ];

        foreach ($payments as $data) {
            $client = Client::where('email', $data['client'])->first();

            if (! $client) {
                continue;
            }

            $work = $data['work']
                ? ClientWork::where('client_id', $client->id)->where('title', $data['work'])->first()
                : null;

            Payment::updateOrCreate(
                ['reference' => $data['reference']],
                [
                    'client_id' => $client->id,
                    'client_work_id' => $work?->id,
                    'amount' => $data['amount'],
                    'payment_date' => Carbon::today()->addDays($data['days'])->toDateString(),
                    'method' => $data['method'],
                    'status' => $data['status'],
                    'notes' => null,
                ]
            );
        }
    }
}
