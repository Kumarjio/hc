
<form action="<?php echo $strSeekerProfileUrl?>" method="post" name="account_form" enctype="multipart/form-data" id="account_form">
										
										<div class="form-group candidateimage">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Photo: <span class="form-required">*</span></label>
											<div class="col-xs-12 col-sm-12  col-md-9">
										<?php	
										if($profilePicture !="" )
										{
										?>
										<img style="float:left;" class="thumbnail" src="<?php echo Router::url('/', true);?>/assets/candidateprofile/<?php echo $profilePicture;?>"  width="200px;"/>
										<?php
										}?>
    
							
							<input id="profilePicture" name="profilePicture" type="file" style="display:none">
<div class="input-append ">
<div id="photoCover"></div>
<a class="btn btn-default" onclick="$('input[id=profilePicture]').click();">Upload Picture</a>
</div>
 
<script type="text/javascript">
$('input[id=profilePicture]').change(function() {
$('#photoCover').html($(this).val());
});
</script>



											</div>
										</div>

										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Firstname: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_fname"  value="<?php echo $profileDetail['CandidateProfile']['fname'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Surname / Last Name: <span class="form-required">*</span></label>
											 
											 <input type="text" placeholder="" name="txt_sname"  value="<?php echo $profileDetail['CandidateProfile']['sname'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
									
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line1: <span class="form-required">*</span></label>
											 <input type="text" placeholder="" name="txt_address"  value="<?php echo $profileDetail['CandidateProfile']['address'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address Line2: </label>
											 <input type="text" placeholder="" name="txt_address2"  value="<?php echo $profileDetail['CandidateProfile']['address2'];?>" class="col-xs-12 col-sm-12 col-md-9 ">
										</div>
											<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Postal / Zip Code: <span class="form-required">*</span></label>
											 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFront()" name="txt_post_code" id="txt_post_code"  value="<?php echo $profileDetail['CandidateProfile']['post_code'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
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
											 
												 <input class="text_field required" name="txtstateprovince" id="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $profileDetail['CandidateProfile']['state_province'];?>" />
								
          
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
											 <input type="text" placeholder="" name="txt_phone_number" value="<?php echo $profileDetail['CandidateProfile']['phone_number'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										<input type="hidden" name="txt_email_address" class="" value="<?php echo $profileDetail['CandidateProfile']['email_address'];?>" size="35" disabled="disabled" />
										<div class="form-group">
											<div class="hidden-xs hidden-sm col-md-3"></div>
											<div class="col-xs-12 col-sm-12 col-md-9">
												<button class="btn btn-primary" type="button" name="account_btn" value="{lang mkey='button' skey='save_my_profile'}" onclick="return fnToUpdateProfile('<?php echo $intPortalId?>');">Save Changes</button>
												
											</div>
										</div>
									</form>
									
							<script type="text/javascript">
							$('#txt_country').val('<?php echo $profileDetail['CandidateProfile']['country'];?>');
</script>							