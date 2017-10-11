@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>email</td>
                                <td>Type</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($all_user)
                            {
                                foreach($all_user as $all_us)
                                {
                                    ?>
                                        <tr>
                                            <td><?php echo $all_us->name; ?></td>
                                            <td><?php echo $all_us->email; ?></td>
                                            <td><?php echo $all_us->type; ?></td>
                                            <td>
                                                <!-- <a href="<?php //echo url('user_edit'); ?>"><button class="btn btn-info">Edit</button></a> -->
                                                <a href="user_edit/<?php echo $all_us->id; ?>"><button class="btn btn-info">Edit</button></a>
                                                <a href=""><button class="btn btn-danger">Delete</button></a>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }
                        ?>
                            
                        </tbody>
                    </table>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
