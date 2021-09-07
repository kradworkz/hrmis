<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{!! $emp->full_name !!}</title>
	<link rel="icon" href="{{ asset('icon/vrams.jpg') }}" type="image/png"/>

    <style type="text/css">
    	body, html {
    		width: 100%;
    		height: 100%;
    		background-color: #212121;
    		color: white;
    		font-family: "Segoe UI";

    		display: flex;
    		flex-direction: column;
    		align-items: center;
    		justify-content: center;

    		border: 0;
    		margin: 0;
    		padding: 0;
    	}

    	th {
    		font-size: 18px;
    		font-weight: normal;
    	}

    	td {
    		font-size: 16px;
    	}

    	th, td, .row-image, .row-text1, .row-text2 {
    		background-color: #0D47A1;
    	}

    	.page-wrapper{
    		display: inline-block;
    		float: none;
    	}

    	.column {
    		border: 0;
    		margin: 6px;
    		padding: 0;
    		background: none;
    		float: left;
    	}

    	.column-table{

    	}

    	.dtr-table {
    		width: 100%;
    		height: 483px;

    		color: white;
  			text-align: center;

    		border: 0;
    		padding: 0;

    		border-collapse: separate;
    		border-spacing: 1px;

    		background: none;

    	}

	   	.row-image{
	   		margin-top: 1px;
    		width: 380px;
    		height: 380px;
    	}

    	.row-text1{
    		margin-top: 8px;
    		width: 380px;
    		height: 48px;
    		display: flex;
    		align-items: center;
    		justify-content: center;

            background: #ffc107;
    	}

    	.row-text2{
    		margin-top: 8px;
    		width: 380px;
    		height: 47px;
    		display: flex;
    		align-items: center;
    		justify-content: center;

            background: #dd2c00;
    	}

    	.text-label {
    		font-size: 18px;
            font-weight: bold;
            color: #404040;
    	}

    	.text-label2 {
    		font-size: 18px;
    		font-weight: bold;
            color: #ffffff;
    	}


    	.col1{
    		width: 47px;
    		height: 26px;
    	}

    	.col2{
    		width: 100px;
    		height: 26px;
    	}

    	.col3{
    		width: 100px;
    		height: 26px;
    	}

    	.selected .col1, .selected .col2, .selected .col3{
    		color: #404040;
    		background: #ffc107;
    		font-weight: bold;
    	}

        .profile-picture {
            height: 100% !important;
            width: 100% !important;
        }
    </style>
</head>
<body>
	<div class="page-wrapper">
		<div class="column">
			<div class="row-image">
				<img class="card-img profile-picture" src="{{ route('get-picture', ['filename' => $emp->picture == null ? 'blank-profile.jpg' : $emp->picture ]) }}" style="height: 100; width: 100">
			</div>
			<div class="row-text1">
				<div class="text-label">{!! $emp->full_name !!}</div>
			</div>
			<div class="row-text2">
				<div class="text-label2">{!! date('F d, Y h:i:s A') !!}</div>
			</div>
		</div>
		<div class="column">
			<table class="dtr-table">
				<thead>
					<tr>
						<th class="col1">Day</th>
						<th class="col2">In</th>
						<th class="col3">Out</th>
					</tr>
				</thead>
				<tbody>

					<?php

					// LOOP THROUGH THE DAYS
					$day = 1;
					$ctr = 0;
					$lastDiv = 0;
					$light = '';

					while ($day <= 31){

						if ($day == date('j')){
							$light = 'class="selected"';
						} else {
							$light = '';
						}

						$d = date('Y-m-').(strlen($day.'') < 2 ? '0'.$day : $day);
						$found = false;
						foreach ($rows as $row) {
							$date = $row->time_in->format('Y-m-d');

							if ($d == $date){
	                        	?>
	                        	<tr {!! $light !!}>
									<td class="col1">{{ $row->time_in->format('j') }}</td>
									<td class="col2">{{ $row->time_in->format('h:i:s A') }}</td>
									<td class="col3">{{ (!is_null($row->time_out) ? $row->time_out->format('h:i:s A'): '') }}</td>
								</tr>
	                        	<?php
	                        	$ctr++;
								$found = true;

								if ( (($ctr % 16) == 0) && ($ctr != $lastDiv) ) {
									?>
											</tbody>
										</table>
									</div>
									<div class="column">
										<table class="dtr-table">
											<thead>
												<tr>
													<th class="col1">Day</th>
													<th class="col2">In</th>
													<th class="col3">Out</th>
												</tr>
											</thead>
											<tbody>
									<?php
									$lastDiv = $ctr;
								}

							}

						}
                        if (!$found){
                        	?>
                        	<tr {!! $light !!}>
								<td class="col1">{{ $day }}</td>
								<td class="col2"></td>
								<td class="col3"></td>
							</tr>
                        	<?php
                        	$ctr++;

							if ( (($ctr % 16) == 0) && ($ctr != $lastDiv) ) {
								?>
										</tbody>
									</table>
								</div>
								<div class="column">
									<table class="dtr-table">
										<thead>
											<tr>
												<th class="col1">Day</th>
												<th class="col2">In</th>
												<th class="col3">Out</th>
											</tr>
										</thead>
										<tbody>
								<?php
								$lastDiv = $ctr;
							}

                        }
                        $day++;

					}

                    if (($ctr % 16) > 0){
                        $max = 16 - ($ctr % 16);
                        for ($i = 0; $i < $max; $i++){
                            ?>
                            <tr>
                                <td class="col1"></td>
                                <td class="col2"></td>
                                <td class="col3"></td>
                            </tr>
                            <?php
                        }

                    }
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>