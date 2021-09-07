<?php

namespace hrmis\Console\Commands;

use Validator;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeRole;
use Illuminate\Console\Command;

class CreateSuperuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superuser
                            {--force : force to create another superuser.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a superuser account.';

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

    protected function validateInput(string $attribute, string $validation, $value)
    {
        if(!is_array($value) && !is_bool($value) && 0 === strlen($value)) {
            throw new \Exception('A value is required.');
        }

        $validator = Validator::make([
            $attribute => $value
        ], [
            $attribute => $validation
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first($attribute));
        }

        return $value;
    }

    public function askWithValidation($question, $default = null, $validator = null)
    {
        return $this->output->ask($question, $default, $validator);
    }

    public function username()
    {
        return $this->askWithValidation('Username', null, function ($value) {
            return $this->validateInput('username', 'unique:employees', $value);
        });
    }

    public function handle()
    {
        $superuser = Employee::whereHas('roles', function($role) {
            $role->where('role_id', '=', '1');
        })->first();

        if($superuser == null) {
            $this->info("Creating superuser account.\n");
            $user_data = array(
                'first_name'            => $this->ask('First Name'),
                'middle_name'           => $this->ask('Middle Name'),
                'last_name'             => $this->ask('Last Name'),
                'designation'           => $this->ask('Designation'),
                'username'              => $this->username(),
                'password'              => $this->secret('Password'),
                'unit_id'               => 1,
                'employee_status_id'    => 3,
            );

            $superuser = Employee::create($user_data);
            $superuser->employee_roles()->create([
                'employee_id'   => $superuser->id,
                'role_id'       => 1,
            ]);
            $superuser->employee_groups()->create([
                'employee_id'   => $superuser->id,
                'group_id'      => 7,
                'is_primary'    => 1,
            ]);
            
            if($superuser) {
                $this->info('Superuser successfully registered.');
            }
        }
        else {
            if($this->option('force')) {
                $this->info("Creating superuser account.\n");
                $user_data = array(
                    'first_name'            => $this->ask('First Name'),
                    'middle_name'           => $this->ask('Middle Name'),
                    'last_name'             => $this->ask('Last Name'),
                    'designation'           => $this->ask('Designation'),
                    'username'              => $this->username(),
                    'password'              => $this->secret('Password'),
                    'employee_status_id'    => 3,
                );

                $superuser = Employee::create($user_data);
                $superuser->employee_roles()->create([
                    'employee_id'   => $superuser->id,
                    'role_id'       => 1,
                ]);
                $superuser->employee_groups()->create([
                    'employee_id'   => $superuser->id,
                    'group_id'      => 12,
                    'is_primary'    => 1,
                ]);
                
                if($superuser) {
                    $this->info('Superuser successfully registered.');
                }
            }
            else {
                $this->error("Superuser account already exists. Aborting.");
            }
        }
    }
}
