<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What services do you offer?',
                'answer' => 'I offer a wide range of accounting and compliance services including bookkeeping, statutory and internal audit assistance, GST registration and filing, income tax return preparation, TDS return filing and payroll support for small and medium businesses.',
                'category' => 'Services',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Are you a qualified Chartered Accountant?',
                'answer' => 'I am a CA Finalist currently pursuing my Chartered Accountancy alongside my Articleship. I have cleared both CA Foundation and CA Intermediate, and I am gaining hands-on practical experience in audit, taxation and accounting.',
                'category' => 'General',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Which regions or clients do you serve?',
                'answer' => 'I primarily serve clients across Gujarat, with most engagements based in Ahmedabad. However, most of my service lines — bookkeeping, ITR filing, GST returns — can be handled remotely for clients anywhere in India.',
                'category' => 'General',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'How much do your services cost?',
                'answer' => 'Pricing depends on the scope and volume of work. Bookkeeping and return filing are usually charged on a monthly or per-return basis, while audit assistance is quoted per engagement. Contact me and I will share a clear, customised quote.',
                'category' => 'Pricing',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Can you help with GST registration and monthly returns?',
                'answer' => 'Yes. I manage end-to-end GST onboarding including registration, migration from composition scheme, monthly GSTR-1 and GSTR-3B preparation, ITC reconciliation and responding to notices from the GST department.',
                'category' => 'GST',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'What documents do you need for income tax return filing?',
                'answer' => 'Typically I need your PAN, Aadhaar, bank statements, Form 16 if employed, capital gains working if any, and details of other income or investments. I will share a checklist after understanding your income profile.',
                'category' => 'Income Tax',
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Can you assist with audit work under an audit firm?',
                'answer' => 'Yes. I regularly assist CA firms with statutory audit assignments, internal audit, vouching, preparation of audit working papers and co-ordination with client accounts teams to finalise audit files.',
                'category' => 'Audit',
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'How do I get started?',
                'answer' => 'Simply use the contact form on this website or email me directly. Share a brief about your requirement, and I will respond within 24 hours with the next steps and a working plan.',
                'category' => 'Contact',
                'display_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $data) {
            Faq::updateOrCreate(
                ['question' => $data['question']],
                $data
            );
        }
    }
}
