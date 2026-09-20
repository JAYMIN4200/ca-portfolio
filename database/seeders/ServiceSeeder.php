<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Accounting & Bookkeeping',
                'short_description' => 'Professional accounting assistance including bookkeeping, financial statements, and bank reconciliation.',
                'description' => 'Complete accounting support for proprietorships, partnerships and private limited companies — from daily voucher entry and ledger scrutiny to finalisation of financial statements in line with Schedule III, bank reconciliation and preparation of audit-ready schedules.',
                'icon' => 'calculator',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Audit Assistance',
                'short_description' => 'Support in statutory, internal, and tax audit processes under professional supervision.',
                'description' => 'Assistance across statutory, internal and tax audits, including audit planning support, voucher testing and sampling, preparation of working papers, verification of transactions and co-ordination with client accounts teams through to finalisation of the audit report.',
                'icon' => 'clipboard-document-check',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'GST Support',
                'short_description' => 'GST registration, return preparation, and compliance assistance.',
                'description' => 'End-to-end GST assistance covering registration and amendments, monthly and annual return preparation (GSTR-1, GSTR-3B, GSTR-9), input tax credit reconciliation, and drafting replies to departmental notices.',
                'icon' => 'document-text',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Income Tax Assistance',
                'short_description' => 'Income tax return preparation, tax planning support, and compliance assistance.',
                'description' => 'Income tax return preparation and filing for individuals, firms and professionals, covering computation under all heads of income, capital gains, advance tax planning and support in responding to income tax notices.',
                'icon' => 'receipt-percent',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'TDS Compliance',
                'short_description' => 'TDS deduction, deposit, and return filing support.',
                'description' => 'Complete TDS support including deduction and applicability review, challan deposit, quarterly TDS return filing, Form 16/16A generation and reconciliation of TDS with Form 26AS and AIS.',
                'icon' => 'currency-rupee',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'MIS Reporting',
                'short_description' => 'Management Information System reports and financial data analysis.',
                'description' => 'Preparation of monthly and quarterly management information reports — receivables and payables ageing, inventory and profitability analysis, variance reporting and dashboards that support day-to-day business decisions.',
                'icon' => 'chart-bar',
                'display_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                $service
            );
        }
    }
}
