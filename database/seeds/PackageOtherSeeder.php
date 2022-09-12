<?php

use Illuminate\Database\Seeder;
use App\PackageOther;

class PackageOtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageOthers = [
            [
                'name' => 'Photo-Video Coverage',
                'service_price' => 15000,
                'package_id' => 8
            ],
            [
                'name' => 'Stage Design (Theme)',
                'service_price' => 5000,
                'package_id' => 8
            ],
            [
                'name' => 'Clown, Magician, Puppet Show',
                'service_price' => 5000,
                'package_id' => 8
            ],
            [
                'name' => '50 Loothebags',
                'service_price' => 3000,
                'package_id' => 8
            ],
            [
                'name' => '50 Souvenirs',
                'service_price' => 3000,
                'package_id' => 8
            ],
            [
                'name' => 'Name Tags, Party Hats, Piñata, Pabitin, Prizes',
                'service_price' => 2000,
                'package_id' => 8
            ],
            [
                'name' => 'Face Painting, Balloon Twisting',
                'service_price' => 4000,
                'package_id' => 8
            ],
            [
                'name' => 'Customized Cake',
                'service_price' => 3000,
                'package_id' => 8
            ],
            [
                'name' => 'Ice Cream Cart',
                'service_price' => 4000,
                'package_id' => 8
            ],
            [
                'name' => 'Cotton Candy Cart',
                'service_price' => 2000,
                'package_id' => 8
            ],
            [
                'name' => 'Sound System',
                'service_price' => 5000,
                'package_id' => 8
            ],
            [
                'name' => '50 pcs. Invitations',
                'service_price' => 2500,
                'package_id' => 8
            ],

        ];
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packageOthers as $key => $other) {

            try {

                // Create Category
                $otherObj = PackageOther::create([

                    'name' => $other['name'],
                    'service_price' => $other['service_price'],
                    'package_id' => $other['package_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $otherObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $other['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
