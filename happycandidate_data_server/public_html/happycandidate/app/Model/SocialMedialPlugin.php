<?php
	class SocialMedialPlugin extends AppModel 
	{
		public $name = 'SocialMedialPlugin';
		public $useTable = 'social_media_plugin';
		
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
				$arrInsertQuery = $this->query("INSERT INTO career_portal_registration_form_social_plugin(career_portal_registration_form_id,career_portal_registration_social_plugin_id,career_portal_registration_form_social_plugin_createdby)VALUES('".$arrRegistrationSocialData['SocialMedialPlugin']['career_portal_registration_form_id']."','".$arrRegistrationSocialData['SocialMedialPlugin']['career_portal_registration_social_plugin_id']."','".$arrRegistrationSocialData['SocialMedialPlugin']['career_portal_registration_form_social_plugin_createdby']."'");
			}
		}
		
		
	}
?>