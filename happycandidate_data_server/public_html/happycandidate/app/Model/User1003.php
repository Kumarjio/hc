<?php

	class User extends AppModel 

	{

		public $name = 'User';

		public $useTable = 'user';

		var $captcha = ''; //intializing captcha var

		

		public $validate = array(

								'captcha' => array(

														'captcha'	=>	array(

																			'rule' => 'matchCaptcha',

																			'message'=>'Failed validating human check.'

																		)

													),

								

								/*'username' => array(

													'alphaNumeric' => array(

																				'rule' => 'notEmpty',

																				'message' => 'Alphabets and numbers only',

																		   )

												   ),*/

								'email' => array(

													'Not Empty'	=>	array(

																				'rule' => 'notEmpty',

																				"message"=>"Pleaze Provide Email Address"

																		),

													'Email Check'	=>	array(

																				'rule' => 'email',

																				"message"=>"Provided email address was not correct"

																		)

												),

								'pass' => array(

													'Not Empty' => array(

																				'rule' => 'notEmpty',

																				'message' => 'Please enter your password'

													),

													'min length' => array(

																				'rule' => array('minLength', '5'),

																				'message' => 'Password Should be minimum 8 characters long'

													)

													/* 'Match Password' => array(

																				'rule' => 'matchPasswords',

																				'message'=>'Your passwords do not match'

													) */

												)

							 );

		

		

		function matchCaptcha($inputValue)	

		{

			return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha

		}



		function setCaptcha($value)	

		{

			$this->captcha = $value; //setting captcha value

		}



		function getCaptcha()	

		{

			return $this->captcha; //getting captcha value

		}

							 

		public function matchPasswords($data) {

			if ($data['pass'] == $this->data['User']['new_password_again']) {

				return true;

			}

			return false;

		}

							 

		public function beforeSave($options = array()) {

			/* if (isset($this->data['User']['password'])) {

				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);

			}

			return true; */

		}

		

		public function fnFormatArray($arrToFormat = array(), $arrTobeFormattedFrom = array())

		{

			if(is_array($arrTobeFormattedFrom) && (count($arrTobeFormattedFrom)>0))

			{

				foreach($arrTobeFormattedFrom as $key=>$val)

				{

					$arrToFormat[0][$key] = $val;

				}

				

				return $arrToFormat;

			}

			else

			{

				return false;

			}

		

		}

			

		public function fnGetCountryName($intCountryId = "")

		{

			if($intCountryId)

			{

				$arrCountryArray = $this->query("SELECT * FROM country WHERE country_id='".$intCountryId."'");

				return $arrCountryArray;

			}

			else

			{

				return false;

			}

		}

		

		public function fnGetStateName($intStateId = "")

		{

			if($intStateId)

			{

				$arrStateArray = $this->query("SELECT * FROM state WHERE state_id='".$intStateId."'");

				return $arrStateArray;

				/* print("<pre>");

				print_r($arrCountryArray); */

				

			}

			else

			{

				return false;

			}

		}

		

		public function fnGetCityName($intCityId = "")

		{

			if($intCityId)

			{

				$arrCityArray = $this->query("SELECT * FROM city WHERE city_id='".$intCityId."'");

				return $arrCityArray;

				

				/* print("<pre>");

				print_r($arrCityArray); */

			}

			else

			{

				return false;

			}

		}

		

		public function fnGetIndustryName($intIdustryId = "")

		{

			if($intIdustryId)

			{

				$objModelIndustry = ClassRegistry::init('Industry');

				$arrIndustry = $objModelIndustry->find('all',array('conditions'=>array('industry_id'=>$intIdustryId)));

				

				return $arrIndustry;

			}

		}

		

		public function fnGetUserDetailForPortal($intPortalId = "")

		{

			if($intPortalId == "all")

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

			else

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.portal_id = '".$intPortalId."' AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

		}

		

		public function fnGetUserInactiveDetailForPortal($intPortalId = "")

		{

			if($intPortalId == "all")

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

			else

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime,user_inactivation_date FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '0' AND user.portal_id = '".$intPortalId."' AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

		}

		

		public function fnGetUserActiveDetailForPortal($intPortalId = "")

		{

			if($intPortalId == "all")

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

			else

			{

				$strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND user.portal_id = '".$intPortalId."' AND user.portal_id = career_portal.career_portal_id";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

		}



		public function fnGetUserCompleted15Steps($intPortalId = "")

		{

			if($intPortalId == "all")

			{

				 $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal,career_portal_candidate cpd WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND j_process_substeps_completed ='60' AND user.portal_id = career_portal.career_portal_id and cpd.career_portal_id =career_portal.career_portal_id  ";

				$arrUserDetail = $this->query($strQuery);
				//print_r($arrUserDetail);
				return $arrUserDetail;

			}

			else
			{

				 $strQuery = "SELECT username,email,is_active,employer_user_fname,employer_user_lname,employer_contact_number,career_portal_name,career_portal.career_portal_created_datetime FROM user,employer_detail,career_portal,career_portal_candidate cpd  WHERE employer_detail.employer_id = user.id AND user.is_active = '1' AND j_process_substeps_completed ='60' AND user.portal_id = '".$intPortalId."' AND user.portal_id = career_portal.career_portal_id  and cpd.career_portal_id =career_portal.career_portal_id  ";

				$arrUserDetail = $this->query($strQuery);
//print_r($arrUserDetail);
				return $arrUserDetail;

			}

		}

		public function fnGetJobSeekerPurchasedOrder()

		{

			//Configure::write('debug','2');

				 $strQuery = "SELECT distinct candidate_first_name,candidate_last_name,candidate_email FROM `career_portal_candidate` ,`resource_order`  WHERE `career_portal_candidate`.candidate_id=`resource_order`.seeker_id and order_payment_status='captured' ";
				
				$arrUserDetail = $this->query($strQuery);
				//echo '<pre>',print_r($arrUserDetail);die;
				return $arrUserDetail;

			

		}

		public function fnGetOverTimeMonery($intPortalId= "")

		{

			//Configure::write('debug','2');

				$strQuery = "SELECT sum(portal_owner_cost) as OverTimeMonery,career_portal_name FROM `resource_order_detail` ,`career_portal` where `resource_order_detail`.order_from_portal=`career_portal`.`career_portal_id` and order_from_portal= '".$intPortalId."'";
				
				$arrUserDetail = $this->query($strQuery);
				//echo '<pre>',print_r($arrUserDetail);die;
				return $arrUserDetail;

			

		}

		

		public function fnFindOwnerDetail($intOwnerId = "")

		{

			if($intOwnerId)

			{

				$strQuery = "SELECT * FROM employer_detail WHERE employer_detail.employer_id = '".$intOwnerId."'";

				$arrUserDetail = $this->query($strQuery);

				return $arrUserDetail;

			}

		}



		public function fnGetCompleteUserDetail($intUid = "", $intUtype = "")

		{

			$arrCompleteUserDetail = array();

			

			if($intUid)

			{

				$arrUserLDetails = AuthComponent::user();

				

				$arrCompleteUserDetail[0] = $arrUserLDetails;

				

				if($intUtype == "2")

				{

					$objModelEmployer = ClassRegistry::init('Employer');

					

					$arrEmpDetail = $objModelEmployer->find('all',array(

										'conditions' => array('employer_id' => $intUid)

									));

					/* print("<pre>");

					print_r($arrEmpDetail); */

									

					if(is_array($arrEmpDetail) && (count($arrEmpDetail)>0))

					{

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrEmpDetail['0']['Employer']);

						$arrEmpCountryDetail = $this->fnGetCountryName($arrEmpDetail['0']['Employer']['employer_country']);

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrEmpCountryDetail['0']['country']);

						$arrEmpStateDetail = $this->fnGetStateName($arrEmpDetail['0']['Employer']['employer_state']);

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrEmpStateDetail['0']['state']);

						$arrEmpCityDetail = $this->fnGetCityName($arrEmpDetail['0']['Employer']['employer_city']);

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrEmpCityDetail['0']['city']);

						$arrEmpIndustryDetail = $this->fnGetIndustryName($arrEmpDetail['0']['Employer']['employer_industry_type']);

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrEmpIndustryDetail['0']['Industry']);

						

						/* print("<pre>");

						print_r($arrEmpStateDetail); */

					}

				}

				else

				{

					$objModelAdmin = ClassRegistry::init('Admin');

					$arrAdminDetail = $objModelAdmin->find('all',array(

										'conditions' => array('admin_id' => $intUid)

									));

									

					/* print("<pre>");

					print_r($arrAdminDetail); */

					

					if(is_array($arrAdminDetail['0']['Admin']) && (count($arrAdminDetail['0']['Admin'])>0))

					{

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrAdminDetail['0']['Admin']);

						$arrAdminCountryDetail = $this->fnGetCountryName($arrAdminDetail['0']['Admin']['admin_country']);

						$arrCompleteUserDetail = $this->fnFormatArray($arrCompleteUserDetail,$arrAdminCountryDetail['0']['country']);

						$arrAdminStateDetail = $this->fnGetStateName($arrAdminDetail['0']['Admin']['admin_state']);

						$arrS = $this->fnFormatArray($arrCompleteUserDetail,$arrAdminStateDetail['0']['state']);

						if(is_array($arrS) && (count($arrS)>0))

						{

							$arrCompleteUserDetail = $arrS;

						}

						

						$arrAdminCityDetail = $this->fnGetCityName($arrAdminDetail['0']['Admin']['admin_city']);

						$arrC = $this->fnFormatArray($arrCompleteUserDetail,$arrAdminCityDetail['0']['city']);

						if(is_array($arrC) && (count($arrC)>0))

						{

							$arrCompleteUserDetail = $arrC;

						}

					}

				}

				

				

				/* print("<pre>");

				print_r($arrCompleteUserDetail); */

				

				return $arrCompleteUserDetail;

			}

			else

			{

				return false;

			}

		}

	}

?>