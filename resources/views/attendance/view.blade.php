<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{!! $employee->full_name !!}</title>
	<link rel="icon" href="{{ asset('icon/vrams.jpg') }}" type="image/png"/>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <script src="{{ asset('tools/jquery/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('tools/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('tools/moment/moment.min.js') }}" type="text/javascript"></script>

    <style type="text/css">
    	body, html {
    		background-color: #212121;
    		color: white;
    		font-family: "Segoe UI";

    		display: flex;
    		align-items: center;
    		justify-content: center;
    	}

    	.vertical-center {
    		min-height: 100%;
			min-height: 100vh;

			display: flex;
			align-items: center;
    	}

    	.container {
    		height: 560px;
    	}

    	.dtr-table-card {
    		background: none;
    		padding: 0;
    		margin: 0;
    		border: 0;
    	}

    	.dtr-table {
    		width: 100%;
    		color: white;
  			text-align: center;
    		border: 0 !important;
    		padding: 0;
    		border-collapse: separate;
    		border-spacing: 1px;
    	}

    	th {
    		font-size: 18px;
    		font-weight: normal;
    	}

    	td {
    		font-size: 16px;
    	}

    	.card-dtr {
    		border: 0;
    		margin: 0;
    		padding: 0;
    		background: none;
    	}

    	th, td , .card-dtr .card-body{
    		background-color: #0D47A1;
    	}

    	.text-label {
    		font-size: 18px;
    		color: #FDD835;
    	}
    </style>
</head>
<body>
	<div class="vertical-center">
		<div>
			<div class="row">
				<div class="col px-0 pr-2">
					<div class="card card-dtr rounded-0 h-100">
						<div class="card-body rounded-0 h-60">
							<img class="card-img h-100" src="{{ asset('images/nopicture.png') }}">
						</div>
						<div class="card card-dtr rounded-0 h-20 mt-2">
							<div class="card-body text-center">
								<div class="text-label">{!! $employee->full_name !!}</div>
							</div>
						</div>
						<div class="card card-dtr rounded-0 h-20 mt-2">
							<div class="card-body text-center">
								<div class="text-label">{!! date('F d, Y') !!}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col px-0">
					<div class="card dtr-table-card rounded-0 h-100">
						<table class="dtr-table h-100">
							<thead>
								<tr>
									<th width="15%">Day</th>
									<th width="42.5%">In</th>
									<th width="42.5%">Out</th>
								</tr>
							</thead>
							<tbody>
								@for($i = 1; $i < 16; $i++)
								<tr>
									<td>{!! $i !!}</td>
									<td>
										@foreach($dtr as $dtr_record)
					                        @if($dtr_record->time_in->format('j') == $i)
					                            {!! $dtr_record->time_in->format('g:i A'); break; !!}
					                        @endif
					                    @endforeach
									</td>
									<td>
					                    @foreach($dtr as $dtr_record)
					                        @if($dtr_record->time_out != null)
					                            @if($dtr_record->time_out->format('j') == $i)
					                                {!! $dtr_record->time_out->format('g:i A'); break; !!}
					                            @endif
					                        @endif
					                    @endforeach
									</td>
								</tr>
								@endfor
							</tbody>
						</table>
					</div>
				</div>
				<div class="col px-0 pl-2">
					<div class="card dtr-table-card rounded-0 h-100">
						<table class="dtr-table h-100">
							<thead>
								<tr>
									<th width="15%">Day</th>
									<th width="42.5%">In</th>
									<th width="42.5%">Out</th>
								</tr>
							</thead>
							<tbody>
								@for($i = 16; $i < 32; $i++)
								<tr>
									<td>{!! $i !!}</td>
									<td>
										@foreach($dtr as $dtr_record)
					                        @if($dtr_record->time_in->format('j') == $i)
					                            {!! $dtr_record->time_in->format('g:i A'); break; !!}
					                        @endif
					                    @endforeach
									</td>
									<td>
					                    @foreach($dtr as $dtr_record)
					                        @if($dtr_record->time_out != null)
					                            @if($dtr_record->time_out->format('j') == $i)
					                                {!! $dtr_record->time_out->format('g:i A'); break; !!}
					                            @endif
					                        @endif
					                    @endforeach
									</td>
								</tr>
								@endfor
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>