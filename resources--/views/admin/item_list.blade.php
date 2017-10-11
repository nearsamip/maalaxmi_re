@extends('layouts.admin')
@section('content')
	<?php if(Auth::user()->type == 1){ ?>
		<button class="btn btn-primary btn-xsbutton" data-toggle="modal" data-target="#item_add_model">Add Item</button>
	<?php } ?>
	<table class="table table-bordered" id="item_table">
		<thead>
			<tr>
				<!-- <th>Id</th> -->
				<th>Items Name</th>
				<th>Rate</th>
				<th>photo</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($items)
				{
					foreach($items as $item)
					{
						?>
							<tr>
								<!-- <td><?php //echo $item->id; ?></td> -->
								<!-- <td><a href="{{url('/item-report/'.$item->slug)}}"><?php //echo $item->name; ?></a></td> -->
								<td><?php echo $item->name; ?></td>
								<td><?php echo $item->rates; ?></td>
								<td>
									<?php
										if($item->itemPhoto == '')
										{
											?>
												<img src="{{url('/assets/uploads/default/item.jpg') }}" >
											<?php
										}
										else
										{
											?>
												<img src="{{url('/') . '/assets/uploads/items/'.$item->itemPhoto}}" >
											<?php
										}
									?>
									
								</td>
								<td>
									<!-- <a href="{{url('/item-report/'.$item->slug)}}"><button class="btn btn-info" >Report</button></a> -->
									<?php if(Auth::user()->type == 1){ ?>
										<button class="btn btn-info btn-xs item_edit" data-id="<?php echo $item->id; ?>" data-name="<?php echo $item->name; ?>" data-rates="<?php echo $item->rates; ?>"  data-image="<?php echo $item->itemPhoto; ?>">Edit</button>
										<!-- <button class="btn btn-danger item_delete" data-id="<?php echo $item->id; ?>" data-name="<?php echo $item->name; ?>">Delete</button> -->
									<?php } ?>
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
			$('#item_table').DataTable( {
		        paging: false,
		        bInfo : false,
		        ordering:false,
		        // order: [ 0, 'asc' ]
		    } );
		})
	</script>
@endsection
<!-- Add source -->
<div aria-hidden="true" aria-labelledby="item_add_model" role="dialog" tabindex="-1" id="item_add_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Add item </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/add-item') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="name">item Name</label>
				    <input type="text" class="form-control" name="name" required>
				  </div>
				  <div class="form-group">
				    <label for="rates">Rates</label>
				    <input type="text" class="form-control" name="rates" required>
				  </div>
				  <div class="form-group">
				    <label for="itemPhoto">Photo</label>
				    <input type="file" class="form-control image_input" name="itemPhoto" accept="image/*">
				    <img src="" class="image_preview" width="30%" height="15%">
				  </div>
              	</div>
              	<div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                  <button class="btn btn-success" name="submit" type="submit">Submit</button>
              	</div>
          </form>
      </div>
  </div>
</div>

<!-- Add source -->
<div aria-hidden="true" aria-labelledby="item_edit_model" role="dialog" tabindex="-1" id="item_edit_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Update customer </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/edit-item') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
          	   <input type="hidden" name="item_id"  value="">
          	   <input type="hidden" name="old_image"  value="">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="name">Items Name</label>
				    <input type="text" class="form-control" name="name"  value="" required>
				  </div>
				  <div class="form-group">
				    <label for="rates">Rates</label>
				    <input type="text" class="form-control" name="rates"  value="" required>
				  </div>
				  
				  <div class="form-group">
				  
				    <label for="itemPhoto">Photo</label>
				    <input type="file" class="form-control image_input_edit" name="itemPhoto" accept="image/*">
				    <img src="" class="image_preview_edit" width="30%" height="15%">
				  </div>
              	</div>
              	<div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                  <button class="btn btn-success" name="submit" type="submit">Update</button>
              	</div>
          </form>
      </div>
  </div>
</div>