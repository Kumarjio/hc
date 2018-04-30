<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-2-contact-info flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">1</span><!-- 

							--><span class="resume-builder-step-title"><s>Experience &amp; Level</s></span>

								

						</li>



						<li class="resume-builder-step-current"  style="cursor:pointer;" onclick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">2</span><!-- 

						--><span class="resume-builder-step-title">Contact Information</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCareerSum('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">3</span><!-- 

						 --><span class="resume-builder-step-title">Career Summary</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">4</span><!-- 

						 --><span class="resume-builder-step-title">Core Competencies</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">5</span><!-- 

						 --><span class="resume-builder-step-title">Education</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">6</span><!-- 

						 --><span class="resume-builder-step-title">Professional Experience</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyAffiliates('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">7</span><!-- 

						 --><span class="resume-builder-step-title">Professional Affiliations</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">8</span><!-- 

						 --><span class="resume-builder-step-title">Awards</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCommunityInvolve('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">9</span><!-- 

						 --><span class="resume-builder-step-title">Community Involvement</span>

								

						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;">



							<span class="resume-builder-step-icon">10</span><!-- 

						 --><span class="resume-builder-step-title">CV or Resume Title</span>

								

						</li>

					</ul>



					<div class="adv-container">

							

						<?php
							$strSeekerId = $seekerid;
						?>
							

						<a href="javascript:void(0);" onclick="fnGetResumeView('<?php echo $intPortalId?>','<?php echo $strSeekerId?>');">

							<h3>View CV or resume</h3>

							<p>In Progress</p>



							<img src="<?php echo Router::url('/',true);?>images/resume-builder-icon.png" alt="image description">



							<span class="ad-hover"></span>

						</a>



					</div>



				</div><!-- 



			 --><div class="content-step">



					<h1>Contact Information</h1>

						<?php 
						if(count($contactinfo)>0)
						{
							if($contactinfo['Candidate_Cv']['firstName'])
							{
								$fname = $contactinfo['Candidate_Cv']['firstName'];
							}
							else
							{
								$fname = $arrCandidateDetail[0]['CandidateProfile']['fname'];
							}
							
							$middle = $contactinfo['Candidate_Cv']['middle_initial'];
							if($contactinfo['Candidate_Cv']['lastName'])
							{
								$lName = $contactinfo['Candidate_Cv']['lastName'];
							}
							else
							{
								$lName = $arrCandidateDetail[0]['CandidateProfile']['sname'];
							}
							
							$streetAddress = $contactinfo['Candidate_Cv']['streetAddress'];
							if($contactinfo['Candidate_Cv']['city'])
							{
								$city = $contactinfo['Candidate_Cv']['city'];
							}
							else
							{
								$city = $arrCandidateDetail[0]['CandidateProfile']['city'];
							}
							if($contactinfo['Candidate_Cv']['country'])
							{
								$countryNew = $country = $contactinfo['Candidate_Cv']['country'];
							}
							else
							{
								$countryNew = $country = $arrCandidateDetail[0]['CandidateProfile']['country'];
							}
							
							if($contactinfo['Candidate_Cv']['zipCode'])
							{
								$zipCode = $contactinfo['Candidate_Cv']['zipCode'];
							}
							else
							{
								$zipCode = $arrCandidateDetail[0]['CandidateProfile']['post_code'];
							}
							
							$homePhone = $contactinfo['Candidate_Cv']['homePhone'];
							$cellPhone = $contactinfo['Candidate_Cv']['cellPhone'];
							if($contactinfo['Candidate_Cv']['email_address'])
							{
								$email_address = $contactinfo['Candidate_Cv']['email_address'];
							}
							else
							{
								$email_address = $arrCandidateDetail[0]['CandidateProfile']['email_address'];
							}
							
							
							if($contactinfo['Candidate_Cv']['state'])
							{
								$state = $contactinfo['Candidate_Cv']['state'];
							}
							else
							{
								$state = $arrCandidateDetail[0]['CandidateProfile']['state_province'];
							}
							
							
						}
						else
						{
						  $fname = $arrCandidateDetail[0]['CandidateProfile']['fname'];
						  $lName =  $arrCandidateDetail[0]['CandidateProfile']['sname'];
						  $middle ="";
						  $city= $arrCandidateDetail[0]['CandidateProfile']['city'];
						  $country = $arrCandidateDetail[0]['CandidateProfile']['country'];
						  $email_address = $arrCandidateDetail[0]['CandidateProfile']['email_address'];
						  $streetAddress =  $arrCandidateDetail[0]['CandidateProfile']['address'];
						}
						?>

					<form name="contactform" id="contactform" method="post" >

							

						<div class="form-group">

								

							<label class="control-label" for="name">First Name:</label>

							<input class="resume-builder-input validate[required,custom[onlyLetterSp]]" type="text" name="firstName" id="firstName" value="<?php echo $fname;?>" placeholder="">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="middle-initial">Middle Initial:</label>

							<input class="resume-builder-input" type="text" name="middle_initial" id="middle_initial" value="<?php echo $middle;?>" placeholder="">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="last-name">Last Name:</label>

							<input class="resume-builder-input validate[required,custom[onlyLetterSp]]" type="text" name="lastName" id="lastName" value="<?php echo $lName;?>" placeholder="">

							<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>

						</div>



						<div class="form-group">

								

							<label class="control-label" for="street-address">Street Address:</label>

							<input class="resume-builder-input validate[required]" type="text" name="streetAddress" id="streetAddress" value="<?php echo $streetAddress;?>" placeholder="">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="city">City:</label>

							<input class="resume-builder-input validate[required]" type="text" name="city" id="city" value="<?php echo $city;?>" placeholder="">

						

						</div>



						


									<div class="form-group">
											<label class="control-label" for="Country">Country:</label>
										  <select name="country" id="country" class="form-control resume-builder-select validate[required]">
										  <?php
									
											foreach($countrylist as $countryid=>$country)
											{
											 $cntname = $country;
											 $id = $countryid;
											?>
											<option value="<?php echo $id;?>"><?php echo $cntname;?></option>
											<?php
											}
											?>
										</select>
										</div>
										
						<div class="form-group">
							<label class="control-label" for="Country">State:</label>
							<input class="resume-builder-input validate[required]" type="text" name="state" id="state" value="<?php echo $state;?>" placeholder="">
						</div>


						<div class="form-group">

								

							<label class="control-label" for="zip-code">Postal or Zip Code:</label>

							<input class="resume-builder-input validate[required]" type="text" name="zipCode" id="zipCode" value="<?php echo $zipCode;?>" placeholder="">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="home-phone">Home Phone:</label>

							<input class="resume-builder-input validate[custom[phone]]" type="text" name="homePhone" id="homePhone" value="<?php echo $homePhone;?>" placeholder="123.456.789">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="cell-phone">Cell Phone:</label>

							<input class="resume-builder-input validate[custom[phone]]" type="text" name="cellPhone" id="cellPhone" value="<?php echo $cellPhone;?>" placeholder="">

						

						</div>



						<div class="form-group">

								

							<label class="control-label" for="email-address">Email Address:</label>

							<input class="resume-builder-input validate[required,custom[email]]" type="text" name="email_address" id="email_address" value="<?php echo $email_address;?>" placeholder="">

						

						</div>



						<div class="form-group">

							<button class="btn btn-default btn-responsive btn-lg" type="button" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');"  >&lt;&nbsp;Prev</button>

							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveContact('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							
							<!--<a href="#" onClick="return saveContact('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>-->

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						Let Employers know how to reach you. List your mailing address, home and cell phone and email address.

					</p>



					<h2>Tips</h2>



					<ul>

						<li>

							This section appears below your name for easy access by hiring authorities

						</li>

						<li>

							Make sure your email address is professional. First initial then last name is an easy option. Example  jsmith@gmail.com

						</li>

						<li>

							Do not use your academic email address. If you are using an AOL, Hotmail or Yahoo email address, you might need a new email address. This can be interpreted that you are not tech savvy.

						</li>

						<li>

							You can obtain a free Gmail account by going to Google’s site.

						</li>

						<li>

							Use your personal email address and phone number rather than your work contact information. You do not want to jeopardize your current job.

						</li>

					</ul>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onClick="return saveContact('<?php echo $intPortalId?>','1');">

							<span class="builder-save-icon"></span><!-- 

						 --><span class="action-value">Save &amp; Quit</span>

						</a>



					</div>



				</div>

			</div>

		</div>

	</div>
<?php
	//echo "rajendra";
	echo $this->element('font_modal');
	
?>
<script type="text/javascript">
$('#country').val('<?php echo $countryNew;?>');
$('#country option[value=CA]').insertBefore('#country option:first-child');
$('#country option[value=US]').insertBefore('#country option:first-child');
</script>
