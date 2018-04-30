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
		var strMainContent =  $("#txtEditor").Editor("getText");
		
		var intPortalId = <?php echo $intPortalId;?>;
		var pageurl = "<?php echo Router::url('/', true)."jstnote/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#loader').show();
				formData.push({name:'notedesc', value:strMainContent});
			},
			success:function(responseText, statusText, xhr, $form) {
					$('#tab-notes').html(responseText.contactshtml);
				
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
<div class="tab-header">
	<h3><?php echo ($strHeader)?$strHeader:"Add"; ?> Note</h3><!--
	--><button type="button" class="btn btn-primary btn-sm">Add New</button>
	<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
</div>
<!--EDIT NOTE PILL DYN-->			
<div id="edit-note-panel-slider" class="panel-slider">
	<a href="#edit-note" class="panel-slider-item" data-toggle="collapse" data-parent="#edit-note-panel-slider">
		<div class="panel-slider-item-header">
			<h3>General</h3>
			<span class="icon-indicator"></span>
		</div>
	</a>
	<!--submenu-->			
	<div class="collapse" id="edit-note" data-parent="#edit-note-panel-slider">
		<div class="col-md-12 form-container edit-appointments">
			<form role="form" id="note_add_form"> 
				<div class="col-md-6">
					<div class="form-group">
						<label for="note-title" class="control-label col-xs-12 col-sm-12 col-md-4">Title: <span class="form-required">*</span></label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="note-title" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_title'];?>" placeholder="Note Title" required>
					</div>
					<div class="form-group">
						<label for="description" class="control-label col-xs-12 col-sm-12 col-md-4">Description: <span class="form-required">*</span></label><!--
						--><div name="description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
							<textarea id="txtEditor" name="notedesc"></textarea> 
							<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id'];?>' />
		<input type='hidden' name='type' id='type' value='default' />
						</div>
					</div>
					<div class="form-group">
						<label for="contact-name" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Name: <span class="form-required">*</span></label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="cname" id="cname" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_fname'];?>" placeholder="Contact Name" required>
					</div>
					<div class="form-group">
						<label for="contact-email" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Email: <span class="form-required">*</span></label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_email" id="c_email" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_email'];?>" placeholder="Contact Email" required>
					</div>
					<div class="form-group">
						<label for="contact-phone" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Phone:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_ph1_no" id="c_ph1_no" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_phone_no'];?>" placeholder="(555) 55 - 55 - 55">
					</div>
				</div>

				<div class="col-md-6">
					<div id="start-date-picker" class="form-group">
						<label for="from-date" class="control-label col-xs-12 col-sm-12 col-md-4">Note Date: <span class="form-required">*</span></label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date control-label' id='datetimepicker1'>
									<input type='text' class="form-control" name="a_start_date" id="a_start_date" placeholder="FROM DATE" value="<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_start_date'];?>" required>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" ></span>
									</span>
								</div>
								<script>
									function tal(event){
										
										$('#datetimepicker1').datetimepicker({
											
											format: 'YYYY-MM-DD'
										   
										});
										$('#datetimepicker2').datetimepicker({
											
											format: 'LT'
										   
										});
										$('#datetimepicker3').datetimepicker({
											
											format: 'YYYY-MM-DD'
										   
										});
										$('#datetimepicker4').datetimepicker({
											
											format: 'LT'
										   
										});
									}
									$(document).ready(function () {
										tal();
									});
									
									
									/*if (document.addEventListener) {
										document.addEventListener("DOMContentLoaded", tal);

									} else if (document.attachEvent) {
										document.attachEvent('DOMContentLoaded', tal);
									}*/
								</script>
						   </div>
					</div>
					<div id="start-time-picker" class="form-group">
						<label for="from-time" class="control-label col-xs-12 col-sm-12 col-md-4">Note Time: <span class="form-required">*</span></label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date' id='datetimepicker2'>
									<input type='text' class="form-control" name="a_start_time" id="a_start_time" placeholder="FROM TIME" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstNotes']['jstnotes_start_time']));?>" required>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
					</div>
				</div>
				<div class="col-md-12 submit-container">
					<div class="col-md-6">
					<div class="form-group">
						<div class="hidden-xs hidden-sm col-md-4"></div>
						<div class="col-xs-12 col-sm-12 col-md-8">
							<button type="button" class="btn btn-primary" onclick="fnSubmitAddAppointmentNote();return false;">Save Changes</button>
							<button type="button" class="btn btn-warning">Cancel</button>
						</div></div>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
<!--END OF EDIT NOTE PILL DYN-->	


<!--<p class="tabloader" id="notes_form_loader" style="display:none;"></p>
<form name="note_add_form" id="note_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:97%;display:inline-block;margin-right:3%;" class="advance_search">
		<textarea name="appoint_note" id="appoint_note"></textarea>
		<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppointmentNoteList[0]['JstAppointments']['jstappointments_id'];?>' />
		<input type='hidden' name='type' id='type' value='appointment' />
	</li>
	<li style="width:40%;">
		<input type="submit" id="add_appointment" value="Save" onclick="fnSubmitAddAppointmentNote();return false;" />
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>-->
<script type="text/javascript">

	$(document).ready(function () {
		//RUN EDITOR
    	$("#txtEditor").Editor();
		$("#txtEditor").Editor("setText", "<?php echo stripslashes($arrAppointmentList[0]['JstNotes']['jstnotes_description']); ?>")
		/*$("#a_start_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			minDate: -90,
			 onClose: function( selectedDate ) {
				$( "#a_end_date" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		$("#a_start_time").timepicker();
		
		$("#a_end_date").datepicker({ 
			dateFormat: 'yy-mm-dd',
			 onClose: function( selectedDate ) {
				$( "#a_start_date" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		$("#a_end_time").timepicker();*/
	});
</script>