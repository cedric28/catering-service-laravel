<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [ 
                'title' => 'Travel',
                'description' => 'daily commute',
            ] ,
            [
                'title' => 'Entertainment',
                'description' => 'movies etc',
            ]

        ];
        
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

            
        foreach($categories as $key => $category) {

            try {
             
                // Create Category
                $categoryObj = Category::create([

                    'title' => $category['title'],
                    'description' => $category['description'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $categoryObj->title . ' | ';

            } catch (Exception $e) {
                echo 'Duplicate title ' . $category['title'] . ' | ';
            }   
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
