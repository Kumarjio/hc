<div class="tab-header">
	<h3 id="contact_header"><?php echo ($strHeader)?$strHeader:"Add"; ?> Contact</h3><!--
	--><button type="button" class="btn btn-primary btn-sm">Add New</button>
</div>

<!--EDIT CONTACT PILL DYN-->			
<div id="edit-contact-panel-slider" class="panel-slider">

	<!--submenu-->			
		<div class="col-md-12 form-container edit-contact">
			<form role="form" id="contact_add_form">
				<div class="col-md-6">
					<div class="form-group">
						<label for="first-name" class="control-label col-xs-12 col-sm-12 col-md-4">First Name: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" type="text" name="c_f_name" id="c_f_name" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_fname'])? $arrContactDetail[0]['JstContacts']['jstcontacts_fname']:'' ?>" required>
					</div>
					<div class="form-group">
						<label for="last-name" class="control-label col-xs-12 col-sm-12 col-md-4">Last Name: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" type="text" id="c_l_name" name="c_l_name" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_lname'])? $arrContactDetail[0]['JstContacts']['jstcontacts_lname']:'' ?>" required>
					</div>
					<div class="form-group">
						<label for="company-name" class="control-label col-xs-12 col-sm-12 col-md-4">Company Name: </label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" type="text" id="comp_name" name="comp_name" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_cname'])? $arrContactDetail[0]['JstContacts']['jstcontacts_cname']:'' ?>" required>
					</div>
					<div class="form-group">
						<label for="job-title" class="control-label col-xs-12 col-sm-12 col-md-4">Job Title:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[onlyLetterSp]]" type="text" name="c_job_title" id="c_job_title" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_jtitle'])? $arrContactDetail[0]['JstContacts']['jstcontacts_jtitle']:'' ?>">
					</div>
					<div class="form-group">
						<label for="person-type" class="control-label col-xs-12 col-sm-12 col-md-4">Person Type:</label><!--
						--><select class="form-control col-xs-12 col-sm-12 col-md-8" id="c_person_type" name="c_person_type">
								<option value="Association/Group">Association/Group</option>
								<option value="Company Contact">Company Contact</option>
								<option value="Network (Personal)">Network (Personal)</option>
								<option value="Network (Professional)">Network (Professional)</option>
								<option value="Referral">Referral</option>
								<option value="Reference">Reference</option>
								<option value="Other">Other</option>
							</select>
					</div>
					<div class="form-group">
						<label for="address" class="control-label col-xs-12 col-sm-12 col-md-4">Address:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="address1" id="address1" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_address'])? $arrContactDetail[0]['JstContacts']['jstcontacts_address']:'' ?>">
					</div>
					<div class="form-group">
						<label for="address2" class="control-label col-xs-12 col-sm-12 col-md-4">Address 2:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="address2" id="address2" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_address2'])? $arrContactDetail[0]['JstContacts']['jstcontacts_address2']:'' ?>">
					</div>
					<div class="form-group">
						<label for="postal-code" class="control-label col-xs-12 col-sm-12 col-md-4">Postal Code:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="UserZipcode" is="UserZipcode" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_postalcode'])? $arrContactDetail[0]['JstContacts']['jstcontacts_postalcode']:'' ?>" onchange='fnGetLocationDetailFromZip()'>
					</div>
					
					<div id="country_row" class="form-group">
						<label for="country" class="control-label col-xs-12 col-sm-12 col-md-4">Country: <span class="form-required">*</span></label><!--
						--><?php 
								echo $this->Form->input('UserCountry', array('onChange'=>'fnGetStateList(this.value)','label'=>false,'style'=>'font-size:90%;','options'=>$arrCountryList,'selected'=>$arrContactDetail[0]['JstContacts']['jstcontacts_country']));
							?>
							<input type='hidden' name='pstate' id='pstate' value='' /> 
							<input type='hidden' name='pcity' id='pcity' value='' />
							<input type='hidden' name='nohtml' id='nohtml' value='1' /> 		
							<input type='hidden' name='contactid' id='contactid' value='<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_id'])? $arrContactDetail[0]['JstContacts']['jstcontacts_id']:'' ?>' />
							<input type='hidden' name='deteailmode' id='deteailmode' value='' />	
					</div>
					<span id="state_city">
						<div class="form-group">
							<label for="state" class="control-label col-xs-12 col-sm-12 col-md-4">State:</label><!--
							--><?php 
									echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','label'=>false,'style'=>'font-size:90%;','options'=>$arrStateList,'selected'=>$arrContactDetail[0]['JstContacts']['jstcontacts_state']));
								?>
						</div>
						<div id="city" class="form-group">
							<label for="city" class="control-label col-xs-12 col-sm-12 col-md-4">City:</label><!--
							--><?php 
									echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','label'=>false,'options'=>$arrCityList,'selected'=>$arrContactDetail[0]['JstContacts']['jstcontacts_city']));
								?>
						</div>
					</span>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone1" class="control-label col-xs-12 col-sm-12 col-md-4">Phone 1:</label><!--
						--><select class="form-control col-xs-12 col-sm-12 col-md-8" name="c_ph1_type" id="c_ph1_type">
								<option value="Cell">Mobile</option>
								<option value="Home">Home</option>
								<option value="Work">Work</option>
							</select>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-12 col-sm-12 col-md-4"></label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[phone]]" type="text" name="c_ph1_no" id="c_ph1_no" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_phone1'])? $arrContactDetail[0]['JstContacts']['jstcontacts_phone1']:'' ?>">
					</div>
					<div class="form-group">
						<label for="phone2" class="control-label col-xs-12 col-sm-12 col-md-4">Phone 2:</label><!--
						--><select class="form-control col-xs-12 col-sm-12 col-md-8" name="c_ph2_type" id="c_ph2_type">
								<option value="Cell">Mobile</option>
								<option value="Home">Home</option>
								<option value="Work">Work</option>
							</select>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-12 col-sm-12 col-md-4"></label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[phone]]" type="text" name="c_ph2_no" id="c_ph2_no" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_phone2'])? $arrContactDetail[0]['JstContacts']['jstcontacts_phone2']:'' ?>">
					</div>
					<div class="form-group">
						<label for="fax" class="control-label col-xs-12 col-sm-12 col-md-4">Fax:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 " type="text" name="c_fax" id="c_fax" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_fax'])? $arrContactDetail[0]['JstContacts']['jstcontacts_fax']:'' ?>">
					</div>
					<div class="form-group">
						<label for="email" class="control-label col-xs-12 col-sm-12 col-md-4">Email Address:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[custom[email]]" type="text" name="c_email" id="c_email" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_emailaddress'])? $arrContactDetail[0]['JstContacts']['jstcontacts_emailaddress']:'' ?>">
					</div>
					<div class="form-group">
						<label for="website" class="control-label col-xs-12 col-sm-12 col-md-4">Website:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8 validate[funcCall[checkURL]]" type="text" name="c_website" id="c_website" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_website'])? $arrContactDetail[0]['JstContacts']['jstcontacts_website']:'' ?>">
					</div>
					<div class="form-group">
						<label for="facebook" class="control-label col-xs-12 col-sm-12 col-md-4">Facebook:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_facebook" id="c_facebook" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_fbid'])? $arrContactDetail[0]['JstContacts']['jstcontacts_fbid']:'' ?>">
					</div>
					<div class="form-group">
						<label for="linkedin" class="control-label col-xs-12 col-sm-12 col-md-4">Linkedin:</label><!--
						--><input class="col-xs-12 col-sm-12 col-md-8" type="text" name="c_twitter" id="c_twitter" value="<?php echo ($arrContactDetail[0]['JstContacts']['jstcontacts_linkedinid'])? $arrContactDetail[0]['JstContacts']['jstcontacts_linkedinid']:'' ?>">
					</div>
				</div>
				<div class="col-md-12 submit-container">
					<div class="col-md-6">
					<div class="form-group">
						<div class="hidden-xs hidden-sm col-md-4"></div>
						<div class="col-xs-12 col-sm-12 col-md-8">
							<button type="button" onclick="fnSubmitAddContact();return false;" class="btn btn-primary">Save Changes</button>
							<button type="button" onclick="fnGetContacts();return false;" class="btn btn-warning">Cancel</button>
						</div></div>
					</div>
				</div>
			</form>
		</div>
	
