<?php echo $this->Session->flash();?>
<div id="personal-info-panel-slider" class="panel-slider">

					<a href="#personal-info" class="panel-slider-item" data-toggle="collapse" data-parent="#personal-info-panel-slider">
						<div class="panel-slider-item-header">
							<!--<h3>Personal Information</h3>-->
							<span class="icon-indicator"></span>
						</div>
					</a>
		
					<div class="collapse in" id="personal-info" data-parent="#personal-info-panel-slider">
						<div class="col-md-12 form-container">
							<form action="<?php echo $strSeekerProfileUrl?>" method="post" name="applyform" enctype="multipart/form-data" id="applyform">
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3" for="first-name">First Name:</label>
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" type="text" name="first-name" id="first-name" value="<?php echo $arrLoggedUser['candidate_first_name'];?>">
								</div>
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3" for="last-name">Surname / Last Name:</label>
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" type="text" name="last-name" id="last-name" value="<?php echo $arrLoggedUser['candidate_last_name'];?>">
								</div>
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3" for="email">Email Address: <span class="form-required">*</span></label>
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" type="text" name="txt_email" id="txt_email" value="<?php echo $arrLoggedUser['candidate_email'];?>" required>
								</div>
									
										
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3" for="select-resume">Select Resume: </label>
									 <select name="txt_existed_cv" id="txt_existed_cv" class="form-control validate[required]">
										  <?php 
										  foreach($arrCvDetail as $cvvalue)
										  {
										     $cvdetail_id = $cvvalue['Candidate_Cv']['candidatecv_id'];
											 $cvdetail_tile = $cvvalue['Candidate_Cv']['resume_title'];
											 ?>
											  <option value="<?php echo $cvdetail_id?>"><?php echo $cvdetail_tile?></option>
											  <?php
										  }
										  ?>
										</select>
									
								</div>
								
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3" for="email">Comment: <span class="form-required">*</span></label>
									<textarea rows="5" name="comment" id="comment" class="col-xs-12 col-sm-12 col-md-9"></textarea>
								</div>

								<div class="form-group">
									<div class="hidden-xs hidden-sm col-md-3"></div>
									<div class="col-xs-12 col-sm-12 col-md-9">
										<!--<button type="submit" class="btn btn-primary" onclick="return validateApplfrm();" name="submit">Save Changes</button>-->
										
										<button type="submit" class="btn btn-primary" onclick="return fnValidateApp();" name="submit">Save Changes</button>
										<button type="button" class="btn btn-default">Cancel</button>
									</div>
								</div>			
										
							</form>
						</div>

					</div>
				</div>
<script type="text/javascript">
	function fnValidateApp()
	{
		var isValidated = jQuery('#applyform').validationEngine('validate');
		return isValidated;
	}
