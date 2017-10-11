$(document).ready(function(){

	/*start customer*/
	$(".customer_edit").on('click', function(e){
    	e.preventDefault();
    	var customerId = $(this).data('id');
    	var customerName = $(this).data('name');
    	var customerAddress = $(this).data('address');
    	var customerContact1 = $(this).data('contactone');
        var customerContact2 = $(this).data('contacttwo');
    	var old_image = $(this).data('image');
        // alert(old_image)

    	//insert display message to the delete confirmation modal
        $('#customer_edit_model').find("input[name='customer_id']").val(customerId);
        $('#customer_edit_model').find("input[name='full_name']").val(customerName);
        $('#customer_edit_model').find("input[name='address']").val(customerAddress);
        $('#customer_edit_model').find("input[name='contact_number']").val(customerContact1);
        $('#customer_edit_model').find("input[name='contact_number2']").val(customerContact2);
        $('#customer_edit_model').find("input[name='old_image']").val(old_image);
        if(old_image == "")
        {
            
            $(".image_preview_edit").attr('src',js_base_url+"assets/images/default-profile-picture.gif");
        }
        else
        {
            $(".image_preview_edit").attr('src',js_base_url+"assets/uploads/customer/"+old_image);
        }
        

        // show the modal
        $('#customer_edit_model').modal();

    });

    $(".customer_delete").on('click', function(e){
        e.preventDefault();
        var Id = $(this).data('id');
        
        var Name = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#deleteConfirmationBtn').find('.modal-header h4').html("Delete");
        $('#deleteConfirmationBtn').find('.modal-body p').html("!!! Are you sure to delete " + "<span style='color: #d9534f'>"+Name+"</span>" + "? This process is nonreversible." );
        $('#deleteConfirmationBtn').find('.modal-footer a').attr("href", js_base_url + "delete-customer/" + Id);

        // show the modal
        $('#deleteConfirmationBtn').modal();



    });

    /*start item*/
    $(".item_edit").on('click', function(e){
        e.preventDefault();
        var itemId = $(this).data('id');
        var itemName = $(this).data('name');
        var itemRates = $(this).data('rates');
        var old_image = $(this).data('image');

        //insert display message to the delete confirmation modal
        $('#item_edit_model').find("input[name='item_id']").val(itemId);
        $('#item_edit_model').find("input[name='name']").val(itemName);
        $('#item_edit_model').find("input[name='rates']").val(itemRates);
        $('#item_edit_model').find("input[name='old_image']").val(old_image);
        $(".image_preview_edit").attr('src',js_base_url+"assets/uploads/items/"+old_image);

        // show the modal
        $('#item_edit_model').modal();

    });

    $(".item_delete").on('click', function(e){
        e.preventDefault();
        var Id = $(this).data('id');
        
        var Name = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#deleteConfirmationBtn').find('.modal-header h4').html("Delete");
        $('#deleteConfirmationBtn').find('.modal-body p').html("!!! Are you sure to delete " + "<span style='color: #d9534f'>"+Name+"</span>" + "? This process is nonreversible." );
        $('#deleteConfirmationBtn').find('.modal-footer a').attr("href", js_base_url + "delete-item/" + Id);

        // show the modal
        $('#deleteConfirmationBtn').modal();



    });

    /*start vehicles*/
    $(".vehicles_edit").on('click', function(e){
        e.preventDefault();
        var vehiclesId = $(this).data('id');
        var vehiclesNumber = $(this).data('name');
        var old_image = $(this).data('image');

        //insert display message to the delete confirmation modal
        $('#vehicles_edit_model').find("input[name='vehicles_id']").val(vehiclesId);
        $('#vehicles_edit_model').find("input[name='number']").val(vehiclesNumber);
        $('#vehicles_edit_model').find("input[name='old_image']").val(old_image);
        $(".image_preview_edit").attr('src',js_base_url+"assets/uploads/vehicles/"+old_image);

        // show the modal
        $('#vehicles_edit_model').modal();

    });

    $(".vehicles_delete").on('click', function(e){
        e.preventDefault();
        var Id = $(this).data('id');
        
        var Name = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#deleteConfirmationBtn').find('.modal-header h4').html("Delete");
        $('#deleteConfirmationBtn').find('.modal-body p').html("!!! Are you sure to delete " + "<span style='color: #d9534f'>"+Name+"</span>" + "? This process is nonreversible." );
        $('#deleteConfirmationBtn').find('.modal-footer a').attr("href", js_base_url + "delete-vehicles/" + Id);

        // show the modal
        $('#deleteConfirmationBtn').modal();



    });

    /*start vehicles*/
    $(".units_edit").on('click', function(e){
        e.preventDefault();
        var UnitsId = $(this).data('id');
        var UnitsName = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#units_edit_model').find("input[name='units_id']").val(UnitsId);
        $('#units_edit_model').find("input[name='name']").val(UnitsName);

        // show the modal
        $('#units_edit_model').modal();

    });

    $(".units_delete").on('click', function(e){
        e.preventDefault();
        var Id = $(this).data('id');
        
        var Name = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#deleteConfirmationBtn').find('.modal-header h4').html("Delete");
        $('#deleteConfirmationBtn').find('.modal-body p').html("!!! Are you sure to delete " + "<span style='color: #d9534f'>"+Name+"</span>" + "? This process is nonreversible." );
        $('#deleteConfirmationBtn').find('.modal-footer a').attr("href", js_base_url + "delete-units/" + Id);

        // show the modal
        $('#deleteConfirmationBtn').modal();



    });

    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            // if(input.files[0].size/1024 <= 500 )
            // {
              $('.image_preview').attr('src', e.target.result);
            // }
            // else
            // {
            //   alert('File size is too large !!! . Please choose the image up to 500 kb');
            // }
              
              // $('#image_priview').show();
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

    $(".image_input").change(function(){
        readURL(this);
    });

    function readURLEdit(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            // if(input.files[0].size/1024 <= 500 )
            // {
              $('.image_preview_edit').attr('src', e.target.result);
            // }
            // else
            // {
            //   alert('File size is too large !!! . Please choose the image up to 500 kb');
            // }
              
              // $('#image_priview').show();
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

    $(".image_input_edit").change(function(){
        readURLEdit(this);
    });


    
    

    
    

    
	

    

    $(".bill_delete").on('click', function(e){
        e.preventDefault();
        var Id = $(this).data('id');
        
        var Name = $(this).data('name');

        //insert display message to the delete confirmation modal
        $('#deleteConfirmationBtn').find('.modal-header h4').html("Delete");
        $('#deleteConfirmationBtn').find('.modal-body p').html("!!! Are you sure to delete " + "<span style='color: #d9534f'>"+Name+"</span>" + "? This process is nonreversible." );
        $('#deleteConfirmationBtn').find('.modal-footer a').attr("href", js_base_url + "bill-delete/" + Id);

        // show the modal
        $('#deleteConfirmationBtn').modal();



    });

    

    

    

	

})
// end