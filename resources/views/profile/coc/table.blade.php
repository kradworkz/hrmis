@if(count($coc))
    <div class="table-responsive">
        <table class="table table-hover pb-0 mb-0">
            <thead>
                <tr>
                    <th class="text-center">No. of Hours Earned</th>
                    <th class="text-center">Date of CTO</th>
                    <th class="text-center">Used COCs</th>
                    <th class="text-center">Remaining COCs</th>
                    <th class="text-center">Remarks</th>
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
                @foreach($coc as $c)
                <tr>
                    <td class="text-center">{!! $c->beginning_hours != 0 ? $c->beginning_hours." hour(s)" : "" !!} {!! $c->beginning_minutes != 0 ? $c->beginning_minutes." minute(s)" : "" !!}</td>
                    <td class="text-center">{!! $c->offset != null ? $c->offset->date->format('F d, Y') : '' !!}</td>
                    <td class="text-center">{!! $c->offset != null ? $c->offset->hours." hour(s)" : '' !!}</td>
                    <td class="text-center">{!! $c->end_hours != 0 ? $c->end_hours." hour(s)" : "" !!} {!! $c->end_minutes != 0 ? $c->end_minutes." minute(s)" : "" !!}</td>
                    <td class="text-center">{!! date("F", mktime(0, 0, 0, $c->month, 10)) !!} {!! $c->year !!}</td>
                    <td class="text-right">
                        @if($c->offset_id == null)<i class="font-weight-bold {{ $c->type == 1 ? 'text-success' : 'text-danger' }}">{!! $c->type == 1 ? 'Credit' : 'Lapse' !!}</i>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif