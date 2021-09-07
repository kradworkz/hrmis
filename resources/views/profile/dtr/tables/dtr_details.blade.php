<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th class="text-nowrap">Day</th>
                <th></th>
                <th class="text-center">Time In</th>
                <th class="text-center">Time Out</th>
                <th class="text-center">Travel Order</th>
                <th class="text-center">Offset</th>
                <th class="text-center">No. of Minutes Earned</th>
                <th class="text-center">No. of Minutes Late</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $day)
                <tr>
                    <td>{!! $day->format('d') !!}</td>
                    <td>
                        @if($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday')
                            <i class="font-weight-bold text-warning">{!! $day->format('l') !!}</i> 
                        @else
                            @if(getHoliday($day) != '')
                                <a href="#" class="text-decoration-none" data-toggle="tooltip" data-title="{{ getHoliday($day) }}">{!! $day->format('l') !!}</a> 
                            @else
                                {!! $day->format('l') !!}
                            @endif
                        @endif
                    </td>
                    <td class="text-center">{!! getEmployeeAttendance(Auth::id(), $day, 0, 1) !!}</td>
                    <td class="text-center">{!! getEmployeeAttendance(Auth::id(), $day, 1, 1) !!}</td>
                    <td class="text-center">{!! getEmployeeTravel(Auth::id(), $day)  !!}</td>
                    <td class="text-center">{!! getEmployeeOffset(Auth::id(), $day)  !!}</td>
                    <td class="text-center text-success font-italic font-weight-bold">{!! getEmployeeEarned(Auth::id(), $day)  !!}</td>
                    <td class="text-center text-danger font-italic font-weight-bold">{!! getEmployeeLate(Auth::id(), $day) !!}</td>
                </tr>
                @php
                    if($day->isWeekday() && getHoliday($day) == '') { $working_days++; }
                    if(getEmployeeAttendance(Auth::id(), $day, 0, 1) && getEmployeeTravel(Auth::id(), $day) == "") { $biometrics++; }
                    if(getEmployeeTravel(Auth::id(), $day)) { $travel_count++; }
                    if(getEmployeeOffset(Auth::id(), $day)) { $offset_count++; }
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td class="font-weight-bold text-muted">{!! $working_days != '' ? $working_days." working days" : '' !!}</td>
                <td colspan="2" class="font-weight-bold text-center text-muted">{!! $biometrics != '' ? $biometrics." time in without travel" : '' !!}</td>
                <td class="font-weight-bold text-center text-muted">{!! $travel_count != '' ? $travel_count." travel(s)" : '' !!}</td>
                <td class="font-weight-bold text-center text-muted">{!! $offset_count != '' ? $offset_count." offset" : '' !!}</td>
                <td class="text-center"><i class="text-center text-success font-weight-bold" id="monthly_earned">{{ \Auth::user()->compute_attendance(1) ? \Auth::user()->compute_attendance(1)." minute(s)" : '' }}</i></td>
                <td class="text-center font-weight-bold">No. of times Late: <i class="text-center text-danger" id="monthly_late_count">{{ \Auth::user()->compute_attendance(0) }}</i></td>
            </tr>
        </tbody>
    </table>
</div>