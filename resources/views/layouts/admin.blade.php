<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>मालक्ष्मी</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/DataTables-1.10.12/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/css/sb-admin.css') }}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php 
        $path = url('/')."/";
    ?>
    <script type="text/javascript">
        var js_base_url =  <?php echo "'".$path."'";?>
    </script>

    <script type="text/javascript">
        
        /*remove item*/
        function removeItem(btndel)
        {
            $(btndel).parent().parent().remove();
            var cells = $(btndel).closest('tr').children('td');
             // alert(  )
            var value1 = cells.eq(2).find('input').val();
            var value2 = cells.eq(4).find('input').val();
            if(cells.eq(5).find('select').val() == 'exits')
            {
                /*credit*/
                cells.eq(6).text(0);
                cells.eq(7).text(new Number(value1) * new Number(value2));
            }
            else
            {
                /*debit*/
                cells.eq(6).text(new Number(value1) * new Number(value2));
                cells.eq(7).text(0);
            }
            
            var debit = 0;
            var credit = 0;
            // iterate through each td based on class and add the values
            $(".debit").each(function() {

                var value1 = $(this).text();
                // add only if the value is number
                if(!isNaN(value1) && value1.length != 0) {
                    debit += parseFloat(value1);
                }
            });
            $(".credit").each(function() {

                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    credit += parseFloat(value);
                }
            });
            // alert(debit)
            // alert(credit)
            var cash_received = $('#cash_received').val();
            var cash_given = $('#cash_given').val();
            var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
            $('#debit_total').text(debit);
            $('#credit_total').text(credit);
            if(result > 0)
            {
                $('#grand_total_credit').text(0);
                $('#grand_total_debit').text(Math.abs(result));
            }
            else
            {
                 $('#grand_total_debit').text(0);
                 $('#grand_total_credit').text(Math.abs(result));
            }
            
        }

        /*quantity * rate*/
        function quantityrate(btndel)
        {

            var cells = $(btndel).closest('tr').children('td');
             // alert(  )
            var value1 = cells.eq(2).find('input').val();
            var value2 = cells.eq(4).find('input').val();
            if(cells.eq(5).find('select').val() == 'exits')
            {
                /*credit*/
                cells.eq(6).text(0);
                cells.eq(7).text(new Number(value1) * new Number(value2));
            }
            else
            {
                /*debit*/
                cells.eq(6).text(new Number(value1) * new Number(value2));
                cells.eq(7).text(0);
            }
            
            var debit = 0;
            var credit = 0;
            // iterate through each td based on class and add the values
            $(".debit").each(function() {

                var value1 = $(this).text();
                // add only if the value is number
                if(!isNaN(value1) && value1.length != 0) {
                    debit += parseFloat(value1);
                }
            });
            $(".credit").each(function() {

                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    credit += parseFloat(value);
                }
            });
            // alert(debit)
            // alert(credit)
            var cash_received = $('#cash_received').val();
            var cash_given = $('#cash_given').val();
            var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
            $('#debit_total').text(debit);
            $('#credit_total').text(credit);
          if(result > 0)
            {
                $('#grand_total_credit').text(0);
                $('#grand_total_debit').text(Math.abs(result));
            }
            else
            {
                 $('#grand_total_debit').text(0);
                 $('#grand_total_credit').text(Math.abs(result));
            }
        }

        /*cash received or given*/
        function cashreceivegiven()
        {
            var debit = 0;
            var credit = 0;
            // iterate through each td based on class and add the values
            $(".debit").each(function() {

                var value1 = $(this).text();
                // add only if the value is number
                if(!isNaN(value1) && value1.length != 0) {
                    debit += parseFloat(value1);
                }
            });
            $(".credit").each(function() {

                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    credit += parseFloat(value);
                }
            });

            // alert(debit)
            // alert(credit)
            var cash_received = $('#cash_received').val();
            var cash_given = $('#cash_given').val();
            var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
            $('#debit_total').text(debit);
            $('#credit_total').text(credit);
            if(result > 0)
            {
                $('#grand_total_credit').text(0);
                $('#grand_total_debit').text(Math.abs(result));
            }
            else
            {
                 $('#grand_total_debit').text(0);
                 $('#grand_total_credit').text(Math.abs(result));
            }
        }

        function cashReceivedInput()
        {
            var cash_given = $('#cash_given').val(0);
            var debit = 0;
            var credit = 0;
            // iterate through each td based on class and add the values
            $(".debit").each(function() {

                var value1 = $(this).text();
                // add only if the value is number
                if(!isNaN(value1) && value1.length != 0) {
                    debit += parseFloat(value1);
                }
            });
            $(".credit").each(function() {

                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    credit += parseFloat(value);
                }
            });

            // alert(debit)
            // alert(credit)
            var cash_received = $('#cash_received').val();
            var cash_given = $('#cash_given').val();
            var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
            $('#debit_total').text(debit);
            $('#credit_total').text(credit);
            if(result > 0)
            {
                $('#grand_total_credit').text(0);
                $('#grand_total_debit').text(Math.abs(result));
            }
            else
            {
                 $('#grand_total_debit').text(0);
                 $('#grand_total_credit').text(Math.abs(result));
            }
        }

        function cashGivenInput()
        {
            var cash_received = $('#cash_received').val(0);
            var debit = 0;
            var credit = 0;
            // iterate through each td based on class and add the values
            $(".debit").each(function() {

                var value1 = $(this).text();
                // add only if the value is number
                if(!isNaN(value1) && value1.length != 0) {
                    debit += parseFloat(value1);
                }
            });
            $(".credit").each(function() {

                var value = $(this).text();
                // add only if the value is number
                if(!isNaN(value) && value.length != 0) {
                    credit += parseFloat(value);
                }
            });

            // alert(debit)
            // alert(credit)
            var cash_received = $('#cash_received').val();
            var cash_given = $('#cash_given').val();
            var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
            $('#debit_total').text(debit);
            $('#credit_total').text(credit);
            if(result > 0)
            {
                $('#grand_total_credit').text(0);
                $('#grand_total_debit').text(Math.abs(result));
            }
            else
            {
                 $('#grand_total_debit').text(0);
                 $('#grand_total_credit').text(Math.abs(result));
            }
        }

        function defaultValue(btndel)
        {
            // alert('fdf')
            var cells = $(btndel).closest('tr').children('td');
            var item_id = cells.eq(0).find('select').val();
            $.ajax({
                type: "POST",
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: js_base_url+"item-detail",
                dataType: 'html',
                data: {
                    '_token':$('meta[name="csrf-token"]').attr('content'),
                    item_id: item_id
                },

                beforeSend: function(){
                },
                complete: function(){
                },

                success: function (data) {
                    
                    var responseData = JSON.parse(data);
                    var entry_rates = responseData.entry_rates;
                    var exits_rates = responseData.exits_rates;
                    var default_units = responseData.default_units;
                    /*units*/
                    cells.eq(3).find('select').val(default_units);
                    if(cells.eq(5).find('select').val() == 'exits')
                    {
                        cells.eq(4).find('input').val(exits_rates);
                    }
                    else if(cells.eq(5).find('select').val() == 'entry')
                    {
                        cells.eq(4).find('input').val(entry_rates);
                    }

                    /*start*/
                    var value1 = cells.eq(2).find('input').val();
                    var value2 = cells.eq(4).find('input').val();
                    if(cells.eq(5).find('select').val() == 'exits')
                    {
                        /*credit*/
                        cells.eq(6).text(0);
                        cells.eq(7).text(new Number(value1) * new Number(value2));
                    }
                    else
                    {
                        /*debit*/
                        cells.eq(6).text(new Number(value1) * new Number(value2));
                        cells.eq(7).text(0);
                    }
                    
                    var debit = 0;
                    var credit = 0;
                    // iterate through each td based on class and add the values
                    $(".debit").each(function() {

                        var value1 = $(this).text();
                        // add only if the value is number
                        if(!isNaN(value1) && value1.length != 0) {
                            debit += parseFloat(value1);
                        }
                    });
                    $(".credit").each(function() {

                        var value = $(this).text();
                        // add only if the value is number
                        if(!isNaN(value) && value.length != 0) {
                            credit += parseFloat(value);
                        }
                    });
                    // alert(debit)
                    // alert(credit)
                    var cash_received = $('#cash_received').val();
                    var cash_given = $('#cash_given').val();
                    var result = Number(debit) + Number(cash_received) - Number(cash_given) - Number(credit)
                    $('#debit_total').text(debit);
                    $('#credit_total').text(credit);
                  if(result > 0)
                    {
                        $('#grand_total_credit').text(0);
                        $('#grand_total_debit').text(Math.abs(result));
                    }
                    else
                    {
                         $('#grand_total_debit').text(0);
                         $('#grand_total_credit').text(Math.abs(result));
                    }
                    /*end*/
                },

                error: function(data){
                    alert('error');
                }
            });
        }

        
    </script>

