<?php

use hrmis\Models\EmployeeStatus;
use Illuminate\Database\Seeder;

class EmployeeStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeStatus::firstOrCreate(['name'     => 'Contract of Service']);
        EmployeeStatus::firstOrCreate(['name'     => 'Job Order']);
        EmployeeStatus::firstOrCreate(['name'     => 'Permanent']);
    }
}
