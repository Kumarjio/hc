
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

						<li class="resume-builder-step-current" style="cursor:pointer;" onClick="return getMyPublications('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">5</span><!-- 
						 --><span class="resume-builder-step-title">Publications</span>
						</li>

						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyAwards('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">6</span><!-- 
						 --><span class="resume-builder-step-title">Awards</span>
						</li>


						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyGrants('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">7</span><!-- 
						 --><span class="resume-builder-step-title">Grants and Fellowships</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyInvites('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">8</span><!-- 
						 --><span class="resume-builder-step-title">Invited Talks</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyConference('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">9</span><!-- 
						 --><span class="resume-builder-step-title">Conference Participation</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyCampus('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">10</span><!-- 
						 --><span class="resume-builder-step-title">Campus or Depart...</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyTeaching('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">11</span><!-- 
						 --><span class="resume-builder-step-title">Teaching Experience</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyResearch('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
							<span class="resume-builder-step-icon">12</span><!-- 
						 --><span class="resume-builder-step-title">Research Experience</span>
						</li>
						
						<li class="resume-builder-step" style="cursor:pointer;" onClick="return getMyService('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">
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



					<h1>Publications</h1>

					<form name="frmpublication" id="frmpublication" method="post">
					<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>
					<?php
					$degree='';
					$institution='';
					$city='';
					$tution_percentage='';
					$education_id=0;
					$intFrCnt = 0;
					if(count($publications)>0)
					{
					   foreach($publications as $arrEdu)
					   {
						   $education_id = $arrEdu['Candidate_publications']['candidate_publication_id'];
						   $degree = $arrEdu['Candidate_publications']['subheading'];
						   $institution = $arrEdu['Candidate_publications']['citation'];
						   $city = $arrEdu['Candidate_publications']['date'];
						   $tution_percentage = $arrEdu['Candidate_publications']['page_numbers'];
						    $intFrCnt++;
						   ?>
							<div id="education<?php echo $intFrCnt;?>">
								<div class="form-group">
									<input type="hidden" name="education_id<?php echo $intFrCnt;?>" id="publication_id<?php echo $intFrCnt;?>" value="<?php echo $education_id;?>"/>	
									<label class="control-label" for="degree">Subheading:</label>
									<input class="resume-builder-input" type="text" name="degree<?php echo $intFrCnt;?>" id="degree<?php echo $intFrCnt;?>" value="<?php echo $degree;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="institution">Publication:</label>
									<input class="resume-builder-input" type="text" name="institution<?php echo $intFrCnt;?>" id="institution<?php echo $intFrCnt;?>" value="<?php echo $institution;?>" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="citation<?php echo $intFrCnt;?>">Citation:</label>
									<input class="resume-builder-input" type="text" name="citation<?php echo $intFrCnt;?>" id="citation<?php echo $intFrCnt;?>" value="<?php echo $institution;?>" placeholder="">
								</div>
								<div class="half-container">
									<label>Date:</label>
									<div class="datetime-container">
										<div class='input-group date control-label' id='datetimepicker1<?php echo $intFrCnt;?>'>
											<input type='text' class="form-control" name="date-start<?php echo $intFrCnt; ?>" id="date-start<?php echo $intFrCnt; ?>" placeholder="10/17/2015" value="<?php echo $city;?>" required>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<script>
										function tal(event){
											$('#datetimepicker1<?php echo $intFrCnt;?>').datetimepicker({
												format: 'YYYY-MM-DD'
											});
										}
										$(document).ready(function () {
											tal();
										});
									</script>
								</div>
								<div class="form-group">
									<label class="control-label" for="pagenum<?php echo $intFrCnt;?>">Page Numbers:</label>
									<input class="resume-builder-input" type="text" name="pagenum<?php echo $intFrCnt;?>" id="pagenum<?php echo $intFrCnt;?>" value="<?php echo $tution_percentage;?>" placeholder="">
								</div>
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
									<label class="control-label" for="degree">Subheading:</label>
									<input class="resume-builder-input" type="text" name="degree<?php echo $intFrCnt;?>" id="degree<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="institution">Publication:</label>
									<input class="resume-builder-input" type="text" name="publicatons<?php echo $intFrCnt;?>" id="publicatons<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="form-group">
									<label class="control-label" for="citation<?php echo $intFrCnt;?>">Citation:</label>
									<input class="resume-builder-input" type="text" name="citation<?php echo $intFrCnt;?>" id="citation<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
								<div class="half-container">
									<label>Date:</label>
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
										}
										$(document).ready(function () {
											tal();
										});
									</script>
								</div>
								<div class="form-group">
									<label class="control-label" for="pagenum<?php echo $intFrCnt;?>">Page Numbers:</label>
									<input class="resume-builder-input" type="text" name="pagenum<?php echo $intFrCnt;?>" id="pagenum<?php echo $intFrCnt;?>" value="" placeholder="">
								</div>
							</div>
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
							<button class="btn btn-default btn-responsive btn-lg" type="button" onclick="return getProfExp('<?php echo $intPortalId?>','<?php echo $resumeid;?>');">&lt;&nbsp;Prev</button>
							<button class="btn btn-primary btn-responsive btn-lg" type="button" onClick="return savePublication('<?php echo $intPortalId?>','0');">Next&nbsp;&gt;</button>
							<a href="#" onClick="return savePublication('<?php echo $intPortalId?>','0');" class="link link-default">Skip this step</a>
						</div>
					</form>
				</div>
				<div class="aside-actions-container">
					<h2>Definition</h2>
					<p>
						Forthcoming publications are also included in this section.  If your publication is in the printing stage, with the full citation and page numbers available, it may be listed the same as other publications, at the top of the list since their date is in the future.  If they are in press they can be listed in this section with “in press” listed in place of the year.
					</p>
					<p>
						There are many options on the sub-headings you will include in the Publications section of your CV which could include any of the following: Books, Book Chapters, Edited Volumes, Refereed Journal Articles, Conference Proceedings, Book Reviews, Manuscripts in Submission (provide journal title), Manuscripts in Preparation, Web-Based Publication, Other Publications – this subheading can  include non-academic publications, if relevant or applicable.
					</p>
					<div class="panel-fixed-controls">
						<a href="javascript:void(0);" onClick="return savePublication('<?php echo $intPortalId?>','1');">
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
		
		/*var strEduRows = '<div id="education'+intEdCount+'"><div class="form-group"><label class="control-label" for="degree">Degree or Certification Earned:</label><input class="resume-builder-input" type="text" name="degree'+intEdCount+'" id="degree'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="institution">Name of Institution:</label><input class="resume-builder-input" type="text" name="institution'+intEdCount+'" id="institution'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="city">City:</label><input class="resume-builder-input" type="text" name="city'+intEdCount+'" id="city'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="percentage">Percentage of Tuition Paid by Self:</label><input class="resume-builder-input" type="text" name="percentage'+intEdCount+'" id="percentage'+intEdCount+'" value="" placeholder=""></div></div>';*/
		
		var strEduRows = '<div id="education'+intEdCount+'"><div class="form-group"><label class="control-label" for="degree">Subheading:</label><input class="resume-builder-input" type="text" name="degree'+intEdCount+'" id="degree'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="institution">Publication:</label><input class="resume-builder-input" type="text" name="institution'+intEdCount+'" id="institution'+intEdCount+'" value="" placeholder=""></div><div class="form-group"><label class="control-label" for="citation'+intEdCount+'">Citation:</label><input class="resume-builder-input" type="text" name="citation'+intEdCount+'" id="citation'+intEdCount+'" value="" placeholder=""></div><div class="half-container"><label>Date:</label><div class="datetime-container"><div class="input-group date control-label" id="datetimepicker1'+intEdCount+'"><input type="text" class="form-control" name="date-start'+intEdCount+'" id="date-start'+intEdCount+'" placeholder="10/17/2015" value="" required><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div></div><div class="form-group"><label class="control-label" for="pagenum'+intEdCount+'">Page Numbers:</label><input class="resume-builder-input" type="text" name="pagenum'+intEdCount+'" id="pagenum'+intEdCount+'" value="" placeholder=""></div></div>';
		
		
		$('#education').append(strEduRows);
		$('#education_count').val(intEdCount);
		
		$('#datetimepicker1'+intEdCount).datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		if(intEdCount > 1)
		{
			$('#btnremove').show();
		}
	}
	
</script>