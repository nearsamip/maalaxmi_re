@extends('layouts.admin')
@section('content')
	<?php
	?>
	<h1><?php //echo $customer_details->full_name; ?></h1>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">Summary</h3>
	  </div>
	  <div class="panel-body">

	  </div>
	</div>

	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title">Vehicles</h3>
	  </div>
	  <div class="panel-body">
	    <table class="table" id="customer_report_item">
			<thead>
				<th>Created at</th>
				<th>Type of bill</th>
				<th>Customer</th>
				<th>Particular</th>
				<th>Quantity</th>
				<th>From</th>
				<th>To</th>
			</thead>
			<tbody>
				
				
			</tbody>
		</table>
	  </div>
	</div>
@endsection