</head>

<body onMouseover="cashreceivegiven()" >
    <div id="wrapper">

        @include('side_menu')

        <div id="page-wrapper">

            <div class="container-fluid">
                @if(Session::has('success'))
                    <p class="alert alert-info">{{ Session::get('success') }}</p>
                @endif
                 @if(Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/js/bootstrap.min.js') }}"></script>

    <!-- validation -->
    <script src="{{ URL::asset('assets/jquery-validation-1.14.0/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('assets/DataTables-1.10.12/media/js/jquery.dataTables.min.js') }}"></script>
    


    <!-- custome -->
    <script src="{{ URL::asset('assets/custome/admin.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#customer_select').on('change',function(){
                var customer_id = $('#customer_select').val();
                $.ajax({
                    type: "POST",
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: js_base_url+"customer-detail",
                    dataType: 'html',
                    data: {
                        '_token':$('meta[name="csrf-token"]').attr('content'),
                        customer_id: customer_id
                    },

                    beforeSend: function(){
                    },
                    complete: function(){
                    },

                    success: function (data) {
                        $('#customerInformation').html(data);
                    },

                    error: function(data){
                        alert('error');
                    }
                });
            })

            /*select default value*/
            // $('.item_select_in_bill').on('change',function(){
                
            // })


           

           
            
        })
    </script>
    @yield('script')
    <!-- Add customer -->
