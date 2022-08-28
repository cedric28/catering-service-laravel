<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'JK Ignacio',
                'email' => 'admin@admin.com',
                'pw' => 'passw0rd',
                'role_id' => 1,
                'job_type_id' => 1
            ],
            [
                'name' => 'Mariz Clemente',
                'email' => 'head@head.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Ogie Manarin',
                'email' => 'ogie@head.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Lord Suyom',
                'email' => 'staff@staff.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 3
            ],
            [
                'name' => 'Jessica Stamm',
                'email' => 'jessica@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 3
            ],
            [
                'name' => 'Destin Howe',
                'email' => 'destin@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 3
            ],
            [
                'name' => 'Peggie Miller',
                'email' => 'peggie@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' =>3
            ],
            [
                'name' => 'Georgianna Greenfelder',
                'email' => 'georgianna@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 3
            ],
            [
                'name' => 'Loy Nader',
                'email' => 'loy@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 4
            ],
            [
                'name' => 'Tess Bins',
                'email' => 'tess@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 4
            ],
            [
                'name' => 'Nelle Carroll',
                'email' => 'nelle@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 4
            ],
            [
                'name' => 'Ursula Kuvalis',
                'email' => 'ursula@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 4
            ],
            [
                'name' => 'Jerome Zemlak',
                'email' => 'jerome@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 5
            ],
            [
                'name' => 'Gonzalo Wolf ',
                'email' => 'gonzalo@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 5
            ],
            [
                'name' => 'Morton Powlowski',
                'email' => 'morton@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 5
            ],
            [
                'name' => 'Dr. Lorenzo Feeney',
                'email' => 'lorenzo@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 5
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($users as $key => $user) {

            try {

                // Create Users
                $userObj = User::create([

                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt($user['pw']),
                    'role_id' => $user['role_id'],
                    'job_type_id' => $user['job_type_id']
                ]);

                echo $user['email'] . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate email address ' . $user['email'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
