-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2026 at 04:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfoliosca`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `responsibilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`responsibilities`)),
  `tools_used` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tools_used`)),
  `image_path` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `category`, `short_description`, `description`, `responsibilities`, `tools_used`, `image_path`, `external_url`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Statutory Audit of a Manufacturing Company', 'Audit', 'Assisted in statutory audit of a mid-sized manufacturing firm, including voucher testing and finalisation of audit files.', 'Performed a complete statutory audit engagement under the guidance of the engagement partner. Assisted in finalising audit documentation, verifying purchases and expense vouchers, and co-ordinating with the client\'s accounts team for schedule lead time.', '[\"Voucher testing and sampling\",\"Preparation of audit working papers\",\"Compliance check of Income Tax & GST provisions\",\"Assisting in finalisation of audit report\"]', '[\"MS Excel\",\"Tally Prime\",\"Caseware\"]', 'assignments/statutory-audit-of-a-manufacturing-company.svg', NULL, 1, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(2, 'GST Registration & Filing for Retail Business', 'GST', 'Managed end-to-end GST registration and monthly returns for a retail client.', 'Handled GST registration for a newly started retail business and prepared and filed monthly GSTR-1 and GSTR-3B returns. Reconciled ITC on purchase registers and advised the client on input tax credit availability.', '[\"GST registration and migration\",\"Monthly GSTR-1 & GSTR-3B preparation\",\"ITC reconciliation and reversal\",\"Handling GST notice queries\"]', '[\"GST Portal\",\"MS Excel\",\"Tally Prime\"]', 'assignments/gst-registration-filing-for-retail-business.svg', NULL, 2, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(3, 'Income Tax Return Finalisation for Professionals', 'Income Tax', 'Prepared income tax returns for chartered accountants and consultants with complex income streams.', 'Prepared ITR-3 returns for professional clients with receipts from partnership, capital gains and other sources. Computed advance tax liability and assisted the clients in salary restructuring to optimise tax outflows.', '[\"Computing income under all five heads\",\"Capital gains computation and indexation\",\"Advance tax computation\",\"Responding to ITR notices\"]', '[\"Income Tax e-filing portal\",\"MS Excel\",\"TaxSpanner\"]', 'assignments/income-tax-return-finalisation-for-professionals.svg', NULL, 3, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(4, 'Bookkeeping & Monthly MIS for Trading Firm', 'Accounting', 'Maintained complete books of accounts and produced monthly management reports for a trading firm.', 'Managed day-to-day bookkeeping, bank reconciliation and petty cash for a trading company. Prepared monthly management information reports covering receivables aging, inventory position and profitability by product line.', '[\"Daily purchase & sales entry\",\"Bank and vendor reconciliation\",\"Monthly MIS and dashboard\",\"Payroll and statutory compliances\"]', '[\"Tally Prime\",\"MS Excel\",\"Zoho Books\"]', 'assignments/bookkeeping-monthly-mis-for-trading-firm.svg', NULL, 4, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(5, 'TDS Compliance & Payroll Processing Support', 'TDS', 'Supported monthly TDS deductions, challan payments, and payroll compliance for a services company.', 'Assisted in end-to-end TDS compliance for a services firm, including deduction working, challan preparation, and quarterly return support. Also helped streamline payroll calculations and statutory deductions to ensure timely and accurate compliance.', '[\"Monthly TDS working and challan preparation\",\"Quarterly TDS return data compilation\",\"Payroll processing and deduction checks\",\"Employee tax computation support\"]', '[\"MS Excel\",\"Tally Prime\",\"TRACES Portal\"]', 'assignments/tds-compliance-payroll-processing-support.svg', NULL, 5, 1, '2026-11-26 12:46:08', '2026-11-26 12:46:08'),
(6, 'ROC Filing & Corporate Compliance Assistance', 'ROC / MCA', 'Assisted with ROC filings, annual compliance documentation, and MCA record maintenance for a private company.', 'Provided support for routine ROC and MCA compliance activities for a private limited company. Prepared working files for annual filings, maintained statutory records, and coordinated with stakeholders for timely submission of required forms and documents.', '[\"Preparation of annual ROC filing data\",\"Maintenance of statutory registers and records\",\"MCA form documentation support\",\"Coordination for compliance deadlines\"]', '[\"MCA Portal\",\"MS Excel\",\"MS Word\"]', 'assignments/roc-filing-corporate-compliance-assistance.svg', NULL, 6, 1, '2026-11-26 12:46:08', '2026-11-26 12:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `title`, `slug`, `excerpt`, `content`, `cover_image`, `category`, `tags`, `status`, `is_featured`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'GST Return Filing Calendar Every Business Should Follow', 'gst-return-filing-calendar-every-business-should-follow', 'A practical month-by-month checklist of GST returns so you never miss a due date or pay an avoidable late fee.', 'Filing GST returns on time is one of the simplest ways to keep your business out of trouble. Yet every year, thousands of businesses pay late fees and interest purely because a due date slipped past them.\n\nFor most regular dealers, the monthly cycle revolves around GSTR-1 and GSTR-3B. GSTR-1 captures your outward supplies and is generally due on the 11th of the following month. GSTR-3B is the summary return where tax is actually paid, and it follows on the 20th.\n\nThe key discipline is reconciliation. Before you file GSTR-3B, compare your input tax credit with GSTR-2B, because a mismatch today is a notice tomorrow. Keep a simple tracker: outward invoices on one sheet, purchase invoices on another, and reconcile both every month rather than at year end.\n\nQuarterly filers under the QRMP scheme have a slightly different rhythm, but the principle is identical. Decide the schedule once, automate reminders, and hand the reconciliation to a professional early. A little structure each month saves a great deal of stress, and money, at the end of the year.', 'blog/gst-return-filing-calendar-every-business-should-follow.svg', 'GST', '[\"GST\",\"Compliance\",\"Due Dates\"]', 'published', 0, 0, '2026-11-01 18:30:00', '2026-09-19 13:44:15', '2026-11-26 12:48:05'),
(2, 2, 'TDS or TCS: Choosing the Right Deduction for Your Business', 'tds-or-tcs-choosing-the-right-deduction-for-your-business', 'TDS and TCS look similar but apply in very different situations. Here is how to decide which one your transaction attracts.', 'New business owners often confuse Tax Deducted at Source (TDS) with Tax Collected at Source (TCS). The distinction matters because getting it wrong can mean interest, penalties and awkward conversations with vendors.\n\nTDS is deducted by the payer when making a specified payment, such as professional fees, rent or contractor charges. The payer withholds a portion of the payment and deposits it with the government, issuing the payee a TDS certificate.\n\nTCS works in the opposite direction. Here the seller collects tax from the buyer on specified sales, for example the sale of certain goods above a threshold or the sale of a motor vehicle above a prescribed value. The seller then deposits this collected tax.\n\nThe practical rule of thumb: ask who is responsible for depositing the tax. If it is the person making the payment, you are looking at TDS. If it is the person receiving the consideration, it is TCS. Always check the latest rate tables and thresholds, and document your reasoning for each transaction so an assessment is easy to answer.', 'blog/tds-or-tcs-choosing-the-right-deduction-for-your-business.svg', 'Taxation', '[\"TDS\",\"TCS\",\"Income Tax\"]', 'published', 0, 0, '2026-11-07 18:30:00', '2026-09-19 13:44:15', '2026-11-26 12:48:05'),
(3, 2, 'Reading a Balance Sheet: A Founder-Friendly Walkthrough', 'reading-a-balance-sheet-a-founder-friendly-walkthrough', 'Assets, liabilities and equity explained without jargon, and what each section quietly tells you about your business.', 'A balance sheet is a photograph of your business on a single date. It answers one question: what does the business own, what does it owe, and what is left for the owners?\n\nStart with assets. Current assets, such as cash, receivables and inventory, are the resources you will convert into cash within a year. Fixed assets, such as plant and equipment, support the business over the long term. If receivables are ballooning while sales are flat, collections, not sales, are your real problem.\n\nNext come liabilities. Current liabilities include payables, short-term loans and statutory dues. Watch statutory dues closely: unpaid GST or TDS is effectively an interest-bearing loan from the government.\n\nThe difference between assets and liabilities is equity, which reflects the owners\' stake plus retained profits. A healthy business grows equity through profits, not just through additional capital. Read the balance sheet alongside the profit and loss account every month; together they turn accounting data into decisions about pricing, credit and cash flow.', 'blog/reading-a-balance-sheet-a-founder-friendly-walkthrough.svg', 'Accounting', '[\"Accounting\",\"Financial Statements\",\"MIS\"]', 'published', 0, 0, '2026-11-13 18:30:00', '2026-09-19 13:44:15', '2026-11-26 12:48:05'),
(4, 2, 'Five Red Flags an Auditor Looks For First', 'five-red-flags-an-auditor-looks-for-first', 'From unexplained round numbers to consistent negative cash flow, these are the signals that draw an auditor’s attention.', 'Auditors are trained to notice patterns, and some patterns consistently signal risk. Knowing them in advance helps you tighten your books before the engagement begins.\n\nThe first red flag is unexplained round numbers. A string of transactions at exactly five thousand or exactly one lakh often points to estimates or plug figures rather than real supporting documentation.\n\nThe second is a mismatch between revenue and cash. Healthy growth usually brings cash with it. If sales are rising while operating cash flow is consistently negative, either credit terms are too loose or revenue recognition needs a second look.\n\nThe third is a concentration of related-party transactions with no clear commercial rationale. The fourth is a high volume of manual journal entries near period end, which is a classic route for adjustments that lack support.\n\nThe fifth is weak segregation of duties, where the same person records transactions, handles cash and reconciles the bank. Most of these issues are easy to fix once spotted, and fixing them before the audit is far cheaper than fixing them after.', 'blog/five-red-flags-an-auditor-looks-for-first.svg', 'Audit', '[\"Audit\",\"Internal Controls\",\"Risk\"]', 'published', 0, 0, '2026-11-18 18:30:00', '2026-09-19 13:44:16', '2026-11-26 12:48:05'),
(5, 2, 'Advance Tax: Planning Your Quarterly Payments', 'advance-tax-planning-your-quarterly-payments', 'Paying advance tax on time protects you from interest under sections 234B and 234C. Here is a simple planning approach.', 'Advance tax is income tax paid in installments during the year rather than as a lump sum at the end. If your total tax liability for a year is ten thousand rupees or more, you are generally required to pay it in advance.\n\nThe schedule is straightforward: fifteen percent by 15 June, forty-five percent by 15 September, seventy-five percent by 15 December, and one hundred percent by 15 March. Missing these installments attracts interest under section 234C, and shortfalls at the year end attract interest under section 234B.\n\nPlanning starts with a realistic estimate of annual income. Begin with last year\'s actuals, layer in expected growth or contraction, and account for any major one-time events such as the sale of an asset. Multiply by your applicable slab or rate to arrive at the estimated liability.\n\nRevisit the estimate each quarter. If the business is doing better than planned, increase the installment; if it is struggling, you can revise downward. Maintain a simple working sheet that shows estimated income, tax, and payments made. That single sheet is often the difference between a smooth year and an avoidable interest bill.', 'blog/advance-tax-planning-your-quarterly-payments.svg', 'Taxation', '[\"Income Tax\",\"Advance Tax\",\"Planning\"]', 'published', 0, 0, '2026-11-28 18:30:00', '2026-09-19 13:44:16', '2026-11-26 12:48:05'),
(6, 2, 'Bookkeeping Habits That Save Time at Year End', 'bookkeeping-habits-that-save-time-at-year-end', 'A few small monthly habits keep your books audit-ready and turn year-end finalisation into a routine instead of a scramble.', 'Year-end finalisation is only painful when the books have been neglected for eleven months. The businesses that close quickly are rarely doing anything clever; they simply maintain a few disciplined habits.\n\nFirst, reconcile the bank every month. An unreconciled bank account is the single most common cause of delay. If the statement matches your books within a day of month end, everything downstream becomes easier.\n\nSecond, record expenses as they happen, not from a shoebox in March. A simple photograph of each bill, filed weekly, removes the guesswork later.\n\nThird, review receivables and payables monthly and follow up on anything that is ageing. Fourth, keep statutory dues, GST, TDS and PF, in a dedicated tracker with separate ledgers so nothing is buried in a clubbed account.\n\nFinally, close each month with a short checklist: bank, cash, payables, receivables, inventory and statutory dues. Ten minutes of discipline each month means year-end becomes a review of finished books rather than a rescue operation.', 'blog/bookkeeping-habits-that-save-time-at-year-end.svg', 'Accounting', '[\"Bookkeeping\",\"Accounting\",\"Process\"]', 'published', 0, 0, '2026-12-04 18:30:00', '2026-09-19 13:44:16', '2026-11-26 12:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_studies`
--

