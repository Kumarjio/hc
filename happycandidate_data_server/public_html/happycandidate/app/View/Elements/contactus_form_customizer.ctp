<div id="dialog-contactus-form" title="Customize Your Form" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->
	<div>&nbsp;</div>
	<div align='center' style="font-weight:bold;">Contact Form</div>
	<div>&nbsp;</div>
	<table width="70%" style="border-collapse:separate;border-spacing:1px;">
	<tr style="height:20px;">
		<th align="left" style="font-weight:bold;">Contact Form Name</th>
		<!--<th align="left" style="font-weight:bold;">Action</th>-->
	</tr>
	<tbody>
	<?php
		if(is_array($arrContactFormDetail) && (count($arrContactFormDetail)>0))
		{
			foreach($arrContactFormDetail as $arrContactForm)
			{
				?>
					<tr>
						<td><span><?php echo $arrContactForm['PortalContactForm']['career_portal_contact_us_form_name']; ?></span></td>
						<!--<td><span style="color:blue;text-decoration:underline;">Add Captcha</span></td>-->
					</tr>
				<?php
			}
			?>
			<?php
		}
	?>
	</tbody>
	</table>
	</table>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div align='center' style="font-weight:bold;">Contact Form Details</div>
	<div>&nbsp;</div>
	<div id="widgettablepostmessages" class="" style="width:95%;display:none;"></div>
	<div>&nbsp;</div>
	<table width="70%" style="border-collapse:separate;border-spacing:1px;">
	<!--<tr>
		<td colspan="3" align="right"><span style="cursor:pointer;font-weight:bold;color:blue;text-decoration:underline;" onclick="return false;">Add New Field</span></td>
	</tr>-->
	<tr style="height:20px;">
		<!--<th align="left" style="font-weight:bold;">Sr.No.</th>-->
		<th align="left" style="font-weight:bold;">Contact Field Name</th>
		<th align="left" style="font-weight:bold;">Action</th>
	</tr>
	<tbody id="contactformfieldrows">
	<?php
		if(is_array($arrContactFormDetail[0]['PortalContactForm']['ContactFormFields']) && (count($arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'])>0))
		{
			$arrContactFormFields = $arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'];
			
			$intForContactFormCount = 0;
			foreach($arrContactFormFields as $arrContactField)
			{
				if($arrContactField['career_portal_contact_us_form_fields']['is_contacter_field_captcha'] == "1")
				{
					continue;
				}
				
				$intForContactFormCount++;
				$strMandatory = "";
				$arrContactFieldValidations = $arrContactField['contactfieldvalidations'];
				if(is_array($arrContactFieldValidations) && (count($arrContactFieldValidations)>0))
				{
					foreach($arrContactFieldValidations as $arrCFieldValidation)
					{
						if($arrCFieldValidation['validation_rule_table']['validation_rule'] == 'notempty')
						{
							?>
								<input type="hidden" name="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="<?php echo $arrCFieldValidation['validation_rule_table']['validation_rule_id']; ?>" />
							<?php
						}
						else
						{
							?>
								<input type="hidden" name="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="0" />
							<?php
						}
					}
				}
				else
				{
					?>
						<input type="hidden" name="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldmandatory_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="0" />
					<?php
				}
				
				if($arrContactField['career_portal_contact_us_form_fields']['is_contacter_email_field'])
				{
					?>
						<input type="hidden" name="contactformfieldemailfield_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldemailfield_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="1" />
					<?php
				}
				else
				{
					?>
						<input type="hidden" name="contactformfieldemailfield_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldemailfield_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="0" />
					<?php
				}
				if($arrContactField['career_portal_contact_us_form_fields']['is_contacter_field_greet_name'])
				{
					?>
						<input type="hidden" name="contactformfieldgreetname_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldgreetname_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="1" />
					<?php
				}
				else
				{
					?>
						<input type="hidden" name="contactformfieldgreetname_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldgreetname_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="0" />
					<?php
				}
				if($arrContactField['career_portal_contact_us_form_fields']['is_contacter_field_message'])
				{
					?>
						<input type="hidden" name="contactformfieldmessage_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldmessage_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="1" />
					<?php
				}
				else
				{
					?>
						<input type="hidden" name="contactformfieldmessage_<?php echo $arrContactField['fields_table']['field_id']; ?>" id="contactformfieldmessage_<?php echo $arrContactField['fields_table']['field_id']; ?>" value="0" />
					<?php
				}
				
				
				?>
					<tr id="contactformfield_row_<?php echo $arrContactField['career_portal_contact_us_form_fields']['career_portal_contact_us_form_fields_id'];?>">
						<!--<td><?php echo $intForWidgetCount; ?></td>-->
						<td><span id="contactformfield_<?php echo $arrContactField['fields_table']['field_id']; ?>"><?php echo $arrContactField['career_portal_contact_us_form_fields']['career_portal_contact_us_form_field_label']; ?></span></td>
						<td><span onclick="fnEditField('<?php echo $arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'];?>','<?php echo $arrContactField['fields_table']['field_id'];?>','<?php echo $arrContactField['career_portal_contact_us_form_fields']['career_portal_contact_us_form_field_label'];?>');" style="color:blue;text-decoration:underline;cursor:pointer;">Change</span><!--&nbsp;<span style="color:blue;text-decoration:underline;">Delete</span>--></td>
					</tr>
				<?php
			}
			?>
			<?php
		}
	?>
	<span id="num_rows" style="display:none;"><?php echo $intForContactFormCount; ?></span>
	</tbody>
	</table>
	<div>&nbsp;</div>
	<div id="fieldchange" style="display:none;">
	<div align="center" style="font-weight:bold;">Form Field Editor</div>
	<div>&nbsp;</div>
	<form id="fieldeditor">
			<div id="postfieldeditmessages" class="" style="width:95%;display:none;"></div>
			<span id="fieldeditloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
			<div>&nbsp;</div>
			<label for="field_edit_label">Field Label</label>
			<div>&nbsp;</div>
			<input type="text" name="field_edit_label" id="field_edit_label" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="field_id" id="field_id" value="" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="contact_form_identifier" id="contact_form_identifier" value="" class="text ui-widget-content ui-corner-all" />
			<div id="field_edit_label_error" class="ui-state-error" style="width:95%;display:none;"></div>
			<div>&nbsp;</div>
			<label for="validations">Is Mandatory</label>
			<div>&nbsp;</div>
			<input type='radio' name='fieldmandatory' id='fieldmandatoryyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='fieldmandatory' id='fieldmandatoryno' value='0'>No</input>
			<div>&nbsp;</div>
			<label for="greetnameyes">Is this field data to be used as Greet name in notification email</label>
			<div>&nbsp;</div>
			<input type='radio' name='greetname' id='greetnameyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='greetname' id='greetnameno' value='0'>No</input>
			<div>&nbsp;</div>
			<label for="fieldemailyes">Is this field data to be used email in notification email</label>
			<div>&nbsp;</div>
			<input type='radio' name='fieldemail' id='fieldemailyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='fieldemail' id='fieldemailno' value='0'>No</input>
			<div>&nbsp;</div>
			<label for="fieldmessageyes">Is this field data to be used as message in notification email</label>
			<div>&nbsp;</div>
			<input type='radio' name='fieldmessage' id='fieldmessageyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='fieldmessage' id='fieldmessageno' value='0'>No</input>
			<!--<select id="validations" name="validations" class="text ui-widget-content ui-corner-all">
			<option value="">-- Select --</option>
			<option value="1">Not Empty</option>
			<?php
				foreach($arrAllValidations as $arrValidationDetail)
				{
					?>
						
					<?php
				}
			?>
			</select>-->
			<div id="fieldvalidationerror" class="ui-state-error" style="width:95%;display:none;"></div>
	</form>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#contactformfieldrows').children('tr').css('height','20');

		
		$( "#dialog-contactus-form" ).dialog({
				autoOpen: false,
				height: 600,
				width: 500,
				modal: true,
				buttons: {
					"Done": function() {
						var strFieldLabel = $('#field_edit_label').val();
						var intValidation = $('#validations').val();
						var intFieldId = $('#field_id').val();
						
						
						$('#fieldeditloader').show();
						var fieldediturl = "<?php echo Router::url('/', true).$this->params['controller']."/editfield/".$arrPortalDetail['0']['Portal']['career_portal_id'];?>";
						var fieldeditposttype = "POST";
						var fieldeditoroptions = { 
							beforeSubmit:  function(formData, jqForm, options) {
							},
							success:function(responseText, statusText, xhr, $form) {
								//alert(responseText);
								if(responseText.status == "success")
								{
									$('#fieldeditloader').hide();
									$('#contactformfield_'+intFieldId).text('');
									$('#contactformfield_'+intFieldId).text(strFieldLabel);
									
									$('#contact_field_'+intFieldId+'_label').text('');
									$('#contact_field_'+intFieldId+'_label').html('');
									$('#contact_field_'+intFieldId+'_label').html(strFieldLabel+responseText.manadatorytext);

									$('#contactformfieldmandatory_'+intFieldId).val(responseText.ismandatory);
									$('#contactformfieldgreetname_'+intFieldId).val(responseText.greetname);
									$('#contactformfieldemailfield_'+intFieldId).val(responseText.fieldemail);
									$('#contactformfieldmessage_'+intFieldId).val(responseText.messagefield);
									
									$('#postfieldeditmessages').text('');
									$('#postfieldeditmessages').removeClass('ui-state-error');
									$('#postfieldeditmessages').addClass('ui-state-success');
									$('#postfieldeditmessages').text(responseText.message);
									$('#postfieldeditmessages').fadeIn('slow');
								}
								else
								{
									$('#fieldeditloader').hide();
									$('#postfieldeditmessages').text('');
									$('#postfieldeditmessages').removeClass('ui-state-success');
									$('#postfieldeditmessages').addClass('ui-state-error');
									$('#postfieldeditmessages').text(responseText.message);
									$('#postfieldeditmessages').fadeIn('slow');
								}
								
							},								
							url:       fieldediturl,         // override for form's 'action' attribute 
							type:      fieldeditposttype,        // 'get' or 'post', override for form's 'method' attribute 
							dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
						}
						$('#fieldeditor').ajaxSubmit(fieldeditoroptions); 
			 
						// !!! Important !!! 
						// always return false to prevent standard browser submit and page navigation 
						return false; 
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				},
				close: function() {
					
				}
			});
	});

</script>