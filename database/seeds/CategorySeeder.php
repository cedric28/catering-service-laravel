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
                'title' => 'Laptop'
            ] ,
            [
                'title' => 'Mobile Phone'
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
