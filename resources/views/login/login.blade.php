<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>HRMIS</title>
	<link rel="icon" href="{{ asset('icon/hrmis.svg') }}" type="image/png"/>
	<link rel="stylesheet" type="text/css" href="{{ mix('/css/login.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container h-100">
		<div class="row align-items-center h-100">
			<div class="col-md-12 mx-auto">
				<div class="card mx-auto justify-content-center rounded-0" id="card-login">
					<div class="card-header bg-white text-center">
						<div class="row">
							<div class="col-md-12 text-center">
								<h1 class="d-inline-block"><img src="{{ asset('icon/hrmis.svg') }}" class="hrmis-icon" width="40" height="40"></h1> 
								<h1 class="d-inline-block vrams-login align-middle">HRMIS</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h5 class="title text-nowrap">Human Resource Management Information System</h5>
							</div>
						</div>
					</div>
					<div class="card-body pb-0">
						<form action="{{ route('login') }}" autocomplete="off" method="POST" accept-charset="UTF-8">
							{{ csrf_field() }}
							<div class="form-group row text-center">
								@if($errors->has('username'))
								<div class="col-md-12"><span class="help-block text-danger"><strong id="login-error">{{ $errors->first('username') }}</strong></span></div>
								@endif
							</div>
							<div class="form-group row mb-2">
								<div class="col-md-12">
									<div class="input-group input-group-sm">
										<div class="input-group-prepend"><span class="input-group-text rounded-0"><i class="fa fa-at fa-fw"></i></span></div>
										<input type="text" name="username" class="form-control form-control-sm rounded-0" placeholder="Username" required>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<div class="input-group input-group-sm">
										<div class="input-group-prepend"><span class="input-group-text rounded-0"><i class="fa fa-lock fa-fw"></i></span></div>
										<input type="password" name="password" class="form-control form-control-sm rounded-0" placeholder="Password" required>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 text-center">
									<input type="submit" value="Login" class="btn btn-primary btn-sm btn-block rounded-0 mb-1">
									<div>
										<span class="badge badge-info"><a href="#" class="text-white" data-toggle="modal" data-target="#privacyPolicy">Privacy Policy</a></span>
										<span class="badge badge-secondary"><a href="#" class="text-white" data-toggle="modal" data-target="#nda">Non-Disclosure Agreement (NDA)</a></span>
									</div>
									<div><small>Human Resource Management Information System</small></div>
									<div><small>Powered by DOST CALABARZON · MIS Unit</small></div>
									<div><small>ver {{ Config::get('app.version') }}</small></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="privacyPolicy" tabindex="-1" role="dialog" aria-labelledby="privacyPolicy" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg">
	        <div class="modal-content rounded-0">
	            <div class="card-header">
	                <div class="d-flex align-items-center">
	                    <span class="float-left mx-auto w-100">Privacy Policy</span>
	                </div>
	            </div>
	            <div class="modal-body">
	                <p>The Department of Science and Technology – CALABARZON respects the right to privacy and the confidentiality of your information. This Privacy Policy informs you of the purposes and the use of your personal information when collected for Human Resource Management.</p>
	                <p>Personal information is collected and used for a variety of personnel administration and general management purposes such as for administering compensation and benefits, performance evaluation and reviews, learning and development, promotion and succession planning, and for the effective and efficient maintenance of human resource records management.</p>
	                <p>The Human Resource Management Information System (HRMIS) (<a href="https://hrmis.dostcalabarzon.ph">https://hrmis.dostcalabarzon.ph</a>) is an information system that stores 201-files of DOST CALABARZON employees, enables online requesting and approval of travel orders, filing of compensatory time-offs, tracking and monitoring of overtime and leave credits, and online filing and approval of vehicle reservation. In June 2020, during the onset of the Covid19 pandemic, health screening information of employees are added to the system for the purpose of tracking health status of employees.</p>
	                <p>Our records may include your name, address and contact details, date and place of birth, age, civil status, citizenship. religion, government issued identification numbers such as SSS, TIN; educational background, civil service and government examinations passed, family background and information, employment records for both teaching and non-teaching experiences, skills and achievement, references, and medical exam results (collectively, “Employee Data”). These data are collected by the Human Resource Management Unit (HRMU) of DOST-CALABARZON through the HRMIS.</p>
	                <p>We ensure that the access security of personal information stored at HRMIS through implementation of necessary technical protection measures and operational control, applicable policies and procedures. The data collected will not be shared to any other entity and will only be used for legitimate HR-related purposes. Personal information (employee data) stored in at HRMIS are to be kept for 15 years based on “Pambasang Sinupan”.</p>
	                <p>By inputting your personal information, you are giving HRMU the consent to collect your personal information.</p>
	                <p>If at any point you have a complaint or request on the information stored in HRMIS, please let us know. You may contact us at (049) 536-5005 or send email at <a href="#">fashrdostiva@gmail.com.</a></p>
	                <p>FRANCISCO R. BARQUILLA III</p>
	                <p>Data Officer</p>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="modal fade" id="nda" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		    <div class="modal-content rounded-0">
		    	<div class="modal-header">
		    		Confidentiality and Non-Disclosure Agreement
		    	</div>
		    	<div class="modal-body">
		    		<div class="row">
		    			<div class="col-md-12">
		    				<p class="text-left">This Confidentiality and Non-Disclosure Agreement is made</p>
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-3">
		    				BETWEEN:
		    			</div>
		    			<div class="col-md-9">
		    				<div><u>The Officer-of-the-Day logged in to DOST CALABARZON's Health Information System</u></div>
		    				<div>(Receiving Party)</div>
		    			</div>
		    		</div>
		    		<div class="row pb-3">
		    			<div class="col-md-3">
		    				AND:
		    			</div>
		    			<div class="col-md-9">
		    				<div><u>Department of Science and Technology Region IVA (CALABARZON)</u></div>
		    				<div>(Disclosing Party)</div>
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-12">
		    				<p>WHEREAS, the DOST CALABARZON’s Health Information System, owned and operated by the Disclosing Party, collects and processes health information of its employees and customers for the purpose of effecting control of the COVID-19 infection</p>
		    				<p>WHEREAS, The Officer-of-the-Day logged in to DOST CALABARZON’s Health Information System and Department of Science and Technology Region IVA (CALABARZON) wish to evidence by this Agreement the manner in which said confidential and proprietary information will be treated.</p>
		    				<p>NOW THEREFORE, it is agreed as follow:</p>
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-11 offset-md-1">
				    		<table width="100%">
				    			<tr>
				    				<td width="5%" valign="top">1.</td>
				    				<td width="95%">
				    					<div><strong>USE OF INFORMATION SYSTEM</strong></div>
										<p>The Disclosing Party allows the Receiving Party use of its Health Information System.</p> 
				    				</td>
				    			</tr>
				    			<tr>
				    				<td width="5%" valign="top">2.</td>
				    				<td width="95%">
				    					<div><strong>PROPRIETARY INFORMATION</strong></div>
										<p>The Receiving Party acknowledges that all information received from the Disclosing Party’s employees and customers that are inputted into the DOST CALABARZON’s Health Information System are considered “Propriety Information” and are classified as “Confidential” to both parties; and the Receiving Party agrees to use reasonable care to safeguard the Proprietary Information and prevent the unauthorized use or disclosure thereof.</p>
				    				</td>
				    			</tr>
				    			<tr>
				    				<td width="5%" valign="top">3.</td>
				    				<td width="95%">
				    					<div><strong>NON-DISCLOSURE</strong></div>
				    					<p>The Receiving Party shall disclose or give access to Proprietary Information only to such persons having a need-to-know connection with the Receiving Party’s engagement and for use in connection therewith; and similarly the Receiving Party shall treat all information obtained during the course of engagement as confidential and disclose or share that information only with such persons having a need-to-know connection with the subject matter of the engagement.</p>
				    				</td>
				    			</tr>
				    			<tr>
				    				<td width="5%" valign="top">4.</td>
				    				<td width="95%">
				    					<div><strong>COPIES</strong></div>
				    					<p>Any copies or reproductions of the received files and databases shall bear the copyright to the Disclosing Party. Any copies or reproduction of Proprietary Information shall bear the copyright or proprietary notices contained in the original.</p>
				    				</td>
				    			</tr>
				    			<tr>
				    				<td width="5%" valign="top">5.</td>
				    				<td width="95%">
				    					<div><strong>TERMINATION</strong></div>
										<p>The Receiving Party shall, upon termination of its engagement under the contract with the Disclosing Party, shall certify in writing that is retains no copies of all Proprietary information, including any copies or reproductions thereof in the Receiving Party’s possession or control.</p>
				    				</td>
				    			</tr>
				    			<tr>
				    				<td width="5%" valign="top">6.</td>
				    				<td width="95%">
				    					<div><strong>EFFECTIVITY AND DURATION</strong></div>
										<p>This Agreement shall take effect upon signing in of the Receiving Party to the mentioned information system and shall perpetually be in force, unless sooner terminated by the Disclosing Party provided that a written notice shall have been served one month prior to termination.</p>
				    				</td>
				    			</tr>
				    		</table>
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-12">
		    				<p>IN WITNESS WHEREOF, the parties hereto have executed this Agreement.</p>
		    			</div>
		    		</div>
		    		<div class="row pb-3">
		    			<div class="col-md-12">
		    				<div>Signed</div>
		    				<div>Francisco R. Barquilla III</div>
		    				<div>Data Officer</div>
		    				<div>DEPARTMENT OF SCIENCE AND TECHNOLOGY REGION IVA (CALABARZON)</div>
		    			</div>
		    		</div>
		    		
		    	</div>
		    </div>
		</div>
	</div>
<!-- 	<footer class="footer mt-auto py-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<span class="badge badge-primary"><a href="#" class="text-white" data-toggle="modal" data-target="#privacyPolicy">Privacy Policy</a></span>
					<span class="badge badge-primary"><a href="#" class="text-white" data-toggle="modal" data-target="#nda">Non-Disclosure Agreement (NDA)</a></span>
				</div>
				<div class="col-md-6 text-right">
					<small class="text-white">Human Resource Management Information System · Powered by DOST CALABARZON · MIS Unit</small>
				</div>
			</div>
		</div>
	</footer> -->
</body>
</html>