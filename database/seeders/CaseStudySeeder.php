<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        $caseStudies = [
            [
                'title' => 'GST Audit & Finalisation for a Textile Exporter',
                'slug' => 'gst-audit-finalisation-textile-exporter',
                'client_name' => 'Mehta Textiles Pvt. Ltd.',
                'category' => 'GST',
                'summary' => 'Reconciled ITC mismatches and finalised GSTR-9 and GSTR-9C for a textile exporter claiming large refunds.',
                'challenge' => "Mehta Textiles had accumulated ITC mismatches between GSTR-2B and purchase register, plus discrepancies flagged in their provisional GSTR-9C. With a central GST audit approaching, they needed a clean reconciliation and a defensible annual return before the deadline.",
                'solution' => "We rebuilt the ITC ledger from invoices, matched every purchase entry against GSTR-2B, and documented a reconciliation schedule for mismatch items still under dispute. GSTR-9 and GSTR-9C were finalised with supporting schedules, and the refund claim workbook was restructured to reduce repeat notices from the department.",
                'results' => "Zero-rejection annual return filing, a fully documented ITC reconciliation, and a refund claim restored to under scrutiny with no further query. The client now files monthly returns using the same reconciliation template.",
                'display_order' => 1,
            ],
            [
                'title' => 'Notice Response & Assessment Assistance for a Trader',
                'slug' => 'notice-response-assessment-trader',
                'client_name' => 'Shree Ram Trading Co.',
                'category' => 'Income Tax',
                'summary' => 'Assisted in responding to a Section 143(1) intimation and prepared a draft assessment reply for a wholesale trader.',
                'challenge' => "Shree Ram Trading received a 143(1) intimation for mismatch in turnover between GSTR-3B and the ITR, along with a proposal for an assessment proceeding. Missing consultation, they risked an adverse order and unnecessary tax demand.",
                'solution' => "We matched monthly GSTR-3B outward supplies with the ITR turnover, identified the variance source (credit note timing), and prepared a structured reply with reconciliation, workings, and supporting invoices. A draft response to the assessment notice was also prepared with the same underlying figures.",
                'results' => "The intimation mismatch was resolved without demand, and the client gained a clear response template for future notices. Reconciliation now happens every quarter instead of only at year-end.",
                'display_order' => 2,
            ],
            [
                'title' => 'Statutory Audit Working & Finalisation for a Manufacturer',
                'slug' => 'statutory-audit-working-manufacturer',
                'client_name' => 'Apex Engineering Works',
                'category' => 'Audit',
                'summary' => 'Supported a statutory audit engagement with voucher testing, working papers, and finalisation under partner guidance.',
                'challenge' => "Apex Engineering had a compressed year-end with unverified stock movement reports and a backlog of unrecorded purchase invoices. The audit team needed working papers finalised quickly without compromising documentation standards.",
                'solution' => "We performed cut-off testing around stock movements, vouched purchases and expense trails against bank statements, and built a complete set of working paper files covering every material balance. Findings were summarised in a review memorandum for the engagement partner.",
                'results' => "The audit file cleared internal review with minimal queries, and the finalisation timeline improved by nearly three weeks compared with the previous year.",
                'display_order' => 3,
            ],
            [
                'title' => 'Books Finalisation & MIS for a Retail Chain',
                'slug' => 'books-finalisation-mis-retail-chain',
                'client_name' => 'Sunrise Retail Pvt. Ltd.',
                'category' => 'Accounting',
                'summary' => 'Closed a full year of books of accounts and built monthly MIS dashboards for a five-store retail chain.',
                'challenge' => "Sunrise Retail ran five stores on separate ledgers that were never consolidated, so the owner had no single view of profitability. Year-end stock valuation was also incomplete across stores.",
                'solution' => "We consolidated all ledgers, reconciled inter-store transfers and bank accounts, and closed stock valuation using weighted-average costing. A monthly MIS pack was built covering store-wise margins, receivables aging, and a rolling cash-flow forecast.",
                'results' => "The client received a completed set of books, a clean stock ledger, and a repeatable monthly MIS report. Store-level margin visibility exposed two underperforming outlets that were restructured within the same quarter.",
                'display_order' => 4,
            ],
        ];

        $svgTemplates = [
            'GST' => ['hue' => '1E3A5F', 'accent' => '7C3AED', 'label' => 'GST Compliance'],
            'Income Tax' => ['hue' => '2E3A59', 'accent' => 'C9A84C', 'label' => 'Income Tax'],
            'Audit' => ['hue' => '2B3C5E', 'accent' => '8B5CF6', 'label' => 'Audit & Assurance'],
            'Accounting' => ['hue' => '234B4E', 'accent' => '4FB3BF', 'label' => 'Accounting'],
        ];

        $admin = \App\Models\User::query()->where('is_admin', true)->firstOrFail();

        foreach ($caseStudies as $index => $data) {
            $caseStudy = CaseStudy::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id' => $admin->id,
                    'slug' => $data['slug'],
                    'image_path' => 'case-studies/'.$data['slug'].'.svg',
                    'is_active' => true,
                    'published_at' => now()->subMonths(count($caseStudies) - $index),
                ])
            );

            $template = $svgTemplates[$caseStudy->category] ?? ['hue' => '1F2937', 'accent' => 'C9A84C', 'label' => 'Case Study'];
            Storage::disk('public')->put($caseStudy->image_path, $this->coverSvg($template));
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
                <text x="60" y="368" font-family="Arial, sans-serif" font-size="14" fill="#{$accent}" letter-spacing="4">CASE STUDY</text>
            </svg>
            SVG;
    }
}