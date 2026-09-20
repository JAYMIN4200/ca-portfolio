<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ProfileSeeder::class,
            QualificationSeeder::class,
            SkillCategorySeeder::class,
            SkillSeeder::class,
            SettingSeeder::class,
            ServiceSeeder::class,
            ExperienceSeeder::class,
            AssignmentSeeder::class,
            CaseStudySeeder::class,
            ClientSeeder::class,
            PaymentSeeder::class,
            ExpenseSeeder::class,
            MeetingSeeder::class,
            BlogPostSeeder::class,
            FaqSeeder::class,
            TermSeeder::class,
            TestimonialSeeder::class,
            MessageSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
