<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            [
                'title' => 'Statutory Audit of a Manufacturing Company',
                'category' => 'Audit',
                'short_description' => 'Assisted in statutory audit of a mid-sized manufacturing firm, including voucher testing and finalisation of audit files.',
                'description' => "Performed a complete statutory audit engagement under the guidance of the engagement partner. Assisted in finalising audit documentation, verifying purchases and expense vouchers, and co-ordinating with the client's accounts team for schedule lead time.",
                'responsibilities' => ['Voucher testing and sampling', 'Preparation of audit working papers', 'Compliance check of Income Tax & GST provisions', 'Assisting in finalisation of audit report'],
                'tools_used' => ['MS Excel', 'Tally Prime', 'Caseware'],
                'external_url' => null,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'GST Registration & Filing for Retail Business',
                'category' => 'GST',
                'short_description' => 'Managed end-to-end GST registration and monthly returns for a retail client.',
                'description' => 'Handled GST registration for a newly started retail business and prepared and filed monthly GSTR-1 and GSTR-3B returns. Reconciled ITC on purchase registers and advised the client on input tax credit availability.',
                'responsibilities' => ['GST registration and migration', 'Monthly GSTR-1 & GSTR-3B preparation', 'ITC reconciliation and reversal', 'Handling GST notice queries'],
                'tools_used' => ['GST Portal', 'MS Excel', 'Tally Prime'],
                'external_url' => null,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Income Tax Return Finalisation for Professionals',
                'category' => 'Income Tax',
                'short_description' => 'Prepared income tax returns for chartered accountants and consultants with complex income streams.',
                'description' => 'Prepared ITR-3 returns for professional clients with receipts from partnership, capital gains and other sources. Computed advance tax liability and assisted the clients in salary restructuring to optimise tax outflows.',
                'responsibilities' => ['Computing income under all five heads', 'Capital gains computation and indexation', 'Advance tax computation', 'Responding to ITR notices'],
                'tools_used' => ['Income Tax e-filing portal', 'MS Excel', 'TaxSpanner'],
                'external_url' => null,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Bookkeeping & Monthly MIS for Trading Firm',
                'category' => 'Accounting',
                'short_description' => 'Maintained complete books of accounts and produced monthly management reports for a trading firm.',
                'description' => 'Managed day-to-day bookkeeping, bank reconciliation and petty cash for a trading company. Prepared monthly management information reports covering receivables aging, inventory position and profitability by product line.',
                'responsibilities' => ['Daily purchase & sales entry', 'Bank and vendor reconciliation', 'Monthly MIS and dashboard', 'Payroll and statutory compliances'],
                'tools_used' => ['Tally Prime', 'MS Excel', 'Zoho Books'],
                'external_url' => null,
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        $svgTemplates = [
            'Audit' => ['hue' => '2B3C5E', 'accent' => 'C9A84C', 'label' => 'Audit & Assurance'],
            'GST' => ['hue' => '1E3A5F', 'accent' => '7FB069', 'label' => 'GST Compliance'],
            'Income Tax' => ['hue' => '2E3A59', 'accent' => 'E8843C', 'label' => 'Income Tax'],
            'Accounting' => ['hue' => '234B4E', 'accent' => '4FB3BF', 'label' => 'Accounting'],
        ];

        foreach ($assignments as $data) {
            $assignment = Assignment::updateOrCreate(
                ['title' => $data['title']],
                $data
            );

            $template = $svgTemplates[$assignment->category] ?? ['hue' => '1F2937', 'accent' => 'C9A84C', 'label' => 'Professional Work'];
            $path = 'assignments/'.str()->slug($assignment->title).'.svg';

            Storage::disk('public')->put($path, $this->coverSvg($template));

            $assignment->update(['image_path' => $path]);
        }
    }

    protected function coverSvg(array $template): string
    {
        $hue = $template['hue'];
        $accent = $template['accent'];
        $label = htmlspecialchars($template['label'], ENT_QUOTES | ENT_XML1, 'UTF-8');

        return <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg" width="800" height="450" viewBox="0 0 800 450">
                <defs>
                    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#{$hue}"/>
                        <stop offset="100%" stop-color="#0F172A"/>
                    </linearGradient>
                </defs>
                <rect width="800" height="450" fill="url(#bg)"/>
                <circle cx="680" cy="60" r="160" fill="#{$accent}" opacity="0.12"/>
                <circle cx="90" cy="400" r="220" fill="#ffffff" opacity="0.04"/>
                <rect x="60" y="330" width="64" height="5" rx="2.5" fill="#{$accent}"/>
                <text x="60" y="308" font-family="Georgia, serif" font-size="34" font-weight="bold" fill="#ffffff">{$label}</text>
                <text x="60" y="368" font-family="Arial, sans-serif" font-size="14" fill="#{$accent}" letter-spacing="4">PROFESSIONAL ASSIGNMENT</text>
            </svg>
            SVG;
    }
}
