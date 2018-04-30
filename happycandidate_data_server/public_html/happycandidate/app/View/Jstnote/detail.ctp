<?php
	echo $this->Html->script('tinymce/tiny_mce');
	$strJobSearchProcessUrl = Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true);
?>
<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Job Seeker Notes</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;">
			<a style="float:right;margin-right:10px;" id="contact_jsp_<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id']; ?>" onclick="fnDeleteContact(this,'1')" href="javascript:void(0);" name="add_contact_but" class="button_class">Delete</a>
			<a style="float:right;margin-right:10px;" id="contact_delete_<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id']; ?>" href="<?php echo $strJobSearchProcessUrl; ?>" name="add_contact_but" class="button_class">Job Search Process</a>
			<a style="float:right;margin-right:10px;" id="contact_edit_<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id']; ?>" onclick="fnShowEditForm(this,'1')" href="javascript:void(0);" name="add_contact_but" class="button_class">Edit</a>
			<a style="float:right;margin-right:10px;" href="<?php echo $strListcontactsurl; ?>" name="add_contact_but" id="add_contact_but" class="button_class">Back</a>
		</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_notes');
		?>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;">
			<div id="edit_appointment" style="float:left;width:100%;display:none;">
				<?php
					echo $this->element('notes_add_tpl');
				?>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div id="detail_appointment" style="float:left;width:100%;">
				<?php
					echo $this->element('notes_detail');
				?>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div style="float:left;width:100%;">&nbsp;</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#deteailmode').val('1');
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