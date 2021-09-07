<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function() {
	return redirect()->route('login');
});

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function() {

	Route::view('/qrcodes', 'qrcodes.index');

	// Dashboard Routes
	Route::get('dashboard', 'Dashboard\DashboardController@index')->name('Dashboard');
	Route::get('dashboard/reservation/{id}', 'Dashboard\DashboardController@reservation')->name('View Dashboard Vehicle Reservation');
	Route::get('dashboard/travel/{id}', 'Dashboard\DashboardController@travel')->name('View Dashboard Travel Order');

	// Whereabouts Routes
	Route::get('whereabouts', 'Whereabouts\WhereaboutController@index')->name('Whereabouts');

	// Vehicles Routes
	Route::get('calendar/vehicles', 'Calendar\CalendarController@vehicle_index')->name('Vehicle Calendar');
	Route::get('calendar/vehicles/view/{id}/{date}', 'Calendar\CalendarController@vehicle_schedule')->name('View Vehicle Schedule');
	Route::get('calendar/offset', 'Calendar\CalendarController@offset_index')->name('Offset Calendar');
	Route::get('calendar/travels', 'Calendar\CalendarController@travel_index')->name('Travel Calendar');
	
	// Profile Routes
	Route::get('profile/info', 'Profile\ProfileController@index')->name('Profile');
	Route::get('profile/submit', 'Profile\ProfileController@submit')->name('Submit Profile');
	Route::post('profile/submit', 'Profile\ProfileController@submit')->name('Submit Profile');

	Route::group(['middleware' => 'throttle:1,60'], function() {
		Route::get('profile/enroll/{id}', 'Profile\ProfileController@enroll_qrcode')->name('Profile Enroll');
	});

	// Job Contract Routes
	Route::get('profile/contract', 'Profile\JobContractController@index')->name('Job Contract');
	Route::get('profile/contract/new', 'Profile\JobContractController@new')->name('New Job Contract');
	Route::get('profile/contract/edit/{id}', 'Profile\JobContractController@edit')->name('Edit Job Contract');
	Route::get('profile/contract/delete/{id}', 'Profile\JobContractController@delete')->name('Delete Job Contract');
	Route::get('profile/contract/submit/{id}', 'Profile\JobContractController@submit')->name('Submit Job Contract');
	Route::post('profile/contract/submit/{id}', 'Profile\JobContractController@submit')->name('Submit Job Contract');

	// Health Declaration Routes
	Route::get('profile/health', 'Profile\HealthDeclarationController@index')->name('Health Declaration');
	Route::get('profile/health/submit/{id}', 'Profile\HealthDeclarationController@submit')->name('Update Health Declaration Form');
	Route::post('profile/health/submit/{id}', 'Profile\HealthDeclarationController@submit')->name('Update Health Declaration Form');

	// Home Quarantine Routes
	Route::get('profile/quarantine', 'Profile\HomeQuarantineController@index')->name('Home Quarantine');
	Route::get('profile/quarantine/view/{id}', 'Profile\HomeQuarantineController@view')->name('View Home Quarantine');
	Route::get('profile/quarantine/submit/{id}', 'Profile\HomeQuarantineController@submit')->name('Submit Medical Certificate');
	Route::post('profile/quarantine/submit/{id}', 'Profile\HomeQuarantineController@submit')->name('Submit Medical Certificate');
	
	// DTR Routes
	Route::get('profile/dtr', 'Profile\DTRController@index')->name('Daily Time Record');
	Route::get('profile/dtr/new', 'Profile\DTRController@new')->name('New Daily Time Record');
	Route::get('profile/dtr/view/{id}', 'Profile\DTRController@view')->name('View Daily Time Record');
	Route::get('profile/dtr/edit/{id}', 'Profile\DTRController@edit')->name('Edit Daily Time Record');
	Route::get('profile/dtr/delete/{id}', 'Profile\DTRController@delete')->name('Delete Daily Time Record');
	Route::get('profile/dtr/submit/{id}', 'Profile\DTRController@submit')->name('Submit Daily Time Record');
	Route::post('profile/dtr/submit/{id}', 'Profile\DTRController@submit')->name('Submit Daily Time Record');
	Route::get('profile/dtr/search/{date}', 'Profile\DTRController@search')->name('Search Daily Time Record');

	// DTR Override Routes
	Route::get('profile/override', 'Profile\DTROverrideController@index')->name('DTR Override');
	
	// Reservation Routes
	Route::get('profile/reservations', 'Profile\ReservationController@index')->name('Vehicle Reservation');
	Route::get('profile/reservations/new', 'Profile\ReservationController@new')->name('New Reservation');
	Route::get('profile/reservations/edit/{id}', 'Profile\ReservationController@edit')->name('Edit Reservation');
	Route::get('profile/reservations/view/{id}', 'Profile\ReservationController@view')->name('View Reservation');
	Route::get('profile/reservations/status/{id}', 'Profile\ReservationController@status')->name('View Reservation Status');
	Route::get('profile/reservations/tag/{id}/{employee_id?}', 'Profile\ReservationController@tag')->name('Remove Reservation Tag');
	Route::get('profile/reservations/delete/{id}', 'Profile\ReservationController@delete')->name('Delete Reservation');
	Route::get('profile/reservations/submit/{id}', 'Profile\ReservationController@submit')->name('Submit Reservation');
	Route::post('profile/reservations/submit/{id}', 'Profile\ReservationController@submit')->name('Submit Reservation');
	Route::get('profile/reservations/vehicles', 'Profile\ReservationController@vehicles')->name('Get Vehicles');
	
	// Travel Routes
	Route::get('profile/travels', 'Profile\TravelController@index')->name('Travel Order');
	Route::get('profile/travels/new', 'Profile\TravelController@new')->name('New Travel');
	Route::get('profile/travels/edit/{id}', 'Profile\TravelController@edit')->name('Edit Travel Order');
	Route::get('profile/travels/view/{id}', 'Profile\TravelController@view')->name('View Travel Order');
	Route::get('profile/travels/status/{id}', 'Profile\TravelController@status')->name('View Travel Order Status');
	Route::get('profile/travels/tag/{id}/{employee_id?}', 'Profile\TravelController@tag')->name('Remove Travel Tag');
	Route::get('profile/travels/delete/{id}', 'Profile\TravelController@delete')->name('Delete Travel Order');
	Route::get('profile/travels/submit/{id}', 'Profile\TravelController@submit')->name('Submit Travel Order');
	Route::post('profile/travels/submit/{id}', 'Profile\TravelController@submit')->name('Submit Travel Order');

	// Offset Routes
	Route::get('profile/offset', 'Profile\OffsetController@index')->name('Offset');
	Route::get('profile/offset/new', 'Profile\OffsetController@new')->name('New Offset');
	Route::get('profile/offset/edit/{id}', 'Profile\OffsetController@edit')->name('Edit Offset');
	Route::get('profile/offset/view/{id}', 'Profile\OffsetController@view')->name('View Offset');
	Route::get('profile/offset/status/{id}', 'Profile\OffsetController@status')->name('View Offset Status');
	Route::get('profile/offset/cancel/{id}', 'Profile\OffsetController@cancel')->name('Cancel Offset');
	Route::get('profile/offset/submit/{id}', 'Profile\OffsetController@submit')->name('Submit Offset');
	Route::post('profile/offset/submit/{id}', 'Profile\OffsetController@submit')->name('Submit Offset');

	// Leave Routes
	Route::get('profile/leave', 'Profile\LeaveController@index')->name('Leave');
	Route::get('profile/leave/new', 'Profile\LeaveController@new')->name('New Leave');
	Route::get('profile/leave/edit/{id}', 'Profile\LeaveController@edit')->name('Edit Leave');
	Route::get('profile/leave/view/{id}', 'Profile\LeaveController@view')->name('View Leave');
	Route::get('profile/leave/delete/{id}', 'Profile\LeaveController@delete')->name('Delete Leave');
	Route::get('profile/leave/submit/{id}', 'Profile\LeaveController@submit')->name('Submit Leave');
	Route::post('profile/leave/submit/{id}', 'Profile\LeaveController@submit')->name('Submit Leave');

	// Overtime Request Routes
	Route::get('profile/overtime', 'Profile\OvertimeRequestController@index')->name('Overtime Request');
	Route::get('profile/overtime/new', 'Profile\OvertimeRequestController@new')->name('New Overtime Request');
	Route::get('profile/overtime/edit/{id}', 'Profile\OvertimeRequestController@edit')->name('Edit Overtime Request');
	Route::get('profile/overtime/view/{id}', 'Profile\OvertimeRequestController@view')->name('View Overtime Request');
	Route::get('profile/overtime/pdf/{id}', 'Profile\OvertimeRequestController@status')->name('View Overtime Request Status');
	Route::get('profile/overtime/tag/{id}/{employee_id?}', 'Profile\OvertimeRequestController@tag')->name('Remove Overtime Request Tag');
	Route::get('profile/overtime/delete/{id}', 'Profile\OvertimeRequestController@delete')->name('Delete Overtime Request');
	Route::get('profile/overtime/submit/{id}', 'Profile\OvertimeRequestController@submit')->name('Submit Overtime Request');
	Route::post('profile/overtime/submit/{id}', 'Profile\OvertimeRequestController@submit')->name('Submit Overtime Request');

	// Profile COC Routes
	Route::get('profile/coc', 'Profile\CompensatoryOvertimeController@index')->name('Compensatory Overtime Credit');

	// Approval Routes
	Route::get('approval/list/{module_id}', 'Approval\ApprovalController@index')->name('Approval');
	Route::post('approval/list/{module_id}', 'Approval\ApprovalController@index')->name('Approval');

	// Reservation Approval Routes
	Route::get('approval/vehicles', 'Approval\VehicleApprovalController@index')->name('Vehicle Approval');
	Route::get('approval/vehicles/new', 'Approval\VehicleApprovalController@new')->name('New Vehicle Reservation');
	Route::get('approval/vehicles/edit/{id}', 'Approval\VehicleApprovalController@edit')->name('Edit Reservation Approval');
	Route::get('approval/vehicles/view/{id}', 'Approval\VehicleApprovalController@view')->name('View Reservation Approval');
	Route::get('approval/vehicles/submit/{id}', 'Approval\VehicleApprovalController@submit')->name('Submit Vehicle Approval');
	Route::post('approval/vehicles/submit/{id}', 'Approval\VehicleApprovalController@submit')->name('Submit Vehicle Approval');

	// Health Check Approval Routes
	Route::get('approval/health', 'Approval\HealthApprovalController@index')->name('Health Check Approval');
	Route::get('approval/health/edit/{id}', 'Approval\HealthApprovalController@edit')->name('Edit Health Check Approval');
	Route::get('approval/health/view/{id}', 'Approval\HealthApprovalController@view')->name('View Health Check Approval');
	Route::get('approval/health/submit/{id}', 'Approval\HealthApprovalController@submit')->name('Submit Health Check Approval');
	Route::post('approval/health/submit/{id}', 'Approval\HealthApprovalController@submit')->name('Submit Health Check Approval');


	// Birthday Routes
	Route::get('birthdays', 'Birthdays\BirthdayController@index')->name('Birthdays');
	
	// Employee Health Check Routes
	Route::get('health/submit/{id}', 'Dashboard\DashboardController@submit_health_check')->name('Submit Health Check');
	Route::post('health/submit/{id}', 'Dashboard\DashboardController@submit_health_check')->name('Submit Health Check');

	Route::group(['middleware' => 'throttle:1,1'], function() {
		Route::get('desktop/{id}/{location?}', 'api_UsersController@desktop_time_in')->name('Desktop Time In');
		Route::post('desktop/{id}/{location?}', 'api_UsersController@desktop_time_in')->name('Desktop Time In');
		Route::get('dashboard/out/{id}', 'Dashboard\DashboardController@time_out')->name('Dashboard Time Out');
		// Route::post('dashboard/out/{id}', 'Dashboard\DashboardController@time_out')->name('Dashboard Time Out');
	});

	Route::get('records', 'RecordController@index')->name('Records List');

	// Get Client IP
	Route::get('/client/ip', function() {
		return getIp();	
	});

	Route::group(['middleware' => ['signatory']], function() {

		// Travel Approval Routes
		Route::get('approval/travels', 'Approval\TravelApprovalController@index')->name('Travel Approval');
		Route::get('approval/travels/edit/{id}', 'Approval\TravelApprovalController@edit')->name('Edit Travel Approval');
		Route::get('approval/travels/view/{id}', 'Approval\TravelApprovalController@view')->name('View Travel Approval');
		Route::get('approval/travels/submit/{id}', 'Approval\TravelApprovalController@submit')->name('Submit Travel Approval');
		Route::post('approval/travels/submit/{id}', 'Approval\TravelApprovalController@submit')->name('Submit Travel Approval');

		// Leave Approval Routes
		Route::get('approval/leave', 'Approval\LeaveApprovalController@index')->name('Leave Approval');
		Route::get('approval/leave/edit/{id}', 'Approval\LeaveApprovalController@edit')->name('Edit Leave Approval');
		Route::get('approval/leave/view/{id}', 'Approval\LeaveApprovalController@view')->name('View Leave Approval');
		Route::get('approval/leave/submit/{id}', 'Approval\LeaveApprovalController@submit')->name('Submit Leave Approval');
		Route::post('approval/leave/submit/{id}', 'Approval\LeaveApprovalController@submit')->name('Submit Leave Approval');

		// Offset Approval Routes
		Route::get('approval/offset', 'Approval\OffsetApprovalController@index')->name('Offset Approval');
		Route::get('approval/offset/edit/{id}', 'Approval\OffsetApprovalController@edit')->name('Edit Offset Approval');
		Route::get('approval/offset/view/{id}', 'Approval\OffsetApprovalController@view')->name('View Offset Approval');
		Route::get('approval/offset/submit/{id}', 'Approval\OffsetApprovalController@submit')->name('Submit Offset Approval');
		Route::post('approval/offset/submit/{id}', 'Approval\OffsetApprovalController@submit')->name('Submit Offset Approval');

		// Overtime Approval Routes
		Route::get('approval/overtime', 'Approval\OvertimeApprovalController@index')->name('Overtime Approval');
		Route::get('approval/overtime/edit/{id}', 'Approval\OvertimeApprovalController@edit')->name('Edit Overtime Approval');
		Route::get('approval/overtime/view/{id}', 'Approval\OvertimeApprovalController@view')->name('View Overtime Approval');
		Route::get('approval/overtime/submit/{id}', 'Approval\OvertimeApprovalController@submit')->name('Submit Overtime Approval');
		Route::post('approval/overtime/submit/{id}', 'Approval\OvertimeApprovalController@submit')->name('Submit Overtime Approval');

		// DTR Approval Routes
		Route::get('approval/dtr', 'Approval\DTRApprovalController@index')->name('DTR Approval');
		Route::get('approval/dtr/new', 'Approval\DTRApprovalController@new')->name('New DTR');
		Route::get('approval/dtr/edit/{id}', 'Approval\DTRApprovalController@edit')->name('Edit DTR Approval');
		Route::get('approval/dtr/view/{id}', 'Approval\DTRApprovalController@view')->name('View DTR Approval');
		Route::get('approval/dtr/delete/{id}', 'Approval\DTRApprovalController@delete')->name('Delete DTR Approval');
		Route::get('approval/dtr/submit/{id}', 'Approval\DTRApprovalController@submit')->name('Submit DTR Approval');
		Route::get('approval/dtr/approve/{id}/{action}', 'Approval\DTRApprovalController@approve')->name('Approve DTR');
		Route::post('approval/dtr/submit/{id}', 'Approval\DTRApprovalController@submit')->name('Submit DTR Approval');

		// Employee Quarantine Approval Routes
		Route::get('approval/quarantine', 'Approval\QuarantineApprovalController@index')->name('Employee Quarantine Approval');
		Route::get('approval/quarantine/view/{id}', 'Approval\QuarantineApprovalController@view')->name('View Employee Quarantine');
		Route::get('approval/quarantine/edit/{id}', 'Approval\QuarantineApprovalController@edit')->name('Edit Employee Quarantine');
		Route::get('approval/quarantine/done/{id}', 'Approval\QuarantineApprovalController@done')->name('Remove Employee Quarantine');
		Route::get('approval/quarantine/submit/{id}', 'Approval\QuarantineApprovalController@submit')->name('Submit Employee Quarantine Approval');
		Route::post('approval/quarantine/submit/{id}', 'Approval\QuarantineApprovalController@submit')->name('Submit Employee Quarantine Approval');

	});
	
	Route::group(['middleware' => ['su']], function() {

		// Log Routes
		Route::get('settings/logs', 'Settings\LogController@index')->name('Logs');

		// Group Routes
		Route::get('settings/groups', 'Settings\GroupController@index')->name('Groups');
		Route::get('settings/groups/new', 'Settings\GroupController@new')->name('New Group');
		Route::get('settings/groups/edit/{id}', 'Settings\GroupController@edit')->name('Edit Group');
		Route::post('settings/groups/submit/{id}', 'Settings\GroupController@submit')->name('Submit Group');

		// Vehicle Routes
		Route::get('settings/vehicles', 'Settings\VehicleController@index')->name('Vehicles');
		Route::get('settings/vehicles/new', 'Settings\VehicleController@new')->name('New Vehicle');
		Route::get('settings/vehicles/edit/{id}', 'Settings\VehicleController@edit')->name('Edit Vehicle');
		Route::post('settings/vehicles/submit/{id}', 'Settings\VehicleController@submit')->name('Submit Vehicle');

		// Module Routes
		Route::get('settings/modules', 'Settings\ModuleController@index')->name('Modules');
		Route::get('settings/modules/edit/{id}', 'Settings\ModuleController@edit')->name('Edit Module');
		Route::post('settings/modules/submit/{id}', 'Settings\ModuleController@submit')->name('Submit Module');

		// Signatory Routes
		Route::get('settings/signatory', 'Settings\SignatoryController@index')->name('Signatory');
		Route::get('settings/signatory/new', 'Settings\SignatoryController@new')->name('New Signatory');
		Route::get('settings/signatory/edit/{id}', 'Settings\SignatoryController@edit')->name('Edit Signatory');
		Route::post('settings/signatory/submit/{id}', 'Settings\SignatoryController@submit')->name('Submit Signatory');

	});

	Route::group(['middleware' => ['hr']], function() {

		// Employee Routes
		Route::get('employees', 'HR\Employees\EmployeeController@index')->name('Employees');
		Route::get('employees/new', 'HR\Employees\EmployeeController@new')->name('New Employee');
		Route::get('employees/submit/{id}', 'HR\Employees\EmployeeController@submit')->name('Save Employee');
		Route::post('employees/submit/{id}', 'HR\Employees\EmployeeController@submit')->name('Save Employee');

		// Employee Profile Routes
		Route::get('employees/profile/{id}', 'HR\Employees\EmployeeProfileController@index')->name('View Employee Profile');
		Route::post('employees/profile/submit/{id}', 'HR\Employees\EmployeeProfileController@submit')->name('Update Employee Profile');
		Route::get('employees/profile/submit/{id}', 'HR\Employees\EmployeeProfileController@submit')->name('Update Employee Profile');
		Route::get('employees/profile/reset/{id}', 'HR\Employees\EmployeeProfileController@reset')->name('Reset Employee Password');
		
		// Employee Attendance Routes
		Route::get('employees/attendance/{id}', 'HR\Employees\EmployeeAttendanceController@index')->name('View Employee Attendance');
		Route::get('employees/attendance/new/{id}', 'HR\Employees\EmployeeAttendanceController@new')->name('New Employee Attendance');
		Route::get('employees/attendance/edit/{employee_id}/{dtr_id}', 'HR\Employees\EmployeeAttendanceController@edit')->name('Edit Employee Attendance');
		Route::get('employees/attendance/delete/{id}', 'HR\Employees\EmployeeAttendanceController@delete')->name('Delete Employee Attendance');
		Route::get('employees/attendance/submit/{id}', 'HR\Employees\EmployeeAttendanceController@submit')->name('Submit Employee Attendance');
		Route::post('employees/attendance/submit/{id}', 'HR\Employees\EmployeeAttendanceController@submit')->name('Submit Employee Attendance');

		// Employee Schedule Routes
		Route::get('employees/schedule/{id}', 'HR\Employees\EmployeeScheduleController@index')->name('View Employee Schedule');
		Route::get('employees/schedule/new/{id}', 'HR\Employees\EmployeeScheduleController@new')->name('New Employee Schedule');
		Route::get('employees/schedule/edit/{employee_id}/{schedule_id}', 'HR\Employees\EmployeeScheduleController@edit')->name('Edit Employee Schedule');
		Route::get('employees/schedule/delete/{id}', 'HR\Employees\EmployeeScheduleController@delete')->name('Delete Employee Schedule');
		Route::get('employees/schedule/submit/{id}', 'HR\Employees\EmployeeScheduleController@submit')->name('Submit Employee Schedule');
		Route::post('employees/schedule/submit/{id}', 'HR\Employees\EmployeeScheduleController@submit')->name('Submit Employee Schedule');

		// Employee Reservation Routes
		Route::get('employees/reservations/{id}', 'HR\Employees\EmployeeReservationController@index')->name('View Employee Reservation');

		// Employee Travel Routes
		Route::get('employees/travels/{id}', 'HR\Employees\EmployeeTravelController@index')->name('View Employee Travel');

		// Employee Offset Routes
		Route::get('employees/offset/{id}', 'HR\Employees\EmployeeOffsetController@index')->name('View Employee Offset');

		// Employee Overtime Routes
		Route::get('employees/overtime/{id}', 'HR\Employees\EmployeeOvertimeController@index')->name('View Employee Overtime Request');

		// Employee COC Routes
		Route::get('employees/coc/{id}', 'HR\Employees\EmployeeCOCController@index')->name('View Employee COC');
		Route::get('employees/coc/new/{id}', 'HR\Employees\EmployeeCOCController@new')->name('New Employee COC');
		Route::get('employees/coc/edit/{employee_id}/{schedule_id}', 'HR\Employees\EmployeeCOCController@edit')->name('Edit Employee COC');
		Route::get('employees/coc/delete/{id}', 'HR\Employees\EmployeeCOCController@delete')->name('Delete Employee COC');
		Route::get('employees/coc/submit/{id}', 'HR\Employees\EmployeeCOCController@submit')->name('Submit Employee COC');
		Route::post('employees/coc/submit/{employee_id}/{id}', 'HR\Employees\EmployeeCOCController@submit')->name('Submit Employee COC');

		// Employee Leave Credit Routes
		Route::get('employees/credits/{id}', 'HR\Employees\EmployeeCreditController@index')->name('Employee Leave Credit');
		Route::get('employees/credits/new/{id}', 'HR\Employees\EmployeeCreditController@new')->name('New Employee Leave Credit');
		Route::get('employees/credits/edit/{employee_id}/{credit_id}', 'HR\Employees\EmployeeCreditController@edit')->name('Edit Employee Leave Credit');
		Route::get('employees/credits/delete/{id}', 'HR\Employees\EmployeeCreditController@delete')->name('Delete Employee Leave Credit');
		Route::get('employees/credits/submit/{id}', 'HR\Employees\EmployeeCreditController@submit')->name('Submit Employee Leave Credit');
		Route::post('employees/credits/submit/{id}', 'HR\Employees\EmployeeCreditController@submit')->name('Submit Employee Leave Credit');

		// COC Routes
		Route::get('coc', 'HR\CompensatoryOvertimeController@index')->name('COC Listings');

		// Employee Travel Routes
		Route::get('travels', 'HR\TravelController@index')->name('Employee Travel Orders');

		// Employee Reservation Routes
		Route::get('reservations', 'HR\ReservationController@index')->name('Employee Vehicle Reservations');

		// Employee DTR Routes
		Route::get('dtr', 'HR\Employees\EmployeeDTRController@index')->name('Employee DTR');

		// Employee Job Contract Routes
		Route::get('contract', 'HR\ContractController@index')->name('Employee Job Contract');

		// Report Routes
		Route::get('report', 'Reports\ReportController@index')->name('Approval Report');
	});

	Route::group(['middleware' => ['pds']], function() {

		// Personal Information Routes
		Route::get('employees/pds/info/{id}', 'HR\Employees\PDS\PersonalInformationController@index')->name('Personal Information');
		Route::get('employees/pds/info/submit/{id}', 'HR\Employees\PDS\PersonalInformationController@submit')->name('Submit Personal Information');
		Route::post('employees/pds/info/submit/{id}', 'HR\Employees\PDS\PersonalInformationController@submit')->name('Submit Personal Information');

		// Family Background Routes
		Route::get('employees/pds/family/{id}', 'HR\Employees\PDS\FamilyBackgroundController@index')->name('Family Background');
		Route::get('employees/pds/family/submit/{id}', 'HR\Employees\PDS\FamilyBackgroundController@submit')->name('Submit Family Background');
		Route::post('employees/pds/family/submit/{id}', 'HR\Employees\PDS\FamilyBackgroundController@submit')->name('Submit Family Background');

		// Family Child Routes
		Route::get('employees/pds/family/child/new/{id}/{employee_id}', 'HR\Employees\PDS\FamilyBackgroundController@new')->name('New Child');
		Route::get('employees/pds/family/child/edit/{id}/{employee_id}', 'HR\Employees\PDS\FamilyBackgroundController@edit')->name('Edit Child');
		Route::get('employees/pds/family/child/delete/{id}', 'HR\Employees\PDS\FamilyBackgroundController@delete')->name('Delete Child');
		Route::get('employees/pds/family/child/submit/{id}', 'HR\Employees\PDS\FamilyBackgroundController@new')->name('Submit Child');
		Route::post('employees/pds/family/child/submit/{id}', 'HR\Employees\PDS\FamilyBackgroundController@child_submit')->name('Submit Child');

		// Educational Background Routes
		Route::get('employees/pds/education/{id}', 'HR\Employees\PDS\EducationalBackgroundController@index')->name('Educational Background');
		Route::get('employees/pds/education/new/{id}/{employee_id}', 'HR\Employees\PDS\EducationalBackgroundController@new')->name('New Educational Background');
		Route::get('employees/pds/education/edit/{id}/{employee_id}', 'HR\Employees\PDS\EducationalBackgroundController@edit')->name('Edit Educational Background');
		Route::get('employees/pds/education/delete/{id}', 'HR\Employees\PDS\EducationalBackgroundController@delete')->name('Delete Educational Background');
		Route::get('employees/pds/education/submit/{id}', 'HR\Employees\PDS\EducationalBackgroundController@submit')->name('Submit Educational Background');
		Route::post('employees/pds/education/submit/{id}', 'HR\Employees\PDS\EducationalBackgroundController@submit')->name('Submit Educational Background');

		// Civil Service Eligibility Routes
		Route::get('employees/pds/eligibility/{id}', 'HR\Employees\PDS\EligibilityController@index')->name('Civil Service Eligibility');
		Route::get('employees/pds/eligibility/new/{id}/{employee_id}', 'HR\Employees\PDS\EligibilityController@new')->name('New Civil Service Eligibility');
		Route::get('employees/pds/eligibility/edit/{id}/{employee_id}', 'HR\Employees\PDS\EligibilityController@edit')->name('Edit Civil Service Eligibility');
		Route::get('employees/pds/eligibility/delete/{id}', 'HR\Employees\PDS\EligibilityController@delete')->name('Delete Civil Service Eligibility');
		Route::get('employees/pds/eligibility/submit/{id}', 'HR\Employees\PDS\EligibilityController@submit')->name('Submit Civil Service Eligibility');
		Route::post('employees/pds/eligibility/submit/{id}', 'HR\Employees\PDS\EligibilityController@submit')->name('Submit Civil Service Eligibility');

		// Work Experience Routes
		Route::get('employees/pds/experience/{id}', 'HR\Employees\PDS\WorkExperienceController@index')->name('Work Experience');
		Route::get('employees/pds/experience/new/{id}/{employee_id}', 'HR\Employees\PDS\WorkExperienceController@new')->name('New Work Experience');
		Route::get('employees/pds/experience/edit/{id}/{employee_id}', 'HR\Employees\PDS\WorkExperienceController@edit')->name('Edit Work Experience');
		Route::get('employees/pds/experience/delete/{id}', 'HR\Employees\PDS\WorkExperienceController@delete')->name('Delete Work Experience');
		Route::get('employees/pds/experience/submit/{id}', 'HR\Employees\PDS\WorkExperienceController@submit')->name('Submit Work Experience');
		Route::post('employees/pds/experience/submit/{id}', 'HR\Employees\PDS\WorkExperienceController@submit')->name('Submit Work Experience');

		// Voluntary Work Routes
		Route::get('employees/pds/voluntary/{id}', 'HR\Employees\PDS\VoluntaryWorkController@index')->name('Voluntary Work');
		Route::get('employees/pds/voluntary/new/{id}/{employee_id}', 'HR\Employees\PDS\VoluntaryWorkController@new')->name('New Voluntary Work');
		Route::get('employees/pds/voluntary/edit/{id}/{employee_id}', 'HR\Employees\PDS\VoluntaryWorkController@edit')->name('Edit Voluntary Work');
		Route::get('employees/pds/voluntary/delete/{id}', 'HR\Employees\PDS\VoluntaryWorkController@delete')->name('Delete Voluntary Work');
		Route::get('employees/pds/voluntary/submit/{id}', 'HR\Employees\PDS\VoluntaryWorkController@submit')->name('Submit Voluntary Work');
		Route::post('employees/pds/voluntary/submit/{id}', 'HR\Employees\PDS\VoluntaryWorkController@submit')->name('Submit Voluntary Work');

		// Training Routes
		Route::get('employees/pds/training/{id}', 'HR\Employees\PDS\TrainingController@index')->name('Training');
		Route::get('employees/pds/training/new/{id}/{employee_id}', 'HR\Employees\PDS\TrainingController@new')->name('New Training');
		Route::get('employees/pds/training/edit/{id}/{employee_id}', 'HR\Employees\PDS\TrainingController@edit')->name('Edit Training');
		Route::get('employees/pds/training/delete/{id}', 'HR\Employees\PDS\TrainingController@delete')->name('Delete Training');
		Route::get('employees/pds/training/submit/{id}', 'HR\Employees\PDS\TrainingController@submit')->name('Submit Training');
		Route::post('employees/pds/training/submit/{id}', 'HR\Employees\PDS\TrainingController@submit')->name('Submit Training');

		// Other Information Routes
		Route::get('employees/pds/other/{id}', 'HR\Employees\PDS\OtherInformationController@index')->name('Other Information');
		Route::get('employees/pds/other/new/{id}/{employee_id}', 'HR\Employees\PDS\OtherInformationController@new')->name('New Other Information');
		Route::get('employees/pds/other/edit/{id}/{employee_id}', 'HR\Employees\PDS\OtherInformationController@edit')->name('Edit Other Information');
		Route::get('employees/pds/other/delete/{id}', 'HR\Employees\PDS\OtherInformationController@delete')->name('Delete Other Information');
		Route::get('employees/pds/other/submit/{id}', 'HR\Employees\PDS\OtherInformationController@submit')->name('Submit Other Information');
		Route::post('employees/pds/other/submit/{id}', 'HR\Employees\PDS\OtherInformationController@submit')->name('Submit Other Information');

	});

	// Comment Routes
	Route::get('comment/submit/{id}/{module}', 'CommentController@submit')->name('Submit Comment');
	Route::post('comment/submit/{id}/{module}', 'CommentController@submit')->name('Submit Comment');
	Route::get('comment/delete/{id}', 'CommentController@delete')->name('Delete Comment');

	// PDF Routes
	Route::get('pdf/travels/{id}', 'PdfController@travels')->name('Print Travel Order');
	Route::get('pdf/vehicles/{id}', 'PdfController@ticket')->name('Print Trip Ticket');
	Route::get('pdf/offset/{id}', 'PdfController@offset')->name('Print Offset');
	Route::get('pdf/overtime/{id}', 'PdfController@overtime')->name('Print Overtime');
	Route::get('pdf/leave/{id}', 'PdfController@leave')->name('Print Leave');
	Route::get('pdf/dtr/{id}/{start_date}/{end_date}/{mode}', 'PdfController@dtr')->name('Print Daily Time Record');

	// PDF Report Routes
	Route::get('/pdf/report/travels/{id}/{year}', 'PdfController@travel_order_report')->name('Print Travel Report');
	Route::get('/pdf/report/offset/{id}/{year}', 'PdfController@offset_report')->name('Print Offset Report');

	// Chart Controller Routes
	Route::get('/charts/attendance/{unit}/{label}/{date?}', 'ChartController@get_unit_attendance')->name('Get Unit Attendance');

	Route::get('download/{signature}', 'FileController@download_signature')->name('Download Signature');
	Route::get('download/contract/{contract}', 'FileController@contract')->name('Download Job Contract');
});

