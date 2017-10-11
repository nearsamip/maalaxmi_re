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
  Note: 1 cubic feet == 0.0283168 cubic meter
  Note: 1 inch == 2.54cm
  Note: 1 foot == 12 inch
	<?php if(Auth::user()->type == 1){ ?><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#units_add_model">Add units</button><?php } ?>
	<table class="table table-bordered" id="units_table">
		<thead>
			<tr>
				<th>Id</th>
                <th>Name</th>
				<th>Nepali Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($units)
				{
					foreach($units as $unit)
					{
						?>
							<tr>
								<td><?php echo $unit->id; ?></td>
                                <td><?php echo $unit->name; ?></td>
								<td><?php echo $unit->nepali_name; ?></td>
								<td>
                                    <?php if(Auth::user()->type == 1){ ?>
									   <button class="btn btn-info btn-xs units_edit" data-id="<?php echo $unit->id; ?>" data-name="<?php echo $unit->name; ?>" data-nepaliname="<?php echo $unit->nepali_name; ?>"   >Edit</button>
									   <!-- <button class="btn btn-danger units_delete" data-id="<?php echo $unit->id; ?>" data-name="<?php echo $unit->name; ?>">Delete</button> -->
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
            $('#units_table').DataTable( {
                paging: false,
                bInfo : false,
                ordering:false,
                // order: [ 0, 'asc' ]
            } );
        })
    </script>
@endsection
<!-- Add source -->
<div aria-hidden="true" aria-labelledby="units_add_model" role="dialog" tabindex="-1" id="units_add_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Units  </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/add-units') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="number">Name</label>
				    <input type="text" class="form-control" name="name" required>
				  </div>
                  <div class="form-group">
                    <label for="nepali_name">Nepali Name</label>
                    <input type="text" class="form-control" name="nepali_name" >
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
<div aria-hidden="true" aria-labelledby="units_edit_model" role="dialog" tabindex="-1" id="units_edit_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> Update units </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/edit-units') }}">
          	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
          	   <input type="hidden" name="units_id"  value="">
              	<div class="modal-body">
                  <div class="form-group">
				    <label for="name">Name</label>
				    <input type="text" class="form-control" name="name"  value="" required>
				  </div>
				  <div class="form-group">
                    <label for="nepali_name">Nepali Name</label>
                    <input type="text" class="form-control" name="nepali_name"  value="" >
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