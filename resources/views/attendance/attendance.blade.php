<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Attendance</title>
	<link rel="icon" href="{{ asset('icon/vrams.jpg') }}" type="image/png"/>
	<link href="{{ asset('tools/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <script src="{{ asset('tools/jquery/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('tools/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('tools/moment/moment.min.js') }}" type="text/javascript"></script>
</head>
<style type="text/css">
 	body, html {
 		height: 100%;
 		background-color: #4d7496 !important;
 	}

	::-webkit-input-placeholder {
	   text-align: center;
	}

	:-moz-placeholder {
	   text-align: center;  
	}

	::-moz-placeholder {
	   text-align: center;  
	}

	:-ms-input-placeholder {  
	   text-align: center; 
	}

	input {
		text-align: center;
	}

	#name {
		letter-spacing: -2px;
		font-family: arial;
	}

	.vertical-center {
		min-height: 70%;
		min-height: 70vh;

		display: flex;
		align-items: center;
	}

	#datetime {
		text-transform: uppercase;
		font-size: 72px;
		font-family: impact;
	}

	.bg-vrams {
		background-color: #4d7496 !important;
	}

	.footer {
		position: fixed;
	    left: 0;
	    bottom: 0;
	    width: 100%;
	    color: white;
	    text-align: center;
	}
