<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Offset</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/offset.css') }}" rel="stylesheet">
</head>
<body>
	<div class="text-center">
		<img src="{{ asset('images/dost.png') }}" class="align-middle" width="50" height="50"> <strong>DEPARTMENT OF SCIENCE AND TECHNOLOGY</strong>
	</div>
	<br><br>
	<div class="text-center"><strong>REQUEST FOR COMPENSATORY TIME OFF</strong></div>
	<div class="text-center">(To be attached as supporting paper to Daily Time Record or CSC Form 48)</div>
	<table width="100%" class="bordered">
		<!-- I. -->
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="4"><strong>&nbspI. Schedule of Time Off Being Requested:</strong></td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<th width="20%" class="text-center bordered">Date</th>
			<th width="25%" class="text-center bordered">Time</th>
			<th width="20%" class="text-center bordered">Number of Hours</th>
			<th width="35%" class="text-center bordered">Remarks</th>
		</tr>
		<tr>
			<td class="text-center bordered">{{ $offset->date->format('m/d/Y') }}</td>
			<td class="text-center bordered">{{ $offset->time }}</td>
			<td class="text-center bordered">{{ $offset->hours }}</td>
			<td rowspan="10" class="text-center" valign="top">
				To be compensated from the overtime services rendered.
			</td>
		</tr>
		<tr>
			<td class="bordered">&nbsp</td>
			<td class="text-center bordered">Total</td>
			<td class="text-center bordered">{{ $offset->hours }}</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="20%">&nbsp</td>
			<td width="25%">&nbsp</td>
			<td width="20%">&nbsp</td>
			<td width="35%">&nbsp</td>
		</tr>
		<tr>
			<td>Requested By:</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="2" class="text-center">
				@if($offset->employee->signature == null)
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@else
					<img src="{{ base_path('storage/dost/employee_signature/'.$offset->employee->signature) }}" width="100" height="50">
				@endif
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" class="text-center"><strong>{!! $offset->employee->full_name !!}</strong></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">{!! $offset->employee->designation !!}</td>
			<td></td>
			<td></td>
		</tr>
		<!-- II. -->
		<tr><td colspan="4">&nbsp</td></tr>
		<tr><td colspan="4"><strong>II. Reference: Compensatory Overtime Credit (COC) Certificate No.</strong></td></tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="3">@if($offset->employee->unit->offset_recommending != 0)Supervisor:@endif</td>
			<td>Approved:</td>
		</tr>
		<tr><td colspan="4">&nbsp</td></tr>
		<tr>
			<td colspan="2" class="text-center">
			@if($offset->employee->unit->offset_recommending != 0 && $recommending != null)
				@if($offset->recommending == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$offset->recommending_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
			@endif
			</td>
			<td></td>
			<td class="text-center">
			@if($offset->employee->unit->offset_approval != 0 && $approval != null)
				@if($offset->approval == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$offset->approving_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
			@endif
			</td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
				@if($offset->employee->unit->offset_recommending != 0 && $recommending != null)
					<div><strong>{!! $offset->recommending_signature ? $offset->recommending_signature->full_name : ($recommending ? $recommending->signatory->employee->full_name : '') !!}</strong></div>
					<div><strong>{!! $offset->recommending_signature ? $offset->recommending_signature->designation : ($recommending ? $recommending->signatory->employee->designation : '') !!}</strong></div>
				@endif
			</td>
			<td></td>
			<td class="text-center">
				@if($offset->employee->unit->offset_approval != 0 && $approval != null)
					<div><strong>{!! $offset->approving_signature ? $offset->approving_signature->full_name : ($approval ? $approval->signatory->employee->full_name : '') !!}</strong></div>
					<div><strong>{!! $offset->approving_signature ? $offset->approving_signature->designation : ($approval ? $approval->signatory->employee->designation : '') !!}</strong></div>
				@endif
			</td>
		</tr>
	</table>
</body>
</html>