Route::get('include/travel', function() {
	$expenses  	= hrmis\Models\TravelExpense::where('id', '!=', 3)->get();
	return view('layouts.travel', compact('expenses'));
});

// File Routes
Route::get('signature/{filename}', 'FileController@employee_signature')->name('get-signature');
Route::get('document/{filename}', 'FileController@travel_documents')->name('get-travel-document');
Route::get('picture/{filename}', 'FileController@profile_picture')->name('get-picture');
Route::get('file/travels/documents/{filename}', 'FileController@travel_documents')->name('Get Travel Documents');
Route::get('file/pds/{filename}', 'FileController@pds')->name('Get PDS');
Route::get('file/attachments/{filename}', 'FileController@attachments')->name('Get File Attachment');
Route::get('excel/attachments/{id}/{start_date}/{end_date}', 'FileController@generate_attachments')->name('Generate Attachments');

// Unlisted Routes
Route::get('notifications/read/all', 'NotificationController@read_all')->name('Mark all as Read');
Route::get('notifications/view/all', 'NotificationController@index')->name('View All Notifications');
Route::get('coc/update', 'APIController@coc')->name('Update COC');

Route::get('birthday/read/{id}', 'NotificationController@read_birthday')->name('Read Birthday');
Route::get('birthday/submit', 'NotificationController@birthday_comment')->name('Submit Birthday Comment');
Route::post('birthday/submit', 'NotificationController@birthday_comment')->name('Submit Birthday Comment');