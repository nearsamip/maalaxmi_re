@extends('layouts.admin')
@section('content')
	<?php
	?>
	<!-- <div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">Summary</h3>
	  </div>
	  <div class="panel-body">
	  	dfdkfjdksfdklsfdklsfjdklsfjklsdfjklsfjdklsfjklsfdklsfjdklsfdklsfdklsj
	  </div>
	</div> -->

	<div class="panel panel-danger">
	  	<div class="panel-heading">
	    	<h3 class="panel-title">आजको कारोबार </h3>
	  	</div>
	  	<div class="panel-body">
	    	
			<table class="table table-bordered" id="bill_table">
				<thead>
					<tr>
						<th>बिल नम्बर </th>
						<th>System Date</th>
						<th>Date</th>
						<th>ग्राहकको नाम </th>
						<th>Debit</th>
						<th>Credit</th>
						<th>बाकी</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$results = app('App\Http\Controllers\Bills')->todayTransaction();
						if($results)
						{
							foreach($results as $bill)
							{
								$res = app('App\Http\Controllers\Customer')->checkCustomerDeleted($bill->customer_id);
								if($res == 1)
								{


								?>
									<tr>
										<td><?php echo $bill->id; ?></td>
										<td><?php echo $bill->created_at; ?></td>
										<td><?php echo $bill->entry_date; ?></td>
										<td><a href="{{url('/customer-report/'.Crypt::encrypt($bill->customer_id))}}"><?php echo app('App\Http\Controllers\Customer')->get_customer_name_by_id($bill->customer_id); ?></a></td>
										<?php
											$IsBillCashOnly = app('App\Http\Controllers\Bills')->IsBillCashOnly($bill->id);
											if($IsBillCashOnly)
											{
												?>
													<td><?php echo $bill->cash_received; ?></td>
													<td><?php echo $bill->cash_given; ?></td>
													<td><?php echo $bill->cash_received -  $bill->cash_given ;?></td>
												<?php
											}
											else
											{
												?>
													<td><?php echo $bill->debit + $bill->cash_received; ?></td>
													<td><?php echo $bill->credit + $bill->cash_given; ?></td>
													<td><?php echo ($bill->debit + $bill->cash_received) -  ( $bill->credit + $bill->cash_given);?></td>
												<?php
											}
										?>
										
										<td>
											<a href="{{url('/bill-edit/'.Crypt::encrypt($bill->id))}}"><button class="btn btn-success btn-xs">Edit/View</button></a>
											<button class="btn btn-danger btn-xs bill_delete" data-id="<?php echo Crypt::encrypt($bill->id); ?>" data-name="<?php echo app('App\Http\Controllers\Customer')->get_customer_name_by_id($bill->customer_id); ?>">Delete</button>
										</td>
									</tr>
								<?php
							}
							}
						}
					?>
					
				</tbody>
			</table>
			
	  	</div>
	</div>

	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title">Today Created bill(it may contains older date bill also)</h3>
	  </div>
	  <div class="panel-body">
	    <table class="table table-bordered" id="today_created_bill">
			<thead>
				<tr>
					<th>बिल नम्बर </th>
					<th>System Date</th>
					<th>Date</th>
					<th>ग्राहकको नाम </th>
					<th>Debit</th>
					<th>Credit</th>
					<th>बाकी</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$results = app('App\Http\Controllers\Bills')->todayCreatedBill();
					if($results)
					{
						foreach($results as $bill)
						{
							$res = app('App\Http\Controllers\Customer')->checkCustomerDeleted($bill->customer_id);
							if($res == 1)
							{


							?>
								<tr>
									<td><?php echo $bill->id; ?></td>
									<td><?php echo $bill->created_at; ?></td>
									<td><?php echo $bill->entry_date; ?></td>
									<td><a href="{{url('/customer-report/'.Crypt::encrypt($bill->customer_id))}}"><?php echo app('App\Http\Controllers\Customer')->get_customer_name_by_id($bill->customer_id); ?></a></td>
									<?php
										$IsBillCashOnly = app('App\Http\Controllers\Bills')->IsBillCashOnly($bill->id);
										if($IsBillCashOnly)
										{
											?>
												<td><?php echo $bill->cash_received; ?></td>
												<td><?php echo $bill->cash_given; ?></td>
												<td><?php echo $bill->cash_received -  $bill->cash_given ;?></td>
											<?php
										}
										else
										{
											?>
												<td><?php echo $bill->debit + $bill->cash_received; ?></td>
												<td><?php echo $bill->credit + $bill->cash_given; ?></td>
												<td><?php echo ($bill->debit + $bill->cash_received) -  ( $bill->credit + $bill->cash_given);?></td>
											<?php
										}
									?>
									
									<td>
										<a href="{{url('/bill-edit/'.Crypt::encrypt($bill->id))}}"><button class="btn btn-success btn-xs">Edit/View</button></a>
										<button class="btn btn-danger btn-xs bill_delete" data-id="<?php echo Crypt::encrypt($bill->id); ?>" data-name="<?php echo app('App\Http\Controllers\Customer')->get_customer_name_by_id($bill->customer_id); ?>">Delete</button>
									</td>
								</tr>
							<?php
						}
						}
					}
				?>
				
			</tbody>
		</table>
	  </div>
	</div>
	
	

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#bill_table,#today_created_bill').DataTable( {
		        paging: false,
		        bInfo : false,
		        ordering:false,
		        order: [ 0, 'asc' ]
		    } );
		})
	</script>
@endsection




