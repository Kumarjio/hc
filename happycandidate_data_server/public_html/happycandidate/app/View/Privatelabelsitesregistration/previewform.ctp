<h2>
	Registration Form
</h2>
<div>
	<?php
		/*print("<pre>");
		print_r($arrRegistrationFieldDetail);
		
		exit;*/
		
		if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
		{
			echo $this->Form->create('PortalUser',array('type'=>'file'));
			foreach($arrRegistrationFieldDetail as $arrFieldInfo)
			{
				$strMandatorySymbol = "";
				
				if(is_array($arrFieldInfo['fields_validation']) && (count($arrFieldInfo['fields_validation'])>0))
				{
					foreach($arrFieldInfo['fields_validation'] as $arrValidationDetail)
					{
						switch($arrValidationDetail['validation_rule_table']['validation_rule'])
						{
							case"notempty": $strMandatorySymbol = "<span id='madatsym' class='madatsym'>*</span>";
											break;
						
						}
					}
				}
				switch($arrFieldInfo['fields_table']['field_type'])
				{
					case "text"		: echo $this->Form->input($arrFieldInfo['fields_table']['field_name'],array('type'=>'text','label'=>$strMandatorySymbol.$arrFieldInfo['fields_table']['field_label']));
										break;
					case "password"	: echo $this->Form->input($arrFieldInfo['fields_table']['field_name'],array('type'=>'password','label'=>$strMandatorySymbol.$arrFieldInfo['fields_table']['field_label']));
										break;
					case "textarea"	: echo $this->Form->input($arrFieldInfo['fields_table']['field_name'],array('rows'=>'6','cols'=>'6','type'=>'text','label'=>$strMandatorySymbol.$arrFieldInfo['fields_table']['field_label']));
										break;
					case "file"		: echo $this->Form->input($arrFieldInfo['fields_table']['field_name'],array('type'=>'file','label'=>$strMandatorySymbol.$arrFieldInfo['fields_table']['field_label']));
										break;
				}
			}
			$options = array(
				'label' => 'Register',
				'name' => 'register'
			);
			echo $this->Form->end($options);
		}
	?>
</div>