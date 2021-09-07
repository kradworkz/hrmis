<div class="card h-100 border-0">
    <div class="table-responsive">
        <table class="table-dtr table-bordered pb-0 mb-0">
            <thead>
                <tr>
                    <th rowspan="3">Day</th>
                </tr>
                <tr>
                    <th colspan="2">A.M.</th>
                    <th colspan="2">P.M.</th>
                    <th colspan="2">Overtime</th>
                </tr>
                <tr>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Hours</th>
                    <th>Minutes</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i < 32; $i++)
                    @php $date = $year."-".$month."-".sprintf('%02d', $i) @endphp
                    <tr>
                        <td>{!! $i !!}</td>
                    @if(get_employee_schedule($date, $month, $year, $employee->id)['mode'] == 'Official Business')
                        @if(get_employee_schedule($date, $month, $year, $employee->id)['schedule']->time_mode == 'AM')
                            <td colspan="2" class="text-primary">Official Business</td>
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))    
                                @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                    {!! get_attendance($date, $month, $employee->id)[1]->time_in->format('g:i A') !!}
                                @endif
                            @endif
                            </td>
                            <td>
                                @if(!empty(get_time_out($date, $employee->id)))
                                    {!! get_time_out($date, $employee->id)->time_out != null ? get_time_out($date, $employee->id)->time_out->format('g:i A') : '' !!}
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                        @elseif(get_employee_schedule($date, $month, $year, $employee->id)['schedule']->time_mode == 'PM')
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                @endif
                            @endif
                            </td>
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_out != null ? get_attendance($date, $month, $employee->id)[0]->time_out->format('g:i A') : '' !!}
                                @endif
                            @endif
                            </td>
                            <td colspan="2" class="text-primary">Official Business</td>
                            <td></td>
                            <td></td>
                        @else
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                @endif
                            @endif
                            </td>
                            <td colspan="2" class="text-primary">Official Business</td>
                            <td>
                                @if(!empty(get_time_out($date, $employee->id)))
                                    {!! get_time_out($date, $employee->id)->time_out != null ? get_time_out($date, $employee->id)->time_out->format('g:i A') : '' !!}
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                        @endif
                    @elseif(get_employee_schedule($date, $month, $year, $employee->id)['mode'] == 'Offset')
                        @if(get_employee_schedule($date, $month, $year, $employee->id)['schedule']->time == '8:00 to 12:00')
                            <td colspan="2" class="text-danger">Offset</td>
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                @endif
                            @endif
                            </td>
                            <td>
                                @if(!empty(get_time_out($date, $employee->id)))
                                    {!! get_time_out($date, $employee->id)->time_out != null ? get_time_out($date, $employee->id)->time_out->format('g:i A') : '' !!}
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                        @elseif(get_employee_schedule($date, $month, $year, $employee->id)['schedule']->time == '1:00 to 5:00')
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                @endif
                            @endif
                            </td>
                            <td>
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    {!! get_attendance($date, $month, $employee->id)[0]->time_out != null ? get_attendance($date, $month, $employee->id)[0]->time_out->format('g:i A') : '' !!}
                                @endif
                            @endif
                            </td>
                            <td colspan="2" class="text-danger">Offset</td>
                            <td></td>
                            <td></td>
                        @else
                            <td colspan="4" class="text-danger">Offset</td>
                            <td></td>
                            <td></td>
                        @endif
                    @else
                        @if(date_format(date_create($date), "l") == 'Saturday' || date_format(date_create($date), "l") == 'Sunday' || vrams\CalendarEvent::whereDate('date', '=', $date)->first() != null)
                            @if(!empty(get_attendance($date, $month, $employee->id)))
                                @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                    <td>
                                        @if(!empty(get_attendance($date, $month, $employee->id)))
                                            @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                                {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty(get_attendance($date, $month, $employee->id)))
                                            @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                                {!! get_attendance($date, $month, $employee->id)[0]->time_out != null ? get_attendance($date, $month, $employee->id)[0]->time_out->format('g:i A') : '' !!}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty(get_attendance($date, $month, $employee->id)))
                                            @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                                {!! get_attendance($date, $month, $employee->id)[1]->time_in->format('g:i A') !!}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty(get_time_out($date, $employee->id)))
                                            {!! get_time_out($date, $employee->id)->time_out != null ? get_time_out($date, $employee->id)->time_out->format('g:i A') : '' !!}
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                @else
                                    <td colspan="4" class="text-success">
                                        @if(vrams\CalendarEvent::where('is_active', '=', 1)->whereDate('date', '=', $date)->first() != null)
                                            Holiday
                                        @elseif(date_format(date_create($date), "l") == 'Saturday')
                                            Saturday
                                        @elseif(date_format(date_create($date), "l") == 'Sunday')
                                            Sunday
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                @endif
                            @endif
                        @else
                            <td>
                                @if(!empty(get_attendance($date, $month, $employee->id)))
                                    @if(count(get_attendance($date, $month, $employee->id)) != 0)
                                        {!! get_attendance($date, $month, $employee->id)[0]->time_in->format('g:i A') !!}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!empty(get_attendance($date, $month, $employee->id)))
                                    @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                        {!! get_attendance($date, $month, $employee->id)[0]->time_out != null ? get_attendance($date, $month, $employee->id)[0]->time_out->format('g:i A') : '' !!}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!empty(get_attendance($date, $month, $employee->id)))
                                    @if(count(get_attendance($date, $month, $employee->id)) >= 2)
                                        {!! get_attendance($date, $month, $employee->id)[1]->time_in->format('g:i A') !!}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!empty(get_time_out($date, $employee->id)))
                                    {!! get_time_out($date, $employee->id)->time_out != null ? get_time_out($date, $employee->id)->time_out->format('g:i A') : '' !!}
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                        @endif
                    @endif
                    </tr>
                @endfor
                <tr>
                    @if(Auth::user()->desktop_time_in == 1)
                        <td class="text-center" colspan="4">
                            <a href="{{ route('dtr') }}" class="btn btn-success btn-block btn-xs {{ $attendance == true ? 'disabled' : '' }}">Time In</a>
                        </td>
                        <td class="text-center" colspan="4">
                            <a href="{{ route('dtr') }}" class="btn btn-danger btn-block btn-xs {{ $attendance != true ? 'disabled' : '' }}">Time Out</a>
                        </td>
                    @else
                        <td colspan="8"></td>
                    @endif
                </tr>
                <tr>
                    <td colspan="8"><small class="text-danger text-justify"><i>
                        CSC MC No. 1 s. 2017 <strong>Section 46 (F) (4), RRACCS</strong>, Frequent Unauthorized Tardiness (Habitual Tardiness) is a light offense punishable by reprimand for the first offense, suspension of one (1) to
                        thirty (30) days for the second offense, and dismissal from the service for the third offense. It is committed when an official or employee incurs
                        tardiness, regardless of the number of minutes, ten (10) times a month for at least two(2) months in a semester or at least two (2) consecutive months
                        during the year.
                        <br><br>
                        The classification of Habitual Tardiness as either a grave offense or a light offense would depend on the frequency or regularity of its commission and its
                        effects on the government service.
                    </i></small></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="8">
                        <a class="btn btn-info btn-block btn-xs" href="{{ route('Print Daily Time Record', ['id' => Auth::id(), 'month' => $month, 'year' => $year]) }}" target="_blank">PRINT</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
