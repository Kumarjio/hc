<?php
	echo $this->Html->script('portal_user_registration');
?>
<div onmouseover="fnApplyEditorHoverCss(this);fnShowRegisterManage();" onmouseout="fnRemoveEditorHoverCss(this);fnHideRegisterManage();">
&nbsp;
<span style="font-size: 10px;position: relative;top:0px;display:none;cursor:pointer;vertical-align:top;" id="register_manage" onclick="fnShowRegisterCustomizer();">Manage</span>
	<div id="portal_registration">
		<h2>
			Registration
		</h2>
		<form name="PortalUserRegistrationForm" id="PortalUserRegistrationForm" onsubmit="return false;" method="POST" action="">
		<ul class="panel-2 margin-top-5">
			<?php
				/*print("<pre>");
				print_r($arrRegistrationFieldDetail);*/
				/*print("<pre>");
				print_r($arrRegistrationForm);*/
				
				/*exit;*/
				
				if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
				{
					/*print("<pre>");
					print_r($arrRegistrationFieldDetail);*/
					
					foreach($arrRegistrationFieldDetail as $arrFieldInfo)
					{
						/*print('<pre>');
						print_r($arrFieldInfo);*/
						
						$strMandatLabel = "";
						$strValidationString = "";
						$strFieldLabel = "";
						$strFieldLabelComment = "";
						
						if(is_array($arrFieldInfo['fields_validation']) && (count($arrFieldInfo['fields_validation'])>0))
						{
							$strValidationString = "validate[";
							foreach($arrFieldInfo['fields_validation'] as $arrValidationDetail)
							{
								switch($arrValidationDetail['validation_rule_table']['validation_rule'])
								{
									case"notempty": $strMandatLabel = "<span id='madatsym' class='madatsym'>*</span>";
													$strValidationString .= "required";
													break;
									case"email": 	$strValidationString .= ",custom[email]";
													break;
								}
							}
							$strValidationString .= "]";
						}
						
						if(isset($arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label']))
						{
							$strFieldLabel = $arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label'];
						}
						else
						{
							$strFieldLabel = $arrFieldInfo['fields_table']['field_label'];
						}
						
						if(isset($arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_comment']))
						{
							$strFieldLabelComment = $arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_comment'];
						}
						else
						{
							$strFieldLabelComment = $arrFieldInfo['fields_table']['field_comment'];
						}
						
						//echo $arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_enabled'];
						//exit;
						
						switch($arrFieldInfo['fields_table']['field_type'])
						{
							case "text"		: echo "<li>";
											  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
											  echo "<input type='text' class='".$strValidationString."' name='".$arrFieldInfo['fields_table']['field_name']."' id='portal_register_field_".$arrFieldInfo['fields_table']['field_id']."' />";
											  echo "</li>";
											  break;
							case "captcha"	: $strCaptchaDisplayStyle = "style='display:none;'";
											  if($arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_enabled'])
											  {
												$strCaptchaDisplayStyle = "";
											  }
												
												echo "<li id='captchafield' ".$strCaptchaDisplayStyle.">";
												  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
												  echo $this->Html->image($this->Html->url(array('controller'=>'privatelabelsites', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
												  echo "<input type='text' class='".$strValidationString."' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."' placeholder='Please put Above Captcha Code'/>";
												  echo "</li>";
												  break;
							case "password"	: echo "<li>";
											  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
											  echo "<input type='password' class='".$strValidationString."' name='".$arrFieldInfo['fields_table']['field_name']."' id='portal_register_field_".$arrFieldInfo['fields_table']['field_id']."' />";
											  echo "</li>";
											  break;
							case "textarea"	: echo "<li>";
											  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
											  echo "<textarea class='".$strValidationString."' name='".$arrFieldInfo['fields_table']['field_name']."' id='portal_register_field_".$arrFieldInfo['fields_table']['field_id']."' rows='6' cols='6'></textarea>";
											  echo "</li>";
											  break;
							case "file"		: echo "<li>";
											  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
											  echo "<input type='file' class='".$strValidationString."' name='".$arrFieldInfo['fields_table']['field_name']."' id='portal_register_field_".$arrFieldInfo['fields_table']['field_id']."' />";
											  echo "</li>";
											  break;
						}
					}
					echo $this->Form->hidden('portal_id',array('value'=>$intPortalId));
					if(isset($strSocialSetType))
					{
						if($strSocialSetType == "facebook")
						{
							echo "<li><input type='checkbox' name='share' id='share' value='facebook'>Share on Facebook?</input></li>";
						}
						
						if($strSocialSetType == "twitter")
						{
							echo "<li><input type='checkbox' name='share' id='share' value='twitter'>Share on Twitter?</input></li>";
						}
						
						if($strSocialSetType == "linkedin")
						{
							echo "<li><input type='checkbox' name='share' id='share' value='linkedin'>Share on LinkedIn?</input></li>";
						}
					}
					
					echo "<li>";
					if(isset($strResetUrl))
					{
						echo "<a href='".$strResetUrl."'>";
						echo $this->Form->button('Reset', array('type'=>'button','name'=>'reset_social','class'=>'button_class'))."&nbsp; "; 
						echo "</a>";
					}
					if($arrRegistrationForm['0']['PortalRegistration']['career_registration_form_is_social_media'])
					{
						/*print("<pre>");
						print_r($arrRegistrationSocialPluginData);*/
						
						foreach($arrRegistrationSocialPluginData as $arrRegistrationSocialPlugin)
						{
							if($arrRegistrationSocialPlugin['SocialMedialPlugin']['field_allocated'])
							{
								switch($arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_name'])
								{
									case "facebook": 	echo "<span id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through Facebook', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'facebook'))."&nbsp; OR &nbsp; </span>";
														break;
												 
									case "twitter": 	echo "<span id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through Twitter', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'twitter'))."&nbsp; OR &nbsp; </span>";
														break;
														
									case "linkedin": 	echo "<span id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through LinkedIn', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'linkedin'))."&nbsp;  &nbsp; </span>";
														break;
								}
							}
							else
							{
								switch($arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_name'])
								{
									case "facebook": 	echo "<span style='display:none;' id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through Facebook', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'facebook'))."&nbsp; OR &nbsp; </span>";
														break;
												 
									case "twitter": 	echo "<span style='display:none;' id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through Twitter', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'twitter'))."&nbsp; OR &nbsp; </span>";
														break;
														
									case "linkedin": 	echo "<span style='display:none;' id='social_media_button_".$arrRegistrationSocialPlugin['SocialMedialPlugin']['social_media_plugin_id']."'>".$this->Form->button('Register through LinkedIn', array('type'=>'button','name'=>'social_media_button','class'=>'button_class','value'=>'linkedin'))."&nbsp;  &nbsp; </span>";
														break;
								}
							}
							
						}					
					}
					$options = array(
						'label' => 'Register',
						'name' => 'register',
						'div'  => False
					);
					echo $this->Form->end($options);
					echo "</li>";
					
				}
			?>
		</ul>
	</div>
</div>
<?php
	echo $this->element("register_form_customizer");
?>