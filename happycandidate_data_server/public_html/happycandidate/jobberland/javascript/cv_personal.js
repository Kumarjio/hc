function fnUpdateCVPersonal()
{
	
	var cvpersonalupdateurl = strGlobalDocRootUrl+"update_cv_personal.php?portid="+strGlobalCurrentPortalId;
	var cvpersonalupdatetype = "POST";
	var cvpersonalupdateoptions = { 
		beforeSubmit:  function(formData, jqForm, options) {
		},
		success:function(responseText, statusText, xhr, $form) {
			//alert(responseText);
			$('#cvpersonalloader').hide();
			if(responseText.status == "success")
			{
				//alert(responseText.message);
				$('#cv_personal_message_success').text('');
				$('#cv_personal_message_success').removeClass('ui-state-error');
				$('#cv_personal_message_success').addClass('ui-state-success');
				$('#cv_personal_message_success').text(responseText.message);
				$('#cv_personal_message_success').fadeIn('slow');
			}
			else
			{
				$('#cv_personal_message_success').text('');
				$('#cv_personal_message_success').removeClass('ui-state-success');
				$('#cv_personal_message_success').addClass('ui-state-error');
				$('#cv_personal_message_success').text(responseText.message);
				$('#cv_personal_message_success').fadeIn('slow');
			}
			
		},								
		url:       cvpersonalupdateurl,         // override for form's 'action' attribute 
		type:      cvpersonalupdatetype,        // 'get' or 'post', override for form's 'method' attribute 
		dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
	}
	$('#cv_personal_information').ajaxSubmit(cvpersonalupdateoptions);
	$('#cvpersonalloader').show();
	return false;
}
$(document).ready(function() {
	$("#cv_personal_information").validationEngine();
});