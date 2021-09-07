<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Travel Order</title>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link href="{{ asset('pdf/travels.css') }}" rel="stylesheet">
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
	<br><br>
	<table width="100%">
		<tr>
			<td class="text-left">LOCAL TRAVEL ORDER NO. {!! $travel->created_at->format('Y') !!}-{!! $travel->id !!}</td>
			<td class="text-right">{!! $travel->created_at->format('F d, Y') !!}</td>
		</tr>
		<tr>
			<td class="text-left">Series of {!! $travel->created_at->format('Y') !!}</td>
			<td class="text-right">{!! $travel->time != null ? 'Time: '.$travel->time : '' !!}</td>
		</tr>
	</table>
	<br>
	<strong>Authority to Travel is hereby granted to:</strong>
	<br><br>
	<table width="100%">
		<thead>
			<tr>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>NAME</u></span></p>
				</th>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>POSITION</u></span></p>
				</th>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>DIVISION/AGENCY</u></span></p>
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($travel->travel_passengers as $employee)
			<tr>
				<td class="text-center" width="30%">
					<p class="display-table"><span class="display-cell underline text-nowrap">{!! $employee->full_name !!}</span></p>
				</td>
				<td class="text-center" width="30%">
					<p class="display-table text-center"><span class="display-cell underline text-nowrap">{!! $employee->designation !!}</span></p>
				</td>
				<td class="text-center" width="30%">
					<p class="display-table"><span class="display-cell underline text-nowrap">{!! $employee->primary_group == null ? '&nbsp' : $employee->primary_group->group->name !!}</span></p>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<table width="100%">
		<thead>
			<tr>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>DESTINATION</u></span></p>
				</th>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>Inclusive Date/s of Travel</u></span></p>
				</th>
				<th class="text-center" width="30%">
					<p class="display-table"><span class="display-cell text-center"><u>Purpose(s) of the Travel</u></span></p>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="text-center align-top" width="30%">
					<p class="display-table"><span class="display-cell underline">{!! $travel->destination !!}</span></p>
				</td>
				<td class="text-center align-top" width="30%">
					<p class="display-table">
					    <span class="display-cell underline text-nowrap">{!! $travel->travel_dates !!}</span>
					</p>
				</td>
				<td class="text-center align-top" width="30%">
					<p class="display-table"><span class="display-cell underline">{!! $travel->purpose !!}</span></p>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table width="100%">
		<tr>
			<th class="text-left">Travel Expenses to be incurred</th>
			<th class="text-right">Approriate/Fund to which travel expenses would be charged to:</th>
		</tr>
	</table>
	<br>
	<table width="100%">
		@foreach($expenses as $key => $expense)
			@if($key == 0)
				<tr><th>Actual</th></tr>
			@elseif($key == 2)
				<tr><th>Per Diem</th></tr>
			@endif
			@if($expense->id != 3)
				<tr>
					<td width="30%">{!! $expense->name !!}</td>
					<td width="23%" class="text-center">
						<p class="display-expense"><span class="display-cell underline text-nowrap">
							@foreach($travel->travel_funds_expenses as $travel_expense)
								@if($travel_expense->pivot->fund_id == 1 && $travel_expense->pivot->expense_id == $expense->id)
									<span class="fa fa-check"></span>
								@endif
							@endforeach
							&nbsp
						</span></p>
					</td>
					<td width="23%" class="text-center">
						<p class="display-expense"><span class="display-cell underline text-nowrap">
							@foreach($travel->travel_funds_expenses as $travel_expense)
								@if($travel_expense->pivot->fund_id == 2 && $travel_expense->pivot->expense_id == $expense->id)
									<span class="fa fa-check"></span>
								@endif
							@endforeach
							&nbsp
						</span></p>
					</td>
					<td width="23%" class="text-center">
						<p class="display-expense"><span class="display-cell underline text-nowrap">
							@foreach($travel->travel_funds_expenses as $travel_expense)
								@if($travel_expense->pivot->fund_id == 3 && $travel_expense->pivot->expense_id == $expense->id)
									<span class="fa fa-check"></span>
								@endif
							@endforeach
							&nbsp
						</span></p>
					</td>
				</tr>
			@endif
		@endforeach
		<tr><td>&nbsp</td></tr>
		<tr>
			<td class="align-top"><strong>Remarks/Special Instructions:</strong></td>
			<td colspan="3" class="underline">{!! $travel->remarks !!}</td>
		</tr>
	</table>
	<br><br>
	<div class="text-justify">
		<strong>
			A report of your travel must be submitted to the Agency Head/Supervising Official within 7 days completion of travel, liquidation of cash advance should be in accordance 
			with Executive Order No. 298: Rules and Regulations and New Rates of Allowances for Official Local and Foreign Travels of Government Personnel.
		</strong>
	</div>
	<br><br><br>
	<table width="100%">
		<tr>
			<td width="50%" class="align-top">
				@if($travel->employee->unit->travel_recommending != 0 && $recommending != null)
					<strong>
						<div>&nbsp</div>
						@if($travel->recommending == 1)
							<img src="{{ base_path('storage/dost/employee_signature/'.$travel->recommending_signature->signature) }}" width="100" height="50">
						@else
							<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
						@endif
						<div>{!! $travel->recommending_signature ? $travel->recommending_signature->full_name : ($recommending ? $recommending->signatory->employee->full_name : '') !!}</div>
						<div>{!! $travel->recommending_signature ? $travel->recommending_signature->designation : ($recommending ? $recommending->signatory->employee->designation : '') !!}</div>
					</strong>
				@endif
			</td>
			<td width="50%" class="align-top">
				@if($travel->employee->unit->travel_approval != 0 && $approval != null)
					<strong>
						<div>&nbsp</div>
						@if($travel->approval == 1)
							<img src="{{ base_path('storage/dost/employee_signature/'.$travel->approving_signature->signature) }}" width="100" height="50">
						@else
							<img src="{{ asset('images/white-space.png') }}" width="100" height="50">
						@endif
						<div>{!! $travel->approving_signature ? $travel->approving_signature->full_name : ($approval ? $approval->signatory->employee->full_name : '') !!}</div>
						<div>{!! $travel->approving_signature ? $travel->approving_signature->designation : ($approval ? $approval->signatory->employee->designation : '') !!}</div>
					</strong>
				@endif
			</td>
		</tr>
	</table>
</body>
</html>