<?php

use Illuminate\Database\Seeder;
use App\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'name' => 'Bronze Package',
                'package_pax' => 100,
                'package_price' => 100000,
                'main_package_id' => 1
            ],
            [
                'name' => 'Silver Package',
                'package_pax' => 120,
                'package_price' => 165000,
                'main_package_id' => 1
            ],
            [
                'name' => 'Gold Package',
                'package_pax' => 150,
                'package_price' => 240000,
                'main_package_id' => 1
            ],
            [
                'name' => 'Platinum Package',
                'package_pax' => 175,
                'package_price' => 350000,
                'main_package_id' => 1
            ],
            [
                'name' => 'Carnation Package',
                'package_pax' => 150,
                'package_price' => 150000,
                'main_package_id' => 2
            ],
            [
                'name' => 'Rose Package',
                'package_pax' => 100,
                'package_price' => 100000,
                'main_package_id' => 2
            ],
            [
                'name' => 'Tulip Package',
                'package_pax' => 150,
                'package_price' => 200000,
                'main_package_id' => 2
            ],
            [
                'name' => 'Birthday Package 2015',
                'package_pax' => 100,
                'package_price' => 39500,
                'main_package_id' => 3
            ]

        ];

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packages as $key => $package) {

            try {

                // Create Category
                $packageObj = Package::create([

                    'name' => $package['name'],
                    'package_pax' => $package['package_pax'],
                    'main_package_id' => $package['main_package_id'],
                    'package_price' => $package['package_price'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $packageObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $package['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
