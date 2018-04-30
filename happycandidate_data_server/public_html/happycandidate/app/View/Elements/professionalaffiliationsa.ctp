
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
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyLang('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">15</span><!-- 
						 --><span class="resume-builder-step-title"><s>Languages</s></span>
						</li>
						
						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getMyPrffAffA('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
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



					<h1>Professional Affiliations</h1>
					<form name="frmprofaffa" id="frmprofaffa" method="post">
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
							$candidate_prof_affilations_id = $arrEdu['Candidate_prof_affiliation_a']['candidate_prof_affilations_id'];
							$organization_name = $arrEdu['Candidate_prof_affiliation_a']['organization_name'];
							$acronym = $arrEdu['Candidate_prof_affiliation_a']['year'];
							$fromYear = $arrEdu['Candidate_prof_affiliation_a']['year'];
							$intFrCnt++;
							?>
								<div id="profaff<?php echo $intFrCnt;?>">
									<div class="form-group">
										<input type="hidden" name="prof_aff_id<?php echo $intFrCnt;?>" id="prof_aff_id<?php echo $intFrCnt;?>" value="<?php echo $candidate_prof_affilations_id;?>"/>
										<label class="control-label" for="organization-name">Name of Organizations Full Name:</label>
										<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="<?php echo $organization_name;?>" placeholder="">
									</div>
									<div class="form-group">
										<label>Year Joined:</label>
										<select class="resume-builder-input validate[required]" name="date-start<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
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
							<div id="profaff<?php echo $intFrCnt;?>">
								<div class="form-group">
									<input type="hidden" name="prof_aff_id<?php echo $intFrCnt;?>" id="prof_aff_id<?php echo $intFrCnt;?>" value="<?php echo $candidate_prof_affilations_id;?>"/>
									<label class="control-label" for="organization-name">Name of Organizations Full Name:</label>
									<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label>Year Joined:</label>
									<select class="resume-builder-input validate[required]" name="date-start<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
										<?php 
											echo $this->element('dateoptions');
										?>
									</select>
								</div>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="aca_profaff_count" id="aca_profaff_count" value="<?php echo $intFrCnt; ?>" />
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
						<button class="btn btn-default btn-responsive btn-lg" type="button"  onClick="return getMyLang('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
						<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveAcaProffAffilations('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
						<a href="#" onClick="return saveAcaProffAffilations('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
					</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						List all professional organizations where you are a member.  Also list year you joined to demonstrate the length of commitment to your field.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveAcaProffAffilations('<?php echo $intPortalId?>','1');">
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
	function fnRemovePrfAff()
	{
		var intEdCount = $('#aca_profaff_count').val();
		$('#profaff'+intEdCount).remove();
		intEdCount--;
		$('#aca_profaff_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddPrfAff() 
	{
		var intEdCount = $('#aca_profaff_count').val();
		intEdCount++;
		var dateopt = '<?php echo $strHtml; ?>';
		
		var strEduRows = '<div id="profaff'+intEdCount+'"><div class="form-group"><input type="hidden" name="prof_aff_id'+intEdCount+'" id="prof_aff_id'+intEdCount+'" value=""/><label class="control-label" for="organization-name">Name of Organizations Full Name:</label><input class="resume-builder-input" type="text" name="organization_name'+intEdCount+'" id="organization_name'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Year Joined:</label><select class="resume-builder-input validate[required]" name="date-start'+intEdCount+'" id="dateyear'+intEdCount+'">'+dateopt+'</select></div></div>';
		
		
		$('#profaffd').append(strEduRows);
		$('#aca_profaff_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>