<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories=[
            'personal',
            'work',
            'shopping',
            'fitness',
            'hobby',
            'travel',
            'education',
            'health',
            'finance',
            'entertainment',
            'projects',
            'family',
            'social',
            'miscellaneous',

        ];
        foreach($categories as $category){
        Category::create(['name'=>$category]);
        }
    }
}
