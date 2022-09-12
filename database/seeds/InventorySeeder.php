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
                'name' => 'Rounded Table',
                'description' => 'Rounded Table',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 1
            ],
            [
                'name' => 'Kid/s Table',
                'description' => 'Kid/s Table',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 1
            ],
            [
                'name' => 'Long Table',
                'description' => 'Long Table',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 1
            ],
            //cloth
            [
                'name' => 'Mono Block Cover White',
                'description' => 'White Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Black',
                'description' => 'Black Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Red',
                'description' => 'Red Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Yellow',
                'description' => 'Yellow Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Blue',
                'description' => 'Blue Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Orange',
                'description' => 'Orange Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Green',
                'description' => 'Green Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Purple',
                'description' => 'Purple Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Mono Block Cover Pink',
                'description' => 'Pink Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            //end of mono block
            [
                'name' => 'Table Napkin White',
                'description' => 'White Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Black',
                'description' => 'Black Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Red',
                'description' => 'Red Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Yellow',
                'description' => 'Yellow Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Blue',
                'description' => 'Blue Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Orange',
                'description' => 'Orange Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Green',
                'description' => 'Green Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Purple',
                'description' => 'Purple Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Table Napkin Pink',
                'description' => 'Pink Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            //end of table napkin
            [
                'name' => 'Rounded tablecloth White',
                'description' => 'White Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Black',
                'description' => 'Black Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Red',
                'description' => 'Red Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Yellow',
                'description' => 'Yellow Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Blue',
                'description' => 'Blue Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Orange',
                'description' => 'Orange Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Green',
                'description' => 'Green Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Purple',
                'description' => 'Purple Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Rounded tablecloth Pink',
                'description' => 'Pink Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            //end of rounded tablecloth
            [
                'name' => 'Long tablecloth White',
                'description' => 'White Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Black',
                'description' => 'Black Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Red',
                'description' => 'Red Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Yellow',
                'description' => 'Yellow Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Blue',
                'description' => 'Blue Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Orange',
                'description' => 'Orange Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Green',
                'description' => 'Green Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Purple',
                'description' => 'Purple Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Long tablecloth Pink',
                'description' => 'Pink Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            //end of long table cloth
            [
                'name' => 'Chair Ribbon White',
                'description' => 'White Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Black',
                'description' => 'Black Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Red',
                'description' => 'Red Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Yellow',
                'description' => 'Yellow Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Blue',
                'description' => 'Blue Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Orange',
                'description' => 'Orange Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Green',
                'description' => 'Green Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Purple',
                'description' => 'Purple Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            [
                'name' => 'Chair Ribbon Pink',
                'description' => 'Pink Color',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 2
            ],
            //end cloth
            [
                'name' => 'Spoons',
                'description' => 'Spoons',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            [
                'name' => 'Forks',
                'description' => 'Forks',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            [
                'name' => 'Plates',
                'description' => 'Plates',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            [
                'name' => 'Highball Glass',
                'description' => 'Highball Glass',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            [
                'name' => 'Wineglass',
                'description' => 'Wineglass',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 3
            ],
            //end of dishware
            [
                'name' => 'Tiffany Chairs',
                'description' => 'Tiffany Chairs',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            [
                'name' => 'Monoblock',
                'description' => 'Monoblock',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            [
                'name' => 'Wedding sofa',
                'description' => 'Wedding sofa',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            [
                'name' => 'Debutant’s Sofa',
                'description' => 'Debutant’s Sofa',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            [
                'name' => 'Kids’ monoblock',
                'description' => 'Kids’ monoblock',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 4
            ],
            //end of chair
            [
                'name' => 'Artificial Flowers Wisteria',
                'description' => 'Wisteria',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 5
            ],
            [
                'name' => 'Artificial Flowers Rose',
                'description' => 'Rose',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 5
            ],
            [
                'name' => 'Artificial Flowers Carnation',
                'description' => 'Carnation',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 5
            ],
            //end of decorations
            [
                'name' => 'Table Numbers',
                'description' => 'Table Numbers',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            [
                'name' => 'GuestBook',
                'description' => 'GuestBook',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            [
                'name' => 'Signages Reception',
                'description' => 'Reception',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            [
                'name' => 'Signages Entrance',
                'description' => 'Entrance',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            [
                'name' => 'Signages Parking',
                'description' => 'Parking',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            [
                'name' => 'Signages Restrooms',
                'description' => 'Restrooms',
                'quantity' => 1000,
                'quantity_in_use' => 0,
                'quantity_available' => 1000,
                'inventory_category_id' => 6
            ],
            //end of decorations

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
