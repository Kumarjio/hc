<?php
	echo $this->Html->script('tinymce/tiny_mce');
?>
<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;">Job Seeker Tasks</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<div style="float:left;width:100%;"><a style="float:right;" href="<?php echo $contactlistsurl; ?>" name="add_contact" id="add_contact" class="button_class">List Tasks</a></div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;" id="contacts_container">
			<div style="float:left;width:100%;">
				<?php
					echo $this->element('tasks_add_tpl');
				?>
			</div>
		</div>
	</div>
</div>