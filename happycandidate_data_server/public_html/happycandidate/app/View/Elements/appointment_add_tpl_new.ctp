<script type="text/javascript">
function fnSubmitAddAppointment()
{

	var isValidated = $('#appointment_add_form').validationEngine('validate');
	
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		
		var strMainContent =  $("#txtEditor").Editor("getText");
		var intPortalId = <?php echo $intPortalId;?>;
		var pageurl = "<?php echo Router::url('/', true)."jstappointments/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#loader').show();
				formData.push({name:'appoint_dsec', value:strMainContent});
			},
			success:function(responseText, statusText, xhr, $form) {
			
				if(responseText.status == "success")
				{
					
					$('#tab-appointments').html(responseText.contactshtml);
					/*$('#tab-calendar').html(responseText.contactshtml);
					$('.taaaabs').removeClass('active');
					$('#caltab').addClass('active');
					
					$('.tab-pane').removeClass('active');
					$('.tab-pane').removeClass('in');
					
					$('#tab-calendar').addClass('in ');
					$('#tab-calendar').addClass('active');*/
					
				}
				else
				{
					$('#loader').hide();
					$('#contact_form_messages').css('color','#E04B39');
					$('#contact_form_messages').text(responseText.message);
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#appointment_add_form').ajaxSubmit(pageoptions);
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
	<h3><?php echo ($strHeader)?$strHeader:"Add"; ?> Appointment</h3><!--
	--><button type="button"  onclick="fnLoadAppointmentAdder()" class="btn btn-primary btn-sm">Add New</button>
</div>

<!--EDIT APPOINTMENT PILL DYN-->			
<div id="edit-appointments-panel-slider" class="panel-slider">
	
	<!--submenu-->			
	
		<div class="col-md-12 form-container edit-appointments" style="overflow:visible;">
			<form role="form" id="appointment_add_form">
				<div class="col-md-6">
					<div class="form-group">
						<label for="appt_type" class="control-label col-xs-12 col-sm-12 col-md-4">Type: </label><!--
						--><select style="margin-top:0;" class="col-xs-12 col-sm-12 col-md-8" name="appt_type" id="appt_type" >
							<option value="">--Select Type--</option>
							<option value="Interview – Face-to-Face">Interview – Face-to-Face</option>
							<option value="Interview – Informational">Interview – Informational</option>
							<option value="Interview – Telephone">Interview – Phone</option>
							<option value="Interview -  Skype or Video">Interview -  Skype or Video</option>
							<option value="Job Fairs">Job Fairs</option>
							<option value="Networking Events">Networking Events</option>
							<option value="Trade Shows">Trade Shows</option>
							<option value="Other">Other</option>
							
							<!--<option value="Apply for Job">Apply for Job</option>
							<option value="Version of Resume or CV">Version of Resume or CV</option>
							<option value="Cover Letter">Cover Letter</option>
							<option value="Version of Cover Letter">Version of Cover Letter</option>
							<option value="Follow Up Call">Follow Up Call</option>
							<option value="Follow Up Email">Follow Up Email</option>
							<option value="Networking Contact or Event">Networking Contact or Event</option>
							<option value="Send Resume or CV Directly to Decision Maker">Send Resume or CV Directly to Decision Maker</option>
							<option value="Research or Sourcing">Research or Sourcing</option>
							<option value="Thank you email">Thank you email</option>
							<option value="Thank you Letter or Note">Thank you Letter or Note</option>-->
							
						</select>
					</div>
					
					<div class="form-group">
						<label for="appointment-title" class="control-label col-xs-12 col-sm-12 col-md-4">Title: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" id="appointment-title" type="text" name="appointment-title" value="<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_title'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_title']:'' ?>" placeholder="Appointment Title"  >
						<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_id'];?>' />
						<input type='hidden' name='deteailmode' id='deteailmode' value='' />
					</div>
					<div class="form-group">
						<label for="description" class="control-label col-xs-12 col-sm-12 col-md-4">Description: </label><!--
						--><div name="description" class="col-xs-12 col-sm-12 col-md-8 app-area-container"><!--
						--><textarea id="txtEditor" name="appoint_dsec"><?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_description'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_description']:'' ?></textarea> 
						</div>
					</div>
					<?php
							if(is_array($arrContacts) && (count($arrContacts)>0))
							{
								?>
								<div class="form-group">
									<label for="contact-name" class="control-label col-xs-12 col-sm-12 col-md-4">Internal Contacts:</label><!--
									--><select onchange="fnGetContactDetails()" class="col-xs-12 col-sm-12 col-md-8" name="is_internal" id="is_internal">
									<option value="">--Select One--</option>
								<?php
									foreach($arrContacts as $arrContact)
									{
										?>
											<option value="<?php echo $arrContact['JstContacts']['jstcontacts_id'];?>"><?php echo $arrContact['JstContacts']['jstcontacts_fname']." ".$arrContact['JstContacts']['jstcontacts_lname'];?></option>
										<?php
									}
									?>
									</select>
								</div>
									<?php
							}
					?>
					<div class="form-group">
						<label for="contact-name" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Name: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" type="text" name="cname" id="cname" value="<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_fname'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_fname']:'' ?>" placeholder="Contact Name" required>
					</div>
					<div class="form-group">
						<label for="contact-email" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Email: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[email]]" type="text" name="c_email" id="c_email" value="<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_email'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_email']:'' ?>" placeholder="Contact Email" required>
					</div>
					<div class="form-group">
						<label for="contact-phone" class="control-label col-xs-12 col-sm-12 col-md-4">Contact Phone:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_ph1_no" id="c_ph1_no" value="<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_phone_no'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_phone_no']:'' ?>" placeholder="(555) 55 - 55 - 55">
					</div>
					<div class="form-group">
						<label for="appt_reminder" class="control-label col-xs-12 col-sm-12 col-md-4">Reminder:</label><!--
						--><select style="margin-top:0;" class="col-xs-12 col-sm-12 col-md-8" name="appt_reminder" id="appt_reminder" >
							<option value="">--Select Reminder Time--</option>
							<option value="5 Minutes">5 Minutes</option>
							<option value="15 Minutes">15 Minutes</option>
							<option value="30 Minutes">30 Minutes</option>
							<option value="1 Hour">1 Hour</option>
							<option value="4 Hour">4 Hour</option>
							<option value="8 Hour">8 Hour</option>
							<option value="1 Day">1 Day</option>
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div id="start-date-picker" class="form-group">
						<label for="from-date" class="control-label col-xs-12 col-sm-12 col-md-6">Appointment start: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-6">
								<div class='input-group date control-label' id='datetimepicker1'>
									<input readonly="" type='text' class="form-control" name="a_start_date" id="a_start_date" placeholder="FROM DATE" required value="<?php echo date($productdateformatnew,strtotime($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_start_date']));?>">
									<input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid" value="<?php echo $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_start_date'];?>">
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
						<label for="from-time" class="control-label col-xs-12 col-sm-12 col-md-6">Appointment end: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-6">
								<div class='input-group date' id='datetimepicker2'>
									<input readonly="" type='text' class="form-control" name="a_start_time" id="a_start_time" value="<?php echo date('H:i',strtotime($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_start_time']));?>" placeholder="FROM TIME" required>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
					</div>
					<div id="end-date-picker" class="form-group">
						<label for="end-date" class="control-label col-xs-12 col-sm-12 col-md-6">Completion Date: </label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-6">
								<div class='input-group date control-label' id='datetimepicker3'>
									<input readonly="" type='text' class="form-control" name="a_end_date" id="a_end_date" placeholder="TO DATE" required value="<?php echo date($productdateformatnew,strtotime($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_end_date']));?>"><input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid" value="<?php echo $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_end_date'];?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar" ></span>
									</span>
								</div>
						   </div>
					</div>
					<div id="end-time-picker" class="form-group">
						<label for="end-time" class="control-label col-xs-12 col-sm-12 col-md-6">Completion Time:</label><!--
						--><div class="datetime-container col-xs-12 col-sm-12 col-md-6">
								<div class='input-group date' id='datetimepicker4'>
									<input readonly="" type='text' class="form-control" name="a_end_time" id="a_end_time" placeholder="TO TIME" required value="<?php echo date('H:i',strtotime($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_end_time'])); ?>">
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
							<button id="save-button" type="button" onclick="fnSubmitAddAppointment();return false;" class="btn btn-primary">Save Changes</button>
							<button type="button" class="btn btn-warning">Cancel</button>
						</div></div>
					</div>
				</div>
			</form>
		</div>


