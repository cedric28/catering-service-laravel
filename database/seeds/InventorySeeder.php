<?php

use Illuminate\Database\Seeder;
use App\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventories = [
            [
                'name' => 'Tiffany Table',
                'description' => 'Sample Description',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 1
            ],
            [
                'name' => 'Tiffany Cloths',
                'description' => 'Sample Description',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Tiffany Artificials',
                'description' => 'Sample Description',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            [
                'name' => 'Tiffany Chairs',
                'description' => 'Sample Description',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            [
                'name' => 'Tiffany Frames',
                'description' => 'Sample Description',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 5
            ]

        ];

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($inventories as $key => $inventory) {

            try {

                // Create Category
                $inventoryObj = Inventory::create([
                    'name' => $inventory['name'],
                    'description' => $inventory['description'],
                    'quantity' => $inventory['quantity'],
                    'quantity_in_use' => $inventory['quantity_in_use'],
                    'quantity_available' => $inventory['quantity_available'],
                    'inventory_category_id' => $inventory['inventory_category_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $inventory->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $inventory['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
