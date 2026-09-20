<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientWork;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $clients = [
            [
                'name' => 'Ramesh Patel',
                'company' => 'Shree Balaji Traders',
                'email' => 'ramesh@balajitraders.in',
                'phone' => '+91 98250 12345',
                'location' => 'Ahmedabad, Gujarat',
                'notes' => 'GST and bookkeeping retainer since 2022.',
                'works' => [
                    ['title' => 'Monthly GST returns (GSTR-1 & 3B)', 'amount' => 6000, 'status' => 'completed', 'days' => -20, 'description' => 'Filed GSTR-1 and GSTR-3B for the previous month.'],
                    ['title' => 'Annual books finalisation FY 2024-25', 'amount' => 25000, 'status' => 'in_progress', 'days' => -5, 'description' => 'Ledger scrutiny and finalisation of financial statements.'],
                ],
            ],
            [
                'name' => 'Priya Shah',
                'company' => 'Shah & Associates',
                'email' => 'priya@shahassociates.co.in',
                'phone' => '+91 97270 44556',
                'location' => 'Surat, Gujarat',
                'notes' => 'Statutory audit support for CA firm.',
                'works' => [
                    ['title' => 'Statutory audit voucher testing', 'amount' => 18000, 'status' => 'completed', 'days' => -30, 'description' => 'Voucher testing and working paper preparation.'],
                ],
            ],
            [
                'name' => 'Amit Desai',
                'company' => 'Desai Consultants Pvt Ltd',
                'email' => 'amit@desaiconsultants.com',
                'phone' => '+91 99090 77889',
                'location' => 'Vadodara, Gujarat',
                'notes' => 'Income tax scrutiny and advisory.',
                'works' => [
                    ['title' => 'Income tax scrutiny reply FY 2022-23', 'amount' => 35000, 'status' => 'in_progress', 'days' => -12, 'description' => 'Reconciliation annexure and submission to the department.'],
                    ['title' => 'Advance tax computation Q3', 'amount' => 8000, 'status' => 'pending', 'days' => 6, 'description' => 'Project annual income and compute installments.'],
                ],
            ],
            [
                'name' => 'Kiran Joshi',
                'company' => 'Kiran Textiles',
                'email' => 'kiran@kirantextiles.in',
                'phone' => '+91 90999 33445',
                'location' => 'Rajkot, Gujarat',
                'notes' => 'GST registration and monthly filings.',
                'works' => [
                    ['title' => 'GST registration and setup', 'amount' => 5000, 'status' => 'completed', 'days' => -60, 'description' => 'New registration and compliance setup.'],
                    ['title' => 'Input credit reconciliation', 'amount' => 9000, 'status' => 'completed', 'days' => -15, 'description' => 'Recovered eligible input tax credit.'],
                ],
            ],
            [
                'name' => 'Neel Trivedi',
                'company' => 'Trivedi & Co.',
                'email' => 'neel@trivedico.in',
                'phone' => '+91 98450 66778',
                'location' => 'Ahmedabad, Gujarat',
                'notes' => 'Monthly MIS and profitability reporting.',
                'works' => [
                    ['title' => 'Monthly MIS report', 'amount' => 12000, 'status' => 'in_progress', 'days' => -3, 'description' => 'Receivables ageing and profitability by product line.'],
                ],
            ],
            [
                'name' => 'Sunita Mehta',
                'company' => 'Mehta Industries',
                'email' => 'sunita@mehtaindustries.com',
                'phone' => '+91 99740 11223',
                'location' => 'Gandhinagar, Gujarat',
                'notes' => 'TDS and ROC compliance for the group.',
                'works' => [
                    ['title' => 'Quarterly TDS returns', 'amount' => 15000, 'status' => 'pending', 'days' => 10, 'description' => 'Consolidate challans and file quarterly TDS returns.'],
                    ['title' => 'ROC annual filing AOC-4', 'amount' => 20000, 'status' => 'in_progress', 'days' => 4, 'description' => 'Compile statements and board documents for filing.'],
                ],
            ],
        ];

        foreach ($clients as $data) {
            $client = Client::updateOrCreate(
                ['email' => $data['email']],
                [
                    'user_id' => $admin?->id,
                    'name' => $data['name'],
                    'company' => $data['company'],
                    'phone' => $data['phone'],
                    'location' => $data['location'],
                    'notes' => $data['notes'],
                    'is_active' => true,
                    'display_order' => 0,
                ]
            );

            foreach ($data['works'] as $work) {
                ClientWork::updateOrCreate(
                    ['client_id' => $client->id, 'title' => $work['title']],
                    [
                        'description' => $work['description'],
                        'work_date' => Carbon::today()->addDays($work['days'])->toDateString(),
                        'amount' => $work['amount'],
                        'status' => $work['status'],
                    ]
                );
            }
        }
    }
}
