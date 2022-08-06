<?php

use Illuminate\Database\Seeder;
use App\InventoryCategory;

class InventoryCategorySeeder extends Seeder
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
                'name' => 'Table',
            ],
            [
                'name' => 'Cloth',
            ],
            [
                'name' => 'Artificials',
            ],
            [
                'name' => 'Chair',
            ],
            [
                'name' => 'Frames'
            ]

        ];

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($categories as $key => $category) {

            try {

                // Create Category
                $categoryObj = InventoryCategory::create([

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
