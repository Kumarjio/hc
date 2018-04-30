
	<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-7-professional-affiliations flex-fix">

					

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



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getMyAffiliates('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Professional Affiliations</h1>
					<form name="frmprofaff" id="frmprofaff" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>
					<?php
					$intFrCnt = 0;
					$organization_name='';
					$acronym ='';
					$leadership ='';
					$candidate_prof_affilations_id =0;
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					if(count($proffsionalaffilations)>0)
					{
					   foreach($proffsionalaffilations as $arrEdu)
					   {
							$candidate_prof_affilations_id = $arrEdu['Candidate_prof_affilations']['candidate_prof_affilations_id'];
							$organization_name = $arrEdu['Candidate_prof_affilations']['organization_name'];
							$acronym = $arrEdu['Candidate_prof_affilations']['acronym'];
							$leadership = $arrEdu['Candidate_prof_affilations']['leadership'];
							$intFrCnt++;
							?>
								<div id="profaff<?php echo $intFrCnt;?>">
								<div class="form-group">
									<input type="hidden" name="prof_aff_id<?php echo $intFrCnt;?>" id="prof_aff_id<?php echo $intFrCnt;?>" value="<?php echo $candidate_prof_affilations_id;?>"/>
									<label class="control-label" for="organization-name">Name of Organizations Full Name:</label>
									<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="<?php echo $organization_name;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="acronym">Acronym:</label>
									<input class="resume-builder-input" type="text" name="acronym<?php echo $intFrCnt;?>" id="acronym<?php echo $intFrCnt;?>" value="<?php echo $acronym;?>" placeholder="">
								</div>	
								<div class="form-group">
									<label class="control-label" for="leadership-roles">Leadership Roles:</label>
									<input class="resume-builder-input" type="text" name="leadershiproles<?php echo $intFrCnt;?>"  id="leadershiproles<?php echo $intFrCnt;?>" value="<?php echo $leadership;?>" placeholder="">
								</div></div>
							<?php
					   }
					}
					else
					{
						$intFrCnt++;
						?>
							<div id="profaff<?php echo $intFrCnt;?>">
								<div class="form-group">
									<input type="hidden" name="prof_aff_id<?php echo $intFrCnt;?>" id="prof_aff_id<?php echo $intFrCnt;?>" value="<?php echo $candidate_prof_affilations_id;?>"/>
									<label class="control-label" for="organization-name">Name of Organizations Full Name:</label>
									<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="<?php echo $organization_name;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="acronym">Acronym:</label>
									<input class="resume-builder-input" type="text" name="acronym<?php echo $intFrCnt;?>" id="acronym<?php echo $intFrCnt;?>" value="<?php echo $acronym;?>" placeholder="">
								</div>	
								<div class="form-group">
									<label class="control-label" for="leadership-roles">Leadership Roles:</label>
									<input class="resume-builder-input" type="text" name="leadershiproles<?php echo $intFrCnt;?>"  id="leadershiproles<?php echo $intFrCnt;?>" value="<?php echo $leadership;?>" placeholder="">
								</div>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="profaff_count" id="profaff_count" value="<?php echo $intFrCnt; ?>" />
					<div id="profaffd"></div>
					<div class="form-group add-new-block">
						<button type="button" class="btn btn-access btn-sm" onclick="fnAddPrfAff()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New</button>
						<?php
							if($intFrCnt <= 1)
							{
								$strRemoveStyle = "style='display:none;'";
							}
						?>
						<button type="button" <?php echo $strRemoveStyle; ?> id="btnremove" class="btn btn-default btn-sm" onclick="fnRemovePrfAff()"><span class="glyphicon glyphicon-minus"></span>&nbsp;Remove</button>
					</div>
					<div class="form-group">
						<button class="btn btn-default btn-responsive btn-lg" type="button"  onClick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
						<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveProffAffilations('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
						<a href="#" onClick="return saveProffAffilations('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
					</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						Listing Professional Affiliations can highlight dedication to your profession or a strong desire to develop professionally. Your affiliations also indicate that you keep up with current industry trends.
					</p>
					<p>
						Include Professional Affiliations that are related to your job target or personal affiliations that demonstrate characteristics that are important to your targeted job. List leadership roles. When you list Professional Affiliations, list the full name of the organization followed by the appropriate acronym in parentheses.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveProffAffilations('<?php echo $intPortalId?>','1');">
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
	function fnRemovePrfAff()
	{
		var intEdCount = $('#profaff_count').val();
		$('#profaff'+intEdCount).remove();
		intEdCount--;
		$('#profaff_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddPrfAff() 
	{
		var intEdCount = $('#profaff_count').val();
		intEdCount++;
		
		var strEduRows = '<div id="profaff'+intEdCount+'"><div class="form-group"><label class="control-label" for="organization-name">Name of Organizations Full Name:</label><input class="resume-builder-input" type="text" name="organization_name'+intEdCount+'" id="organization_name'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="acronym">Acronym:</label><input class="resume-builder-input" type="text" name="acronym'+intEdCount+'" id="acronym'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="leadership-roles">Leadership Roles:</label><input class="resume-builder-input" type="text" name="leadershiproles'+intEdCount+'"  id="leadershiproles'+intEdCount+'" value="" placeholder=""></div></div>';
		
		
		$('#profaffd').append(strEduRows);
		$('#profaff_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>