CREATE TABLE `case_studies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `challenge` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `results` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_studies`
--

INSERT INTO `case_studies` (`id`, `user_id`, `title`, `slug`, `client_name`, `category`, `summary`, `challenge`, `solution`, `results`, `image_path`, `is_active`, `display_order`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'GST Audit & Finalisation for a Textile Exporter', 'gst-audit-finalisation-textile-exporter', 'Mehta Textiles Pvt. Ltd.', 'GST', 'Reconciled ITC mismatches and finalised GSTR-9 and GSTR-9C for a textile exporter claiming large refunds.', 'Mehta Textiles had accumulated ITC mismatches between GSTR-2B and purchase register, plus discrepancies flagged in their provisional GSTR-9C. With a central GST audit approaching, they needed a clean reconciliation and a defensible annual return before the deadline.', 'We rebuilt the ITC ledger from invoices, matched every purchase entry against GSTR-2B, and documented a reconciliation schedule for mismatch items still under dispute. GSTR-9 and GSTR-9C were finalised with supporting schedules, and the refund claim workbook was restructured to reduce repeat notices from the department.', 'Zero-rejection annual return filing, a fully documented ITC reconciliation, and a refund claim restored to under scrutiny with no further query. The client now files monthly returns using the same reconciliation template.', 'case-studies/gst-audit-finalisation-textile-exporter.svg', 1, 1, '2026-05-19', '2026-09-19 15:38:17', '2026-09-19 15:38:17'),
(2, 2, 'Notice Response & Assessment Assistance for a Trader', 'notice-response-assessment-trader', 'Shree Ram Trading Co.', 'Income Tax', 'Assisted in responding to a Section 143(1) intimation and prepared a draft assessment reply for a wholesale trader.', 'Shree Ram Trading received a 143(1) intimation for mismatch in turnover between GSTR-3B and the ITR, along with a proposal for an assessment proceeding. Missing consultation, they risked an adverse order and unnecessary tax demand.', 'We matched monthly GSTR-3B outward supplies with the ITR turnover, identified the variance source (credit note timing), and prepared a structured reply with reconciliation, workings, and supporting invoices. A draft response to the assessment notice was also prepared with the same underlying figures.', 'The intimation mismatch was resolved without demand, and the client gained a clear response template for future notices. Reconciliation now happens every quarter instead of only at year-end.', 'case-studies/notice-response-assessment-trader.svg', 1, 2, '2026-06-19', '2026-09-19 15:38:18', '2026-09-19 15:38:18'),
(3, 2, 'Statutory Audit Working & Finalisation for a Manufacturer', 'statutory-audit-working-manufacturer', 'Apex Engineering Works', 'Audit', 'Supported a statutory audit engagement with voucher testing, working papers, and finalisation under partner guidance.', 'Apex Engineering had a compressed year-end with unverified stock movement reports and a backlog of unrecorded purchase invoices. The audit team needed working papers finalised quickly without compromising documentation standards.', 'We performed cut-off testing around stock movements, vouched purchases and expense trails against bank statements, and built a complete set of working paper files covering every material balance. Findings were summarised in a review memorandum for the engagement partner.', 'The audit file cleared internal review with minimal queries, and the finalisation timeline improved by nearly three weeks compared with the previous year.', 'case-studies/statutory-audit-working-manufacturer.svg', 1, 3, '2026-07-19', '2026-09-19 15:38:18', '2026-09-19 15:38:18'),
(4, 2, 'Books Finalisation & MIS for a Retail Chain', 'books-finalisation-mis-retail-chain', 'Sunrise Retail Pvt. Ltd.', 'Accounting', 'Closed a full year of books of accounts and built monthly MIS dashboards for a five-store retail chain.', 'Sunrise Retail ran five stores on separate ledgers that were never consolidated, so the owner had no single view of profitability. Year-end stock valuation was also incomplete across stores.', 'We consolidated all ledgers, reconciled inter-store transfers and bank accounts, and closed stock valuation using weighted-average costing. A monthly MIS pack was built covering store-wise margins, receivables aging, and a rolling cash-flow forecast.', 'The client received a completed set of books, a clean stock ledger, and a repeatable monthly MIS report. Store-level margin visibility exposed two underperforming outlets that were restructured within the same quarter.', 'case-studies/books-finalisation-mis-retail-chain.svg', 1, 4, '2026-08-19', '2026-09-19 15:38:18', '2026-09-19 15:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_works`
--

CREATE TABLE `client_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Jaymin Panchal', 'jaymin.panchal@gmail.com', '+91 98250 12345', 'GST registration for new business', 'Hello, I am starting a wholesale trading business and would like to know the process and charges for GST registration and monthly return filing. Please share your availability for a call.', 1, '2026-09-19 13:44:16', '2026-10-11 06:39:32'),
(2, 'Chetan Patel', 'chetan.patel@gmail.com', '+91 99870 45678', 'Income tax return filing', 'I need help filing my ITR-3 for the last financial year. I have income from freelancing and some capital gains. Could you guide me on the documents required?', 1, '2026-09-19 13:44:16', '2026-09-19 17:45:08'),
(3, 'Nilesh Panchal', 'nilesh.panchal@gmail.com', '+91 97260 78901', 'Audit assistance enquiry', 'Our firm requires assistance with a statutory audit for a manufacturing unit during this quarter. We are based in Ahmedabad and prefer on-site support. Kindly share your schedule.', 0, '2026-09-19 13:44:16', '2026-10-11 06:39:04'),
(4, 'Naresh Panchal', 'naresh.panchal@gmail.com', '+91 98650 23456', 'Bookkeeping services', 'We are looking for monthly bookkeeping and MIS reporting services for our retail chain. Can you please share a quote and the engagement terms?', 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(5, 'Dhruv Suthar', 'dhruv@gmail.com', '+91 94080 56789', 'Helping with a GST notice', 'We received a notice regarding ITC mismatch in GSTR-1 and GSTR-3B for the last year. Could you review the notice and help us draft a response?', 0, '2026-09-19 13:44:16', '2026-09-19 13:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(60) NOT NULL,
  `custom_category` varchar(60) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `expense_date` date NOT NULL,
  `method` varchar(30) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `responsibilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`responsibilities`)),
  `skills_used` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills_used`)),
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `firm_name`, `role`, `location`, `start_date`, `end_date`, `is_current`, `description`, `responsibilities`, `skills_used`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 2, 'Chandabhoy & Jassoobhoy, Chartered Accountants', 'Audit & Tax Compliance Professional', 'Ahmedabad, Gujarat, India', '2026-10-01', NULL, 1, 'Working in accounting, audit, taxation and regulatory compliance, with practical exposure to financial reporting, statutory and internal audits, income tax, GST and ROC/MCA filings. Involved in financial statement preparation, ledger scrutiny, reconciliations and client compliance assignments.', '[]', '[]', 0, 1, '2026-10-10 16:06:22', '2026-10-10 16:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'What services do you offer?', 'I offer a wide range of accounting and compliance services including bookkeeping, statutory and internal audit assistance, GST registration and filing, income tax return preparation, TDS return filing and payroll support for small and medium businesses.', 'Services', 1, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(2, 'Are you a qualified Chartered Accountant?', 'I am a CA Finalist currently pursuing my Chartered Accountancy alongside my Articleship. I have cleared both CA Foundation and CA Intermediate, and I am gaining hands-on practical experience in audit, taxation and accounting.', 'General', 2, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(3, 'Which regions or clients do you serve?', 'I primarily serve clients across Gujarat, with most engagements based in Ahmedabad. However, most of my service lines — bookkeeping, ITR filing, GST returns — can be handled remotely for clients anywhere in India.', 'General', 3, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(4, 'How much do your services cost?', 'Pricing depends on the scope and volume of work. Bookkeeping and return filing are usually charged on a monthly or per-return basis, while audit assistance is quoted per engagement. Contact me and I will share a clear, customised quote.', 'Pricing', 4, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(5, 'Can you help with GST registration and monthly returns?', 'Yes. I manage end-to-end GST onboarding including registration, migration from composition scheme, monthly GSTR-1 and GSTR-3B preparation, ITC reconciliation and responding to notices from the GST department.', 'GST', 5, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(6, 'What documents do you need for income tax return filing?', 'Typically I need your PAN, Aadhaar, bank statements, Form 16 if employed, capital gains working if any, and details of other income or investments. I will share a checklist after understanding your income profile.', 'Income Tax', 6, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(7, 'Can you assist with audit work under an audit firm?', 'Yes. I regularly assist CA firms with statutory audit assignments, internal audit, vouching, preparation of audit working papers and co-ordination with client accounts teams to finalise audit files.', 'Audit', 7, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(8, 'How do I get started?', 'Simply use the contact form on this website or email me directly. Share a brief about your requirement, and I will respond within 24 hours with the next steps and a working plan.', 'Contact', 8, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `meeting_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'in_person',
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_replies`
--

CREATE TABLE `message_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_message_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_modify_users_add_is_admin', 1),
(5, '2024_01_01_000002_create_profiles_table', 1),
(6, '2024_01_01_000003_create_qualifications_table', 1),
(7, '2024_01_01_000004_create_skill_categories_table', 1),
(8, '2024_01_01_000005_create_skills_table', 1),
(9, '2024_01_01_000006_create_experiences_table', 1),
(10, '2024_01_01_000007_create_services_table', 1),
(11, '2024_01_01_000008_create_assignments_table', 1),
(12, '2024_01_01_000009_create_contact_messages_table', 1),
(13, '2024_01_01_000010_create_settings_table', 1),
(14, '2026_09_18_125840_add_social_handles_to_profiles_table', 1),
(15, '2026_09_18_125841_add_last_login_at_to_users_table', 1),
(16, '2026_09_18_134055_create_visits_table', 1),
(17, '2026_09_18_161312_create_faqs_table', 1),
(18, '2026_09_18_161313_create_terms_table', 1),
(19, '2026_09_18_161314_create_testimonials_table', 1),
(20, '2026_09_18_170001_create_clients_table', 1),
(21, '2026_09_18_170002_create_client_works_table', 1),
(22, '2026_09_18_170003_create_payments_table', 1),
(23, '2026_09_18_170004_create_case_studies_table', 1),
(24, '2026_09_18_170005_create_blog_posts_table', 1),
(25, '2026_09_18_170006_create_meetings_table', 1),
(26, '2026_09_18_170007_add_experience_stats_to_profiles_table', 1),
(27, '2026_09_18_180138_add_telegram_url_to_profiles_table', 1),
(28, '2026_09_18_180139_create_tasks_table', 1),
(29, '2026_09_19_000001_create_expenses_table', 1),
(30, '2026_09_19_092149_add_custom_category_to_expenses_table', 1),
(31, '2026_09_19_180500_convert_datetimes_to_asia_kolkata', 2),
(32, '2026_10_10_230000_remove_seo_from_profiles_table', 3),
(33, '2026_10_11_112418_create_message_replies_table', 3),
(34, '2026_11_27_095953_add_user_id_to_visits_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `client_work_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'received',
  `reference` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_title` varchar(255) DEFAULT NULL,
  `short_intro` text DEFAULT NULL,
  `about_me` longtext DEFAULT NULL,
  `years_of_experience` tinyint(3) UNSIGNED DEFAULT NULL,
  `clients_count` int(10) UNSIGNED DEFAULT NULL,
  `career_objective` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `linkedin_username` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `telegram_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `professional_title`, `short_intro`, `about_me`, `years_of_experience`, `clients_count`, `career_objective`, `profile_photo`, `resume_path`, `phone`, `location`, `linkedin_username`, `instagram_url`, `facebook_url`, `twitter_url`, `telegram_url`, `github_url`, `whatsapp_number`, `social_links`, `seo_title`, `seo_description`, `seo_keywords`, `og_image`, `created_at`, `updated_at`) VALUES
