<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = new Category;
        $category1->name = "Hardware";
        $category1->save();

        $category2 = new Category;
        $category2->name = "Software";
        $category2->save();

        $category3 = new Category;
        $category3->name = "Internet";
        $category3->save();

        $category4 = new Category;
        $category4->name = "Wi-fi";
        $category4->save();
    }
}
