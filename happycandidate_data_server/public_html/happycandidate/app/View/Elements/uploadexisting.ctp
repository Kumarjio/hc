<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-10-general-information flex-fix">

					

				<div class="aside-steps-container bg-lightest-grey">

						

					<h2>Upload Existing Resume</h2>

				</div><!-- 



			 --><div class="content-step">



					<h1>Existing Resume</h1>

						

					<form name="existingResumeTitle" id="existingResumeTitle" method="post" enctype="multipart/form-data">

							
						<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
						<div class="form-group">
							<label class="control-label" for="resume-title">Resume title:</label>

							<input class="resume-builder-input" type="text" name="existing_resume_title_name" id="existing_resume_title_name" value="<?php echo $resume_title; ?>" placeholder="">

						

						</div>

						<div class="form-group">
							<label class="control-label" for="resume-title">Attach Your Resume:</label>
							<input type="file" class="resume-builder-input" name="existing_resume_title" id="existing_resume_title">
						</div>
						
						<?php
							if($resume_path)
							{
								$strFilePath = Router::url('/',true)."candidate_cv/".$resume_path;
								?>
									<div class="form-group">
										<a href="<?php echo $strFilePath; ?>" target="_blank"><label class="control-label" for="resume-title">Your Existing Resume</label></a>
									</div>
								<?php
							}
						?>
						 
						<div class="form-group">
							<button class="btn btn-primary btn-responsive btn-lg" onClick="return saveExistingResume('<?php echo $intPortalId?>');" type="button">Save &amp; Continue&nbsp;&gt;</button>
						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						Resume title helps to find necessary resume quickly. It can be useful when you have a large list of saved documents.

					</p>



					<div class="panel-fixed-controls">

							

						<a href="javascript:void(0);" onClick="return saveExistingResume('<?php echo $intPortalId?>');">

							<span class="builder-save-icon"></span><!-- 

						 --><span class="action-value">Save &amp; Quit</span>

						</a>



					</div>



				</div>

			</div>

		</div>

	</div>

	