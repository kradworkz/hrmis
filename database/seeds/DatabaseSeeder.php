<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(EmployeeStatusTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(VehicleTableSeeder::class);
        $this->call(TravelFundTableSeeder::class);
        $this->call(TravelExpenseTableSeeder::class);
    }
}