<div aria-hidden="true" aria-labelledby="customer_add_model" role="dialog" tabindex="-1" id="customer_add_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> नया ग्राहक </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="<?php echo url('/add-customer'); ?>">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="full_name">ग्राहकको नाम </label>
                    <input type="text" class="form-control" name="full_name" required>
                  </div>
                  <div class="form-group">
                    <label for="address">ठेगाना </label>
                    <input type="text" class="form-control" name="address" required>
                  </div>
                  <div class="form-group">
                    <label for="contact_number">सम्पर्क नम्बर 1</label>
                    <input type="number" class="form-control" name="contact_number" required>
                  </div>
                  <div class="form-group">
                    <label for="contact_number2">सम्पर्क नम्बर 2</label>
                    <input type="number" class="form-control" name="contact_number2" required>
                  </div>
                  <div class="form-group">
                    <label for="customerPhoto">फोटो </label>
                    <input type="file" class="form-control image_input" name="customerPhoto"  accept="image/*">
                    <img src="assets/images/default-profile-picture.gif" class="image_preview" width="30%" height="15%">
                  </div>
                </div>
                <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                  <button class="btn btn-success" name="submit" type="submit">भयो </button>
                </div>
          </form>
      </div>
  </div>
</div>

<!-- Add source -->
<div aria-hidden="true" aria-labelledby="customer_edit_model" role="dialog" tabindex="-1" id="customer_edit_model" class="modal fade" data-backdrop="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"> ग्राहकको विवरण परिबर्तन </h4>
          </div>
          <form role="form" method="post" enctype="multipart/form-data" action="{{ url('/edit-customer') }}">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="customer_id"  value="">
               <input type="hidden" name="old_image"  value="">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="full_name">ग्राहकको नाम </label>
                    <input type="text" class="form-control" name="full_name"  value="" required>
                  </div>
                  <div class="form-group">
                    <label for="address">ठेगाना </label>
                    <input type="text" class="form-control" name="address"  value="" required>
                  </div>
                  <div class="form-group">
                    <label for="contact_number">सम्पर्क नम्बर 1</label>
                    <input type="number" class="form-control" name="contact_number"   value=""required>
                  </div>
                  <div class="form-group">
                    <label for="contact_number2">सम्पर्क नम्बर 2</label>
                    <input type="number" class="form-control" name="contact_number2"  value="" required>
                  </div>
                  <div class="form-group">
                    <label for="customerPhoto">फोटो </label>
                    <input type="file" class="form-control image_input_edit" name="customerPhoto"  accept="image/*">
                    <img src="" class="image_preview_edit" width="30%" height="15%">
                  </div>
                </div>
                <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                  <button class="btn btn-success" name="submit" type="submit">परिबर्तन</button>
                </div>
          </form>
      </div>
  </div>
</div>

    <!--Confirmation popup for delete-->
    <div class="modal fade" id="deleteConfirmationBtn" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
