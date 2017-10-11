@extends('layouts.admin')
@section('content')
	<button class="btn btn-primary" data-toggle="modal" data-target="#customer_add_model">नया ग्राहक </button>
	<form class="form-inline" method="post"  action="<?php echo url('/bill-store') ?>" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="row" >
			<div class="col-sm-4" id="customerInformation" >
				<ul>
					<li>Name: No Name</li>
					<li>address: No address</li>
					<li>contact1: no</li>
					<li>contact2: no</li>
				</ul>
				
			</div>
			<div class="col-sm-4">
				<!-- <label for="customer">Customer</label> -->
				<select class="form-control" name="customer_id" id="customer_select"  required>
			    	<option value="<?php echo NULL; ?>">Choose customer</option>
			    	<?php 
			    		if($customers)
			    		{ 
			    			foreach($customers as $customer)
			    			{
			    				?>
			    					<option value="<?php echo $customer->id; ?>"><?php echo $customer->full_name; ?></option>
			    				<?php
			    			}
			    		}
			    	?>
			    <select>
			    <div class="form-group">
				    <label for="date">Document(if any)</label>
				    <input type="file" name="docImage" accept="image/*">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
				    <label for="date">Date</label>
				    <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>"  required>
				</div><br>
				<div class="form-group">
				    <label for="date">Vehicles number</label>
				    <input type="number" class="form-control" name="vehicles_num" Placeholder="Vehicles number" >
				</div>
			</div
		</div>

		<div class="row" >
			<table class="table table-bordered" id="billTable">
				<thead>
					<tr style="background-color:gainsboro">
						<th>Items</th>
						<th>Description</th>
						<th>quantity</th>
						<th>Units</th>
						<th>Rate</th>
						<th>Type</th>
						<th>Debit</th>
						<th>Credit</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select class="form-control" name="particular[]" required>
					      		<option></option>
					      		<?php 
					      			if($items)
					      			{
					      				foreach($items as $item)
					      				{ 
					      		?>
					      		<option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
					      		<?php }}
					      		?>
					      	</select>
						</td>
						<td><input type="text" class="form-control " name="description[]"></td>
						<td onClick="quantityrate(this)" onInput="quantityrate(this)"><input  type="number" class="form-control myformelement" name="qty[]" step=any min="0"  required></td>
						<td>
				     	 	<select class="form-control myformelement" name="units[]" required>
					      		<option></option>
					      		<?php 
					      			if($units)
					      			{
					      				foreach($units as $uni)
					      				{ 
					      		?>
					      		<option value="<?php echo $uni->id; ?>"><?php echo $uni->name; ?></option>
					      		<?php }}
					      		?>
					      	</select>
				     	 </td>

						<td  onClick="quantityrate(this)" onInput="quantityrate(this)" ><input type="number" class="form-control myformelement" name="cost[]"   step=any min="0" required></td>
						<td onChange="quantityrate(this)" >
							<select name="itemType[]">
								<option value="exits">Exits</option>
								<option value="entry">Entry</option>
							</select>
						</td>
						<td class="debit"></td>
						<td class="credit"></td>
						<td>
							<span onClick="removeItem(this)" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</td>
					</tr>

				</tbody>
				<tfoot>
					<tr style="background-color:gainsboro">
						<td>Cash received</td>
						<td><input type="text"  class="form-control myformelement" name="cash_received_desc" placeholder="only for cash transaction"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><input type="number" onInput="cashReceivedInput()" onClick="cashreceivegiven()"  class="form-control myformelement" id="cash_received" name="cash_received" step=any min="0"></td>
						<td></td>
						<td></td>
					</tr>
					<tr style="background-color:gainsboro">
						<td>Cash Given</td>
						<td><input type="text" class="form-control myformelement" name="cash_given_desc" placeholder="only for cash transaction"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><input type="number" onInput="cashGivenInput()" onClick="cashreceivegiven()"  class="form-control myformelement" id="cash_given" name="cash_given" step=any min="0"></td>
						<td></td>
					</tr>
					<tr style="background-color:aquamarine">
						<td><span class="glyphicon glyphicon-plus" id="addMore"></span>
						<td><button class="btn btn-success" type="submit" id="submitBtn">Save </button></td>
						<td><a href="<?php echo url('/'); ?>">Cancel</a></td></td>
						<td></td>
						<td></td>
						<td>Sub Total</td>
						<td id="debit_total"></td>
						<td id="credit_total"></td>
						<td></td>
					</tr>
					<tr style="background-color:aquamarine">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Grand total</td>
						<td id="grand_total_debit"></td>
						<td id="grand_total_credit"></td>
						<td></td>
					</tr>
				</tfoot>
				
			</table>

		</div>
		
	</form>
	
	
@endsection

@section('script')
	<script type="text/javascript">
		/*add more*/
        $('#addMore').on('click',function(){
            $('#billTable tbody').append('<tr><td><select class="form-control" name="particular[]" required><option></option><?php if($items){ foreach($items as $item){ ?> <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option> <?php }}	?></select></td><td><input type="text" class="form-control " name="description[]"></td><td onClick="quantityrate(this)" onInput="quantityrate(this)"><input  type="number" class="form-control myformelement" name="qty[]" min="0" step=any required></td><td><select class="form-control myformelement" name="units[]" required><option></option><?php if($units){foreach($units as $uni){?><option value="<?php echo $uni->id; ?>"><?php echo $uni->name; ?></option><?php }}?></select></td><td onClick="quantityrate(this)" onInput="quantityrate(this)" ><input type="number" class="form-control myformelement" name="cost[]" step=any min="0" required></td><td onChange="quantityrate(this)" ><select name="itemType[]"><option value="exits">Exits</option><option value="entry">Entry</option></select></td><td class="debit"></td><td class="credit"></td><td><span onClick="removeItem(this)" class="glyphicon glyphicon-remove" aria-hidden="true"></span></td></tr>');
        })
	</script>
@endsection









