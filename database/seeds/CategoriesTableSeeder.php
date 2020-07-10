<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = factory(Category::class)->times(50)->make()->each(function ($category, $index) {

        })->toArray();

        Category::insert($categories);
    }

}

