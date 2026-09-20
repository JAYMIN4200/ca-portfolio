<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'jinendrapanchal2002@gmail.com'],
            [
                'name' => 'Jinendra Panchal',
                'password' => 'Jinendra@2002',
                'is_admin' => true,
            ]
        );

        $admin->profile()->updateOrCreate(
            ['user_id' => $admin->id],
            [
                'professional_title' => 'CA Finalist | Accounting, Audit & Taxation Professional',
                'short_intro' => 'Aspiring Chartered Accountant with a strong foundation in accounting, audit, and taxation. Currently pursuing CA Final while gaining practical experience through Articleship.',
                'phone' => '+91 9979024601',
                'location' => 'Naroda, Ahmedabad, Gujarat 382230, India',
                'linkedin_username' => 'jinendra2002',
            ]
        );
    }
}
