<script type="text/javascript">
	function addRefrence()
{				
			var isFormValidated = $("#reference_add_edit").validationEngine('validate');			
			if(isFormValidated == false)
			{
				return false;
			}
			else
			{
				$('#loader').show();
				var intPortalId = <?php echo $intPortalId;?>;
				
				var referenceformurl = '<?php echo Router::url('/', true).$this->params['controller']?>/modify/'+intPortalId;
				var referenceformtype = "POST";
				var referenceformoptions = { 
					beforeSubmit:  function(formData, jqForm, options) {
					},
					success:function(responseText, statusText, xhr, $form) {
						//alert(responseText);
						if(responseText.status == "success")
						{
							$('#tab-references').html(responseText.contactshtml);
						}
						else
						{
							
							$('#reference_operation_message').css('color','red');
							$('#reference_operation_message').html(responseText.message);
							$('#reference_operation_message').fadeIn('slow');
						}
						
					},								
					url:       referenceformurl,         // override for form's 'action' attribute 
					type:      referenceformtype,        // 'get' or 'post', override for form's 'method' attribute 
					dataType:  'json'        			// 'xml', 'script', or 'json' (expected server response type) 
				}
				$('#reference_add_edit').ajaxSubmit(referenceformoptions);
				return false;
			}
		
	}
	</script>
					<div class="tab-header">
							<h3><?php echo ($strHeader)?$strHeader:"Add"; ?> Reference</h3><!--
							--><button type="button" class="btn btn-primary btn-sm">Add New</button>
						</div>

						<!--Edit reference PILL DYN-->			
						<div id="user-reference-panel-slider" class="panel-slider">
							<a href="#user-reference" class="panel-slider-item" data-toggle="collapse" data-parent="#user-reference-panel-slider">
								<div class="panel-slider-item-header">
									<h3>Reference</h3>
									<span class="icon-indicator"></span>
								</div>
							</a>
							<!--submenu-->			
							<div class="collapse" id="user-reference" data-parent="#user-reference-panel-slider">
								<div class="col-md-12 form-container edit-reference">
									<form role="form" name="reference_add_edit" id="reference_add_edit">
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3" for="reference-name">Name: <span class="form-required">*</span></label>
											<input class="col-xs-12 col-sm-12 col-md-9 validate[required,custom[onlyLetterSp]]" type="text"type="text" name="reference_name" id="reference_name"   value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['reference_name']?>" placeholder="Matthew Connelly">
											<input type="hidden" name="edit_reference_id" id="edit_reference_id" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['candidate_reference_id']?>" />
										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3" for="company-name">Company: <span class="form-required">*</span></label>
											<input class="col-xs-12 col-sm-12 col-md-9 validate[required,custom[onlyLetterSp]]" type="text"  value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['reference_company_name']?>" name="company_name" id="company_name" placeholder="Matrix Marketing" required>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3" for="job-title">Job Title: <span class="form-required">*</span></label>
											<input class="col-xs-12 col-sm-12 col-md-9 validate[required,custom[onlyLetterSp]]" type="text" name="job_title" id="job_title" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['reference_job_title']?>" placeholder="CEO" required>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3" for="phone-number">Phone #: <span class="form-required">*</span></label>
											<input class="col-xs-12 col-sm-12 col-md-9 validate[required,custom[number]]" type="text"  name="tele_number" id="tele_number" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['reference_tele_number']?>" placeholder="(555) 55 - 66 - 77" required>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3" for="reference-email">Email:</label>
											<input class="col-xs-12 col-sm-12 col-md-9 validate[required,custom[email]]" type="text" name="email_address" id="email_address" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['reference_email_address']?>" placeholder="m.connelly@gmail.com">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Address: </label>
											 <input type="text" placeholder="" name="txt_address2"  value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['address'];?>" class="col-xs-12 col-sm-12 col-md-9 ">
										</div>
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Zip / Postal Code: </label>
											 <input type="text" placeholder=""onchange="fnGetLocationDetailFromZipFrontRef()" name="txt_post_code" id="txt_post_code"  value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['zipcode'];?>" class="col-xs-12 col-sm-12 col-md-9 validate[required]">
										</div>
										
										<div class="form-group">
											<?php
												//print("<pre>");
												//print_r($countrylist);
												//exit;
											?>
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Country </label>
											<select name="txt_country_ref" id="txt_country_ref" onchange="javascript: fnGetLocationDetailFromCountryRef();">
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
											 
											<input class="text_field required" name="txtstateprovinceref" id="txtstateprovinceref" type="text" size="30" maxlength="100" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['state'];?>" />
										</div>
										<div class="form-group" id="county_auto_ref" style="display:none">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">County / District: </label>
									
											<input name="txtcountyref" id="txtcountyref" type="text" size="30" maxlength="100" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['county'];?>"  class="col-xs-12 col-sm-12 col-md-9"/>
										</div>
									
									<div class="form-group" id="city_auto_ref" style="display:none">
										<label class="control-label col-xs-12 col-sm-12 col-md-3">City / Town: </label>
										 <input name="localityvalref" id="localityvalref" type="text" size="30" maxlength="100" value="" class="col-xs-12 col-sm-12 col-md-9" value="<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['city'];?>" />
									</div>
									<div class="form-group">
										<div class="hidden-xs hidden-sm col-md-3"></div>
										<div class="col-xs-12 col-sm-12 col-md-9">
											<button type="button" onclick="return addRefrence();" class="btn btn-primary">Save Changes</button>
											<button type="button" class="btn btn-default">Cancel</button>
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
						<!--END OF Edit reference PILL DYN-->

			
<script type="text/javascript">
							$('#txt_country_ref').val('<?php echo $arrCandidateReferenceDetail[0]['CandidateReferences']['country'];?>');
</script>												
	
					