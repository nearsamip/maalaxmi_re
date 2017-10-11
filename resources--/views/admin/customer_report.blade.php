@extends('layouts.admin')
@section('content')
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">Summary</h3>
	  </div>
	  <div class="panel-body">
	  	<p><strong>Formula = Debit - Credit </strong> Note: + == debit and - == credit</p>
	  	<?php
	  		if($item_summary_reports || $cash_summary_reports)
	  		{
	  			?>
	  			Result = <?php echo ($item_summary_reports->total_debit + $cash_summary_reports->total_cash_received) - ($item_summary_reports->total_credit + $cash_summary_reports->total_cash_given); ?>
	  			<?php
	  		}
	  	?>
	  	
	  </div>
	</div>

	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?php echo $customer_details->full_name; ?></h3>
	  </div>
	  <div class="panel-body">
	    <table class="table table-bordered" id="customer_report_item">
			<thead>
				<th>Date</th>
				<th class="no-sort">Particular</th>
				<th class="no-sort">Debit</th>
				<th class="no-sort">Credit</th>
			</thead>
			<tbody>
				<?php
					if($items_reports)
					{
						foreach($items_reports as $items_repor)
						{
							$IsBillCashOnly = app('App\Http\Controllers\Bills')->IsBillCashOnly($items_repor->id);
							if(!$IsBillCashOnly)
							{
								?>
								<tr>
									<td><?php echo $items_repor->entry_date; ?></td>
									<td><?php echo app('App\Http\Controllers\Bills')->get_item_name_by_particular_id($items_repor->particular_id).' '.$items_repor->quantity.' '.app('App\Http\Controllers\Bills')->get_unit_name_by_units_id($items_repor->units_id).' ('.$items_repor->description.') => Rs. '.$items_repor->rate.'*'.$items_repor->quantity; ?></td>
									<td><?php echo $items_repor->debit; ?></td>
									<td><?php echo $items_repor->credit; ?></td>
								</tr>
								<?php
							}
						}
					}
				?>
				<!-- cash report row start -->
				<?php
					if($cash_reports)
					{
						foreach($cash_reports as $cash_repor)
						{
							if($cash_repor->cash_received > 0 || $cash_repor->cash_given > 0 )
							{
								?>
									<tr>
										<td><?php echo $cash_repor->entry_date; ?></td>
										<td><?php if($cash_repor->cash_received > 0){ echo "Cash received ".$cash_repor->description_for_cash_only;}else{echo "Cash given ".$cash_repor->description_for_cash_only;} ?></td>
										<td><?php echo $cash_repor->cash_received; ?></td>
										<td><?php echo $cash_repor->cash_given; ?></td>
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
			$('#customer_report_item').DataTable( {
		        paging: false,
		        bInfo : false,
		        // ordering:false,
		        order: [ 0, 'desc' ],
		        "columnDefs": [ {
			          "targets": 'no-sort',
			          "orderable": false,
			    } ]
		    } );
		})
	</script>
@endsection
