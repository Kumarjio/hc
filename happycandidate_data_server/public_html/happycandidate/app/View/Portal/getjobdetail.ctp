	<div class="container-fluid bg-lightest-grey">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				
				<div class="page-header">
					<a href="#" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span> Back to Jobs</a>
				</div>
				<div class="find-jobs-body">
					<div class="col-md-9">
						<div class="job-details-container">
							<?php echo $this->Session->flash(); ?>
							<div id="alertjobmessage"></div>
							<h2><?php echo ($arrJobDetail['Job']['job_title']);?></h2>
							
							<p class="job-details-subheader">
								<span>Full-time</span> - <?php echo ($arrJobDetail['Job']['city']);?>, <?php echo ($arrJobDetail['Job']['country']);?> - Experienced level: <?php echo ($arrJobDetail['jobexperience']['experience_name']);?>   - Salary: $<?php echo ($arrJobDetail['Job']['job_salary']);?>k - Posted <?php echo date('Y M d',strtotime($arrJobDetail['Job']['created_at']));?>  - <?php echo ($arrJobDetail['Job']['views_count']);?> views - <?php echo ($arrJobDetail['Job']['apply_count']);?> applicants
							</p>

							<hr>
							<div class="description-table-container">
								<table>
									<tr>
										<td>
											Education Level:
										</td>
										<td>
											<?php echo ($arrJobDetail['jobeducation']['education_name']);?>
										</td>
										<td>
											Start Date:
										</td>
										<td>
										<?php echo ($arrJobDetail['job']['start_date']);?>	
										</td>
									</tr>
									<tr>
										<td>
											Relevant Work Experience:
										</td>
										<td>
											N/A
										</td>
										<td class="empty-column">
											&nbsp;
										</td>
										<td class="empty-column">
											&nbsp;
										</td>
									</tr>
								</table>
							</div>
							<hr>

							<p>
								<?php echo ($arrJobDetail['Job']['job_description']);?>
							</p>

							
							
							<div class="social-dropdown-container">
								<button class="btn btn-primary social-dropdown" id="social-dropdown">Share <span class="glyphicon glyphicon-chevron-down"></span></button>
							
								<script>
									$("#social-dropdown").click(function(e) {
										$(".social-dropdown-menu").css("display", "block");
										$(".social-dropdown-menu").css("position", "absolute");
										$(".social-dropdown-menu").css("bottom", "45px");
										$(".social-dropdown-menu").css("right", "0");

										$( "#social-dropdown-menu" ).mouseleave(function() {
											$(this).css("display", "none");
										});
									});
								</script>

								<div class="social-dropdown-menu" id="social-dropdown-menu">
									<ul>
										<li>
											<a href="#" onclick="fnTweetOnTwitter();" class="social social-twitter">Share on Twitter</a>
										</li>
										<!--<li>
											<a href="#" onclick="fnShareOnFb();" class="social social-facebook">Share on Facebook</a>
										</li>
										<li>
											<a href="#"   onclick="fnShareOnLinkedIn();"   class="social social-linkedin">Share on LinkedIn</a>
										</li>-->
										<li>
											<a href="#tell_a_friend" class="social social-email" data-toggle="modal" >Share by email</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

					<!--	<div class="job-details-bottom">
							<h3>Related Jobs</h3>
							<div class="bottom-jobs-container">
								<div class="related-job-container">
							
									<h4 class="heading-primary">
										<a href="#">
											Graphic Designer
										</a>
									</h4>
								
	        						<div class="result-icon favorite"><a href="#"></a></div>
        							<p class="related-job-subheader"><span>Full-time</span> - Calgary, CA - Experienced level - Salary: $50k - Posted 3 minutes ago</p>
								</div>
								<hr>
								<div class="related-job-container">
									<h4>
										<a href="#">
											Front-end Developer
										</a>
									</h4>
									<div class="result-icon"><a href="#"></a></div>
									<p class="related-job-subheader"><span>Full-time</span> - Calgary, CA - Experienced level - Salary: $50k - Posted 3 minutes ago</p>
								</div>
								<hr>
								<div class="related-job-container">
									<h4>
										<a href="#">
											Marketing Specialist
										</a>
									</h4>
									<div class="result-icon"><a href="#"></a></div>
									<p class="related-job-subheader"><span>Full-time</span> - Calgary, CA - Experienced level - Salary: $50k - Posted 3 minutes ago</p>
								</div>
							</div>
						</div>-->
					</div>

					<div class="col-md-3">
						<div class="buttons-container">
							<a class="btn btn-primary btn-large" href="<?php echo Router::url('/',true);?>/portal/applyJob/<?php echo $intPortalId;?>/<?php echo $intJobId;?>">Apply Now <span class="glyphicon glyphicon-chevron-right"></span></a><br>
							<button type="button" class="btn btn-default btn-large"><span class="glyphicon glyphicon-heart"></span> Save Job</button>
						</div><br>
						<div class="actions-link-container">
							<a href="#reminder-modal" class="link-options" data-toggle="modal">
								<span class="glyphicon glyphicon-plus"></span> Add Note &amp; Set Reminder
							</a>
						</div>
						<div class="job-details-info-block">
							<h3>Contact Information</h3>
						</div>
						
						<div class="job-search-options-container">
							
							<div class="job-details-description">
								<h4>Company name:</h4>
								<p><?php echo ($arrJobDetail['Job']['company_name']);?></p>
								<hr>
								<h4>Contact name:</h4>
								<p><?php echo ($arrJobDetail['Job']['contact_name']);?></p>
								<hr>
								<h4>Telephone Number:</h4>
								<p><?php echo ($arrJobDetail['Job']['contact_telephone']);?></p>
								<hr>
								<h4>Site Link:</h4>
								<p><a href="<?php echo ($arrJobDetail['Job']['site_link']);?>"><?php echo ($arrJobDetail['Job']['site_link']);?></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
	<script type="text/javascript">

	function fnShareOnFb()

	{

		var strFbLibBaseUrl = '<?php echo Router::url('/',true);?>portal/socailshare/<?php echo $intPortalId;?>/fb/<?php echo ($intJobId);?>';

		//alert(strFbLibBaseUrl);

		window.open(strFbLibBaseUrl,'Login','width=500,height=500');

	}

	

	function fnTweetOnTwitter()

	{
		var strTwillterLibBaseUrl = '<?php echo Router::url('/',true);?>portal/socailshare/<?php echo $intPortalId;?>/tw/<?php echo ($intJobId);?>';

		//	alert(strTwillterLibBaseUrl);

		//return false;
		window.open(strTwillterLibBaseUrl,'Login','width=500,height=500');

	}

	

	function fnShareOnLinkedIn()

	{

		var strLinkedInBaseUrl = '<?php echo Router::url('/',true);?>portal/socailshare/<?php echo $intPortalId;?>/li/<?php echo ($intJobId);?>';

		var link ='http://www.linkedin.com/shareArticle?mini=true&url='+strLinkedInBaseUrl;

		window.open(link,'sharer','width=500,height=500');
		

	}

