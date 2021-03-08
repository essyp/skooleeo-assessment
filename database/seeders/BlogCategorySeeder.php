<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('blog_categories')->insert(array (
            0 => 
            array (
                'name' => 'Technology',
                'slug' => 'technology',
                'status' => 1,
                'created_at' => '2021-03-07 21:36:00',
                'updated_at' => '2021-03-07 21:36:00',
            ),
            1 => 
            array (
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'status' => 1,
                'created_at' => '2021-03-07 21:36:00',
                'updated_at' => '2021-03-07 21:36:00',
            ),
            2 => 
            array (
                'name' => 'Engineering',
                'slug' => 'engineering',
                'status' => 1,
                'created_at' => '2021-03-07 21:36:00',
                'updated_at' => '2021-03-07 21:36:00',
            ),
        ));
    }
}
