<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-9-resume-involvement flex-fix">

					

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



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">8</span><!-- 

						 --><span class="resume-builder-step-title"><s>Awards</s></span>

								

						</li>



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getCommunityInvolve('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Community Involvement</h1>
					<form name="frmcommunity" id="frmcommunity" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
					<?php
					$intFrCnt = 0;
					$organization = '';
					$candidate_cv_id=0;
					$city='';
					$state='';
					$dateStart='';
					$dateEnd='';
					$description='';
					$title='';
					$candidate_comm_involve_id=0;
					if(count($candidatecomminvolves)>0)
					{
						foreach($candidatecomminvolves as $arrEdu)
						{
							$candidate_comm_involve_id = $arrEdu['Candidate_Comm_Involve']['candidate_comm_involve_id'];
							$candidate_cv_id = $arrEdu['Candidate_Comm_Involve']['candidate_cv_id'];
							$organization = $arrEdu['Candidate_Comm_Involve']['organization'];
							$city = $arrEdu['Candidate_Comm_Involve']['city'];
							$state = $arrEdu['Candidate_Comm_Involve']['state'];
							$title = $arrEdu['Candidate_Comm_Involve']['title'];
							$dateStart = $arrEdu['Candidate_Comm_Involve']['dateStart'];
							$dateEnd = $arrEdu['Candidate_Comm_Involve']['dateEnd'];
							$description = $arrEdu['Candidate_Comm_Involve']['description'];
							$fromMonth = $arrEdu['Candidate_Comm_Involve']['frommonth'];
							$fromYear = $arrEdu['Candidate_Comm_Involve']['fromyear'];
							$toMonth = $arrEdu['Candidate_Comm_Involve']['tomonth'];
							$toYear = $arrEdu['Candidate_Comm_Involve']['toyear'];
							$description = $arrEdu['Candidate_Comm_Involve']['description'];
							$tilldate = "no";
							$strChk = "";
							if($arrEdu['Candidate_Comm_Involve']['tilldate'] == "on")
							{
								$tilldate = $arrEdu['Candidate_Comm_Involve']['tilldate'];
								$strChk = "checked='checked'";
							}
							$strStyle = "";
							if($tilldate == "on")
							{
								$strStyle = "style='display:none;'";
							}
							$intFrCnt++;
							?>
								<div id="comminv<?php echo $intFrCnt;?>">
									<div class="form-group">
										<input type="hidden" name="comm_involve_id" id="comm_involve_id" value="<?php echo $candidate_comm_involve_id;?>"/>
										<label class="control-label" for="organization-name">Name of organization:</label>
										<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="<?php echo $organization;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="city">City:</label>
										<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt;?>" id="city<?php echo $intFrCnt;?>" value="<?php echo $city;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="state">State:</label>
										<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt;?>" id="state<?php echo $intFrCnt;?>" value="<?php echo $state;?>" placeholder="">
									</div>
									<div class="form-group">
										<label class="control-label" for="title">Title:</label>
										<input class="resume-builder-input" type="text" name="title<?php echo $intFrCnt;?>" id="title<?php echo $intFrCnt;?>" value="<?php echo $title;?>" placeholder="">
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
										<select <?php echo $strStyle; ?> class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth<?php echo $intFrCnt; ?>" id="dateemonth<?php echo $intFrCnt; ?>">
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
										<select <?php echo $strStyle; ?> class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear<?php echo $intFrCnt; ?>" id="dateeyear<?php echo $intFrCnt; ?>">
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
										});
									</script>
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
							<div id="comminv<?php echo $intFrCnt;?>">
								<div class="form-group">
									<input type="hidden" name="comm_involve_id" id="comm_involve_id" value="<?php echo $candidate_comm_involve_id;?>"/>
									<label class="control-label" for="organization-name">Name of organization:</label>
									<input class="resume-builder-input" type="text" name="organization_name<?php echo $intFrCnt;?>" id="organization_name<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="city">City:</label>
									<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt;?>" id="city<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="state">State:</label>
									<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt;?>" id="state<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="title">Title:</label>
									<input class="resume-builder-input" type="text" name="title<?php echo $intFrCnt;?>" id="title<?php echo $intFrCnt;?>" value="" placeholder="">
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
											<!--<option value="13">Present</option>-->
										</select>&nbsp;
										<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
											<?php 
												echo $this->element('dateoptions');
											?>
											<!--<option value="2099">Present</option>-->
										</select>
								</div>
								<div class="form-group">
									<label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate<?php echo $intFrCnt; ?>" id="tilldate<?php echo $intFrCnt; ?>" <?php echo $strChk; ?> />&nbsp; I am presently active in this organization</label>&nbsp;
								</div>
								<div id="dateemonthcont<?php echo $intFrCnt; ?>" class="form-group" <?php echo $strStyle; ?>>
											<label>Date End:</label>
											<select <?php echo $strStyle; ?> class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth<?php echo $intFrCnt; ?>" id="dateemonth<?php echo $intFrCnt; ?>">
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
											<select <?php echo $strStyle; ?> class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear<?php echo $intFrCnt; ?>" id="dateeyear<?php echo $intFrCnt; ?>">
												<?php 
													echo $this->element('dateoptions');
												?>
												
											</select>
									</div>
								<div class="form-group">
									<label class="control-label" for="description">Description:</label>
									<textarea class="builder-textarea" name="description<?php echo $intFrCnt;?>" id="description<?php echo $intFrCnt;?>" rows="4"></textarea>
								</div>
							</div>
						<?php
					}
					?>
						<input type="hidden" name="comm_count" id="comm_count" value="<?php echo $intFrCnt; ?>" />
						<div id="commd"></div>
						<div class="form-group add-new-block">
							<button type="button" class="btn btn-access btn-sm" onclick="fnAddComm()"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New</button>
							<?php
								if($intFrCnt <= 1)
								{
									$strRemoveStyle = "style='display:none;'";
								}
							?>
							<button type="button" <?php echo $strRemoveStyle; ?> id="btnremove" class="btn btn-default btn-sm" onclick="fnRemoveComm()"><span class="glyphicon glyphicon-minus"></span>&nbsp;Remove</button>
						</div>
						<div class="form-group">
							<button class="btn btn-default btn-responsive btn-lg"  type="button" onClick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');" >&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveCommunityInvolvement('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" class="link link-default" onClick="return saveCommunityInvolvement('<?php echo $intPortalId?>','0');">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						If you are a recent grad, your work experience is limited or you have been out of the work force for a period of time, community involvement can add experience to your resume. Depending on the type of work you do, you can develop and improve transferrable skills like leadership, communication, public speaking, and mentoring abilities.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveCommunityInvolvement('<?php echo $intPortalId?>','1');">
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
	
	function fnRemoveComm()
	{
		var intEdCount = $('#comm_count').val();
		$('#comminv'+intEdCount).remove();
		intEdCount--;
		$('#comm_count').val(intEdCount);
		if(intEdCount == 1)
		{
			$('#btnremove').hide();
		}
		
	}
	
	function fnAddComm() 
	{
		var intEdCount = $('#comm_count').val();
		var dateopt = '<?php echo $strHtml; ?>';
		intEdCount++;
		
		var strEduRows = '<div id="comminv'+intEdCount+'"><div class="form-group"><input type="hidden" name="comm_involve_id" id="comm_involve_id" value="<?php echo $candidate_comm_involve_id;?>"/><label class="control-label" for="organization-name">Name of organization:</label><input class="resume-builder-input" type="text" name="organization_name'+intEdCount+'" id="organization_name'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="state">State:</label><input class="resume-builder-input" type="text" name="state'+intEdCount+'" id="state'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="title">Title:</label><input class="resume-builder-input" type="text" name="title'+intEdCount+'" id="title'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Date start:</label><select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth'+intEdCount+'" id="datemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear'+intEdCount+'" id="dateyear'+intEdCount+'">'+dateopt+'</select></div><span>&nbsp;</span><div class="form-group"><label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;" type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate'+intEdCount+'" id="tilldate'+intEdCount+'"/>&nbsp; I am presently active in this organization</label>&nbsp;</div><div id="dateemonthcont'+intEdCount+'" class="form-group"><label>Date End:</label><select class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth'+intEdCount+'" id="dateemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear'+intEdCount+'" id="dateeyear'+intEdCount+'"><option value="">--Select Year--</option>'+dateopt+'</select></div><div class="form-group"><label class="control-label" for="description">Description:</label><textarea class="builder-textarea" name="description'+intEdCount+'" id="description'+intEdCount+'" rows="4"></textarea></div></div>';
		
		$('#commd').append(strEduRows);
		$('#comm_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
		
	}
</script>