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
            ['category' => 'Accounting', 'name' => 'Financial Statement Preparation', 'proficiency' => null, 'icon' => 'chart-bar', 'display_order' => 1, 'description' => 'Preparation and finalisation of profit & loss accounts and balance sheets as per Schedule III.'],
            ['category' => 'Accounting', 'name' => 'Bookkeeping on Tally', 'proficiency' => null, 'icon' => 'calculator', 'display_order' => 2, 'description' => 'Day-to-day voucher entry, ledgers, stock and inventory maintenance on Tally Prime.'],
            ['category' => 'Accounting', 'name' => 'Bank Reconciliation', 'proficiency' => null, 'icon' => 'banknotes', 'display_order' => 3, 'description' => 'Reconciling bank statements with books and investigating outstanding differences.'],
            ['category' => 'Audit', 'name' => 'Statutory Audit', 'proficiency' => null, 'icon' => 'clipboard-document-check', 'display_order' => 4, 'description' => 'Assisting in full statutory audit engagements including voucher testing and working papers.'],
            ['category' => 'Audit', 'name' => 'Internal Audit', 'proficiency' => null, 'icon' => 'document-magnifying-glass', 'display_order' => 5, 'description' => 'Reviewing internal controls, SOP adherence and risk areas for mid-sized companies.'],
            ['category' => 'Audit', 'name' => 'Voucher Testing & Sampling', 'proficiency' => null, 'icon' => 'document-check', 'display_order' => 6, 'description' => 'Statistically driven sample verification of vouchers for audit evidence.'],
            ['category' => 'Taxation', 'name' => 'Income Tax Return Filing', 'proficiency' => null, 'icon' => 'document-text', 'display_order' => 7, 'description' => 'Preparation and filing of ITR-1, ITR-3, ITR-4 and handling tax computations.'],
            ['category' => 'Taxation', 'name' => 'GST Return Filing', 'proficiency' => null, 'icon' => 'receipt-percent', 'display_order' => 8, 'description' => 'GSTR-1, GSTR-3B and GSTR-9 preparation, filing and ITC reconciliation.'],
            ['category' => 'Taxation', 'name' => 'TDS & Advance Tax', 'proficiency' => null, 'icon' => 'currency-rupee', 'display_order' => 9, 'description' => 'TDS computation, challan deposit, return filing and advance tax planning.'],
            ['category' => 'Taxation', 'name' => 'Tax Advisory', 'proficiency' => null, 'icon' => 'light-bulb', 'display_order' => 10, 'description' => 'Advising clients on restructuring, exemptions and tax-efficient planning.'],
            ['category' => 'Compliance', 'name' => 'ROC & Company Filings', 'proficiency' => null, 'icon' => 'building-office', 'display_order' => 11, 'description' => 'MCA forms, annual returns, board resolutions and company statutory registers.'],
            ['category' => 'Compliance', 'name' => 'Payroll & Statutory Compliance', 'proficiency' => null, 'icon' => 'shield-check', 'display_order' => 12, 'description' => 'Payroll processing, PF/ESI remittances and other monthly statutory deductions.'],
            ['category' => 'Software & Tools', 'name' => 'Tally Prime', 'proficiency' => null, 'icon' => 'computer-desktop', 'display_order' => 13, 'description' => 'Advanced accounting and inventory configuration in Tally Prime.'],
            ['category' => 'Software & Tools', 'name' => 'MS Excel', 'proficiency' => null, 'icon' => 'table-cells', 'display_order' => 14, 'description' => 'Pivot tables, advanced formulas, data analytics and MIS reporting.'],
            ['category' => 'Software & Tools', 'name' => 'GST & Income Tax Portals', 'proficiency' => null, 'icon' => 'globe-alt', 'display_order' => 15, 'description' => 'Working knowledge of government filing portals and workflows.'],
            ['category' => 'Software & Tools', 'name' => 'Caseware & Audit Tools', 'proficiency' => null, 'icon' => 'wrench-screwdriver', 'display_order' => 16, 'description' => 'Digital audit working paper software used in statutory audits.'],
            ['category' => 'Financial Advisory', 'name' => 'Financial Planning & Analysis', 'proficiency' => null, 'icon' => 'chart-bar', 'display_order' => 17, 'description' => 'Budgeting, forecasting, variance analysis and MIS reporting for business performance tracking.'],
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
