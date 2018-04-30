<script type="text/javascript">
function fnSubmitFilterAppoint()
{
	var isValidated = $('#appoint_filter').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		var intPortalId = $('#portal_id').val();
		var pageurl = "<?php echo Router::url('/', true)."jstappointments/searchform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#appoint_list_tabloader').show();
				$('#app_list').hide();
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#appoint_list_tabloader').hide();
					$('#app_list').html(responseText.contactshtml);
					$('#app_list').show();
				}
				else
				{
					$('#appoint_list_tabloader').hide();
					$('#app_list').html("<p style='color:#E04B39;'>"+responseText.message+"</p>");
					$('#app_list').show();
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#appoint_filter').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>
<div id="contact_filteration_strip" style="float:left;width:100%;display:none;">
	<form id="appoint_filter" name="appoint_filter">
		<ul class="panel-2 margin-top-5">
			<li style="width:">
				<label>Name:</label>
				<input type="text" name="contact_fname" id="contact_fname" />
			</li>
			<li>
				<label>Email Address:</label>
				<input type="text" name="contact_email" id="contact_email" />
			</li>
			<li>
				<input type="button" name="contact_filter_but" id="contact_filter_but" class="button_class" value="Filter" onclick="fnSubmitFilterAppoint();return false;" />
				&nbsp;
				<input type="reset" name="contact_filter_reset_but" id="contact_filter_reset_but" class="button_class" value="Reset"/>
			</li>
	</form>
</div>