(1, 2, 'Accounting, Audit, Taxation and Compliance Professional', 'Accounting, audit, taxation and compliance professional with practical experience in financial reporting, statutory and internal audits, GST, income tax and ROC/MCA compliance. Focused on delivering accurate, reliable and business-oriented financial solutions to clients.', '<p>I am an accounting, audit, taxation and compliance professional with practical experience in financial reporting, audit procedures and statutory compliance. My work focuses on helping businesses maintain accurate financial records, meet regulatory requirements and make informed financial decisions.</p><p>My professional experience includes:</p><p>- Accounting &amp; Financial Reporting: Preparation and review of financial statements under applicable Accounting Standards and Ind AS, bookkeeping, ledger scrutiny and financial reconciliations.</p><p>- Audit &amp; Assurance: Assistance in statutory audits, internal audits, tax audits, vouching, verification and analytical review.</p><p>- Direct Taxation: Income tax return preparation and filing, tax computation, tax audit assistance and related compliance.</p><p>- GST Compliance: GST registration, GSTR-1 and GSTR-3B returns, ITC reconciliation and GST-related advisory.</p><p>- ROC/MCA Compliance: Assistance with company and LLP incorporation, annual filings, event-based forms and statutory documentation.</p><p>- Business &amp; Financial Services: Net worth and turnover documentation, TDS/TCS compliance, payroll-related compliance and accounting support.</p><p>I work with tools such as Tally Prime, Microsoft Excel and government compliance portals, with an emphasis on accuracy, confidentiality and timely execution.</p><p>My objective is to provide dependable, transparent and practical compliance solutions that help businesses operate efficiently and remain compliant with applicable laws.</p><p><br></p>', 4, 180, 'To deliver reliable accounting, audit, taxation and regulatory compliance services while building long-term client relationships through professional integrity, technical knowledge and timely execution.', 'profile/pWlbi3CP17bbwxu6ekENCqb7I8UnRI4878UcFZg9.jpg', NULL, '+91 9979024601', 'Naroda, Ahmedabad, Gujarat 382230, India', 'jinendra2002', 'https://www.instagram.com/jinendra_panchal_', NULL, NULL, NULL, NULL, '+919979024601', '[]', NULL, NULL, NULL, 'profile/sUR6DUJI9GWs7HUB6IbAALDXxCwYrtHyjVFLTb1q.jpg', '2026-09-19 13:44:08', '2026-11-26 13:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `status` enum('completed','pursuing','cleared') NOT NULL DEFAULT 'pursuing',
  `start_year` smallint(6) DEFAULT NULL,
  `end_year` smallint(6) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `user_id`, `name`, `institution`, `status`, `start_year`, `end_year`, `description`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'CA Intermediate', 'Institute of Chartered Accountants of India', 'cleared', 2020, 2021, 'Successfully cleared CA Intermediate examination.', 1, 0, '2026-09-19 13:44:09', '2026-10-11 04:23:26'),
