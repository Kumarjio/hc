


<form action="" method="post" name="contentform" enctype="multipart/form-data" id="contentform">
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Username: <span class="form-required">*</span></label>
											 
											 <label><?php echo $arrEmployerDetail[0]['Employer']['employer_uname'];?></label>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Email Address: <span class="form-required">*</span></label>
											
											 <label><?php echo $arrEmployerDetail[0]['Employer']['employer_email'];?></label>
											 <!--<input type="text" placeholder="" name="eemail"  id="eemail" value="<?php echo $arrEmployerDetail[0]['Employer']['employer_email'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">-->
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Firstname: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_fname"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_user_fname'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_sname"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_user_lname'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Company Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="cname"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_company_name'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line1: <span class="form-required">*</span></label>
											 <textarea name="txt_address" id="txt_address" style="width:60%;" class="builder-textarea col-xs-12 col-sm-12 col-md-9 validate[required]"><?php echo $arrEmployerDetail[0]['Employer']['employer_address'];?></textarea>
											 
											 <!--<input type="text" placeholder="" name="txt_address"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_address'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">-->
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line2: </label>
											 <textarea name="txt_address2" id="txt_address2" style="width:60%;" class="builder-textarea col-xs-12 col-sm-12 col-md-9 validate[required]"><?php echo $arrEmployerDetail[0]['Employer']['address2'];?></textarea>
											
											<!--<input type="text" placeholder="" name="txt_address2"  value="" class="col-xs-12 col-sm-12 col-md-9 ">-->
										</div>
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Postal / Zip Code: <span class="form-required">*</span></label>
											 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFront()" name="txt_post_code" id="txt_post_code"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_pin'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Country <span class="form-required">*</span></label>
										  <select name="txt_country" id="txt_country" onchange="javascript: fnGetLocationDetailFromCountry();">
										  <?php
									
											foreach($countrylist as $countryid=>$country)
											{
											 $cntname = $country;
											 $id = $countryid;
											?>
											<option value="<?php echo $id;?>"><?php echo $cntname;?></option>
											<?php
											}
											?>
										</select>
										</div>
										
										<div class="form-group" id="stateprovince_auto">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">State / Province / Region: <span class="form-required">*</span></label>
											 
												 <input class="text_field required" name="txtstateprovince" id="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $arrEmployerDetail[0]['Employer']['employer_state'];?>" />
								
          
										</div>
											<div class="form-group" id="county_auto" style="display:none">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">County / District: </label>
									
										<input name="txtcounty" id="txtcounty" type="text" size="30" maxlength="100" value=""  class="col-xs-12 col-sm-12 col-md-9"/>
									 
									</div>
									
									<div class="form-group" id="city_auto" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">City / Town: </label>
									
									
									  
										 <input name="txtcity" id="localityval" type="text" size="30" maxlength="100" value="" class="col-xs-12 col-sm-12 col-md-9" />
									 
									</div>
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Mobile Telephone Number <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_phone_number" value="<?php echo $arrEmployerDetail[0]['Employer']['employer_contact_number'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="submit" name="account_btn" onclick="return fnCheckEmployer();" value="{lang mkey='button' skey='save_my_profile'}">Save Changes</button>
												
											</div>
										</div>
									</form>
									
							<script type="text/javascript">
								$(document).ready(function () {
									$('#txt_country').val('<?php echo $arrEmployerDetail[0]['Employer']['employer_country'];?>');
								});
							</script>
<script type="text/javascript">
	function fnCheckEmployer()
	{
		var isValidated = $('#contentform').validationEngine('validate');
		if(isValidated == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
</script>