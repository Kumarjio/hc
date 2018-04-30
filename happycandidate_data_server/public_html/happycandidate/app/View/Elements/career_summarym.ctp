<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-3-career-summary flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">1</span><!-- 

							--><span class="resume-builder-step-title"><s>Experience &amp; Level</s></span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">2</span><!-- 

						--><span class="resume-builder-step-title"><s>Contact Information</s></span>

								

						</li>



						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getCareerSum('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">3</span><!-- 

						 --><span class="resume-builder-step-title">Career Summary</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">4</span><!-- 

						 --><span class="resume-builder-step-title">Core Competencies</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">5</span><!-- 

						 --><span class="resume-builder-step-title">Education</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">6</span><!-- 

						 --><span class="resume-builder-step-title">Professional Experience</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">8</span><!-- 

						 --><span class="resume-builder-step-title">Awards</span>

								

						</li>

						
						<li class="resume-builder-step">



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



					<h1>Career Summary</h1>

						

					<form name="frmcarsumm" id="frmcarsumm" method="post">

							
						<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
						<div class="form-group">

								

							<label class="control-label" for="description">Description:</label>

							<textarea class="builder-textarea" name="career_summary" rows="4"><?php echo $Career_Summary;?></textarea>

						

						</div>



						<div class="form-group">

							<button class="btn btn-default btn-responsive btn-lg" type="button" onclick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');" >&lt;&nbsp;Prev</button>

							<button class="btn btn-primary btn-responsive btn-lg" type="button" onclick="return saveCareerSummary('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							
							<a href="#" onclick="return saveCareerSummary('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						The Career Summary section of a CV or resume has replaced the Job Objective. Titles vary greatly and a summary of your expertise and skills provides you with a better chance of being screened in by the automated screening systems and hiring authorities.

					</p>



					<h2>Tips</h2>



					<ul>

						<li>

							Utilize keywords as often as possible. These are keywords and unique key phrases that would appear in job descriptions you would target.

						</li>

						<li>

							Quantify your expertise whenever possible

						</li>

						<li>

							Consider all jobs i.e. part time, internships, summer jobs, volunteerism

						</li>

						<li>

							Include desirable soft skills i.e. strong verbal and written communication skills

						</li>

						<li>

							List main areas of responsibility vs. listing specific job titles

						</li>

						<li>

							Examples of phrases to start sentences in<br>

							Career Summary could include:

							<ul class="inside-list">

								<li>

									a. Innovative and Driven (insert job title) handling ________

								</li>

								<li>

									b. Proficient in _______

								</li>

								<li>

									c. Skilled _________ with

								</li>

								<li>

									d. Adept at _________

								</li>

							</ul>

						</li>

					</ul>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onclick="return saveCareerSummary('<?php echo $intPortalId?>','1');">

							<span class="builder-save-icon"></span><!-- 

						 --><span class="action-value">Save &amp; Quit</span>

						</a>



					</div>



				</div>

			</div>

		</div>

	</div>
<?php
	echo $this->element('font_modal');
	
?>