(2, 2, 'CA Final', 'Institute of Chartered Accountants of India', 'pursuing', 2021, NULL, 'Currently pursuing CA Final examination.', 2, 0, '2026-09-19 13:44:09', '2026-10-05 17:10:35'),
(4, 2, 'LLB', 'Gujarat University', 'pursuing', 2026, NULL, 'Currently pursuing Bachelor of Laws.', 4, 0, '2026-09-19 13:44:09', '2026-10-05 17:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `short_description`, `description`, `icon`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Accounting & Bookkeeping', 'Accounting, bookkeeping, ledger scrutiny, bank reconciliation and preparation of financial statements.', 'Complete accounting support for proprietorships, partnerships and private limited companies — from daily voucher entry and ledger scrutiny to finalisation of financial statements in line with Schedule III, bank reconciliation and preparation of audit-ready schedules.', 'calculator', 1, 1, '2026-09-19 13:44:11', '2026-10-10 16:08:15'),
(2, 'Audit Assistance', 'Support in statutory, internal, and tax audit processes under professional supervision.', 'Assistance across statutory, internal and tax audits, including audit planning support, voucher testing and sampling, preparation of working papers, verification of transactions and co-ordination with client accounts teams through to finalisation of the audit report.', 'clipboard-document-check', 2, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(3, 'GST Support', 'GST registration, return preparation, and compliance assistance.', 'End-to-end GST assistance covering registration and amendments, monthly and annual return preparation (GSTR-1, GSTR-3B, GSTR-9), input tax credit reconciliation, and drafting replies to departmental notices.', 'document-text', 3, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(4, 'Income Tax Assistance', 'Income tax return preparation, tax planning support, and compliance assistance.', 'Income tax return preparation and filing for individuals, firms and professionals, covering computation under all heads of income, capital gains, advance tax planning and support in responding to income tax notices.', 'receipt-percent', 4, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(5, 'TDS Compliance', 'TDS deduction, deposit, and return filing support.', 'Complete TDS support including deduction and applicability review, challan deposit, quarterly TDS return filing, Form 16/16A generation and reconciliation of TDS with Form 26AS and AIS.', 'currency-rupee', 5, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(6, 'MIS Reporting', 'Management Information System reports and financial data analysis.', 'Preparation of monthly and quarterly management information reports — receivables and payables ageing, inventory and profitability analysis, variance reporting and dashboards that support day-to-day business decisions.', 'chart-bar', 6, 1, '2026-09-19 13:44:11', '2026-09-19 13:44:11'),
(7, 'ROC/MCA Compliance', 'Assistance with company and LLP annual filings, event-based MCA forms, statutory documentation and compliance tracking.', NULL, NULL, 0, 1, '2026-10-10 16:08:54', '2026-10-10 16:08:54'),
(8, 'Company & LLP Incorporation', 'Documentation and filing coordination for company incorporation, LLP registration and related compliance formalities.', NULL, NULL, 0, 1, '2026-10-10 16:09:28', '2026-10-10 16:09:28'),
(9, 'Financial Certificates & Documentation', 'Assistance with financial data compilation and supporting documentation for net worth, turnover and other financial requirements, subject to applicable certification rules.', NULL, NULL, 0, 1, '2026-10-10 16:10:13', '2026-10-10 16:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7mW6ub1n9TstVQQqrIVlbvHAxgTNpD1sWzV1Yh8q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI1MGgxdHhCRk93azdlandjeWlKMmY5SGpud3BYTTRZSUtzUlpPQ01UIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluIn19', 1795755003),
('zG5dqhwGFQD0zDnHsxUHHG42qtfERiBI5ndonGH0', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlN01wZ0V2Z00wTjJvY1R0dDIxMEJ4M1FqcndmejJ5b3l3T0l0bXFTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvc2V0dGluZ3MiLCJyb3V0ZSI6ImFkbWluLnNldHRpbmdzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsInByZXZpb3VzX2xvZ2luX2F0IjoiMjAyNi0xMS0yNlQxNjowOTo0OC4wMDAwMDBaIiwiYWRtaW5fbGFzdF9hY3RpdmUiOjE3OTU3NTQ3OTV9', 1795754795);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Jinendra Panchal', 'general', '2026-09-19 13:44:10', '2026-09-19 13:44:10'),
(2, 'site_title', 'JP FinEdge & Co.', 'general', '2026-09-19 13:44:10', '2026-11-17 06:43:20'),
(3, 'footer_text', 'Jinendra Panchal | Specializing in  Audit & Taxation and Accounting', 'general', '2026-09-19 13:44:10', '2026-11-17 06:43:20'),
(4, 'copyright', '© JP FinEdge & Co. All rights reserved.', 'general', '2026-09-19 13:44:10', '2026-11-27 04:24:37'),
(5, 'logo_text', 'JP FinEdge & Co.', 'general', '2026-09-19 13:44:10', '2026-11-26 12:23:28'),
(6, 'mission', 'To deliver reliable, transparent and value-driven financial solutions — accounting, audit, taxation and advisory — that let businesses grow with confidence and complete peace of mind.', 'about', '2026-09-19 13:44:10', '2026-09-19 13:44:10'),
(7, 'vision', 'To be a trusted financial partner that grows alongside our clients, blending professional expertise with honest, personalised service in accounting, audit and taxation.', 'about', '2026-09-19 13:44:10', '2026-09-19 13:44:10'),
(8, 'why_choose_us', 'Practical Expertise | Hands-on experience in accounting, taxation, audit assistance and regulatory compliance.\r\nTimely Delivery | Committed to meeting agreed timelines and completing assignments efficiently.\r\nComprehensive Services | Accounting, GST, income tax, TDS and ROC/MCA compliance support in one place.\r\nTransparent Pricing | Clear fee structures, upfront communication and a client-focused approach.', 'home', '2026-09-19 13:44:10', '2026-10-10 16:15:21'),
(9, 'contact_email', 'jinendra369.in@gmail.com', 'contact', '2026-09-19 13:44:10', '2026-11-26 16:21:31'),
(10, 'contact_phone', '+91 9979024601', 'contact', '2026-09-19 13:44:10', '2026-09-19 13:44:10'),
(11, 'contact_location', 'Naroda, Ahmedabad, Gujarat 382230, India', 'contact', '2026-09-19 13:44:10', '2026-09-19 13:44:10'),
(12, 'seo_title', 'JP FinEdge & Co. | Accounting, Audit & Taxation', 'seo', '2026-09-19 13:44:10', '2026-11-26 13:19:40'),
(13, 'seo_description', 'Jinendra Panchal,  Specializing in Accounting, Audit & Taxation. Explore my professional portfolio, skills, expertise, and career journey in the field of finance and accounting.', 'seo', '2026-09-19 13:44:10', '2026-11-17 06:54:06'),
(14, 'seo_keywords', 'Jinendra Panchal, Chartered Accountant, Accounting, Auditing, Taxation, GST, Income Tax, Financial Accounting, Tax Compliance, Audit Services, Ahmedabad, Gujarat, Indian Accounting Standards, Financial Reporting', 'seo', '2026-09-19 13:44:10', '2026-11-17 06:54:06'),
(15, 'site_favicon', 'favicon/9WbdgY7Xycvpnn6fyBSe7HeWBESKDjhnAcf18TCI.png', 'general', '2026-09-19 13:55:03', '2026-11-26 12:29:05'),
(17, 'hero_image', 'hero/VFHpDHTIqBuoVBnE8BlaVAQueTEugehzPn9EgTSW.png', 'home', '2026-09-19 15:03:36', '2026-11-27 04:46:32'),
(18, 'auto_logout_minutes', '30', 'security', '2026-10-11 05:15:02', '2026-10-11 06:38:19'),
(19, 'hero_badge_1_title', 'GST', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(20, 'hero_badge_1_label', 'Expert', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(21, 'hero_badge_1_enabled', '1', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(22, 'hero_badge_2_title', '₹', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(23, 'hero_badge_2_label', 'Tax Planning', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(24, 'hero_badge_2_enabled', '1', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(25, 'hero_badge_3_title', 'ITR', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(26, 'hero_badge_3_label', 'Income Tax', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(27, 'hero_badge_3_enabled', '1', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(28, 'hero_badge_4_title', 'Audit', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(29, 'hero_badge_4_label', 'Compliance', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(30, 'hero_badge_4_enabled', '1', 'home', '2026-11-26 12:22:45', '2026-11-26 12:22:45'),
(31, 'theme_toggle_enabled', '0', 'general', '2026-11-26 15:56:22', '2026-11-26 15:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skill_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `proficiency` tinyint(4) DEFAULT NULL COMMENT '0-100 percentage',
  `icon` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_category_id`, `name`, `description`, `proficiency`, `icon`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Financial Statement Preparation', 'Preparation and finalisation of profit & loss accounts and balance sheets as per Schedule III.', NULL, 'chart-bar', 1, 1, '2026-09-19 13:44:09', '2026-11-26 12:48:39'),
(2, 1, 'Bookkeeping on Tally', 'Day-to-day voucher entry, ledgers, stock and inventory maintenance on Tally Prime.', NULL, 'calculator', 2, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(3, 1, 'Bank Reconciliation', 'Reconciling bank statements with books and investigating outstanding differences.', NULL, 'banknotes', 3, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(4, 2, 'Statutory Audit', 'Assisting in full statutory audit engagements including voucher testing and working papers.', NULL, 'clipboard-document-check', 4, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(5, 2, 'Internal Audit', 'Reviewing internal controls, SOP adherence and risk areas for mid-sized companies.', NULL, 'document-magnifying-glass', 5, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(6, 2, 'Voucher Testing & Sampling', 'Statistically driven sample verification of vouchers for audit evidence.', NULL, 'document-check', 6, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(7, 3, 'Income Tax Return Filing', 'Preparation and filing of ITR-1, ITR-3, ITR-4 and handling tax computations.', NULL, 'document-text', 7, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(8, 3, 'GST Return Filing', 'GSTR-1, GSTR-3B and GSTR-9 preparation, filing and ITC reconciliation.', NULL, 'receipt-percent', 8, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(9, 3, 'TDS & Advance Tax', 'TDS computation, challan deposit, return filing and advance tax planning.', NULL, 'currency-rupee', 9, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(10, 3, 'Tax Advisory', 'Advising clients on restructuring, exemptions and tax-efficient planning.', NULL, 'light-bulb', 10, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(11, 4, 'ROC & Company Filings', 'MCA forms, annual returns, board resolutions and company statutory registers.', NULL, 'building-office', 11, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(12, 4, 'Payroll & Statutory Compliance', 'Payroll processing, PF/ESI remittances and other monthly statutory deductions.', NULL, 'shield-check', 12, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(13, 5, 'Tally Prime', 'Advanced accounting and inventory configuration in Tally Prime.', NULL, 'computer-desktop', 13, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(14, 5, 'MS Excel', 'Pivot tables, advanced formulas, data analytics and MIS reporting.', NULL, 'table-cells', 14, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(15, 5, 'GST & Income Tax Portals', 'Working knowledge of government filing portals and workflows.', NULL, 'globe-alt', 15, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(16, 5, 'Caseware & Audit Tools', 'Digital audit working paper software used in statutory audits.', NULL, 'wrench-screwdriver', 16, 1, '2026-09-19 13:44:10', '2026-11-26 12:48:39'),
(17, 6, 'Financial Planning & Analysis', 'Budgeting, forecasting, variance analysis and MIS reporting for business performance tracking.', NULL, 'chart-bar', 17, 1, '2026-11-26 16:25:59', '2026-11-26 16:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `skill_categories`
--

CREATE TABLE `skill_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skill_categories`
--

INSERT INTO `skill_categories` (`id`, `name`, `slug`, `icon`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Accounting', 'accounting', 'calculator', 1, 1, '2026-09-19 13:44:09', '2026-09-19 13:44:09'),
(2, 'Audit', 'audit', 'clipboard-document-check', 2, 1, '2026-09-19 13:44:09', '2026-09-19 13:44:09'),
(3, 'Taxation', 'taxation', 'receipt-percent', 3, 1, '2026-09-19 13:44:09', '2026-09-19 13:44:09'),
(4, 'Compliance', 'compliance', 'shield-check', 4, 1, '2026-09-19 13:44:09', '2026-09-19 13:44:09'),
(5, 'Software & Tools', 'software-tools', 'computer-desktop', 5, 1, '2026-09-19 13:44:09', '2026-09-19 13:44:09'),
(6, 'Financial Advisory', 'financial-advisory', 'light-bulb', 6, 1, '2026-11-26 12:53:21', '2026-11-26 12:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'medium',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `category`, `description`, `priority`, `status`, `due_date`, `completed_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Finalise audit working papers for ABC Manufacturing', 'Audit', 'Complete voucher testing, tie-up of ledgers and prepare the audit finalisation file before partner review.', 'high', 'in_progress', '2026-09-20', NULL, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(2, 2, 'File GSTR-3B for September for retail client', 'GST', 'Reconcile ITC as per GSTR-2B, compute output tax and file the return on the portal.', 'high', 'pending', '2026-09-21', NULL, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(3, 2, 'Prepare income tax computation for HNI client', 'Income Tax', 'Compute income under all heads, claim deductions and arrive at tax payable.', 'high', 'pending', '2026-09-19', NULL, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(4, 2, 'Monthly bank reconciliation for trading firm', 'Accounting', 'Match bank statement with books and list unreconciled entries.', 'medium', 'pending', '2026-09-22', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(5, 2, 'Update TDS challans and prepare quarterly summary', 'TDS', 'Waiting for challan details from the client before consolidation.', 'medium', 'hold', '2026-09-24', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(6, 2, 'Draft management MIS report for review', 'Advisory', 'Prepare receivables ageing, profitability by product line and cash flow snapshot.', 'medium', 'pending', '2026-09-23', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(7, 2, 'ROC annual filing — form AOC-4 preparation', 'ROC / MCA', 'Compile financial statements and board documents for AOC-4 filing.', 'high', 'pending', '2026-09-26', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(8, 2, 'Reconcile vendor ledgers for the quarter', 'Accounting', 'Match purchase register with vendor confirmations and flag differences.', 'low', 'pending', '2026-09-25', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(9, 2, 'Respond to GST notice for FY 2023-24', 'GST', 'Prepare the reconciliation annexure and draft a reply to the department.', 'high', 'done', '2026-09-17', '2026-09-19 15:07:08', 1, '2026-09-19 13:44:17', '2026-09-19 15:07:08'),
(10, 2, 'Complete bookkeeping entries for the month', 'Bookkeeping', 'Recorded all sales, purchase and journal entries with supporting vouchers.', 'medium', 'done', '2026-09-16', '2026-09-17 00:00:00', 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(11, 2, 'Share quarterly portfolio summary with mentor', 'Documentation', 'Compiled the articleship portfolio and shared the progress summary.', 'low', 'done', '2026-09-14', '2026-09-17 00:00:00', 1, '2026-09-19 13:44:17', '2026-09-19 17:50:50'),
(12, 2, 'Prepare advance tax estimate for Q3', 'Income Tax', 'Project annual income and compute the advance tax installments.', 'medium', 'pending', '2026-09-28', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(13, 2, 'Verify GST input credit on capital purchases', 'GST', 'On hold pending capital goods invoice details.', 'low', 'hold', '2026-09-27', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(14, 2, 'Review payroll and statutory compliance file', 'Advisory', 'Checked PF, ESI and professional tax entries for the month.', 'medium', 'done', '2026-09-18', '2026-09-17 00:00:00', 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17'),
(15, 2, 'Prepare audit checklist for new client onboarding', 'Audit', 'Draft the standard information request list and audit checklist.', 'low', 'pending', '2026-09-30', NULL, 1, '2026-09-19 13:44:17', '2026-09-19 13:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `title`, `slug`, `content`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Introduction', 'introduction', 'Welcome to the portfolio website of Jinendra Panchal, a CA Finalist specialising in accounting, audit and taxation. By accessing or using this website, you agree to be bound by the terms and conditions set out below. If you do not agree with any part of these terms, please do not use this website.', 1, 1, '2026-09-19 13:44:16', '2026-09-25 17:11:35'),
(2, 'Use of Website', 'use-of-website', 'The content on this website is provided for general information about the professional experience and services of Jinendra Panchal. You may browse the website for personal, non-commercial purposes. You may not reproduce, distribute or use any content without prior written permission.', 2, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(3, 'Professional Disclaimer', 'professional-disclaimer', 'The information presented on this website does not constitute professional advice and must not be relied upon as such. The website owner is a CA Finalist in practice training. Always consult a qualified professional before making financial, tax or legal decisions.', 3, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(4, 'Intellectual Property', 'intellectual-property', 'All text, images, logos and other material on this website are the property of the website owner unless stated otherwise. Unauthorised use, copying or redistribution of this material is prohibited.', 4, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(5, 'Third-Party Links', 'third-party-links', 'This website may contain links to third-party websites such as LinkedIn. These links are provided for convenience only and do not imply endorsement. The website owner is not responsible for the content or practices of external websites.', 5, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(6, 'Limitation of Liability', 'limitation-of-liability', 'The website owner will not be liable for any direct, indirect, incidental or consequential losses arising from the use of, or inability to use, this website or from reliance on the information provided herein.', 6, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(7, 'Changes to These Terms', 'changes-to-these-terms', 'These terms and conditions may be updated from time to time. Any changes will be posted on this page, and continued use of the website after such changes constitutes acceptance of the revised terms.', 7, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16'),
(8, 'Contact', 'contact', 'If you have any questions about these terms, you may reach out through the contact form on this website or by email at jinendrapanchal2002@gmail.com.', 8, 1, '2026-09-19 13:44:16', '2026-09-19 13:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `company`, `message`, `rating`, `photo`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Jaymin Panchal', 'Proprietor', 'Shiv Traders', 'Jinendra has been managing our books of accounts and monthly GST returns for over a year now. He is prompt, accurate and always explains things clearly. Our compliance worries are completely gone.', 5, NULL, 1, 1, '2026-09-19 13:44:16', '2026-10-11 06:47:59'),
(2, 'Aditi Mishra', 'Chartered Accountant', 'Mishra& Associates', 'Jinendra assisted our firm on statutory audit engagements with a genuinely professional approach. His voucher testing and working paper preparation were meticulous, and he thrived under deadline pressure.', 5, NULL, 2, 1, '2026-09-19 13:44:16', '2026-10-11 06:48:19'),
(3, 'Prachi Patel', 'Director', 'Patel Consultants Pvt Ltd', 'He handled a complex income tax scrutiny response for our company with confidence and great documentation. Proactive communication made the whole process stress-free for our team.', 4, NULL, 3, 1, '2026-09-19 13:44:16', '2026-10-11 06:48:41'),
(4, 'Vaishali Panchal', 'Owner', 'Crux Textiles', 'From GST registration to monthly returns, everything was handled smoothly. He even recovered eligible input credit we had been missing. Highly recommended for any new business.', 5, NULL, 4, 1, '2026-09-19 13:44:16', '2026-10-11 06:49:10'),
(5, 'Tushar Patel', 'Partner', 'Patel & Co.', 'A dependable, detail-oriented professional. Jinendra\'s monthly MIS helped our trading firm finally get clear visibility into profitability by product line. Great analytical skills.', 3, NULL, 5, 1, '2026-09-19 13:44:16', '2026-10-11 06:49:51'),
(6, 'Punit Mevada', 'Business Owner', 'Mevada Enterprises', 'Working with Jinendra has been a smooth and reliable experience. His clarity in accounting and taxation matters, along with timely support, makes him a trusted professional to work with.', 5, NULL, 6, 1, '2026-11-26 12:55:35', '2026-11-26 12:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `last_login_at`, `created_at`, `updated_at`) VALUES
(2, 'Jinendra Panchal', 'jinendra369.in@gmail.com', NULL, '$2y$12$ZpVjoABH4KpzUhe4irjQq.ranN35YFXtUBVkeCrfoqH2aEJUYOYj6', 1, '6se2vjzxA724PKvcpdBbCUWEOZfBx1zJUJI8eIf9j3WhyeNF6xqVLxBgps9T', '2026-11-27 03:54:21', '2026-09-19 13:44:08', '2026-11-27 03:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `ip_address`, `user_agent`, `url`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:27:13', '2026-11-27 04:27:13', NULL),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/experience', '2026-11-27 04:27:23', '2026-11-27 04:27:23', NULL),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:27:25', '2026-11-27 04:27:25', NULL),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/about', '2026-11-27 04:30:55', '2026-11-27 04:30:55', NULL),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:30:57', '2026-11-27 04:30:57', 2),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:39:14', '2026-11-27 04:39:14', NULL),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:40:09', '2026-11-27 04:40:09', NULL),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:40:24', '2026-11-27 04:40:24', NULL),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:41:07', '2026-11-27 04:41:07', NULL),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:46:38', '2026-11-27 04:46:38', NULL),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:46:57', '2026-11-27 04:46:57', NULL),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:48:26', '2026-11-27 04:48:26', NULL),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', '2026-11-27 04:50:03', '2026-11-27 04:50:03', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `case_studies`
--
ALTER TABLE `case_studies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `case_studies_slug_unique` (`slug`),
  ADD KEY `case_studies_user_id_foreign` (`user_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Indexes for table `client_works`
--
ALTER TABLE `client_works`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_works_client_id_foreign` (`client_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_client_id_foreign` (`client_id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiences_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_user_id_foreign` (`user_id`),
  ADD KEY `meetings_client_id_foreign` (`client_id`);

--
-- Indexes for table `message_replies`
--
ALTER TABLE `message_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_replies_contact_message_id_foreign` (`contact_message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_client_id_foreign` (`client_id`),
  ADD KEY `payments_client_work_id_foreign` (`client_work_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skills_skill_category_id_foreign` (`skill_category_id`);

--
-- Indexes for table `skill_categories`
--
ALTER TABLE `skill_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skill_categories_slug_unique` (`slug`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`),
  ADD KEY `tasks_status_due_date_index` (`status`,`due_date`),
  ADD KEY `tasks_priority_index` (`priority`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terms_slug_unique` (`slug`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_ip_address_index` (`ip_address`),
  ADD KEY `visits_created_at_index` (`created_at`),
  ADD KEY `visits_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `case_studies`
--
ALTER TABLE `case_studies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client_works`
--
ALTER TABLE `client_works`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message_replies`
--
ALTER TABLE `message_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `skill_categories`
--
ALTER TABLE `skill_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `case_studies`
--
ALTER TABLE `case_studies`
  ADD CONSTRAINT `case_studies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `client_works`
--
ALTER TABLE `client_works`
  ADD CONSTRAINT `client_works_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meetings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `message_replies`
--
ALTER TABLE `message_replies`
  ADD CONSTRAINT `message_replies_contact_message_id_foreign` FOREIGN KEY (`contact_message_id`) REFERENCES `contact_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_client_work_id_foreign` FOREIGN KEY (`client_work_id`) REFERENCES `client_works` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_skill_category_id_foreign` FOREIGN KEY (`skill_category_id`) REFERENCES `skill_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
