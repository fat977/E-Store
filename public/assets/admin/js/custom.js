$(document).ready(function(){
    $('#categories').DataTable();
    $('#sections').DataTable();
    $('#brands').DataTable();
    $('#banners').DataTable();
    $('#products').DataTable();
    $('#users').DataTable();
    $('#filters').DataTable();

    //check current status
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/check-current-password',
            data : {current_password:current_password},
            success : function(res){
                if(res =="false"){
                    $("#check_password").html("<font color='red'> current password is incorrect! </font>");
                }
                else if(res =="true"){
                    $("#check_password").html("<font color='green'> current password is correct! </font>");
                }
            },
            error : function(){
                
            }

        });
    });

    // forgot password
	/* $("#forgotForm").submit(function(){
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/admin/forgot-password',
			type:'POST',
			success:function(resp){
				if(resp.type=="error"){
					//$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#forgot-"+i).attr('style','color:red');
						$("#forgot-"+i).html(error);
					
						setTimeout(function(){
							$("#forgot-"+i).css({'display':'none'});
						},3000);
				});
				}else if(resp.type=="success"){
					//alert(resp.message);
					//$(".loader").hide();
					$("#forgot-success").attr('style','color:green');
					$("#forgot-success").html(resp.message);
				}
				
			},error:function(){
				alert("Error");
			}
		
		 });
	}); */


    // category status
    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/category/update-category-status',
            data : {status:status,category_id:category_id},
            success : function(res){
                if(res['status']==0){
                    $("#category-"+category_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#category-"+category_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }

        });
    });

    //append categories
    $("#section_id").change(function(){
		var section_id = $(this).val();
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'get',
			url:'/admin/category/append-categories',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategories").html(resp);
			},error:function(){
				alert("Error");
			}
		})
	});

    // section status
    $(document).on("click",".updateSectionStatus",function(){
    var status = $(this).children("i").attr("status");
    var section_id = $(this).attr("section_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'post',
        url : '/admin/section/update-section-status',
        data : {status:status,section_id:section_id},
        success : function(res){
            if(res['status']==0){
                $("#section-"+section_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
            }
            else if(res['status']==1){
                $("#section-"+section_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
            }
        },
        error : function(){
            alert(error);
        }

    });
    });

    // brand status
    $(document).on("click",".updateBrandStatus",function(){
    var status = $(this).children("i").attr("status");
    var brand_id = $(this).attr("brand_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'post',
        url : '/admin/brand/update-brand-status',
        data : {status:status,brand_id:brand_id},
        success : function(res){
            if(res['status']==0){
                $("#brand-"+brand_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
            }
            else if(res['status']==1){
                $("#brand-"+brand_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
            }
        },
        error : function(){
            alert(error);
        }

    });
    });

    // product status
    $(document).on("click",".updateProductStatus",function(){
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/product/update-product-status',
            data : {status:status,product_id:product_id},
            success : function(res){
                if(res['status']==0){
                    $("#product-"+product_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#product-"+product_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }
    
        });
    });

     // banner status
    $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/banner/update-banner-status',
            data : {status:status,banner_id:banner_id},
            success : function(res){
                if(res['status']==0){
                    $("#banner-"+banner_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#banner-"+banner_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }
    
        });
    });

    $(document).on("click",".updateImageStatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-image-status',
            data : {status:status,image_id:image_id},
            success : function(res){
                if(res['status']==0){
                    $("#image-"+image_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#image-"+image_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }

        });
    });

    // products attributes status
    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/attribute/update-attribute-status',
            data : {status:status,attribute_id:attribute_id},
            success : function(res){
                if(res['status']==0){
                    $("#attribute-"+attribute_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#attribute-"+attribute_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }

        });
    });

       // filters status
       $(document).on("click",".updateFilterStatus",function(){
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/filter/update-filter-status',
            data : {status:status,filter_id:filter_id},
            success : function(res){
                if(res['status']==0){
                    $("#filter-"+filter_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#filter-"+filter_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }

        });
    });

      // filters values status
    $(document).on("click",".updateFilterValueStatus",function(){
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/filter/update-filter-value-status',
            data : {status:status,filter_id:filter_id},
            success : function(res){
                if(res['status']==0){
                    $("#filter-"+filter_id).html('<i style="font-size: 20px" class="far fa-bookmark" status="inactive"></i>');
                }
                else if(res['status']==1){
                    $("#filter-"+filter_id).html('<i style="font-size: 20px" class="fas fa-bookmark" status="active"></i>');
                }
            },
            error : function(){
                alert(error);
            }

        });
    });


    //confirm delete sweet alert
     //confirm delete sweet alert
     $(document).on("click",".confirmDelete",function(){
        var module = $(this).attr("module");
        var moduleid = $(this).attr("moduleid");
        var name = $(this).attr("name");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              window.location = "/admin"+"/"+name+"/delete-"+module+"/"+moduleid;
            }

          })
    });  
    

    //get brands
    $(document).on("click",".getBrands",function(){
        $('select[name="category_id"]').on('change', function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="brand_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="brand_id"]').append('<option value="' +
                                value + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
     ////// add / remove products attributes /////
     var maxField = 10; //Input fields increment limitation
     var addButton = $('.add_button'); //Add button selector
     var wrapper = $('.field_wrapper'); //Input field wrapper
     var fieldHTML = '<div><input type="text" name="size[]" placeholder="size"/><input type="text" name="stock[]" placeholder="stock"/><input type="text" name="price[]" placeholder="price"/><input type="text" name="sku[]" placeholder="sku"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
     var x = 1; //Initial field counter is 1
     
     //Once add button is clicked
     $(addButton).click(function(){
         //Check maximum number of input fields
         if(x < maxField){ 
             x++; //Increment field counter
             $(wrapper).append(fieldHTML); //Add field html
         }
     });
     
     //Once remove button is clicked
     $(wrapper).on('click', '.remove_button', function(e){
         e.preventDefault();
         $(this).parent('div').remove(); //Remove field html
         x--; //Decrement field counter
     });
 
    // show filters on selection categories
    $("#category_id").on("change",function(){
       var category_id =$(this).val();
       $.ajax({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type:'post',
         url:'/admin/filter/category-filters',
         data:{category_id:category_id},
         success:function(resp){
             $(".LoadFilters").html(resp.view);
         },error:function(){
             alert("Error");
         }
     })
    });
});