</style>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-center pt-5">
				<br>
				<div class="mx-auto" id="datetime"></div>
			</div>
		</div>
		<div class="vertical-center">
			<div class="container-fluid">
				<div class="card-deck">
					<div class="card rounded-0 border-0">
						<table class="table table-bordered table-sm text-center dtr-tbl" style="height: 100%">
							<thead>
								<tr>
									<th class="align-middle" rowspan="2" width="10%">DAY</th>
									<th colspan="2">DAILY TIME RECORD</th>
								</tr>
								<tr>
									<th width="45%">IN</th>
									<th width="45%">OUT</th>
								</tr>
							</thead>
							<tbody>
							@for($i = 1; $i < 16; $i++)
								<tr class="{{ $i == date('j') ? 'bg-vrams text-white' : '' }}">
									<td id="{{ $i }}">{{ $i }}</td>
									<td class="dtr-info">&nbsp</td>
									<td class="dtr-info">&nbsp</td>
								</tr>
							@endfor
							</tbody>
						</table>
					</div>
					<div class="card border-0 rounded-0">
						<div class="card-body">
							<img class="rounded-circle img-responsive mx-auto mt-3 mb-2 d-block" src="{{ asset('images/blank-profile.jpg') }}" id="profile" alt="Profile Picture" height="300" width="300">
							<div class="text-center"><h3 id="name">&nbsp</h3></div>
							<label class="col-md-12 text-center text-nowrap" id="error-msg">&nbsp</label>
							<input type="search" class="form-control p-1 mb-3 my-2 rounded-0" id="search" placeholder="Username" autocomplete="off">
							<input type="password" class="form-control p-1 my-3 rounded-0" id="password" placeholder="Password" autocomplete="off">
							<div class="text-center validation-container">
								<h3 id="msg" class="pt-3"></h3>
							</div>
						</div>
					</div>
					<div class="card rounded-0 border-0">
						<table class="table table-bordered table-sm text-center dtr-tbl" style="height: 100%">
							<thead>
								<tr>
									<th class="align-middle" rowspan="2" width="10%">DAY</th>
									<th colspan="2">DAILY TIME RECORD</th>
								</tr>
								<tr>
									<th width="45%">IN</th>
									<th width="45%">OUT</th>
								</tr>
							</thead>
							<tbody>
							@for($i = 16; $i < 32; $i++)
								<tr class="{{ $i == date('j') ? 'bg-vrams text-white' : '' }}">
									<td id="{{ $i }}">{{ $i }}</td>
									<td class="dtr-info">&nbsp</td>
									<td class="dtr-info">&nbsp</td>
								</tr>
							@endfor
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center pt-3">
				<h4>NOTE: USE YOUR <strong><i class="text-danger">VRAMS</i></strong> ACCOUNT TO TIME IN/TIME OUT.</h4>
			</div>
		</div>
	</div>
	<div class="footer text-center p-1">
		© {!! date('Y') !!} Department of Science and Technology CALABARZON.
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('#search').focus();

			$.ajaxSetup({
			    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			setInterval(function() {
				$('#datetime').html(moment().format('MMMM DD YYYY, hh:mm:ss A'));
			}, 1000);
			
			$('#search').keyup(function(e) {
				$('#time-in, #time-out, #msg').html('&nbsp');
				clearTimeout($.data(this, 'timer'));
				if(e.keyCode == 13) {
					search(true);
				} else {
					$(this).data('timer', setTimeout(search, 500));
				}
			});

			$('#password').keydown(function(e) {
				clearTimeout($.data(this, 'timer'));
				if(e.keyCode == 13) {
					login(true);
				} else {
					$(this).data('timer', setTimeout(login, 500));
				}
			});

			function search(force) {
				var existingString = $('#search').val();
				$.get('{!! URL::to("/") !!}'+'/attendance/search/'+existingString, function(data) {
					if(data['employee'] !== null) {
						$('#error-msg').text("");
						$('.dtr-tbl tr .dtr-info').text("");
						$('#name').text(data['employee'].full_name);
						$('#profile').attr('src', data['employee'].picture == null ? "{!! asset('images/blank-profile.jpg') !!}" : "{!! asset('storage/profile/"+data["employee"].picture+"') !!}");
						$('#search').removeClass('is-invalid').addClass('is-valid');
						$.each(data['dtr'], function(key, value) {
							var days = $('#'+value.day).text();
							if(value.day == days) {
								$('#'+value.day).next('td').append("<div>"+value.dtr_in+"</div>");
								$('#'+value.day).next('td').next().append(value.dtr_out == null ? "" : "<div>"+value.dtr_out+"</div>");
							}
						});
					}
					else {
						$('.dtr-tbl tr .dtr-info').text("");
						$('#name').html('&nbsp');
						$('#error-msg').html('NO RECORD FOUND. KEYWORD: <i class="text-danger"><strong>'+existingString+'</strong></i>');
						$('#profile').attr('src', "{!! asset('images/blank-profile.jpg') !!}");
						$('#search').removeClass('is-valid').addClass('is-invalid');
					}
				});
			}

			function login(data) {
				var username = $('#search').val();
				var password = $('#password').val();
				var mode 	 = $('.active').text();

				$.ajax({
					type: "POST",
					url: '{!! URL::to("/") !!}'+'/attendance/login',
					data: {"username" : username, "password" : password},
					success: function(data) {
						$('.dtr-tbl tr .dtr-info').html("")
						$.each(data.dtr, function(key, value) {
							var days = $('#'+value.day).text();
							if(value.day == days) {
								$('#'+value.day).next('td').append("<div>"+value.dtr_in+"</div>");
								$('#'+value.day).next('td').next().append(value.dtr_out == null ? "" : "<div>"+value.dtr_out+"</div>");
							}
						});

						if(data.result == 0) {
							$('#search, #password').val('').removeClass('is-valid is-invalid');
							$('#search').focus();
							$('#error-msg').text("");
							$('#msg').html('<i class="fa fa-check-circle text-success"></i> Time In: '+moment().format('LT'));
						}
						else if(data.result == 1) {
							$('#search, #password').val('').removeClass('is-valid is-invalid');
							$('#search').focus();
							$('#error-msg').text("");
							$('#msg').html('<i class="fa fa-check-circle text-success"></i> Time Out: '+moment().format('LT'));
						}
						else if(data.result == 2) {
							$('#error-msg').html('<strong class="text-danger">INVALID PASSWORD!</strong>');
							$('#password').removeClass('is-valid').addClass('is-invalid');
						}
					}
				});
			}
		});
	</script>
</body>
</html>