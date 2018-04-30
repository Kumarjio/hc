<div class="col-md-12 form-container edit-profile">
<h3>Creating a new cover letter</h3>	
<div id="alertcvMessages"></div>	
							<form id="cover_form" action="" method="post" name="cover_form" enctype="multipart/form-data" >
										
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Your Name: <span class="form-required">*</span></label>		
									<input type="text" placeholder="" name="txt_your_name" value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
								
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Address: </label>
									<input type="text" placeholder="" name="txt_your_address"  value="" class="col-xs-12 col-sm-12 col-md-9 ">
								</div>
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip / Postal Code: </label>
									 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFrontRef()" name="txt_your_post_code" id="txt_your_post_code"  value="" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
								</div>
								
								<div class="form-group">
									<?php
										//print("<pre>");
										//print_r($countrylist);
										//exit;
									?>
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Country </label>
									<select name="txt_your_country_ref" id="txt_your_country_ref" onchange="javascript: fnGetLocationDetailFromCountryRef();">
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
									
									<input class="col-xs-12 col-sm-12 col-md-9 validate[required]" name="txtyourstateprovinceref" id="txtyourstateprovinceref" type="text" size="30" maxlength="100" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['state'];?>" />
								</div>
								<div class="form-group" id="county_your_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">County / District: </label>
							
									<input name="txtyourcountyref" id="txtyourcountyref" type="text" size="30" maxlength="100" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['county'];?>"  class="col-xs-12 col-sm-12 col-md-9"/>
								</div>
							
								<div class="form-group" id="city_your_auto_ref" style="display:none">
									<label class="control-label col-xs-12 col-sm-12 col-md-3">City / Town: </label>
									 <input name="yourlocalityvalref" id="yourlocalityvalref" type="text" size="30" maxlength="100" value="" class="col-xs-12 col-sm-12 col-md-9" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['city'];?>" />
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3">Title: <span class="form-required">*</span></label>		
									<input type="hidden" id="coverid" name="coverid" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['id'];?>"/>
									<input type="text" placeholder="" name="txt_name" value="<?php echo $arrCovervDetail['CandidateCoverDetail']['cl_title'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">										
								</div>
								
								<div class="form-group">	
									<label class="control-label col-xs-12 col-sm-12 col-md-3 ">Add a description  <span class="form-required">*</span></label>	
								
									<textarea  placeholder="" name="txt_letter"   class="col-xs-12 col-sm-12 col-md-9 validate[required]"><?php echo $arrCovervDetail['CandidateCoverDetail']['cl_text'];?></textarea>						
								</div>	
								<div class="form-group">		
									<div class="hidden-xs hidden-sm col-md-3"></div>	
									<div class="col-xs-12 col-sm-12 col-md-9">		
									<button class="btn btn-primary" type="button" onclick="return fnAddCoverLetter('<?php echo $intPortalId?>');" name="bt_cv_add" class="button" value="submit">Save Changes</button>		
								</div>										</div>									</form>							
	</div>