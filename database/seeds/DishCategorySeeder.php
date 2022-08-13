<?php

use Illuminate\Database\Seeder;
use App\DishCategory;

class DishCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dish_categories = [
            [
                'name' => 'Main Dish'
            ],
            [
                'name' => 'Secondary Dish'
            ],
            [
                'name' => 'Others'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($dish_categories as $key => $dish_category) {

            try {

                // Create DishCategory
                $dish_categoryObj = DishCategory::create([

                    'name' => $dish_category['name']
                ]);

                echo $dish_categoryObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate role ' . $dish_category['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