function fnShowSetReminderForm()
{
	$('#postinterviewsetmessages').text('');
	$('#postinterviewsetmessages').hide();
	//$( "#dialog-set-interview-reminder-form" ).dialog( "open" );
	$("#dialog-set-interview-reminder-form").dialog().dialog("open");
}
function fnAddJobReminder()
{

	var isValidated = jQuery('#interviewreminderform').validationEngine('validate');
	
	if(isValidated == false)
		{
			return false;
		}
		else
		{
		
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var url = strBaseUrl+"portal/updateevent/<?php echo $intPortalId?>";
		var type = "POST";
		var options = { 
		//target:        '#output2',   // target element(s) to be updated with server response 
		success:	function(responseText, statusText, xhr, $form) {
			
			$('.cms-bgloader-mask').hide();//show loader mask
	 	    $('.cms-bgloader').hide(); //show loading image
			
				
					$('#alertjobmessage').html(responseText.message);
				
				$('#reminder-modal').modal('hide');
				
			},								
				 
			// other available options: 
			url:       url,         // override for form's 'action' attribute 
			type:      type,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		} 
			$('#interviewreminderform').ajaxSubmit(options); 
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}
}


$(document).ready(function () {

		

		/*$("#event_date_time").datepicker({ 

			dateFormat: 'yy-mm-dd' 

		});*/

		

		/*$('#event_date_time').datetimepicker({ 

			dateFormat: 'yy-mm-dd',

			stepMinute: 5

		});*/

		

		$('#event_date_time').datepicker({ 

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

							var url = strBaseUrl+"portal/updateevent/<?php echo $intPortalId?>";

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


			},


		});

	

	});
	
