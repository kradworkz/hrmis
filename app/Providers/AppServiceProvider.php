<?php

namespace hrmis\Providers;

use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Leave;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Attendance;
use hrmis\Models\Reservation;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\OvertimeRequest;
use hrmis\Models\PushNotification;
use hrmis\Models\EmployeeQuarantine;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            
            $birthdays              = 0;
            $greetings              = 0;
            $bday_count             = 0;
            $total                  = 0;
            $dtr                    = 0;
            $reservations           = 0;
            $travels                = 0;
            $leave                  = 0;
            $offset                 = 0;
            $overtime               = 0;
            $quarantine             = 0;

            if(Auth::check()) {
                $birthdays  = PushNotification::where('type', '=', 1)->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->where('recipient_id', '=', Auth::id())->where('is_read', '-', 0)->groupBy('employee_id')->get();
                $greetings  = PushNotification::where('type', '=', 1)->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->where('remarks', '!=', "")->whereYear('updated_at', date('Y'))->get();
                $bday_count = PushNotification::where('type', '=', 1)->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->groupBy('employee_id')->get();

                if(Auth::user()->is_hr()) {
                    $dtr            = Attendance::withoutGlobalScopes()->changed()->where('status', '=', 0)->count();
                    $total += $dtr;
                }
                if(Auth::user()->reservation_signatory) {
                    $data           = $this->getSignatory(1, 'reservation_signatory');
                    $reservations   = Reservation::location()->signatory($data[1])->signature(0, $data[0])->approved()->active()->orderBy('created_at', 'desc')->count();
                    $total += $reservations;
                }
                elseif(Auth::user()->is_assistant()) {
                    $reservations   = Reservation::whereHas('vehicle', function($vehicle) {
                                        $vehicle->where('location', '=', 1);
                                    })->where('is_active', '=', 1)->where('status', '=', 0)->recent()->count();
                    $total += $reservations;
                }
                elseif(Auth::user()->is_health_officer()) {
                    $reservations   = Reservation::whereDate('start_date', '>', '2020-06-07')->where('is_active', '=', 1)->where('check', '=', 0)->count();
                    $total += $reservations;
                }
                if(Auth::user()->leave_signatory) {
                    $data           = $this->getSignatory(6, 'leave_signatory');
                    $leave          = Leave::where('employee_id', '!=', Auth::id())->signature(0, $data[0])->signatory($data[1], $data[0])->orderBy('created_at', 'desc')->count();
                    $total += $leave;
                }
                if(Auth::user()->travel_signatory) {
                    $data           = $this->getSignatory(2, 'travel_signatory');
                    $travels        = Travel::where('employee_id', '!=', Auth::id())->signatory($data[1], $data[0])->signature(0, $data[0])->active()->recent()->orderBy('created_at', 'desc')->count();
                    $total += $travels;
                }
                if(Auth::user()->offset_signatory) {
                    $data           = $this->getSignatory(3, 'offset_signatory');
                    $offset         = Offset::where('employee_id', '!=', Auth::id())->signatory($data[1], $data[0])->signature(0, $data[0])->active()->recent()->orderBy('created_at', 'desc')->count();
                    $total += $offset;
                }
                if(Auth::user()->overtime_signatory) {
                    $data           = $this->getSignatory(3, 'overtime_signatory');
                    $overtime       = OvertimeRequest::where('employee_id', '!=', Auth::id())->signatory($data[1], $data[0])->signature(0, $data[0])->active()->orderBy('created_at', 'desc')->count();
                    $total += $overtime;
                }
                if(Auth::user()->health_signatory) {
                    $data           = $this->getSignatory(7, 'health_signatory');
                    $quarantine     = EmployeeQuarantine::where('employee_id', '!=', Auth::id())->whereIn('unit_id', $data[1])->signature(0, $data[0])->active()->orderBy('created_at', 'desc')->count();
                    $total += $quarantine;
                }
            }

            $view->with('total_approvals', $total)
                 ->with('pending_attendance', $dtr)
                 ->with('pending_reservations', $reservations)
                 ->with('pending_travels', $travels)
                 ->with('pending_leave', $leave)
                 ->with('pending_offset', $offset)
                 ->with('pending_overtime', $overtime)
                 ->with('birthdays', $birthdays)
                 ->with('bday_count', $bday_count)
                 ->with('employee_quarantine', $quarantine)
                 ->with('greetings', $greetings);
        });
    }

    public function getSignatory($module_id, $module_name)
    {
        $signatory      = Auth::user()->$module_name != null ? Auth::user()->$module_name->signatory : null;
        $signatories    = SignatoryGroup::whereHas('signatory', function($signatories) use($module_id) {
            $signatories->where('module_id', '=', $module_id)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');
        return array($signatory, $signatories);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('app.env') == 'production') {
            \URL::forceScheme('https');
        }
        else {
            \URL::forceScheme('http');
        }
    }
}