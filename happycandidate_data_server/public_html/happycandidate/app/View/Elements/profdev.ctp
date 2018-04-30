
	<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-5-education flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<?php
						echo $this->element('resume_title');
					?>



					<ul class="resume-builder-steps-list" style="padding:0px;">

							
<li class="resume-builder-step" onclick="return getContactInfof('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">1</span><!-- 

										 --><span class="resume-builder-step-title"><s>Contact Information</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getCareerSumf('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">2</span><!-- 

										 --><span class="resume-builder-step-title"><s>Career Summary</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getCoreCompentsf('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">3</span><!-- 

										 --><span class="resume-builder-step-title"><s>Core Competencies</s></span>

												

										</li>



										<li class="resume-builder-step" onclick="return getMyEducationF('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">4</span><!-- 

										 --><span class="resume-builder-step-title"><s>Summary Of Skills</s>s</span>

												

										</li>



										<li class="resume-builder-step" onclick="return getWokExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">5</span><!-- 

										 --><span class="resume-builder-step-title"><s>Work Experience</s></span>

												

										</li>
										
										<li class="resume-builder-step" onclick="return getFEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">6</span><!-- 

										 --><span class="resume-builder-step-title"><s>Education</s></span>

												

										</li>



										<li class="resume-builder-step-current" onclick="return getProfDev('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">



											<span class="resume-builder-step-icon">7</span><!-- 

										 --><span class="resume-builder-step-title">Professional Development</span>

												

										</li>

										<li class="resume-builder-step" >



											<span class="resume-builder-step-icon">8</span><!-- 

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



					<h1>Professional Development</h1>
					<p>Please list your skills separated by a comma:</p>

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
						   $education_id = $arrEdu['Proffdev']['candidate_education_id'];
						   $degree = $arrEdu['Proffdev']['skillarea'];
						   $institution = $arrEdu['Proffdev']['acc'];
						   $city = $arrEdu['Proffdev']['city'];
						   $tution_percentage = $arrEdu['Proffdev']['tution_percentage'];
						   $fromYear = $arrEdu['Proffdev']['year'];
						   $state = $arrEdu['Proffdev']['state'];
						    $intFrCnt++;
						   ?>
							<div id="education<?php echo $intFrCnt;?>">
								<div class="form-group">
									<label class="control-label" for="institution">Heading:</label>
									<input class="resume-builder-input" type="text" name="skillarea<?php echo $intFrCnt;?>" id="skillarea<?php echo $intFrCnt;?>" value="<?php echo $degree;?>" placeholder="">									
								</div>
								<div class="form-group">
									<input type="hidden" name="education_id<?php echo $intFrCnt;?>" id="education_id<?php echo $intFrCnt;?>" value="<?php echo $education_id;?>"/>										<label class="control-label" for="degree">Accomplishments or experiences:</label>
									<textarea name="institution<?php echo $intFrCnt;?>" id="institution<?php echo $intFrCnt;?>" class="builder-textarea" rows="4"><?php echo $institution; ?></textarea>
								</div>
								<p style="margin-top:15px;"><i>Example:</i></p>
								<p style="margin-top:15px;"><i>Sales, Sales Management, Prospecting, Cold Calling, Presentation Skills</i></p>
								
								
							</div>
						   <?php
						  
					   }
					}
					else
					{
						$intFrCnt++;
						?>
							<div id="education<?php echo $intFrCnt;?>">
								<div class="form-group">
								<label class="control-label" for="institution">Heading:</label>									
								<input class="resume-builder-input" type="text" name="skillarea<?php echo $intFrCnt;?>" id="skillarea<?php echo $intFrCnt;?>" value="" placeholder="">																	</div>								
								<div class="form-group">									
								<label class="control-label" for="degree">Accomplishments or experiences:</label>																		<textarea name="institution<?php echo $intFrCnt;?>" id="institution<?php echo $intFrCnt;?>" class="builder-textarea" rows="4"></textarea>								</div>
							</div>
							<p style="margin-top:15px;"><i>Example:</i></p>
							<p style="margin-top:15px;"><i>Sales, Sales Management, Prospecting, Cold Calling, Presentation Skills</i></p>
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
							<button class="btn btn-default btn-responsive btn-lg" type="button" onclick="return getFEducation('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return saveProfDev('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" onClick="return saveProfDev('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						Lastly, add in any other headings that you think will sell or highlight your experience.  Feel free to get creative, but remember that everything listed on your resume should have a professional or career value. Some options you might consider:
					</p>
					<ul>
						<li>
							Education
						</li>
						<li>
							Professional Affiliations
						</li>
						<li>
							Projects Completed
						</li>
						<li>
							Professional development courses or continuing education
						</li>
						<li>
							Community involvement
						</li>
						<li>
							Articles published
						</li>
						<li>
							Technical Skills
						</li>
					</ul>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return saveProfDev('<?php echo $intPortalId?>','1');">
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
		var dateopt = '<?php echo $strHtml; ?>';
		
		var strEduRows = '<div id="education'+intEdCount+'"><div class="form-group"><label class="control-label" for="institution">Heading:</label><input class="resume-builder-input" type="text" name="skillarea'+intEdCount+'" id="skillarea'+intEdCount+'" value="<?php echo $degree;?>" placeholder=""></div><div class="form-group"><label class="control-label" for="degree">Accomplishments or experiences:</label><textarea name="institution'+intEdCount+'" id="institution'+intEdCount+'" class="builder-textarea" rows="4"></textarea></div><p style="margin-top:15px;"><i>Example:</i></p><p style="margin-top:15px;"><i>Sales, Sales Management, Prospecting, Cold Calling, Presentation Skills</i></p></div>';
		
		
		$('#education').append(strEduRows);
		$('#education_count').val(intEdCount);
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
$(document).ready(function() {
	$( "ul.resume-builder-steps-list" ).children().css( "cursor", "pointer" );
}); 
	
</script>