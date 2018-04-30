<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-10-general-information flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							

						<li class="resume-builder-step" onclick="return getContactInfof('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">1</span><!-- 

										 --><span class="resume-builder-step-title"><s>Contact Information</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getCareerSumf('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">2</span><!-- 

										 --><span class="resume-builder-step-title"><s>Career Summary</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getCoreCompentsf('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">3</span><!-- 

										 --><span class="resume-builder-step-title"><s>Core Competencies</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getMyEducationF('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">4</span><!-- 

										 --><span class="resume-builder-step-title"><s>Summary Of Skills</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getWokExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">5</span><!-- 

										 --><span class="resume-builder-step-title"><s>Work Experience</s></span>

												

										</li>
										
										<li class="resume-builder-step" onclick="return getFEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">6</span><!-- 

										 --><span class="resume-builder-step-title"><s>Education</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getProfDev('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">7</span><!-- 

										 --><span class="resume-builder-step-title"><s>Professional Development</s></span>

												

										</li>

										<li class="resume-builder-step-current" >



											<span class="resume-builder-step-icon">8</span><!-- 

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



					<h1>CV or Resume Title</h1>

					<p>Naming your CV or resume will help you locate the correct version of this document quickly.</p>	

					<form name="frmResumeTitle" id="frmResumeTitle" method="post">

							

						<div class="form-group">

								
						<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>
							<label class="control-label" for="resume-title">Resume title:</label>

							<input class="resume-builder-input validate[required]" type="text" name="resume_title" id="resume_title" value="<?php echo $resume_title; ?>" placeholder="">

						

						</div>



						<div class="form-group">

							<button class="btn btn-default btn-responsive btn-lg" onClick="return getProfDev('<?php echo $intPortalId?>','<?php echo $resumeid;?>');" type="button">&lt;&nbsp;Prev</button>

							<button class="btn btn-primary btn-responsive btn-lg" onClick="return saveResumeTitlef('<?php echo $intPortalId?>');" type="button">Save &amp; Continue&nbsp;&gt;</button>

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						Resume title helps to find necessary resume quickly. It can be useful when you have a large list of saved documents.

					</p>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onClick="return saveResumeTitlef('<?php echo $intPortalId?>');">

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
	