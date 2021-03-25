<!DOCTYPE html>
<html>
<head>
	<title></title>
		<!-- Latest compiled and minified CSS -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



</head>
<body style="font-size:18px; margin-top" onload="window.print()">
	<div>
		<img src="{{ asset("storage/header_mata.png") }}" width="100%"></img>
		
		@foreach($service as $row)
		<div style="text-align: center; margin-top:px;">
			
{{-- 
			<p>Branch:{{$branch_location->branch_location}}</p> --}}
			{{-- fuck this --}}
		</div>
		
		<br>
			<h1 style="text-align: center;"><strong>OFFICIAL CONTRACT</strong>	</h1>
			<br>
			<br>
			<p>I <strong><i>{{$row->name}}</i></strong> of legal age, {{$row->status}} and resident of <strong><i>{{$row->address}}</i></strong> and currently using the phone number <strong><i>{{$row->phone_number}}</i></strong></p>
			<p>Have entered into this Contract on <strong><i>{{$row->date}}</i></strong> with MATA FUNERAL HOMES & PLAN. INC. {{$branch_location->branch_location}} Branch to undertake the funeral of late <strong>{{$row->name_of_deceased}}</strong>.		

			<p><strong>Date of Birth:</strong> {{$row->date_of_birth}}</p>
			<p><strong>Date of Death:</strong> {{$row->date_of_death}}</p>
			<hr>
			Covering the following:
			<br>
			<br>
			<p><strong>Type of Casket: </strong>{{$row->type_of_casket}}</p>
			<p><strong>Days Embalming: </strong>{{$row->days_embalming}}</p>
			<p><strong>Service Description: </strong>{{$row->service_description}}</p>
			<p><strong>Freebies Inclusion: </strong>{{$row->freebies_inclusion}}</p>
			<p><strong>Interment Schedule: </strong>{{$row->interment_schedule}}</p>
			
			<hr>
			<h2>Payments Information</h2>
			<br>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Payment ID</th>
						<th>Date</th>
						<th>Mode of Payment</th>
						<th>Amount</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($payments as $payment)
					<tr>
						{{-- <td>{{$first_payment->id}}</td>
						<td>{{$first_payment->date_created}}</td>
						<td>{{$first_payment->mode_of_payment}}</td>
						<td>{{$first_payment->amount}}</td>
						<td>{{$first_payment->remarks}}</td>
						@if($first_payment->verified == '1')
							<td>Verified</td>
						@else
							<td>Unverified</td>
						@endif --}}
						<td>{{$payment->id}}</td>
						<td>{{$payment->date_created}}</td>
						<td>{{$payment->mode_of_payment}}</td>
						<td>{{$payment->amount}}</td>
						<td>{{$payment->remarks}}</td>
						@if($payment->verified == '1')
							<td>Verified</td>
						@else
							<td>Unverified</td>
						@endif 
						
					</tr>
					@endforeach
				</tbody>
			</table>
			<br>
			<p>That in consideration of the foregoing Services to be rendered, I hereby assumed to pay to the MATA FUNERAL HOMES & PLAN, INC. {{$branch_location->branch_location}} Branch, the sum of <strong>{{$row->contract_amount}}</strong> Pesos.

			<p>I hereby promise to pay the balance of <strong>{{$row->balance}}</strong> pesos upon termination of all services.</p>
			<p>In case of non-payment Maturity, I further agree to pay the cost expenses & Attorney's fee for collection in case of legal steps are taken before the court. I further agree any competent courts in Tandag City, Cantilan Surigao del Sur.</p>

			<br>
			<br>
			<div class="row">
				<p class="col">Contracting Party:</p>
				
				<p class="col">Approved:</p>
				
			</div>
		
			
			<div class="row	">
				<p class="col">___________________________________</p>
				
				<p class="col">___________________________________</p>
			</div>
			<div class="row">
				<div class="col">
					<p>Contract Party</p>
					<p>(Signature over printed name)</p>
				</div>
				<div class="col">
					<p>Mata Funeral Homes & Plan Inc. Authorized Representative</p>
				</div>

			</div>
			
			
			
		@endforeach
	</div>
</body>
</html>
<style type="text/css">
	
</style>