<?php
	echo $this->Html->script('portal_user_registration');
?>
<div class="wrapper">
<div id="portal_registration">
	<h2>
		Registration
	</h2>
	<?php 
		echo $this->Form->create('PortalUser',array('inputDefaults'=>array('label' => false,'div' => false),'type'=>'file'));
	?>
	<ul class="panel-2 margin-top-5">
		<?php
			/*print("<pre>");
			print_r($arrRegistrationFieldDetail);
			
			exit;*/
			
			if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
			{
				/*print("<pre>");
				print_r($arrRegistrationFieldDetail);*/
				
				foreach($arrRegistrationFieldDetail as $arrFieldInfo)
				{
					
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
					//echo "--".$arrFieldInfo['career_portal_registration_form_fields']['career_portal_registration_form_field_label'];
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
					
					
					switch($arrFieldInfo['fields_table']['field_type'])
					{
						case "text"		: echo "<li>";
										  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
										  echo "<input value='".$arrFieldInfo['fields_table']['field_value']."' type='text' class='".$strValidationString."' name='data[PortalUser][".$arrFieldInfo['fields_table']['field_name']."]' id='".$arrFieldInfo['fields_table']['field_name']."' />";
										  echo "</li>";
										  break;
						case "password"	: echo "<li>";
										  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
										  echo "<input type='password' class='".$strValidationString."' name='data[PortalUser][".$arrFieldInfo['fields_table']['field_name']."]' id='".$arrFieldInfo['fields_table']['field_name']."' />";
										  echo "</li>";
										  break;
						case "textarea"	: echo "<li>";
										  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
										  echo "<textarea class='".$strValidationString."' name='data[PortalUser][".$arrFieldInfo['fields_table']['field_name']."]' id='".$arrFieldInfo['fields_table']['field_name']."' rows='6' cols='6'>".$arrFieldInfo['fields_table']['field_value']."</textarea>";
										  echo "</li>";
										  break;
						case "file"		: echo "<li>";
										  echo "<label id='portalregister_field_".$arrFieldInfo['fields_table']['field_id']."_label' for='".$arrFieldInfo['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label><small>".$strFieldLabelComment."</small>";
										  echo "<input type='file' class='".$strValidationString."' name='data[PortalUser][".$arrFieldInfo['fields_table']['field_name']."]' id='".$arrFieldInfo['fields_table']['field_name']."' />";
										  echo "</li>";
										  break;
					}
				}
				echo "<li>";
					echo $this->Html->image($this->Html->url(array('controller'=>'portal', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
					//echo '<p><a href="#" id="a-reload">Can\'t read? Reload</a></p>';					
					echo "<input type='text' class='validate[required]' name='data[PortalUser][captcha]' id='captcha' />";
					echo '<p>Enter security code shown above:</p>';
				echo "</li>";
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
				echo "<input type='hidden' id='regmethod' name='regmethod' value='".$strRegistrationMethod."' />";
				if(isset($strResetUrl))
				{
					echo "<a href='".$strResetUrl."'>";
					echo $this->Form->button('Reset', array('type'=>'button','name'=>'reset_social','class'=>'button_class'))."&nbsp; "; 
					echo "</a>";
				}
				if($arrRegistrationForm['0']['PortalRegistration']['career_registration_form_is_social_media'])
				{
					foreach($arrRegistrationSocialPluginData as $arrRegistrationSocialPlugin)
					{
						switch($arrRegistrationSocialPlugin['social_media_plugin']['social_media_plugin_name'])
						{
							case "facebook": 	echo $this->Form->button('Register through Facebook', array('type'=>'button','onclick'=>'fnSocialRegister(this)','name'=>'social_media_button','class'=>'button_class','value'=>'facebook'))."&nbsp; OR &nbsp;"; 
												$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","register","facebook",$intPortalId));
												echo $this->Form->hidden('',array('id'=>'facebook_process_url', 'value'=>$strFURL));
												break;
										 
							case "twitter": 	echo $this->Form->button('Register through Twitter', array('type'=>'button','onclick'=>'fnSocialRegister(this)','name'=>'social_media_button','class'=>'button_class','value'=>'twitter'))."&nbsp; OR &nbsp;"; 
												$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","register","twitter",$intPortalId));
												echo $this->Form->hidden('',array('id'=>'twitter_process_url', 'value'=>$strFURL));
												break;
												
							case "linkedin": 	echo $this->Form->button('Register through LinkedIn', array('type'=>'button','onclick'=>'fnSocialRegister(this)','name'=>'social_media_button','class'=>'button_class','value'=>'linkedin'))."&nbsp;  &nbsp;"; 
												$strFURL = $this->Html->url(array("controller"=>"social","action" => "social","register","linkedin",$intPortalId));
												echo $this->Form->hidden('',array('id'=>'linkedin_process_url', 'value'=>$strFURL));
												break;
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
	if(isset($isRegistrationDone))
	{
		?>
			<script type="text/javascript">
				mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?>", {
					"Portal User Registered": Yes",
					"User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
					"User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
					"User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
					"Registrtaion Method": "<?php echo $arrMixPanelUserRegData['registrationmethod']; ?>",
					"User Confirmed": "No",
				});
				
				mixpanel.track("<?php echo $arrMixPanelUserRegData['portalname']; ?> Registered Users", {
					"Portal User Registered": Yes",
					"User Name": "<?php echo $arrMixPanelUserRegData['username']; ?>",
					"User Id": "<?php echo $arrMixPanelUserRegData['userid']; ?>",
					"User Email": "<?php echo $arrMixPanelUserRegData['useremail']; ?>",
					"Registrtaion Method": "<?php echo $arrMixPanelUserRegData['registrationmethod']; ?>",
					"User Confirmed": "No",
				});
			</script>
		<?php
	}
?>
