<!DOCTYPE html>
<html>
<head>
	<title></title>
		<!-- Latest compiled and minified CSS -->


</head>
<body style="font-size:12px;">
	<div>
		<img src="https://i.imgur.com/Y3hqiHf.png" width="720">
		@foreach($service as $row)
		<div style="text-align: center; margin-top:-50px;">
			<pre>Head Office: 072 National Highway, Linibunan, Madrid, Surigao del Sur</pre>

			<pre><strong>Branch:{{$branch_location->location}}</strong></pre>
		</div>
		<br>
			<h1 style="text-align: center;">OFFICIAL CONTRACT</h1>
			<p>I <strong><i>{{$row->name}}</i></strong> of legal age and resident of <strong><i>{{$row->address}}</i></strong> and currently using the phone number <strong><i>{{$row->phone_number}}</i></strong></p>
			<p>Have on this <strong><i>{{$row->date}}</i></strong> entered into Contract with MATA FUNERAL HOMES & PLAN, INC. <i>{{$branch_location->location}}</i> Branch to undertake the funeral services of late <strong><i>{{$row->name_of_deceased}}</i></strong> </p>
			<br>
			

			<p>Covering the Following:</p>
			<hr>
			<p>Deceased Date Information: <strong><i>{{$row->deceased_date}}</i></strong></p>
			<p>Days Embalming:</p>
			<p>Arrangement:</p>
			<p>Kind of Coach:</p>
			<p>Interment on:</p>
			<p>Extra:</p>
			<p>Payment:</p>
			<p>Total Charges</p>
			<br>
			<hr>
			<p>Total Freebies:</p>
			<br>
			<hr>
			
			<p>That in consideration of the foregoing Services to be rendered, I hereby assumed to pay to the MATA FUNERAL HOMES & PLAN, INC. {{$branch_location->location}} Branch, the sum of _________________________________________________________________ Pesos, after paying an advance of ___________ Pesos.</p>

			<p>I hereby promise to pay the balance of _____________ pesos upon termination of all services.</p>
			<p>In case of non-payment Maturity, I further agree to pay the cost expenses & Attorney's fee for collection in case of legal steps are taken before the court. I further agree any competent courts in Tandag City, Cantilan Surigao del Sur.</p>

			<br>
			<br>
			<p>Approved: </p>
			<p>Contracting Party: </p>
			
		@endforeach
	</div>
</body>
</html>