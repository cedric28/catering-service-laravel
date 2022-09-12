<?php

use Illuminate\Database\Seeder;
use App\Foods;

class FoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foods = [
            [
                'name' => 'Roast beef In Mushroom Sauce',
                'category_id' => 1
            ],
            [
                'name' => 'Beef with Broccoli',
                'category_id' => 1
            ],
            [
                'name' => 'Spicy Beef Salpicao',
                'category_id' => 1
            ],
            [
                'name' => 'Beef Stroganoff',
                'category_id' => 1
            ],
            [
                'name' => 'Beef Morcon (Traditionally Cooked)',
                'category_id' => 1
            ],
            [
                'name' => 'Beef Stew (Peanut Sauce)',
                'category_id' => 1
            ],
            [
                'name' => 'Beef Kare-Kare',
                'category_id' => 1
            ],
            //end beef
            [
                'name' => 'Pork Spareribs / Liempo in BBQ Sauce',
                'category_id' => 2
            ],
            [
                'name' => 'Pork Oriental',
                'category_id' => 2
            ],
            [
                'name' => 'Pork Liempo Humba',
                'category_id' => 2
            ],
            [
                'name' => 'Hawaiian Porkchops',
                'category_id' => 2
            ],
            [
                'name' => 'Pork Pastel',
                'category_id' => 2
            ],
            [
                'name' => 'Asian Tender Liempo',
                'category_id' => 2
            ],
            [
                'name' => 'Pork loin Supreme',
                'category_id' => 2
            ],
            [
                'name' => 'Pot Roast in Mushroom Sauce',
                'category_id' => 2
            ],
            //end pork
            [
                'name' => 'Chicken Teriyaki Topped with Sesame Seeds',
                'category_id' => 3
            ],
            [
                'name' => 'Soy Chicken (Oyster Sauce & White Wine)',
                'category_id' => 3
            ],
            [
                'name' => 'Chicken Inasal',
                'category_id' => 3
            ],
            [
                'name' => 'Chicken Pastel',
                'category_id' => 3
            ],
            [
                'name' => 'Cinnamon Fried Chicken',
                'category_id' => 3
            ],
            //end chicken
            [
                'name' => 'Crispy Fish Fillet Creamy Onion',
                'category_id' => 4
            ],
            [
                'name' => 'Crispy Fish Fillet Honey Mustard',
                'category_id' => 4
            ],
            [
                'name' => 'Crispy Fish Fillet Cream of TarTar',
                'category_id' => 4
            ],
            [
                'name' => 'Crispy Fish Fillet Sweet & Sour',
                'category_id' => 4
            ],
            [
                'name' => 'Pan Grilled Blue Marlin / Tuna',
                'category_id' => 4
            ],
            [
                'name' => 'Baked Fillet with Creamy Pesto Filling',
                'category_id' => 4
            ],
            [
                'name' => 'Seafoods Medley',
                'category_id' => 4
            ],
            //end fish
            [
                'name' => 'Tuna & Corn Spaghetti',
                'category_id' => 5
            ],
            [
                'name' => 'Ham & Mushroom Spaghetti',
                'category_id' => 5
            ],
            [
                'name' => 'Aglio-Oglio Pasta',
                'category_id' => 5
            ],
            [
                'name' => 'Bam-i (Vermicelli & Canton)',
                'category_id' => 5
            ],
            [
                'name' => 'Ham & Cheese Carbonara',
                'category_id' => 5
            ],
            //end pasta
            [
                'name' => 'Creamy Coffee Jelly',
                'category_id' => 6
            ],
            [
                'name' => 'Buko Pandan',
                'category_id' => 6
            ],
            [
                'name' => 'Fresh Fruits in Season',
                'category_id' => 6
            ],
            [
                'name' => 'Fruit Salad',
                'category_id' => 6
            ],
            [
                'name' => 'Fruit Cocktail Rhum',
                'category_id' => 6
            ],
            [
                'name' => 'Leche Flan',
                'category_id' => 6
            ],
            [
                'name' => 'Lychee Almond Treat',
                'category_id' => 6
            ],
            //end dessert
            [
                'name' => 'Caesars Salad',
                'category_id' => 7
            ],
            [
                'name' => 'Asian Salad',
                'category_id' => 7
            ],
            [
                'name' => 'Thousand Island Salad',
                'category_id' => 7
            ],
            //end vegetable
            [
                'name' => 'Iced Tea',
                'category_id' => 8
            ],
            [
                'name' => 'Soft drinks',
                'category_id' => 8
            ],
            [
                'name' => 'Orange/Pineapple Juice',
                'category_id' => 8
            ],
            //end drinks
        ];

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($foods as $key => $food) {

            try {

                // Create Category
                $foodObj = Foods::create([

                    'name' => $food['name'],
                    'category_id' => $food['category_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $foodObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $food['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
