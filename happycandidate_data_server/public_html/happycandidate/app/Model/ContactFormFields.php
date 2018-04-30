<?php
	class ContactFormFields extends AppModel 
	{
		public $name = 'ContactFormFields';
		public $useTable = 'career_portal_contact_us_form_fields';
		
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
		
		public function fnSaveContactFormFields($arrContactFormFields = array())
		{			
			if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
			{
				
				$strFields = "career_portal_contact_us_form_id,career_portal_contact_us_form_field_id,career_portal_contact_us_form_field_category,career_portal_contact_us_form_field_createdby";
				$strFieldValues = "'".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_id']."','".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_id']."','".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_category']."','".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_createdby']."'";
				if(isset($arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_label']))
				{
					$strFields .= ",career_portal_contact_us_form_field_label";
					$strFieldValues .= ",'".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_label']."'";
				}
				
				if(isset($arrContactFormFields['ContactFormFields']['is_contacter_email_field']))
				{
					$strFields .= ",is_contacter_email_field";
					$strFieldValues .= ",'".$arrContactFormFields['ContactFormFields']['is_contacter_email_field']."'";
				}
				
				if(isset($arrContactFormFields['ContactFormFields']['is_contacter_field_greet_name']))
				{
					$strFields .= ",is_contacter_field_greet_name";
					$strFieldValues .= ",'".$arrContactFormFields['ContactFormFields']['is_contacter_field_greet_name']."'";
				}
				
				if(isset($arrContactFormFields['ContactFormFields']['is_contacter_field_message']))
				{
					$strFields .= ",is_contacter_field_message";
					$strFieldValues .= ",'".$arrContactFormFields['ContactFormFields']['is_contacter_field_message']."'";
				}
				
				if(isset($arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_order']))
				{
					$strFields .= ",career_portal_contact_us_form_field_order";
					$strFieldValues .= ",'".$arrContactFormFields['ContactFormFields']['career_portal_contact_us_form_field_order']."'";
				}
				
				//echo $strQuery = "\n"."INSERT INTO career_portal_registration_form_fields(".$strFields.")VALUES(".$strFieldValues.")";
				
				$arrInsertQuery = $this->query("INSERT INTO career_portal_contact_us_form_fields(".$strFields.")VALUES(".$strFieldValues.")");
				return $arrInsertQuery;
			}
		}
		
		public function fnGetAllFields($intContactFormId = "")
		{
			if($intContactFormId)
			{
				$arrGetAllFieldsDetailQuery = $this->query("SELECT fields_table.*,career_portal_contact_us_form_fields.* FROM career_portal_contact_us_form_fields,fields_table WHERE career_portal_contact_us_form_fields.career_portal_contact_us_form_field_id = fields_table.field_id AND career_portal_contact_us_form_fields.career_portal_contact_us_form_id = '".$intContactFormId."' ORDER BY career_portal_contact_us_form_fields.career_portal_contact_us_form_field_order");
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