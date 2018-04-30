<?php
	echo $this->Html->script('tinymce/tiny_mce');
	$strJobSearchProcessUrl = Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true);
?>
<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Appointments</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">
			<a style="float:right;margin-right:10px;" id="contact_jsp_<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id']; ?>" onclick="fnDeleteContact(this,'1')" href="javascript:void(0);" name="add_contact_but" class="button_class">Delete</a>
			<a style="float:right;margin-right:10px;" id="contact_delete_<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id']; ?>" href="<?php echo $strJobSearchProcessUrl; ?>" name="add_contact_but" class="button_class">Return To Job Search Process</a>
			<a style="float:right;margin-right:10px;" id="contact_edit_<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id']; ?>" onclick="fnShowEditForm(this,'1')" href="javascript:void(0);" name="add_contact_but" class="button_class">Edit</a>
			<a style="float:right;margin-right:10px;" href="<?php echo $strListcontactsurl; ?>" name="add_contact_but" id="add_contact_but" class="button_class">Back</a>
		</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_appointment');
			echo $this->element('delete_note');
		?>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<div id="edit_appointment" style="float:left;width:100%;display:none;">
				<?php
					echo $this->element('appointment_add_tpl');
				?>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div id="detail_appointment" style="float:left;width:100%;">
				<?php
					echo $this->element('appointment_detail');
				?>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div style="float:left;width:100%;">&nbsp;</div>
		</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div id="notes_container" class="line_up_table" style="float:left;width:100%;">
			<div style="float:left;width:100%;"><label>Notes: </label><input onclick="fnShowAddNote()" type="button" name="add_note" id="add_note" value="Add Note" /></div>
			<div id="notes_add" style="float:left;width:97%;display:none;">
				<?php
					echo $this->element('note_add_tpl');
				?>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<p class="tabloader" id="detail_notes_loader" style="display:none;"></p>
			<div id="detail_notes" style="float:left;width:100%;">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#deteailmode').val('1');
		
		fnLoadAppointMentNotes("<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id'];?>","<?php echo $intPortalId; ?>",'appointment');
	});
	
	function fnLoadConatctAdder()
	{
		$("#add_contact").dialog("open");
		if($('#contact_add_form').length>0)
		{
			$('#contact_add_form')[0].reset();
		}
	}
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
	
	
	function fnShowEditForm(ele,strMode)
	{
		var strElementId = $(ele).attr('id');
		var arrElementId = strElementId.split("_");
		
		$('#appoint_dsec_tbl').css('width','100%');
		$('#edit_appointment').toggle();
		$('#detail_appointment').toggle();
	}
</script>