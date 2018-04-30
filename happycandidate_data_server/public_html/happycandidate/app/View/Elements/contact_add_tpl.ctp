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
		var intPortalId = $('#portal_id').val();
		var pageurl = "<?php echo Router::url('/', true)."jstcontacts/addform/";?>"+intPortalId;
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#loader').show();
				
			},
			success:function(responseText, statusText, xhr, $form) {
				if(responseText.status == "success")
				{
					$('#loader').hide();
					$('#contact_message').hide();
					$('.message').remove();
					if(responseText.updated == "1")
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
					}
					$('#contact_form_messages').css('color','green');
					$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+responseText.message+'</div>');
					$('#add_contact').dialog("close");
				}
				else
				{
					$('#loader').hide();
					$('#contact_form_messages').css('color','#E04B39');
					$('#contact_form_messages').text(responseText.message);
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
</script>
<p id="contact_form_messages" style="display:none;"></p>
<p class="tabloader" id="add_model_loader" style="display:none;"></p>
<div id="form_loader_mask" class="pagemask"></div>
<form name="contact_add_form" id="contact_add_form">
<ul class="panel-2 margin-top-5">
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>First Name:</label>
		<input type="text" class="validate[required,custom[onlyLetterSp]]" name="c_f_name" id="c_f_name" placeholder="First Name" data-prompt-position="topRight:-100" />
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Last Name:</label>
		<input type="text"  class="validate[required,custom[onlyLetterSp]]" name="c_l_name" id="c_l_name" data-prompt-position="topRight:-100"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Company Name:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="comp_name" id="comp_name" data-prompt-position="topRight:-100"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Job Title:</label>
		<input type="text" class="validate[custom[onlyLetterSp]]" name="c_job_title" id="c_job_title" data-prompt-position="topRight:-100"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Person Type:</label>
		<select name="c_person_type" id="c_person_type">
			<option value="Association/Group">Association/Group</option>
			<option value="Company Contact">Company Contact</option>
			<option value="Network (Personal)">Network (Personal)</option>
			<option value="Network (Professional)">Network (Professional)</option>
			<option value="Referral">Referral</option>
			<option value="Reference">Reference</option>
			<option value="Other">Other</option>
		</select>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Address:</label>
		<textarea name="address1" id="address1"></textarea>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Address 2:</label>
		<textarea name="address2" id="address2"></textarea>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Zip / Postal Code:</label>
		<input type="text" onchange='fnGetLocationDetailFromZip()' name="UserZipcode" id="UserZipcode"/>
	</li>
	<li id="country_row" style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Country:</label>
		<?php 
			echo $this->Form->input('UserCountry', array('onChange'=>'fnGetStateList(this.value)','label'=>false,'style'=>'font-size:90%;','options'=>$arrCountryList,'selected'=>$arrCompleteLoggedInUserDetail[0]['country_id']));
		?>
		<input type='hidden' name='pstate' id='pstate' value='' /> 
		<input type='hidden' name='pcity' id='pcity' value='' />
		<input type='hidden' name='nohtml' id='nohtml' value='1' /> 		
		<input type='hidden' name='contactid' id='contactid' value='' />
		<input type='hidden' name='deteailmode' id='deteailmode' value='' />	
	</li>
	<span id="state_city">
		<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>State / Province / Region:</label>
			<?php 
				echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','label'=>false,'style'=>'font-size:90%;','options'=>$arrStateList,'selected'=>$arrCompleteLoggedInUserDetail[0]['state_id']));
			?>
		</li>
		<li id="city" style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>City / Town:</label>
			<?php 
				echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','label'=>false,'options'=>$arrCityList,'selected'=>$arrCompleteLoggedInUserDetail[0]['city_id']));
			?>
		</li>
	</span>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Phone 1:</label>
		<input type="text" class="validate[custom[phone]]" name="c_ph1_no" id="c_ph1_no" data-prompt-position="topRight:-100" />
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Phone 1 Type:</label>
		<select name="c_ph1_type" id="c_ph1_type">
			<option value="Cell">Cell</option>
			<option value="Home">Home</option>
			<option value="Work">Work</option>
		</select>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Phone 2:</label>
		<input type="text" class="validate[custom[phone]]" name="c_ph2_no" id="c_ph2_no" data-prompt-position="topRight:-100" />
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Phone 2 Type:</label>
		<select name="c_ph2_type" id="c_ph2_type">
			<option value="Cell">Cell</option>
			<option value="Home">Home</option>
			<option value="Work">Work</option>
		</select>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Fax:</label>
		<input type="text" name="c_fax" id="c_fax"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Email Address:</label>
		<input type="text" class="validate[required,custom[email]]" name="c_email" id="c_email" data-prompt-position="topRight:-100"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Website:</label>
		<input type="text" class="validate[funcCall[checkURL]]" name="c_website" id="c_website" data-prompt-position="topRight:-100"/>
	</li>
	<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>Twitter:</label>
		<input type="text" name="c_twitter" id="c_twitter"/>
	</li>
	<li style="width:30%;display:inline-block;" class="advance_search"><label>Facebook:</label>
		<input type="text" name="c_facebook" id="c_facebook"/>
	</li>
	<li style="width:30%;">
		<input type="submit" id="add_contact" value="Add Contact" onclick="fnSubmitAddContact();return false;" /> &nbsp; <input type="reset"  class="button_class" value="Reset"/>
	</li>
	<li style="width:auto;display:none;" id="loader">
		<img src="<?php echo Router::url('/',true);?>/img/loader.gif" alt="Loader" title="Loader"/>
	</li>
</ul>
</form>