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

function fnConfirmInquiryDelete(intInquiryId)
{	alert(intInquiryId);
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
				}
				else
				{
					$('#product_list_notification').html(data.message);
				}
			}
	});
}

function fnShowEditableFields(ele,intPortalId)
{
	//alert("hi");
	
	var strAction = $(ele).val();
	var status = $('#right_label_answer_order_status').text();
	if(strAction == "Edit")
	{
		$('#order_status').val(status.trim());
		
		
		$('.order_display_fields').hide();
		$('.order_editable_fields').show();
	}
	
	if(strAction == "Done")
	{
		var intOrderId = $('#order_id').val();
		var strOrderStatus = $('#order_status').val();
		if(status.trim() != strOrderStatus)
		{
			fnChangeOrderStatus(intOrderId,strOrderStatus,"1",intPortalId);
		}
		else
		{
			$('.order_display_fields').toggle();
			$('.order_editable_fields').toggle();
		}
	}
	
}

function fnChangeOrderStatus(strOrderId,strOrderStatus,strEditMode,intPortalId)
{
	$('#order_done_loader').show();
	$.ajax({ 
			type: "POST",
			url: strBaseUrl+"myorders/changeorderstatus/"+intPortalId+'/'+strOrderId+"/"+strOrderStatus,
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