</div>
<!--END OF EDIT CONTACTS PILL DYN-->
<script type="text/javascript">



function fnSubmitAddContact()
{
	var isValidated = $('#contact_add_form').validationEngine('validate');
	if(isValidated == false)
	{
		return false;
	}
	else
	{
		
		var intPortalId = "<?php echo $intPortalId;?>";
		var pageurl = "<?php echo Router::url('/', true)."jstcontacts/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#loader').show();
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					//$('#loader').hide();
					//$('#contact_message').hide();
					//$('.message').remove();
					
					$('#tab-contacts').html(responseText.contactshtml);
					
					/*if(responseText.updated == "1")
					{
						if(responseText.detailmode == "1")
						{
							$('#contact_detail_'+$('#contactid').val()).replaceWith(responseText.contactshtml);
						}
						else
						{
							$("#contact_"+$('#contactid').val()).replaceWith(responseText.contactshtml);
						}
					}
					else
					{
						$('#contacts_container').append(responseText.contactshtml);
					}*/
					/*$('#contact_form_messages').css('color','green');
					$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+responseText.message+'</div>');
					$('#add_contact').dialog("close");*/
				}
				else
				{
					//$('#loader').hide();
					//$('#contact_form_messages').css('color','#E04B39');
					//$('#contact_form_messages').text(responseText.message);
					
					$('#tab-contacts').html(responseText.contactshtml);
				}
				
			},								
			url:       pageurl,         // override for form's 'action' attribute 
			type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
			dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
		}
		$('#contact_add_form').ajaxSubmit(pageoptions);
		return false;
	}
}

function checkURL(field, rules, i, options)
{
	var re=/^(http:\/\/www\.|https:\/\/www\.|ftp:\/\/www\.|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
	if(re.test(field.val())) 
	{
		return true;
	}
	else
	{
		return options.allrules.urlcheck.alertText;
	}
}

function fGetContactSnapShotHtml(strContactfName,strContactlName,strContactId)
{
	var strContactHtml = "";
	
	strContactHtml = '<div class="line_up_td"><div class="line_up_thumb"><a href="javascript:void(0);"><img width="200" height="200" alt="Contact Pic"  src="'+strBaseUrl +'img/default.png"></a></div><div class="line_up_title"><a title="'+strContactfName+' '+strContactlName+'" href="javascript:void(0);">'+strContactfName+' '+strContactlName+'</a></div></div>';
	return strContactHtml;
}
$('#UserCountry option[value=39]').insertBefore('#UserCountry option:first-child');
$('#UserCountry option[value=231]').insertBefore('#UserCountry option:first-child');
</script>