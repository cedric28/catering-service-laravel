<?php

use Illuminate\Database\Seeder;
use App\PackageTask;

class PackageTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageTasks = [
            //Bronze Package
            [
                'name' => 'Digital Photography',
                'package_id' => 1,
            ],
            [
                'name' => 'Pre-Nuptial Pictorial',
                'package_id' => 1,
            ],
            [
                'name' => 'Edited Video',
                'package_id' => 1,
            ],
            [
                'name' => 'Audio Visual Presentation',
                'package_id' => 1,
            ],
            [
                'name' => 'Same Day Edit',
                'package_id' => 1,
            ],
            [
                'name' => 'Pre-Nup Make up and Dress',
                'package_id' => 1,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 1,
            ],
            [
                'name' => 'Photo Booth',
                'package_id' => 1,
            ],
            [
                'name' => 'Bride/s Make-up during the wedding day',
                'package_id' => 1,
            ],
            [
                'name' => 'Sounds and Lights',
                'package_id' => 1,
            ],
            [
                'name' => 'Bridal Car Driver',
                'package_id' => 1,
            ],
            [
                'name' => 'Milk Tea Booth',
                'package_id' => 1,
            ],
            // end of Bronze Package
        ];

         /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packageTasks as $key => $package) {

            try {

                // Create Category
                $packageObj = PackageTask::create([

                    'name' => $package['name'],
                    'package_id' => $package['package_id'],
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
