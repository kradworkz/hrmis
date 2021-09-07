<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daily Time Record</title>
    <link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/dtr.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<table width="100%">
					<tr><td><i>Civil Service form No. 48</i></td></tr>
					<tr><td class="text-center"><strong>DAILY TIME RECORD</strong></td></tr>
					<tr><td class="text-center"><strong>-----o0o-----</strong></td></tr>
					<tr><td>&nbsp</td></tr>
					<tr>
						<td class="text-center dtr-border-bottom">{!! $employee->full_name !!}</td>
					</tr>
					<tr><td class="text-center">(Name)</td></tr>
					<tr><td>&nbsp</td></tr>
					<tr>
						<td>
							<table width="100%">
								<tr>
									<td class="text-center text-nowrap"><i>For the month of</i></td>
									<td colspan="2" width="80%" class="text-center dtr-border-bottom">{!! $start_date->format('F') !!}</td>
								</tr>
								<tr>
									<td class="text-center text-nowrap"><i>Official hours for</i></td>
									<td class="text-right" width="20%"><i>Regular days</i></td>
									<td width="60%" class="dtr-border-bottom">&nbsp</td>
								</tr>
								<tr>
									<td class="text-center text-nowrap"><i>arrival and departure</i></td>
									<td class="text-right" width="20%"><i>Saturdays</i></td>
									<td width="60%" class="dtr-border-bottom">&nbsp</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr><td>&nbsp</td></tr>
				</table>
				<table border="1" width="100%" class="text-center" id="dtr-table">
					<thead>
						<tr>
							<td rowspan="3">Day</td>
						</tr>
						<tr>
							<td colspan="2">A.M.</td>
							<td colspan="2">P.M.</td>
							<td colspan="2">Overtime</td>
						</tr>
						<tr>
							<td>Arrival</td>
							<td>Departure</td>
							<td>Arrival</td>
							<td>Departure</td>
							<td>Hours</td>
							<td>Minutes</td>
						</tr>
					</thead>
					<tbody>
						@foreach($days as $day)
							<tr>
								<td>{!! $day->format('d') !!}</td>
								@if(getEmployeeTravel($id, $day) || getEmployeeOffset($id, $day))
									@if(getEmployeeTravel($id, $day, 1) == 'AM' || getEmployeeOffset($id, $day) == 'AM')
										<td colspan="2">{{ getEmployeeOffset($id, $day) ? 'Offset' : 'Official Business' }}</td>
										<td>{!! getEmployeeAttendance($id, $day, 2) !!}</td>
										<td>{!! getEmployeeAttendance($id, $day, 1) !!}</td>
									@elseif(getEmployeeTravel($id, $day, 1) == 'PM' || getEmployeeOffset($id, $day) == 'PM')
										<td>{!! getEmployeeAttendance($id, $day, 0, 1) !!}</td>
										<td>{!! getEmployeeAttendance($id, $day, 3) !!}</td>
										<td colspan="2">{{ getEmployeeOffset($id, $day) ? 'Offset' : 'Official Business' }}</td>
									@elseif(getEmployeeTravel($id, $day, 1) == 'Whole Day' || getEmployeeOffset($id, $day) == 'Whole Day')
										<td>{!! getEmployeeAttendance($id, $day, 0, 1) !!}</td>
										<td colspan="2">{{ getEmployeeOffset($id, $day) ? 'Offset' : 'Official Business' }}</td>
										<td>{!! getEmployeeAttendance($id, $day, 1) !!}</td>
									@endif
								@elseif(getEmployeeAttendance($id, $day, 0, 1) == null && ($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday' || getHoliday($day) != null))
									<td colspan="4"><i class="text-success">{{ getHoliday($day) != null ? 'Holiday' : $day->format('l') }}</i></td>
								@else
									<td>{!! getEmployeeAttendance($id, $day, 0, 1) !!}</td>
									<td>{!! getEmployeeAttendance($id, $day, 3) !!}</td>
									<td>{!! getEmployeeAttendance($id, $day, 2) !!}</td>
									<td>{!! getEmployeeAttendance($id, $day, 1) !!}</td>
								@endif
								<td></td>
								<td></td>
							</tr>
						@endforeach
						<tr><td colspan="5" class="text-right">Total</td><td></td><td></td></tr>
					</tbody>
				</table>
				<br>
				<table width="100%">
					<tr><td class="text-center"><i>I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.</i></td></tr>
					<tr><td style="border-bottom: solid black 3px;">&nbsp</td></tr>
					<tr><td class="pt-2 pl-3"><i>VERIFIED as to the prescribed office hours:</i></td></tr>
					<tr><td class="pt-3" style="border-bottom: solid black 3px;">&nbsp</td></tr>
					<tr><td class="text-center"><i>In Charge</i></td></tr>
				</table>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12 text-center">	
				<div class="text-nowrap"><i><span class="text-primary">Blue</span> indicates Work from Home arrangement.</i></div>			
				<div class="text-nowrap"><i>This report was generated using the</i></div>
				<div class="text-nowrap"><i>Human Resource Management Information System</i></div>
				<div><i>on {!! date('F d, Y H:i A') !!}.</i></div>
			</div>
		</div>
	</div>
</body>
</html>