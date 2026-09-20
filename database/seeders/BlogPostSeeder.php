<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $posts = [
            [
                'title' => 'GST Return Filing Calendar Every Business Should Follow',
                'category' => 'GST',
                'excerpt' => 'A practical month-by-month checklist of GST returns so you never miss a due date or pay an avoidable late fee.',
                'tags' => ['GST', 'Compliance', 'Due Dates'],
                'days' => -24,
                'content' => "Filing GST returns on time is one of the simplest ways to keep your business out of trouble. Yet every year, thousands of businesses pay late fees and interest purely because a due date slipped past them.\n\nFor most regular dealers, the monthly cycle revolves around GSTR-1 and GSTR-3B. GSTR-1 captures your outward supplies and is generally due on the 11th of the following month. GSTR-3B is the summary return where tax is actually paid, and it follows on the 20th.\n\nThe key discipline is reconciliation. Before you file GSTR-3B, compare your input tax credit with GSTR-2B, because a mismatch today is a notice tomorrow. Keep a simple tracker: outward invoices on one sheet, purchase invoices on another, and reconcile both every month rather than at year end.\n\nQuarterly filers under the QRMP scheme have a slightly different rhythm, but the principle is identical. Decide the schedule once, automate reminders, and hand the reconciliation to a professional early. A little structure each month saves a great deal of stress, and money, at the end of the year.",
            ],
            [
                'title' => 'TDS or TCS: Choosing the Right Deduction for Your Business',
                'category' => 'Taxation',
                'excerpt' => 'TDS and TCS look similar but apply in very different situations. Here is how to decide which one your transaction attracts.',
                'tags' => ['TDS', 'TCS', 'Income Tax'],
                'days' => -18,
                'content' => "New business owners often confuse Tax Deducted at Source (TDS) with Tax Collected at Source (TCS). The distinction matters because getting it wrong can mean interest, penalties and awkward conversations with vendors.\n\nTDS is deducted by the payer when making a specified payment, such as professional fees, rent or contractor charges. The payer withholds a portion of the payment and deposits it with the government, issuing the payee a TDS certificate.\n\nTCS works in the opposite direction. Here the seller collects tax from the buyer on specified sales, for example the sale of certain goods above a threshold or the sale of a motor vehicle above a prescribed value. The seller then deposits this collected tax.\n\nThe practical rule of thumb: ask who is responsible for depositing the tax. If it is the person making the payment, you are looking at TDS. If it is the person receiving the consideration, it is TCS. Always check the latest rate tables and thresholds, and document your reasoning for each transaction so an assessment is easy to answer.",
            ],
            [
                'title' => 'Reading a Balance Sheet: A Founder-Friendly Walkthrough',
                'category' => 'Accounting',
                'excerpt' => 'Assets, liabilities and equity explained without jargon, and what each section quietly tells you about your business.',
                'tags' => ['Accounting', 'Financial Statements', 'MIS'],
                'days' => -12,
                'content' => "A balance sheet is a photograph of your business on a single date. It answers one question: what does the business own, what does it owe, and what is left for the owners?\n\nStart with assets. Current assets, such as cash, receivables and inventory, are the resources you will convert into cash within a year. Fixed assets, such as plant and equipment, support the business over the long term. If receivables are ballooning while sales are flat, collections, not sales, are your real problem.\n\nNext come liabilities. Current liabilities include payables, short-term loans and statutory dues. Watch statutory dues closely: unpaid GST or TDS is effectively an interest-bearing loan from the government.\n\nThe difference between assets and liabilities is equity, which reflects the owners' stake plus retained profits. A healthy business grows equity through profits, not just through additional capital. Read the balance sheet alongside the profit and loss account every month; together they turn accounting data into decisions about pricing, credit and cash flow.",
            ],
            [
                'title' => 'Five Red Flags an Auditor Looks For First',
                'category' => 'Audit',
                'excerpt' => 'From unexplained round numbers to consistent negative cash flow, these are the signals that draw an auditor\u2019s attention.',
                'tags' => ['Audit', 'Internal Controls', 'Risk'],
                'days' => -7,
                'content' => "Auditors are trained to notice patterns, and some patterns consistently signal risk. Knowing them in advance helps you tighten your books before the engagement begins.\n\nThe first red flag is unexplained round numbers. A string of transactions at exactly five thousand or exactly one lakh often points to estimates or plug figures rather than real supporting documentation.\n\nThe second is a mismatch between revenue and cash. Healthy growth usually brings cash with it. If sales are rising while operating cash flow is consistently negative, either credit terms are too loose or revenue recognition needs a second look.\n\nThe third is a concentration of related-party transactions with no clear commercial rationale. The fourth is a high volume of manual journal entries near period end, which is a classic route for adjustments that lack support.\n\nThe fifth is weak segregation of duties, where the same person records transactions, handles cash and reconciles the bank. Most of these issues are easy to fix once spotted, and fixing them before the audit is far cheaper than fixing them after.",
            ],
            [
                'title' => 'Advance Tax: Planning Your Quarterly Payments',
                'category' => 'Taxation',
                'excerpt' => 'Paying advance tax on time protects you from interest under sections 234B and 234C. Here is a simple planning approach.',
                'tags' => ['Income Tax', 'Advance Tax', 'Planning'],
                'days' => 3,
                'content' => "Advance tax is income tax paid in installments during the year rather than as a lump sum at the end. If your total tax liability for a year is ten thousand rupees or more, you are generally required to pay it in advance.\n\nThe schedule is straightforward: fifteen percent by 15 June, forty-five percent by 15 September, seventy-five percent by 15 December, and one hundred percent by 15 March. Missing these installments attracts interest under section 234C, and shortfalls at the year end attract interest under section 234B.\n\nPlanning starts with a realistic estimate of annual income. Begin with last year's actuals, layer in expected growth or contraction, and account for any major one-time events such as the sale of an asset. Multiply by your applicable slab or rate to arrive at the estimated liability.\n\nRevisit the estimate each quarter. If the business is doing better than planned, increase the installment; if it is struggling, you can revise downward. Maintain a simple working sheet that shows estimated income, tax, and payments made. That single sheet is often the difference between a smooth year and an avoidable interest bill.",
            ],
            [
                'title' => 'Bookkeeping Habits That Save Time at Year End',
                'category' => 'Accounting',
                'excerpt' => 'A few small monthly habits keep your books audit-ready and turn year-end finalisation into a routine instead of a scramble.',
                'tags' => ['Bookkeeping', 'Accounting', 'Process'],
                'days' => 9,
                'content' => "Year-end finalisation is only painful when the books have been neglected for eleven months. The businesses that close quickly are rarely doing anything clever; they simply maintain a few disciplined habits.\n\nFirst, reconcile the bank every month. An unreconciled bank account is the single most common cause of delay. If the statement matches your books within a day of month end, everything downstream becomes easier.\n\nSecond, record expenses as they happen, not from a shoebox in March. A simple photograph of each bill, filed weekly, removes the guesswork later.\n\nThird, review receivables and payables monthly and follow up on anything that is ageing. Fourth, keep statutory dues, GST, TDS and PF, in a dedicated tracker with separate ledgers so nothing is buried in a clubbed account.\n\nFinally, close each month with a short checklist: bank, cash, payables, receivables, inventory and statutory dues. Ten minutes of discipline each month means year-end becomes a review of finished books rather than a rescue operation.",
            ],
        ];

        foreach ($posts as $data) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'user_id' => $admin?->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'cover_image' => null,
                    'category' => $data['category'],
                    'tags' => $data['tags'],
                    'status' => BlogPost::STATUS_PUBLISHED,
                    'is_featured' => false,
                    'views' => 0,
                    'published_at' => Carbon::today()->addDays($data['days']),
                ]
            );
        }
    }
}
