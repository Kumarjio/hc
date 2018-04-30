<script type="text/javascript">
function fnSubmitAddTask()
{

	var isValidated = $('#task_add_form').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
	
		
		var strMainContent =  $("#txtEditor").Editor("getText");
		var intPortalId = <?php echo $intPortalId;?>;
	
		var pageurl = "<?php echo Router::url('/', true)."jsttasks/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
				formData.push({name:'task_dsec', value:strMainContent});
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#tab-tasks').html(responseText.contactshtml);
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
				else
				{
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					$('#contact_form_messages').css('color','#E04B39');
					$('#contact_form_messages').text(responseText.message);
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#task_add_form').ajaxSubmit(pageoptions);
		return false;
	}
}

function checkURL(field, rules, i, options)
{
	var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
	if(re.test(field.val())) 
	{
		return true;
	}
	else
	{
		return options.allrules.urlcheck.alertText;
	}
}
</script>
<div class="tab-header">
	<h3><?php echo ($strHeader)?$strHeader:"Add"; ?> Task</h3><!--
	--><button type="button" class="btn btn-primary btn-sm">Add New</button>
	<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
</div>

<!--EDIT TASK PILL DYN-->			
<div id="edit-task-panel-slider" class="panel-slider">
	
	<!--submenu-->			
	
		<div class="col-md-12 form-container edit-task" style="overflow:visible;">
			<form role="form" id="task_add_form">
				<div class="col-md-6">
					<div class="form-group">
						<label for="task_type" class="control-label col-xs-12 col-sm-12 col-md-4">Type: </label><!--
						--><select style="margin-top:0;" class="col-xs-12 col-sm-12 col-md-8" name="task_type" id="task_type" >
							<option value="">--Select Type--</option>
							<option value="Assessment Tools">Assessment Tools</option>
							<option value="Blog postings">Blog postings</option>
							<option value="Cover Letter – Write or Update">Cover Letter – Write or Update</option>
							<option value="Apply for Job">Follow up Call</option>
							<option value="Follow up Email">Follow up Email</option>
							<option value="Follow up Email">Follow up Email</option>
							<option value="Identify New Targets and Contact">Identify New Targets and Contact</option>
							<option value="Interview Prep">Interview Prep</option>
							<option value="Interview De-Brief">Interview De-Brief</option>
							<option value="LinkedIn Profile update">LinkedIn Profile update</option>
							<option value="Networking Contact">Networking Contact</option>
							<option value="Networking Social Media">Networking Social Media</option>
							<option value="Personal website">Personal website</option>
							<option value="Research/Sourcing">Research/Sourcing</option>
							<option value="Resume Direct to Hiring Authority">Resume Direct to Hiring Authority</option>
							<option value="Resume Job Board Postings">Resume Job Board Postings</option>
							<option value="Resume Referrals">Resume Referrals</option>
							<option value="Resume Website Postings">Resume Website Postings</option>
							<option value="Thank you Email, Letter or Note">Thank you Email, Letter or Note</option>
							<option value="Training to Enhance Skills">Training to Enhance Skills</option>
							<option value="Other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="note-title" class="control-label col-xs-12 col-sm-12 col-md-4">Title: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="note-title" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_title'];?>" placeholder="Note Title" id="title_tasks">
						<input type='hidden' name='taskid' id='taskid' value='<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_id'];?>' />
						<input type='hidden' name='deteailmode' id='deteailmode' value='' />
					</div>
					<div class="form-group">
						<label for="description" class="control-label col-xs-12 col-sm-12 col-md-4">Description: </label><!--
						--><div name="description" class="col-xs-12 col-sm-12 col-md-8 app-area-container">
							<textarea id="txtEditor" name="task_dsec"></textarea> 
						</div>
					</div>
					<div class="form-group">
						<label for="contact-name" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Name: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="cname" id="cname" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_fname'];?>" placeholder="Contact Name" required>
					</div>
					<div class="form-group">
						<label for="contact-email" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Email: 	</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_email" id="c_email" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_email'];?>" placeholder="Contact Email" required>
					</div>
					<div class="form-group">
						<label for="contact-phone" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Phone:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_ph1_no" id="c_ph1_no" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_phone_no'] ;?>" placeholder="(555) 55 - 55 - 55">
					</div>
				</div>

				<div class="col-md-6">
					<div id="start-date-picker" class="form-group">
						<label for="from-date" class="control-label col-xs-12 col-sm-12 col-md-4">Task Date: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date control-label' id='datetimepicker1'>
									<input readonly="" type='text' class="form-control" name="a_start_date" id="a_start_date" value="<?php echo date($productdateformatnew,strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_start_date']));?>" placeholder="FROM DATE" required>
									<input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_start_date'];?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" ></span>
									</span>
								</div>
								<script>
									function tal(event){
										
										$('#datetimepicker1').datetimepicker({
											
											format: '<?php echo $productdateformatjs;?>',
											ignoreReadonly: true,
											useCurrent: false
										   
										});
										
										$('#from_date_hid').datetimepicker({
											format:'YYYY-MM-DD'
										});
										
										
										$('#datetimepicker2').datetimepicker({
											
											format: 'HH:mm',
											ignoreReadonly: true
										   
										});
										$('#datetimepicker3').datetimepicker({
											
											format: '<?php echo $productdateformatjs;?>',
											ignoreReadonly: true,
											useCurrent: false
										   
										});
										
										$('#to_date_hid').datetimepicker({
												format:'YYYY-MM-DD'
										});
										
										
										$('#datetimepicker4').datetimepicker({
											
											format: 'HH:mm',
											ignoreReadonly: true
										   
										});
									}
									$(document).ready(function () {
										tal();
										
										$("#datetimepicker1").on("dp.change", function (e) {
											$('#from_date_hid').data("DateTimePicker").date(e.date);
										});
										
										$("#datetimepicker3").on("dp.change", function (e) {
											 $('#to_date_hid').data("DateTimePicker").date(e.date);
										});
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
						<label for="from-time" class="control-label col-xs-12 col-sm-12 col-md-4">Task Time: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date' id='datetimepicker2'>
									<input readonly="" type='text' class="form-control" name="a_start_time" id="a_start_time" placeholder="FROM TIME" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_start_time']));?>" required>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
					</div>
					<div id="completion-date-picker" class="form-group">
						<label for="completion-date" class="control-label col-xs-12 col-sm-12 col-md-4">Complete Date: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date control-label' id='datetimepicker3'>
									<input readonly="" type='text' class="form-control" name="a_end_date" id="a_end_date" placeholder="COMPLETION DATE" required value="<?php echo date($productdateformatnew,strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_end_date']));?>"/>
									<input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_end_date'];?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" ></span>
									</span>
								</div>
						   </div>
					</div>
					<div id="end-time-picker" class="form-group">
						<label for="end-time" class="control-label col-xs-12 col-sm-12 col-md-4">Complete Time: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-8">
								<div class='input-group date' id='datetimepicker4'>
									<input readonly="" type='text' class="form-control" name="a_end_time" id="a_end_time" placeholder="TO TIME" required value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_end_time'])); ?>"/>
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
							<button type="button" class="btn btn-primary"  onclick="fnSubmitAddTask();return false;" >Save Changes</button>
							<button type="button" class="btn btn-warning">Cancel</button>
						</div></div>
					</div>
				</div>
			</form>
		</div>

</div>
<!--END OF EDIT TASK PILL DYN-->
<!--<p id="contact_form_messages" style="display:none;"></p>
<p class="tabloader" id="add_model_loader" style="display:none;"></p>
<div id="form_loader_mask" class="pagemask"></div>
<form name="appointment_add_form" id="appointment_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Name:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_contact_fname'])
			{
				?>
					<input style="margin-top:0;" type="text" class="validate[required,custom[onlyLetterSp]]" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_fname'];?>" name="cname" id="cname" data-prompt-position="topRight:-100" />
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[onlyLetterSp]]" name="cname" id="cname" data-prompt-position="topRight:-100" />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Email:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_contact_email'])
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[email]]" name="c_email" id="c_email" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_email'];?>" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[email]]" name="c_email" id="c_email" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
		
		<input type='hidden' name='nohtml' id='nohtml' value='1' /> 		
		<input type='hidden' name='taskid' id='taskid' value='<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_id'];?>' />
		<input type='hidden' name='deteailmode' id='deteailmode' value='' />
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_contact_id'])
			{
				?>
					<input type='hidden' name='contactid' id='contactid' value='<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_id'];?>' />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Telephone Number:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_contact_phone_no'])
			{
				?>
					<input type="text" style="margin-top:0;" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_phone_no'] ;?>" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
				<?php
			}
		?>
	</li>
	<li style="width:90%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Action Description:</label></li>
	<li style="width:90%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_description'])
			{
				?>
					<textarea style="margin-top:0;" name="appoint_dsec" id="appoint_dsec"><?php echo htmlspecialchars_decode(stripslashes($arrAppointmentList[0]['JstTasks']['jsttasks_description']));;?></textarea>
				<?php
			}
			else
			{
				?>
					<textarea style="margin-top:0;" name="appoint_dsec" id="appoint_dsec"></textarea>
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Action Date:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_start_date'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_start_date'];?>" name="a_start_date" id="a_start_date" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input style="margin-top:0;" type="text" name="a_start_date" id="a_start_date" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Action Time:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_start_time'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_start_time']));?>" name="a_start_time" id="a_start_time" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input style="margin-top:0;" type="text" name="a_start_time" id="a_start_time" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Completion End Date:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_end_date'])
			{
				if($arrAppointmentList[0]['JstTasks']['jsttasks_end_date'] == "0000-00-00")
				{
					$arrAppointmentList[0]['JstTasks']['jsttasks_end_date'] = "";
				}
				?>
					<input type="text" style="margin-top:0;" value="<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_end_date'] ;?>" name="a_end_date" id="a_end_date" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" name="a_end_date" id="a_end_date" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Completion End Time:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstTasks']['jsttasks_end_time'])
			{
				if($arrAppointmentList[0]['JstTasks']['jsttasks_end_time'] == "00:00:00")
				{
					$arrAppointmentList[0]['JstTasks']['jsttasks_end_time'] = "";
				}
				?>
					<input style="margin-top:0;" type="text" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstTasks']['jsttasks_end_time'])); ?>" name="a_end_time" id="a_end_time" data-prompt-position="topRight:-100"/>
				<?php
			}
			else
			{
				?>
					<input type="text" style="margin-top:0;" name="a_end_time" id="a_end_time" data-prompt-position="topRight:-100"/>
				<?php
			}
		?>
	</li>
	<!--<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Reminder:</label><small>Remind Before</small></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<select style="margin-top:0;" name="appt_reminder" id="appt_reminder">
			<option value="">--Select Reminder Time--</option>
			<option value="5 Minutes">5 Minutes</option>
			<option value="15 Minutes">15 Minutes</option>
			<option value="30 Minutes">30 Minutes</option>
			<option value="1 Hour">1 Hour</option>
			<option value="4 Hour">4 Hour</option>
			<option value="8 Hour">8 Hour</option>
			<option value="1 Day">1 Day</option>
		</select>
	</li>-->
	<!--<li style="width:40%;">
		<input type="submit" id="add_appointment" value="Save" onclick="fnSubmitAddTask();return false;" /> &nbsp; <input type="reset"  class="button_class" value="Reset"/>
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>-->
<script type="text/javascript">

	$(document).ready(function () {
		$("#txtEditor").Editor();
	$("#txtEditor").Editor("setText", "<?php echo stripslashes($arrAppointmentList[0]['JstTasks']['jsttasks_description']); ?>")
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
		});*/
		
		$('#task_type').val("<?php echo ($arrAppointmentList[0]['JstTasks']['task_type'])? $arrAppointmentList[0]['JstTasks']['task_type']:'' ?>");
		
		$('#title_tasks').keydown(function(e){
			var code = e.keyCode || e.which;
			if (code === 9) { 
				e.preventDefault();
				$(".Editor-editor").focus();
			}
		});
		
	});
</script>