<!DOCTYPE html>
<html>
<head>
	<title>Print Summary</title>
</head>
<body style="font-size: 12px;">
	

	<div>
		{{-- <img src="https://i.imgur.com/Y3hqiHf.png" width="500">	 --}}
		<h1 style="font-size:50px;">MATA DIRECT SERVICES</h1>
		<hr>
		<br>
		<span style="font-size: 18px;">Collection Summary for Month: <strong>{{$month}}</strong> and Year: <strong>{{$year}}</strong></span>
		<br>
		<br>
		<table class="table">
			<thead>
				<tr>
					<th>DSWD</th>
					<th>MSWDO</th>
					<th>LGU</th>
					<th>PSWD</th>
					<th>Cheque</th>
					<th>Total Discount</th>
					<th>Cash on hand</th>
					<th>Amount of Cash Collected</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($results as $res)
						<td>{{$res}}</td>
					@endforeach
				</tr>
				<!-- footer -->
			</tbody>
		</table>
		<br>
		<br>
		<br>
		<strong style="font-size: 19px;">SERVICES THIS MONTH</strong>
		<table class="table dark">
			<thead>
				<tr>
					<th>Contract_No</th>
					<th>Name</th>
					<th>Name of Deceased</th>
					<th>Address</th>
					<th>Amount</th>
					<th>Phone Number</th>
					<th>Down Payment</th>
					<th>Balance</th>
					<th>Type of Casket</th>
				</tr>
			</thead>
			<tbody>
				@foreach($services as $service)
				<tr>
					<td>{{$service->contract_no}}</td>
					<td>{{$service->name}}</td>
					<td>{{$service->name_of_deceased}}</td>
					<td>{{$service->address}}</td>
					<td>{{$service->amount}}</td>
					<td>{{$service->phone_number}}</td>
					<td>{{$service->down_payment}}</td>
					<td>{{$service->balance}}</td>
					<td>{{$service->type_of_casket}}</td>
				</tr>	
				@endforeach
			</tbody>
		</table>
		<br>
		<br>
		<br>
		<small>Sent from Branch: <strong>{{$branch}}, Surigao del Sur</strong>
			<br>www.matafuneralhomes.com
		</small>
	<!-- 	@foreach($results as $res)

			<li>{{$res}}</li>

		@endforeach -->
	</div>
	
</body>
</html>
<style type="text/css">
	table, tr, th{
		border-style: solid;
		padding:2px;
	}
	table, td{
		padding:2px;
	} 
	body{
		font-family: sans-serif;
	}
</style>