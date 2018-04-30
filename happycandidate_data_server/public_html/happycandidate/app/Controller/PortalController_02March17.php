<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PortalController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Portal';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail','captcha','share','home','index1','index2','index3','index4','index5','getIndeedJobSerach','aboutus','privacypolicy','contactus','themehome','themepage');
		
	}

	
	public function index($strPortalName = "")
	{
		set_time_limit(0);
		//SET GLOBAL max_allowed_packet=1073741824;
		//echo "--".$this->layout;
		App::import('Vendor', 'indeed/src/Indeed');
		$this->loadModel('Candidate');
		$arrLoggedUser = $this->Auth->user();
		$this->set('current_user',$arrLoggedUser);
		$arrCandidateDetail = $this->Candidate->find('first', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
		//print("<pre>");
		//print_r($_SESSION);
		
		//echo "---".$this->Session->read('userregistered');
		if($this->Session->read('userregistered') == "1")
		{
			$this->set('newuserregistered','1');
			//unset($_SESSION['userregistered']);
			$this->Session->delete('userregistered');
			
		}
								
		if($arrCandidateDetail['Candidate']['candidate_confirmed'] == "0")
		{
				 $message = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Your account not activated.Please check your email.<a href="javascript:void(0);" onclick="return resendconfirmemail();">Resend email</a></div>'; 
						$_SESSION['message']=$message;
				
		
		}
		else
		{
			if(isset($_SESSION['message']))
			{
				unset($_SESSION['message']);
			}
		}
		
		$stepIncompleteid = "";
		$arrfirstStepcontent="";
		$this->loadModel('Portal');
		
		if(is_numeric($strPortalName))
		{
			$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_id' => $strPortalName)
								));
		}
		else
		{
			$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
		}
		
		
		$this->set('arrPortalDetail',"");
		$this->set('arrPortalPageDetail',"");
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
		
		if($intPortalExists)
		{
			//echo "HI";exit;
			if(is_numeric($strPortalName))
			{
				$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id' => $strPortalName)
								));
			}
			else
			{
				$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
			}
			
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$arrPortalDetail['0']['Portal']['career_portal_id']);
			
			$arrLoggedUser = $this->Auth->user();
		/*	print_r($arrLoggedUser);
			exit();*/
			if(is_array($arrLoggedUser) && (count($arrLoggedUser)>0))
			{
				 $compLms = $this->Components->load('LmsBridge');
				 $arrSeekerLmsSetup = $compLms->fnSetupSeeker($arrPortalDetail['0']['Portal']['career_portal_id'],$arrLoggedUser['candidate_email']);
			
			}
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			$this->loadModel('PortalPages');
			
			$arrPortalHomePageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'is_career_portal_home_page'=> '1')
								));
			$this->set('arrPortalPageDetail',$arrPortalHomePageDetail);
			
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			// load contact form if present
			$this->loadModel('PortalContactForm');
			$arrContactFormDetail = $this->PortalContactForm->find('all',array('conditions'=>array('PortalContactForm.career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'],'PortalContactForm.career_portal_contact_us_form_is_active'=>'1')));
			/* print("<pre>");
			print_r($arrContactFormDetail); */
			if(is_array($arrContactFormDetail)  && (count($arrContactFormDetail)>0))
			{
				$this->loadModel('ContactFormFields');
				
				$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
				if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
				{
					$intContactFormFieldCount = 0;
					foreach($arrContactFormFields as $arrContactFFields)
					{
						$arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
						$arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
						$intContactFormFieldCount++;
					}
					$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
				}
				$this->set('arrContactFormDetail',$arrContactFormDetail);
			}
			
			
			
			$this->loadModel('Job');
			$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
			
			
			$this->loadModel('Job');
			$arrHighJobDetail = $this->Job->fnGetHighlightedJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalHJobDetail',$arrHighJobDetail);
			
			
			$this->loadModel('JCountry');
			$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
			asort($arrJCountries);
			$this->set('arrJcountry',$arrJCountries);
			
			
			$this->loadModel('JobCategory');
			$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
			$arrJCategories["0"] = "Choose Category";
			ksort($arrJCategories);
			$this->set('arrJcategories',$arrJCategories);
			
			
			$this->loadModel('JobExperience');
			$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
			$arrJobInitialVal["0"] = "Choose Experience";
			//ksort($arrJobExperience);
			$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
			$this->set('arrJobExperience',$arrNewMergedJobExp);
			
			
			
			$this->set('arrCourseWebinarContent',$arrCourseWebinarContent);
			
			// Load Quotes
			$this->loadModel('Content');
			$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
			$intRandomQuoteIndex = rand(0,$intQuoteCount);
			$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
			
			//print("<pre>");
			//print_r($arrRandomQuoteDetail);
			//exit;
			
			$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
			
			
			
			
			$this->loadModel('Categories');
			$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'phase'),'order'=>array('job_search_order'=>'ASC')));
			
			
			
			
			if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
			{
				$this->loadModel('Content');
				$this->loadModel('Jobsearchtracker');
				$intFrCnt = 0;
				foreach($arrJobSearchProcessPhases as $arrJobSearchPhase)
				{
					$arrCatContentData = $this->Content->find('all',array('fields'=>array('content_id','content'),'conditions'=>array('content_default_category'=>$arrJobSearchPhase['Categories']['content_category_id'])));
					//print("<pre>");
					//print_r($arrCatContentData);
					
					if(is_array($arrCatContentData) && (count($arrCatContentData)>0))
					{
						//echo "--".$arrCatContentData[0]['Content']['content'];
						//$arrfirstStepcontent	= $arrCatContentData[0]['Content']['content'];
							
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
					}
					
					//echo "--".$arrJobSearchPhase['Categories']['content_category_id'];
					$arrStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrJobSearchPhase['Categories']['content_category_id'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
					if($arrStepCompleted)
					{
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completed'] = "1";
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completion_class'] = "stepcomplete";
					}
					else
					{
						/*if($arrfirstStepcontent=="")
						{
							$arrfirstStepcontent = $arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'];
						}*/
					}
					
					$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'steps','content_category_parent_id'=>$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));
					if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
					{
						$intFrNewCnt = 0;
						$this->loadModel('Jobsearchtracker');
						/*echo "<pre>";
						print_R($arrJobPhaseSteps);*/
						
						foreach($arrJobPhaseSteps as $arrJsteps)
						{

						
							 $isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['content_category_id'])));
							if($isStepCompleted)
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "1";
							}
							else
							{
								if($stepIncompleteid=="")
								{
									
									$stepIncompleteid = $arrJsteps['Categories']['content_category_id'];
									$phaseIncompleteid = $arrJsteps['Categories']['content_category_parent_id'];
									
									$arrfirstStepdata	= $arrJsteps['Categories'];	
								
								}
							
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "0";
							}
							$intFrNewCnt++;
						}
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['Steps'] = $arrJobPhaseSteps;
					}
					$intFrCnt++;
				}
			}
			
			//get incomplete step id get substep of it
			$arrJobPhasesubSteps = $this->Categories->find('all',array('fields'=>array('content_category_id','job_search_order','content_category_name','content_category_parent_id'),'conditions'=>array('job_process_type'=>'substeps','content_category_parent_id'=>$stepIncompleteid),'order'=>array('job_search_order'=>'ASC')));
			
			
			
			
			$incompleteorder=0;
			$incompleteSubstepid=0;
			$this->loadModel('Jobsearchtracker');
			if(is_array($arrJobPhasesubSteps) && (count($arrJobPhasesubSteps)>0))
				{
			foreach($arrJobPhasesubSteps as $substeps)
			{
				
				 $substep_id = $substeps['Categories']['content_category_id'];
				 $job_search_order = $substeps['Categories']['job_search_order'];
				 
				

				 $issubStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$substep_id)));
				  if(!$issubStepCompleted)
				 {
					 if($incompleteorder=="")
					 {
						$arrStepContentData = $this->Content->find('all',array('fields'=>array('content_id','content','content_intro_text'),'conditions'=>array('content_default_category'=>$substep_id)));
						
						$arrfirstStepdata = $substeps['Categories'];
						$incompleteorder = $job_search_order;
						$arrfirstStepcontent = $arrStepContentData[0];
						
					 }
				 }
			}
		}
			
			
			//get jobs from indeed for candidate
			$client = new Indeed("4991231526397630");

					$params = array(
						"q" => "php",
						"l" => "austin",
						"userip" => "1.2.3.4",
						"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);

					$indeedresults = $client->search($params);
				
					
	
					$indeedresults = $indeedresults['results'];
				
			$this->set('indeedresults',$indeedresults);
			$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessPhases);
			
			$this->loadModel("Vendorservice");
			//$arrResourcesDetail = $this->Resources->find('all',array('conditions'=>array('product_publish_status'=>'1')));
			$arrResourcesDetail = $this->Vendorservice->fnGetPublishedResources(6);
			
			/*print("<pre>");
			print_r($arrResourcesDetail);
			exit;*/
			
			if(is_array($arrResourcesDetail) && (count($arrResourcesDetail)>0))
			{
				$this->loadModel('ResourcesImages');
				$this->loadModel('Vendors');
				$intProductCount = 0;
				foreach($arrResourcesDetail as $arrResource)
				{
					//echo $arrResource['Resources']['product_id'];exit;
					$arrVendorDetail = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrResource['Vendorservice']['vendor_id'])));
					$arrResourcesDetail[$intProductCount]['Vendor'] = $arrVendorDetail[0]['Vendors'];
					$arrResourceImages = $this->ResourcesImages->find('all',array('conditions'=>array('product_id'=>$arrResource['Resources']['productd_id'])));
					if(is_array($arrResourceImages) && (count($arrResourceImages)>0))
					{
						$arrResourcesDetail[$intProductCount]['Resources']['images'] = $arrResourceImages; 
					}
					$intProductCount++;
				}
			}
			//print("<pre>");
			//print_r($arrResourcesDetail);
			
			
			
			
			
			$this->set('arrResourcesDetail',$arrResourcesDetail);
			$this->set('arrfirstStepdata',$arrfirstStepdata);
			$this->set('arrfirstStepcontent',$arrfirstStepcontent);
			$this->set('stepIncompleteid',$incompleteorder);
			$this->set('phaseIncompleteid',$phaseIncompleteid);
			
			
		}
		else
		{
			$this->set('strPortalNotFoundMessage',"URL Broken");
		}
	}
	
	
	public function getIndeedJobSerach($intPortalId)
	{

			App::import('Vendor', 'indeed/src/Indeed');
			 $title = $_POST['title'];
			 $location = $_POST['location'];
			
			
			
			$client = new Indeed("4991231526397630");

					$params = array(
						"q" => $title,
						"l" => $location,
						"userip" => "1.2.3.4",
						"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);

					$indeedresults = $client->search($params);
	
					$indeedresults = $indeedresults['results'];
				
		
				$view = new View($this, false);
				$view->set('indeedresults',$indeedresults);
				$view->set('intPortalId',$intPortalId);
				//$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
				//$view->set('arrContactDetail',$arrContactDetail);
				
				$strWidgetListerHtml = $view->element('indeed_job_list');
				$arrResponse['status'] = "success";
				$arrResponse['html'] = $strWidgetListerHtml;
				echo json_encode($arrResponse);
				exit;
			
	}
	
	
	public function indeedJobdetail($intPortalId,$key)
	{

			App::import('Vendor', 'indeed/src/Indeed');
			
			
			
			
			$client = new Indeed("4991231526397630");

					$params = array(
						"q" => '',
						"l" => '',
						"userip" => "1.2.3.4",
						"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
					);
					
			$params = array(
				"jobkeys" => array($key),
				);

					$indeedresults =  $client->jobs($params);
	
					$indeedresults = $indeedresults['results'];
				
				
				$this->set('indeedresults',$indeedresults);
			
				
			
	}
	
	
	
	
	public function home($strPortalName = "")
	{
	
		
		$arrLoggedUser = $this->Auth->user();
		if($arrLoggedUser['candidate_is_active'] == "0")
		{
			$this->Session->setFlash('Your account has been inactivated');
			$this->Auth->logout();
			$this->redirect(Router::url(array("controller"=>"portal","action"=>"index",$strPortalName),true));
		}
		
		
		$this->loadModel('Portal');
		
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
		
		$this->set('arrPortalDetail',"");
		$this->set('arrPortalPageDetail',"");
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
		
		if($intPortalExists)
		{
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$arrPortalDetail['0']['Portal']['career_portal_id']);
			
			$arrLoggedUser = $this->Auth->user();
			if(is_array($arrLoggedUser) && (count($arrLoggedUser)>0))
			{
				 $compLms = $this->Components->load('LmsBridge');
				 $arrSeekerLmsSetup = $compLms->fnSetupSeeker($arrPortalDetail['0']['Portal']['career_portal_id'],$arrLoggedUser['candidate_email']);
				
			}
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			$this->loadModel('PortalPages');
			
			$arrPortalHomePageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'is_career_portal_home_page'=> '1')
								));
			$this->set('arrPortalPageDetail',$arrPortalHomePageDetail);
			
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			// load contact form if present
			$this->loadModel('PortalContactForm');
			$arrContactFormDetail = $this->PortalContactForm->find('all',array('conditions'=>array('PortalContactForm.career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'],'PortalContactForm.career_portal_contact_us_form_is_active'=>'1')));
			/* print("<pre>");
			print_r($arrContactFormDetail); */
			if(is_array($arrContactFormDetail)  && (count($arrContactFormDetail)>0))
			{
				$this->loadModel('ContactFormFields');
				//$arrContactFormFields = $this->ContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'])));
				$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
				if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
				{
					$intContactFormFieldCount = 0;
					foreach($arrContactFormFields as $arrContactFFields)
					{
						$arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
						$arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
						$intContactFormFieldCount++;
					}
					$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
				}
				$this->set('arrContactFormDetail',$arrContactFormDetail);
			}
			
			$this->loadModel('Job');
			$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
			/* print("<pre>");
			print_r($arrLatesJobDetail); */
			
			$this->loadModel('Job');
			$arrHighJobDetail = $this->Job->fnGetHighlightedJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			/* print("<pre>");
			print_r($arrHighJobDetail); */
			$this->set('arrPortalHJobDetail',$arrHighJobDetail);
			
			
			$this->loadModel('JCountry');
			$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
			asort($arrJCountries);
			$this->set('arrJcountry',$arrJCountries);
			
			
			$this->loadModel('JobCategory');
			$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
			$arrJCategories["0"] = "Choose Category";
			ksort($arrJCategories);
			$this->set('arrJcategories',$arrJCategories);
			
			
			$this->loadModel('JobExperience');
			$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
			$arrJobInitialVal["0"] = "Choose Experience";
			//ksort($arrJobExperience);
			$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
			$this->set('arrJobExperience',$arrNewMergedJobExp);
			
			// courses detail
			$compLmsBridge = $this->Components->load('LmsBridge');
			$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrCourseDetails);*/
			
			$arrWebinarsDetails = $compLmsBridge->fnGetPortalWebinars($arrPortalDetail['0']['Portal']['career_portal_id']);
			
			$arrCourseWebinarContent = array();
			$arrCourseWebinarContent['Elearning'] = $arrCourseDetails;
			$arrCourseWebinarContent['Webinars'] = $arrWebinarsDetails;
			
			/*print("<pre>");
			print_r($arrCourseWebinarContent);*/
			
			
			$this->set('arrCourseWebinarContent',$arrCourseWebinarContent);
			
			// Load Quotes
			$this->loadModel('Content');
			$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
			$intRandomQuoteIndex = rand(0,$intQuoteCount);
			$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
			
			//print("<pre>");
			//print_r($arrRandomQuoteDetail);
			//exit;
			
			$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
			
			/// new added by akash
			
			$intPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
			
			if($intPortalId)
			{
			$strRegistrationMethod = "Manual";
			$this->loadModel('Portal');
		
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->loadModel('PortalRegistration');
				$arrPortalRegistration = $this->PortalRegistration->find('all', array(
																'conditions' => array('career_portal_id'=> $intPortalId,'career_registration_form_is_active'=>'1')
															));
				$this->loadModel('RegistrationFormFields');
				$arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
				if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
				{
					$intForEachCount = 0;
					foreach($arrRegistrationFieldDetail as $arrRegistrationField)
					{
						
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table'] = $arrRegistrationField['fields_table'];
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['career_portal_registration_form_fields'] = $arrRegistrationField['career_portal_registration_form_fields'];
						$arrFieldValidationDetail = $this->RegistrationFormFields->fnGetAllFieldValidation($arrRegistrationField['fields_table']['field_id']);
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_validation'] = $arrFieldValidationDetail;
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = "";
						if(is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS'))>0))
						{
							$arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
							
							//echo "---".$arrRegistrationField['fields_table']['field_name'];
							
							if(isset($arrRegistrationData['SOCIALUSERFNAME']))
							{
								
								if($arrRegistrationField['fields_table']['field_name'] == 'first_name')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERFNAME'];
								}
							}
							
							if(isset($arrRegistrationData['SOCIALUSERLNAME']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'last_name')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLNAME'];
								}
							}
							
							
							if(isset($arrRegistrationData['SOCIALUSEREMAIL']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'email')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSEREMAIL'];
								}
							}
							
							if(isset($arrRegistrationData['SOCIALUSERLOCATION']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'address')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLOCATION'];
								}
							}
							
						}
						
						$intForEachCount++;
					}
				}
				if($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_is_social_media'])
				{
					$this->loadModel('RegistrationSocialMedialField');
					$arrSetRegistrationSocialFields = $this->RegistrationSocialMedialField->fnGetSocialMediaFieldDetail($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
					/* print("<pre>");
					print_r($arrSetRegistrationSocialFields); */
					
					$this->set('arrRegistrationSocialPluginData',$arrSetRegistrationSocialFields);
				}
				
				
				/* print("<pre>");
				print_r($_SESSION); */
				if(is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS'))>0))
				{
					$arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
					$this->set('strResetUrl',$arrRegistrationData['logout_url']);
					$this->set('strSocialSetType',$arrRegistrationData['SOCIALUSERTYPE']);
					$strRegistrationMethod = $arrRegistrationData['SOCIALUSERTYPE'];
				}
				
				$this->set('intPortalId',$intPortalId);
				$this->set('arrRegistrationForm',$arrPortalRegistration);
				$this->set('arrRegistrationFieldDetail',$arrCompleteRegistrationFieldDetail);
				$this->set('strRegistrationMethod',$strRegistrationMethod);
			}
			
			// Load Quotes
			$this->loadModel('Content');
			$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
			$intRandomQuoteIndex = rand(0,$intQuoteCount);
			$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
			
			//print("<pre>");
			//print_r($arrRandomQuoteDetail);
			//exit;
			
			$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
			
			/* print("<pre>");
			print_r($arrCompleteRegistrationFieldDetail); */
			
			if($this->request->is('post'))
			{
				/*print("<pre>");
				print_r($this->request->data);
				exit;*/
				
				$arrUniqueFieldsConditions = array();
				$strShare = "";
				if(isset($this->request->data['share']))
				{
					$strShare = $this->request->data['share'];
				}
				if(isset($this->request->data['regmethod']))
				{
					$strCandidateRegMethod = $this->request->data['regmethod'];
				}
				$strFname = "";
				$strEmail = "";
				
				$this->loadModel('PortalUser');
				if(!isset($this->Captcha))	
				{ 
					//if Component was not loaded throug $components array()
					$this->Captcha = $this->Components->load('Captcha'); //load it
				}
				
				/*$this->PortalUser->validate[] = array(
														'captcha'=>array(
																		'rule' => array('matchCaptcha'),
																		'message'=>'Failed validating human check.'
																	)
													);*/
				//print("<pre>");
				//print_r($arrCompleteRegistrationFieldDetail);
				//exit;
				foreach($arrCompleteRegistrationFieldDetail as $arrRegistrationFields)
				{
					
					
					if($arrRegistrationFields['career_portal_registration_form_fields']['career_portal_registration_form_field_enabled'])
					{
						if(strpos($arrRegistrationFields['career_portal_registration_form_fields']['career_portal_registration_form_field_label'],"Captcha") !== false)
						{
							$this->PortalUser->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
						}
					}
					
					if(is_array($arrRegistrationFields['fields_validation']) && (count($arrRegistrationFields['fields_validation'])>0))
					{
						
						foreach($arrRegistrationFields['fields_validation'] as $arrValidationDetail)
						{
							switch($arrValidationDetail['validation_rule_table']['validation_rule'])
							{
								case"notempty": //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Not Empty',array('rule' => 'notEmpty','message' => 'Cannot leave the field empty'));
												$this->PortalUser->validate['candidate_'.$arrRegistrationFields['fields_table']['field_name']]['Not Empty'] = array('rule' => 'notEmpty','message' => 'Cannot leave the field empty');
												break;
								case"email": 	//$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
												$this->PortalUser->validate['candidate_'.$arrRegistrationFields['fields_table']['field_name']]['Email'] = array('rule' => 'email','message' => 'Provided email address was not correct');
												break;
							}
						}
					}					
					
					switch($arrRegistrationFields['fields_table']['field_type'])
					{
						case 'password' : $this->request->data['PortalUser']['candidate_password_decrypted'] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
											$this->request->data['PortalUser']['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = AuthComponent::password($this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']]);
										  break;
						case 'text' : 	$this->request->data['PortalUser']['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
										break;
					}
					
					
					if($arrRegistrationFields['fields_table']['field_is_unique'])
					{
						$arrUniqueFieldsConditions['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					$strCurrentFieldName = 'candidate_'.$arrRegistrationFields['fields_table']['field_name'];
					if($strCurrentFieldName == "candidate_first_name")
					{
						$strFname = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					
					if($strCurrentFieldName == "candidate_email")
					{
						$strEmail = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					
					if($strCurrentFieldName == "candidate_username")
					{
						$strCandidateUsername = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
				}
				$arrUniqueFieldsConditions['career_portal_id'] = $intPortalId;
				
				/* print("<pre>");
				print_r($arrUniqueFieldsConditions);
				exit; */
				
				
				$intCountCandidateExists = $this->PortalUser->find('count',array('conditions'=>$arrUniqueFieldsConditions));
				if($intCountCandidateExists)
				{
					
					$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  This account is already been registered, Please try again with other details</div>');
				//	$this->Session->setFlash('This account is already been registered, Please try again with other details');
				}
				else
				{
					$this->request->data['PortalUser']['career_portal_id'] = $intPortalId;
					//print("<pre>");
					//print_r($this->request->data);exit;
					
					$this->PortalUser->set($this->request->data);
					//print("<pre>");
					//print_r($this->PortalUser->validates());exit;
					if(is_array($this->PortalUser->validate) && (count($this->PortalUser->validate)>0))
					{
						if($this->PortalUser->validates())
						{
							 $boolCandidateRegistered = $this->PortalUser->save($this->request->data);
						
							
							if($boolCandidateRegistered)
							{
									$this->loadModel('Email');
									
							$emailContent = $this->Email->find('first', array(
        'conditions' => array('Email.template_key' =>'registration')
    ));
	
								$intLastCandidateInsertedId = $this->PortalUser->getInsertID();
								//$boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname,$strEmail,$intLastCandidateInsertedId,$arrPortalDetail[0]['Portal']['career_portal_name'],$intPortalId,$emailContent['Email']);
								$arrMixPanelRegisteredData = array();
								$arrMixPanelRegisteredData['username'] = $strFname;
								$arrMixPanelRegisteredData['useremail'] = $strEmail;
								$arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
								$arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
								$arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod; 
								// set default role for the portal in LMS
								//$compLms = $this->Components->load('LmsBridge');
								//$arrSeekerLmsSetup = $compLms->fnSetupSeeker($arrPortalDetail['0']['Portal']['career_portal_id'],$strEmail);
								/*print("<pre>");
								 print_r($arrSeekerLmsSetup);
								exit; */
								
								
								// based on user request share on facebook
								if($strShare == "facebook")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									//$boolShared = $this->SocialRegister->fnShareUserRegistrationOnFacebook($arrPortalDetail);
								}
								// based on user request share on twitter
								if($strShare == "twitter")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									//$boolShared = $this->SocialRegister->fnShareUserRegistrationOnTwitter($arrPortalDetail);
								}
								// based on user request share on linkedin
								if($strShare == "linkedin")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									//$boolShared = $this->SocialRegister->fnShareUserRegistrationOnLinkedIn($arrPortalDetail);
								}
								
								$this->loadModel('Candidate');
								$arrCandidateDetail = $this->Candidate->find('first', array(
									'conditions' => array('candidate_id'=> $intLastCandidateInsertedId)
								));
								$this->request->data['Candidate']['candidate_email'] = addslashes(trim($arrCandidateDetail['Candidate']['candidate_email']));
								$this->request->data['Candidate']['candidate_password'] = addslashes(trim($arrCandidateDetail['Candidate']['candidate_password_decrypted']));
								$this->Candidate->set($this->request->data);
								if($this->Candidate->validates())
								{
									if($this->Auth->login())
									{
										$arrLoggedInUser = $this->Auth->user();
										$arrReturResult = array();
										$arrReturResult['status'] = "success";
										$arrReturResult['userid'] = $arrLoggedInUser['candidate_id'];
										$arrReturResult['username'] = $arrLoggedInUser['candidate_username'];
										$arrReturResult['useremail'] = $arrLoggedInUser['candidate_email'];
										//$arrReturResult['redirecturl'] = Router::url($this->Auth->redirectUrl(),true);
										$arrReturResult['redirecturl'] = Router::url(array('controller'=>'portal','action'=>'index',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']),"1"),true);
										//$arrReturResult['redirecturl'] = Router::url(array('controller'=>'portal','action'=>'index',strtolower($arrPortalDetail[0]['Portal']['career_portal_name'])),true);
										$arrReturResult['userportalid'] = $arrLoggedInUser['career_portal_id'];
										 $message = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  You are now registered, Please check your email for confirmation</div>'; 
										$_SESSION['message']=$message;
										$this->Session->write('userregistered','1');
										//$_SESSION['userregistered']="1";
										//print("")
										
								$this->set('isRegistrationDone',"1");
								$this->set('arrMixPanelUserRegData',$arrMixPanelRegisteredData);
										$this->redirect($this->Auth->redirectUrl());					
									}
									else
									{
										$arrResultSet = array();
										$arrResultSet['status'] = "failure";
										$arrResultSet['message'] = "Your username and password combination was incorrect.";
										$this->Session->setFlash('Your username and password combination was incorrect');
										
									}
								}
								
								
							}
							
						}
						else
						{
							$errors = $this->PortalUser->invalidFields();
							$strCandidateRegerrorMessage = "";
							if(is_array($errors) && (count($errors)>0))
							{
								$intErrorCnt = 0;
								foreach($errors as $errorVal)
								{
									$intErrorCnt++;
									if($intErrorCnt == "1")
									{
										$strCandidateRegerrorMessage .= "Error: ".$errorVal['0'];
									}
									else
									{
										$strCandidateRegerrorMessage .= "<br> Error: ".$errorVal['0'];
									}
								}
								$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Error occured! Please try again.</div>');
								//$this->Session->setFlash($strCandidateRegerrorMessage);
							}
						}
					}
					else
					{
						 $boolCandidateRegistered = $this->PortalUser->save($this->request->data);
						
						if($boolCandidateRegistered)
						{
							$this->loadModel('Email');
							$emailContent = $this->Email->find('first', array(
        'conditions' => array('Email.template_key' =>'registration')
    ));
							
							
							$intLastCandidateInsertedId = $this->PortalUser->getInsertID();
							$boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname,$strEmail,$intLastUserInsertedId,$arrPortalDetail[0]['Portal']['career_portal_name'],$intPortalId,$emailContent['Email']);
							$this->Session->setFlash('You are now registered, Please check your email for confirmation','default',array('class' => 'success'));
							$arrMixPanelRegisteredData = array();
							$arrMixPanelRegisteredData['username'] = $strFname;
							$arrMixPanelRegisteredData['useremail'] = $strEmail;
							$arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
							$arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
							$arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod;
							$this->set('isRegistrationDone',"1");
							$this->set('arrMixPanelUserRegData',$arrMixPanelRegisteredData);
						}
					}
				}
			}
		}
	
			
		}
		else
		{
			$this->set('strPortalNotFoundMessage',"URL Broken");
		}
	}
	//PORTAL EMPLOYER THEME FRONTEND
	public function themehome($strPortalName="")
	{
		//Configure::write('debug', 2);
		$this->loadModel('Portal');
		
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
		
		
		if($intPortalExists)
		{
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
			$this->loadModel('PortalTheme');
			//$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);					
			$arrPortalThemeDetail = $this->PortalTheme->find('first', array(
			'fields' => array('Wiztheme.*','Portal.*'),
				'joins' => array(
				array(
					'table' => 'wizard_theme',
					'alias' => 'Wiztheme',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Wiztheme.theme_id = PortalTheme.career_portal_theme_id')
				),array(
					'table' => 'career_portal',
					'alias' => 'Portal',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Portal.career_portal_id = PortalTheme.career_portal_id')
				)
			),'conditions'=>array('Portal.career_portal_name'=>$strPortalName)));
			//echo $this->params['action']; exit();
			//echo "<pre>"; print_r($arrPortalThemeDetail); exit();
			if($this->params['action'] == "themehome")
			{
				
				$this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-FRONTEND';
			}
			if($this->params['action'] == "themepage")
			{
				$this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-FRONTENDPAGE';
			}
			//exit;		
			//echo '<pre>';print_r($arrPortalThemeDetail);exit();
			$intPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$intPortalId),));
				/* print("<pre>");
				print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
				
				// courses detail
			$compLmsBridge = $this->Components->load('LmsBridge');
			$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				/*print("<pre>");
				print_r($arrCourseDetails);*/
			$this->set('arrCoursesDetails',$arrCourseDetails);
				
			$this->loadModel('PortalPages');
			$arrPageList = $this->PortalPages->find('list',array('fields'=>array('PortalPages.career_portal_page_id', 'PortalPages.career_portal_page_tittle'),"conditions"=>array('career_portal_id'=>$intPortalId),"order"=>array('career_portal_page_createddatetime'=>'DESC')));
			$this->set('arrPortalPageDetailList',$arrPageList);
				
			$arrPortalHomePageDetail = $this->PortalPages->find('all',array('conditions' => array('career_portal_id' => $intPortalId,'is_career_portal_home_page'=> '1')));
			$this->set('arrPortalPageDetail',$arrPortalHomePageDetail);
		}	
	}
	public function themepage($intPageId)
	{
		//Configure::write('debug', 2);
		//$this->layout = 'THEME-DESIGN-1-RED-FRONTENDPAGE';	
		echo $strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		$this->loadModel('PortalTheme');
			//$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);					
			$arrPortalThemeDetail = $this->PortalTheme->find('first', array(
			'fields' => array('Wiztheme.*','Portal.*'),
				'joins' => array(
				array(
					'table' => 'wizard_theme',
					'alias' => 'Wiztheme',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Wiztheme.theme_id = PortalTheme.career_portal_theme_id')
				),array(
					'table' => 'career_portal',
					'alias' => 'Portal',
					'type' => 'inner',
					'recursive' => -1,
					'conditions'=> array('Portal.career_portal_id = PortalTheme.career_portal_id')
				)
			),'conditions'=>array('Portal.career_portal_id'=>$arrPageDetail['1'])));
			//echo '<pre>';print_r($arrPortalThemeDetail); exit();
		   if($this->params['action'] == "themehome")
			{
				
				$this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-FRONTEND';
			}
			if($this->params['action'] == "themepage")
			{
				$this->layout = $arrPortalThemeDetail['Wiztheme']['theme_name'].'-'.$arrPortalThemeDetail['Wiztheme']['theme_color'].'-FRONTENDPAGE';
			}	
			
		//$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrPageDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrPageDetail['1'])
								));			
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				//echo "HI";
				$this->set('arrPortalDetail',$arrPortalDetail);
				
				// load portal theme and its details
				$this->loadModel('PortalTheme');
				$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);
				if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
				{
					$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
				}				
				
				// load portal theme page widgets
				$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
				$this->loadModel('PortalThemePageWidgets');
				//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
				$arrPortalThemePageWidgets = $this->PortalThemePageWidgets->fnLoadPortalThemePageWidgetDetail($arrPageDetail['0'],$arrPageDetail['1']);
				if(is_array($arrPortalThemePageWidgets) && (count($arrPortalThemePageWidgets)>0))
				{
					$this->set('arrPortalWidgets',$arrPortalThemePageWidgets);
				}
				else
				{
					// load portal theme widgets
					$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
					$this->loadModel('PortalThemeWidgets');
					//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
					$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId,$arrPageDetail['1']);
					if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
					{
						$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
					}
				}				
				
				$this->loadModel('TopMenu');
				$arrMenuDetail = $this->TopMenu->find('all',array('conditions'=>array('career_portal_id'=>$arrPageDetail['1']),'order'=>array('TopMenu.career_portal_menu_order'=>'ASC')));
				/* print("<pre>");
				print_r($arrMenuDetail); */
				if(is_array($arrMenuDetail) && (count($arrMenuDetail)>0))
				{
					$this->set('arrPortalMenuDetail',$arrMenuDetail);
				}
				$this->loadModel('PortalPages');
				$arrPortalPageDetail = $this->PortalPages->find('all', array(
										'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
									));
						
				/*print("<pre>");
				print_r($arrPortalPageDetail);
				exit;*/
				$this->set('arrPortalPageDetail',$arrPortalPageDetail);
				if(strpos($arrPortalPageDetail[0]['PortalPages']['career_portal_page_tittle'],"Contact")  !== False)
				{
					$this->loadModel('PortalContactForm');
					$arrContactFormDetail = $this->PortalContactForm->find('all',array('conditions'=>array('PortalContactForm.career_portal_id'=>$arrPageDetail['1'],'PortalContactForm.career_portal_contact_us_form_is_active'=>'1')));
					//print("<pre>");
					//print_r($arrContactFormDetail);
					if(is_array($arrContactFormDetail)  && (count($arrContactFormDetail)>0))
					{
						$this->loadModel('ContactFormFields');
						//$arrContactFormFields = $this->ContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'])));
						$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
						if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
						{
							$intContactFormFieldCount = 0;
							foreach($arrContactFormFields as $arrContactFFields)
							{
								$arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
								$arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
								$intContactFormFieldCount++;
							}
							$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
						}
						$this->set('arrContactFormDetail',$arrContactFormDetail);
					}
				}				
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
				/* print("<pre>");
				print_r($arrLatesJobDetail); */
				
				$this->loadModel('JCountry');
				$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
				asort($arrJCountries);
				$this->set('arrJcountry',$arrJCountries);
				
				
				$this->loadModel('JobCategory');
				$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
				$arrJCategories["0"] = "Choose Category";
				ksort($arrJCategories);
				$this->set('arrJcategories',$arrJCategories);
				
				
				$this->loadModel('JobExperience');
				$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
				$arrJobInitialVal["0"] = "Choose Experience";
				//ksort($arrJobExperience);
				$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
				$this->set('arrJobExperience',$arrNewMergedJobExp);
				
				// courses detail
				$compLmsBridge = $this->Components->load('LmsBridge');
				$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				/*print("<pre>");
				print_r($arrCourseDetails);*/
				
				$this->loadModel('Portalpagetemplates');
				$arrPortalPageTemplates = $this->Portalpagetemplates->find('all',array('fields'=>array('career_portal_page_template_id','career_portal_page_tittle')));
				
				$this->set('arrPortalPageTemplates',$arrPortalPageTemplates);
				
				$this->set('arrCoursesDetails',$arrCourseDetails);

			}
			
		}
	}
	public function resendemail($portalid)
	{
		if($portalid)
		{
			$arrLoggedUser = $this->Auth->user();
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_name' => $strPortalName)
								));
			$strFname = $arrLoggedUser['candidate_first_name'];
			$strEmail = $arrLoggedUser['candidate_email'];
			$intLastCandidateInsertedId = $arrLoggedUser['candidate_id'];
			
			$boolresendmail = $this->fnSendPortalRegistrationResendConfirmationEmail($strFname,$strEmail,$intLastCandidateInsertedId,$arrPortalDetail[0]['Portal']['career_portal_name'],$portalid);
			if($boolresendmail)
			{
				
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Email has been sent your account successfully.";
			}
			else
			{
				$arrResponse['status'] = "success";
							$arrResponse['message'] = "Email not has been sent.";
			}
			echo json_encode($arrResponse);
			exit();
		}
	}
	public function index1($strPortalName = "")
	{
		
	}
	public function index2($strPortalName = "")
	{
		
	}
	public function index3($strPortalName = "")
	{
		
	}
	public function index4($strPortalName = "")
	{
		
	}
	public function index5() {

	}

	public function share()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($_GET['shareon'] && $_GET['shareurl'])
		{
			$_SESSION['ShareOn'] = $_GET['shareon'];
			$_SESSION['ShareUrl'] = $_GET['shareurl'];
		}
		
		$strShareOn = $_SESSION['ShareOn'];
		$strShareData = $_SESSION['ShareUrl'];
		if($strShareOn && $strShareData)
		{
			$compSocialRegister = $this->Components->load('FbRegister');
			switch($strShareOn)
			{
				case"fb": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnFacebook($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was shared successfully on facebook";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
				case"tw": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnTwitter($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was tweeted successfully on twitter";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
				case"li": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnLinkedIn($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was tweeted successfully on twitter";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing input parameters, Please try again";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function socailshare($portalid,$shareon,$jobid)
	{
		
		/*if($_GET['shareon'] && $_GET['shareurl'])
		{
			$_SESSION['ShareOn'] = $_GET['shareon'];
			$_SESSION['ShareUrl'] = $_GET['shareurl'];
		}*/
		
		$strShareOn = $shareon;
		$strShareData = $jobid;
		$strShareData = Router::url('/',true)."portal/getjobdetail/".$portalid."/".$jobid;
		if($strShareOn && $strShareData)
		{
			$compSocialRegister = $this->Components->load('FbRegister');
			switch($strShareOn)
			{
				case"fb": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnFacebook($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was shared successfully on facebook";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
				case"tw": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnTwitter($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was tweeted successfully on twitter";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
				case"li": $arrPortalDetail['link'] = $strShareData;
						  $boolShared = $compSocialRegister->fnShareOnLinkedIn($arrPortalDetail);
						  if($boolShared)
						  {
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "This was tweeted successfully on twitter";
							$_SESSION['ShareOn'] = "";
							$_SESSION['ShareUrl'] = "";
						  }
						  else
						  {
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "There was some issue, please try again";
						  }
						  break;
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing input parameters, Please try again";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function jobsearch($intPortalId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('strPortalNotFoundMessage',"");
			
			$arrSearchPostedValues = array();
			$this->set("strKeywords","");
			$this->set("strlocation","");
			$this->set("strCategory","");
			

			
			if($this->request->is('post'))
			{
				/* print("<pre>");
				print_r($this->request->data);
				exit */
				$arrSearchString = array();
				$arrSearchPostedValues['keywords'] = $strKeywords = addslashes(trim($this->request->data['keywords']));
				$arrSearchPostedValues['location'] = $strLocation = addslashes(trim($this->request->data['location']));
				$arrSearchPostedValues['country'] = $strLocation = addslashes(trim($this->request->data['txt_country']));
				$arrSearchPostedValues['category'] = $strCategory = $this->request->data['category'];
				$arrSearchPostedValues['experience'] = $strExperience = $this->request->data['experience'];
				$arrSearchPostedValues['jobtype'] = $strJobType = $this->request->data['job_type'];
				$arrSearchPostedValues['searchtype'] = $strJobType = $this->request->data['search_type'];
				$isAdvanceSearch = $this->request->data['adv_search'];
				
				
				if($arrSearchPostedValues['keywords'])
				{
					$arrSearchString[] = "q=".urlencode($arrSearchPostedValues['keywords']);
				}
				
				if($arrSearchPostedValues['location'])
				{
					$arrSearchString[] = "location=".urlencode($arrSearchPostedValues['location']);
				}
				
				if($arrSearchPostedValues['country'])
				{
					$arrSearchString[] = "txt_country=".urlencode($arrSearchPostedValues['country']);
				}
				
				/*print("<pre>");
				print_r($arrSearchPostedValues);
				exit;*/
				if(is_array($arrSearchPostedValues['category']) && (count($arrSearchPostedValues['category'])>0))
				{
					foreach($arrSearchPostedValues['category'] as $arrCat)
					{
						if($arrCat == "0")
						{
							continue;
						}
						else
						{
							$arrSearchString[] = "category[]=".urlencode($arrCat);
						}
					}
				}
				else
				{
					if($arrSearchPostedValues['category'])
					{
						$arrSearchString[] = "category[]=".urlencode($arrSearchPostedValues['category']);
					}
				}
				
				if($arrSearchPostedValues['experience'])
				{
					$arrSearchString[] = "experience=".urlencode($arrSearchPostedValues['experience']);
				}
				
				if($arrSearchPostedValues['jobtype'])
				{
					$arrSearchString[] = "job_type=".urlencode($arrSearchPostedValues['jobtype']);
				}
				
				if($arrSearchPostedValues['searchtype'])
				{
					$arrSearchString[] = "search_type=".urlencode($arrSearchPostedValues['searchtype']);
				}
				
				$arrSearchString[] = "portid=".$intPortalId;
				$strSearchQueryString = implode("&",$arrSearchString);
				
				$strSearchQueryString = Configure::read('Jobber.seekerjobsearchurl')."?".$strSearchQueryString;
				
				//echo "--".$strSearchQueryString;
				$this->set("strJobSearchUrl",$strSearchQueryString);
				
				$this->set("strKeywords",$arrSearchPostedValues['keywords']);
				$this->set("strlocation",$arrSearchPostedValues['location']);
				$this->set("strCategory",$arrSearchPostedValues['category']);
				$this->set("strSearchMode","Basic");
				if($isAdvanceSearch)
				{
					$this->set("strSearchMode","Advance");
				}
			}
		}
	}
	
	public function jobdetail($intPortalId = "",$intJobId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('strPortalNotFoundMessage',"");
			
			
			$strJobDetailUrl = Configure::read('Jobber.seekerjobdetailurl').$intJobId."/?portid=".$intPortalId;
			$this->set('strJobDetailUrl',$strJobDetailUrl);
		}
	}
	
	public function getjobdetail($intPortalId = "",$intJobId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrLoggedUser = $this->Auth->user();
			
			$candidate_id = $arrLoggedUser['candidate_id'];
			
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('intJobId',$intJobId);
			$this->set('intCandidateId',$candidate_id);
			
			$this->loadModel('Job');
			

		     $arrJobDetail = $this->Job->find('first', array(
			'fields' => array('Job.*','jobexperience.experience_name','jobecareer.career_name','jobeducation.education_name'),
			'joins' => array(
			array(
				'table' => 'jobberland_education',
				'alias' => 'jobeducation',
				'type' => 'left',
				'recursive' => -1,
				'conditions'=> array('jobeducation.id = Job.fk_education_id')
			),
			array(
				'table' => 'jobberland_career_degree',
				'alias' => 'jobecareer',
				'type' => 'inner',
				'recursive' => -1,
				'conditions'=> array('jobecareer.id = Job.fk_career_id')
			),
			array(
				'table' => 'jobberland_experience',
				'alias' => 'jobexperience',
				'type' => 'left',
				'recursive' => -1,
				'conditions'=> array('jobexperience.id = Job.fk_experience_id')
			)
			) ,'conditions'=>array('Job.id'=>$intJobId)));
			
			
			$this->set('arrJobDetail',$arrJobDetail);
			
		}
	}
	
	
	public function updateevent($intPortalId = "")
	{		
		//if($this->request->is('Post'))
		//{
			if($intPortalId)
			{
				/* if($this->Auth->loggedIn())
				{ */
					//$arrLoggedUserDetails = $this->Auth->user();
					$this->loadModel('Portal');
					$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					
					if($intPortlExists)
					{
						$arrEventDetail = array();
						$this->request->data['Event']['event_name'] = $arrEventDetail['eventname'] = $strEventName = addslashes(trim($_POST['event_name']));
						$this->request->data['Event']['event_description'] = $arrEventDetail['eventdesc'] = $strEventDescription = addslashes(trim($_POST['event_dsec']));
						$this->request->data['Event']['event_date_time'] = $arrEventDetail['eventdatetime'] = $strEventdatetime = addslashes(trim($_POST['event_date_time']));
						$this->request->data['Event']['event_venue'] = $arrEventDetail['eventvenu'] = $strEventVenue = addslashes(trim($_POST['event_venue']));
						$this->request->data['Event']['event_contact_person'] = $arrEventDetail['eventcontactperson'] = $strEventContactPerson = addslashes(trim($_POST['event_contact_name']));
						$this->request->data['Event']['event_reminder'] = $arrEventDetail['eventreminder'] = $strEventReminder = addslashes(trim($_POST['event_reminder']));
						$this->request->data['Reminder']['reminder_frequency'] = $arrEventDetail['eventreminderfrequency'] = $strEventReminderFrequency = "";
						if($strEventReminder)
						{
							$this->request->data['Reminder']['reminder_frequency'] = $arrEventDetail['eventreminderfrequency'] = $strEventReminderFrequency = addslashes(trim($_POST['event_reminder_frequency']));
						}
						$this->request->data['Event']['event_type'] = $arrEventDetail['eventtype'] = $strEventType = addslashes(trim($_POST['event_type']));
						
						$this->request->data['Eventparticipant']['event_participant_type'] = $arrEventDetail['eventparticipanttype'] = $strEventParticipantType = addslashes(trim($_POST['participant_type']));
						$this->request->data['Eventparticipant']['event_participant_id'] = $arrEventDetail['eventparticipantid'] = $strEventParticipantId = addslashes(trim($_POST['participant_id']));
						$this->request->data['Eventparticipant']['event_participant_reg_by'] = addslashes(trim($_POST['participant_id']));
						
						$this->request->data['Eventorganizer']['event_organizer_type'] = $arrEventDetail['eventorganizationtype'] = $strEventOrganizerType = addslashes(trim($_POST['organization_type']));
						$this->request->data['Eventorganizer']['event_organizer_head_id'] = $arrEventDetail['eventorganizerid'] = $strEventOrganizerId = addslashes(trim($_POST['organization_head_id']));
						$this->request->data['Eventorganizer']['event_organization_registered_by'] = addslashes(trim($_POST['participant_id']));
						
						$this->request->data['Eventsubject']['event_subject_type'] = $arrEventDetail['eventsubjecttype'] = $strEventSubjectType = addslashes(trim($_POST['event_subject_type']));
						$this->request->data['Eventsubject']['event_subject_id'] = $arrEventDetail['eventsubjectid'] = $strEventSubjectId = addslashes(trim($_POST['event_subject_id']));
						$this->request->data['Eventsubject']['event_subject_registered_by'] = addslashes(trim($_POST['participant_id']));
						
						$arrEventDetail['creadtedby'] = addslashes(trim($_POST['participant_id']));
						
						/*print("<pre>");
						print_r($this->request->data['Eventparticipant']);
						exit;*/
						
						$this->loadModel('Event');
						$boolEventExistis = $this->Event->fnCheckEventExists($arrEventDetail);
						if($boolEventExistis)
						{
							// update event
							
							/*$this->Event->fnDeleteExistingEvent($arrEventDetail);
							$boolEventCreated = $this->Event->save($this->request->data);
							if($boolEventCreated)
							{
								$this->request->data['Eventsubject']['event_id'] = $this->request->data['Eventorganizer']['event_id'] = $this->request->data['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
								$this->loadModel('Eventparticipant');
								$this->Eventparticipant->save($this->request->data);
								$this->loadModel('Eventorganizer');
								$this->Eventorganizer->save($this->request->data);
								$this->loadModel('Eventsubject');
								$this->Eventsubject->save($this->request->data);
								
								$arrReturn = array();
								$arrReturn['status'] = "success";
								$arrReturn['message'] = "Your Reminder was added successfully";
							}
							else
							{
								$arrReturn = array();
								$arrReturn['status'] = "failure";
								$arrReturn['message'] = "Please try again";
							}*/
							$arrReturn = array();
							$arrReturn['status'] = "failure";
							$arrReturn['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  You have already set Reminder for this event.</div>';
						}
						else
						{
							//insert event
							//$boolEventCreated = $this->Event->fnSaveEvent($arrEventDetail);
							$boolEventCreated = $this->Event->save($this->request->data);
							/* print("<pre>");
							print_r($boolEventCreated);
							exit; */
							if($boolEventCreated)
							{
								$this->request->data['Reminder']['reminder_type_id'] = $this->request->data['Eventsubject']['event_id'] = $this->request->data['Eventorganizer']['event_id'] = $this->request->data['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
								$this->loadModel('Eventparticipant');
								$this->Eventparticipant->save($this->request->data);
								$this->loadModel('Eventorganizer');
								$this->Eventorganizer->save($this->request->data);
								$this->loadModel('Eventsubject');
								$this->Eventsubject->save($this->request->data);
								
								$this->loadModel('Reminder');
								$this->request->data['Reminder']['reminder_status'] = "active";
								$this->request->data['Reminder']['reminder_created_by'] = addslashes(trim($_POST['participant_id']));
								$objTimeComponent = $this->Components->load('TimeCalculation');
								
								$this->request->data['Reminder']['reminder_time'] = $objTimeComponent->fnGetBeforeTime($arrEventDetail['eventreminderfrequency'],$arrEventDetail['eventdatetime']);
								$this->request->data['Reminder']['reminder_text'] = $arrEventDetail['eventdesc'];
								$this->Reminder->fnInsertReminder($this->request->data['Reminder']);
								//$this->Reminder->save($this->request->data);
								
								$arrReturn = array();
								$arrReturn['status'] = "success";
								$arrReturn['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Your Reminder was added successfully</div>';
							}
							else
							{
								$arrReturn = array();
								$arrReturn['status'] = "failure";
								$arrReturn['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Please try again</div>';
							}
						}
					}
				/* }
				else
				{
					$arrReturn = array();
					$arrReturn['status'] = "failure";
					$arrReturn['message'] = "Not Logged In";
				} */
			}
			else
			{
				$arrReturn = array();
				$arrReturn['status'] = "failure";
				$arrReturn['message'] = "Organizer Missing";
			}
		/* }
		else
		{
			$arrReturn = array();
			$arrReturn['status'] = "failure";
			$arrReturn['message'] = "Bad Request";
		} */
		
		echo json_encode($arrReturn);
		exit;
	}
	
	public function sharewithfriend($intPortalId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrLoggedUser = $this->Auth->user();
			
			$candidate_id = $arrLoggedUser['candidate_id'];
			
			
			$error = array();

	/** SNED to email address and check for vaildation on entered emails */

		$jobid	=  $_POST['jobid'] ;
		$candidate_id = $arrLoggedUser['candidate_id'];
		$send_to = $_POST['txt_send_to1'];
		if ( $send_to == "" ){

			$error[] = 1;

		}
		

		if ($send_to != ""){

			$send = split(",", $send_to);

			for ($i=0; $i < sizeof($send); $i++ ){

				$ch = $this->check_email( $send[$i] );

				if ($ch == ""){

					$error[]= 1;

				}

			}

		}

	
			$link = Router::url('/', true)."portal/getjobdetail/".$intPortalId."/".$jobid;
		/**subject */
		$subject =  $_POST['txt_subject'] ;

		if ( $subject == "" ){

			$subject = "Re: ";

		}

	

	$comments = $_POST['txt_comments'];


		/*$txt_email1 =  $_POST['txt_email1'] ;

		

		if ( $txt_email1 != "" ){

			$txt_email1 = $this->check_email( $txt_email1 );

			if ($txt_email1 == ""){

				$error[]= 1;

			}

		}*/
		
		if(count($error)>0)
		{
					$arrReturn = array();
					$arrReturn['status'] = "error";
					$arrReturn['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Please check something wrong happen.</div>';
		}
		else
		{
			 if(count($send)>0)
			 {
				 	for ($i=0; $i < count($send); $i++ ){

							$email =  $send[$i] ;

			
							$bool = $this->fnSendShareJobEmail($email,$link,$comments,$subject);
					}
				
			 }
					$arrReturn = array();
						$arrReturn['status'] = "success";
						$arrReturn['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Job shared successfully with your friends.</div>';
			 
		}
		echo json_encode($arrReturn);
		exit;


	}
		
		
   }
	public function applyJob($intPortalId = "",$intJobId = "")
	{
		//Configure::write('debug','2');
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			//print("<pre>");
			//print_r($arrLoggedUser);
			//exit;
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('arrLoggedUser',$arrLoggedUser);
			$arrLoggedUser = $this->Auth->user();
			// get cover letters 
			$this->loadModel('Candidate_Cv');
			$this->loadModel('CandidateCvDetail');
			$this->loadModel('CandidateCoverDetail');
			$arrCvDetail = $this->Candidate_Cv->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
			//print('<pre>');
			//print_r($arrCvDetail);
			
			
			/*$arrCvDetail = $this->CandidateCvDetail->find('list', array(
									'fields'=>array('id','cv_title'),
									'conditions' => array('fk_employee_id'=> $arrLoggedUser['candidate_id'])
								));
			$arrCoverDetail = $this->CandidateCoverDetail->find('list', array(
									'fields'=>array('id','cl_title'),
									'conditions' => array('fk_employer_id'=> $arrLoggedUser['candidate_id'])
								));*/
	
		

		   $this->set('arrCvDetail',$arrCvDetail);
		   $this->set('arrCoverDetail',$arrCoverDetail);
			if(isset($_POST['submit']))
			{
				$this->loadModel('JobsApplied');
				/// check if allready applied by user
					$cntapply = $this->JobsApplied->find('count',array( 'conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'job_id'=>$intJobId)));
					if($cntapply>0)
					{
						$this->Session->setFlash('<div class="alert alert-success">
									  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
									  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
									   You have applied allready for this job.
									</div>');
					}
					else
					{
						$applyemail 		=  $email =  $_POST['txt_email1'] ;
						$working_status = $_POST['txt_working_status'] ;
						$which_letter 	= $_POST['txt_which_letter'];
						$cover_letter 	= empty($_POST['txt_letter']) ? "" :  $_POST['txt_letter'] ;
						$which_cv 	= $_POST['txt_existed_cv'];
						$fname = $_POST['txt_fname'];		
						$sname  = $_POST['txt_sname'];
						$full_name = $fname . " ".$sname;
						$address = $_POST['txt_address'];				
						$htel = $_POST['txt_tel'];
						$mtel = $_POST['txt_mob'];
						$notice = $_POST['txt_notice'];
						$salary = $_POST['txt_salary'];
						$txt_willing_to_travel = $_POST['txt_willing_to_travel'];
						$arrJobApp['JobsApplied']['job_portal_id'] = $arrLoggedUser['career_portal_id'];
						$arrJobApp['JobsApplied']['job_id'] = $intJobId;
						$arrJobApp['JobsApplied']['candidate_id'] = $arrLoggedUser['candidate_id'];
						$arrJobApp['JobsApplied']['candidate_cv_id'] = $which_cv;
						$arrJobApp['JobsApplied']['comment'] = $_POST['comment'];
						
						$this->JobsApplied->set($arrJobApp);
						$arrJASaved = $this->JobsApplied->save($arrJobApp);
						if(is_array($arrJASaved) && (count($arrJASaved)>0))
						{
							$this->Session->setFlash('<div class="alert alert-success">
									  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
									  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
									   Application sent successfully.
									</div>');
						}
						else
						{
							$this->Session->setFlash('<div class="alert alert-success">
									  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
									  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
									   Some issue, Please try applying again.
									</div>');
						}
						
					}	
			}
		}
	}
	
	public function logout($intPortalId = "",$strSwitchBack = "")
	{
		/* if(!$intPortalId) 
		{
			$intPortalId = Configure::read('PrivatePortal.id');
		} */
		?>
		<script>
		setcookie('visitedPopup', '0');
		</script>
		<?php
		$this->autoRender = false;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			if(is_numeric($intPortalId))
			{
				$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			}
			else
			{
				$arrPortalDetail = $this->Portal->find('all', array(
								'conditions' => array('career_portal_name'=> $intPortalId)
							));
			}
			
			/*print("<pre>");
			print_r($arrPortalDetail);*/
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$strLogoutPath = $this->Auth->logout();
			
			/*$compCandidates = $this->Components->load('Candidates');
			$isJobebrTokenUpdated = $compCandidates->fnUpdateCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$isLmsTokenUpdated = $compCandidates->fnUpdateCandidateLmsToken($arrLoggedUser['candidate_id']);*/
			if($strSwitchBack)
			{
				$strUrlToGo = $_SESSION['switchurltogo']."/1";
				$this->redirect($strUrlToGo);
			}
			else
			{
				$this->redirect($strLogoutPath);
			}
		}
	
	}
	
	public function login($intPortalId = "")
	{
		 set_time_limit(0);
		//SET GLOBAL max_allowed_packet=1073741824;
		if(!$intPortalId)
		{
			if(isset($this->request->data['PortalUser']['portal_id']))
			{
				 $intPortalId = $this->request->data['PortalUser']['portal_id'];				
			}
			else
			{
				
				$arrReturResult = array();
				$arrReturResult['status'] = "failure";
				$arrReturResult['message'] = "Bad Request";
				echo json_encode($arrReturResult);
				exit;
			}
		}
		
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			// Load Quotes
			$this->loadModel('Content');
			$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
			$intRandomQuoteIndex = rand(0,$intQuoteCount);
			$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
			
			//print("<pre>");
			//print_r($arrRandomQuoteDetail);
			//exit;
			
			$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
			if($this->request->is('post'))
			{
				/* print("<pre>");
				print_r($this->request->data); */
				
				$this->loadModel('Candidate');
				$this->request->data['Candidate']['candidate_email'] = addslashes(trim($this->request->data['PortalUser']['email']));
				$this->request->data['Candidate']['candidate_password'] = addslashes(trim($this->request->data['PortalUser']['password']));
				
				$this->Candidate->validate['candidate_email']['Not Empty'] = array('rule' => 'notEmpty','message' => 'Cannot leave Email field empty');
				$this->Candidate->validate['candidate_email']['Email'] = array('rule' => 'email','message' => 'Provided email address was not correct');
				$this->Candidate->validate['candidate_password']['Not Empty'] = array('rule' => 'notEmpty','message' => 'Cannot leave Password field empty');
				
				/* print("<pre>");
				print_r($this->request->data);
				exit */;
				$this->Candidate->set($this->request->data);
				if($this->Candidate->validates())
				{
					if($this->Auth->login())
					{
						$arrLoggedInUser = $this->Auth->user();
						$arrReturResult = array();
						$arrReturResult['status'] = "success";
						$arrReturResult['userid'] = $arrLoggedInUser['candidate_id'];
						$arrReturResult['username'] = $arrLoggedInUser['candidate_username'];
						$arrReturResult['useremail'] = $arrLoggedInUser['candidate_email'];
						//$arrReturResult['redirecturl'] = Router::url($this->Auth->redirectUrl(),true);
						$arrReturResult['redirecturl'] = Router::url(array('controller'=>'portal','action'=>'index',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']),"1"),true);
						//$arrReturResult['redirecturl'] = Router::url(array('controller'=>'portal','action'=>'index',strtolower($arrPortalDetail[0]['Portal']['career_portal_name'])),true);
						$arrReturResult['userportalid'] = $arrLoggedInUser['career_portal_id'];
						
						echo json_encode($arrReturResult);
						exit;
						//$this->redirect($this->Auth->redirectUrl());					
					}
					else
					{
						$arrResultSet = array();
						$arrResultSet['status'] = "failure";
						$arrResultSet['message'] = "Your username and password combination was incorrect.";
						$this->Session->setFlash('Your username and password combination was incorrect');
						echo json_encode($arrResultSet);
						exit;
					}
				}
				else
				{
					$errors = $this->Candidate->invalidFields();
					$strCandidateLoginerrorMessage = "";
					if(is_array($errors) && (count($errors)>0))
					{
						$intErrorCnt = 0;
						foreach($errors as $errorVal)
						{
							$intErrorCnt++;
							if($intErrorCnt == "1")
							{
								$strCandidateLoginerrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strCandidateLoginerrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
						$arrResultSet = array();
						$arrResultSet['status'] = "failure";
						$arrResultSet['message'] = $strCandidateLoginerrorMessage;
						$this->Session->setFlash($strCandidateLoginerrorMessage);
						echo json_encode($arrResultSet);
						exit;
					}
				}
			}
			else
			{
				if(is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS'))>0))
				{
					//echo "HI";exit;
					/*print("<pre>");
					print_r($this->Session->read('SOCIALREGISTRATIONDETAILS'));
					exit;*/
					
					$this->loadModel('Candidate');
					$arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
					
					$arrUserExists = $this->Candidate->find('first',array('conditions'=>array('career_portal_id'=>$intPortalId,'candidate_email'=>$arrRegistrationData['SOCIALUSEREMAIL'])));
					/*print("<pre>");
					print_r($arrUserExists);
					exit;*/
					if(is_array($arrUserExists) && (count($arrUserExists)>0))
					{
						$this->Auth->login($arrUserExists['Candidate']);
						
						$arrSeekerData['form_param'] = '1';
						$arrSeekerData['form_upor'] = $arrUserExists['Candidate']['candidate_id'];
						$arrSeekerData['form_upormai'] = $arrRegistrationData['SOCIALUSEREMAIL'];
						$arrSeekerData['form_uporna'] = '';
						$arrSeekerData['form_uporie'] = $intPortalId;
						$arrSeekerData['form_socio'] = "1";
						
						//print("<pre>");
						//print_r($arrSeekerData);	
						
						$compJobberBridge = $this->Components->load('JobberBridge');
						$arrResponse = $compJobberBridge->fnLogSeekerIn($arrSeekerData);
						//echo "HI";
						//print("<pre>");
						//print_r($arrResponse);exit;
						
						// id login success carry on otherwise remove the fb inserted record and ask for try again
						
						if($arrResponse['status'] != "success")
						{
							$this->Auth->logout();
							$this->Session->setFlash("There might be some issue, Please Try Again");
						}
						else
						{
							setcookie("HCJPORTAL".$intPortalId,$arrResponse['sid'],0,"/");
							$compLmsBridge = $this->Components->load('LmsBridge');
							$arrLmsResponse = $compLmsBridge->fnLogSeekerIn($intPortalId,$arrUserExists);
							if($arrLmsResponse['status'] == "success")
							{
								setcookie("_FrontendUser_".$intPortalId,$arrLmsResponse['sid'],0,"/moodle/");
								$arrSessionUpdatedResponse = $this->updatesession($intPortalId,$arrLmsResponse['sesskey'],"",$arrLmsResponse['sesskey'],$arrResponse['st']);
								/*print("<pre>");
								print_r($arrSessionUpdatedResponse);
								exit;*/
								if($arrSessionUpdatedResponse['status'] == "success")
								{
									//echo "--".$arrRegistrationData['logout_url'];
									
									$arrNextLoggInUrl = explode("next=",$arrRegistrationData['logout_url']);
									$strLoggInUrl = urldecode($arrNextLoggInUrl[1]);
									$arrLoginUrl = explode("&",$strLoggInUrl);
									if(is_array($arrLoginUrl) && (count($arrLoginUrl)>0))
									{
										$arrLoginUrl[0] = urlencode(Router::url(array('controller'=>'portal','action'=>'index',$arrPortalDetail[0]['Portal']['career_portal_name'],"1"),true));
									}
									$strLoggInUrl = implode("&",$arrLoginUrl);
									$arrNextLoggInUrl[1] = $strLoggInUrl;
									$arrRegistrationData['logout_url'] = implode("next=",$arrNextLoggInUrl);
								}
								else
								{
									$arrLoggedFromLms = $compLmsBridge->fnLogSeekerOut($arrLmsResponse['sesskey']);
									if($arrLoggedFromLms['status'] == "success")
									{
										$arrSeekerLogout = array('token'=>$arrSeekerData['jb_auth_token']);
										$arrJobberLogutResponse = $compJobberBridge->fnLogSeekerOut($arrSeekerLogout);
										if($arrJobberLogutResponse['status'] == "success")
										{
											$this->Auth->logout();
										}
									}
								}
							}
							
						}
						$this->Session->delete('SOCIALREGISTRATIONDETAILS');
						$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
						$this->redirect($arrRegistrationData['logout_url']);
					}
					else
					{
						$arrNewUserData = array();
						$arrNewUserData['Candidate']['career_portal_id'] = $intPortalId;
						$arrNewUserData['Candidate']['candidate_email'] = $arrRegistrationData['SOCIALUSEREMAIL'];
						$arrNewUserData['Candidate']['candidate_password'] = AuthComponent::password(uniqid(mt_rand()));
						$arrNewUserData['Candidate']['candidate_first_name'] = $arrRegistrationData['SOCIALUSERFNAME'];
						$arrNewUserData['Candidate']['candidate_last_name'] = $arrRegistrationData['SOCIALUSERLNAME'];

						$this->Candidate->create(false);
						$boolCreadted = $this->Candidate->save($arrNewUserData);

						if(is_array($boolCreadted) && (count($boolCreadted)>0))
						{
							$arrSeekerData = array();
							$arrSeekerData['form_param'] = '1';
							$arrSeekerData['form_upor'] = $this->Candidate->getLastInsertID();
							$arrSeekerData['form_upormai'] = $arrNewUserData['Candidate']['candidate_email'];
							$arrSeekerData['form_uporna'] = '';
							$arrSeekerData['form_uporie'] = $intPortalId;
							$arrSeekerData['form_socio'] = "1";
							
							
							
							$compJobberBridge = $this->Components->load('JobberBridge');
							$arrResponse = $compJobberBridge->fnLogSeekerIn($arrSeekerData);
							
							/*print("<pre>");
							print_r($arrResponse);exit;*/
							
							if($arrResponse['status'] != "success")
							{
								$isCandidateDeleted = $this->Candidate->deleteAll(array('Candidate.candidate_id' => $this->Candidate->getLastInsertID()),false);
								$this->Session->delete('SOCIALREGISTRATIONDETAILS');
								$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
								$this->redirect(array('controller'=>'candidates','action'=>'dashboard',$intPortalId));
							}
						}
						else
						{
							//echo "Helo";exit;
						}
						$this->redirect(Router::url(null, true));
					}
				}
			}
		}
	}
	
	public function contactus($intPortalId = "")
	{
		
		$this->autoRender = false;
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				$this->set('intPortalId',$intPortalId);
				$arrContactUs = array();
				
				if($this->request->is('post'))
				{
					//print("<pre>");
					//print_r($this->request->data);
					//exit; 
					
					$strContactusErrorMessage = "";
					$intContactFormId = $this->request->data['contact_form_id'];
					$this->request->data['Contactus']['portal_id'] = $intPortalId;
					if($intContactFormId)
					{
						$this->loadModel('Contactus');
						$this->loadModel('ContactFormFields');
						$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($intContactFormId);
						//print('<pre>');
						//print_r($arrContactFormFields);
						
						if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
						{
							foreach($arrContactFormFields as $arrContactFieldDetail)
							{
								// load validations for form
								$arrContactValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFieldDetail['fields_table']['field_id']);
								//print('<pre>');
								//print_r($arrContactValidations);
							
								$strContacUsColumnPrefixString = 'portal_contacter_';
								
								if(is_array($arrContactValidations) && (count($arrContactValidations)>0))
								{
									
									foreach($arrContactValidations as $arrCintactValidation)
									{
										switch($arrCintactValidation['validation_rule_table']['validation_rule'])
										{
											case"notempty": //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Not Empty',array('rule' => 'notEmpty','message' => 'Cannot leave the field empty'));
															$this->Contactus->validate[$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']]['Not Empty'] = array('rule' => 'notEmpty','message' => 'Cannot leave Mandatory field empty');
															break;
											case"email": 	//$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
															$this->Contactus->validate[$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']]['Email'] = array('rule' => 'email','message' => 'Provided email address was not correct');
															break;
															
											case"captcha": 	//$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
															$this->Contactus->validate[$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']]['captcha'] = array('rule' => 'matchCaptcha','message' => 'Failed validating human check.');
															break;
										}
									}
								}
								
								// Accepting Contact Us Posted Request(data from the form)
								if($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_email_field'])
								{
									$arrContactUs['email'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
								}
								else
								{
									if($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_field_greet_name'])
									{
										$arrContactUs['name'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
									}
									else
									{
										if($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_field_message'])
										{
											$arrContactUs['message'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
										}
										else
										{
											if($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_field_captcha'])
											{
												$arrContactUs['captcha'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
											}
											else
											{
												$arrContactUs['subject'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString.$arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
											}
										}
									}
								}
							}
								//exit;
						}
					}
					//print('<pre>');
					//print_r($arrContactUs);
					//exit;
					if(!isset($this->Captcha))	
					{ 
						//if Component was not loaded throug $components array()
						$this->Captcha = $this->Components->load('Captcha'); //load it
					}
					//echo $this->Captcha->getVerCode();exit;
					$this->Contactus->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
					//print("<pre>");
					//print_r($this->request->data);
					//exit;
					$this->Contactus->set($this->request->data);
					
					//echo "---".$this->Contactus->validates();exit;
					if($this->Contactus->validates())
					{
						$boolContactUsDataSaved = $this->Contactus->save($this->request->data);
						if($boolContactUsDataSaved)
						{
							// set success message
							$this->Session->setFlash('Thanks For Contacting Us, Your Message has been sent, Soon You will be contacted!','default',array('class' => 'success'));
							
							if(isset($arrContactUs['email']))
							{
								
								$this->loadModel('User');
								$arrUserDetail = $this->User->find('all',array('conditions'=>array('id'=>$arrPortalDetail[0]['Portal']['career_portal_provider_id'])));
								
								// shoot email to admin
								$arrPortalOwn = $this->User->fnFindOwnerDetail($arrUserDetail[0]['User']['id']);								
								$this->fnSendAdminPortalContactusEmail($arrUserDetail,$arrPortalDetail[0]['Portal']['career_portal_name'],$arrContactUs,$arrPortalOwn);	
								
								// shoot email to portal owner
								/*$intNotifiedPortalAdmin = $this->fnSendPortalAdminContactusEmail($arrUserDetail,$arrPortalDetail[0]['Portal']['career_portal_name'],$arrContactUs);*/

								// shoot an email to contacter
								$intNotifyContacter = $this->fnSendContactUsFormSubmissionEmailForContacter($arrContactUs['email']);
							}							
						}
						else
						{
							// set error message
							$this->Session->setFlash('Please Try Again Some Problem!');
							
						}
					}
					else
					{
						$arrContactUsErrors = $this->Contactus->invalidFields();
						//print("<pre>");
						//print_r($arrContactUsErrors);
						//exit;
						if(is_array($arrContactUsErrors) && (count($arrContactUsErrors)>0))
						{
							$intForIterateCount = 0;
							foreach($arrContactUsErrors as $errorVal)
							{
								$intForIterateCount++;
								if($intForIterateCount == 1)
								{
									$strContactusErrorMessage .= "Error: ".$errorVal['0'];
								}
								else
								{
									$strContactusErrorMessage .= "<br> Error: ".$errorVal['0'];
								}
							}
							
						}
						$this->Session->setFlash($strContactusErrorMessage);
					}
					$this->redirect($this->referer());
				}
			}
		}
	}
	
	public function page($intPortalId = "",$intPageId = "")
	{
		//echo "".$this->layout;
		
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
		//$strId = base64_decode($intPortalPageId);
		//$arrPageDetail = explode("_",$strId);
		$intPortalId = $intPortalId;
		$intPageId = $intPageId;
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				$this->set('intPortalId',$intPortalId);
				
				
				// load portal theme page widgets
				/* $intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
				$this->loadModel('PortalThemePageWidgets');
				//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
				$arrPortalThemePageWidgets = $this->PortalThemePageWidgets->fnLoadPortalThemePageWidgetDetail();
				if(is_array($arrPortalThemePageWidgets) && (count($arrPortalThemePageWidgets)>0))
				{
					$this->set('arrPortalWidgets',$arrPortalThemePageWidgets);
				} */
				
				
				// load menus data
				$this->loadModel('TopMenu');
				$arrMenuDetail = $this->TopMenu->find('all',array('conditions'=>array('career_portal_id'=>$intPortalId),'order'=>array('TopMenu.career_portal_menu_order'=>'ASC')));
				/* print("<pre>");
				print_r($arrMenuDetail); */
				if(is_array($arrMenuDetail) && (count($arrMenuDetail)>0))
				{
					$this->set('arrPortalMenuDetail',$arrMenuDetail);
				}
				
				// load page data
				$this->loadModel('PortalPages');
				$arrPortalPageDetail = $this->PortalPages->find('all', array(
										'conditions' => array('career_portal_id' => $intPortalId,'career_portal_page_id' => $intPageId)
									));
									

				$this->set('arrPortalPageDetail',$arrPortalPageDetail);
				if(strpos($arrPortalPageDetail[0]['PortalPages']['career_portal_page_tittle'],"Contact") !== false)
				{
					$this->loadModel('PortalContactForm');
					$arrContactFormDetail = $this->PortalContactForm->find('all',array('conditions'=>array('PortalContactForm.career_portal_id'=>$intPortalId,'PortalContactForm.career_portal_contact_us_form_is_active'=>'1')));
					/* print("<pre>");
					print_r($arrContactFormDetail); */
					if(is_array($arrContactFormDetail)  && (count($arrContactFormDetail)>0))
					{
						$this->loadModel('ContactFormFields');
						//$arrContactFormFields = $this->ContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'])));
						$arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
						if(is_array($arrContactFormFields) && (count($arrContactFormFields)>0))
						{
							$intContactFormFieldCount = 0;
							foreach($arrContactFormFields as $arrContactFFields)
							{
								$arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
								$arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
								$intContactFormFieldCount++;
							}
							$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
						}
						$arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
						$this->set('arrContactFormDetail',$arrContactFormDetail);
					}
				}
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->loadModel('Job');
				$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				
				$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
				/* print("<pre>");
				print_r($arrLatesJobDetail); */
				
				$this->loadModel('Job');
				$arrHighJobDetail = $this->Job->fnGetHighlightedJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
				/* print("<pre>");
				print_r($arrHighJobDetail); */
				$this->set('arrPortalHJobDetail',$arrHighJobDetail);
				
				$this->loadModel('JCountry');
				$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
				asort($arrJCountries);
				$this->set('arrJcountry',$arrJCountries);
				
				
				$this->loadModel('JobCategory');
				$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
				$arrJCategories["0"] = "Choose Category";
				ksort($arrJCategories);
				$this->set('arrJcategories',$arrJCategories);
				
				$this->loadModel('JobExperience');
				$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
				$arrJobInitialVal["0"] = "Choose Experience";
				//ksort($arrJobExperience);
				$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
				$this->set('arrJobExperience',$arrNewMergedJobExp);
				
				// Load Quotes
				$this->loadModel('Content');
				$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
				$intRandomQuoteIndex = rand(0,$intQuoteCount);
				$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
				
				//print("<pre>");
				//print_r($arrRandomQuoteDetail);
				//exit;
				
				$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
				
				// courses detail
				$compLmsBridge = $this->Components->load('LmsBridge');
				$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				
				/*print("<pre>");
				print_r($arrCourseDetails);*/
				
				$this->set('arrCoursesDetails',$arrCourseDetails);
			}
		}
	}
	
	public function reset($intPortalId = "")
	{
		$arrExistSocialSession = $this->Session->read('SOCIALREGISTRATIONDETAILS');
		if(is_array($arrExistSocialSession) && (count($arrExistSocialSession)>0))
		{
			if(isset($arrExistSocialSession['SOCIALUSERTYPE']))
			{
				if($arrExistSocialSession['SOCIALUSERTYPE'] == "facebook")
				{
					// run the facebook logout url in background
					$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
					$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_code');
					$this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_user_id');
				}
				if($arrExistSocialSession['SOCIALUSERTYPE'] == "twitter")
				{
					$this->Session->delete('twitter');
					$this->Session->delete('SOCIALREGISTRATIONDETAILS');
				}
				if($arrExistSocialSession['SOCIALUSERTYPE'] == "linkedin")
				{
					$this->Session->delete('linkedin');
					$this->Session->delete('SOCIALREGISTRATIONDETAILS');
				}
			}
		}
		$this->redirect(array('controller'=>'portal','action'=>'registration',$intPortalId));
	}
	
	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			$this->Captcha = $this->Components->load('Captcha', array(
				'width' => 150,
				'height' => 50,
				'theme' => 'default', //possible values : default, random ; No value means 'default'
			)); //load it
			}
		$this->Captcha->create();
	}
	
	public function registration($intPortalId = "")
	{
		/* if(!$intPortalId) 
		{
			$intPortalId = Configure::read('PrivatePortal.id');
		} */
		/* print("<pre>");
		print_r($_SESSION);
		exit; */
		
		if($intPortalId)
		{
			$strRegistrationMethod = "Manual";
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->loadModel('PortalRegistration');
				$arrPortalRegistration = $this->PortalRegistration->find('all', array(
																'conditions' => array('career_portal_id'=> $intPortalId,'career_registration_form_is_active'=>'1')
															));
				$this->loadModel('RegistrationFormFields');
				$arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
				if(is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail)>0))
				{
					$intForEachCount = 0;
					foreach($arrRegistrationFieldDetail as $arrRegistrationField)
					{
						
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table'] = $arrRegistrationField['fields_table'];
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['career_portal_registration_form_fields'] = $arrRegistrationField['career_portal_registration_form_fields'];
						$arrFieldValidationDetail = $this->RegistrationFormFields->fnGetAllFieldValidation($arrRegistrationField['fields_table']['field_id']);
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_validation'] = $arrFieldValidationDetail;
						$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = "";
						if(is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS'))>0))
						{
							$arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
							
							//echo "---".$arrRegistrationField['fields_table']['field_name'];
							
							if(isset($arrRegistrationData['SOCIALUSERFNAME']))
							{
								
								if($arrRegistrationField['fields_table']['field_name'] == 'first_name')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERFNAME'];
								}
							}
							
							if(isset($arrRegistrationData['SOCIALUSERLNAME']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'last_name')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLNAME'];
								}
							}
							
							
							if(isset($arrRegistrationData['SOCIALUSEREMAIL']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'email')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSEREMAIL'];
								}
							}
							
							if(isset($arrRegistrationData['SOCIALUSERLOCATION']))
							{
								if($arrRegistrationField['fields_table']['field_name'] == 'address')
								{
									$arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLOCATION'];
								}
							}
							
						}
						
						$intForEachCount++;
					}
				}
				if($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_is_social_media'])
				{
					$this->loadModel('RegistrationSocialMedialField');
					$arrSetRegistrationSocialFields = $this->RegistrationSocialMedialField->fnGetSocialMediaFieldDetail($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
					/* print("<pre>");
					print_r($arrSetRegistrationSocialFields); */
					
					$this->set('arrRegistrationSocialPluginData',$arrSetRegistrationSocialFields);
				}
				
				
				/* print("<pre>");
				print_r($_SESSION); */
				if(is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS'))>0))
				{
					$arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
					$this->set('strResetUrl',$arrRegistrationData['logout_url']);
					$this->set('strSocialSetType',$arrRegistrationData['SOCIALUSERTYPE']);
					$strRegistrationMethod = $arrRegistrationData['SOCIALUSERTYPE'];
				}
				
				$this->set('intPortalId',$intPortalId);
				$this->set('arrRegistrationForm',$arrPortalRegistration);
				$this->set('arrRegistrationFieldDetail',$arrCompleteRegistrationFieldDetail);
				$this->set('strRegistrationMethod',$strRegistrationMethod);
			}
			
			// Load Quotes
			$this->loadModel('Content');
			$intQuoteCount = $this->Content->find('count',array('conditions'=>array('content_type'=>'3')));
			$intRandomQuoteIndex = rand(0,$intQuoteCount);
			$arrRandomQuoteDetail = $this->Content->find('all',array('conditions'=>array('content_type'=>'3'),'limit'=>"1",'offset'=>$intRandomQuoteIndex));
			
			//print("<pre>");
			//print_r($arrRandomQuoteDetail);
			//exit;
			
			$this->set("arrRandomQuoteDetail",$arrRandomQuoteDetail);
			
			/* print("<pre>");
			print_r($arrCompleteRegistrationFieldDetail); */
			
			if($this->request->is('post'))
			{
				/*print("<pre>");
				print_r($this->request->data);
				exit;*/
				
				$arrUniqueFieldsConditions = array();
				$strShare = "";
				if(isset($this->request->data['share']))
				{
					$strShare = $this->request->data['share'];
				}
				if(isset($this->request->data['regmethod']))
				{
					$strCandidateRegMethod = $this->request->data['regmethod'];
				}
				$strFname = "";
				$strEmail = "";
				
				$this->loadModel('PortalUser');
				if(!isset($this->Captcha))	
				{ 
					//if Component was not loaded throug $components array()
					$this->Captcha = $this->Components->load('Captcha'); //load it
				}
				
				/*$this->PortalUser->validate[] = array(
														'captcha'=>array(
																		'rule' => array('matchCaptcha'),
																		'message'=>'Failed validating human check.'
																	)
													);*/
				//print("<pre>");
				//print_r($arrCompleteRegistrationFieldDetail);
				//exit;
				foreach($arrCompleteRegistrationFieldDetail as $arrRegistrationFields)
				{
					
					
					if($arrRegistrationFields['career_portal_registration_form_fields']['career_portal_registration_form_field_enabled'])
					{
						if(strpos($arrRegistrationFields['career_portal_registration_form_fields']['career_portal_registration_form_field_label'],"Captcha") !== false)
						{
							$this->PortalUser->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
						}
					}
					
					if(is_array($arrRegistrationFields['fields_validation']) && (count($arrRegistrationFields['fields_validation'])>0))
					{
						
						foreach($arrRegistrationFields['fields_validation'] as $arrValidationDetail)
						{
							switch($arrValidationDetail['validation_rule_table']['validation_rule'])
							{
								case"notempty": //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Not Empty',array('rule' => 'notEmpty','message' => 'Cannot leave the field empty'));
												$this->PortalUser->validate['candidate_'.$arrRegistrationFields['fields_table']['field_name']]['Not Empty'] = array('rule' => 'notEmpty','message' => 'Cannot leave the field empty');
												break;
								case"email": 	//$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
												$this->PortalUser->validate['candidate_'.$arrRegistrationFields['fields_table']['field_name']]['Email'] = array('rule' => 'email','message' => 'Provided email address was not correct');
												break;
							}
						}
					}					
					
					switch($arrRegistrationFields['fields_table']['field_type'])
					{
						case 'password' : $this->request->data['PortalUser']['candidate_password_decrypted'] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
											$this->request->data['PortalUser']['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = AuthComponent::password($this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']]);
										  break;
						case 'text' : 	$this->request->data['PortalUser']['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
										break;
					}
					
					
					if($arrRegistrationFields['fields_table']['field_is_unique'])
					{
						$arrUniqueFieldsConditions['candidate_'.$arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					$strCurrentFieldName = 'candidate_'.$arrRegistrationFields['fields_table']['field_name'];
					if($strCurrentFieldName == "candidate_first_name")
					{
						$strFname = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					
					if($strCurrentFieldName == "candidate_email")
					{
						$strEmail = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
					
					if($strCurrentFieldName == "candidate_username")
					{
						$strCandidateUsername = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
					}
				}
				$arrUniqueFieldsConditions['career_portal_id'] = $intPortalId;
				
				/* print("<pre>");
				print_r($arrUniqueFieldsConditions);
				exit; */
				
				
				$intCountCandidateExists = $this->PortalUser->find('count',array('conditions'=>$arrUniqueFieldsConditions));
				if($intCountCandidateExists)
				{
					$this->Session->setFlash('This account is already been registered, Please try again with other details');
				}
				else
				{
					$this->request->data['PortalUser']['career_portal_id'] = $intPortalId;
					//print("<pre>");
					//print_r($this->request->data);exit;
					
					$this->PortalUser->set($this->request->data);
					//print("<pre>");
					//print_r($this->PortalUser->validates());exit;
					if(is_array($this->PortalUser->validate) && (count($this->PortalUser->validate)>0))
					{
						if($this->PortalUser->validates())
						{
							$boolCandidateRegistered = $this->PortalUser->save($this->request->data);
							if($boolCandidateRegistered)
							{
													$this->loadModel('Email');
							$emailContent = $this->Email->find('first', array(
        'conditions' => array('Email.template_key' =>'registration')
    ));
								$intLastCandidateInsertedId = $this->PortalUser->getInsertID();
								$boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname,$strEmail,$intLastCandidateInsertedId,$arrPortalDetail[0]['Portal']['career_portal_name'],$intPortalId,$emailContent['Email']);
								$arrMixPanelRegisteredData = array();
								$arrMixPanelRegisteredData['username'] = $strFname;
								$arrMixPanelRegisteredData['useremail'] = $strEmail;
								$arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
								$arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
								$arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod; 
								// set default role for the portal in LMS
								//$compLms = $this->Components->load('LmsBridge');
								//$arrSeekerLmsSetup = $compLms->fnSetupSeeker($arrPortalDetail['0']['Portal']['career_portal_id'],$strEmail);
								/*print("<pre>");
								 print_r($arrSeekerLmsSetup);
								exit; */
								
								
								// based on user request share on facebook
								if($strShare == "facebook")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									$boolShared = $this->SocialRegister->fnShareUserRegistrationOnFacebook($arrPortalDetail);
								}
								// based on user request share on twitter
								if($strShare == "twitter")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									$boolShared = $this->SocialRegister->fnShareUserRegistrationOnTwitter($arrPortalDetail);
								}
								// based on user request share on linkedin
								if($strShare == "linkedin")
								{
									$this->SocialRegister = $this->Components->load('FbRegister');
									$boolShared = $this->SocialRegister->fnShareUserRegistrationOnLinkedIn($arrPortalDetail);
								}
								$this->Session->setFlash('You are now registered, Please check your email for confirmation','default',array('class' => 'success'));
								$this->set('isRegistrationDone',"1");
								$this->set('arrMixPanelUserRegData',$arrMixPanelRegisteredData);
								
							}
							
						}
						else
						{
							$errors = $this->PortalUser->invalidFields();
							$strCandidateRegerrorMessage = "";
							if(is_array($errors) && (count($errors)>0))
							{
								$intErrorCnt = 0;
								foreach($errors as $errorVal)
								{
									$intErrorCnt++;
									if($intErrorCnt == "1")
									{
										$strCandidateRegerrorMessage .= "Error: ".$errorVal['0'];
									}
									else
									{
										$strCandidateRegerrorMessage .= "<br> Error: ".$errorVal['0'];
									}
								}
								
								$this->Session->setFlash($strCandidateRegerrorMessage);
							}
						}
					}
					else
					{
						$boolCandidateRegistered = $this->PortalUser->save($this->request->data);
						if($boolCandidateRegistered)
						{
														$this->loadModel('Email');
							$emailContent = $this->Email->find('first', array(
        'conditions' => array('Email.template_key' =>'registration')
    ));
							$intLastCandidateInsertedId = $this->PortalUser->getInsertID();
							$boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname,$strEmail,$intLastUserInsertedId,$arrPortalDetail[0]['Portal']['career_portal_name'],$intPortalId,$emailContent['Email']);
							$this->Session->setFlash('You are now registered, Please check your email for confirmation','default',array('class' => 'success'));
							$arrMixPanelRegisteredData = array();
							$arrMixPanelRegisteredData['username'] = $strFname;
							$arrMixPanelRegisteredData['useremail'] = $strEmail;
							$arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
							$arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
							$arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod;
							$this->set('isRegistrationDone',"1");
							$this->set('arrMixPanelUserRegData',$arrMixPanelRegisteredData);
						}
					}
				}
			}
		}
	}
	
	public function shop($intPortalId = "")
	{
		
		if($intPortalId)
		{
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			// courses detail
			$compLmsBridge = $this->Components->load('LmsBridge');
			$arrPaidCourseDetails = $compLmsBridge->fnGetPaypalEnrolledPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrPaidCourseDetails);
			exit;*/
			if(isset($arrPaidCourseDetails) && (count($arrPaidCourseDetails)>0))
			{
				$arrShopDetails['E-learning'] = $arrPaidCourseDetails;
			}
			
			/*$compLmsBridge = $this->Components->load('LmsBridge');
			$arrWebinarsDetails = $compLmsBridge->fnGetPortalWebinars($arrPortalDetail['0']['Portal']['career_portal_id']);
			if(isset($arrPaidCourseDetails) && (count($arrPaidCourseDetails)>0))
			{
				$arrShopDetails['Webinars'] = $arrWebinarsDetails;
			}*/
			/*print("<pre>");
			print_r($arrShopDetails);*/
			
			$this->set('arrShopDetails',$arrShopDetails);
		}
		
	}
	
	public function forgotpassword($intPortalId = "")
	{
		
		if($intPortalId)
		{
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_name'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			if($this->request->is('post'))
			{
				
				  $strCandidateEmail = addslashes(trim($this->request->data['UserEmail']));
				
				$this->loadModel('Candidate');
				$compMessage = $this->Components->load('Message');
				$arrCandidateExists = $this->Candidate->find('all',array('conditions'=>array('candidate_email'=>$strCandidateEmail,'career_portal_id'=>$intPortalId)));
				if(is_array($arrCandidateExists) && (count($arrCandidateExists)>0))
				{
					
					$this->loadModel('Email');
							$emailContent = $this->Email->find('first', array(
        'conditions' => array('Email.template_key' =>'forgot')
    ));
					$strNewPassword = $this->fnRegeneratePassword($arrCandidateExists[0]['Candidate']['candidate_id']);
					$intMailSent = $this->fnSendPassowordRegenerationMail($arrCandidateExists[0]['Candidate']['candidate_username'], $strCandidateEmail,$strNewPassword,$emailContent['Email']);
					
					if($intMailSent)
					{
						$boolUpdated = $this->Candidate->updateAll(
									array('Candidate.candidate_password' => "'".AuthComponent::password($strNewPassword)."'"),
									array('Candidate.candidate_email =' => $strCandidateEmail,'career_portal_id'=>$intPortalId)
								);
						if($boolUpdated)
						{
							
							$strMessage = $compMessage->fnGenerateMessageBlock('New Password has been your Mail');
			
							$arrResponse['status'] = "success";
							$arrResponse['message'] = $strMessage;
							//$this->Session->setFlash("Congratulation, your Password has been reset, Please check your Mail",'default',array('class' => 'success'));
						}
						else
						{
							$strMessage = $compMessage->fnGenerateMessageBlock('Please try again');
							$arrResponse['status'] = "success";
							$arrResponse['message'] = $strMessage;
							//$this->Session->setFlash("Please try again.");
						}
					}
					else
					{
							$strMessage = $compMessage->fnGenerateMessageBlock('Please try again');
							$arrResponse['status'] = "success";
							$arrResponse['message'] = $strMessage;
					}
				}
				else
				{
						 $strMessage = $compMessage->fnGenerateMessageBlock('Sorry No Such Email id is registered with us');
						$arrResponse['status'] = "success";
							$arrResponse['message'] = $strMessage;
				//	$this->Session->setFlash("Sorry No Such Email id is registered with us.");
				}
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	public function aboutus()
	{
		
	}
	public function privacypolicy()
	{
		
	}
	public function check_email($email){

	//check for vaild email user@demain.com/co.uk/net

	if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )

	{ 

		return $email;

	}

	return false;

}
	
	
}
