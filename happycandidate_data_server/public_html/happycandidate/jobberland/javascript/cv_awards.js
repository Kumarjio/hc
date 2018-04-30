function fnUpdateCVAwards()
{
	
	var cvawardsupdateurl = strGlobalDocRootUrl+"update_cv_awards.php?portid="+strGlobalCurrentPortalId;
	var cvawardsupdatetype = "POST";
	var cvawardsupdateoptions = { 
		beforeSubmit:  function(formData, jqForm, options) {
		},
		success:function(responseText, statusText, xhr, $form) {
			//alert(responseText);
			$('#cvawardsloader').hide();
			if(responseText.status == "success")
			{
				//alert(responseText.message);
				$('#cv_awards_message_success').text('');
				$('#cv_awards_message_success').removeClass('ui-state-error');
				$('#cv_awards_message_success').addClass('ui-state-success');
				$('#cv_awards_message_success').text(responseText.message);
				$('#cv_awards_message_success').fadeIn('slow');
			}
			else
			{
				$('#cv_awards_message_success').text('');
				$('#cv_awards_message_success').removeClass('ui-state-success');
				$('#cv_awards_message_success').addClass('ui-state-error');
				$('#cv_awards_message_success').text(responseText.message);
				$('#cv_awards_message_success').fadeIn('slow');
			}
			
		},								
		url:       cvawardsupdateurl,         // override for form's 'action' attribute 
		type:      cvawardsupdatetype,        // 'get' or 'post', override for form's 'method' attribute 
		dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
	}
	$('#cv_awards_form').ajaxSubmit(cvawardsupdateoptions);
	$('#cvawardsloader').show();
	return false;
}