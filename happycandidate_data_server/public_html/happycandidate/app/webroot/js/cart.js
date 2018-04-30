function fnAddtocart(ele)
{
	var strElementId = $(ele).attr('id');
	if(strElementId != "")
	{
		arrElement = strElementId.split("_");
		var intResourceId = arrElement[3];
		
		
		var intPortalId = arrElement[4];
		if(intResourceId != "")
		{
			$('#product_action').hide();
			$('.cms-bgloader-mask').show();//show loader mask
                        $('.cms-bgloader').show(); //show loading image
			var strUrl = strBaseUrl+"resources/addtocart/"+intPortalId+"/"+intResourceId;;
			$.ajax({ 
					type: "GET",
					url: strUrl,
					dataType: 'json',
					data:"",
					cache:false,
					async:false,
					success: function(data)
					{
						if(data.status == "success")
						{
                                                    $('#operation_messages').html(data.message);
                                                    $('#operation_messages').show();
                                                    $('#product_action').show();
                                                    $('#product_load_action').hide();
                                                    window.location.href = strBaseUrl+"portal/shop/"+intPortalId;
						}
						else
						{
							//alert("fail");
						}
                                                    $('#product_action').show();
                                                    $('#product_load_action').hide();
                                                    $('.cms-bgloader-mask').hide();//hide loader mask
                                                    $('.cms-bgloader').hide(); //hide loading image
					}
			});
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function fnRemoveItem(ele)
{
	var strElementId = $(ele).attr('id');
	if(strElementId != "")
	{
		arrElement = strElementId.split("_");
		var intResourceId = arrElement[1];
		var intCountId = arrElement[2];
		var intPortalId = arrElement[3];
		if(intResourceId != "")
		{
			var strUrl = strBaseUrl+"resources/removefromcart/"+intPortalId+"/"+intResourceId+"/"+intCountId;
			$('#cartdetail').hide();
			$('.tabloader').show();
			$.ajax({ 
					type: "GET",
					url: strUrl,
					dataType: 'json',
					data:"",
					cache:false,
					async:false,
					success: function(data)
					{
						if(data.status == "success")
						{
							if(data.carthtml != "")
							{
								$('#cartdetail').html(data.carthtml);
							}
							else
							{
								$('#cartdetail').html('');
							}
							$('.tabloader').hide();
							$('#cartdetail').show();
						}
						else
						{
							//alert("fail");
							$('.tabloader').hide();
							$('#cartdetail').show();
						}
					}
			});
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function fnRemoveItemFromOrder(ele)
{
	var strElementId = $(ele).attr('id');
	if(strElementId != "")
	{
		arrElement = strElementId.split("_");
		var intResourceId = arrElement[2];
		var intOrderId = arrElement[1];
		var intPortalId = arrElement[3];
		if(intResourceId != "")
		{
			var strUrl = strBaseUrl+"resources/removefromorder/"+intPortalId+"/"+intResourceId+"/"+intOrderId;
			$('#contacts_container').hide();
			$('.tabloader').show();
			$.ajax({ 
					type: "GET",
					url: strUrl,
					dataType: 'json',
					data:"",
					cache:false,
					async:false,
					success: function(data)
					{
						if(data.status == "success")
						{
							if(data.orderhtml != "")
							{
								$('#contacts_container').html(data.orderhtml);
							}
							else
							{
								$('#contacts_container').html('');
							}
							$('.tabloader').hide();
							$('#contacts_container').show();
						}
						else
						{
							//alert("fail");
							$('.tabloader').hide();
							$('#contacts_container').show();
						}
					}
			});
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function fnShowCart(intPortalId)
{
	var strUrl = strBaseUrl+"resources/showcart/"+intPortalId;
	$('#cartdetail').hide();
	$('.tabloader').show();
	$.ajax({ 
			type: "GET",
			url: strUrl,
			dataType: 'json',
			data:"",
			cache:false,
			async:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.carthtml);
					$('#cartdetail').html(data.carthtml);
					$('.tabloader').hide();
					$('#cartdetail').show();
				}
				else
				{
					//alert("fail");
					$('.tabloader').hide();
					$('#cartdetail').show();
				}
			}
	});
	
}



function fnSubmitCheckout(ele)
{
	var strElementId = $(ele).attr('id');
	
	var validate = $("#checkoutfrm").validationEngine('validate');

	
	if(validate==false)
	{
		return false;
	}
	else
	{
			if(strElementId)
			{
					//return false;
				$('.cms-bgloader-mask').show();//show loader mask
                                $('.cms-bgloader').show(); //show loading image
				arrElement = strElementId.split("_");
				var strUrl = "";
				datastr = "order_id="+$('#order_id').val()+"&total_amount="+$('#total_amount').val()+"&customer_id="+$('#customer_id').val()+"&cust_fname="+$('#customer_fname').val()+"&cust_lname="+$('#customer_lname').val()+"&cust_address="+$('#customer_address').val()+"&card_number="+$('#card_number').val()+"&exp_month="+$('#exp_month').val()+"&exp_year="+$('#exp_year').val()+"&vendor_id="+$("#vendorId").val()+"&post_code="+$("#txt_post_code").val()+"&txt_country="+$("#txt_country").val()+"&txtstateprovince="+$("#txtstateprovince").val()+"&txtcounty="+$("#txtcounty").val();

                                strUrl = strBaseUrl+"resources/confirmorders/"+arrElement[1];
				$('#submit_'+arrElement[1]).hide();
				$('#load').show();
				$.ajax({ 
						type: "POST",
						url: strUrl,
						dataType: 'json',
						data:datastr,
						cache:false,
						async:false,
						success: function(data)
						{
							if(data.status == "success")
							{
							//$('#submit_'+arrElement[1]).show();
                                                            if(data.type == "othersite"){
                                                                
                                                            $('.cms-bgloader-mask').hide();//show loader mask
                                                            $('.cms-bgloader').hide(); //show loading image
                                                            $('#load').hide();
                                                            $('#submit_'+arrElement[1]).show();
                                                            window.location.href = strBaseUrl+"resources/ordersuccess/"+arrElement[1]+"/"+data.transactionid; 
                                                                window.open("http://"+data.redirect_link,'_blank');
                                                            }else{
                                                               window.location.href = strBaseUrl+"resources/ordersuccess/"+arrElement[1]+"/"+data.transactionid; 
                                                            }
							}
							else
							{
								$('.cms-bgloader-mask').hide();//show loader mask
								$('.cms-bgloader').hide(); //show loading image
								$('#load').hide();
								$('#submit_'+arrElement[1]).show();
								$('#checkout_messages').html('<div class="alert alert-success">  <img alt="image description" src="'+strBaseUrl+'images/icon-alert-success.png"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Error occured. Please try again.</div>');
							}
						}
				});
			}
			else
			{
				return false;
			}
	}
}

function fnCheckOut(ele)
{
	var strElementId = $(ele).attr('id');
        
	if(strElementId != "")
	{
		$('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image
		arrElement = strElementId.split("_");
                var vendor_id = $("#vendor_id").val();
		var strUrl = "";
		if(arrElement.length == "3")
		{
			strUrl = strBaseUrl+"resources/checkout/"+arrElement[1]+"/"+arrElement[2]+"/"+vendor_id;
			$('#product_action').hide();
			$('#product_load_action').show();
		}
		else
		{
                    if(vendor_id !='undefined'){
                        strUrl = strBaseUrl+"resources/checkout/"+arrElement[1];
                    }else{
                        strUrl = strBaseUrl+"resources/checkout/"+arrElement[1]+"/"+vendor_id;
                    }
                    $('#checkout_'+arrElement[1]).hide();
                    $('#load').show();
		}
		
		$.ajax({ 
				type: "GET",
				url: strUrl,
				dataType: 'json',
				data:"",
				cache:false,
				async:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						if(arrElement.length == "3")
						{
                                                         window.location.href = strBaseUrl+"resources/orders/"+arrElement[1]+"/"+arrElement[2]+"/"+vendor_id;
							$('#product_action').show();
							$('#product_load_action').hide();
                                                        
						}
						else
						{
							$('#load').hide();
							$('#checkout_'+arrElement[1]).show();
						}
                                                
                                                if(arrElement.length == "3")
						{
                                                    
                                                }else{
                                                    if(vendor_id =='' || vendor_id !='undefined'){
                                                        window.location.href = strBaseUrl+"resources/orders/"+arrElement[1];
                                                    }else{
                                                        window.location.href = strBaseUrl+"resources/orders/"+arrElement[1]+"/"+vendor_id;
                                                    }
                                                }
					}
					else
					{
						if(arrElement.length == "3")
						{
							$('#product_action').show();
							$('#product_load_action').hide();
						}
						else
						{
							$('#load').hide();
							$('#checkout_'+arrElement[1]).show();
						}
					}
				}
		});
	}
	else
	{
		return false;
	}
}

function continueForbilling(ele)
{
		var strUrl = "";
		datastr = "order_id="+$('#order_id').val()+"&total_amount="+$('#total_amount').val()+"&customer_id="+$('#customer_id').val()+"&cust_fname="+$('#customer_fname').val()+"&cust_lname="+$('#customer_lname').val()+"&cust_address="+$('#customer_address').val()+"&card_number="+$('#card_number').val()+"&exp_month="+$('#exp_month').val()+"&exp_year="+$('#exp_year').val();
		var strElementId = $(ele).attr('id');
	
		arrElement = strElementId.split("_");
		//return false;
		$('.cms-bgloader-mask').show();//show loader mask
	 	    $('.cms-bgloader').show(); //show loading image
		strUrl = strBaseUrl+"resources/getPayCardhtml/"+arrElement[1];
		$('#submit_'+arrElement[1]).hide();
		$('#load').show();
		$.ajax({ 
				type: "POST",
				url: strUrl,
				dataType: 'json',
				data:datastr,
				cache:false,
				async:false,
				success: function(data)
				{
					$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
					if(data.status == "success")
					{
						
						$('#load').hide();
					$('.ordershtml').html(data.html);
						
					}
					else
					{
						$('#load').hide();
						$('#submit_'+arrElement[1]).show();
						$('#checkout_messages').html(data.message);
					}
				}
		});
}
function sharewithfriend(portalid)
{
	
	var isValidated = jQuery('#share_form').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = appBaseU+"portal/sharewithfriend/"+portalid;
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				if(responseText.status == "success")
				{
					$("#tell_a_friend").modal('hide');
					$("#alertjobmessage").html(responseText.message);
				}
				else
				{
					$("#tell_a_friend").modal('hide');
					$("#alertjobmessage").html(responseText.message);
				}
				
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#share_form').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}