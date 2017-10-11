@extends('layouts.admin')
@section('content')
	<div class="container-fluid">
		<div class="col-sm-4" >
			<label for="customer">ग्राहक : </label>
			<ul>
				<li>Name: <?php echo $customer_details->full_name;  ?></li>
				<li>address: <?php echo $customer_details->address;  ?></li>
				<li>contact1: <?php echo $customer_details->contact_number;  ?></li>
				<li>contact2: <?php echo $customer_details->contact_number2;  ?></li>
			</ul>
		</div>
		
		<div class="col-sm-4">
			<div class="form-group">
			    <label for="date">बिल न. : </label>
			    <?php echo $bill_detail->id;  ?>
			</div>
			<div class="form-group">
			    <label for="date">मिति : </label>
			    <?php echo $bill_detail->entry_date;  ?>
			</div>
			<div class="form-group">
			    <label for="date">गाडी न. </label>
			    <?php echo $bill_detail->vehicles_num;  ?>
			</div>
		</div>

		<div class="col-sm-4">
		    <div class="form-group">
			    
			    <?php 
	            	if($bill_detail->docImage != '')
	            	{
	            		?>
	            		<label for="date">Document(if any)</label>
	            		<a href="<?php echo url('assets/uploads/bill/'.$bill_detail->docImage); ?>" target="_blank"><img  src="<?php echo url('assets/uploads/bill/'.$bill_detail->docImage); ?>" width="300px" height="210px"></a>
	            		<?php
	            	}
	            ?>
			</div>
		</div>
	</div>

	<div class="row">
		<table class="table table-bordered" id="billTable">
			<thead>
				<tr style="background-color:gainsboro">
					<th>Particular</th>
					<th>quantity</th>
					<th>Rate</th>
					<th>Debit</th>
					<th>Credit</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				$particular_credit = 0;
				$particular_debit = 0;
		  		if($particular_details)
		  		{
		  			$total = 0 ;

		  			foreach($particular_details as $particular_detai)
		  			{

		  				?>
		  					<tr>
		  						<td>
		  							<?php echo app('App\Http\Controllers\Items')->getItemNepaliName($particular_detai->particular_id).' '.$particular_detai->quantity.' '.app('App\Http\Controllers\Units')->getUnitsNepaliName($particular_detai->units_id).' ('.$particular_detai->description.')' ?>
		  						</td>
								<td><?php echo $particular_detai->quantity;  ?></td>
								<td><?php echo $particular_detai->rate;  ?></td>
								<td class="debit"><?php echo $particular_detai->debit;  ?></td>
								<td class="credit"><?php echo $particular_detai->credit;  ?></td>
							</tr>
		  				<?php
		  				// $total += $price;
		  				$particular_debit += $particular_detai->debit;
		  				$particular_credit += $particular_detai->credit;
		  			}
		  		}

		  	?>

			</tbody>
			<tfoot>
				<tr style="background-color:gainsboro">
					<td>Cash received</td>
					<td>
						<?php 
							if($bill_detail->cash_received > 0)
							{
								echo $bill_detail->description_for_cash_only; 
							} 
						?>
					</td>
					<td></td>
					<td>
						<?php 
							if($bill_detail->cash_received > 0)
							{
								echo $bill_detail->cash_received;
							} 
						?>
					</td>
					<td></td>
				</tr>
				<tr style="background-color:gainsboro">
					<td>Cash Given</td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<?php 
							if($bill_detail->cash_given > 0)
							{
								echo $bill_detail->cash_given;
							} 
						?>
					</td>
				</tr>
				<!-- for grand total -->
				<?php
					$grand_total = ($particular_debit + $bill_detail->cash_received)-($particular_credit + $bill_detail->cash_given);
				?>
				<tr style="background-color:aquamarine">
					<td>Sub total</td>
					<td></td>
					<td></td>
					<td><?php echo $particular_debit + $bill_detail->cash_received; ?></td>
					<td><?php echo $particular_credit + $bill_detail->cash_given; ?></td>
				</tr>
				<tr style="background-color:aquamarine">
					<td>Grand total</td>
					<td></td>
					<td></td>
					<td><?php if($grand_total > 0 ){echo "<strong>".abs($grand_total)."</strong>";}else{echo '';} ?></td>
					<td><?php if($grand_total < 0 ){echo "<strong>".abs($grand_total)."</strong>";}else{echo '';} ?></td>
				</tr>
			</tfoot>
			
		</table>
	</div>
@endsection













