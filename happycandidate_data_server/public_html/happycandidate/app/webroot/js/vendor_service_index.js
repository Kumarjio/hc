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
{
	//$("#confirm_delete").modal('show');
	$('#delete_for').val(intInquiryId);
	$("#confirm_delete").dialog("open");
}

function fnDeleteProduct(intProductId)
{
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"vendorservices/productdelete/"+intProductId,
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