</script>

				<?php /*
<div style="margin-top:10px;" >
<?php echo $this->Session->flash();?>
<form action="<?php echo $strSeekerProfileUrl?>" method="post" name="applyform" enctype="multipart/form-data" id="applyform">
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Email Address <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_email"  value="<?php echo $profileDetail['CandidateProfile']['address'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										 
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Select your working status in the GB <span class="form-required">*</span></label>
										  <select name="txt_working_status" id="txt_working_status">
										  <option value="#CITIZEN# Citizen">UK/EU Citizen</value>
										  <option value="Work Permit Holder">Work Permit Holder</value>
										  <option value="Sponsorship Required">Sponsorship Required</value>
										</select>
										</div>
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"></label>
										  <select name="txt_which_letter" id="txt_which_letter">
										   <option value="">New Cover Letter</option>
										  <?php 
										  foreach($arrCoverDetail as $coverkey=>$covervalue)
										  {
										     $coverdetail_id = $coverkey;
											 $coverdetail_tile = $covervalue;
											 ?>
											  <option value="<?php echo $coverdetail_id?>"><?php echo $coverdetail_tile?></option>
											  <?php
										  }
										  ?>
										</select>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Cover Letter<span class="form-required">*</span></label>
										<textarea rows="5" cols="40" id="txt_letter" class="text_fields validate[required]" name="txt_letter"></textarea>
										</div>
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Select Exiting Resume <span class="form-required">*</span></label>
										  <select name="txt_existed_cv" id="txt_existed_cv">
										  <option value="">New Cv</option>
										  <?php 
										  foreach($arrCvDetail as $cvkey=>$cvvalue)
										  {
										     $cvdetail_id = $cvkey;
											 $cvdetail_tile = $cvvalue;
											 ?>
											  <option value="<?php echo $cvdetail_id?>"><?php echo $cvdetail_tile?></option>
											  <?php
										  }
										  ?>
										</select>
										</div>
										<div class="form-group candidateimage">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Upload Resume <span class="form-required">*</span></label>
											<div class="col-xs-12 col-sm-12  col-md-9">
										<?php	
										if($profilePicture !="" )
										{
										?>
										<img style="float:left;" class="thumbnail" src="<?php echo Router::url('/', true);?>/assets/candidateprofile/<?php echo $profilePicture;?>"  width="200px;"/>
										<?php
										}?>
    
							
							<input id="txt_cv" name="txt_cv" type="file" style="display:none">
<div class="input-append ">
<div id="photoCover"></div>
<a class="btn btn-default" onclick="$('input[id=txt_cv]').click();">Upload Resume/Cv</a>
</div>
 
<script type="text/javascript">
$('input[id=txt_cv]').change(function() {
$('#photoCover').html($(this).val());
});
</script>



											</div>
										</div>

										To further your application you may also wish to complete the following optional questions
										
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Firstname: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_fname"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_sname"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Mobile Telephone Number: <span class="form-required">*</span></label>
											 <input type="text" placeholder=""  name="txt_tel" id="txt_tel"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"> Mobile No : <span class="form-required">*</span></label>
											 <input type="text" placeholder=""  name="txt_mob" id="txt_mob"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Availability/Notice </label>
										 <select class="text_fields" id="txt_notice" name="txt_notice">
								<option value=""></option>
								<option value="Immediate" label="Immediate">Immediate</option>
					<option value="1 Week" label="1 Week">1 Week</option>
					<option value="2 Weeks" label="2 Weeks">2 Weeks</option>
					<option value="3 Weeks" label="3 Weeks">3 Weeks</option>
					<option selected="selected" value="1 Month" label="1 Month">1 Month</option>
					<option value="3 Months" label="3 Months">3 Months</option>
					<option value="> 3 Months" label="> 3 Months">> 3 Months</option>

							</select>
										</div>
										
										<div class="form-group" id="stateprovince_auto">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"> 	Hourly Rate </label>
											 
												<select class="text_fields" id="txt_salary" name="txt_salary">
            <option value=""></option>
				<option selected="selected" value="0-10000" label="$0-$10000">$0-$10000</option>
<option value="10000-12000" label="$10000-$12000">$10000-$12000</option>
<option value="12000-15000" label="$12000-$15000">$12000-$15000</option>
<option value="15000-17000" label="$15000-$17000">$15000-$17000</option>
<option value="17000-20000" label="$17000-$20000">$17000-$20000</option>
<option value="20000-30000" label="$20000-$30000">$20000-$30000</option>
<option value="30000-50000" label="$30000-$50000">$30000-$50000</option>
<option value="50000+" label="$50000+">$50000+</option>

        </select>
          
										</div>
											
									<div class="form-group" id="stateprovince_auto">
											<label class="control-label col-xs-12 col-sm-12 col-md-3"> 	 	Approximately how far are you willing to travel to work (in miles) ?  </label>
											 
												<select class="text_fields" id="txt_willing_to_travel" name="txt_willing_to_travel">
            <option value=""></option>
            <option value="Up to 5" label="Up to 5">Up to 5</option>
<option selected="selected" value="Up to 15" label="Up to 15">Up to 15</option>
<option value="Up to 30" label="Up to 30">Up to 30</option>
<option value="Up to 50" label="Up to 50">Up to 50</option>
<option value="50+" label="50+">50+</option>

        </select>
          
										</div>
									
											
										
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="submit" name="submit" value="{lang mkey='button' skey='save_my_profile'}" onclick="return validateApplfrm();" >Save Changes</button>
												
											</div>
										</div>
									</form>
									
							</div>
							*/?>