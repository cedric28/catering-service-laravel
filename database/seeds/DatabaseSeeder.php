<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo "\n";
        echo "/*---------------------------------------------- \n";
        echo "| @Populating Data! \n";
        echo "|----------------------------------------------*/ \n";

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(MainPackageSeeder::class);
        $this->call(InventoryCategorySeeder::class);
        $this->call(DishCategorySeeder::class);
        $this->call(PaymentStatusSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(PackageEquipmentsSeeder::class);
        $this->call(PackageTaskSeeder::class);
        $this->call(PackageOtherSeeder::class);
        $this->call(PackageMenuSeeder::class);
        $this->call(FoodsSeeder::class);
    }
}
