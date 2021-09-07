@extends('layouts.content')
@section('content')
<style type="text/css">
	.bar-name {
		font-size: 8px;
		word-wrap: break-word;
		max-width: 200px;
	}
</style>
<div>
<?php
$rows = hrmis\Models\QrCode::orderBy('qrcode', 'ASC')->get();
$logo = '/public/images/dost24.png'; // realpath('images').DIRECTORY_SEPARATOR.'dost24.png';
?>
@foreach ($rows as $row)
	<div class="d-inline-block m-4 p-1 text-center">
		<img src="data:image/png;base64, {!! base64_encode(QrCode::errorCorrection('H')->format('png')->merge($logo)->size(200)->generate($row->qrcode)) !!} ">
		<div class="bar-name">
		<br>
		{{  $row->qrcode  }}
		</div>
	</div>
@endforeach
</div>
@endsection