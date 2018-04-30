<div class="container-fluid">



		<div class="row bg-lightest-grey">

			

			<div class="col-md-12 resume-builder-1-experience-level flex-fix">
			 <div class="content-step">



					<h1>Choose Resume</h1>

					<p>Tell Us a Little About Yourself and we’ll match you to the best CV or resume template.</p>

						

					<form id="typ_form" action="" method="post" name="typ_form" enctype="multipart/form-data">

							

						<div class="form-group">

								<input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resumeid;?>"/>	
								<input type="hidden" name="expvalidated" id="expvalidated" value="0"/>	
								<input type="hidden" name="readytosubmit" id="readytosubmit" value="0"/>	
							<h4>Resume Type:</h4>
						
							<ul id="exp-level" class="builder-step-list">
						
								<li>

									<label for="v1" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['mode']=='chronological'){ echo "current"; $strStudent = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="rtype" id="v1" <?php echo $strStudent; ?> value="chronological"><!-- 

									 --><span>Chronological Resume</span>

									</label>

								</li>

								<li>

									<label for="v2" class="<?php if(count($experienceLevel)>0){if($experienceLevel['Candidate_Cv']['mode']=='functional'){ echo "current";$strEntry = "checked='checked'";}} ?>">

										<input type="radio" class="validate[funcCall[checkURL]]" name="rtype" id="v2"  <?php echo $strEntry; ?> value="functional"><!-- 

									 --><span>Functional Resume</span>

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

							<button class="btn btn-primary btn-responsive btn-lg" onclick="return submitTypFrom(<?php echo $intPortalId?>,'0');">Next&nbsp;&gt;</button>

						</div>



					</form>

				</div>



				<div class="aside-actions-container">

						

					<h2>Definition</h2>



					<p>

						The Career Summary section of a CV or resume has replaced the Job Objective.  Titles vary greatly and a summary of your expertise and skills provides you with a better chance of being screened in by the automated screening systems and hiring authorities.

					</p>
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
<script type="text/javascript">
	function checkURL(field, rules, i, options){
		var strValidated = $('#expvalidated').val();
		//alert(strValidated);
		var strExoName = "";
		var isReadyToSubmit = "";
		if(strValidated == 0)
		{
			//alert("hi");
			strExoName = $("input[name=rtype]:checked").val();
			if(strExoName == undefined)
			{
				$('#expvalidated').val('1');
				$('#readytosubmit').val('0');
				return "Please choose resume type";
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
	}
</script>