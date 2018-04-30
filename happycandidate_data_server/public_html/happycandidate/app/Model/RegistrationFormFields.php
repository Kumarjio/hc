<?php
	class RegistrationFormFields extends AppModel 
	{
		public $name = 'RegistrationFormFields';
		public $useTable = 'career_portal_registration_form_fields';
		
		/* public $validate = array(
								'career_registration_form_name' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not provided Name For Registration Form',
																		)
												   )
							 ); */
							 
		
							 
		public function beforeSave($options = array()) {
		}
		
		public function fnFormatResultSet($resource = "")
		{
			$arrFormattedResultSet = array();
			if($resource)
			{
				while($arrResource = mysql_fetch_array($resource))
				{
					$arrFormattedResultSet[] = $arrResource;
				}
				
				/* print("<pre>");
				print_r($arrFormattedResultSet); */
			}
		}
		
		public function fnSaveRegistrationFields($arrRegistrationFormFields = array())
		{			
			if(is_array($arrRegistrationFormFields) && (count($arrRegistrationFormFields)>0))
			{
				
				$strFields = "career_portal_registration_form_id,career_portal_registration_form_field_id,career_portal_registration_form_field_category,career_portal_registration_form_fields_created_by";
				$strFieldValues = "'".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_id']."','".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_id']."','".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_category']."','".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_fields_created_by']."'";
				if(isset($arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_label']))
				{
					$strFields .= ",career_portal_registration_form_field_label";
					$strFieldValues .= ",'".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_label']."'";
				}
				
				if(isset($arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_order']))
				{
					$strFields .= ",career_portal_registration_form_field_order";
					$strFieldValues .= ",'".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_order']."'";
				}
				
				if(isset($arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_comment']))
				{
					$strFields .= ",career_portal_registration_form_field_comment";
					$strFieldValues .= ",'".$arrRegistrationFormFields['RegistrationFormFields']['career_portal_registration_form_field_comment']."'";
				}
				
				//echo $strQuery = "\n"."INSERT INTO career_portal_registration_form_fields(".$strFields.")VALUES(".$strFieldValues.")";
				
				$arrInsertQuery = $this->query("INSERT INTO career_portal_registration_form_fields(".$strFields.")VALUES(".$strFieldValues.")");
				return $arrInsertQuery;
			}
		}
		
		public function fnGetAllFields($intRegistrationFormId = "")
		{
			if($intRegistrationFormId)
			{
				$arrGetAllFieldsDetailQuery = $this->query("SELECT fields_table.*,career_portal_registration_form_fields.* FROM career_portal_registration_form_fields,fields_table WHERE career_portal_registration_form_fields.career_portal_registration_form_field_id = fields_table.field_id AND career_portal_registration_form_fields.career_portal_registration_form_id = '".$intRegistrationFormId."' ORDER BY career_portal_registration_form_field_order ASC");
				return $arrGetAllFieldsDetailQuery;
			}
		}
		
		public function fnGetAllFieldValidation($intFieldId = "")
		{
			if($intFieldId)
			{
				$arrGetAllFieldsValidationDetailQuery = $this->query("SELECT validation_rule_table.* FROM validation_rule_table,field_validation WHERE field_validation.validation_id = validation_rule_table.validation_rule_id AND field_validation.field_id = '".$intFieldId."'");
				return $arrGetAllFieldsValidationDetailQuery;
			}
		}
		
		
	}
?>