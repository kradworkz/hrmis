<?php

use hrmis\Models\Module;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::firstOrCreate(['name'     => 'Vehicle Reservation', 'model_name' => 'Reservation']);
        Module::firstOrCreate(['name'     => 'Travel Order', 'model_name' => 'Travel']);
        Module::firstOrCreate(['name'     => 'Offset', 'model_name' => 'Offset']);
        Module::firstOrCreate(['name'     => 'Overtime Request', 'model_name' => 'OvertimeRequest']);
        Module::firstOrCreate(['name'     => 'Attendance', 'model_name' => 'Attendance']);
        Module::firstOrCreate(['name'     => 'Leave', 'model_name' => 'Leave']);
        Module::firstOrCreate(['name'     => 'Health Check', 'model_name' => 'EmployeeQuarantine']);
    }
}