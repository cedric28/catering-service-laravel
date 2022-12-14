<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator'
            ],
            [
                'name' => 'HeadStaff'
            ],
            [
                'name' => 'Staff'
            ]
        ];


        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($roles as $key => $role) {

            try {

                // Create Role
                $roleObj = Role::create([

                    'name' => $role['name']
                ]);

                echo $roleObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate role ' . $role['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
