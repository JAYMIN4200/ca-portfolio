<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $tasks = [
            ['title' => 'Finalise audit working papers for ABC Manufacturing', 'category' => 'Audit', 'priority' => 'high', 'status' => 'in_progress', 'due' => 1, 'description' => 'Complete voucher testing, tie-up of ledgers and prepare the audit finalisation file before partner review.'],
            ['title' => 'File GSTR-3B for September for retail client', 'category' => 'GST', 'priority' => 'high', 'status' => 'pending', 'due' => 2, 'description' => 'Reconcile ITC as per GSTR-2B, compute output tax and file the return on the portal.'],
            ['title' => 'Prepare income tax computation for HNI client', 'category' => 'Income Tax', 'priority' => 'high', 'status' => 'pending', 'due' => 0, 'description' => 'Compute income under all heads, claim deductions and arrive at tax payable.'],
            ['title' => 'Monthly bank reconciliation for trading firm', 'category' => 'Accounting', 'priority' => 'medium', 'status' => 'pending', 'due' => 3, 'description' => 'Match bank statement with books and list unreconciled entries.'],
            ['title' => 'Update TDS challans and prepare quarterly summary', 'category' => 'TDS', 'priority' => 'medium', 'status' => 'hold', 'due' => 5, 'description' => 'Waiting for challan details from the client before consolidation.'],
            ['title' => 'Draft management MIS report for review', 'category' => 'Advisory', 'priority' => 'medium', 'status' => 'pending', 'due' => 4, 'description' => 'Prepare receivables ageing, profitability by product line and cash flow snapshot.'],
            ['title' => 'ROC annual filing — form AOC-4 preparation', 'category' => 'ROC / MCA', 'priority' => 'high', 'status' => 'pending', 'due' => 7, 'description' => 'Compile financial statements and board documents for AOC-4 filing.'],
            ['title' => 'Reconcile vendor ledgers for the quarter', 'category' => 'Accounting', 'priority' => 'low', 'status' => 'pending', 'due' => 6, 'description' => 'Match purchase register with vendor confirmations and flag differences.'],
            ['title' => 'Respond to GST notice for FY 2023-24', 'category' => 'GST', 'priority' => 'high', 'status' => 'in_progress', 'due' => -2, 'description' => 'Prepare the reconciliation annexure and draft a reply to the department.'],
            ['title' => 'Complete bookkeeping entries for the month', 'category' => 'Bookkeeping', 'priority' => 'medium', 'status' => 'done', 'due' => -3, 'description' => 'Recorded all sales, purchase and journal entries with supporting vouchers.'],
            ['title' => 'Share quarterly portfolio summary with mentor', 'category' => 'Documentation', 'priority' => 'low', 'status' => 'done', 'due' => -5, 'description' => 'Compiled the articleship portfolio and shared the progress summary.'],
            ['title' => 'Prepare advance tax estimate for Q3', 'category' => 'Income Tax', 'priority' => 'medium', 'status' => 'pending', 'due' => 9, 'description' => 'Project annual income and compute the advance tax installments.'],
            ['title' => 'Verify GST input credit on capital purchases', 'category' => 'GST', 'priority' => 'low', 'status' => 'hold', 'due' => 8, 'description' => 'On hold pending capital goods invoice details.'],
            ['title' => 'Review payroll and statutory compliance file', 'category' => 'Advisory', 'priority' => 'medium', 'status' => 'done', 'due' => -1, 'description' => 'Checked PF, ESI and professional tax entries for the month.'],
            ['title' => 'Prepare audit checklist for new client onboarding', 'category' => 'Audit', 'priority' => 'low', 'status' => 'pending', 'due' => 11, 'description' => 'Draft the standard information request list and audit checklist.'],
        ];

        foreach ($tasks as $data) {
            Task::updateOrCreate(
                ['title' => $data['title']],
                [
                    'user_id' => $admin?->id,
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'priority' => $data['priority'],
                    'status' => $data['status'],
                    'due_date' => Carbon::today()->addDays($data['due'])->toDateString(),
                    'completed_at' => $data['status'] === 'done' ? Carbon::today()->subDays(2) : null,
                    'is_active' => true,
                ]
            );
        }
    }
}
