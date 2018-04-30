<?php
	echo $this->Html->script('tinymce/tiny_mce');
?>
<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;">Job Seeker Tasks</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;"><a style="float:right;" href="<?php echo $contactlistsurl; ?>" name="add_contact" id="add_contact" class="button_class">Back</a></div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<?php
			echo $this->element('delete_note');
		?>
		<div style="float:left;width:100%;" id="contacts_container">
			<div style="float:left;width:100%;">
				<?php
					echo $this->element('tasks_add_tpl');
				?>
			</div>
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
		//$('#appt_reminder').val("<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_reminder_set']; ?>");
		$('#type').val("tasks");
		fnLoadAppointMentNotes("<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_id'];?>","<?php echo $intPortalId; ?>","tasks");
	});
</script>