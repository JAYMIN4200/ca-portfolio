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
                'professional_title' => 'Chartered Accountant | Accounting, Audit & Taxation Professional',
                'short_intro' => 'Chartered Accountant with a strong foundation in accounting, audit, and taxation, delivering reliable and compliant financial solutions.',
                'phone' => '+91 9979024601',
                'location' => 'Naroda, Ahmedabad, Gujarat 382230, India',
                'linkedin_username' => 'jinendra2002',
            ]
        );
    }
}
