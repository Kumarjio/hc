
	<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-8-awards flex-fix">

					

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

						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">4</span><!-- 
						 --><span class="resume-builder-step-title"><s>Professional Experience</s></span>
						</li>

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyPublications('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">5</span><!-- 
						 --><span class="resume-builder-step-title"><s>Publications</s></span>
						</li>

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">6</span><!-- 
						 --><span class="resume-builder-step-title"><s>Awards</s></span>
						</li>


						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyGrants('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">7</span><!-- 
						 --><span class="resume-builder-step-title"><s>Grants and Fellowships</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyInvites('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">8</span><!-- 
						 --><span class="resume-builder-step-title"><s>Invited Talks</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyConference('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">9</span><!-- 
						 --><span class="resume-builder-step-title"><s>Conference Participation</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyCampus('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">10</span><!-- 
						 --><span class="resume-builder-step-title"><s>Campus or Depart...</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyTeaching('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">11</span><!-- 
						 --><span class="resume-builder-step-title"><s>Teaching Experience</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyResearch('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">12</span><!-- 
						 --><span class="resume-builder-step-title"><s>Research Experience</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">13</span><!-- 
						 --><span class="resume-builder-step-title"><s>Service to Profession</s></span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyUniService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">14</span><!-- 
						 --><span class="resume-builder-step-title"><s>Department/Uni...</s></span>
						</li>
						
						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getMyLang('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
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



					<h1>Languages</h1>

						

					<form id="lang" name="lang" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>
							
				<?php
					$intFrCnt = 0;
					$award='';
					$organization ='';
					$description ='';
					$candidate_awards_id =0;
					if(count($candidateawards)>0)
					{
					   foreach($candidateawards as $arrEdu)
					   {
						   $candidate_awards_id = $arrEdu['Candidate_lang']['candidate_prof_exp_id'];
						   $candidate_cv_id = $arrEdu['Candidate_lang']['candidate_cv_id'];
						   $award = $arrEdu['Candidate_lang']['lang'];
						   $organization = $arrEdu['Candidate_lang']['reading'];
						   $date = $arrEdu['Candidate_lang']['speaking'];
						   $writing = $arrEdu['Candidate_lang']['writing'];
						   $intFrCnt++;
						   ?>
								<div id="awards<?php echo $intFrCnt;?>">
									<div class="form-group">
										<label class="control-label" for="organization">Language:</label>
										<input class="resume-builder-input" type="text" name="lang<?php echo $intFrCnt;?>" id="lang<?php echo $intFrCnt;?>" value="<?php echo $award;?>" placeholder="">
									</div>
									<div class="form-group">
										<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
										<label class="control-label" for="award-name">Reading:</label>
										<input class="resume-builder-input" type="text" name="reading<?php echo $intFrCnt;?>" id="reading<?php echo $intFrCnt;?>" value="<?php echo $organization;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="award-name">Speaking:</label>
										<input class="resume-builder-input" type="text" name="speaking<?php echo $intFrCnt;?>" id="speaking<?php echo $intFrCnt;?>" value="<?php echo $date;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="award-name">Writing:</label>
										<input class="resume-builder-input" type="text" name="writing<?php echo $intFrCnt;?>" id="writing<?php echo $intFrCnt;?>" value="<?php echo $writing;?>" placeholder="">
									</div>
								</div>
						   <?php
					   }
					}
					else
					{
						$intFrCnt++;
						?>
							<div id="awards<?php echo $intFrCnt;?>">
								<div class="form-group">
									<label class="control-label" for="organization">Language:</label>
									<input class="resume-builder-input" type="text" name="lang<?php echo $intFrCnt;?>" id="lang<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
									<label class="control-label" for="award-name">Reading:</label>
									<input class="resume-builder-input" type="text" name="reading<?php echo $intFrCnt;?>" id="reading<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="award-name">Speaking:</label>
									<input class="resume-builder-input" type="text" name="speaking<?php echo $intFrCnt;?>" id="speaking<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="award-name">Writing:</label>
									<input class="resume-builder-input" type="text" name="writing<?php echo $intFrCnt;?>" id="writing<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="lang_count" id="lang_count" value="<?php echo $intFrCnt; ?>" />
					<div id="awardd"></div>
						<div class="form-group add-new-block">
							<button type="button" class="btn btn-access btn-sm" onclick="fnAddAward()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New</button>
							<?php
								if($intFrCnt <= 1)
								{
									$strRemoveStyle = "style='display:none;'";
								}
							?>
							<button type="button" <?php echo $strRemoveStyle; ?> id="btnremove" class="btn btn-default btn-sm" onclick="fnRemoveAward()"><span class="glyphicon glyphicon-minus"></span>&nbsp;Remove</button>
						</div>
						<div class="form-group">
							<button class="btn btn-default btn-responsive btn-lg"  type="button" onClick="return getMyUniService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveLang('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" class="link link-default" onClick="return saveLang('<?php echo $intPortalId?>','0');">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						All languages should be listed with proficiency in reading, speaking and writing using terms including: native fluent, excellent, conversational, good, etc.
					</p>
					<p>
						Include a short explanation on each award stating if it was a personal or professional accomplishment. Also state the organization that presented the award.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveLang('<?php echo $intPortalId?>','1');">
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
	function fnRemoveAward()
	{
		var intEdCount = $('#lang_count').val();
		$('#awards'+intEdCount).remove();
		intEdCount--;
		$('#lang_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddAward() 
	{
		var intEdCount = $('#lang_count').val();
		intEdCount++;
		
		var strEduRows = '<div id="awards'+intEdCount+'"><div class="form-group"><label class="control-label" for="organization">Language:</label><input class="resume-builder-input" type="text" name="lang'+intEdCount+'" id="lang'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><input type="hidden" name="awardsid'+intEdCount+'" id="awardsid'+intEdCount+'" value=""/><label class="control-label" for="award-name">Reading:</label><input class="resume-builder-input" type="text" name="reading'+intEdCount+'" id="reading'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="award-name">Speaking:</label><input class="resume-builder-input" type="text" name="speaking'+intEdCount+'" id="speaking'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="award-name">Writing:</label><input class="resume-builder-input" type="text" name="writing'+intEdCount+'" id="writing'+intEdCount+'" value="" placeholder=""></div></div>';
		
		
		$('#awardd').append(strEduRows);
		$('#lang_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
</script>