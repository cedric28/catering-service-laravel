<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        for ($x = 1; $x <= 5; $x++) {
            try {
             
                // Create Product Laptop
                $laptopObj = Product::create([

                    'title' => 'Laptop '.$x,
                    'content' => 'Laptop Content '.$x,
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                $laptopObj->categories()->sync(1);

                echo $laptopObj->title . ' | ';

            } catch (Exception $e) {
                echo 'Duplicate Product '.$x ;
            }   
        }

        for ($x = 1; $x <= 5; $x++) {
            try {
             
                // Create Product Cellphone
                $cellphoneObj = Product::create([

                    'title' => 'Cellphone '.$x,
                    'content' => 'Cellphone Content '.$x,
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                $cellphoneObj->categories()->sync(2);

                echo $cellphoneObj->title . ' | ';

            } catch (Exception $e) {
                echo 'Duplicate Product'.$x ;
            }   
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