</script>




<div id="reminder-modal" class="modal fade" role="dialog">
		  	<div class="modal-dialog-reminder">
			    <div class="modal-content">
			    	<div class="modal-header">
			    		
						<button type="button" class="close" data-dismiss="modal">&times;</button>
			    		<h3>Set Interview Reminder</h3>

			    	</div>

				    <div class="modal-body">
				      	
				      	<form type="POST" enctype="multipart/form-data" id="interviewreminderform" name="interviewreminderform">
				      		<input type="hidden" name="event_type" id="event_type" value="Interview" />

						<input type="hidden" name="participant_type" id="participant_type" value="Candidate" />

						<input type="hidden" name="participant_id" id="participant_id" value="<?php echo $intCandidateId?>" />

						<input type="hidden" name="organization_type" id="organization_type" value="Portal" />

						<input type="hidden" name="organization_head_id" id="organization_head_id" value="<?php echo $intPortalId?>" />

						<input type="hidden" name="event_subject_type" id="event_subject_type" value="Job" />

						<input type="hidden" name="event_subject_id" id="event_subject_id" value="<?php echo $intJobId;?>" />
						
				      		<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-name">Interview Name:</label>

								<input class="col-xs-12 col-sm-12 col-md-6 validate[required]" type="text" name="event_name" id="event_name" Value="Interview Schedule">

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-description">Interview Description:</label>

								<textarea rows="5" class="col-xs-12 col-sm-12 col-md-6 validate[required]" type="text" name="event_dsec" id="event_dsec" value="">Your Interview for the post of <?php echo ($arrJobDetail['Job']['job_title']);?> with <?php echo ($arrJobDetail['Job']['company_name']);?></textarea>

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-date">Interview Date:</label>

								<input class="col-xs-12 col-sm-12 col-md-6" type="text" name="event_date_time" id="event_date_time" value="">

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-venue">Interview Venue:</label>

								<textarea rows="5" class="col-xs-12 col-sm-12 col-md-6" type="text" name="event_venue" id="event_venue" value=""></textarea>

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-contact-person">Interview Contact Person:</label>

								<input class="col-xs-12 col-sm-12 col-md-6" type="text" name="event_contact_name" id="event_contact_name" value="<?php echo ($arrJobDetail['Job']['contact_name']);?>">

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line" for="interview-reminder">Interview Reminder:</label>

								<div class="col-xs-12 col-sm-12 col-md-6">
									<select name="event_reminder" id="event_reminder" class="modal-select-small">
										<option value="1">Yes</option>

										<option value="0">No</option>
									</select>
								</div>

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-6 multy-line">Interview Reminder Frequency:</label>

								<div class="col-xs-12 col-sm-12 col-md-6">
									<p class="modal-paragraph">30 mins before the time</p>
								</div>

							</div>

							<div class="form-group">
								
								<div class="col-xs-12 col-sm-12 col-md-6">&nbsp;</div>

								<div class="col-xs-12 col-sm-12 col-md-6">
									<button type="button" class="btn btn-primary" onclick="return fnAddJobReminder();">Submit a Request</button>
								</div>

							</div>

				      	</form>

				    </div>
		    	</div>
		  	</div>
		</div>

		
		
