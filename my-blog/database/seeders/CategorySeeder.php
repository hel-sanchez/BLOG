<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Technology',
            'Lifestyle',
            'Travel',
            'Food',
            'Entertainment',
            'Education',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => strtolower($name)],
                ['name' => $name]
            );
        }
    }
}
