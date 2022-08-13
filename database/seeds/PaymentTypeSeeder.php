<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_types = [
            [
                'name' => 'GCASH'
            ],
            [
                'name' => 'CASH'
            ],
            [
                'name' => 'BANK'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($payment_types as $key => $type) {

            try {

                // Create DishCategory
                $paymentTypesObj = PaymentType::create([

                    'name' => $type['name']
                ]);

                echo $paymentTypesObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate role ' . $type['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
