<?php

namespace Database\Seeders;

use App\Models\SkillCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Accounting', 'icon' => 'calculator', 'display_order' => 1],
            ['name' => 'Audit', 'icon' => 'clipboard-document-check', 'display_order' => 2],
            ['name' => 'Taxation', 'icon' => 'receipt-percent', 'display_order' => 3],
            ['name' => 'Compliance', 'icon' => 'shield-check', 'display_order' => 4],
            ['name' => 'Software & Tools', 'icon' => 'computer-desktop', 'display_order' => 5],
        ];

        foreach ($categories as $category) {
            SkillCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category
            );
        }
    }
}
