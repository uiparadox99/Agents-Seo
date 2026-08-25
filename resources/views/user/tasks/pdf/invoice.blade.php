<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<style type="text/css">
@page {
                margin: 100px 25px;
				size: 'A4';
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

            }
	body {
		/* margin-top: 0px;margin-left: 0px; */
		font-family: 'sans-serif;';}

	/* #page_1 {position:relative; overflow: hidden;margin:20px 10px;padding: 0px;border: none;} */
	table{
		width: 100%;
		text-align: left;
	}
	.items-table{
		text-align: center !important;	
	}
	.items-table thead tr{
		background: #ddd;
		color: black;
	}
	.items-table thead tr th{
		padding: 3px;
		text-transform: uppercase;
		font-size: 15px;
	}
	.items-table tbody tr td{
		padding: 3px;
		font-size: 15px;
	}
	h4{
		margin: 0;
	}
	h3{
		margin: 0;
	}
	p.page { page-break-after: always; }
    p.page:last-child { page-break-after: never; }
</style>
</head>
<body>
	<header>
		<table>
			<tr style="margin-bottom:20px"> 
				<td style="width:33.3%">
					<div style="border:1px solid #ddd;padding: 10px;">
					{!! nl2br($party)!!}
						
					</div>
				</td>
					<td style="width:33.3%;text-align: center;">
					<h2>INVOICE</h2>
				</td>
				<td  style="width:33.3%;text-align: right;position: relative;">
					<img src="{{url('storage/uploads/agents/'.$agent_logo)}}" style="background: #fff;width:150px;">
					<h4>DATE: {{date('d-M-Y',strtotime($date))}}</h4>
					<h4>Invoice No: {{$ref}}</h4>
				</td>
			</tr>
		</table>
	</header>
	<footer>
		<table>
			<tr>
				<td>
						<h3>STAR HOLIDAYS</h3>
						Phone: +44 (0) 208 123 9900<br>
			Phone: +44 (0) 777 888 2464 <br>
				</td>
				<td style="text-align:right">
					<p>
			Email: starholidaysuk@hotmail.com<br>
			Website: www.starholidays.co.uk<br>
			<b>79 Tooting High Street, London, UK SW17 OSU</b>
		</p>
				</td>
			</tr>
		</table>
	</footer>
	<main>
		<p style="page-break-after: never;">
			<br>
			<br>
		<table class="items-table" style="border:1px solid #ddd;padding: 0;">
			<thead>
				<tr>
					<th>Sr NO</th>
					<th>Name</th>
					<th>Ticket Nnumber</th>
					<th>Sector</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($ticket_no as $key => $t)
				<tr>
					<td>{{$sr_no[$key]}}</td>
					<td style="text-align:left;">{{$name[$key]}}</td>
					<td>{{$ticket_no[$key]}}</td>
					<td>{{$sector[$key]}}</td>
					<td>{{$amount[$key]}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		</p>
		{{-- <br> --}}
		<p style="page-break-after: never;">
		<table>
			<tr>
				<td width="30%" >
					
				</td>
				<td width="70%">
					<table>
						<tr>
							<th  style="width:70%;text-align: right;">
								<h3>Total Amount (GBP):</h3>
							</th>
							<td  style="width:30%;text-align: right"><b style="    border: 2px solid;    padding: 2px 6px;
							width: 54px;
							display: inline-block;float: right">{{$total}}</b></td>
						</tr>
						@if(!empty($recieved))
						<tr>
							<th  style="width:70%;text-align: right;">
								<h3>Payment Received (GBP):</h3>
							</th>
							<td  style="width:30%;text-align: right"><b>{{$recieved}}</b></td>
						</tr>
						@endif
						@if(!empty($balance))
						<tr>
							<th  style="width:70%;text-align: right;">
								<h3>Balance:</h3>
							</th>
							<td  style="width:30%;text-align: right"><b>{{$balance}}</b></td>
						</tr>
						@endif
					</table>
				</td>
			</tr>
			<td colspan="2">
				@if(isset($remarks) && !empty($remarks))
				{!! $remarks !!}
				@endif
			</td>
		</table>
		</p>
	
	

	</main>
</body>
</html>