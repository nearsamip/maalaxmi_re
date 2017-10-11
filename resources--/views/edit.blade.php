@extends('layouts.app')

@section('content')
 
  <form method="post" action="<?php echo url('update_process'); ?>">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="<?php if($users){echo $users->name;} ?>">
      <?php echo $errors->first('name'); ?>
    </div>
     <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php if($users){echo $users->email;} ?>">
      <?php echo $errors->first('email'); ?>
    </div>
     <div class="form-group">
      <label for="type">Type</label>
      <input type="text" class="form-control" id="type" name="type" value="<?php if($users){echo $users->type;} ?>">
      <?php echo $errors->first('type'); ?>
    </div>
    
    <button type="submit" class="btn btn-default">Update</button>
  </form>
@endsection  