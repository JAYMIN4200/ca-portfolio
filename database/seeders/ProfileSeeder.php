<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'jinendrapanchal2002@gmail.com')->first();

        if (! $admin) {
            return;
        }

        $admin->profile()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'professional_title' => 'CA Finalist | Accounting, Audit & Taxation Professional',
                'short_intro' => 'Aspiring Chartered Accountant with a strong foundation in accounting, audit, and taxation. Currently pursuing CA Final while gaining practical experience through Articleship.',
                'about_me' => "CA Finalist with a strong foundation in financial accounting, audit and taxation, currently pursuing the CA Final examination while completing my Articleship. I enjoy translating complex financial information into clear, decision-ready insight for businesses.\n\nMy Articleship has given me hands-on exposure to statutory and internal audits, GST and income tax compliance, and day-to-day bookkeeping for a diversified client base. I work extensively on Tally Prime, MS Excel and the government tax portals, and I am comfortable managing deadlines across multiple engagements.\n\nI am now looking to build on this foundation and grow into a well-rounded Chartered Accountant.",
                'career_objective' => 'To qualify as a Chartered Accountant and build expertise in audit, taxation and financial advisory, delivering accurate, compliant and value-adding solutions to the organisations and clients I serve.',
                'phone' => '+91 9979024601',
                'location' => 'Naroda, Ahmedabad, Gujarat 382230, India',
                'linkedin_username' => 'jinendra2002',
                'instagram_url' => 'https://www.instagram.com/jinendra_panchal_',
                'facebook_url' => 'https://www.facebook.com/jinendra.panchal',
                'twitter_url' => 'https://twitter.com/jinendra_2002',
                'telegram_url' => 'https://t.me/jinendra_panchal',
                'github_url' => 'https://github.com/jinendra2002',
                'whatsapp_number' => '+919979024601',
                'social_links' => [
                    ['label' => 'Instagram', 'url' => 'https://www.instagram.com/jinendra_panchal_'],
                    ['label' => 'Facebook', 'url' => 'https://www.facebook.com/jinendra.panchal'],
                    ['label' => 'Twitter', 'url' => 'https://twitter.com/jinendra_2002'],
                    ['label' => 'Telegram', 'url' => 'https://t.me/jinendra_panchal'],
                    ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/jinendra2002'],
                    ['label' => 'GitHub', 'url' => 'https://github.com/jinendra2002'],
                    ['label' => 'WhatsApp', 'url' => 'https://wa.me/919979024601'],
                ],
                'seo_title' => 'Jinendra Panchal | CA Finalist — Accounting, Audit & Taxation',
                'seo_description' => 'Portfolio of Jinendra Panchal, CA Finalist specialising in accounting, audit, GST and income tax compliance. Explore my qualifications, skills and professional assignments.',
                'seo_keywords' => 'Jinendra Panchal, CA Finalist, Chartered Accountant, Accounting, Audit, Taxation, GST, Income Tax, Articleship, Ahmedabad',
            ]
        );
    }
}
