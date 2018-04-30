<?php
	if(is_array($arrMessage) && (count($arrMessage)>0))
	{
		if($arrMessage['status'] == "success")
		{
			$strStyle = "";
			$strMessage = $arrMessage['mssg'];
		}
		else
		{
			$strStyle = "style='display:none;'";
		}
	}
	else
	{
		$strStyle = "style='display:none;'";
	}
?>
<div <?php echo $strStyle; ?> id="alertcvMessage"><div class="alert alert-success">
  <img src="<?php echo Router::url('/',true);?>images/icon-alert-success.png" alt="image description">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	<?php echo $strMessage; ?>
</div></div>
<div class="page-content-wrapper employers-type">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12" style="min-height: 500px;">
				<h1>Add a Job</h1>
				<div class="tab-row-container">
								<div class="col-lg-12 emp-content-container">
									<div id="job-information-panel-slider" class="panel-slider emp-dashboard-jobs-slider emp-dashboard-jobs-slider-v2">
										<a href="#job-information" class="panel-slider-item" data-toggle="collapse" data-parent="#personal-info-panel-slider">
											<div class="panel-slider-item-header">
												<h3>Job Information</h3>
												<span class="icon-indicator"></span>
											</div>
										</a>
							
										<div class="collapse in" id="job-information" data-parent="#job-information-panel-slider">
											<div class="col-md-12 form-container">
												<form method="post" id="addjobform">

													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="job-title">Contact Name: </label>
														<input class="emp-dashboard-jobs-input" type="text" name="contact_name" id="contact_name" value="">
													</div>
		
													<div class="form-group ">
														<label class="emp-dashboard-jobs-label" for="job-description">Contact Telephone #:</label>
														<div class="emp-dashboard-jobs-tel-container">
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-tel-fix validate[custom[phone]]" type="text" name="contact_phone" id="contact_phone" value="">
														</div>
														
													</div>
													<div class="form-group ">
														<label class="emp-dashboard-jobs-label" for="job-description">Email Address: </label>
														<input class="emp-dashboard-jobs-input validate[custom[email]]" type="text" name="contact_email" id="contact_email" value="">
													</div>
													
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="first-name">Reference Code:</label>
														<div class="emp-dashboard-jobs-tel-container">
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-tel-fix" type="text" name="job_referrence_code" id="job_referrence_code" value="">
														</div>
													</div>
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="job-title">Job Title: <span class="form-required">*</span></label>
														<input class="emp-dashboard-jobs-input validate[required]" type="text" name="job-title" id="job-title" value="" data-prompt-position="topRight:-100" >
													</div>
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="job-title">Job Description: <span class="form-required">*</span> <br><span class="form-subtext">0 of 1000</span></label>
														<textarea cols="49" rows="6" name="job_desc" class="emp-dashboard-jobs-input emp-dashboard-jobs-input-fix validate[required,maxSize[1000]]" id="job_desc" data-prompt-position="topRight:-100" ></textarea>
													</div>
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="job-title">Job Minimum Requirements: <span class="form-required">*</span> <br><span class="form-subtext">0 of 1000</span></label>
														<textarea cols="49" rows="6" name="min_req" class="emp-dashboard-jobs-input emp-dashboard-jobs-input-fix validate[required,maxSize[1000]]" id="min_req" data-prompt-position="topRight:-100" ></textarea>
													</div>
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="first-name">Number of Positions Available:</label>
														<div class="emp-dashboard-jobs-tel-container">
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-number-fix" type="text" name="job_pos" id="job_pos" value="">
														</div>
													</div>
													<div class="form-group">
														<label class="emp-dashboard-jobs-label" for="job-title">Target Start Date:</label>
														<input class="emp-dashboard-jobs-input" type="text" name="job_start_date" id="job_start_date" value="">
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Job Type: <span class="form-required">*</span></label>
														<select class="double-extra-small validate[required]" name="job_type"><option value="1">Full-time</option><option value="2">Part-time</option><option value="3">Per Day</option></select>	
														
														<!--<div class="checkbox-group ">
															<div class="checkbox-container">
																<input type="checkbox" value="" >
																<p>Full-time</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" value="" checked>
																<p>Part-time</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" value="">
																<p>Per Day</p>
															</div>
														</div>-->
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Job Status: </label>
														<div class="checkbox-group">
															<div class="checkbox-container">
																<input type="checkbox" name="direct_job">
																<p>Direct</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="contract_job" checked>
																<p>Contract</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="seasonal_job">
																<p>Seasonal</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="temporary_job">
																<p>Temporary</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="project_job">
																<p>Project</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="internship_job">
																<p>Internship</p>
															</div>
														</div>
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label" for="first-name">Salary Range:</label>
														<div class="emp-dashboard-jobs-tel-container">
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-range-fix" type="text" name="job_salary" id="job_salary" value="" placeholder="e.g. 25000-35000, 8.5, 300, 3k-5k">
															<select name="sal_unit" id="sal_unit" class="double-extra-small" title="Year">
																<option  value="Annually">Annually</option>
																<option value="Hourly">Hourly</option>
																<option value="Daily">Daily</option>
															</select>
														</div>
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Education:</label>
														<div class="checkbox-group">
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="9">
																<p>Doctoral of professional degree</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="10">
																<p>Master’s degree</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="11" checked>
																<p>Bachelor’s degree</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="12">
																<p>Associate’s degree</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="14">
																<p>Some college - no degree</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="15">
																<p>High school diploma of equivalent</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="education[]" value="16">
																<p>Less than high school</p>
															</div>
														</div>
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Experience:</label>
														<div class="checkbox-group">
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" value="7">
																<p>Senior Executive (Chairman, MD, CEO)</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" value="6">
																<p>Executive (Director, Department Head)</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" checked value="5">
																<p>Manager (Manager, Supervisor of Staff)</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" value="4">
																<p>Experienced (Non-Manager)</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" value="3">
																<p>Entry Level</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp[]" value="2">
																<p>Student</p>
															</div>
														</div>
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Year of Experience:</label>
														<div class="checkbox-group">
															<div class="checkbox-container">
																<input type="checkbox"  name="exp_yr[]" value="9">
																<p>5 years or more</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp_yr[]" value="10">
																<p>3 - 4 years</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp_yr[]" checked value="11">
																<p>1 - 2 years</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp_yr[]" value="12">
																<p>Less than 1 year</p>
															</div>
															<div class="checkbox-container">
																<input type="checkbox" name="exp_yr[]" value="13">
																<p>None</p>
															</div>
														</div>
													</div>
													<div class="form-group emp-form-group">
														<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Job Location: </label>
														<div class="emp-dashboard-jobs-tel-container">
															<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Postal Code:</label>
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-postal-code" type="text" name="job_pin" id="job_pin" value="">
														</div>
														<div class="emp-dashboard-jobs-tel-container">
															<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">Country:</label>
															<select class="emp-dashboard-jobs-select" name="country" id="country">
																<option value="">Please select one</option>
																<?php
																	foreach($arrJcountry as $arrCountKey => $arrCountVal)
																	{
																		?>
																			<option value="<?php echo $arrCountKey; ?>"><?php echo $arrCountVal; ?></option>
																		<?php
																	}
																?>
															</select>
														</div>
														<div class="emp-dashboard-jobs-tel-container">
															<label class="emp-dashboard-jobs-label emp-dashboard-jobs-label-checkbox" for="job-title">State / Province / Region:</label>
															<input class="emp-dashboard-jobs-input emp-dashboard-jobs-input-postal-code" type="text" name="job_state" id="job_state" value="">
														</div>
													</div>
													<button type="submit" class="btn btn-primary btn-emp-dashboard-jobs-v2" onclick="return fnCheckJobPost()">Post Job</button>
													<button type="button" class="btn btn-default btn-emp-dashboard-jobs-v2">Cancel</button>
												</form>
											</div>

										</div>
									</div>

									<!--<div id="contact-info-panel-slider" class="panel-slider emp-dashboard-jobs-slider  emp-dashboard-jobs-slider-v2">
										<a href="#contact-info" class="panel-slider-item" data-toggle="collapse" data-parent="#contact-info-panel-slider">
											<div class="panel-slider-item-header">
												<h3>Contact Information</h3>
												<span class="icon-indicator"></span>
											</div>
										</a>
							
										<div class="collapse" id="contact-info" data-parent="#contact-info-panel-slider">
											<div class="col-md-12 form-container">
												<form>

													
												</form>
											</div>

										</div>
									</div>
									<button type="submit" class="btn btn-primary btn-emp-dashboard-jobs-v2" onclick="fnCheckJobPost()">Post Job</button>
									<button type="button" class="btn btn-default btn-emp-dashboard-jobs-v2">Cancel</button>
			
								</div>-->	

							</div>
				
				
			</div>
		</div>
	</div>
	</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.leftnavi').removeClass('active');
		$('#jobnavi').addClass('active');
	});
	
	function fnCheckJobPost()
	{
		var isValidated = $('#addjobform').validationEngine('validate');
		if(isValidated == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
</script>

<!--<div class="users index container-layout">

	<div id="page-title">
		<h3>Portal Jobs</h3>
		</div>

		<iframe style="width:100%;height:1000px; border:none" src="<?php echo $strPostJobIndexUrl;?>" ></iframe>

</div>-->
<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Post Jobs', array('action' => 'add',$portal_id)); ?></li>
	</ul>
</div>-->