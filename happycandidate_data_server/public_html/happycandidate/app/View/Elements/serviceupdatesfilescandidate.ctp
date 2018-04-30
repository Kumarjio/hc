<form id="contentfileform" name="contentfileform" action="" method="post" role="form">
	<div class="row nopadding nomargin">
		<div class="col-md-12 nomargin"><strong>Attach Files:</strong></div>
		<div class="col-md-3" style="width:30%;">
			<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId;?>"/>
			<input data-toggle="modal" data-target="#mediaModal" name="add_media_main_content" id="add_media" class="content_media_button_order_update" type="button" value="Add Files"></input>
		</div>
	</div>
	<!--<div class="row">
		<div class="col-md-9"><input name="add_publish" id="add_publish" type="submit" value="Add"></input>&nbsp;<input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->Session->read('strCancelUrl');?>'" value="Cancel"></input></div>
	</div>-->
</form>
<?php
	echo $this->Html->script('content_form');
?>
<?php
	//echo $this->element('contentfile_uploader_modal');
?>