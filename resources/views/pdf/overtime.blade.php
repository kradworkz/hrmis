<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Request for Overtime Work</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/overtime.css') }}" rel="stylesheet">
</head>
<body>
	<div class="text-center">
		<div class="d-inline-block align-middle pt-1">
			<div><strong>Republic of the Philippines</strong></div>
			<div><strong>DEPARTMENT OF SCIENCE AND TECHNOLOGY</strong></div>
			<div><strong>Regional Office CALABARZON</strong></div>
			<div><strong>Jamboree Road, Timugan, Los Baños, Laguna</strong></div>
		</div>
	</div>
	<br>
	<div class="col-md-12 text-right">
		Date: {!! $overtime->created_at->format('F d, Y') !!}
	</div>
	<br>
	<div class="col-md-12 text-center"><h4>REQUEST FOR OVERTIME WORK</h4></div>
	<br>
	<div class="text-indent">This is to request for rendition of overtime services before & after office hours/Saturdays, Sundays and Holidays, pursuant to:</div>
	<br>
	<div class="text-indent">Please check applicable box:</div>
	<br>
	<div>@if($overtime->type == null || $overtime->type == 'To be offset as compensatory time off') /_X_/ @else /____/ @endif CSC Memo Circular No. 01, series 2001 and DOST OSEC Memo No. 006, s2002, to be offset as compensatory time off</div>
	<br>
	<div>@if($overtime->type == 'Overtime pay on hourly basis') /_X_/ @else /____/ @endif NBC 410 s. 1995 and COA Cir. 90-663, and AAMRO Book 1 pp 38-40: to claim overtime pay on hourly basis (suspended as per Malacañang AO 103)</div>
	<br>
	<table width="100%">
		<tr>
			<td class="text-right align-top">Purpose:</td>
			<td class="pl-2">
				{!! nl2br($overtime->purpose) !!}
			</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		@if($overtime->remarks != null)
		<tr>
			<td class="text-right align-top">Remarks:</td>
			<td class="pl-2">
				{!! nl2br($overtime->remarks) !!}
			</td>
		</tr>
		@endif
		<tr><td colspan="2">&nbsp</td></tr>
		<tr>
			<td width="20%" class="text-right">
				Date/Duration:
			</td>
			<td width="80%" class="pl-2">
				{!! $overtime->overtime_dates !!}
			</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr>
			<td class="text-right align-top">List of Personnel:</td>
			<td class="pl-2">
				@foreach($overtime->overtime_personnel as $personnel)
					<div>{!! $personnel->full_name !!}</div>
				@endforeach
			</td>
		</tr>
	</table>
	<br><br>
	<table width="100%">
		<td width="50%">
		@if($overtime->employee->unit->location == 0)
			<strong>
				<div>Noted By:</div>
				<div>&nbsp</div>
				<img src="{{ base_path('storage/dost/employee_signature/'.$overtime->employee->signature) }}" width="100" height="50">
				<div>{!! $overtime->employee->full_name !!}</div>
				<div>{!! $overtime->employee->designation !!}</div>
			</strong>
		@endif
		</td>
		<td width="50%" class="text-right">
		@if($overtime->employee->unit->overtime_recommending != 0 && $recommending != null)
			<strong>
				<div>Recommending:</div>
				<div>&nbsp</div>
				@if($overtime->recommending == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$overtime->recommending_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
				<div>{!! $overtime->recommending_signature ? $overtime->recommending_signature->full_name : ($recommending ? $recommending->signatory->employee->full_name : '') !!}</div>
				<div>{!! $overtime->recommending_signature ? $overtime->recommending_signature->designation : ($recommending ? $recommending->signatory->employee->designation : '') !!}</div>
			</strong>
		@endif
		</td>
	</table>
	<br><br>
	<table width="100%" class="text-center">
		<td>
		@if($overtime->employee->unit->overtime_approval != 0 && $approval != null)
			<strong>
				<div>Approved:</div>
				<div>&nbsp</div>
				@if($overtime->approval == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$overtime->approving_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
				<div>{!! $overtime->approving_signature ? $overtime->approving_signature->full_name : ($approval ? $approval->signatory->employee->full_name : '') !!}</div>
				<div>{!! $overtime->approving_signature ? $overtime->approving_signature->designation : ($approval ? $approval->signatory->employee->designation : '') !!}</div>
			</strong>
		@endif
		</td>
	</table>
</body>
</html>