<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-4-core-competencies flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">1</span><!-- 

							--><span class="resume-builder-step-title"><s>Experience &amp; Level</s></span>

								

						</li>



						<li class="resume-builder-step"  style="cursor:pointer;" onclick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">2</span><!-- 

						--><span class="resume-builder-step-title"><s>Contact Information</s></span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCareerSum('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">3</span><!-- 

						 --><span class="resume-builder-step-title"><s>Career Summary</s></span>

								

						</li>



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Core Competencies</h1>
					<p>Please enter in your core competencies by keyword separated by a comma.</p>
					
						

					<form name="frmKeywords" id="frmKeywords" method="post">

							
						<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
						<div class="form-group">

								

							<label class="control-label" for="description">Keywords:</label>

							<textarea class="builder-textarea" name="keywords" rows="4"><?php echo $keywords;?></textarea>
							
						

						</div>

						<p style="margin-top:15px;"><i>Example:</i></p>
						<p style="margin-top:15px;"><i>Sales, Sales Management, Prospecting, Cold Calling, Presentation Skills</i></p>

						<div class="form-group">

							<button class="btn btn-default btn-responsive btn-lg" type="button" onclick="return getCareerSum('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>

							<button class="btn btn-primary btn-responsive btn-lg" type="button" onclick="return saveCoreCompents('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							
							<a href="#" onclick="return saveCoreCompents('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>

						</div>



					</form>
					
					

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						The Core Competencies section of a resume should include 12-15 keywords following the Career Summary that identify core skills. This section should be keyword rich to cause your CV or Resume to be screened in by automated programs.

					</p>



					<h2>Tips</h2>



					<ul>

						<li>

							Utilize keywords most desirable by your targeted employers

						</li>

						<li>

							Use bullets when listing the core competencies

						</li>

						<li>

							Core competencies vary greatly from one profession to another. Examples:

						

							<ul class="inside-list">

								<li>

									a. Communication Skills – written

								</li>

								<li>

									b. Communication Skills - verbal

								</li>

								<li>

									c. Customer Service

								</li>

								<li>

									d. Problem Solver

								</li>

								<li>

									e. Team Leadership

								</li>

								<li>

									f. Tracking &amp; Reporting

								</li>

							</ul>

						</li>

					</ul>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onclick="return saveCoreCompents('<?php echo $intPortalId?>','1');">

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
	