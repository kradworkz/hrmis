<?php

namespace hrmis\Console\Commands;


use hrmis\Models\Employee;
use hrmis\Models\PersonalInformation;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class SetFakeNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Employees table to set fake names.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $faker = Faker::create();
        $employees = Employee::where('is_active', '=', 1)->get();
        $pds = PersonalInformation::get();
        
        foreach($employees as $employee) {
            Employee::where('id', '=', $employee->id)->update([
                'first_name' => $faker->firstName,
                'middle_name' => $faker->randomLetter,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
            ]);
        }

        foreach($pds as $info) {
            PersonalInformation::where('id', '=', $info->id)->update([
                'first_name' => $faker->firstName,
                'middle_name' => $faker->randomLetter,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
            ]);
        }

        echo "Employees table name successfully updated.";
    }
}
