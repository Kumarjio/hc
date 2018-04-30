<?php
App::uses('Component', 'Controller');
class PortalFormsCreatorComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnCreateDefaultPortalForms($intForPortalId = "")
	{
		$arrResponse = array();
		if($intForPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$arrPageDetail = array();
			
			$arrDefaultPortalForms = array();
			$arrDefaultPortalForms[0]['PortalRegistration']['career_portal_id'] = $intForPortalId;
			$arrDefaultPortalForms[0]['PortalRegistration']['career_registration_form_name'] = "Registration Form";
			$arrDefaultPortalForms[0]['PortalRegistration']['career_registration_form_is_active'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['career_registration_form_is_deleted'] = "0";
			$arrDefaultPortalForms[0]['PortalRegistration']['career_registration_form_is_social_media'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['career_registration_form_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][0]['career_portal_registration_form_field_id'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][0]['career_portal_registration_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][0]['career_portal_registration_form_field_label'] = "Your First Name";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][0]['career_portal_registration_form_field_order'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][0]['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][1]['career_portal_registration_form_field_id'] = "2";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][1]['career_portal_registration_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][1]['career_portal_registration_form_field_label'] = "Your Last Name";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][1]['career_portal_registration_form_field_order'] = "2";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][1]['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_field_id'] = "3";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_field_label'] = "Your Email";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_field_comment'] = "Will be used as Username";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_field_order'] = "3";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][2]['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][3]['career_portal_registration_form_field_id'] = "4";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][3]['career_portal_registration_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][3]['career_portal_registration_form_field_label'] = "Your Password";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][3]['career_portal_registration_form_field_order'] = "4";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][3]['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][4]['career_portal_registration_form_field_id'] = "5";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][4]['career_portal_registration_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][4]['career_portal_registration_form_field_label'] = "Your Address";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][4]['career_portal_registration_form_field_order'] = "5";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationFormFields'][4]['career_portal_registration_form_fields_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][0]['career_portal_registration_social_plugin_id'] = "1";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][0]['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][1]['career_portal_registration_social_plugin_id'] = "2";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][1]['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][2]['career_portal_registration_social_plugin_id'] = "3";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][2]['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][3]['career_portal_registration_social_plugin_id'] = "4";
			$arrDefaultPortalForms[0]['PortalRegistration']['RegistrationSocialMedialField'][3]['career_portal_registration_form_social_plugin_createdby'] = $arrLoggedUserDetails['id'];
			
			$arrDefaultPortalForms[0]['PortalContactForm']['career_portal_id'] = $intForPortalId;
			$arrDefaultPortalForms[0]['PortalContactForm']['career_portal_contact_us_form_name'] = "Contact Us Form";
			$arrDefaultPortalForms[0]['PortalContactForm']['career_portal_contact_us_form_is_active'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['career_portal_contact_us_form_is_deleted'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['career_portal_contact_us_form_created_by'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['career_portal_contact_us_form_field_id'] = "6";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['career_portal_contact_us_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['career_portal_contact_us_form_field_label'] = "Your Name";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['is_contacter_email_field'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['is_contacter_field_greet_name'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['is_contacter_field_message'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['career_portal_contact_us_form_field_order'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][0]['career_portal_contact_us_form_field_createdby'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['career_portal_contact_us_form_field_id'] = "3";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['career_portal_contact_us_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['career_portal_contact_us_form_field_label'] = "Your Email";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['is_contacter_email_field'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['is_contacter_field_greet_name'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['is_contacter_field_message'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['career_portal_contact_us_form_field_order'] = "2";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][1]['career_portal_contact_us_form_field_createdby'] = $arrLoggedUserDetails['id'];
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['career_portal_contact_us_form_field_id'] = "7";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['career_portal_contact_us_form_field_category'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['career_portal_contact_us_form_field_label'] = "Your Message";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['is_contacter_email_field'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['is_contacter_field_greet_name'] = "0";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['is_contacter_field_message'] = "1";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['career_portal_contact_us_form_field_order'] = "3";
			$arrDefaultPortalForms[0]['PortalContactForm']['ContactFormFields'][2]['career_portal_contact_us_form_field_createdby'] = $arrLoggedUserDetails['id'];
			
			
			if(is_array($arrDefaultPortalForms) && (count($arrDefaultPortalForms)>0))
			{
				
				$intFormsCount = 0;
				foreach($arrDefaultPortalForms as $arrDefaultPortalForm)
				{
					$intFormsCount++;
					/* echo $intFormsCount;
					
					print('<pre>');
					print_r($arrDefaultPortalForm); */
					
					if(is_array($arrDefaultPortalForm['PortalRegistration']) && (count($arrDefaultPortalForm['PortalRegistration'])>0))
					{
						$intRegistrationFormFieldId = ""; 
						$modelPortalRegistrationForm = ClassRegistry::init('PortalRegistration');
						$arrRegistrationForm = $modelPortalRegistrationForm->find('all',array('conditions'=>array('career_portal_id'=>$intForPortalId,'career_registration_form_name'=>$arrDefaultPortalForm['PortalRegistration']['career_registration_form_name'])));
						
						if(is_array($arrRegistrationForm) && (count($arrRegistrationForm)>0))
						{
							// get form Id and check for fields
							$intRegistrationFormFieldId = $arrRegistrationForm[0]['PortalRegistration']['career_registration_form_id'];
							if(is_array($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields']) && (count($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields'])>0))
							{
								$modelRegistrationFields = ClassRegistry::init('RegistrationFormFields');
								foreach($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields'] as $arrRegistrationField)
								{
									$arrCheckRegistrationField = $modelRegistrationFields->find('all',array('conditions'=>array('career_portal_registration_form_id'=>$intRegistrationFormFieldId,'career_portal_registration_form_field_id'=>$arrRegistrationField['career_portal_registration_form_field_id'])));
									
									
									if((is_array($arrCheckRegistrationField)) && (count($arrCheckRegistrationField)<=0))
									{
										$arrRegistrationField['career_portal_registration_form_id'] = $intRegistrationFormFieldId;
										// insert Registration field
										$arrRegistrationFieldData['RegistrationFormFields'] = $arrRegistrationField;
										$arrRegistrationFieldInserted = $modelRegistrationFields->fnSaveRegistrationFields($arrRegistrationFieldData);
									}
								}
							}
							
							if(is_array($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField']) && (count($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField'])>0))
							{
								$modelRegistrationSocialMedia = ClassRegistry::init('RegistrationSocialMedialField');
								foreach($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField'] as $arrRegistrationSocialMediaField)
								{
									$arrCheckRegistrationSocialMediaField = $modelRegistrationSocialMedia->find('all',array('conditions'=>array('career_portal_registration_form_id'=>$intRegistrationFormFieldId,'career_portal_registration_social_plugin_id'=>$arrRegistrationSocialMediaField['career_portal_registration_social_plugin_id'])));
									if((is_array($arrCheckRegistrationSocialMediaField)) && (count($arrCheckRegistrationSocialMediaField)<=0))
									{
										$arrRegistrationSocialMediaField['career_portal_registration_form_id'] = $intRegistrationFormFieldId;
										// insert Registration social media field
										$arrRegistrationSocialFieldData['RegistrationSocialMedialField'] = $arrRegistrationSocialMediaField;
										$arrRegistrationSocialFieldInserted = $modelRegistrationSocialMedia->fnSaveRegistrationFormSocialPlugin($arrRegistrationSocialFieldData);
									}
								}
							}
						}
						else
						{
							// insert a new form and get form field
							$intRegistrationFormSaved = $modelPortalRegistrationForm->save($arrDefaultPortalForm['PortalRegistration']);
							if($intRegistrationFormSaved)
							{
								// check for form fields and its insertion
								$intRegistrationFormFieldId = $modelPortalRegistrationForm->getLastInsertID();
								
								if(is_array($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields']) && (count($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields'])>0))
								{
									$modelRegistrationFields = ClassRegistry::init('RegistrationFormFields');
									foreach($arrDefaultPortalForm['PortalRegistration']['RegistrationFormFields'] as $arrRegistrationField)
									{
										$arrCheckRegistrationField = $modelRegistrationFields->find('all',array('conditions'=>array('career_portal_registration_form_id'=>$intRegistrationFormFieldId,'career_portal_registration_form_field_id'=>$arrRegistrationField['career_portal_registration_form_field_id'])));
										
										
										if((is_array($arrCheckRegistrationField)) && (count($arrCheckRegistrationField)<=0))
										{
											$arrRegistrationField['career_portal_registration_form_id'] = $intRegistrationFormFieldId;
											// insert Registration field
											$arrRegistrationFieldData['RegistrationFormFields'] = $arrRegistrationField;
											$arrRegistrationFieldInserted = $modelRegistrationFields->fnSaveRegistrationFields($arrRegistrationFieldData);
										}
									}
								}
								
								if(is_array($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField']) && (count($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField'])>0))
								{
									$modelRegistrationSocialMedia = ClassRegistry::init('RegistrationSocialMedialField');
									foreach($arrDefaultPortalForm['PortalRegistration']['RegistrationSocialMedialField'] as $arrRegistrationSocialMediaField)
									{
										$arrCheckRegistrationSocialMediaField = $modelRegistrationSocialMedia->find('all',array('conditions'=>array('career_portal_registration_form_id'=>$intRegistrationFormFieldId,'career_portal_registration_social_plugin_id'=>$arrRegistrationSocialMediaField['career_portal_registration_social_plugin_id'])));
										if((is_array($arrCheckRegistrationSocialMediaField)) && (count($arrCheckRegistrationSocialMediaField)<=0))
										{
											$arrRegistrationSocialMediaField['career_portal_registration_form_id'] = $intRegistrationFormFieldId;
											// insert Registration social media field
											$arrRegistrationSocialFieldData['RegistrationSocialMedialField'] = $arrRegistrationSocialMediaField;
											$arrRegistrationSocialFieldInserted = $modelRegistrationSocialMedia->fnSaveRegistrationFormSocialPlugin($arrRegistrationSocialFieldData);
										}
									}
								}
							}
						}
					}
					
					
					if(is_array($arrDefaultPortalForm['PortalContactForm']) && (count($arrDefaultPortalForm['PortalContactForm'])>0))
					{
						$intContactFormFieldId = ""; 
						$modelPortalContactForm = ClassRegistry::init('PortalContactForm');
						$arrContactForm = $modelPortalContactForm->find('all',array('conditions'=>array('career_portal_id'=>$intForPortalId,'career_portal_contact_us_form_name'=>$arrDefaultPortalForm['PortalContactForm']['career_portal_contact_us_form_name'])));
						
						if(is_array($arrContactForm) && (count($arrContactForm)>0))
						{
							// check for fields and insert them
							$intContactFormFieldId = $arrContactForm[0]['PortalContactForm']['career_portal_contact_us_form_id'];
							if(is_array($arrDefaultPortalForm['PortalContactForm']['ContactFormFields']) && (count($arrDefaultPortalForm['PortalContactForm']['ContactFormFields'])>0))
							{
								$modelContactFormFields = ClassRegistry::init('PortalContactForm');
								foreach($arrDefaultPortalForm['PortalContactForm']['ContactFormFields'] as $arrContactFormField)
								{
									$arrCheckContactField = $modelContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$intContactFormFieldId,'career_portal_contact_us_form_field_id'=>$arrContactFormField['career_portal_contact_us_form_field_id'])));
									
									if((is_array($arrCheckContactField)) && (count($arrCheckContactField)<=0))
									{
										$arrContactFormField['career_portal_contact_us_form_id'] = $intContactFormFieldId;
										// insert Registration field
										$arrContactFieldData['ContactFormFields'] = $arrContactFormField;
										$arrContactFormFieldInserted = $modelContactFormFields->fnSaveContactFormFields($arrContactFieldData);
									}
								}
							}
						}
						else
						{
							// insert contact form and check for fields and insert them
							$intContactFormSaved = $modelPortalContactForm->save($arrDefaultPortalForm['PortalContactForm']);
							if($intContactFormSaved)
							{
								// check for form fields and its insertion
								$intContactFormFieldId = $modelPortalContactForm->getLastInsertID();
								
								if(is_array($arrDefaultPortalForm['PortalContactForm']['ContactFormFields']) && (count($arrDefaultPortalForm['PortalContactForm']['ContactFormFields'])>0))
								{
									$modelContactFormFields = ClassRegistry::init('ContactFormFields');
									foreach($arrDefaultPortalForm['PortalContactForm']['ContactFormFields'] as $arrContactFormField)
									{
										$arrCheckContactField = $modelContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$intContactFormFieldId,'career_portal_contact_us_form_field_id'=>$arrContactFormField['career_portal_contact_us_form_field_id'])));
										
										if((is_array($arrCheckContactField)) && (count($arrCheckContactField)<=0))
										{
											$arrContactFormField['career_portal_contact_us_form_id'] = $intContactFormFieldId;
											// insert Registration field
											$arrContactFieldData['ContactFormFields'] = $arrContactFormField;
											$arrContactFormFieldInserted = $modelContactFormFields->fnSaveContactFormFields($arrContactFieldData);
										}
									}
								}
							}
						}
						
					}
				}
			}
		}
		else
		{
			$arrResponse['status'] = 'failure';
			$arrResponse['message'] = 'Bad Request';
		}
		return $arrResponse;
	}
}
?>