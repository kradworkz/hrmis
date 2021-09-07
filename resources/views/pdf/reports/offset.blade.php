<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Offset Report</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('tools/fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <h3 class="text-primary">{!! $employee->full_name !!}</h3>
	<table class="table table-sm table-bordered">
		<thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th class="text-center">Hours</th>
                <th class="text-center text-nowrap">Status</th>
                <th class="text-center">Created At</th>
            </tr>
        </thead>
        <tbody>
            @if(count($offset) > 0)
                @foreach($offset as $off)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $off->date->format('F d, Y') }}</td>
                    <td>{{ $off->time }}</td>
                    <td class="text-center">{{ $off->hours }}</td>
                    <td class="text-center text-nowrap">
                    @if($off->is_active == 1)
                        {!! getStatus($off) !!}
                    @else
                        <strong class="text-danger"><i>CANCELLED</i></strong>
                    @endif
                    </td>
                    <td class="text-nowrap text-center">{!! getDateDiff($off->created_at) !!}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
	</table>
</body>
</html>