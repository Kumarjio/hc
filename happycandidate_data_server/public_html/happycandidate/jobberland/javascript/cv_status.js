function fnUpdateCVStatus()
{
	var strCvPublicStatus = $('#update_cv_status_public').attr('checked');
	var strCvPublicStatusData = "";
	if(strCvPublicStatus == "checked")
	{
		strCvPublicStatusData = "public";
	}
	var cvupdateurl = strGlobalDocRootUrl+"update_cv_status.php?portid="+strGlobalCurrentPortalId;
	var cvupdatetype = "POST";
	var cvupdateoptions = { 
		beforeSubmit:  function(formData, jqForm, options) {
		},
		success:function(responseText, statusText, xhr, $form) {
			//alert(responseText);
			$('#cvloader').hide();
			if(responseText.status == "success")
			{
				//alert(responseText.message);
				$('#cv_status_message_success').text('');
				$('#cv_status_message_success').removeClass('ui-state-error');
				$('#cv_status_message_success').addClass('ui-state-success');
				$('#cv_status_message_success').text(responseText.message);
				$('#cv_status_message_success').fadeIn('slow');
			}
			else
			{
				$('#cv_status_message_success').text('');
				$('#cv_status_message_success').removeClass('ui-state-success');
				$('#cv_status_message_success').addClass('ui-state-error');
				$('#cv_status_message_success').text(responseText.message);
				$('#cv_status_message_success').fadeIn('slow');
			}
			
		},								
		url:       cvupdateurl,         // override for form's 'action' attribute 
		type:      cvupdatetype,        // 'get' or 'post', override for form's 'method' attribute 
		dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
	}
	$('#cv_status_form').ajaxSubmit(cvupdateoptions);
	$('#cvloader').show();
	return false;
}