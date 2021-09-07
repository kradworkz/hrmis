<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Trip Ticket</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/ticket.css') }}" rel="stylesheet">
</head>
<body>
	<div class="text-center">
		<img src="{{ asset('images/dost.png') }}" class="align-middle" width="50" height="50">
		<div class="d-inline-block align-middle pt-1">
			<div><strong>Republic of the Philippines</strong></div>
			<div><strong>DEPARTMENT OF SCIENCE AND TECHNOLOGY</strong></div>
			<div><strong>DOST Regional Office Region IV-A</strong></div>
		</div>
	</div>

	<br>
	<table width="100%">
		<tr>
			<td colspan="2" class="text-center"><h5><strong class="text-uppercase">OFFICIAL TRAVEL ORDER/VEHICLE DISPATCH</strong></h5></td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr>
			<td class="text-left"><strong>Vehicle Plate Number: {!! $reservation->vehicle->plate_number !!}</strong></td>
			<td class="text-right"><strong>Trip Ticket No. {!! date('Y')!!}-{!! $reservation->id !!}</strong></td>
		</tr>
	</table>
	<br>

	<div class="text-uppercase"><strong>A. TRAVEL ORDER</strong></div><br>
	<div><strong>Permission is hereby granted to the following to go on official travel as follows:</strong></div><br>

	<table width="100%">
		<tr>
			<td class="text-left">Passengers</td>
			<td class="text-right">Destination</td>
		</tr>
		<tr>
			<td class="text-left align-top " width="70%">
				@foreach($reservation->passengers as $employee)
					{!! $employee->full_name !!}@if(!$loop->last),@endif
				@endforeach
				<div>{!! $reservation->others !!}</div>
			</td width="30%">
			<td class="text-right align-top">{!! $reservation->destination !!}</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr>
			<td class="align-top" width="70%">Purpose of Visit: {!! $reservation->purpose !!}</td>
			<td class="text-right">
				<div>Inc. date of travel: {!! $reservation->reservation_dates !!}</div>
				<div>Est. time of Departure: {!! $reservation->time !!}</div>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr><td colspan="2">&nbsp</td></tr>
		<tr><td colspan="2">&nbsp</td></tr>
	</table>

	<table width="100%">
		<tr>
			<td class="text-center" width="33%">@if(Auth::user()->unit->location == 1 || $reservation->location != 1) Approving Official @endif</td>
			<td class="text-center" width="33%">Noted</td>
			<td class="text-center" width="33%">&nbsp</td>
		</tr>
		<tr>
			<td class="text-center" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->recommending != 0 && $recommending != null))
				@if($reservation->recommending == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$reservation->recommending_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
			@endif
			</td>
			<td class="text-center" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->approval != 0 && $approval != null))
				@if($reservation->approval == 1)
					<img src="{{ base_path('storage/dost/employee_signature/'.$reservation->approving_signature->signature) }}" width="100" height="50">
				@else
					<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
				@endif
			@endif
			</td>
			<td class="text-center" width="33%">&nbsp</td>
		</tr>
		<tr>
			<td class="text-center font-weight-bold" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->recommending != 0 && $recommending != null))
				{!! $recommending != null ? $recommending->signatory->employee->full_name : '' !!}
			@endif
			</td>
			<td class="text-center font-weight-bold" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->approval != 0 && $approval != null))
				{!! $approval != null ? $approval->signatory->employee->full_name : '' !!}
			@endif
			</td>
			<td class="text-center" width="33%"><strong>________________</strong></td>
		</tr>
		<tr>
			<td class="text-center" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->recommending != 0 && $recommending != null))
				{!! $recommending != null ? $recommending->signatory->employee->designation : '' !!}
			@endif
			</td>
			<td class="text-center" width="33%">
			@if($reservation->vehicle->location == 1 || ($reservation->employee->unit->approval != 0 && $approval != null))
				{!! $approval != null ? $approval->signatory->employee->designation : '' !!}
			@endif
			</td>
			<td class="text-center" width="33%">Date</td>
		</tr>
	</table>
	<br><br>

	<table width="100%">
		<tr>
			<td width="50%" class="text-left"><strong class="text-uppercase">B. VEHICLE DISPATCH</strong></td>
			<td width="50%" class="text-right"><strong class="text-uppercase">B-1. VEHICLE PRE SAFETY CHECK</strong></td>
		</tr>
		<tr>
			<td width="50%" class="align-top">
				<table width="100%">
					<tr><td>&nbsp</td></tr>
					<tr>
						<td><strong>As per travel order above the vehicle is hereby dispatched:</strong></td>
					</tr>
					<tr><td>&nbsp</td></tr>
					<tr><td>Drivers' Name: <u>{!! $reservation->driver_name !!}</u></td></tr>
					<tr><td>at place: _______________________________</td></tr>
					<tr><td>on (time) _______________________________</td></tr>
					<tr><td>&nbsp</td></tr>
					<tr><td>Report to: ______________________________</td></tr>
					<tr><td class="text-center">(Head of Party/Passenger)</td></tr>
					<tr><td>&nbsp</td></tr>
					<tr><td>Good for ____________________ liters only</td></tr>
					<tr><td>&nbsp</td></tr>
					<tr><td>Remarks: _______________________________</td></tr>
					<tr><td>&nbsp</td></tr>
					<tr><td>Time: ___________________________________</td></tr>
					<tr><td>Date: ___________________________________</td></tr>
					<tr><td> No. of liters issued: ___________________________</td></tr>
					<tr><td>Chargable against: ____________________________</td></tr>
				</table>
			</td>
			<td width="50%">
				<table width="100%" class="trip-ticket-border">
					<tr><td colspan="3">&nbsp</td></tr>
					<tr>
						<td>&nbsp</td>
						<td width="30%" class="text-center">OK</td>
						<td width="30%" class="text-center">NOT OK</td>
					</tr>
					<tr>
						<td width="30%"><strong>Brakes</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Lights</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Oil</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Water</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Battery</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Air</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td><strong>Gas</strong></td>
						<td width="30%" class="text-center">__________</td>
						<td width="30%" class="text-center">__________</td>
					</tr>
					<tr>
						<td width="30%" class="align-top"><strong>Others</strong></td>
						<td colspan="2" width="60%" class="text-center">
							<div>_____________________________</div>
							<div>_____________________________</div>
							<div>_____________________________</div>
							<div>_____________________________</div>
						</td>
					</tr>
					<tr>
						<td width="30%" class="align-top"><strong>Certified</strong></td>
						<td colspan="2" width="60%" class="text-center"><strong>Driver</strong></td>
					</tr>
					<tr><td colspan="3">&nbsp</td></tr>
					<tr>
						<td width="30%">&nbsp</td>
						<td colspan="2" width="60%" class="text-center">
							<div>Date</div>
							<div>_____________________________</div>
							<div>Time</div>
						</td>
					</tr>
				</table>
				<table width="100%">
					<tr><td>&nbsp</td></tr>
					<tr>
						<td class="text-center text-uppercase">
							<div><strong>
								@if($reservation->status_by == NULL)
									&nbsp
								@else
									<u>{!! $reservation->dispatched_by->full_name !!}</u>
								@endif
							</strong></div>
							<div style="line-height: 1"><strong>Dispatching Official</strong></div>
						</td>
					</tr>
					<tr><td>&nbsp</td></tr>
					<tr>
						<td class="text-center"><div>____________________</div><div>Date</div></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>