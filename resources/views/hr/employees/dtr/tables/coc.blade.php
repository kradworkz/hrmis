<div class="table-responsive">
    <table class="table table-sm table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th class="text-center">No. of Hours Earned</th>
                <th class="text-center">Date of CTO</th>
                <th class="text-center">Used COCs</th>
                <th class="text-center">Remaining COCs</th>
                <th class="text-center">Date Encoded</th>
                <th class="text-center">Lapse Date</th>
                <th class="text-right">Type</th>
            </tr>
            <tr>
            	<th class="text-center">COCs/Beginning Balance</th>
            	<th></th>
            	<th></th>
            	<th></th>
            	<th class="text-center">(COC Earned for the month of)</th>
            </tr>
        </thead>
        <tbody>
        @if(count($coc))
            @foreach($coc as $c)
            <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Employee COC', ['employee_id' => $employee->id, 'coc_id' => $c->id]) }}">
                <td class="text-center font-italic font-weight-bold {{ $c->type == 1 ? 'text-success' : 'text-secondary' }}">
                    {!! $c->beginning_hours != 0 ? $c->beginning_hours." hour(s)" : "" !!} {!! $c->beginning_minutes != 0 ? $c->beginning_minutes." minute(s)" : "" !!}
                </td>
            	<td class="text-center">{!! $c->offset != null ? $c->offset->date->format('F d, Y') : '' !!}</td>
            	<td class="text-center font-italic text-danger font-weight-bold">{!! $c->offset != null ? $c->offset->hours." hour(s)" : '' !!}</td>
            	<td class="text-center {{ $loop->last ? 'text-primary font-weight-bold font-italic' : '' }}">{!! $c->end_hours != 0 ? $c->end_hours." hour(s)" : "" !!} {!! $c->end_minutes != 0 ? $c->end_minutes." minute(s)" : "" !!}</td>
            	<td class="text-center">{!! date("F", mktime(0, 0, 0, $c->month, 10)) !!} {!! $c->year !!}</td>
                <td class="text-center">
                    @if($c->lapse_month != NULL)
                        {!! date("F", mktime(0, 0, 0, $c->lapse_month, 10)) !!} {!! $c->lapse_year !!}
                    @endif
                </td>
            	<td class="text-right">
                    @if($c->offset != null)
                        <i class="font-weight-bold text-danger">Offset</i>
                    @elseif($c->type == 1)
                        <i class="font-weight-bold text-success">Credit</i>
                    @else
                        <i class="font-weight-bold text-secondary">Lapse</i>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>