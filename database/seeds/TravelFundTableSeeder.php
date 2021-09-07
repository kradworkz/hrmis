<?php

use hrmis\Models\TravelFund;
use Illuminate\Database\Seeder;

class TravelFundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TravelFund::firstOrCreate(['name'     => 'General Funds']);
        TravelFund::firstOrCreate(['name'     => 'Project Funds']);
        TravelFund::firstOrCreate(['name'     => 'Others']);
    }
}
