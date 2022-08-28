<?php

use Illuminate\Database\Seeder;
use App\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_types = [
            [
                'name' => 'Manager'
            ],
            [
                'name' => 'HeadStaff'
            ],
            [
                'name' => 'Busboy'
            ],
            [
                'name' => 'Dishwasher'
            ],
            [
                'name' => 'Server'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($job_types as $key => $job) {

            try {

                // Create Job
                $jobObj = JobType::create([
                    'name' => $job['name'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $jobObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate job type ' . $job['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
