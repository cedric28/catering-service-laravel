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
                'name' => 'Beef',
            ],
            [
                'name' => 'Pork',
            ],
            [
                'name' => 'Chicken',
            ],
            [
                'name' => 'Fish',
            ],
            [
                'name' => 'Pasta',
            ],
            [
                'name' => 'Dessert',
            ],
            [
                'name' => 'Vegetable',
            ],
            [
                'name' => 'Drinks',
            ]

        ];

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($categories as $key => $category) {

            try {

                // Create Category
                $categoryObj = Category::create([

                    'name' => $category['name'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $categoryObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $category['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
