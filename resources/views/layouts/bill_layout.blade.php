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
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('assets/bill/css/style.css') }}" />
	<link rel='stylesheet' type='text/css' href="{{ URL::asset('assets/bill/css/print.css') }}" media="print" />
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
	<!-- jQuery -->
  <script src="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/js/jquery.js') }}"></script>
  
    

    <?php 
        $path = url('/')."/";
    ?>
    <script type="text/javascript">
        var js_base_url =  <?php echo "'".$path."'";?>
    </script>
    <script language="javascript">
        function checkInput(ob) {
          var invalidChars = /[^0-9.]/gi
          if(invalidChars.test(ob.value)) {
                    ob.value = ob.value.replace(invalidChars,"");
              }
        }
    </script>

</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
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
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('assets/startbootstrap-sb-admin-1.0.4/js/bootstrap.min.js') }}"></script>
    <script type='text/javascript' src="{{ URL::asset('assets/bill/js/jquery-1.3.2.min.js') }}"></script>

    
    <script type="text/javascript">
        function print_today() {
          var now = new Date();
          var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
          var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
          function fourdigits(number) {
            return (number < 1000) ? number + 1900 : number;
          }
          var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
          return today;
        }

        // from http://www.mediacollege.com/internet/javascript/number/round.html
        function roundNumber(number,decimals) {
          var newString;// The new rounded number
          decimals = Number(decimals);
          if (decimals < 1) {
            newString = (Math.round(number)).toString();
          } else {
            var numString = number.toString();
            if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
              numString += ".";// give it one at the end
            }
            var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
            var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
            var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
            if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
              if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
                while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                  if (d1 != ".") {
                    cutoff -= 1;
                    d1 = Number(numString.substring(cutoff,cutoff+1));
                  } else {
                    cutoff -= 1;
                  }
                }
              }
              d1 += 1;
            } 
            if (d1 == 10) {
              numString = numString.substring(0, numString.lastIndexOf("."));
              var roundedNum = Number(numString) + 1;
              newString = roundedNum.toString() + '.';
            } else {
              newString = numString.substring(0,cutoff) + d1.toString();
            }
          }
          if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
            newString += ".";
          }
          var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
          for(var i=0;i<decimals-decs;i++) newString += "0";
          //var newNumber = Number(newString);// make it a number if you like
          return newString; // Output the result to the form field (change for your purposes)
        }

        function update_total() {
          var total = 0;
          $('.price').each(function(i){
            price = $(this).html().replace("$","");
            if (!isNaN(price)) total += Number(price);
          });

          total = roundNumber(total,2);

          $('#subtotal').html(total);
          $('#total').html(total);
          
          update_balance();
        }

        function update_balance() {
          var due = $("#total").html().replace("$","") - $("#paid").val().replace("$","");
          due = roundNumber(due,2);
          
          $('.due').html(due);
        }

        function update_price() {
          var row = $(this).parents('.item-row');
          var price = row.find('.cost').val().replace("$","") * row.find('.qty').val();
          price = roundNumber(price,2);
          isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html(price);
          
          update_total();
        }

        function bind() {
          $(".cost").blur(update_price);
          $(".qty").blur(update_price);
        }

        $(document).ready(function() {

          $('input').click(function(){
            $(this).select();
          });

          $("#paid").blur(update_balance);
           
          $("#addrow").click(function(){
            $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><select class="form-control" name="particular[]" required><option></option><?php if($items){foreach($items as $item){ ?><option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option><?php }}?></select><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description" ><textarea class="form-control" name="description[]"></textarea></td><td><textarea class="cost form-control" name="cost[]" onkeyup="checkInput(this)" required></textarea></td><td><select class="form-control" name="units[]" required><option></option><?php if($units){foreach($units as $uni){ ?><option value="<?php echo $uni->id; ?>"><?php echo $uni->name; ?></option><?php }}?></select></td><td><textarea class="qty form-control" name="qty[]" onkeyup="checkInput(this)" required></textarea></td><td><span class="price">0</span></td></tr>');
            if ($(".delete").length > 0) $(".delete").show();
            bind();
          });
          
          bind();
          
          $(".delete").live('click',function(){
            $(this).parents('.item-row').remove();
            update_total();
            if ($(".delete").length < 2) $(".delete").hide();
          });
          
          
          
          $("#date").val(print_today());

          
        });
    </script>

    

    @yield('script')

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
