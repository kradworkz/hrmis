<?php

use hrmis\Models\Group;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::firstOrCreate([
            'name' => 'Office of the Regional Director'
        ]);

        Group::firstOrCreate([
            'name' => 'Finance and Administrative Services'
        ]);

        Group::firstOrCreate([
            'name' => 'Technical Operations'
        ]);

        Group::firstOrCreate([
            'name' => 'SETUP'
        ]);

        Group::firstOrCreate([
            'name' => 'RSTL'
        ]);

        Group::firstOrCreate([
            'name' => 'RML'
        ]);

        Group::firstOrCreate([
            'name' => 'MIS'
        ]);
    }
}
