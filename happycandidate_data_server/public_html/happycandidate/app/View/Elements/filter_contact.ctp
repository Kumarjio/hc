<script type="text/javascript">
function fnSubmitFilterContact()
{
	var isValidated = $('#contact_filter').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		var intPortalId = $('#portal_id').val();
		var pageurl = "<?php echo Router::url('/', true)."jstcontacts/searchform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('.tabloader').show();
				$('#contacts_container').hide();
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('.tabloader').hide();
					$('#contacts_container').html(responseText.contactshtml);
					$('#contacts_container').show();
				}
				else
				{
					$('.tabloader').hide();
					$('#contacts_container').html("<p style='color:#E04B39;'>"+responseText.message+"</p>");
					$('#contacts_container').show();
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#contact_filter').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>
<div id="contact_filteration_strip" style="float:left;width:100%;display:none;">
	<form id="contact_filter" name="contact_filter">
		<ul class="panel-2 margin-top-5">
			<li style="width:">
				<label>First Name:</label>
				<input type="text" name="contact_fname" id="contact_fname" />
			</li>
			<li>
				<label>Last Name:</label>
				<input type="text" name="contact_lname" id="contact_lname" />
			</li>
			<li>
				<label>Email Address:</label>
				<input type="text" name="contact_email" id="contact_email" />
			</li>
			<li>
				<input type="button" name="contact_filter_but" id="contact_filter_but" class="button_class" value="Filter" onclick="fnSubmitFilterContact();return false;" />
				&nbsp;
				<input type="reset" name="contact_filter_reset_but" id="contact_filter_reset_but" class="button_class" value="Reset"/>
			</li>
	</form>
</div>