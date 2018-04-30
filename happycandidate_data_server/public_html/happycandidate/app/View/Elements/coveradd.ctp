<div class="col-md-12 form-container edit-profile">
<h3>Creating a new cover letter</h3>	
<div id="alertcvMessages"></div>	
							<form id="cover_form" action="" method="post" name="cover_form" enctype="multipart/form-data" >
							
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Letter Title: <span class="form-required">*</span></label>
									<input type="hidden" name="coverid" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['id']; ?>">										
									<input type="text" placeholder="" name="txt_letter_title" id="txt_letter_title" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['cover_title']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
										
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Your Name: <span class="form-required">*</span></label>		
									<input type="text" placeholder="" name="txt_your_name" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['name']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
								
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Address: </label>
									<input type="text" placeholder="" name="txt_your_address"  value="<?php echo $arrCovervDetail['CandidateCoverDetail']['address']; ?>" class="col-xs-12 col-sm-12 col-md-9 ">
								</div>
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip / Postal Code: </label>
									 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFrontCov()" name="txt_your_post_code" id="txt_your_post_code"  value="<?php echo $arrCovervDetail['CandidateCoverDetail']['zipcode']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
								</div>
								
								<div class="form-group">
									<?php
										//print("<pre>");
										//print_r($countrylist);
										//exit;
									?>
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Country </label>
									<select name="txt_your_country_ref" id="txt_your_country_ref" onchange="javascript: fnGetLocationDetailFromCountryCov();">
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
									<label class="control-label col-xs-12 col-sm-12 col-md-3">State / Province / Region: </label>
									
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" name="txtyourstateprovinceref" id="txtyourstateprovinceref" type="text" size="30" maxlength="100" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['state']; ?>" />
								</div>
								<div class="form-group" id="county_your_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">County / District: </label>
							
									<input name="txtyourcountyref" id="txtyourcountyref" type="text" size="30" maxlength="100" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['county']; ?>"  class="col-xs-12 col-sm-12 col-md-9"/>
								</div>
							
								<div class="form-group" id="city_your_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">City / Town: </label>
									 <input name="yourlocalityvalref" id="yourlocalityvalref" type="text" size="30" maxlength="100" value="" class="col-xs-12 col-sm-12 col-md-9" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['city']; ?>" />
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Name: <span class="form-required">*</span></label>		
									<input type="text" placeholder="" name="txt_emp_name" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['ename']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Title: <span class="form-required">*</span></label>		
									<select name="emp_salutation" id="emp_salutation" class="validate[required]">
										<option value="Mr.">Mr.</option>
										<option value="Mrs.">Mrs.</option>
										<option value="Miss.">Miss.</option>
									</select>										
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Company: <span class="form-required">*</span></label>		
									<input type="text" placeholder="" name="txt_emp_comp" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['ecomp']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
								
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Address: </label>
									<input type="text" placeholder="" name="txt_emp_address"  value="<?php echo $arrCovervDetail['CandidateCoverDetail']['eaddress']; ?>" class="col-xs-12 col-sm-12 col-md-9 ">
								</div>
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Zip / Postal Code: </label>
									 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFrontCovEmp()" name="txt_emp_post_code" id="txt_emp_post_code"  value="<?php echo $arrCovervDetail['CandidateCoverDetail']['ezipcode']; ?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
								</div>
								
								<div class="form-group">
									<?php
										//print("<pre>");
										//print_r($countrylist);
										//exit;
									?>
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer Country </label>
									<select name="txt_emp_country_ref" id="txt_emp_country_ref" onchange="javascript: fnGetLocationDetailFromCountryCovEmp();">
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
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer State / Province / Region: </label>
									
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" name="txtempstateprovinceref" id="txtempstateprovinceref" type="text" size="30" maxlength="100" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['estate']; ?>" />
								</div>
								<div class="form-group" id="county_emp_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer County / District: </label>
							
									<input name="txtempcountyref" id="txtempcountyref" type="text" size="30" maxlength="100" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['ecounty']; ?>"  class="col-xs-12 col-sm-12 col-md-9"/>
								</div>
							
								<div class="form-group" id="city_emp_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Employer City / Town: </label>
									 <input name="emplocalityvalref" id="emplocalityvalref" type="text" size="30" maxlength="100" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['ecity']; ?>" class="col-xs-12 col-sm-12 col-md-9"/>
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3 ">Letter Content:  <span class="form-required validate[required]">*</span></label>	
								
									<textarea  placeholder="" name="txt_letter"   class="col-xs-12 col-sm-12 col-md-9 validate[required]"><?php echo $arrCovervDetail['CandidateCoverDetail']['cl_text']; ?></textarea>						
								</div>
								
								<div class="form-group">		
									<div class="hidden-xs hidden-sm col-md-3"></div>	
									<div class="col-xs-12 col-sm-12 col-md-9">		
									<button class="btn btn-primary" type="button" onclick="return fnAddCoverLetter('<?php echo $intPortalId?>');" name="bt_cv_add" class="button" value="submit">Save Changes</button>		
								</div>										</div>									</form>							
	</div>
<?php
	$countryNew = "";
	if($arrCovervDetail['CandidateCoverDetail']['ecountry'])
	{
		$countryNew = $arrCovervDetail['CandidateCoverDetail']['ecountry'];
	}
	
	$countryYNew = "";
	if($arrCovervDetail['CandidateCoverDetail']['country'])
	{
		$countryYNew = $arrCovervDetail['CandidateCoverDetail']['country'];
	}
	
	$strTitle = "";
	if($arrCovervDetail['CandidateCoverDetail']['cl_title'])
	{
		$strTitle = $arrCovervDetail['CandidateCoverDetail']['cl_title'];
	}
	
?>
<script type="text/javascript">
$(document).ready(function () {
	$('#emp_salutation').val('<?php echo $strTitle;?>');
	
	$('#txt_emp_country_ref').val('<?php echo $countryNew;?>');
	$('#txt_emp_country_ref option[value=CA]').insertBefore('#txt_emp_country_ref option:first-child');
	$('#txt_emp_country_ref option[value=US]').insertBefore('#txt_emp_country_ref option:first-child');

	$('#txt_your_country_ref').val('<?php echo $countryYNew;?>');
	$('#txt_your_country_ref option[value=CA]').insertBefore('#txt_your_country_ref option:first-child');
	$('#txt_your_country_ref option[value=US]').insertBefore('#txt_your_country_ref option:first-child');
});
</script>