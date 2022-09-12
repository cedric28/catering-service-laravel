<?php

use Illuminate\Database\Seeder;
use App\PackageEquipments;

class PackageEquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageEquipments = [
            //Bronze Package
            [
                'inventory_id' => 1,
                'quantity' => 100,
                'package_id' => 1,
            ],
            [
                'inventory_id' => 2,
                'quantity' => 100,
                'package_id' => 1,
            ],
            [
                'inventory_id' => 3,
                'quantity' => 100,
                'package_id' => 1,
            ],
            [
                'inventory_id' => 4,
                'quantity' => 100,
                'package_id' => 1,
            ],
            [
                'inventory_id' => 5,
                'quantity' => 100,
                'package_id' => 1,
            ],
            // end of bronze package
        ];

         /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packageEquipments as $key => $package) {

            try {

                // Create Category
                $packageObj = PackageEquipments::create([

                    'inventory_id' => $package['inventory_id'],
                    'quantity' => $package['quantity'],
                    'package_id' => $package['package_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $packageObj->inventory_id . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate id ' . $package['inventory_id'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