</div>
<!--END OF EDIT APPOINTMENT PILL DYN-->
<!--<p id="contact_form_messages" style="display:none;"></p>
<p class="tabloader" id="add_model_loader" style="display:none;"></p>
<div id="form_loader_mask" class="pagemask"></div>
<form name="appointment_add_form" id="appointment_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Name:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_contact_fname'])
			{
				?>
					<input style="margin-top:0;" type="text" class="validate[required,custom[onlyLetterSp]]" value="<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_contact_fname'];?>" name="cname" id="cname" data-prompt-position="topRight:-100" />
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
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_contact_email'])
			{
				?>
					<input type="text" style="margin-top:0;" class="validate[required,custom[email]]" name="c_email" id="c_email" value="<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_contact_email'];?>" data-prompt-position="topRight:-100"/>
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
		<input type='hidden' name='appointmentid' id='appointmentid' value='<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_id'];?>' />
		<input type='hidden' name='deteailmode' id='deteailmode' value='' />
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_contact_id'])
			{
				?>
					<input type='hidden' name='contactid' id='contactid' value='<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_contact_id'];?>' />
				<?php
			}
		?>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Contact Telephone Number:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_contact_phone_no'])
			{
				?>
					<input type="text" style="margin-top:0;" value="<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_contact_phone_no'] ;?>" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
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
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_description'])
			{
				?>
					<textarea style="margin-top:0;" name="appoint_dsec" id="appoint_dsec"><?php echo htmlspecialchars_decode(stripslashes($arrAppointmentList[0]['JstAppointments']['jstappointments_description']));;?></textarea>
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
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Appointment Date:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_start_date'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_start_date'];?>" name="a_start_date" id="a_start_date" data-prompt-position="topRight:-100"/>
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
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Appointment Time:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_start_time'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstAppointments']['jstappointments_start_time']));?>" name="a_start_time" id="a_start_time" data-prompt-position="topRight:-100"/>
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
	
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Appointment End Date:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_end_date'])
			{
				?>
					<input type="text" style="margin-top:0;" value="<?php echo $arrAppointmentList[0]['JstAppointments']['jstappointments_end_date'] ;?>" name="a_end_date" id="a_end_date" data-prompt-position="topRight:-100"/>
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
	
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Appointment End Time:</label></li>
	<li style="width:60%;display:inline-block;margin-right:3%;" class="advance_search">
		<?php
			if($arrAppointmentList[0]['JstAppointments']['jstappointments_end_time'])
			{
				?>
					<input style="margin-top:0;" type="text" value="<?php echo date('H:i',strtotime($arrAppointmentList[0]['JstAppointments']['jstappointments_end_time'])); ?>" name="a_end_time" id="a_end_time" data-prompt-position="topRight:-100"/>
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
	<li style="width:30%;display:inline-block;margin-right:3%;vertical-align:top;" class="advance_search"><label>Reminder:</label><small>Remind Before</small></li>
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
	</li>
	<li style="width:40%;">
		<input type="submit" id="add_appointment" value="Save" onclick="fnSubmitAddAppointment();return false;" /> &nbsp; <input type="reset"  class="button_class" value="Reset"/>
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
		$("#txtEditor").Editor("setText", "<?php echo stripslashes($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_description']); ?>")
		
		$('#appointment-title').keydown(function(e){
			var code = e.keyCode || e.which;
			if (code === 9) { 
				e.preventDefault();
				$(".Editor-editor").focus();
			}
		});
		
		/*$('#datetimepicker4').on('dp.show', function() {
	      var datepicker = $('body').find('.bootstrap-datetimepicker-widget:last');
	      if (datepicker.hasClass('bottom')) {
	        var top = $(this).offset().top + $(this).outerHeight();
	        var left = $(this).offset().left;
	        datepicker.css({
	          'top': top + 'px',
	          'bottom': 'auto',
	          'left': left + 'px'
	        });
	      }
	      else if (datepicker.hasClass('top')) {
	        var top = $(this).offset().top - datepicker.outerHeight();
	        var left = $(this).offset().left;
	        datepicker.css({
	          'top': top + 'px',
	          'bottom': 'auto',
	          'left': left + 'px'
	        });
	      }
	    });*/
		
		
		
		
		
		
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
		$('#appt_reminder').val("<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_reminder_set'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_reminder_set']:'' ?>");
		
		$('#appt_type').val("<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_type'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_type']:'' ?>");
		
		$('#is_internal').val("<?php echo ($arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_id'])? $arrAppoinmentDetail[0]['JstAppointments']['jstappointments_contact_id']:'' ?>");
	});
	
	function fnGetContactDetails()
	{
		var intContactId = $('#is_internal').val();
		var strUrl = appBaseU+"jstappointments/contactdetails/"+intContactId;
		var datastr = "";
		$('.cms-bgloader-mask').show();//show loader mask
	 	$('.cms-bgloader').show(); //show loading image
		$.ajax({ 
			type: "POST",
			url: strUrl,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				//alert(data);
				$('#cname').val(data.name);
				$('#c_email').val(data.email);
				$('#c_ph1_no').val(data.phone);
				
				
				
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide(); //show loading image
				
			}
	});
	}
</script>