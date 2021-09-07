<?php

use hrmis\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'Superuser']);
        Role::firstOrCreate(['name' => 'Administrator']);
        Role::firstOrCreate(['name' => 'Regional Director']);
        Role::firstOrCreate(['name' => 'Assistant Regional Director']);
        Role::firstOrCreate(['name' => 'Provincial Director']);
        Role::firstOrCreate(['name' => 'Division Head']);
        Role::firstOrCreate(['name' => 'Division Assistant']);
        Role::firstOrCreate(['name' => 'Staff']);
        Role::firstOrCreate(['name' => 'Human Resource']);
        Role::firstOrCreate(['name' => 'Health Officer']);
    }
}