<!--<div id="dialog-set-interview-reminder-form" title="Set Interview Reminder" style="display:none;">

	



	<form type="POST" enctype="multipart/form-data" id="interviewreminderform">

		<fieldset>

			<div id="postinterviewsetmessages" class="" style="width:100%;display:none;"></div>

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

						<input type="hidden" name="participant_id" id="participant_id" value="<?php echo $intCandidateId?>" />

						<input type="hidden" name="organization_type" id="organization_type" value="Portal" />

						<input type="hidden" name="organization_head_id" id="organization_head_id" value="<?php echo $intPortalId?>" />

						<input type="hidden" name="event_subject_type" id="event_subject_type" value="Job" />

						<input type="hidden" name="event_subject_id" id="event_subject_id" value="<?php echo $intJobId;?>" />

						

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

						<textarea name="event_dsec" id="event_dsec" class="text ui-widget-content ui-corner-all validate[required]">Your Interview for the post of <?php echo ($arrJobDetail['Job']['job_title']);?> with <?php echo ($arrJobDetail['Job']['company_name']);?></textarea>

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

						<input value="<?php echo ($arrJobDetail['Job']['contact_name']);?>" type="text" name="event_contact_name" id="event_contact_name" class="text ui-widget-content ui-corner-all validate[required]" />

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

						</select>

						<span id="eventremindererror" class="ui-state-error" style="display:none;"></span>

					</span>

				</div>	

			</div>			

		</fieldset>

	</form>

</div>-->



		<div id="tell_a_friend" class="modal fade" role="dialog">
		  	<div class="modal-dialog-share">
			    <div class="modal-content">
			    	<div class="modal-header">
			    		
						<button type="button" class="close" data-dismiss="modal">&times;</button>
			    		<h3>Share via Email</h3>

			    	</div>

				    <div class="modal-body">
				      	
				      	<form action="" method="post" name="share_form" enctype="multipart/form-data" id="share_form">
				      		
				      		<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-3 multy-line" for="send-this-job-to">Send this Job to:&nbsp;<span class="form-required">*</span></label>

								<div class="col-xs-12 col-sm-12 col-md-9">
									<input class="validate[required]" type="text" name="txt_send_to1" id="txt_send_to1" value="" required>
									 <input type="hidden" placeholder="" name="jobid"  value="<?php echo $intJobId;?>" class="">
									<span class="block-explanation">Enter the email address of the recipient. Multiple addresses need to be separated by commas.</span>
								</div>

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-3 multy-line" for="subject">Subject:&nbsp;<span class="form-required">*</span></label>

								<div class="col-xs-12 col-sm-12 col-md-9">
									<input class="validate[required]" type="text" name="txt_subject" id="txt_subject" value="" required>
									<span class="block-explanation">Please choose an appropriate subject for the email, or leave blank and a default one will be used.</span>
								</div>

							</div>

							<div class="form-group">
								
								<label class="control-label col-xs-12 col-sm-12 col-md-3 multy-line" for="comments">Comments:&nbsp;<span class="form-required">*</span></label>

								<textarea rows="5" class="col-xs-12 col-sm-12 col-md-9 validate[required]" type="text" name="txt_comments" id="txt_comments" value="" required></textarea>

							</div>

							<div class="form-group">
								
								<div class="col-xs-12 col-sm-12 col-md-3">&nbsp;</div>

								<div class="col-xs-12 col-sm-12 col-md-9">
									<button type="button" class="btn btn-primary" onclick="return sharewithfriend(<?php echo $intPortalId;?>);">Submit a Request</button>
								</div>

							</div>

				      	</form>

				    </div>
		    	</div>
		  	</div>
		</div>

