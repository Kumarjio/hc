<?php
	echo $this->Html->script('portal_contactus.js');
	if(isset($strHidden))
	{
		?>
			<div id="contact_us" class="contact_us" style="display:none;">
		<?php
	}
	else
	{
		?>
			<div id="contact_us" class="contact_us">
		<?php
	}
?>
	<div class="wrapper">
		<h2>
			Contact Us
		</h2>
		<?php 
			$strContactUsUrl = Router::url(array('controller'=>'portal','action'=>'contactus',$intPortalId),true);
			//echo $this->Form->create('ContactUs',array('id'=>'contactusform','inputDefaults'=>array('label' => false,'div' => false)));
		?>
		<form name="contactusform" id="contactusform" method="POST" action="<?php echo $strContactUsUrl; ?>">
		<ul class="panel-2 margin-top-5">
			<?php
				$arrContactUsFormFields = $arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'];
				if(is_array($arrContactUsFormFields) && (count($arrContactUsFormFields)>0))
				{
					foreach($arrContactUsFormFields as $arrContactField)
					{
						if(isset($arrContactField['career_portal_contact_us_form_fields']['career_portal_contact_us_form_field_label']))
						{
							$strFieldLabel = $arrContactField['career_portal_contact_us_form_fields']['career_portal_contact_us_form_field_label'];
						}
						else
						{
							$strFieldLabel = $arrContactField['fields_table']['field_label'];
						}
						$strMandatLabel = "";
						if(is_array($arrContactField['contactfieldvalidations']) && (count($arrContactField)>0))
						{
							$strValidationString = "validate[";
							foreach($arrContactField['contactfieldvalidations'] as $arrFieldValid)
							{
								if($arrFieldValid['validation_rule_table']['validation_rule'] == "notempty")
								{
									$strMandatLabel = "<span id='madatsym_".$arrContactField['fields_table']['field_id']."' class='madatsym'>*</span>";
									$strValidationString .= "required";
								}
								
								if($arrFieldValid['validation_rule_table']['validation_rule'] == "email")
								{
									$strValidationString .= ",custom[email]";
								}
							}
							$strValidationString .= "]";
						}
						else
						{
							$strMandatLabel = "";
							$strValidationString .= "";
						}
						switch($arrContactField['fields_table']['field_type'])
						{
							case "text"		: echo "<li>";
											  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
											  echo "<input type='text' class='".$strValidationString."' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."' />";
											  echo "</li>";
											  break;
							case "captcha"	: echo "<li>";
											  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
											  echo $this->Html->image($this->Html->url(array('controller'=>'employers', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
											  echo "<input type='text' class='".$strValidationString."' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."' placeholder='Please put Above Captcha Code'/>";
											  echo "</li>";
											  break;
							case "password"	: echo "<li>";
											  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
											  echo "<input type='password' class='".$strValidationString."' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."' />";
											  echo "</li>";
											  break;
							case "textarea"	: echo "<li>";
											  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
											  echo "<textarea class='basiceditor ".$strValidationString."' rows='5' cols='5' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."'></textarea>";
											  echo "</li>";
											  break;
							case "file"		: echo "<li>";
											  echo "<label id='contact_field_".$arrContactField['fields_table']['field_id']."_label' for='".$arrContactField['fields_table']['field_name']."'>".$strFieldLabel.$strMandatLabel."</label>";
											  echo "<input type='file' class='".$strValidationString."' name='".$arrContactField['fields_table']['field_name']."' id='".$arrContactField['fields_table']['field_name']."' />";
											  echo "</li>";
											  break;
						}
					}
				}
				echo $this->Form->hidden('portal_id',array('value'=>$portal_id));
				echo $this->Form->hidden('contact_form_id',array('value'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']));
				echo "<li>";
				echo $this->Form->submit('Send',array('div'  => False));
				echo "&nbsp;";
				echo $this->Form->button('Cancel', array('type' => 'reset','div'  => False,'class'=>'button_class'));
				/*$options = array(
						'label' => 'Send',
						'name' => 'Submit',
						'div'  => False
				);*/
				//echo $this->Form->end($options);
				echo $this->Form->end();
				echo "</li>";
			?>
		</ul>
		</form>
	</div>
</div>
<?php
	echo $this->Html->script('portal_contactus');
?>