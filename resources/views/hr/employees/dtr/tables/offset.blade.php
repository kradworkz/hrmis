<div class="table-responsive">
    <table class="table table-sm table-hover table-borederd mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th class="text-center">Hours</th>
                <th class="text-center text-nowrap">Status</th>
                <th>Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($offset))
                @php $total_offset = 0; @endphp
                @foreach($offset as $off)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-nowrap">{{ $off->date->format('F d, Y') }}</td>
                    <td class="text-center">{{ $off->hours }}</td>
                    <td class="text-center text-nowrap">
                    @if($off->is_active == 1)
                        {!! getStatus($off) !!}
                    @else
                        <i><small class="text-danger font-weight-bold">CANCELLED</small></i>
                    @endif
                    </td>
                    <td class="text-nowrap">{!! getDateDiff($off->created_at) !!}</td>
                    <td class="text-right">
                        <a href="{{ route('Print Offset', ['id' => $off->id]) }}" target="_blank" class="badge badge-primary rounded-0 py-1" data-toggle="tooltip" data-placement="top" title="Print">PRINT</a>
                    </td>
                </tr>
                @if($off->is_active) @php $total_offset += $off->hours; @endphp @endif
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center">{!! $total_offset !!}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>