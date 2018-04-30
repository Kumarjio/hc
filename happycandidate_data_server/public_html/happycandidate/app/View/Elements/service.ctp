
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
						
						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getMyService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
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



					<h1>Service to Profession</h1>

						

					<form id="service" name="service" method="post">
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
						   $candidate_awards_id = $arrEdu['Candidate_service']['candidate_awards_id'];
						   $candidate_cv_id = $arrEdu['Candidate_service']['candidate_cv_id'];
						   $award = $arrEdu['Candidate_service']['jobTitle'];
						   $organization = $arrEdu['Candidate_service']['company'];
						   $fromMonth = $arrEdu['Candidate_service']['frommonth'];
						   $fromYear = $arrEdu['Candidate_service']['fromyear'];
						   $toMonth = $arrEdu['Candidate_service']['tomonth'];
						   $toYear = $arrEdu['Candidate_service']['toyear'];
						   $tilldate = "no";
							$strChk = "";
							if($arrEdu['Candidate_service']['tilldate'] == "on")
							{
								$tilldate = $arrEdu['Candidate_service']['tilldate'];
								$strChk = "checked='checked'";
							}
							
							$strStyle = "";
							if($tilldate == "on")
							{
								$strStyle = "style='display:none;'";
							}
						   $intFrCnt++;
						   ?>
								<div id="awards<?php echo $intFrCnt;?>">
									<div class="form-group">
										<label class="control-label" for="organization">Name of Organization/Journal:</label>
										<input class="resume-builder-input" type="text" name="organization<?php echo $intFrCnt;?>" id="organization<?php echo $intFrCnt;?>" value="<?php echo $organization;?>" placeholder="">
									</div>
									<div class="form-group">
										<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
										<label class="control-label" for="award-name">Title:</label>
										<input class="resume-builder-input" type="text" name="award_name<?php echo $intFrCnt;?>" id="award_name<?php echo $intFrCnt;?>" value="<?php echo $award;?>" placeholder="">
									</div>
									<div class="form-group">
											<label>Date start:</label>
											<select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth<?php echo $intFrCnt; ?>" id="datemonth<?php echo $intFrCnt; ?>" >
												<option value="01">January</option>
												<option value="02">February</option>
												<option value="03">March</option>
												<option value="04">April</option>
												<option value="05">May</option>
												<option value="06">June</option>
												<option value="07">July</option>
												<option value="08">August</option>
												<option value="09">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
											</select>&nbsp;
											<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
												<?php 
													echo $this->element('dateoptions');
												?>
											</select>
									</div>
									<script type="text/javascript">
										$(document).ready( function () {
											$('#datemonth'+<?php echo $intFrCnt; ?>).val('<?php echo date("m",strtotime($fromMonth)); ?>');
											$('#dateyear'+<?php echo $intFrCnt; ?>).val('<?php echo $fromYear; ?>');
										});
									</script>
									<div class="form-group">
										<label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate<?php echo $intFrCnt; ?>" id="tilldate<?php echo $intFrCnt; ?>" <?php echo $strChk; ?> />&nbsp; I am presently active in this organization</label>&nbsp;
									</div>
									<div id="dateemonthcont<?php echo $intFrCnt; ?>" class="form-group" <?php echo $strStyle; ?>>
											<label>Date End:</label>
											<select <?php echo $strStyle; ?>  class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth<?php echo $intFrCnt; ?>" id="dateemonth<?php echo $intFrCnt; ?>">
												<option value="01">January</option>
												<option value="02">February</option>
												<option value="03">March</option>
												<option value="04">April</option>
												<option value="05">May</option>
												<option value="06">June</option>
												<option value="07">July</option>
												<option value="08">August</option>
												<option value="09">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
											</select>
											<select <?php echo $strStyle; ?>  class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear<?php echo $intFrCnt; ?>" id="dateeyear<?php echo $intFrCnt; ?>">
												<?php 
													echo $this->element('dateoptions');
												?>
											</select>
									</div>
									<script type="text/javascript">
										$(document).ready( function () {
											var strToMonth = '<?php echo $toMonth ;?>';
											if(strToMonth == "13")
											{
												$('#dateemonth'+<?php echo $intFrCnt; ?>).val('13');
											}
											else
											{
												$('#dateemonth'+<?php echo $intFrCnt; ?>).val('<?php echo date("m",strtotime($toMonth)); ?>');
											}
											
											$('#dateeyear'+<?php echo $intFrCnt; ?>).val('<?php echo $toYear; ?>');
											//$('#tilldate'+<?php echo $intFrCnt; ?>).val('<?php echo $tilldate; ?>');
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
							<div id="awards<?php echo $intFrCnt;?>">
								<div class="form-group">
									<label class="control-label" for="organization">Name of Organization/Journal:</label>
									<input class="resume-builder-input" type="text" name="organization<?php echo $intFrCnt;?>" id="organization<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								
								<div class="form-group">
									<input type="hidden" name="awardsid<?php echo $intFrCnt;?>" id="awardsid<?php echo $intFrCnt;?>" value="<?php echo $candidate_awards_id;?>"/>	
									<label class="control-label" for="award-name">Title:</label>
									<input class="resume-builder-input" type="text" name="award_name<?php echo $intFrCnt;?>" id="award_name<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
										<label>Date start:</label>
										<select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth<?php echo $intFrCnt; ?>" id="datemonth<?php echo $intFrCnt; ?>">
											<option value="01">January</option>
											<option value="02">February</option>
											<option value="03">March</option>
											<option value="04">April</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">August</option>
											<option value="09">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>&nbsp;
										<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
											<?php 
												echo $this->element('dateoptions');
											?>
										</select>
								</div>
								<div class="form-group">
									<label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate<?php echo $intFrCnt; ?>" id="tilldate<?php echo $intFrCnt; ?>" <?php echo $strChk; ?> />&nbsp; I am presently working at this company</label>&nbsp;
								</div>
								<div id="dateemonthcont<?php echo $intFrCnt; ?>" class="form-group" <?php echo $strStyle; ?>>
										<label>Date End:</label>
										<select class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth<?php echo $intFrCnt; ?>" id="dateemonth<?php echo $intFrCnt; ?>">
											<option value="01">January</option>
											<option value="02">February</option>
											<option value="03">March</option>
											<option value="04">April</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">August</option>
											<option value="09">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>&nbsp;
										<select class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear<?php echo $intFrCnt; ?>" id="dateeyear<?php echo $intFrCnt; ?>">
											<?php 
												echo $this->element('dateoptions');
											?>
										</select>
								</div>
							</div>
						<?php
					}
					?>
					<input type="hidden" name="service_count" id="service_count" value="<?php echo $intFrCnt; ?>" />
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
							<button class="btn btn-default btn-responsive btn-lg"  type="button" onClick="return getMyResearch('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveService('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" class="link link-default" onClick="return saveService('<?php echo $intPortalId?>','0');">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						Leadership of professional organizations or journal manuscript review work with journal titles should be included in this section of your CV.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveService('<?php echo $intPortalId?>','1');">
							<span class="builder-save-icon"></span><!-- 
						 --><span class="action-value">Save &amp; Quit</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
$strHtml = $this->element('dateoptionsnew');
?>
<?php
	echo $this->element('font_modal');
	
?>
<script type="text/javascript">
	function fnRemoveAward()
	{
		var intEdCount = $('#service_count').val();
		$('#awards'+intEdCount).remove();
		intEdCount--;
		$('#service_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function checkFromMonth(field, rules, i, options){
		var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		var strFromMonthVal  = field.val();
		var stFromMonthAtt = field.attr('name');
		var strFromYearIndex = stFromMonthAtt.substr(9);
		var strFromYear = $('#dateyear'+strFromYearIndex).val();
		var strToMonth = $('#dateemonth'+strFromYearIndex).val();
		var strToYear = $('#dateeyear'+strFromYearIndex).val();
		
		if(parseInt(strFromYear) == parseInt(strToYear))
		{
			if(parseInt(field.val()) <= parseInt(strToMonth))
			{
				return true;
			}
			else
			{
				//return options.allrules.urlcheck.alertText;
				return "Start Month cannot be ahead of End month";
			}
		}
	}
	
	function checkToMonth(field, rules, i, options){
		var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		var strFromMonthVal  = field.val();
		var stFromMonthAtt = field.attr('name');
		var strFromYearIndex = stFromMonthAtt.substr(10);
		var strFromYear = $('#dateyear'+strFromYearIndex).val();
		var strFromMonth = $('#datemonth'+strFromYearIndex).val();
		var strToYear = $('#dateeyear'+strFromYearIndex).val();
		
		if(parseInt(strFromYear) == parseInt(strToYear))
		{
			if(parseInt(field.val()) >= parseInt(strFromMonth))
			{
				return true;
			}
			else
			{
				//return options.allrules.urlcheck.alertText;
				return "End Month cannot be behind of Start month";
			}
		}
	}
	
	function checkFromYear(field, rules, i, options){
		var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		var strFromMonthVal  = field.val();
		var stFromMonthAtt = field.attr('name');
		var strFromYearIndex = stFromMonthAtt.substr(8);
		var strToYear = $('#dateeyear'+strFromYearIndex).val();
		
		if(parseInt(field.val()) <= parseInt(strToYear))
		{
			return true;
		}
		else
		{
			return "Start Year cannot be ahead of End Year";
		}
	}
	
	function fnAdjustYearSelection(ele)
	{
		var stFromMonthAtt = $(ele).attr('name');
		var strFromYearIndex = stFromMonthAtt.substr(8);		
		if($(ele).is(':checked'))
		{
			$('#dateemonthcont'+strFromYearIndex).hide();
			$('#dateemonth'+strFromYearIndex).hide();
			$('#dateeyear'+strFromYearIndex).hide();
		}
		else
		{
			$('#dateemonthcont'+strFromYearIndex).show();
			$('#dateemonth'+strFromYearIndex).show();
			$('#dateeyear'+strFromYearIndex).show();
		}
		
	}
	
	function checkToYear(field, rules, i, options){
		var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		var strFromMonthVal  = field.val();
		var stFromMonthAtt = field.attr('name');
		var strFromYearIndex = stFromMonthAtt.substr(9);
		var strFromYear = $('#dateyear'+strFromYearIndex).val();
		
		if(parseInt(field.val()) >= parseInt(strFromYear))
		{
			return true;
		}
		else
		{
			return "End Year cannot be behind of Start Year";
		}
	}
	
	function fnAddAward() 
	{
		var intEdCount = $('#service_count').val();
		intEdCount++;
		var dateopt = '<?php echo $strHtml; ?>';
		
		var strEduRows = '<div id="awards'+intEdCount+'"><div class="form-group"><label class="control-label" for="organization">Name of Organization/Journal:</label><input class="resume-builder-input" type="text" name="organization'+intEdCount+'" id="organization'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="award-name">Title:</label><input class="resume-builder-input" type="text" name="award_name'+intEdCount+'" id="award_name'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Date start:</label><select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth'+intEdCount+'" id="datemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear'+intEdCount+'" id="dateyear'+intEdCount+'">'+dateopt+'</select></div><div class="form-group"><label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate'+intEdCount+'" id="tilldate'+intEdCount+'" />&nbsp; I am presently active in this organization</label>&nbsp;</div><div id="dateemonthcont'+intEdCount+'" class="form-group"><label>Date End:</label><select class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth'+intEdCount+'" id="dateemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear'+intEdCount+'" id="dateeyear'+intEdCount+'">'+dateopt+'</select></div></div>';
		
		
		$('#awardd').append(strEduRows);
		$('#service_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
</script>