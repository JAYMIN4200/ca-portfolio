<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('is_admin', true)->first() ?? User::first();

        if (! $user) {
            return;
        }

        $experiences = [
            [
                'role' => 'CA Articles Assistant',
                'firm_name' => 'M/s J. D. & Associates, Chartered Accountants',
                'location' => 'Ahmedabad, Gujarat',
                'start_date' => '2023-06-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Currently pursuing CA Final articleship with hands-on exposure to audits, taxation and accounting assignments across a diversified client base.',
                'responsibilities' => [
                    'Assisting in statutory and internal audits',
                    'Preparation of financial statements and schedules',
                    'GST and Income Tax return filing and reconciliation',
                    'Computation of advance tax and TDS compliances',
                ],
                'skills_used' => ['Tally Prime', 'MS Excel', 'GST Portal', 'Income Tax Portal'],
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'role' => 'Article Trainee (Audit & Assurance)',
                'firm_name' => 'M/s K. R. & Co., Chartered Accountants',
                'location' => 'Naroda, Ahmedabad',
                'start_date' => '2022-07-01',
                'end_date' => '2023-05-31',
                'is_current' => false,
                'description' => 'Gained foundational training in audit techniques, documentation and basic accounting during the early years of articleship.',
                'responsibilities' => [
                    'Voucher checking and audit trail documentation',
                    'Bank reconciliation and client co-ordination',
                    'Maintaining books of accounts on Tally',
                ],
                'skills_used' => ['Tally ERP 9', 'MS Excel'],
                'display_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($experiences as $data) {
            Experience::updateOrCreate(
                ['role' => $data['role'], 'firm_name' => $data['firm_name']],
                [...$data, 'user_id' => $user->id]
            );
        }
    }
}
