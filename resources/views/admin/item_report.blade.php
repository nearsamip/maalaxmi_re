@extends('layouts.admin')
@section('content')
	<?php
	?>
	<h1><?php echo $item_name; ?></h1>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">Summary</h3>
	  </div>
	  <div class="panel-body">
	    <!-- total entry <?php //echo $total_entry ?><br>
	    total exists <?php //echo $total_exit ?> -->
	    <?php
	    	if($items_id_of_same_slug)
	    	{
	    		foreach($items_id_of_same_slug as $items_id_of_same_slu)
	    		{
	    			$data_exists = DB::table('tbl_items')
	                ->leftjoin('tbl_particular', 'tbl_items.id', '=', 'tbl_particular.particular_id')
	                ->leftjoin('tbl_bills', 'tbl_particular.bill_id', '=', 'tbl_bills.id')
	                ->select('tbl_items.name', DB::raw('SUM(tbl_particular.quantity) as total'),'tbl_particular.units_id as units_id')
	                ->groupBy('tbl_particular.units_id')
	                ->where('tbl_particular.particular_id',$items_id_of_same_slu->id)
	                ->where('tbl_bills.type_of_bill','exits')
	                // ->orderBy('tbl_bills.id', 'desc')
	                ->get();
	                // print_r($data[$cn]);echo "<br>";
	                if(!empty($data_exists))
	                {
	                	foreach($data_exists as $da)
	                	{
	                		echo "<p style='color:red'>"."total exits ".$da->name." ". $da->total.app('App\Http\Controllers\Units')->get_units_name_by_id($da->units_id)."</p>";
	                	}
	                	
	                }

	                // data entry
	                $data_entry = DB::table('tbl_items')
	                ->leftjoin('tbl_particular', 'tbl_items.id', '=', 'tbl_particular.particular_id')
	                ->leftjoin('tbl_bills', 'tbl_particular.bill_id', '=', 'tbl_bills.id')
	                ->select('tbl_items.name', DB::raw('SUM(tbl_particular.quantity) as total'),'tbl_particular.units_id as units_id')
	                ->groupBy('tbl_particular.units_id')
	                ->where('tbl_particular.particular_id',$items_id_of_same_slu->id)
	                ->where('tbl_bills.type_of_bill','entry')
	                // ->orderBy('tbl_bills.id', 'desc')
	                ->get();
	                // print_r($data[$cn]);echo "<br>";
	                if(!empty($data_entry))
	                {
	                	foreach($data_entry as $data_entr)
	                	{
	                		echo "<p>"."total entry ".$data_entr->name." ". $data_entr->total.app('App\Http\Controllers\Units')->get_units_name_by_id($data_entr->units_id)."</p>";
	                	}
	                	
	                }
	                

	    		}
	    	}
	    ?>
	  </div>
	</div>

	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title">Item entry transaction</h3>
	  </div>
	  <div class="panel-body">
	    <table class="table" id="entry_report_item">
			<thead>
				<th>Bill no.</th>
				<th>Created at</th>
				<th>Particular</th>
				<th>Quantity</th>
				<th>Units</th>
				<th>Rates</th>
				<!-- <th>Debit</th> -->
				<!-- <th>Credit</th> -->
			</thead>
			<tbody>
				<?php
					if($entry_transaction)
					{
						foreach($entry_transaction as $bill_id_of_custom)
						{
							$particular = DB::table('tbl_bills')
			                ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
			                ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
			                ->where('tbl_particular.id',$bill_id_of_custom->id)
			                ->orderBy('tbl_bills.id', 'desc')
			                ->get();

			                if(!empty($particular))
			                {
			                	$cn = 0;
			                	foreach($particular as $particu)
			                	{
			                		$cn++;
			                		?>
			                			<tr>
											<td><?php echo $particu->id; ?></td>
											<td><?php if($cn == 1){ echo $particu->created_at;} ?></td>
											<td><?php echo app('App\Http\Controllers\Bills')->get_item_name_by_particular_id($particu->particular_id); ?></td>
											<td><?php echo $particu->quantity; ?></td>
											<td><?php echo app('App\Http\Controllers\Bills')->get_unit_name_by_units_id($particu->units_id); ?></td>
											<td><?php echo $particu->rate; ?></td>
											<!-- <td><?php //if($particu->type_of_bill == "entry"){ echo $debit = $particu->quantity * $particu->rate;} ?></td> -->
											<!-- <td><?php //if($particu->type_of_bill == "exits"){ echo $credit = $particu->quantity * $particu->rate;} ?></td> -->
										</tr>
			                		<?php
			                	}
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
	    <h3 class="panel-title">Item exists transaction</h3>
	  </div>
	  <div class="panel-body">
	    <table class="table" id="exits_report_item">
			<thead>
				<th>Bill no.</th>
				<th>Created at</th>
				<th>Particular</th>
				<th>Quantity</th>
				<th>Units</th>
				<th>Rates</th>
				<!-- <th>Debit</th> -->
				<!-- <th>Credit</th> -->
			</thead>
			<tbody>
				<?php
					if($exits_transaction)
					{
						foreach($exits_transaction as $bill_id_of_custom)
						{
							$particular = DB::table('tbl_bills')
			                ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
			                ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
			                ->where('tbl_particular.id',$bill_id_of_custom->id)
			                ->orderBy('tbl_bills.id', 'desc')
			                ->get();

			                if(!empty($particular))
			                {
			                	$cn = 0;
			                	foreach($particular as $particu)
			                	{
			                		$cn++;
			                		?>
			                			<tr>
											<td><?php echo $particu->id; ?></td>
											<td><?php if($cn == 1){ echo $particu->created_at;} ?></td>
											<td><?php echo app('App\Http\Controllers\Bills')->get_item_name_by_particular_id($particu->particular_id); ?></td>
											<td><?php echo $particu->quantity; ?></td>
											<td><?php echo app('App\Http\Controllers\Bills')->get_unit_name_by_units_id($particu->units_id); ?></td>
											<td><?php echo $particu->rate; ?></td>
											<!-- <td><?php //if($particu->type_of_bill == "entry"){ echo $debit = $particu->quantity * $particu->rate;} ?></td> -->
											<!-- <td><?php //if($particu->type_of_bill == "exits"){ echo $credit = $particu->quantity * $particu->rate;} ?></td> -->
										</tr>
			                		<?php
			                	}
			                }
						}
					}
				?>
				
			</tbody>
		</table>
	  </div>
	</div>
	
	

@endsection
