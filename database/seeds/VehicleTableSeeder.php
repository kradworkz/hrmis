<?php

use hrmis\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::firstOrCreate(['plate_number' => 'Van Rental', 'location' => 1, 'group_id' => 1, 'is_active' => 1]);
    }
}
