<div class="row pb-2">
	<div class="col-md-6">
		<h3 class="hrmis-date text-nowrap">{!! date('F d, Y') !!}</h3>
	</div>
	<div class="col-md-6 text-right">
		@include('layouts.attendance')
	</div>
</div>
<div class="card-deck">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 pt-2">
					<i class="text-left fa fa-stopwatch fa-3x text-info"></i>
				</div>
				<div class="col-md-9 pt-2">
					<div class="d-flex align-items-end flex-column text-right h-100">
						<div class="title mt-auto">Compensatory Overtime Credit (COC)</div>
						<div class="value">
							{!! Auth::user()->employee_balance() != 0 ? convertToHoursMins(Auth::user()->employee_balance(), '%02dh %02dm') : '&nbsp' !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="{{ route('Compensatory Overtime Credit') }}">
            <div class="card-footer clearfix">
                <div class="float-left more">VIEW MORE</div>
                <div class="float-right more"><i class="fa fa-angle-right"></i></div>
            </div>
        </a>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 pt-2">
					<i class="text-left fa fa-info-circle fa-3x text-primary"></i>
				</div>
				<div class="col-md-9 pt-2">
					<div class="d-flex align-items-end flex-column text-right h-100">
						<div class="title mt-auto">Latest COC update (@if(Auth::user()->monthly_coc_earned){!! formatMonth(Auth::user()->monthly_coc_earned->month) !!}@endif)</div>
						<div class="value">
							@if(Auth::user()->monthly_coc_earned != null) {!! Auth::user()->monthly_coc_earned->beginning_hours."h" !!} {!! Auth::user()->monthly_coc_earned->beginning_minutes."m" !!} @else &nbsp @endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="{{ route('Offset') }}">
            <div class="card-footer clearfix">
                <div class="float-left more">VIEW MORE</div>
                <div class="float-right more"><i class="fa fa-angle-right"></i></div>
            </div>
        </a>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 pt-2">
					<i class="text-left fa fa-info-circle fa-3x text-warning"></i>
				</div>
				<div class="col-md-9 pt-2">
					<div class="d-flex align-items-end flex-column text-right h-100">
						<div class="title mt-auto">Used COC ({{ date('F') }})</div>
						<div class="value">
							{!! Auth::user()->total_offset_month() != 0 ? Auth::user()->total_offset_month()." hour(s)" : '&nbsp'  !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="{{ route('Offset') }}">
            <div class="card-footer clearfix">
                <div class="float-left more">VIEW MORE</div>
                <div class="float-right more"><i class="fa fa-angle-right"></i></div>
            </div>
        </a>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 pt-2">
					<i class="text-left fa fa-bell fa-3x text-danger"></i>
				</div>
				<div class="col-md-9 pt-2">
					<div class="d-flex align-items-end flex-column text-right h-100">
						<div class="title mt-auto">Notifications</div>
						<div class="value">{{ count(Auth::user()->notifications) }}</div>
					</div>
				</div>
			</div>
		</div>
		<a href="#" data-toggle="modal" data-target="#notificationModal" id="notificationBtn" data-url="{{ route('View All Notifications') }}">
            <div class="card-footer clearfix">
                <div class="float-left more">VIEW MORE</div>
                <div class="float-right more"><i class="fa fa-angle-right"></i></div>
            </div>
        </a>
	</div>
</div>
@if(count(Auth::user()->notifications))
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="modal-header mb-0">Notifications</h6>
            <div class="modal-body p-0">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
@endif