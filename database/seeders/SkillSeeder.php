<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $categories = SkillCategory::pluck('id', 'name');

        if ($categories->isEmpty()) {
            return;
        }

        $skills = [
            ['category' => 'Accounting', 'name' => 'Financial Statement Preparation', 'proficiency' => 90, 'icon' => 'chart-bar', 'display_order' => 1, 'description' => 'Preparation and finalisation of profit & loss accounts and balance sheets as per Schedule III.'],
            ['category' => 'Accounting', 'name' => 'Bookkeeping on Tally', 'proficiency' => 88, 'icon' => 'calculator', 'display_order' => 2, 'description' => 'Day-to-day voucher entry, ledgers, stock and inventory maintenance on Tally Prime.'],
            ['category' => 'Accounting', 'name' => 'Bank Reconciliation', 'proficiency' => 92, 'icon' => 'banknotes', 'display_order' => 3, 'description' => 'Reconciling bank statements with books and investigating outstanding differences.'],
            ['category' => 'Audit', 'name' => 'Statutory Audit', 'proficiency' => 85, 'icon' => 'clipboard-document-check', 'display_order' => 4, 'description' => 'Assisting in full statutory audit engagements including voucher testing and working papers.'],
            ['category' => 'Audit', 'name' => 'Internal Audit', 'proficiency' => 80, 'icon' => 'document-magnifying-glass', 'display_order' => 5, 'description' => 'Reviewing internal controls, SOP adherence and risk areas for mid-sized companies.'],
            ['category' => 'Audit', 'name' => 'Voucher Testing & Sampling', 'proficiency' => 90, 'icon' => 'document-check', 'display_order' => 6, 'description' => 'Statistically driven sample verification of vouchers for audit evidence.'],
            ['category' => 'Taxation', 'name' => 'Income Tax Return Filing', 'proficiency' => 87, 'icon' => 'document-text', 'display_order' => 7, 'description' => 'Preparation and filing of ITR-1, ITR-3, ITR-4 and handling tax computations.'],
            ['category' => 'Taxation', 'name' => 'GST Return Filing', 'proficiency' => 89, 'icon' => 'receipt-percent', 'display_order' => 8, 'description' => 'GSTR-1, GSTR-3B and GSTR-9 preparation, filing and ITC reconciliation.'],
            ['category' => 'Taxation', 'name' => 'TDS & Advance Tax', 'proficiency' => 84, 'icon' => 'currency-rupee', 'display_order' => 9, 'description' => 'TDS computation, challan deposit, return filing and advance tax planning.'],
            ['category' => 'Taxation', 'name' => 'Tax Advisory', 'proficiency' => 78, 'icon' => 'light-bulb', 'display_order' => 10, 'description' => 'Advising clients on restructuring, exemptions and tax-efficient planning.'],
            ['category' => 'Compliance', 'name' => 'ROC & Company Filings', 'proficiency' => 82, 'icon' => 'building-office', 'display_order' => 11, 'description' => 'MCA forms, annual returns, board resolutions and company statutory registers.'],
            ['category' => 'Compliance', 'name' => 'Payroll & Statutory Compliance', 'proficiency' => 83, 'icon' => 'shield-check', 'display_order' => 12, 'description' => 'Payroll processing, PF/ESI remittances and other monthly statutory deductions.'],
            ['category' => 'Software & Tools', 'name' => 'Tally Prime', 'proficiency' => 90, 'icon' => 'computer-desktop', 'display_order' => 13, 'description' => 'Advanced accounting and inventory configuration in Tally Prime.'],
            ['category' => 'Software & Tools', 'name' => 'MS Excel', 'proficiency' => 88, 'icon' => 'table-cells', 'display_order' => 14, 'description' => 'Pivot tables, advanced formulas, data analytics and MIS reporting.'],
            ['category' => 'Software & Tools', 'name' => 'GST & Income Tax Portals', 'proficiency' => 92, 'icon' => 'globe-alt', 'display_order' => 15, 'description' => 'Working knowledge of government filing portals and workflows.'],
            ['category' => 'Software & Tools', 'name' => 'Caseware & Audit Tools', 'proficiency' => 75, 'icon' => 'wrench-screwdriver', 'display_order' => 16, 'description' => 'Digital audit working paper software used in statutory audits.'],
        ];

        foreach ($skills as $data) {
            $categoryId = $categories->get($data['category']);
            if (! $categoryId) {
                continue;
            }

            Skill::updateOrCreate(
                ['name' => $data['name'], 'skill_category_id' => $categoryId],
                [
                    'proficiency' => $data['proficiency'],
                    'icon' => $data['icon'],
                    'display_order' => $data['display_order'],
                    'description' => $data['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
