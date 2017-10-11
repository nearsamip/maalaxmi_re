@extends('layouts.admin')
@section('content')
	<div class="alert-danger">{{ $errors->first('source_name') }}</div>
	<table class="table table-bordered" id="customer_table">
		<thead>
			<tr>
				<th>Id</th>
				<th>ग्राहकको नाम  </th>
				<th>ठेगाना  </th>
				<th>सम्पर्क नम्बर 1</th>
				<th>सम्पर्क नम्बर 2</th>
				<th>फोटो </th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($customers)
				{
					foreach($customers as $customer)
					{
						?>
							<tr>
								<td><?php echo $customer->id; ?></td>
								<td><a href="{{url('/customer-report/'. Crypt::encrypt($customer->id))}}"><?php echo $customer->full_name; ?></a></td>
								<td><?php echo $customer->address; ?></td>
								<td><?php echo $customer->contact_number; ?></td>
								<td><?php echo $customer->contact_number2; ?></td>
								<td>
									<?php if($customer->customerPhoto == ""){ ?>
										<img src="assets/images/default-profile-picture.gif" >
									<?php }else{ ?>
										<img src="{{url('/') . '/assets/uploads/customer/'.$customer->customerPhoto}}" >
									<?php } ?>
								</td>
								<td>
									<a href="<?php echo url('/customer-report/'.Crypt::encrypt($customer->id)); ?>"><button class="btn btn-success btn-xs" >Ladger</button></a>
									<button class="btn btn-info btn-xs customer_edit" data-id="<?php echo $customer->id; ?>" data-name="<?php echo $customer->full_name; ?>" data-address="<?php echo $customer->address; ?>" data-contactone="<?php echo $customer->contact_number; ?>" data-contacttwo="<?php echo $customer->contact_number2; ?>" data-image="<?php echo $customer->customerPhoto; ?>">Edit</button>
									<button class="btn btn-danger btn-xs customer_delete" data-id="<?php echo Crypt::encrypt($customer->id); ?>" data-name="<?php echo $customer->full_name; ?>">Delete</button>
								</td>
							</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#customer_table').DataTable( {
		        paging: false,
		        bInfo : false,
		        ordering:false,
		        // order: [ 0, 'asc' ]
		    } );
		    $('#customer_table_wrapper').addClass('table-responsive');
		})
	</script>
@endsection
