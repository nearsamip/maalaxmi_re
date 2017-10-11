<?php
	if($customer_detail)
	{
		?>
		<ul>
			<li>Name: <a href="<?php echo url('/customer-report/'.$customer_detail->id) ?>"><?php echo $customer_detail->full_name; ?></li></a>
			<li>Address: <?php echo $customer_detail->address; ?></li>
			<li>Contact number1: <?php echo $customer_detail->contact_number; ?></li>
			<li>Contact number2: <?php echo $customer_detail->contact_number2; ?></li>
		</ul>
		<?php
	}

?>