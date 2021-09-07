<?php

use hrmis\Models\TravelExpense;
use Illuminate\Database\Seeder;

class TravelExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TravelExpense::firstOrCreate(['name'     => 'Accomodation']);
        TravelExpense::firstOrCreate(['name'     => 'Meals/Food']);
        TravelExpense::firstOrCreate(['name'     => 'Incidental Expenses']);
        TravelExpense::firstOrCreate(['name'     => 'Accomodation']);
        TravelExpense::firstOrCreate(['name'     => 'Subsistence']);
        TravelExpense::firstOrCreate(['name'     => 'Incidental Expenses']);
    }
}