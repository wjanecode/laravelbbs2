<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = factory(Category::class)->times(50)->make()->each(function ($category, $index) {
            if ($index == 0) {
                // $category->field = 'value';
            }
        });

        Category::insert($categories->toArray());
    }

}

