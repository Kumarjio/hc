
<div id="dialog-set-interview-reminder-form" title="Set Interview Reminder" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form type="POST" enctype="multipart/form-data" id="interviewreminderform">
		<fieldset>
			<div id="postinterviewsetmessages" class="" style="width:95%;display:none;"></div>
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			{*<span id="interviewsetloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>*}
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_name" style="font-size:90%;vertical-align:top;">Interview Name</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<input type="hidden" name="event_type" id="event_type" value="Interview" />
						<input type="hidden" name="participant_type" id="participant_type" value="Candidate" />
						<input type="hidden" name="participant_id" id="participant_id" value="{$intCandidateId}" />
						<input type="hidden" name="organization_type" id="organization_type" value="Portal" />
						<input type="hidden" name="organization_head_id" id="organization_head_id" value="{$intPortId}" />
						<input type="hidden" name="event_subject_type" id="event_subject_type" value="Job" />
						<input type="hidden" name="event_subject_id" id="event_subject_id" value="{$intJobId}" />
						
						<input type="text" name="event_name" id="event_name" Value="Interview Schedule" class="text ui-widget-content ui-corner-all validate[required]" />
						<span id="eventnameerror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>				
			</div>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_dsec" style="font-size:90%;vertical-align:top;">Interview Description</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<textarea name="event_dsec" id="event_dsec" class="text ui-widget-content ui-corner-all validate[required]">Your Interview for the post of {$job_title} with {$company_name}</textarea>
						<span id="eventdescerror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_date_time" style="font-size:90%;vertical-align:top;">Interview Date</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<input type="text" name="event_date_time" id="event_date_time" class="text ui-widget-content ui-corner-all validate[required]" />{*<small>e.g.2010-10-10</small>*}
						<span id="eventdatetimeerror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_venue" style="font-size:90%;vertical-align:top;">Interview Venue</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<textarea name="event_venue" id="event_venue" class="text ui-widget-content ui-corner-all validate[required]"></textarea>
						<span id="eventvenueerror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>			
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_contact_name" style="font-size:90%;vertical-align:top;">Interview Contact Person</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<input value="{$contact_name}" type="text" name="event_contact_name" id="event_contact_name" class="text ui-widget-content ui-corner-all validate[required]" />
						<span id="eventorganizererror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_reminder" style="font-size:90%;vertical-align:top;">Interview Reminder</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<select id="event_reminder" name="event_reminder" class="text ui-widget-content ui-corner-all validate[required]">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
						<span id="eventremindererror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>
			
			<div style="margin-bottom:0;padding:0;">&nbsp;</div>
			
			<div id="reminder_details" style="width:100%;float:left;">
				<div style="width:40%;float:left;">
					<label for="event_reminder_frequency" style="font-size:90%;vertical-align:top;">Interview Reminder Frequency</label>
				</div>
				<div style="width:60%;float:left;">
					<span style="margin-left:5%;">
						<input type="hidden" name="event_reminder_frequency" id="event_reminder_frequency" value="30" />
						<span>30mins before the time</span>
						<!--<select id="event_reminder_frequency" name="event_reminder_frequency" class="text ui-widget-content ui-corner-all validate[required]">
							<option value="daily">Daily</option>
							<option value="weekly">Weekly</option>
						</select>-->
						<span id="eventremindererror" class="ui-state-error" style="display:none;"></span>
					</span>
				</div>	
			</div>			
		</fieldset>
	</form>
</div>

{literal}
<script type="text/javascript">
	$(document).ready(function () {
		
		/*$("#event_date_time").datepicker({ 
			dateFormat: 'yy-mm-dd' 
		});*/
		
		/*$('#event_date_time').datetimepicker({ 
			dateFormat: 'yy-mm-dd',
			stepMinute: 5
		});*/
		
		$('#event_date_time').datetimepicker({ 
			dateFormat: 'yy-mm-dd'
		});
		
		
	
	
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
			height: 540,
			width: 500,
			modal: true,
			buttons: {
				"Set": function() {
						
							//$('#logoloader').show();
							var url = "{/literal}{$DOC_ROOT}{literal}add_event.php?portid={/literal}{$intPortId}{literal}";
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
{/literal}