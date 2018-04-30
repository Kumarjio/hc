	<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey resume-builder-welcome-v2">
				
				<h3>Welcome to CV and Resume Builder!</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

				<div class="col-md-2">
					
				</div>
				<div class="col-md-4 createnew">
					<a href="#" id="createnew" >
						<div class="block-container">
							<span class="resume-builder-icon icon-pencil"></span>
							<h4>Create New</h4>
						</div>
					</a>
				</div>

				

				<div class="col-md-4 upload_existing">
					<a href="#" id="upload_existing">
						<div class="block-container">
							<span class="resume-builder-icon icon-plus"></span>
							<h4>Upload Existing</h4>
						</div>
					</a>
				</div>
				<input type="hidden" name="ctype" id="ctype">
				<div class="col-md-2">
					
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-responsive btn-lg" onclick="return fnCongoCv('<?php echo $intPortalId?>');">Continue&nbsp;&gt;</button>
				</div>

			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
<?php /*
<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-1-experience-level flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<h2>New Resume</h2>



					<ul class="resume-builder-steps-list">

							

						<li class="resume-builder-step-current">



							<span class="resume-builder-step-icon">1</span><!-- 

						 --><span class="resume-builder-step-title">Experience &amp; Level</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">2</span><!-- 

						 --><span class="resume-builder-step-title">Contact Information</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">3</span><!-- 

						 --><span class="resume-builder-step-title">Career Summary</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">4</span><!-- 

						 --><span class="resume-builder-step-title">Core Competencies</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">5</span><!-- 

						 --><span class="resume-builder-step-title">Education</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">6</span><!-- 

						 --><span class="resume-builder-step-title">Professional Experience</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">7</span><!-- 

						 --><span class="resume-builder-step-title">Professional Affiliations</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">8</span><!-- 

						 --><span class="resume-builder-step-title">Awards</span>

								

						</li>



						<li class="resume-builder-step">



							<span class="resume-builder-step-icon">9</span><!-- 

						 --><span class="resume-builder-step-title">Community Involvement</span>

								

						</li>



					</ul>



					<div class="adv-container">

							

						<a href="#">

							<h3>View Resume</h3>

							<p>In Progress</p>



							<img src="<?php echo Router::url('/',true);?>images/resume-builder-icon.png" alt="image description">



							<span class="ad-hover"></span>

						</a>



					</div>



				</div><!-- 



			 --><div class="content-step">



					<h1>Experience &amp; Level</h1>

					<p>Tell Us a Little About Yourself and we’ll match you to the best resume template.</p>

						

					<form>

							

						<div class="form-group">

								

							<h4>Experience Level:</h4>



							<ul id="exp-level" class="builder-step-list">

								<li>

									<label for="v1" class="current">

										<input type="radio" name="rad" id="v1" checked value="Student"> <!-- 

									 --><span>Student</span>

									</label>

								</li>

								<li>

									<label for="v2">

										<input type="radio" name="rad" id="v2" value="Entrylevel"><!-- 

									 --><span>Entry Level</span>

									</label>

								</li>

								<li>

									<label for="v3">

										<input type="radio" name="rad" id="v3" value="Experienced"><!-- 

									 --><span>Experienced</span>

									</label>

								</li>

								<li>

									<label for="v4">

										<input type="radio" name="rad" id="v4" value="Manager"><!-- 

									 --><span>Manager/Executive</span>

									</label>

								</li>

							</ul>

						</div>

						<div class="form-group">

							<h4>Work History:</h4>



							<ul id="work-history" class="builder-step-list">

								<li>

									<label for="v5" class="current">

										<input type="radio" name="rad-1" id="v5" checked><!-- 

									 --><span>Little or No Experience</span>

									</label>

								</li>

								<li>

									<label for="v6">

										<input type="radio" name="rad-1" id="v6"><!-- 

									 --><span>Experienced – Targeted Same Career</span>

									</label>

								</li>

								<li>

									<label for="v7">

										<input type="radio" name="rad-1" id="v7"><!-- 

									 --><span>Experienced – Changing Careers</span>

									</label>

								</li>

								<li>

									<label for="v8">

										<input type="radio" name="rad-1" id="v8"><!-- 

									 --><span>Transitioning from the Military</span>

									</label>

								</li>

								<li>

									<label for="v9">

										<input type="radio" name="rad-1" id="v9"><!-- 

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

							<button class="btn btn-primary btn-responsive btn-lg">Next&nbsp;&gt;</button>

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						The Career Summary section of a CV or resume has replaced the Job Objective.  Titles vary greatly and a summary of your expertise and skills provides you with a better chance of being screened in by the automated screening systems and hiring authorities.

					</p>



					<div class="panel-fixed-controls">

							

						<a href="#">

							<span class="builder-save-icon"></span><!-- 

						 --><span class="action-value">Save &amp; Quit</span>

						</a>



					</div>



				</div>

			</div>

		</div>

	</div>

	

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
	
	<script type="text/javascript">
	$('#createnew').click(function()
	{
	
	$('.createnew  .block-container').css('background-color','#eef8ff');
	$('.createnew .block-container').css('border','2px solid #1684c9');
	
	$('.upload_existing  .block-container').css('background-color','#fff');
	$('.upload_existing .block-container').css('border','1px solid #ddd');
	$('#ctype').val('new');
	});
	
	$('#upload_existing').click(function()
	{
	
		$('.upload_existing  .block-container').css('background-color','#eef8ff');
		$('.upload_existing .block-container').css('border','2px solid #1684c9');
		$('.createnew  .block-container').css('background-color','#fff');
		$('.createnew .block-container').css('border','1px solid #ddd');
		$('#ctype').val('existing');
	});
	
	
	</script>