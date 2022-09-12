<?php

use Illuminate\Database\Seeder;
use App\PackageMenu;

class PackageMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageMenus = [
            [
                'category_id' => 1,
                'package_id' => 1
            ],
            [
                'category_id' => 2,
                'package_id' => 1
            ],
            [
                'category_id' => 3,
                'package_id' => 1
            ],
            [
                'category_id' => 4,
                'package_id' => 1
            ],
            [
                'category_id' => 5,
                'package_id' => 1
            ],
            [
                'category_id' => 6,
                'package_id' => 1
            ],
            [
                'category_id' => 7,
                'package_id' => 1
            ],
            [
                'category_id' => 8,
                'package_id' => 1
            ],

            //end of package 1

            [
                'category_id' => 1,
                'package_id' => 2
            ],
            [
                'category_id' => 2,
                'package_id' => 2
            ],
            [
                'category_id' => 3,
                'package_id' => 2
            ],
            [
                'category_id' => 4,
                'package_id' => 2
            ],
            [
                'category_id' => 5,
                'package_id' => 2
            ],
            [
                'category_id' => 6,
                'package_id' => 2
            ],
            [
                'category_id' => 7,
                'package_id' => 2
            ],
            [
                'category_id' => 8,
                'package_id' => 2
            ],

            //end of package 2
            [
                'category_id' => 1,
                'package_id' => 3
            ],
            [
                'category_id' => 2,
                'package_id' => 3
            ],
            [
                'category_id' => 3,
                'package_id' => 3
            ],
            [
                'category_id' => 4,
                'package_id' => 3
            ],
            [
                'category_id' => 5,
                'package_id' => 3
            ],
            [
                'category_id' => 6,
                'package_id' => 3
            ],
            [
                'category_id' => 7,
                'package_id' => 3
            ],
            [
                'category_id' => 8,
                'package_id' => 3
            ],

            //end of package 3
            [
                'category_id' => 1,
                'package_id' => 4
            ],
            [
                'category_id' => 2,
                'package_id' => 4
            ],
            [
                'category_id' => 3,
                'package_id' => 4
            ],
            [
                'category_id' => 4,
                'package_id' => 4
            ],
            [
                'category_id' => 5,
                'package_id' => 4
            ],
            [
                'category_id' => 6,
                'package_id' => 4
            ],
            [
                'category_id' => 7,
                'package_id' => 4
            ],
            [
                'category_id' => 8,
                'package_id' => 4
            ],

            //end of package 4

            [
                'category_id' => 1,
                'package_id' => 5
            ],
            [
                'category_id' => 2,
                'package_id' => 5
            ],
            [
                'category_id' => 3,
                'package_id' => 5
            ],
            [
                'category_id' => 4,
                'package_id' => 5
            ],
            [
                'category_id' => 5,
                'package_id' => 5
            ],
            [
                'category_id' => 6,
                'package_id' => 5
            ],
            [
                'category_id' => 7,
                'package_id' => 5
            ],
            [
                'category_id' => 8,
                'package_id' => 5
            ],

            //end of package 5


            [
                'category_id' => 1,
                'package_id' => 6
            ],
            [
                'category_id' => 2,
                'package_id' => 6
            ],
            [
                'category_id' => 3,
                'package_id' => 6
            ],
            [
                'category_id' => 4,
                'package_id' => 6
            ],
            [
                'category_id' => 5,
                'package_id' => 6
            ],
            [
                'category_id' => 6,
                'package_id' => 6
            ],
            [
                'category_id' => 7,
                'package_id' => 6
            ],
            [
                'category_id' => 8,
                'package_id' => 6
            ],

            //end of package 6

            [
                'category_id' => 1,
                'package_id' => 7
            ],
            [
                'category_id' => 2,
                'package_id' => 7
            ],
            [
                'category_id' => 3,
                'package_id' => 7
            ],
            [
                'category_id' => 4,
                'package_id' => 7
            ],
            [
                'category_id' => 5,
                'package_id' => 7
            ],
            [
                'category_id' => 6,
                'package_id' => 7
            ],
            [
                'category_id' => 7,
                'package_id' => 7
            ],
            [
                'category_id' => 8,
                'package_id' => 7
            ],

            //end of package 7

            [
                'category_id' => 1,
                'package_id' => 8
            ],
            [
                'category_id' => 2,
                'package_id' => 8
            ],
            [
                'category_id' => 3,
                'package_id' => 8
            ],
            [
                'category_id' => 4,
                'package_id' => 8
            ],
            [
                'category_id' => 5,
                'package_id' => 8
            ],
            [
                'category_id' => 6,
                'package_id' => 8
            ],
            [
                'category_id' => 7,
                'package_id' => 8
            ],
            [
                'category_id' => 8,
                'package_id' => 8
            ],

            //end of package 8
           

        ];
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packageMenus as $key => $menu) {

            try {

                // Create Category
                $otherObj = PackageMenu::create([

                    'category_id' => $menu['category_id'],
                    'package_id' => $menu['package_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $otherObj->category_id . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $other['category_id'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
