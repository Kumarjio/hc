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



						<li class="resume-builder-step-current" style="cursor:pointer;" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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

					

					<h1>Professional Experience</h1>
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
							$fromMonth = $arrEdu['Candidate_prof_exp']['frommonth'];
							$fromYear = $arrEdu['Candidate_prof_exp']['fromyear'];
							$toMonth = $arrEdu['Candidate_prof_exp']['tomonth'];
							$toYear = $arrEdu['Candidate_prof_exp']['toyear'];
							$description = $arrEdu['Candidate_prof_exp']['description'];
							$arrAcc = $arrEdu['Candidate_prof_exp']['acc'];
							$tilldate = "no";
							$strChk = "";
							if($arrEdu['Candidate_prof_exp']['tilldate'] == "on")
							{
								$tilldate = $arrEdu['Candidate_prof_exp']['tilldate'];
								$strChk = "checked='checked'";
							}
							
							$strStyle = "";
							if($tilldate == "on")
							{
								$strStyle = "style='display:none;'";
							}
							$intFrCnt++;
							?>
								<div id="proffexpe<?php echo $intFrCnt; ?>">
									<div class="form-group">
										<input type="hidden" name="prof_exp_id<?php echo $intFrCnt; ?>" id="prof_exp_id<?php echo $intFrCnt; ?>" value="<?php echo $candidate_prof_exp_id;?>"/>	
										<label class="control-label" for="company-name">Name of Company:</label>
										<input class="resume-builder-input" type="text" name="company<?php echo $intFrCnt; ?>" id="company<?php echo $intFrCnt; ?>" value="<?php echo $company;?>" placeholder="">
									</div>

									<div class="form-group">
										<label class="control-label" for="city">City:</label>
										<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt; ?>" id="city<?php echo $intFrCnt; ?>" value="<?php echo $city;?>" placeholder="">
									</div>

									<div class="form-group">
										<label class="control-label" for="state">State:</label>
										<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt; ?>" id="state<?php echo $intFrCnt; ?>" value="<?php echo $state;?>" placeholder="">
									</div>

									<div class="form-group">
										<label class="control-label" for="job-title">Job Title:</label>
										<input class="resume-builder-input" type="text" name="jobTitle<?php echo $intFrCnt; ?>" id="jobTitle<?php echo $intFrCnt; ?>" value="<?php echo $jobTitle;?>" placeholder="">
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
												<!--<option value="13">Present</option>-->
											</select>&nbsp;
											<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear<?php echo $intFrCnt; ?>" id="dateyear<?php echo $intFrCnt; ?>">
												<?php 
													echo $this->element('dateoptions');
												?>
												<!--<option value="2099">Present</option>-->
											</select>
									</div>
									<script type="text/javascript">
										$(document).ready( function () {
											$('#datemonth'+<?php echo $intFrCnt; ?>).val('<?php echo date("m",strtotime($fromMonth)); ?>');
											$('#dateyear'+<?php echo $intFrCnt; ?>).val('<?php echo $fromYear; ?>');
										});
									</script>
									<div class="form-group">
										<label> <input style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate<?php echo $intFrCnt; ?>" id="tilldate<?php echo $intFrCnt; ?>" <?php echo $strChk; ?> />&nbsp; I am presently working at this company</label>&nbsp;
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
										<textarea class="builder-textarea" name="description<?php echo $intFrCnt; ?>" id="description<?php echo $intFrCnt; ?>" rows="4"><?php echo $description;?></textarea>
									</div>
									<?php
										if(is_array($arrAcc) && (count($arrAcc)>0))
										{
											?>
											<div class="form-group">
												<label class="control-label">Accomplishments/Impact of Accomplishments:</label>
												<?php
													$intFrAcnt = 0;
													foreach($arrAcc as $arrAc)
													{
														$strRow = $arrAc['Candidate_prof_exp_acc']['acc'];
														$intFrAcnt++;
														?>
															<textarea name="acc<?php echo $intFrCnt.$intFrAcnt; ?>" id="acc<?php echo $intFrCnt.$intFrAcnt; ?>" class="builder-textarea" rows="2"><?php echo $strRow; ?></textarea>
														<?php
													}
												?>
												<div id="acccont<?php echo $intFrCnt; ?>"></div>
												<a id="acc<?php echo $intFrCnt; ?>" href="javascript:void(0);" onclick="fnAddAccomplishments(this)" class="link link-primary">+ Add Accomplishment</a>
											</div>
											<?php
										}
										else
										{
											?>
												<div class="form-group">
													<label class="control-label">Accomplishments/Impact of Accomplishments:</label>
													<textarea name="acc1<?php echo $intFrCnt; ?>" id="acc1<?php echo $intFrCnt; ?>" class="builder-textarea" rows="2"></textarea>
													<div id="acccont<?php echo $intFrCnt; ?>"></div>
													<a id="acc<?php echo $intFrCnt; ?>" href="javascript:void(0);" onclick="fnAddAccomplishments(this)" class="link link-primary">+ Add Accomplishment</a>
												</div>
											<?php
										}
									?>
									
									<input type="hidden" name="pexp_acc_cnt<?php echo $intFrCnt; ?>" id="pexp_acc_cnt<?php echo $intFrCnt; ?>" value="<?php echo $intFrCnt; ?>" />
								</div>
							<?php
						}	
					}
					else
					{
						$intFrCnt++;
						$strStyle = "style='display:none;'";
						?>
							<div id="proffexpe<?php echo $intFrCnt; ?>">
								<div class="form-group">
									<input type="hidden" name="prof_exp_id<?php echo $intFrCnt; ?>" id="prof_exp_id<?php echo $intFrCnt; ?>" value="<?php echo $candidate_prof_exp_id;?>"/>	
									<label class="control-label" for="company-name">Name of Company:</label>
									<input class="resume-builder-input" type="text" name="company<?php echo $intFrCnt; ?>" id="company<?php echo $intFrCnt; ?>" value="<?php echo $company;?>" placeholder="">
								</div>

								<div class="form-group">
									<label class="control-label" for="city">City:</label>
									<input class="resume-builder-input" type="text" name="city<?php echo $intFrCnt; ?>" id="city<?php echo $intFrCnt; ?>" value="<?php echo $city;?>" placeholder="">
								</div>

								<div class="form-group">
									<label class="control-label" for="state">State:</label>
									<input class="resume-builder-input" type="text" name="state<?php echo $intFrCnt; ?>" id="state<?php echo $intFrCnt; ?>" value="<?php echo $state;?>" placeholder="">
								</div>

								<div class="form-group">
									<label class="control-label" for="job-title">Job Title:</label>
									<input class="resume-builder-input" type="text" name="jobTitle<?php echo $intFrCnt; ?>" id="jobTitle<?php echo $intFrCnt; ?>" value="<?php echo $jobTitle;?>" placeholder="">
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
									<label> <input checked='checked' style="width:auto;height:auto;margin-top:0px;vertical-align:middle;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate<?php echo $intFrCnt; ?>" id="tilldate<?php echo $intFrCnt; ?>" <?php echo $strChk; ?>>&nbsp; I am presently working at this company</input></label>&nbsp;
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
								<!--<div class="form-group">
									<div class="half-container">
										<label>Date start:</label>
										<div class="datetime-container">
											<div class='input-group date control-label' id='datetimepicker1'>
												<input type='text' class="form-control" name="date-start<?php echo $intFrCnt; ?>" id="date-start<?php echo $intFrCnt; ?>" placeholder="10/17/2015" value="<?php echo $fromDate;?>" required>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
										<script>
											function tal(event){
												$('#datetimepicker1').datetimepicker({
													format: 'YYYY-MM-DD'
												});
												$('#datetimepicker2').datetimepicker({
													format: 'YYYY-MM-DD'
												});
											}
											$(document).ready(function () {
												tal();
											});
										</script>
									</div>
									<span>&nbsp;-&nbsp;</span>
									<div class="half-container">
										<label>Date end:</label>
										<div class="datetime-container">
											<div class='input-group date control-label' id='datetimepicker2'>
												<input type='text' class="form-control" name="date-end<?php echo $intFrCnt; ?>" id="date-end<?php echo $intFrCnt; ?>" placeholder="10/17/2015" value="<?php echo $toDate;?>" required>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar" ></span>
												</span>
											</div>
										</div>
									</div>
								</div>-->
								<div class="form-group">
									<label class="control-label" for="description">Description:</label>
									<textarea class="builder-textarea" name="description<?php echo $intFrCnt; ?>" id="description<?php echo $intFrCnt; ?>" rows="4"><?php echo $description;?></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">Accomplishments/Impact of Accomplishments:</label>
									<textarea name="acc1<?php echo $intFrCnt; ?>" id="acc1<?php echo $intFrCnt; ?>" class="builder-textarea" rows="2"></textarea>
									<?php 
										$intFrCnt++; 
									?>
									<textarea name="acc1<?php echo $intFrCnt; ?>" id="acc1<?php echo $intFrCnt; ?>" class="builder-textarea" rows="2"></textarea>
									
									<div id="acccont<?php echo $intFrCnt; ?>"></div>
									<a id="acc<?php echo $intFrCnt; ?>" href="javascript:void(0);" onclick="fnAddAccomplishments(this)" class="link link-primary">+ Add Accomplishment</a>
								</div>
								<input type="hidden" name="pexp_acc_cnt<?php echo $intFrCnt; ?>" id="pexp_acc_cnt<?php echo $intFrCnt; ?>" value="<?php echo $intFrCnt; ?>" />
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
$strHtml = $this->element('dateoptionsnew');
?>
<?php
	echo $this->element('font_modal');
	
?>
<script type="text/javascript">
	
	function fnAddAccomplishments(ele)
	{
		//alert("hi");
		var stFromMonthAtt = $(ele).attr('id');
		var strFromYearIndex = stFromMonthAtt.substr(3);
		
		var intEdCount = $('#pexp_acc_cnt'+strFromYearIndex).val();
		//alert(intEdCount);
		
		var str ='<textarea name="acc1'+intEdCount+'" id="acc1'+intEdCount+'" class="builder-textarea" rows="2"></textarea>';
		$('#acccont'+strFromYearIndex).append(str);
		intEdCount++;
		
		
		$('#pexp_acc_cnt'+strFromYearIndex).val(intEdCount);
	}
	
	
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
			//alert($('#dateemonthcont'+strFromYearIndex).length)
			$('#dateemonthcont'+strFromYearIndex).hide();
			$('#dateemonth'+strFromYearIndex).hide();
			$('#dateeyear'+strFromYearIndex).hide();
		}
		else
		{
			//alert('asd');
			
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
	
	function fnAddProfExperience() 
	{
		var intEdCount = $('#pexp_count').val();
		intEdCount++;
		var dateopt = '<?php echo $strHtml; ?>';
		
		/*var strEduRows  = '<div id="proffexpe'+intEdCount+'"><div class="form-group"><input type="hidden" name="prof_exp_id'+intEdCount+'" id="prof_exp_id'+intEdCount+'" value=""/><label class="control-label" for="company-name">Name of Company:</label><input class="resume-builder-input" type="text" name="company'+intEdCount+'" id="company'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="state">State:</label><input class="resume-builder-input" type="text" name="state'+intEdCount+'" id="state'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="job-title">Job Title:</label><input class="resume-builder-input" type="text" name="jobTitle'+intEdCount+'" id="jobTitle'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><div class="half-container"><label>Date start:</label><div class="datetime-container"><div class="input-group date control-label" id="datetimepicker1'+intEdCount+'"><input type="text" class="form-control" name="date-start'+intEdCount+'" id="date-start'+intEdCount+'" placeholder="10/17/2015" value="" required><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><span>&nbsp;-&nbsp;</span><div class="half-container"><label>Date end:</label><div class="datetime-container"><div class="input-group date control-label" id="datetimepicker2'+intEdCount+'"><input type="text" class="form-control" name="date-end'+intEdCount+'" id="date-end'+intEdCount+'" placeholder="10/17/2015" value="" required><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div></div><div class="form-group"><label class="control-label" for="description">Description:</label><textarea class="builder-textarea" name="description'+intEdCount+'" id="description'+intEdCount+'" rows="4"><?php echo $description;?></textarea></div><div class="form-group"><label class="control-label">Accomplishments/Impact of Accomplishments:</label><textarea name="acc1'+intEdCount+'" id="acc1'+intEdCount+'" class="builder-textarea" rows="2"></textarea><textarea name="acc2'+intEdCount+'" id="acc2'+intEdCount+'" class="builder-textarea" rows="2"></textarea><textarea name="acc3'+intEdCount+'" id="acc3'+intEdCount+'" class="builder-textarea" rows="2"></textarea></div></div>';*/
		
		
		/*var strEduRows  = '<div id="proffexpe'+intEdCount+'"><div class="form-group"><input type="hidden" name="prof_exp_id'+intEdCount+'" id="prof_exp_id'+intEdCount+'" value=""/><label class="control-label" for="company-name">Name of Company:</label><input class="resume-builder-input" type="text" name="company'+intEdCount+'" id="company'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="state">State:</label><input class="resume-builder-input" type="text" name="state'+intEdCount+'" id="state'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="job-title">Job Title:</label><input class="resume-builder-input" type="text" name="jobTitle'+intEdCount+'" id="jobTitle'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Date start:</label><select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth'+intEdCount+'" id="datemonth'+intEdCount+'"><option value="">--Select Month--</option><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear'+intEdCount+'" id="dateyear'+intEdCount+'"><option value="">--Select Year--</option>'+dateopt+'</select></div><div class="form-group"><label>Date End:</label><input style="width:auto;vertical-align:bottom;"  type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate'+intEdCount+'" id="tilldate'+intEdCount+'" />&nbsp;<label>I am presently working at this company</label>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth'+intEdCount+'" id="dateemonth'+intEdCount+'"><option value="">--Select Month--</option><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear'+intEdCount+'" id="dateeyear'+intEdCount+'"><option value="">--Select Year--</option>'+dateopt+'</select></div><div class="form-group"><label class="control-label">Accomplishments/Impact of Accomplishments:</label><textarea name="acc1'+intEdCount+'" id="acc1'+intEdCount+'" class="builder-textarea" rows="2"></textarea><textarea name="acc2'+intEdCount+'" id="acc2'+intEdCount+'" class="builder-textarea" rows="2"></textarea><textarea name="acc3'+intEdCount+'" id="acc3'+intEdCount+'" class="builder-textarea" rows="2"></textarea></div></div>';*/
		var strEduRows  = '<div id="proffexpe'+intEdCount+'"><div class="form-group"><input type="hidden" name="prof_exp_id'+intEdCount+'" id="prof_exp_id'+intEdCount+'" value=""/><label class="control-label" for="company-name">Name of Company:</label><input class="resume-builder-input" type="text" name="company'+intEdCount+'" id="company'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="state">State:</label><input class="resume-builder-input" type="text" name="state'+intEdCount+'" id="state'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="job-title">Job Title:</label><input class="resume-builder-input" type="text" name="jobTitle'+intEdCount+'" id="jobTitle'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label>Date start:</label><select class="resume-builder-input validate[required,funcCall[checkFromMonth]]" name="datemonth'+intEdCount+'" id="datemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkFromYear]]" name="dateyear'+intEdCount+'" id="dateyear'+intEdCount+'">'+dateopt+'</select></div><div class="form-group"><label><input checked="checked" style="width:auto;height:auto;vertical-align:middle;margin-top:0px;" type="checkbox" onclick="fnAdjustYearSelection(this)" name="tilldate'+intEdCount+'" id="tilldate'+intEdCount+'" />&nbsp; <span>I am presently working at this company<span></label></div><div id="dateemonthcont'+intEdCount+'" style="display:none;" class="form-group"><label>Date End:</label><select class="resume-builder-input validate[required,funcCall[checkToMonth]]" name="dateemonth'+intEdCount+'" id="dateemonth'+intEdCount+'"><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>&nbsp;<select class="resume-builder-input validate[required,funcCall[checkToYear]]" name="dateeyear'+intEdCount+'" id="dateeyear'+intEdCount+'">'+dateopt+'</select></div><div class="form-group"><label class="control-label">Accomplishments/Impact of Accomplishments:</label><textarea name="acc1'+intEdCount+'" id="acc1'+intEdCount+'" class="builder-textarea" rows="2"></textarea><textarea name="acc2'+intEdCount+'" id="acc2'+intEdCount+'" class="builder-textarea" rows="2"></textarea></div></div>';
		
		
		$('#pexp').append(strEduRows);
		$('#pexp_count').val(intEdCount);
		
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>