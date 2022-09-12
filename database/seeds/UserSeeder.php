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
                'name' => 'Paula Wong',
                'email' => 'paulawong@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Genevieve Hemphill',
                'email' => 'genevieve@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Robert Myers',
                'email' => 'robertmyers@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Dale Blake',
                'email' => 'daleblake@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Ann Williams',
                'email' => 'annwilliams@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Pamela Racette',
                'email' => 'pamelaracette@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Nicolas Mueller',
                'email' => 'nicolasmueller@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Anna Allen',
                'email' => 'annaallen@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Deanna Inniss',
                'email' => 'deannainniss@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Robert Pennell',
                'email' => 'robertpennell@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Raymond Menzies',
                'email' => 'raymondmenzies@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Louise Procopio',
                'email' => 'louiseprocopio@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Mary Lesko',
                'email' => 'marylesko@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Rick Boese',
                'email' => 'rickyboese@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Nancy Velazquez',
                'email' => 'nancyvelazquez@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Darin Clay',
                'email' => 'darinclay@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Digna Lopez',
                'email' => 'dignalopez@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Randy A. Stringer',
                'email' => 'randystinger@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Ralph D. Hall',
                'email' => 'RalphDHall@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Quinton R. Crouch',
                'email' => 'QuintonRCrouch@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Annmarie J. Marcotte',
                'email' => 'AnnmarieJMarcotte@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Yvonne R. Lilly',
                'email' => 'YvonneRLilly@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Sam V. Horvath',
                'email' => 'SamVHorvath@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Edwin D. Myers',
                'email' => 'EdwinDMyers@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Christian J. Martinez',
                'email' => 'ChristianJMartinez@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Shelia J. Franco',
                'email' => 'SheliaJFranco@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Jerry S. Bohannon',
                'email' => 'JerrySBohannon@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 2,
                'job_type_id' => 2
            ],
            [
                'name' => 'Joseph G. Randall',
                'email' => 'JosephGRandall@gmail.com',
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
                'name' => 'Kendra G. Butts',
                'email' => 'KendraGButts@staff.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 3
            ],
            [
                'name' => 'William S. Blankenship',
                'email' => 'WilliamSBlankenship@staff.com',
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
                'name' => 'James P. Covert',
                'email' => 'JamesPCovert@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 4
            ],
            [
                'name' => 'Blanche P. Peterson',
                'email' => 'BlanchePPeterson@gmail.com',
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
                'name' => 'Michelle J. Fincher',
                'email' => 'MichelleJFincher@gmail.com',
                'pw' => 'passw0rd',
                'role_id' => 3,
                'job_type_id' => 5
            ],
            [
                'name' => 'Erick F. Burr',
                'email' => 'ErickFBurr@gmail.com',
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
