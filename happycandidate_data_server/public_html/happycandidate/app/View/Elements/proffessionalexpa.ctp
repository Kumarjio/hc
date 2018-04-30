<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-6-professional-experience flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">1</span><!-- 
							--><span class="resume-builder-step-title"><s>Experience &amp; Level</s></span>
						</li>
						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">2</span><!-- 
						--><span class="resume-builder-step-title"><s>Contact Information</s></span>
						</li>
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">3</span><!-- 
						 --><span class="resume-builder-step-title"><s>Education</s></span>
						</li>

						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">4</span><!-- 
						 --><span class="resume-builder-step-title">Professional Experience</span>
						</li>

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyPublications('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">5</span><!-- 
						 --><span class="resume-builder-step-title">Publications</span>
						</li>

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">6</span><!-- 
						 --><span class="resume-builder-step-title">Awards</span>
						</li>


						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyGrants('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">7</span><!-- 
						 --><span class="resume-builder-step-title">Grants and Fellowships</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyInvites('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">8</span><!-- 
						 --><span class="resume-builder-step-title">Invited Talks</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyConference('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">9</span><!-- 
						 --><span class="resume-builder-step-title">Conference Participation</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyCampus('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">10</span><!-- 
						 --><span class="resume-builder-step-title">Campus or Depart...</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyTeaching('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">11</span><!-- 
						 --><span class="resume-builder-step-title">Teaching Experience</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyResearch('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">12</span><!-- 
						 --><span class="resume-builder-step-title">Research Experience</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">13</span><!-- 
						 --><span class="resume-builder-step-title">Service to Profession</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyUniService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">14</span><!-- 
						 --><span class="resume-builder-step-title">Department/Uni...</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyLang('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">15</span><!-- 
						 --><span class="resume-builder-step-title">Languages</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyPrffAffA('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">16</span><!-- 
						 --><span class="resume-builder-step-title">Professional Affiliations</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyExtra('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">17</span><!-- 
						 --><span class="resume-builder-step-title">Extracurricular Service</span>
						</li>
						
						<li class="resume-builder-step">
							<span class="resume-builder-step-icon">18</span><!-- 
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



					<h1>Professional Appointments/Employment</h1>
					<form name="frmprofexp" id="frmprofexp" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>

					<?php
						
					$company = '';
					$candidate_cv_id=0;
					$state='';
					$city='';
					$fromDate='';
					$toDate='';
					$description='';
					$jobTitle='';
					$candidate_prof_exp_id=0;
					$intFrCnt = 0;
					//print("<pre>");
					//print_r($proffsionalexp);
					//exit;
					if(count($proffsionalexp)>0)
					{
						foreach($proffsionalexp as $arrEdu)
						{
							$candidate_prof_exp_id = $arrEdu['Candidate_prof_exp']['candidate_prof_exp_id'];
							$candidate_cv_id = $arrEdu['Candidate_prof_exp']['candidate_cv_id'];
							$company = $arrEdu['Candidate_prof_exp']['company'];
							$city = $arrEdu['Candidate_prof_exp']['city'];
							$state = $arrEdu['Candidate_prof_exp']['state'];
							$jobTitle = $arrEdu['Candidate_prof_exp']['jobTitle'];
							$fromDate = $arrEdu['Candidate_prof_exp']['fromDate'];
							$toDate = $arrEdu['Candidate_prof_exp']['toDate'];
							$description = $arrEdu['Candidate_prof_exp']['description'];
							$fromYear = $arrEdu['Candidate_prof_exp']['fromyear'];
							$intFrCnt++;
							?>
								<div id="proffexpe<?php echo $intFrCnt; ?>">
									<div class="form-group">
										<input type="hidden" name="prof_exp_id<?php echo $intFrCnt; ?>" id="prof_exp_id<?php echo $intFrCnt; ?>" value="<?php echo $candidate_prof_exp_id;?>"/>	
										<label class="control-label" for="company-name">Inistitution / Department:</label>
										<input class="resume-builder-input" type="text" name="company<?php echo $intFrCnt; ?>" id="company<?php echo $intFrCnt; ?>" value="<?php echo $company;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="job-title">Title:</label>
										<input class="resume-builder-input" type="text" name="jobTitle<?php echo $intFrCnt; ?>" id="jobTitle<?php echo $intFrCnt; ?>" value="<?php echo $jobTitle;?>" placeholder="">
									</div>
									<div class="form-group">
										<label>Year of Employment:</label>
										<select class="resume-builder-input validate[required]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
											<?php 
												echo $this->element('dateoptions');
											?>
										</select>
									</div>
									<script type="text/javascript">
										$(document).ready( function () {
											$('#dateyear'+<?php echo $intFrCnt; ?>).val('<?php echo $fromYear; ?>');
										});
									</script>
								</div>
							<?php
							
						}
					}
					else
					{
						$intFrCnt++;
						?>
							<div id="proffexpe<?php echo $intFrCnt; ?>">
								<div class="form-group">
									<label class="control-label" for="company-name">Inistitution / Department:</label>
									<input class="resume-builder-input" type="text" name="company<?php echo $intFrCnt; ?>" id="company<?php echo $intFrCnt; ?>" value="<?php echo $company;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="job-title">Title:</label>
									<input class="resume-builder-input" type="text" name="jobTitle<?php echo $intFrCnt; ?>" id="jobTitle<?php echo $intFrCnt; ?>" value="<?php echo $jobTitle;?>" placeholder="">
								</div>
								<div class="form-group">
									<label>Year of Employment:</label>
									<select class="resume-builder-input validate[required]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
										<?php 
											echo $this->element('dateoptions');
										?>
									</select>
								</div>
								<script type="text/javascript">
									$(document).ready( function () {
										$('#dateyear'+<?php echo $intFrCnt; ?>).val('<?php echo $fromYear; ?>');
									});
								</script>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="pexp_count" id="pexp_count" value="<?php echo $intFrCnt; ?>" />
					<div id="pexp"></div>
					<div class="form-group add-new-block">
							<button type="button" class="btn btn-access btn-sm" onclick="fnAddProfExperience()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New</button>
							
							<?php
								if($intFrCnt <= 1)
								{
									$strRemoveStyle = "style='display:none;'";
								}
							?>
							<button type="button" <?php echo $strRemoveStyle; ?> id="btnremove" class="btn btn-default btn-sm" onclick="fnRemoveProfExperience()"><span class="glyphicon glyphicon-minus"></span>&nbsp;Remove</button>
						</div>
					<div class="form-group">
						<button class="btn btn-default btn-responsive btn-lg" type="button"  onClick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>

						<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveProfExp('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
						
						<a href="#" onClick="return saveProfExp('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
					</div>
					</form>
				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						Professional Experience should outline all work experience, including part time, internships, summer jobs and volunteer jobs. You will list the name of your employer followed by city and state. The second line should list your title on the left hand side, under the employer name with the dates of employment on the same line over to the right hand side.

					</p>



					<p>

						Summarize your experience in one paragraph, preferably with no more than five or six sentences.  This section should not read like a job description. After experience paragraph, list bulleted accomplishments that also state the impact of each accomplishment. To determine your accomplishments, think of how you did your job better or faster than the person who did your job before you.

					</p>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onClick="return saveProfExp('<?php echo $intPortalId?>','1');">

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
<?php
$strHtml = $this->element('dateoptionsnew');
?>
<script type="text/javascript">
	function fnRemoveProfExperience()
	{
		var intEdCount = $('#pexp_count').val();
		$('#proffexpe'+intEdCount).remove();
		intEdCount--;
		$('#pexp_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddProfExperience() 
	{
		var intEdCount = $('#pexp_count').val();
		intEdCount++;
		var dateopt = '<?php echo $strHtml; ?>';
		
		/*var strEduRows = '<div id="education'+intEdCount+'"><div class="form-group"><label class="control-label" for="degree">Degree or Certification Earned:</label><input class="resume-builder-input" type="text" name="degree'+intEdCount+'" id="degree'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="institution">Name of Institution:</label><input class="resume-builder-input" type="text" name="institution'+intEdCount+'" id="institution'+intEdCount+'" value="" placeholder=""></div><div class="half-container"><label>Completion Year:</label><div class="datetime-container"><div class="input-group date control-label" id="datetimepicker1'+intEdCount+'"><input type="text" class="form-control" name="date-start<?php echo $intFrCnt;?>" id="date-start<?php echo $intFrCnt;?>" placeholder="10/17/2015" value="<?php echo $fromDate;?>" required><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div>';*/
		
		var strEduRows  = '<div id="proffexpe'+intEdCount+'"><div class="form-group"><label class="control-label" for="company-name">Inistitution / Department:</label><input class="resume-builder-input" type="text" name="company'+intEdCount+'" id="company'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="job-title">Title:</label><input class="resume-builder-input" type="text" name="jobTitle'+intEdCount+'" id="jobTitle'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Year of Employment:</label><select class="resume-builder-input validate[required]" name="dateyear'+intEdCount+'" id="dateyear'+intEdCount+'"><option value="">--Select Year--</option>'+dateopt+'<option value="2099">Present Year</option></select></div></div>';
		
		
		$('#pexp').append(strEduRows);
		$('#pexp_count').val(intEdCount);
	
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>