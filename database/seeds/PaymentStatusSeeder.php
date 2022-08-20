<?php

use Illuminate\Database\Seeder;
use App\PaymentStatus;

class PaymentStatusSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_status = [
            [
                'name' => '50% Payment'
            ],
            [
                'name' => '100% Full Payment'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($payment_status as $key => $status) {

            try {

                // Create DishCategory
                $paymentStatusObj = PaymentStatus::create([

                    'name' => $status['name']
                ]);

                echo $paymentStatusObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate role ' . $status['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
