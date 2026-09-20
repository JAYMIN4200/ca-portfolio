<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'jinendrapanchal2002@gmail.com')->first();

        if (! $admin) {
            return;
        }

        $qualifications = [
            [
                'name' => 'CA Intermediate',
                'institution' => 'Institute of Chartered Accountants of India',
                'status' => 'cleared',
                'start_year' => 2020,
                'end_year' => 2021,
                'description' => 'Successfully cleared CA Intermediate examination.',
                'display_order' => 1,
            ],
            [
                'name' => 'CA Final',
                'institution' => 'Institute of Chartered Accountants of India',
                'status' => 'pursuing',
                'start_year' => 2021,
                'end_year' => null,
                'description' => 'Currently pursuing CA Final examination.',
                'display_order' => 2,
            ],
            [
                'name' => 'B.Com',
                'institution' => 'Gujarat University',
                'status' => 'completed',
                'start_year' => 2020,
                'end_year' => 2023,
                'description' => 'Bachelor of Commerce degree completed.',
                'display_order' => 3,
            ],
            [
                'name' => 'LLB',
                'institution' => 'Gujarat University',
                'status' => 'pursuing',
                'start_year' => 2026,
                'end_year' => null,
                'description' => 'Currently pursuing Bachelor of Laws.',
                'display_order' => 4,
            ],
        ];

        foreach ($qualifications as $qual) {
            $admin->qualifications()->updateOrCreate(
                ['name' => $qual['name']],
                $qual
            );
        }
    }
}
