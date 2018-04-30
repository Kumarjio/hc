
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



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">5</span><!-- 

						 --><span class="resume-builder-step-title"><s>Education</s></span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">6</span><!-- 

						 --><span class="resume-builder-step-title"><s>Professional Experience</s></span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyAffiliates('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">7</span><!-- 

						 --><span class="resume-builder-step-title"><s>Professional Affiliations</s></span>

								

						</li>



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Awards</h1>

						

					<form id="frmawards" name="frmawards" method="post">
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
						   $candidate_awards_id = $arrEdu['Candidate_Awards']['candidate_awards_id'];
						   $candidate_cv_id = $arrEdu['Candidate_Awards']['candidate_cv_id'];
						   $award = $arrEdu['Candidate_Awards']['award'];
						   $organization = $arrEdu['Candidate_Awards']['organization'];
						   $description = $arrEdu['Candidate_Awards']['description'];
						   $intFrCnt++;
						   ?>
								<div id="awards<?php echo $intFrCnt;?>">
									<div class="form-group">
										<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
										<label class="control-label" for="award-name">Name of Award:</label>
										<input class="resume-builder-input" type="text" name="award_name<?php echo $intFrCnt;?>" id="award_name<?php echo $intFrCnt;?>" value="<?php echo $award;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="organization">Organization:</label>
										<input class="resume-builder-input" type="text" name="organization<?php echo $intFrCnt;?>" id="organization<?php echo $intFrCnt;?>" value="<?php echo $organization;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="description">Description:</label>
										<textarea class="builder-textarea" name="description<?php echo $intFrCnt;?>" id="description<?php echo $intFrCnt;?>" rows="4"><?php echo $description;?></textarea>
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
									<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
									<label class="control-label" for="award-name">Name of Award:</label>
									<input class="resume-builder-input" type="text" name="award_name<?php echo $intFrCnt;?>" id="award_name<?php echo $intFrCnt;?>" value="<?php echo $award;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="organization">Organization:</label>
									<input class="resume-builder-input" type="text" name="organization<?php echo $intFrCnt;?>" id="organization<?php echo $intFrCnt;?>" value="<?php echo $organization;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="description">Description:</label>
									<textarea class="builder-textarea" name="description<?php echo $intFrCnt;?>" id="description<?php echo $intFrCnt;?>" rows="4"><?php echo $description;?></textarea>
								</div>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="award_count" id="award_count" value="<?php echo $intFrCnt; ?>" />
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
							<button class="btn btn-default btn-responsive btn-lg"  type="button" onClick="return getMyAffiliates('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveAwards('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" class="link link-default" onClick="return saveProfExp('<?php echo $intPortalId?>','0');">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						Awards show how hard you have worked and helps reinforce the fact that you do more than attend school and work. In order for awards to have a positive effect, it needs to be formatted properly. Utilize bullet points similar to the bullet points utilized when listing your accomplishments.
					</p>
					<p>
						Include a short explanation on each award stating if it was a personal or professional accomplishment. Also state the organization that presented the award.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveAwards('<?php echo $intPortalId?>','1');">
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
		var intEdCount = $('#award_count').val();
		$('#awards'+intEdCount).remove();
		intEdCount--;
		$('#award_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddAward() 
	{
		var intEdCount = $('#award_count').val();
		intEdCount++;
		
		var strEduRows = '<div id="awards'+intEdCount+'"><div class="form-group"><label class="control-label" for="award-name">Name of Award:</label><input class="resume-builder-input" type="text" name="award_name'+intEdCount+'" id="award_name'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="organization">Organization:</label><input class="resume-builder-input" type="text" name="organization'+intEdCount+'" id="organization'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="description">Description:</label><textarea class="builder-textarea" name="description'+intEdCount+'" id="description'+intEdCount+'" rows="4"></textarea></div></div>';
		
		
		$('#awardd').append(strEduRows);
		$('#award_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
</script>