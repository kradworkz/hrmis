<?php

namespace hrmis\Console\Commands;

use hrmis\Models\Employee;
use hrmis\Models\PushNotification;
use hrmis\Models\PersonalInformation;
use Illuminate\Console\Command;

class NotifyBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $birthdays = PersonalInformation::whereHas('employee', function($query) {
            $query->where('is_active', '=', 1);
        })->where('date_of_birth', '!=', NULL)->get();

        $employees = Employee::where('is_active', '=', 1)->get();

        foreach($birthdays as $birthday) {
            if($birthday->date_of_birth->isBirthday()) {
                foreach($employees as $employee) {
                    PushNotification::create([
                        'employee_id'   => $birthday->employee_id,
                        'date_of_birth' => $birthday->date_of_birth->format('Y-m-d'),
                        'recipient_id'  => $employee->id,
                        'remarks'       => '',
                        'is_read'       => 0,
                    ]);
                }
            }
        }
    }
}
