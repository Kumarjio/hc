<div id="dialog-register-form" title="Customize Your Form" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->
	<div>&nbsp;</div>
	<div align='center' style="font-weight:bold;">Registration Form</div>
	<div>&nbsp;</div>
	<div id="registrationformpostmessages" class="" style="width:95%;display:none;"></div>
	<div>&nbsp;</div>
	<table width="100%" style="border-collapse:separate;border-spacing:1px;">
	<tr style="height:20px;">
		<th align="left" style="font-weight:bold;">Form Name</th>
		<th align="left" style="font-weight:bold;">Action</th>
	</tr>
	<tbody>
	<?php
		/*print("<pre>");
		print_r($arrRegistrationSocialPluginData);*/
		//print("<pre>");
		//print_r($arrRegistrationForm);
		
		if(is_array($arrRegistrationForm) && (count($arrRegistrationForm)>0))
		{
			foreach($arrRegistrationForm as $arrRegisterForm)
			{
				?>
					<tr>
						<td><span><?php echo $arrRegisterForm['PortalRegistration']['career_registration_form_name']; ?></span></td>
						<td>
							<?php
								if(is_array($arrRegistrationSocialPluginData) && (count($arrRegistrationSocialPluginData)>0))
								{
									/*print('<pre>');
									print_r($arrRegistrationSocialPluginData);*/
									
									foreach($arrRegistrationSocialPluginData as $arrSocialMediaPlug)
									{
										if($arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_type'] == "register")
										{
											$intRegisterFormId = $arrRegisterForm['PortalRegistration']['career_registration_form_id'];
											$intSocialMediaButtonId = $arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_id'];
											if($arrSocialMediaPlug['SocialMedialPlugin']['field_allocated'])
											{
												
												?>
													<span onclick="fnHideSocialMediaButtons('<?php echo $intPortalId; ?>','<?php echo $intRegisterFormId; ?>','<?php echo $intSocialMediaButtonId; ?>');" id="social_media_remove_<?php echo $arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_id']; ?>" style="color:blue;text-decoration:underline;cursor:pointer;"><?php echo "Remove ".ucfirst($arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_name']); ?></span>
													<span onclick="fnAddSocialMediaButtons('<?php echo $intPortalId; ?>','<?php echo $intRegisterFormId; ?>','<?php echo $intSocialMediaButtonId; ?>');" id="social_media_add_<?php echo $arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_id']; ?>" style="color:blue;text-decoration:underline;cursor:pointer;display:none;"><?php echo "Add ".ucfirst($arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_name']); ?></span>
												<?php
											}
											else
											{
												?>
													<span onclick="fnAddSocialMediaButtons('<?php echo $intPortalId; ?>','<?php echo $intRegisterFormId; ?>','<?php echo $intSocialMediaButtonId; ?>');" id="social_media_add_<?php echo $arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_id']; ?>" style="color:blue;text-decoration:underline;cursor:pointer;"><?php echo "Add ".ucfirst($arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_name']); ?></span>
													<span onclick="fnHideSocialMediaButtons('<?php echo $intPortalId; ?>','<?php echo $intRegisterFormId; ?>','<?php echo $intSocialMediaButtonId; ?>');" id="social_media_remove_<?php echo $arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_id']; ?>" style="color:blue;text-decoration:underline;display:none;cursor:pointer;"><?php echo "Remove ".ucfirst($arrSocialMediaPlug['SocialMedialPlugin']['social_media_plugin_name']); ?></span>
												<?php
											}
										}
									}
								}
							?>
						</td>
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
	<div align='center' style="font-weight:bold;">Registration Form Details</div>
	<div>&nbsp;</div>
	<div id="widgettablepostmessages" class="" style="width:95%;display:none;"></div>
	<div>&nbsp;</div>
	<table width="70%" style="border-collapse:separate;border-spacing:1px;">
	<!--<tr>
		<td colspan="3" align="right"><span style="cursor:pointer;font-weight:bold;color:blue;text-decoration:underline;" onclick="return false;">Add New Field</span></td>
	</tr>-->
	<tr style="height:20px;">
		<!--<th align="left" style="font-weight:bold;">Sr.No.</th>-->
		<th align="left" style="font-weight:bold;">Field Names</th>
		<th align="left" style="font-weight:bold;">Action</th>
	</tr>
	<tbody id="portalregisterformfieldrows">
	<?php
		/*print('<pre>');
		print_r($arrRegistrationForm);*/
		
		if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
		{
			$intForPortalRegisterFormCount = 0;
			foreach($arrRegistrationFieldDetail as $arrRegistrationField)
			{
				$intForPortalRegisterFormCount++;
				$strMandatory = "";
				$arrContactFieldValidations = $arrRegistrationField['fields_validation'];
				if(is_array($arrContactFieldValidations) && (count($arrContactFieldValidations)>0))
				{
					foreach($arrContactFieldValidations as $arrCFieldValidation)
					{
						if($arrCFieldValidation['validation_rule_table']['validation_rule'] == 'notempty')
						{
							?>
								<input type="hidden" name="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" id="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" value="<?php echo $arrCFieldValidation['validation_rule_table']['validation_rule_id']; ?>" />
							<?php
						}
						else
						{
							?>
								<input type="hidden" name="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" id="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" value="0" />
							<?php
						}
					}
				}
				else
				{
					?>
						<input type="hidden" name="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" id="portal_register_fieldmandatory_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" value="0" />
					<?php
				}
				
				?>
					<tr id="portalregisterformrow_<?php echo $arrRegistrationField['fields_table']['field_id'];?>">
						<!--<td><?php echo $intForWidgetCount; ?></td>-->
						<td><span id="portalregisterformfield_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>"><?php echo $arrRegistrationField['career_portal_registration_form_fields']['career_portal_registration_form_field_label']; ?></span><input type="hidden" name="field_enable_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" id="field_enable_<?php echo $arrRegistrationField['fields_table']['field_id']; ?>" value="<?php echo $arrRegistrationField['career_portal_registration_form_fields']['career_portal_registration_form_field_enabled'];?>" /></td>
						<td><span onclick="fnEditPortalRegisterField('<?php echo $arrRegistrationForm[0]['PortalRegistration']['career_registration_form_id'];?>','<?php echo $arrRegistrationField['fields_table']['field_id'];?>','<?php echo $arrRegistrationField['career_portal_registration_form_fields']['career_portal_registration_form_field_label'];?>');" style="color:blue;text-decoration:underline;cursor:pointer;">Change</span><!--&nbsp;<span style="color:blue;text-decoration:underline;">Delete</span>--></td>
					</tr>
				<?php
			}
			?>
			<?php
		}
	?>
	<span id="num_rows" style="display:none;"><?php echo $intForPortalRegisterFormCount; ?></span>
	</tbody>
	</table>
	<div>&nbsp;</div>
	<div id="portalregisterfieldchange" style="display:none;">
	<div align="center" style="font-weight:bold;">Registration Field Editor</div>
	<div>&nbsp;</div>
	<form id="portal_register_field_editor">
			<div id="postportalregisterfieldeditmessages" class="" style="width:95%;display:none;"></div>
			<span id="portalregisterfieldeditloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
			<div>&nbsp;</div>
			<label for="portal_register_field_edit_label">Field Label</label>
			<div>&nbsp;</div>
			<input type="text" name="portal_register_field_edit_label" id="portal_register_field_edit_label" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="portal_register_field_id" id="portal_register_field_id" value="" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="portal_register_form_identifier" id="portal_register_form_identifier" value="" class="text ui-widget-content ui-corner-all" />
			<div id="field_edit_label_error" class="ui-state-error" style="width:95%;display:none;"></div>
			<div>&nbsp;</div>
			<label for="portal_register_fieldmandatoryyes">Enable Field?:</label>
			<div>&nbsp;</div>
			<input type='radio' name='portal_register_fielde' id='portal_register_fieldenableyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='portal_register_fielde' id='portal_register_fieldenableyno' value='0'>No</input>
			<div>&nbsp;</div>
			<label for="portal_register_fieldmandatoryyes">Is Mandatory</label>
			<div>&nbsp;</div>
			<input type='radio' name='portal_register_fieldmandatory' id='portal_register_fieldmandatoryyes' value='1'>Yes</input>&nbsp;
			<input type='radio' name='portal_register_fieldmandatory' id='portal_register_fieldmandatoryno' value='0'>No</input>
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
			<div id="portal_register_field_validation_error" class="ui-state-error" style="width:95%;display:none;"></div>
	</form>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#portalregisterformfieldrows').children('tr').css('height','20');

		
		$( "#dialog-register-form" ).dialog({
				autoOpen: false,
				height: 600,
				width: 500,
				modal: true,
				buttons: {
					"Done": function() {
						var strFieldLabel = $('#portal_register_field_edit_label').val();
						var intFieldId = $('#portal_register_field_id').val();
						
						
						
						$('#portalregisterfieldeditloader').show();
						var portal_register_fieldediturl = "<?php echo Router::url('/', true).$this->params['controller']."/registereditfield/".$arrPortalDetail['0']['Portal']['career_portal_id'];?>";
						var portal_register_fieldeditposttype = "POST";
						var portal_register_fieldeditoroptions = { 
							beforeSubmit:  function(formData, jqForm, options) {
							},
							success:function(responseText, statusText, xhr, $form) {
								//alert(responseText);
								if(responseText.status == "success")
								{
									$('#portalregisterfieldeditloader').hide();
									$('#portalregisterformfield_'+intFieldId).text('');
									$('#portalregisterformfield_'+intFieldId).text(strFieldLabel);
									
									$('#portalregister_field_'+intFieldId+'_label').text('');
									$('#portalregister_field_'+intFieldId+'_label').html('');
									$('#portalregister_field_'+intFieldId+'_label').html(strFieldLabel+responseText.manadatorytext);
									if(responseText.manadatoryclass != "")
									{
										$('#portal_register_field_'+intFieldId).removeClass();
										$('#portal_register_field_'+intFieldId).addClass(responseText.manadatoryclass);
									}
									else
									{
										$('#portal_register_field_'+intFieldId).removeClass();
									}
									$('#portal_register_fieldmandatory_'+intFieldId).val(responseText.ismandatory);
									$('#field_enable_'+intFieldId).val(responseText.enabeled);
									if(responseText.enabeled == "0")
									{
										$('#captchafield').hide();
									}
									else
									{
										$('#captchafield').show();
									}
									
									
									
									$('#postportalregisterfieldeditmessages').text('');
									$('#postportalregisterfieldeditmessages').removeClass('ui-state-error');
									$('#postportalregisterfieldeditmessages').addClass('ui-state-success');
									$('#postportalregisterfieldeditmessages').text(responseText.message);
									$('#postportalregisterfieldeditmessages').fadeIn('slow');
								}
								else
								{
									$('#portalregisterfieldeditloader').hide();
									$('#postportalregisterfieldeditmessages').text('');
									$('#postportalregisterfieldeditmessages').removeClass('ui-state-success');
									$('#postportalregisterfieldeditmessages').addClass('ui-state-error');
									$('#postportalregisterfieldeditmessages').text(responseText.message);
									$('#postportalregisterfieldeditmessages').fadeIn('slow');
								}
								
							},								
							url:       portal_register_fieldediturl,         // override for form's 'action' attribute 
							type:      portal_register_fieldeditposttype,        // 'get' or 'post', override for form's 'method' attribute 
							dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
						}
						$('#portal_register_field_editor').ajaxSubmit(portal_register_fieldeditoroptions); 
			 
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