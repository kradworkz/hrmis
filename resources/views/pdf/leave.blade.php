<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Application for Leave</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/leave.css') }}" rel="stylesheet">
</head>
<body>
	<br><br><br>
	<table width="100%">
		<tr>
			<td>CSC Form No. 6</td>
			<td></td>
		</tr>
		<tr>
			<td>Revised 1984</td>
			<td colspan="2">&nbsp</td>
			<td colspan="1" class="text-right border-bottom">{!! sprintf('%03d', $leave->id) !!}</td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr><td colspan="4" class="text-center border-bottom leave-title">APPLICATION FOR LEAVE</td></tr>
		<tr>
			<td>OFFICE/AGENCY</td>
			<td>NAME (Lastname)</td>
			<td>(Firstname)</td>
			<td>(M.I)</td>
		</tr>
		<tr class="border-bottom">
			<td>DOST-CALABARZON</td>
			<td>{!! $leave->employee->last_name !!}</td>
			<td>{!! $leave->employee->first_name !!}</td>
			<td>{!! $leave->employee->middle_name !!}</td>
		</tr>
		<tr>
			<td>DATE OF FILING</td>
			<td>POSITION</td>
			<td colspan="2" class="text-center">SALARY (Monthly)</td>
		</tr>
		<tr class="border-bottom">
			<td>{!! $leave->created_at->format('F d, Y') !!}</td>
			<td>{!! $leave->employee->designation !!}</td>
			<td colspan="2" class="text-center">{!! $leave->employee->salary !!}</td>
		</tr>
	</table>
	<table width="100%">
		<tr class="border-bottom">
			<td colspan="4" class="text-center">DETAILS OF APPLICATION</td>
		</tr>
		<tr>
			<td colspan="2">TYPE OF LEAVE:</td>
			<td colspan="2">WHERE LEAVE WILL BE SPENT:</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="vacation_leave" class="ml-3" {{ $leave->type == 'Vacation Leave' ? 'checked' : '' }}> Vacation Leave</td>
			<td colspan="2"><span class="ml-3">IN CASE OF VACATION LEAVE</span></td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" class="ml-5" {{ $leave->vacation_leave == 'To seek employment' ? 'checked' : '' }}>To seek employment</td>
			<td width="10%"><input type="checkbox" class="ml-3" {{ $leave->vacation_location == 'Within Philippines' ? 'checked' : '' }}> Within Philippines</td>
			<td class="border-bottom" width="20%">{!! $leave->vacation_location == 'Within Philippines' ? $leave->vacation_location_specify : '&nbsp' !!}</td>
		</tr>
		<tr>
			<td colspan="1" width="20%"><input type="checkbox" class="ml-5" {{ $leave->vacation_leave == 'Others' ? 'checked' : '' }}>Others (Specify)</td>
			<td class="border-bottom">{!! $leave->vacation_leave == 'Others' ? $leave->vacation_leave_specify : '&nbsp' !!}</td>
			<td width="10%"><input type="checkbox" class="ml-3" {{ $leave->vacation_location == 'Abroad' ? 'checked' : '' }}> Abroad (Specify)</td>
			<td class="border-bottom" width="20%">{!! $leave->vacation_location == 'Abroad' ? $leave->vacation_location_specify : '&nbsp' !!}</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" class="ml-3" {{ $leave->type == 'Sick Leave' ? 'checked' : '' }}> Sick Leave</td>
			<td colspan="2"><span class="ml-3">IN CASE OF SICK LEAVE</span></td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" class="ml-3" {{ $leave->type == 'Maternity Leave' ? 'checked' : '' }}> Maternity</td>
			<td width="20%"><input type="checkbox" class="ml-3" {{ $leave->sick_location == 'In Hospital' ? 'checked' : '' }}> In Hospital (Specify)</td>
			<td class="border-bottom">{!! $leave->sick_location == 'In Hospital' ? $leave->sick_location_specify : '&nbsp' !!}</td>
		</tr>
		<tr>
			<td colspan="1" width="20%"><input type="checkbox" class="ml-3" {{ $leave->sick_leave == 'Others' ? 'checked' : '' }}>Others (Specify)</td>
			<td class="border-bottom">{!! $leave->sick_leave == 'Others' ? $leave->sick_leave_specify : '&nbsp' !!}</td>
			<td width="20%"><input type="checkbox" class="ml-3" {{ $leave->sick_location == 'Out Patient' ? 'checked' : '' }}> Out Patient (Specify)</td>
			<td class="border-bottom">{!! $leave->sick_location == 'Out Patient' ? $leave->sick_location_specify : '&nbsp' !!}</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="special_privilege_leave" class="ml-3" {{ $leave->type == 'Special Privilege Leave' ? 'checked' : '' }}> Special Privilege Leave</td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="2">NUMBER OF WORKING DAYS APPLIED FOR</td>
			<td colspan="2">COMMUTATION</td>
		</tr>
		<tr>
			<td colspan="2">{!! count($leave->leave_dates) !!}</td>
			<td><input type="checkbox" class="ml-3" {{ $leave->commutation == 'Requested' ? 'checked' : '' }}> Requested</td>
			<td><input type="checkbox" class="ml-3" {{ $leave->commutation == 'Not Requested' ? 'checked' : '' }}>Not Requested</td>
		</tr>
		<tr>
			<td colspan="2" class="text-uppercase">INCLUSIVE DATES: {!! $leave->off_dates !!}</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
			<td colspan="2" class="border-bottom text-center">
				@if($leave->employee->signature != "")
					<img src="{{ base_path('storage/dost/employee_signature/'.$leave->employee->signature) }}" width="100" height="50">
				@endif
			</td>
		</tr>
		<tr>
			<td colspan="2">&anbsp</td>
			<td colspan="2" class="text-center">SIGNATURE OF APPLICANT</td>
		</tr>
		<tr class="border-bottom border-top">
			<td colspan="4" class="text-center">DETAILS OF ACTION ON APPLICATION</td>
		</tr>
		<tr>
			<td colspan="2">CERTIFICATION OF LEAVE CREDITS</td>
			<td colspan="2">RECOMMENDATION</td>
		</tr>
		<tr>
			<td colspan="2"><span class="ml-5">As of <u>@if($leave->employee->leave_credits) {!! date("F", mktime(0, 0, 0, $leave->employee->leave_credits->month, 10)) !!} {!! $leave->employee->leave_credits->year !!} @endif</u></span></td>
			<td colspan="2"><input type="checkbox" class="ml-2" {!! $leave->recommending == 1 ? 'checked' : '' !!}> Approval</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
			<td colspan="2"><input type="checkbox" class="ml-2" {!! $leave->recommending == 2 ? 'checked' : '' !!}> Disapproval due to:</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="90%" class="text-center" border="1">
					<thead>
						<tr>
							<th width="33%">Vacation</th>
							<th width="33%">Sick</th>
							<th width="33%">Total</th>
						</tr>
					</thead>
					<tbody>
						@if($leave->employee->leave_credits)
						<tr>
							<td>{!! $leave->employee->leave_credits->vl_balance !!}</td>
							<td>{!! $leave->employee->leave_credits->sl_balance !!}</td>
							<td>{!! $leave->employee->leave_credits->vl_balance+$leave->employee->leave_credits->sl_balance !!}</td>
						</tr>
						@else
						<tr>
							<td>&nbsp</td>
							<td>&nbsp</td>
							<td>&nbsp</td>
						</tr>
						@endif
					</tbody>
				</table>
			</td>
			<td colspan="2">
				<table width="100%">
					<tr><td class="border-bottom">{!! $leave->recommending_disapproval !!} @forelse($ard_dates as $date) {!! $date->date->format('F d, Y') !!} @empty @endforelse</td></tr>
					<tr><td class="border-bottom">&nbsp</td></tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="2" class="text-center">
					@if($chief)
						<img src="{{ base_path('storage/dost/employee_signature/'.$chief->signatory->employee->signature) }}" width="100" height="50">
					@else
						<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
					@endif
			</td>
			<td colspan="2" class="text-center">
				@if($leave->employee->unit->leave_recommending != 0 && $recommending != null)
					@if($leave->recommending == 1)
						<img src="{{ base_path('storage/dost/employee_signature/'.$leave->recommending_signature->signature) }}" width="100" height="50">
					@else
						<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
					@endif
				@endif
			</td>
		</tr>
		<tr>
			<td colspan="2" class="text-center leave-title"><u>@if($chief){!! $chief->signatory->employee->full_name !!}@endif</u></td>
			<td colspan="2" class="text-center leave-title">{!! $recommending->signatory->employee->full_name !!}</td>
		</tr>
		<tr>
			<td colspan="2" class="text-center"><u>@if($chief){!! $chief->signatory->employee->designation !!}@endif</u></td>
			<td colspan="2" class="text-center">{!! $recommending->signatory->employee->designation !!}</td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr class="border-bottom"><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="2">APPROVED FOR:</td>
			<td colspan="2">DISAPPROVED DUE TO:</td>
		</tr>
		<tr>
			<td class="border-bottom text-center">{!! $leave->approved_sick_leave !!}</td>
			<td>day(s) sick leave with pay</td>
			<td colspan="2" class="border-bottom">{!! $leave->approval_disapproval !!} @forelse($rd_dates as $date) {!! $date->date->format('F d, Y') !!} @empty @endforelse</td>
		</tr>
		<tr>
			<td class="border-bottom text-center">{!! $leave->approved_vacation_leave !!}</td>
			<td>day(s) vacation leave with pay</td>
			<td colspan="2" class="border-bottom">&nbsp</td>
		</tr>
		<tr>
			<td class="border-bottom text-center">{!! $leave->approved_without_pay !!}</td>
			<td>days without pay</td>
			<td colspan="2" class="border-bottom">&nbsp</td>
		</tr>
		<tr>
			<td class="border-bottom text-center">{!! $leave->approved_others !!}</td>
			<td>others (specify)</td>
			<td colspan="2">&nbsp</td>
		</tr>
	</table>
	<br><br><br><br>
	<div class="mx-auto text-center border-bottom centered-width">
		@if($leave->employee->unit->leave_approval != 0 && $recommending != null)
			@if($leave->approval == 1)
				<img src="{{ base_path('storage/dost/employee_signature/'.$leave->approving_signature->signature) }}" width="100" height="50">
			@else
				<img class="border-bottom" src="{{ asset('images/white-space.png') }}" width="100" height="50">
			@endif
		@endif
	</div>
	<div class="mx-auto text-center">SIGNATURE</div>
	<div class="mx-auto text-center leave-title">{!! $leave->approving_signature ? $leave->approving_signature->full_name : ($approval ? $approval->signatory->employee->full_name : '') !!}</div>
	<div class="mx-auto text-center">{!! $leave->approving_signature ? $leave->approving_signature->designation : ($approval ? $approval->signatory->employee->designation : '') !!}</div>
</body>
</html>