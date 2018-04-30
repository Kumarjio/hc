<div id="dialog-set-interview-reminder-form" title="Set Interview Reminder" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form type="POST" enctype="multipart/form-data" id="interviewreminderform">
		<fieldset>
			<div id="postinterviewsetmessages" class="" style="width:95%;display:none;"></div>
			<span id="interviewsetloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
			
			<label for="event_name" style="font-size:90%;">Interview Name</label>
			<input type="text" name="event_name" id="event_name" Value="Interview Schedule" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="eventnameerror" class="ui-state-error" style="display:none;"></span>
			<input type="hidden" name="event_type" id="event_type" value="Interview" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="participant_type" id="participant_type" value="Candidate" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="participant_id" id="participant_id" value="<?php echo $intCandidateId;?>" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="organization_type" id="organization_type" value="Portal" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="organization_head_id" id="organization_head_id" value="<?php echo $arrPortalDetail[0]['Portal']['career_portal_id'];?>" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="event_subject_type" id="event_subject_type" value="Job" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="event_subject_id" id="event_subject_id" value="<?php echo $arrJobDetail[0]['Job']['id'];?>" class="text ui-widget-content ui-corner-all" />
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<label for="event_dsec" style="font-size:90%;">Interview Description</label>
			<textarea name="event_dsec" id="event_dsec">Your Interview for the post of <?php echo $arrJobDetail['0']['Job']['title'];?> has been scheduled at <?php echo $arrJobDetail['0']['Job']['company'];?></textarea>
			<span id="eventdescerror" class="ui-state-error" style="display:none;"></span>
			
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<label for="event_date_time" style="font-size:90%;">Interview Date Time</label>
			<input type="text" name="event_date_time" id="event_date_time" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="eventdatetimeerror" class="ui-state-error" style="display:none;"></span>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<label for="event_venue" style="font-size:90%;">Interview Venue</label>
			<textarea name="event_venue" id="event_venue"></textarea>
			<span id="eventvenueerror" class="ui-state-error" style="display:none;"></span>
			
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<label for="event_contact_name" style="font-size:90%;">Interview Contact Person</label>
			<input value="<?php echo $arrJobDetail['0']['Job']['poster_email']; ?>" type="text" name="event_contact_name" id="event_contact_name" class="text ui-widget-content ui-corner-all validate[required]" />
			<span id="eventorganizererror" class="ui-state-error" style="display:none;"></span>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<label for="event_reminder" style="font-size:90%;">Interview Reminder</label>
			<select id="event_reminder" name="event_reminder">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
			<span id="eventremindererror" class="ui-state-error" style="display:none;"></span>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div id="reminder_details" style="margin-bottom:0;padding:0;">
				<label for="event_reminder_frequency" style="font-size:90%;">Interview Reminder Frequency</label>
				<select id="event_reminder_frequency" name="event_reminder_frequency">
					<option value="daily">Daily</option>
					<option value="weekly">Weekly</option>
				</select>
				<span id="eventremindererror" class="ui-state-error" style="display:none;"></span>
			</div>
			
			
		</fieldset>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#event_reminder').change(function () {
			var strEvenReminderOption = $('#event_reminder').val();
			if(strEvenReminderOption == "0")
			{
				$('#reminder_details').hide();
			}
			else
			{
				$('#reminder_details').show();
			}
		});
		
		$( "#dialog-set-interview-reminder-form" ).dialog({
			autoOpen: false,
			height: 590,
			width: 500,
			modal: true,
			buttons: {
				"Set": function() {
										
											
						
							$('#logoloader').show();
							var url = "<?php echo Router::url('/', true).$this->params['controller']."/updateevent/".$this->params['pass']['0'];?>";
							var type = "POST";
							var options = { 
								//target:        '#output2',   // target element(s) to be updated with server response 
								success:	function(responseText, statusText, xhr, $form) {
									if(responseText.status == "success")
									{
										$('#logoloader').hide();
										$('#postinterviewsetmessages').text('');
										$('#postinterviewsetmessages').removeClass('ui-state-error');
										$('#postinterviewsetmessages').addClass('ui-state-success');
										$('#postinterviewsetmessages').text(responseText.message);
										$('#postinterviewsetmessages').fadeIn('slow');
									}
									else
									{
										$('#logoloader').hide();
										$('#postinterviewsetmessages').text('');
										$('#postinterviewsetmessages').removeClass('ui-state-success');
										$('#postinterviewsetmessages').addClass('ui-state-error');
										$('#postinterviewsetmessages').text(responseText.message);
										$('#postinterviewsetmessages').fadeIn('slow');
										
									}
								},								
						 
								// other available options: 
								url:       url,         // override for form's 'action' attribute 
								type:      type,        // 'get' or 'post', override for form's 'method' attribute 
								dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
								//clearForm: true        // clear all form fields after successful submit 
								//resetForm: true        // reset the form after successful submit 
						 
								// $.ajax options can be used here too, for example: 
								//timeout:   3000 
							} 
							$('#interviewreminderform').ajaxSubmit(options); 
					 
							// !!! Important !!! 
							// always return false to prevent standard browser submit and page navigation 
							return false; 
						
													
					
				},
				Cancel: function() {
					$(this).dialog( "close" );
				}
			},
			close: function() {
				
			}
		});
	
	});

</script>