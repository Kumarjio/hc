<script type="text/javascript">
function fnSubmitAddAppointmentNote()
{
	var isValidated = $('#note_add_form').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		var strMainContent = tinyMCE.get('appoint_dsec').getContent();
		
		var intPortalId = $('#portal_id').val();
		var pageurl = "<?php echo Router::url('/', true)."jstappointments/addnote/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#notes_form_loader').show();
				$('#note_add_form').hide();
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#notes_form_loader').hide();
					$('#note_add_form').show();
					$('#note_add_form')[0].reset();
					$('#detail_notes').prepend(responseText.contactshtml);
					$('#notes_add').toggle();
					//$('#add_contact').dialog("close");
				}
				else
				{
					$('#loader').hide();
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#note_add_form').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>
<p class="tabloader" id="notes_form_loader" style="display:none;"></p>
<form name="note_add_form" id="note_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:97%;display:inline-block;margin-right:3%;" class="advance_search">
		<textarea name="appoint_note" id="appoint_note"></textarea>
		<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id'];?>' />
		<input type='hidden' name='type' id='type' value='appointment' />
	</li>
	<li style="width:40%;">
		<input type="submit" id="add_appointment" value="Save" onclick="fnSubmitAddAppointmentNote();return false;" />
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>