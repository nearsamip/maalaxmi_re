@extends('layouts.bill_layout')
@section('content')

	
		<div id="page-wrap" class="bill-form">

			<textarea id="header">बिल</textarea>
			
			<div id="identity">


	            <textarea id="address" disabled>
	            			<?php echo $customer_details->full_name;  ?>
					<?php echo $customer_details->address;  ?>
					<?php echo $customer_details->contact_number.",". $customer_details->contact_number2;  ?>
				</textarea>

	            <div class="form-group myformgroup">
				    <label for="customer_id">ग्राहकको नाम </label>
				    <input class="form-control myformelement" value="<?php echo $customer_details->full_name;  ?>" disabled>
				</div>
			</div>
			
			<div style="clear:both"></div>
			
			<div id="customer">


	            <table id="meta">
	            	<tr>
	                    <td class="meta-head">बिल नम्बर</td>
	                    <td><div ><?php echo $bill_detail->id;  ?></div></td>
	                </tr>
	                <tr>
	                    <td class="meta-head">बिलको प्रकार </td>
	                    <td><div ><?php if($bill_detail->type_of_bill == 1){echo 'समान बाहिर पठाउने बिल';}elseif($bill_detail->type_of_bill == 2){echo "समान इन्ट्री गर्ने बिल";}else{echo "Cash only";}  ?></div></td>
	                </tr>
	                <tr>
	                    <td class="meta-head">गाडी नम्बर </td>
	                    <td><?php echo $bill_detail->vehicles_num;  ?></td>
	                </tr>
	                <tr>

	                    <td class="meta-head">मिति</td>
	                    <td><?php echo $bill_detail->entry_date;  ?></td>
	                    <?php 
	                    	if($bill_detail->docImage != '')
	                    	{
	                    		?>
	                    		<a href="<?php echo url('assets/uploads/bill/'.$bill_detail->docImage); ?>" target="_blank"><img  src="<?php echo url('assets/uploads/bill/'.$bill_detail->docImage); ?>" width="300px" height="210px"></a>
	                    		<?php
	                    	}
	                    ?>
	                </tr>
	               

	            </table>
			
			</div>
			
			<table id="items">
			
			 	<tr>
				    <th>समान</th>
				    <th>विवरण </th>
				    <th>दर</th>
				    <th>इकाइ(Unit)</th>
				    <th>परिमाण </th>
				    <th>रकम</th>
			  	</tr>

			  	<?php
			  		// echo count($particular_details);die;
			  		if($particular_details)
			  		{
			  			$total = 0 ;

			  			foreach($particular_details as $particular_detai)
			  			{

			  				?>
			  					<tr class="item-row">
							      	<td class="item-name"><div class="delete-wpr">
								      	<select class="form-control" name="particular[]" required disabled>
								      		<option></option>
								      		<?php 
								      			if($items)
								      			{
								      				foreach($items as $item)
								      				{ 
								      		?>
								      		<option value="<?php echo $item->id; ?>" <?php if($item->id == $particular_detai->particular_id){echo "selected";} ?> ><?php echo $item->name; ?></option>
								      		<?php }}
								      		?>
								      	</select>
								      	<!-- <a class="delete" href="javascript:;" title="Remove row">X</a> --></div>
								    </td>

							      	<td class="description"><?php echo $particular_detai->description;  ?></td>
							     	 <td><?php echo $particular_detai->rate;  ?></td>
							     	 <td>
							     	 	<select class="form-control" name="units[]" required disabled>
								      		<option></option>
								      		<?php 
								      			if($units)
								      			{
								      				foreach($units as $uni)
								      				{ 
								      		?>
								      		<option value="<?php echo $uni->id; ?>" <?php if($uni->id == $particular_detai->units_id){echo "selected";} ?> ><?php echo $uni->name; ?></option>
								      		<?php }}
								      		?>
								      	</select>
							     	 </td>

							     	 <td><?php echo $particular_detai->quantity;  ?></td>
							      	<td><span class="price" ><?php echo $price = $particular_detai->quantity * $particular_detai->rate;  ?></span></td>
							  	</tr>
			  				<?php
			  				$total += $price;
			  			}
			  		}

			  	?>
			  
			 	
			  
			  <!-- <tr id="hiderow">
			    <td colspan="6"><a id="addrow" href="javascript:;" title="Add a row">Add a Item</a></td>
			  </tr> -->
			  
			  <tr>
			      <td colspan="2" class="blank"> </td>
			      <td colspan="3" class="total-line">Subtotal</td>
			      <td class="total-value"><div id="subtotal"><?php echo $total; ?></div></td>
			  </tr>
			  <tr>

			      <td colspan="2" class="blank"> </td>
			      <td colspan="3" class="total-line">जम्मा</td>
			      <td class="total-value"><div id="total"><?php echo $total; ?></div></td>
			  </tr>
			  <tr>
			      <td colspan="2" class="blank"> </td>
			      <td colspan="3" class="total-line"><?php if(  $bill_detail->type_of_bill == '1' ){echo "रकम लिएको ";}else{echo "रकम दिएको ";} ?></td>

			      <td class="total-value"><?php if(  $bill_detail->type_of_bill == '1' ){echo $bill_detail->cash_received;}else{echo $bill_detail->cash_given;} ?></td>
			  </tr>
			  <tr>
			      <td colspan="2" class="blank"> </td>
			      <td colspan="3" class="total-line balance">बाकी</td>
			      <td class="total-value balance"><div class="due"><?php if(  $bill_detail->type_of_bill == '1' ){echo $total - $bill_detail->cash_received;}else{echo $total - $bill_detail->cash_given;} ?></div></td>
			  </tr>
			
			</table>
			
			<div id="terms">
				<!-- <p>
					<button class="btn btn-success" type="submit">Done</button>
					<a href="<?php echo url('/'); ?>">Cancel</a>
				</p> -->
			  <h5>Terms</h5>
			  NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.
			</div>
		
		</div>

		
	
	
@endsection









