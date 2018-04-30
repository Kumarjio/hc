function fnUpdateCVSkills()
{
	
	var cvskillsupdateurl = strGlobalDocRootUrl+"update_cv_skills.php?portid="+strGlobalCurrentPortalId;
	var cvskillsupdatetype = "POST";
	var cvskillsupdateoptions = { 
		beforeSubmit:  function(formData, jqForm, options) {
		},
		success:function(responseText, statusText, xhr, $form) {
			//alert(responseText);
			$('#cvskillsloader').hide();
			if(responseText.status == "success")
			{
				//alert(responseText.message);
				$('#cv_skills_message_success').text('');
				$('#cv_skills_message_success').removeClass('ui-state-error');
				$('#cv_skills_message_success').addClass('ui-state-success');
				$('#cv_skills_message_success').text(responseText.message);
				$('#cv_skills_message_success').fadeIn('slow');
			}
			else
			{
				$('#cv_skills_message_success').text('');
				$('#cv_skills_message_success').removeClass('ui-state-success');
				$('#cv_skills_message_success').addClass('ui-state-error');
				$('#cv_skills_message_success').text(responseText.message);
				$('#cv_skills_message_success').fadeIn('slow');
			}
			
		},								
		url:       cvskillsupdateurl,         // override for form's 'action' attribute 
		type:      cvskillsupdatetype,        // 'get' or 'post', override for form's 'method' attribute 
		dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
	}
	$('#cv_skills_form').ajaxSubmit(cvskillsupdateoptions);
	$('#cvskillsloader').show();
	return false;
}