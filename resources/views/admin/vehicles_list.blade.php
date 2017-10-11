@extends('layouts.admin')
@section('content')
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
	<button class="btn btn-primary" data-toggle="modal" data-target="#vehicles_add_model">Add vehicle</button>
	<table class="table table-bordered" id="vehicles_table">
		<thead>
			<tr>
				<!-- <th>Id</th> -->
				<th>Number</th>
				<!-- <th>photo</th> -->
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($vehicles)
				{
					foreach($vehicles as $vehicle)
					{
						?>
							<tr>
								<!-- <td><?php //echo $vehicle->id; ?></td> -->
								<td><?php echo $vehicle->vehicles_num; ?></td>
								<!-- <td><img src="{{url('/') . '/assets/uploads/vehicles/'.$vehicle->photo}}" width="100px" height="100px"></td> -->
								<td>
									<a href="{{url('/vehicles-report/'.$vehicle->vehicles_num)}}"><button class="btn btn-info" data-id="<?php echo $vehicle->id; ?>" data-name="<?php echo $vehicle->number; ?>"   data-image="<?php echo $vehicle->photo; ?>">Report</button></a>
									<!-- <button class="btn btn-primary vehicles_edit" data-id="<?php //echo $vehicle->id; ?>" data-name="<?php //echo $vehicle->number; ?>"   data-image="<?php //echo $vehicle->photo; ?>">Edit</button> -->
									<!-- <button class="btn btn-danger vehicles_delete" data-id="<?php //echo $vehicle->id; ?>" data-name="<?php //echo $vehicle->number; ?>">Delete</button> -->
								</td>
							</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
@endsection
<!-- Add source -->
<div aria-hidden="true" aria-labelledby="vehicles_add_model" role="dialog" tabindex="-1" id="vehicles_add_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Add vehicles </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/add-vehicles') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="number">vehicles Number</label>
				    <input type="text" class="form-control" name="number" required>
				  </div>
				  
				  <div class="form-group">
				    <label for="photo">Photo</label>
				    <input type="file" class="form-control image_input" name="photo" required>
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
<div aria-hidden="true" aria-labelledby="vehicles_edit_model" role="dialog" tabindex="-1" id="vehicles_edit_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Update vehicles </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/edit-vehicles') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
          	   <input type="hidden" name="vehicles_id"  value="">
          	   <input type="hidden" name="old_image"  value="">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="name">vehicles Name</label>
				    <input type="text" class="form-control" name="number"  value="" required>
				  </div>
				  
				  
				  <div class="form-group">
				  
				    <label for="photo">Photo</label>
				    <input type="file" class="form-control image_input_edit" name="photo" >
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