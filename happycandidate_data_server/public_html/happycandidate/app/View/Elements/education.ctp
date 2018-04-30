
	<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-5-education flex-fix">

					

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



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">4</span><!-- 

						 --><span class="resume-builder-step-title"><s>Core Competencies</s></span>

								

						</li>



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Education</h1>

					<form name="frmeducation" id="frmeducation" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>
					<?php
					$degree='';
					$institution='';
					$city='';
					$tution_percentage='';
					$education_id=0;
					$intFrCnt = 0;
					if(count($candidateEducation)>0)
					{
					   foreach($candidateEducation as $arrEdu)
					   {
						   $education_id = $arrEdu['Candidate_Education']['candidate_education_id'];
						   $degree = $arrEdu['Candidate_Education']['degree'];
						   $institution = $arrEdu['Candidate_Education']['institution'];
						   $city = $arrEdu['Candidate_Education']['city'];
						   $state = $arrEdu['Candidate_Education']['state'];
						   $tution_percentage = $arrEdu['Candidate_Education']['tution_percentage'];
						    $intFrCnt++;
						   ?>
							<div class="form-group">
								<label class="control-label" for="institution">Name of Institution:</label>
								<input class="resume-builder-input" type="text" name="institution<?php echo $intFrCnt;?>" id="institution<?php echo $intFrCnt;?>" value="<?php echo $institution;?>" placeholder="">
							</div>
							<div id="education<?php echo $intFrCnt;?>"><div class="form-group">
								<input type="hidden" name="education_id<?php echo $intFrCnt;?>" id="education_id<?php echo $intFrCnt;?>" value="<?php echo $education_id;?>"/>	
								<label class="control-label" for="degree">Degree or Certification Earned:</label>
								<input class="resume-builder-input" type="text" name="degree<?php echo $intFrCnt;?>" id="degree<?php echo $intFrCnt;?>" value="<?php echo $degree;?>" placeholder="">
							</div>
							<div class="form-group">
								<label class="control-label" for="city">City:</label>
								<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt;?>" id="city<?php echo $intFrCnt;?>" value="<?php echo $city;?>" placeholder="">
							</div>
							<div class="form-group">
								<label class="control-label" for="city">State:</label>
								<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt;?>" id="state<?php echo $intFrCnt;?>" value="<?php echo $state;?>" placeholder="">
							</div>
							<!--<div class="form-group">
								<label class="control-label" for="percentage">Percentage of Tuition Paid by Self:</label>
								<input class="resume-builder-input" type="text" name="percentage<?php echo $intFrCnt;?>" id="percentage<?php echo $intFrCnt;?>" value="<?php echo $tution_percentage;?>" placeholder="">
								
							</div>--></div>
						   <?php
						  
					   }
					}
					else
					{
						$intFrCnt++;
						?>
							<div class="form-group">
								<label class="control-label" for="institution">Name of Institution:</label>
								<input class="resume-builder-input" type="text" name="institution<?php echo $intFrCnt;?>" id="institution<?php echo $intFrCnt;?>" value="<?php echo $institution;?>" placeholder="">
							</div>
							<div class="form-group">	
								<label class="control-label" for="degree">Degree or Certification Earned:</label>
								<input class="resume-builder-input" type="text" name="degree<?php echo $intFrCnt;?>" id="degree<?php echo $intFrCnt;?>" value="<?php echo $degree;?>" placeholder="">
							</div>
							<div class="form-group">
								<label class="control-label" for="city">City:</label>
								<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt;?>" id="city<?php echo $intFrCnt;?>" value="<?php echo $city;?>" placeholder="">
							</div>
							<div class="form-group">
								<label class="control-label" for="city">State:</label>
								<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt;?>" id="state<?php echo $intFrCnt;?>" value="<?php echo $state;?>" placeholder="">
							</div>
							<!--<div class="form-group">
								<label class="control-label" for="percentage">Percentage of Tuition Paid by Self:</label>
								<input class="resume-builder-input" type="text" name="percentage<?php echo $intFrCnt;?>" id="percentage<?php echo $intFrCnt;?>" value="<?php echo $tution_percentage;?>" placeholder="">
							</div>-->
						<?php
						
					}
					?>
						<input type="hidden" name="education_count" id="education_count" value="<?php echo $intFrCnt; ?>" />
						<div id="education"></div>

						<div class="form-group add-new-block">
							<button type="button" class="btn btn-access btn-sm" onclick="fnAddEducation()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New</button>
							
							<?php
								if($intFrCnt <= 1)
								{
									$strRemoveStyle = "style='display:none;'";
								}
							?>
							<button type="button" <?php echo $strRemoveStyle; ?> id="btnremove" class="btn btn-default btn-sm" onclick="fnRemoveEducation()"><span class="glyphicon glyphicon-minus"></span>&nbsp;Remove</button>
						</div>
						<div class="form-group">
							<button class="btn btn-default btn-responsive btn-lg" type="button" onclick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveEducation('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" onClick="return saveEducation('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						List degree or certification earned, year of graduation, your GPA, Name of your School, City and State. Indicate if you have financed a percentage of your education which helps validate work experience or your ability to earn scholarship monies.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveEducation('<?php echo $intPortalId?>','1');">
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
<script type="text/javascript">
	function fnRemoveEducation()
	{
		var intEdCount = $('#education_count').val();
		$('#education'+intEdCount).remove();
		intEdCount--;
		$('#education_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddEducation() 
	{
		var intEdCount = $('#education_count').val();
		intEdCount++;
		
		var strEduRows = '<div id="education'+intEdCount+'"><div class="form-group"><label class="control-label" for="degree">Degree or Certification Earned:</label><input class="resume-builder-input" type="text" name="degree'+intEdCount+'" id="degree'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="institution">Name of Institution:</label><input class="resume-builder-input" type="text" name="institution'+intEdCount+'" id="institution'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div></div>';
		
		
		$('#education').append(strEduRows);
		$('#education_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>