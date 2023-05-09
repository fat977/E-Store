
$(document).ready(function(){
	loadWishlist();

    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-products-price',
            type:'post',
            data:{size:size,product_id:product_id},
            success:function(resp){
               //alert(resp['discount']);
               if(resp['discount']>0){
                 $(".getAttributePrice").html("<div class='price'><h4>RS."+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price:</span><span>RS."+resp['product_price']+"</span></div>");
               }else{
                $(".getAttributePrice").html("<div class='price'><h4>RS."+resp['final_price']+"</h4></div>");

               }
            },error:function(){
                alert("Error");
            }
        });
    });

    // Update Cart Items Qty
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// increase the qty by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// Check Qty is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}
			// increase the qty by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
        var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty},
			url:'/cart/update',
			method:'post',
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerView);
			},error:function(){
				alert("Error");
			}
        
         });
    });

	// delete Cart Items Qty
	$(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
		var result = confirm('are you sure to delete this ?');
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{cartid:cartid},
				url:'/cart/delete',
				method:'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerView);
				},error:function(){
					alert("Error");
				}
			
			 });

		}
		//alert(cartid);
		
    });

	// Add To Wishlist
	$('.addToWishlist').click(function(e){
		e.preventDefault();
		var product_id = $(this).closest('.product_data').find('.product_id').val();
		//alert(product_id);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				'product_id':product_id,
			},
			url:'/wishlist/add-to-wishlist',
			method:'POST',
			success:function(resp){
				if(resp.type=="success"){
					$("#wishlist-success").attr('style','color:#0f5132; background-color:#d1e7dd; padding:20px; border-color: #badbcc');
					$("#wishlist-success").html(resp.message);	
					
					setTimeout(function(){
						$("#wishlist-success").css({'display':'none'});
					},6000);
					loadWishlist();	
			    }else if(resp.type=="error"){
					$("#wishlist-error").attr('style','color:#842029; background-color:#f8d7da; padding:20px; border-color: #f5c2c7');
					$("#wishlist-error").html(resp.message);
					setTimeout(function(){
						$("#wishlist-error").css({'display':'none'});
					},6000);
				}
				
			},error:function(){
				alert("Error");
			}
			
		});
	});

	function loadWishlist(){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/wishlist/load-wishlist-count',
			method:'GET',
			success:function(response){
				$('.wishlist-count').html('');
				$('.wishlist-count').html(response.count);
			}
			
		});
	}
	// delete wishlist Items 
	$(document).on('click','.remove_item',function(e){
		e.preventDefault();
		var product_id = $(this).closest('.product_data').find('.product_id').val();
		var result = confirm('are you sure to delete this ?');
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{
					'product_id':product_id,
				},
				url:'/wishlist/delete-wishlist-item',
				method:'POST',
				success:function(response){
					loadWishlist();
					$('.WishlistItems').load(location.href +" .WishlistItems");
					//window.location.reload();
					//alert(response.status); 
				}
				
			});
		}
	});

	//delete review
	$(document).on('click','.delete-review',function(e){
		e.preventDefault();
		var product_id = $(this).closest('.product_data').find('.product_id').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{
				'product_id':product_id,
			},
			url:'/delete-review',
			method:'POST',
			success:function(response){
				//$('.Reviews').load(location.href +" .Reviews");
				window.location.reload();
				//alert(response.status);
			}
			
		});
	});

	// register form validation
	$("#registerForm").submit(function(){
		$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/user/register',
			type:'POST',
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
					
						setTimeout(function(){
							$("#register-"+i).css({'display':'none'});
						},3000);
				});
				}else if(resp.type=="success"){
					//alert(resp.message);
					$(".loader").hide();
					$("#register-success").attr('style','color:green');
					$("#register-success").html(resp.message);
				}
				
			},error:function(){
				alert("Error");
			}
		
		 });
	});

	// account form validation
	$("#accountForm").submit(function(){
		//$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/user/account',
			type:'POST',
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#account-"+i).attr('style','color:red');
						$("#account-"+i).html(error);
					
						setTimeout(function(){
							$("#account-"+i).css({'display':'none'});
						},3000);
				});
				}else if(resp.type=="success"){
					$("#account-success").attr('style','color:green');
					$("#account-success").html(resp.message);
				}
				
			},error:function(){
				alert("Error");
			}
		
		 });
	});

	// password form validation
	$("#passwordForm").submit(function(){
		//$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/user/update-password',
			type:'POST',
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#password-"+i).attr('style','color:red');
						$("#password-"+i).html(error);
					
						setTimeout(function(){
							$("#password-"+i).css({'display':'none'});
						},3000);
				});
				
				}else if(resp.type=="incorrect"){
					$("#password-error").attr('style','color:red');
					$("#password-error").html(resp.message);
				
					setTimeout(function(){
						$("#password-error").css({'display':'none'});
					},3000);
				
			    }else if(resp.type=="success"){
					$("#password-success").attr('style','color:green');
					$("#password-success").html(resp.message);
				}
				
			},error:function(){
				alert("Error");
			}
		
		 });
	});

	//check current status
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
		
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/user/check-current-password',
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
                alert(current_password);
            }

        });
    });


	// forgot password
	$("#forgotForm").submit(function(){
		//$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/user/forgot-password',
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
	});

	// login form validation
	$("#loginForm").submit(function(){
		var formdata =$(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:formdata,
			url:'/user/login',
			type:'POST',
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#login-"+i).attr('style','color:red');
						$("#login-"+i).html(error);
					
						setTimeout(function(){
							$("#login-"+i).css({'display':'none'});
						},3000);
				});
				}else if(resp.type=="incorrect"){
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}else if(resp.type=="success"){
					window.location.href= resp.url;
				}else if(resp.type=="inactive"){
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}
				
			},error:function(){
				alert("Error");
			}
		
		 });
	});

});


function get_filters(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}