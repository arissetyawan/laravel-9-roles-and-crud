<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name"=>"Fashion",
            "description"=>"Stay in touch with the latest trends"
        ]);
        Category::create([
            "name"=>"Health",
            "description"=>"An apple a day keeps the doctor away"
        ]);
        Category::create([
            "name"=>"Food",
            "description"=>"Our favourite recipes"
        ]);
        Category::create([
            "name"=>"Home",
            "description"=>"The latest trends in home decorations"
        ]);
        Category::create([
            "name"=>"Travel",
            "description"=>"Travel ideas for everyone"
        ]);
        Category::create([
            "name"=>"Category",
            "description"=>"Category ideas for everyone"
        ]);
    }
}
