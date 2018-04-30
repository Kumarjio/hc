function fnUpdateCVSummary()
{
	
	var cvsummaryupdateurl = strGlobalDocRootUrl+"update_cv_summary.php?portid="+strGlobalCurrentPortalId;
	var cvsummaryupdatetype = "POST";
	var cvsummaryupdateoptions = { 
		beforeSubmit:  function(formData, jqForm, options) {
		},
		success:function(responseText, statusText, xhr, $form) {
			//alert(responseText);
			$('#cvsummaryloader').hide();
			if(responseText.status == "success")
			{
				//alert(responseText.message);
				$('#cv_summary_message_success').text('');
				$('#cv_summary_message_success').removeClass('ui-state-error');
				$('#cv_summary_message_success').addClass('ui-state-success');
				$('#cv_summary_message_success').text(responseText.message);
				$('#cv_summary_message_success').fadeIn('slow');
			}
			else
			{
				$('#cv_summary_message_success').text('');
				$('#cv_summary_message_success').removeClass('ui-state-success');
				$('#cv_summary_message_success').addClass('ui-state-error');
				$('#cv_summary_message_success').text(responseText.message);
				$('#cv_summary_message_success').fadeIn('slow');
			}
			
		},								
		url:       cvsummaryupdateurl,         // override for form's 'action' attribute 
		type:      cvsummaryupdatetype,        // 'get' or 'post', override for form's 'method' attribute 
		dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
	}
	$('#cv_career_summary').ajaxSubmit(cvsummaryupdateoptions);
	$('#cvsummaryloader').show();
	return false;
}