$(document).ready(function () {

	$('#delete_confirm').click(function () {
		var deleteFor = $('#delete_for').val();
		if(deleteFor != "")
		{
			$("#confirm_delete").modal('hide');
			fnDeleteProduct(deleteFor);
		}
		return false;
	});
	
});

function fnUnAssignOrderToSubVendor()
{
	var strSubVendorId = $('#vendoruser').val();
	var strOrderId = $('#vendor_order_id').val();

	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"vendororders/assignordertovendoruser/"+strOrderId+"/"+strSubVendorId+"/unassign",
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					alert(data.message);
					window.location.reload();
				}
				else
				{
					alert(data.message);
				}
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnAssignOrderToSubVendor()
{
	var strSubVendorId = $('#vendoruser').val();
	var strOrderId = $('#vendor_order_id').val();

	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "POST",
			url: appBaseU+"vendororders/assignordertovendoruser/"+strOrderId+"/"+strSubVendorId,
			data: '',
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					alert(data.message);
					window.location.reload();
				}
				else
				{
					alert(data.message);
				}
			
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnConfirmInquiryDelete(intInquiryId)
{
	//$("#confirm_delete").modal('show');
	$('#delete_for').val(intInquiryId);
	$("#confirm_delete").dialog("open");
}

function fnConfirmInquiryClose(intInquiryId)
{
	//$("#confirm_delete").modal('show');
	$('#close_for').val(intInquiryId);
	$("#confirm_close").dialog("open");
}

function fnCloseProduct(intProductId)
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"vendororders/closeorder/"+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					//$('.tabloader').hide();
					$('#product_list_notification').html(data.message);
					$('#order_status_'+intProductId).text('Closed');
				}
				else
				{
					$('#product_list_notification').html(data.message);
				}
			}
	});
}


function fnDeleteProduct(intProductId)
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"vendors/productdelete/"+intProductId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					//$('.tabloader').hide();
					$('#product_list_notification').html(data.message);
					$('#product_list_'+intProductId).remove();
                                        $('#str'+intProductId).remove();
                                        $('#product_notification').html(data.message);
				}
				else
				{
					$('#product_list_notification').html(data.message);
                                        $('#product_notification').html(data.message);
				}
			}
	});
}

function fnShowEditableFields(ele)
{
	var strAction = $(ele).val();
	var status = $('#right_label_answer_order_status').text();
	//alert(strAction);
	if(strAction == "Edit")
	{
		$('#order_status').val(status.trim());
		$('.order_display_fields').toggle();
		$('.order_editable_fields').toggle();
	}
	
	if(strAction == "Done")
	{
		var intOrderId = $('#order_id').val();
		var strOrderStatus = $('#order_status').val();
		if(status.trim() != strOrderStatus)
		{
			fnChangeOrderStatus(intOrderId,strOrderStatus,"1");
		}
		else
		{
			$('.order_display_fields').toggle();
			$('.order_editable_fields').toggle();
		}
	}
	
}

function fnChangeOrderStatus(strOrderId,strOrderStatus,strEditMode)
{
	$('#order_done_loader').show();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"vendororders/changeorderstatus/"+strOrderId+"/"+strOrderStatus,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					//$('.tabloader').hide();
					$('#order_done_loader').hide();
					$('#product_list_notification').html(data.message);
					if(strEditMode == "1")
					{
						$('#right_label_answer_order_status').text(strOrderStatus);
						$('.order_display_fields').toggle();
						$('.order_editable_fields').toggle();
					}
				}
				else
				{
					$('#product_list_notification').html(data.message);
				}
			}
	});
}
function fnSendPassNot(ele){	
	var strElementId = $(ele).attr('id');
	var arrElementId = strElementId.split("_");	
       $('#pass_for').val(arrElementId[2]);	
       //deleteVendor(arrElementId[2]);	
       //$('#confirm_delete').dialog("open");	
      $("#password_confirm_vendor").modal('show');
}

function sendPassNotificationTosubVendor(intVendorId)
{
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); 
    //show loading image	$('#contacts_container').hide();
	$.ajax({ 		
	type: "POST",			
       url: strBaseUrl+"vendoraccount/sendpassnotification/"+intVendorId,	
       dataType: 'json',			
      data:"",		
    cache:false,	
 		success: function(data)			
{				if(data.status == "success")				
                   {					//alert(data.content)					
                   $('.cms-bgloader-mask').hide();//show loader mask	
				$('.cms-bgloader').hide(); //show loading image					
                   $('.message').remove();										                               $('#product_notification').prepend(data.message);	
														}	
			else				{		
			$('.cms-bgloader-mask').hide();//show loader mask		
			$('.cms-bgloader').hide(); //show loading image			
		$('#product_notification').prepend(data.message);			
	}
			}	
            });
	}