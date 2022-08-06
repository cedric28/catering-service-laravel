<?php

use Illuminate\Database\Seeder;
use App\MainPackage;

class MainPackageSeeder extends Seeder
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
                'name' => 'Wedding Package'
            ],
            [
                'name' => 'Debut Package'
            ],
            [
                'name' => 'Birthday Package'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packages as $key => $package) {

            try {

                // Create MainPackage
                $packageObj = MainPackage::create([

                    'name' => $package['name']
                ]);

                echo $packageObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate role ' . $package['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
