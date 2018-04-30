<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-1-experience-level flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<!--<h2>New Resume</h2>
					<h2><?php echo $experienceLevel['Candidate_Cv']['resume_title'];?></h2>-->
					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							

						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getExpLevel('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">1</span><!-- 

							--><span class="resume-builder-step-title">Experience &amp; Level</span>

								

						</li>



						<li class="resume-builder-step"  style="cursor:pointer;" onclick="return getContactInfo('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">2</span><!-- 

						--><span class="resume-builder-step-title">Contact Information</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCareerSum('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">3</span><!-- 

						 --><span class="resume-builder-step-title">Career Summary</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getCoreCompents('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



							<span class="resume-builder-step-icon">4</span><!-- 

						 --><span class="resume-builder-step-title">Core Competencies</span>

								

						</li>



						<li class="resume-builder-step" style="cursor:pointer;" onclick="return getMyEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



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



					<h1>Experience &amp; Level</h1>

					<p>Tell Us a Little About Yourself and we’ll match you to the best CV or resume template.</p>

						

					<form id="exp_form" action="" method="post" name="exp_form" enctype="multipart/form-data">

							

						<div class="form-group">

								<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
								<input type="hidden" name="expvalidated" id="expvalidated" value="0"/>	
								<input type="hidden" name="readytosubmit" id="readytosubmit" value="0"/>									<input type="hidden" name="rtype" id="readytosubmit" value="<?php echo rtype;?>"/>	
							<h4>Experience Level:</h4>
						
							<ul id="exp-level" class="builder-step-list">
						
								<li >

									<label for="v1" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['experience_level']=='Student'){ echo "current"; $strStudent = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="experience" id="v1" <?php echo $strStudent; ?> value="Student"><!-- 

									 --><span>Student</span>

									</label>

								</li>

								<li >

									<label for="v2" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['experience_level']=='Entrylevel'){ echo "current";$strEntry = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="experience" id="v2"  <?php echo $strEntry; ?> value="Entrylevel"><!-- 

									 --><span>Entry Level</span>

									</label>

								</li>

								<li>

									<label for="v3" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['experience_level']=='Experienced'){ echo "current";$strExped = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="experience" id="v3"  <?php echo $strExped; ?> value="Experienced"><!-- 

									 --><span>Experienced</span>

									</label>

								</li>

								<li>

									<label for="v4" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['experience_level']=='Manager'){ echo "current";$strMgr = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="experience"  id="v4" <?php echo $strMgr; ?> value="Manager"><!-- 

									 --><span>Manager/Executive</span>

									</label>

								</li>

							</ul>

						</div>

						<div class="form-group">

							<h4>Work History:</h4>



							<ul id="work-history" class="builder-step-list">

								<li >

									<label for="v5" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['work_history']=='no_experience'){ echo "current";$strnoexp = "checked='checked'";}} ?>">

										<input type="radio" name="workhistory" id="v5" <?php echo $strnoexp; ?> value="no_experience" ><!-- 

									 --><span>Little or No Experience</span>

									</label>

								</li>

								<li>

									<label for="v6" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['work_history']=='experiencedTargeted'){  echo "current";$strExpT = "checked='checked'";}} ?>">

										<input type="radio" name="workhistory" id="v6" <?php echo $strExpT; ?> value="experiencedTargeted"><!-- 

									 --><span>Experienced – Targeted Same Career</span>

									</label>

								</li>

								<li>

									<label for="v7" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['work_history']=='experiencedChanging'){ echo "current";$strExpChang = "checked='checked'";}} ?>">

										<input type="radio" name="workhistory" id="v7" <?php echo $strExpChang; ?> value="experiencedChanging"  ><!-- 

									 --><span>Experienced – Changing Careers</span>

									</label>

								</li>

								<li >

									<label for="v8" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['work_history']=='military'){ echo "current";$strExplM = "checked='checked'";}} ?>">

										<input type="radio" name="workhistory" id="v8" <?php echo $strExplM; ?> value="military"  ><!-- 

									 --><span>Transitioning from the Military</span>

									</label>

								</li>

								<li>

									<label for="v9" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['work_history']=='academia'){ echo "current";$strExpA = "checked='checked'";}} ?>">

										<input type="radio" name="workhistory" id="v9" <?php echo $strExpA; ?> value="academia"><!-- 

									 --><span>Targeting Academia</span>

									</label>

								</li>

							</ul>

			

						</div>



						<script type="text/javascript">

							$('#work-history label').click(function() {

								$('#work-history label').removeClass('current');

								$( this ).addClass('current');

							});

							$('#exp-level label').click(function() {

								$('#exp-level label').removeClass('current');

								$( this ).addClass('current');

							});

								

						</script>



						<div class="form-group">

							<button class="btn btn-primary btn-responsive btn-lg" onclick="return submitExpFrom(<?php echo $intPortalId?>,'0');">Next&nbsp;&gt;</button>

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						The Career Summary section of a CV or resume has replaced the Job Objective.  Titles vary greatly and a summary of your expertise and skills provides you with a better chance of being screened in by the automated screening systems and hiring authorities.

					</p>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);"  onclick="return submitExpFrom(<?php echo $intPortalId?>,'1');">

							<span class="builder-save-icon"></span><!-- 

						 --><span class="action-value">Save &amp; Quit</span>

						</a>



					</div>



				</div>

			</div>

		</div>

	</div>


	<?php /*

<div class="col-md-12 form-container edit-profile">
<h3>Creating a CV / Resume Never Been Easier</h3>	
<div id="alertcvMessages"></div>	
							<form id="cv_form" action="" method="post" name="cv_form" enctype="multipart/form-data" >
							<div class="form-group candidateimage">	
							<label class="control-label col-xs-12 col-sm-12 col-md-3">Resume: <span class="form-required">*</span></label>
							<div class="col-xs-12 col-sm-12  col-md-9">		
							<input id="txt_file_cv" name="txt_file_cv" type="file" class="validate[required]" style="display:none">
							<div class="input-append " >
							<div id="photoCovershow"></div>
							<a class="btn btn-default" onclick="$('input[id=txt_file_cv]').click();" style="margin-top:9px;">Upload Resume</a><small style="margin-left:10px;">256 KB max. doc,docx,pdf,rtf,txt files only</small></div> 
						
						<script type="text/javascript">
						$('input[id=txt_file_cv]').change(function() {
						
						$('#photoCovershow').html($(this).val());
						});</script>					
							</div>						
							</div>				
							<div class="form-group">	
							<label class="control-label col-xs-12 col-sm-12 col-md-3">Name your CV / Resume: <span class="form-required">*</span></label>		
						
							<input type="text" placeholder="" name="txt_title" value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										</div>			
							<div class="form-group">	
							<label class="control-label col-xs-12 col-sm-12 col-md-3 ">Add a description (optional) <span class="form-required">*</span></label>	
							
							<textarea  placeholder="" name="txt_desc"   class="col-xs-12 col-sm-12 col-md-9 validate[required]"></textarea>						
							</div>	
							<div class="form-group">		
							<div class="hidden-xs hidden-sm col-md-3"></div>	
							<div class="col-xs-12 col-sm-12 col-md-9">		
							<button class="btn btn-primary" type="button" onclick="return fnAddCv('<?php echo $intPortalId?>');" name="bt_cv_add" class="button" value="submit">Save Changes</button>		
							</div>										</div>									</form>							
	</div>
*/?>
<?php
	echo $this->element('resume_modal');
?>
<?php
	echo $this->element('font_modal');
	
?>
<script type="text/javascript">
	function checkURL(field, rules, i, options){
		var strValidated = $('#expvalidated').val();
		//alert(strValidated);
		var strExoName = "";
		var isReadyToSubmit = "";
		if(strValidated == 0)
		{
			//alert("hi");
			strExoName = $("input[name=experience]:checked").val();
			if(strExoName == undefined)
			{
				$('#expvalidated').val('1');
				$('#readytosubmit').val('0');
				return "Please choose your experience level";
			}
			else
			{
				//alert(strExoName);
				$('#expvalidated').val('1');
				$('#readytosubmit').val('1');
				return true;
			}
		}
		else
		{
			//alert("bi");
			isReadyToSubmit = $('#readytosubmit').val();
			//alert(isReadyToSubmit);
			if(isReadyToSubmit == "1")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/*var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		if(re.test(field.val())) 
		{
			return true;
		}
		else
		{
			return options.allrules.urlcheck.alertText;
		}*/
	}
</script>