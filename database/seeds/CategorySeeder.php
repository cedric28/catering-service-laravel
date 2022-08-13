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
                'dish_category_id' => 1
            ],
            [
                'name' => 'Pork',
                'dish_category_id' => 1
            ],
            [
                'name' => 'Chicken',
                'dish_category_id' => 2
            ],
            [
                'name' => 'Fish',
                'dish_category_id' => 2
            ],
            [
                'name' => 'Pasta',
                'dish_category_id' => 3
            ],
            [
                'name' => 'Dessert',
                'dish_category_id' => 3
            ],
            [
                'name' => 'Vegetable',
                'dish_category_id' => 3
            ],
            [
                'name' => 'Drinks',
                'dish_category_id' => 3
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
                    'dish_category_id' => $category['dish_category_id'],
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
