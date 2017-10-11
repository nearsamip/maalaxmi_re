@extends('layouts.admin')
@section('content')
	

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
				if($bills)
				{
					foreach($bills as $bill)
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
									<a href="{{url('/bill-view/'.Crypt::encrypt($bill->id))}}"><button class="btn btn-success btn-xs">View</button></a>
									<a href="{{url('/bill-edit/'.Crypt::encrypt($bill->id))}}"><button class="btn btn-info btn-xs">Edit</button></a>
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
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#bill_table').DataTable( {
		        paging: false,
		        bInfo : false,
		        ordering:false,
		        // order: [ 0, 'asc' ]
		    } );
		    $('#bill_table_wrapper').addClass('table-responsive');
		})
	</script>
@endsection

