@if($otr)
<div class="table-responsive">
    <table class="table table-sm table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap">Date</th>
                <th class="text-nowrap">Purpose</th>
                <th class="text-center">Status</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($otr as $ot)
            <tr>
            	<td>{!! $loop->iteration !!}</td>
            	<td class="text-nowrap"><a class="text-primary" data-toggle="tooltip" data-placement="left" title="{{ $ot->overtime_personnel_names() }}" href="#">{!! $ot->overtime_dates !!}</a></td>
            	<td>{!! nl2br($ot->purpose) !!}</td>
            	<td class="text-center">@include('layouts.status', ['approvals' => $ot])</td>
                <td class="text-right">
                    <a href="{{ route('Print Overtime', ['id' => $ot->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif