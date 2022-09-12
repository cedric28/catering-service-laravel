<?php

use Illuminate\Database\Seeder;
use App\PackageTask;

class PackageTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packageTasks = [
            //Bronze Package
            [
                'name' => 'Digital Photography',
                'package_id' => 1,
            ],
            [
                'name' => 'Pre-Nuptial Pictorial',
                'package_id' => 1,
            ],
            [
                'name' => 'Edited Video',
                'package_id' => 1,
            ],
            [
                'name' => 'Audio Visual Presentation',
                'package_id' => 1,
            ],
            [
                'name' => 'Same Day Edit',
                'package_id' => 1,
            ],
            [
                'name' => 'Pre-Nup Make up and Dress',
                'package_id' => 1,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 1,
            ],
            [
                'name' => 'Photo Booth',
                'package_id' => 1,
            ],
            [
                'name' => 'Bride/s Make-up during the wedding day',
                'package_id' => 1,
            ],
            [
                'name' => 'Sounds and Lights',
                'package_id' => 1,
            ],
            [
                'name' => 'Bridal Car Driver',
                'package_id' => 1,
            ],
            [
                'name' => 'Milk Tea Booth',
                'package_id' => 1,
            ],
            [
                'name' => 'Icing Cake',
                'package_id' => 1,
            ],
            // end of Bronze Package
            [
                'name' => 'Food Tasting',
                'package_id' => 2,
            ],
            [
                'name' => '50 pcs. Invitation',
                'package_id' => 2,
            ],
            [
                'name' => 'Entourage Flower Arrangement',
                'package_id' => 2,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 2,
            ],
            [
                'name' => 'Couple’s Backdrop Arrangement',
                'package_id' => 2,
            ],
            [
                'name' => 'Bridal Asssitants',
                'package_id' => 2,
            ],
            [
                'name' => 'Sound and Lights',
                'package_id' => 2,
            ],
            [
                'name' => 'Photo Booth',
                'package_id' => 2,
            ],
            [
                'name' => '3-Layer Fondant Cake',
                'package_id' => 2,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 2,
            ],
            [
                'name' => 'Photo-Video Coverage',
                'package_id' => 2,
            ],
            [
                'name' => 'Pre-Nup Make-up and Dress',
                'package_id' => 2,
            ],
            [
                'name' => 'Bride’s make-up for Wedding',
                'package_id' => 2,
            ],
            [
                'name' => 'Bridal Car',
                'package_id' => 2,
            ],
            // end of Silver Package
            [
                'name' => 'Food Tasting',
                'package_id' => 3,
            ],
            [
                'name' => '50 pcs. Invitation',
                'package_id' => 3,
            ],
            [
                'name' => 'Entourage Flower Arrangement',
                'package_id' => 3,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 3,
            ],
            [
                'name' => 'Couple’s Backdrop Arrangement',
                'package_id' => 3,
            ],
            [
                'name' => 'Bridal Asssitants',
                'package_id' => 3,
            ],
            [
                'name' => 'Sound and Lights',
                'package_id' => 3,
            ],
            [
                'name' => 'Photo Booth',
                'package_id' => 3,
            ],
            [
                'name' => '3-Layer Fondant Cake',
                'package_id' => 3,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 3,
            ],
            [
                'name' => 'Acoustic Band',
                'package_id' => 3,
            ],
            [
                'name' => 'Photo-Video Coverage',
                'package_id' => 3,
            ],
            [
                'name' => 'Pre-Nup Make-up and Dress',
                'package_id' => 3,
            ],
            [
                'name' => 'Bridal Gown',
                'package_id' => 3,
            ],
            [
                'name' => 'Bride’s make-up for Wedding',
                'package_id' => 3,
            ],
            [
                'name' => 'Bridal Car',
                'package_id' => 3,
            ],
            // end of Gold Package
            [
                'name' => 'Food Tasting',
                'package_id' => 4,
            ],
            [
                'name' => '75 pcs. Invitation',
                'package_id' => 4,
            ],
            [
                'name' => 'Entourage Flower Arrangement',
                'package_id' => 4,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 4,
            ],
            [
                'name' => 'Couple’s Backdrop Arrangement',
                'package_id' => 4,
            ],
            [
                'name' => 'Bridal Asssitants',
                'package_id' => 4,
            ],
            [
                'name' => 'Sound and Lights',
                'package_id' => 4,
            ],
            [
                'name' => 'Photo Booth',
                'package_id' => 4,
            ],
            [
                'name' => '3-Layer Fondant Cake',
                'package_id' => 4,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 4,
            ],
            [
                'name' => 'Acoustic Band',
                'package_id' => 4,
            ],
            [
                'name' => 'Photo-Video Coverage',
                'package_id' => 4,
            ],
            [
                'name' => 'Bridal Gown',
                'package_id' => 4,
            ],
            [
                'name' => 'Gowns (2 mothers)',
                'package_id' => 4,
            ],
            [
                'name' => 'Gowns ( 5 secondary sponsors)',
                'package_id' => 4,
            ],
            [
                'name' => 'Gowns (3 flower girls)',
                'package_id' => 4,
            ],
            [
                'name' => 'Bride’s make-up for wedding',
                'package_id' => 4,
            ],
            [
                'name' => 'Make-up (2 mothers)',
                'package_id' => 4,
            ],
            [
                'name' => 'Make-up ( 5 secondary sponsors)',
                'package_id' => 4,
            ],
            [
                'name' => 'Make-up ( 3 flower girls)',
                'package_id' => 4,
            ],
            [
                'name' => 'Bridal Car',
                'package_id' => 4,
            ],
            // end of Platinum Package
            [
                'name' => 'Food Tasting',
                'package_id' => 5,
            ],
            [
                'name' => 'Stage Arrangement',
                'package_id' => 5,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 5,
            ],
            [
                'name' => 'Photo-video coverage',
                'package_id' => 5,
            ],
            [
                'name' => 'Photoshoot Make-up and dress',
                'package_id' => 5,
            ],
            [
                'name' => 'Debutant’s make-up for event',
                'package_id' => 5,
            ],
            [
                'name' => 'Debut Assistants',
                'package_id' => 5,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 5,
            ],
            [
                'name' => '3 layer fondant cake',
                'package_id' => 5,
            ],
            [
                'name' => '50 pcs. Invitations',
                'package_id' => 5,
            ],
            [
                'name' => 'Photobooth',
                'package_id' => 5,
            ],
            [
                'name' => 'Sound and lights',
                'package_id' => 5,
            ],
            // end of Carnation Package
            [
                'name' => 'Food Tasting',
                'package_id' => 6,
            ],
            [
                'name' => 'Stage Arrangement',
                'package_id' => 6,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 6,
            ],
            [
                'name' => 'Photo-video coverage',
                'package_id' => 6,
            ],
            [
                'name' => 'Photoshoot Make-up and dress',
                'package_id' => 6,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 6,
            ],
            [
                'name' => 'Icing cake',
                'package_id' => 6,
            ],
            [
                'name' => '30 pcs. Invitations',
                'package_id' => 6,
            ],
            [
                'name' => 'Photobooth',
                'package_id' => 6,
            ],
            [
                'name' => 'Sound and lights',
                'package_id' => 6,
            ],
            // end of Rose Package
            [
                'name' => 'Food Tasting',
                'package_id' => 7,
            ],
            [
                'name' => 'Stage Arrangement',
                'package_id' => 7,
            ],
            [
                'name' => 'Table Arrangement',
                'package_id' => 7,
            ],
            [
                'name' => 'Photo-video coverage',
                'package_id' => 7,
            ],
            [
                'name' => 'Photoshoot Make-up and dress',
                'package_id' => 7,
            ],
            [
                'name' => 'Debutant’s make-up for event',
                'package_id' => 7,
            ],
            [
                'name' => 'Debut Assistants',
                'package_id' => 7,
            ],
            [
                'name' => 'Hosting',
                'package_id' => 7,
            ],
            [
                'name' => 'Acoustic Band',
                'package_id' => 7,
            ],
            [
                'name' => '3 layer fondant cake',
                'package_id' => 7,
            ],
            [
                'name' => '50 pcs. Invitations',
                'package_id' => 7,
            ],
            [
                'name' => 'Photobooth',
                'package_id' => 7,
            ],
            [
                'name' => 'Sound and lights',
                'package_id' => 7,
            ],
            // end of Tulip Package
            [
                'name' => 'Food Tasting',
                'package_id' => 8,
            ],
            [
                'name' => 'Photo-video coverage',
                'package_id' => 8,
            ],
            [
                'name' => 'Stage Arrangement',
                'package_id' => 8,
            ],
            [
                'name' => 'Clown, magician and puppet show',
                'package_id' => 8,
            ],
            [
                'name' => 'Kid’s birthday materials',
                'package_id' => 8,
            ],
            [
                'name' => 'Face painting',
                'package_id' => 8,
            ],
            [
                'name' => 'Customized Cake',
                'package_id' => 8,
            ],
            [
                'name' => 'Ice cream Cart',
                'package_id' => 8,
            ],
            [
                'name' => 'Cotton Candy Cart',
                'package_id' => 8,
            ],
            [
                'name' => 'Sound System',
                'package_id' => 8,
            ],
            [
                'name' => '50 pcs. Invitations',
                'package_id' => 8,
            ],
            // end of Birthday Package
        ];

         /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();


        foreach ($packageTasks as $key => $package) {

            try {

                // Create Category
                $packageObj = PackageTask::create([

                    'name' => $package['name'],
                    'package_id' => $package['package_id'],
                    'creator_id' => 1,
                    'updater_id' => 1
                ]);

                echo $packageObj->name . ' | ';
            } catch (Exception $e) {
                echo 'Duplicate name ' . $package['name'] . ' | ';
            }
        }

        echo "\n";


        /*
        | @End Transaction
        |---------------------------------------------*/
        \DB::commit();
    }
}
