<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Travel Order Report</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('tools/fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <h3 class="text-primary">{!! $employee->full_name !!}</h3>
	<table class="table table-sm table-bordered">
		<thead>
            <tr>
                <th>#</th>
                <th>Filed By</th>
                <th>Purpose</th>
                <th>Destination</th>
                <th>Date of Travel</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
            </tr>
        </thead>
        <tbody>
            @if(count($travels) > 0)
            	@foreach($travels as $travel)
            	<tr>
                	<td>{{ $loop->iteration }}</td>
                	<td>{{ $travel->employee->order_by_last_name }}</td>
                	<td>{!! nl2br($travel->purpose) !!}</td>
                    <td>{!! nl2br($travel->destination) !!}</td>
                    <td class="text-nowrap">{!! $travel->travel_dates !!}</td>
                    <td class="text-center text-nowrap">{!! getStatus($travel) !!}</td>
                    <td class="text-nowrap text-center">{!! getDateDiff($travel->created_at) !!}</td>
                </tr>
            	@endforeach
            @endif
            </tbody>
	</table>
</body>
</html>