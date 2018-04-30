<?php
	class RegistrationSocialMedialField extends AppModel 
	{
		public $name = 'RegistrationSocialMedialField';
		public $useTable = 'career_portal_registration_form_social_plugin';
		
		/* public $validate = array(
								'career_portal_page_tittle' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not provided Page Title',
																		)
												   ),
								'career_portal_page_content' => array(
													'Not Empty'	=>	array(
																			'rule' => 'notEmpty',
																			"message"=>"You have not provided Page Content"
																		)
												)
							 ); */
							 
		
							 
		public function beforeSave($options = array()) 
		{
			/* if (isset($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
			return true; */
		}
		
		public function fnSaveRegistrationFormSocialPlugin($arrRegistrationSocialData = array())
		{
			if(is_array($arrRegistrationSocialData) && (count($arrRegistrationSocialData)>0))
			{
				$arrInsertQuery = $this->query("INSERT INTO career_portal_registration_form_social_plugin(career_portal_registration_form_id,career_portal_registration_social_plugin_id,career_portal_registration_form_social_plugin_createdby)VALUES('".$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_id']."','".$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_social_plugin_id']."','".$arrRegistrationSocialData['RegistrationSocialMedialField']['career_portal_registration_form_social_plugin_createdby']."')");
				return $arrInsertQuery;
			}
		}
		
		public function fnGetSocialMediaFieldDetail($intRegistrationFormId = "")
		{
			if($intRegistrationFormId)
			{
				$arrGetAllFieldsDetailQuery = $this->query("SELECT social_media_plugin.* FROM career_portal_registration_form_social_plugin,social_media_plugin WHERE career_portal_registration_form_social_plugin.career_portal_registration_social_plugin_id = social_media_plugin.social_media_plugin_id AND career_portal_registration_form_social_plugin.career_portal_registration_form_id = '".$intRegistrationFormId."'");
				return $arrGetAllFieldsDetailQuery;
			}
		}
		
		
	}
?>