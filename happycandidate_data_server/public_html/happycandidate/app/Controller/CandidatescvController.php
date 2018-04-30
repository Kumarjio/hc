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
class CandidatescvController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Candidatescv';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		parent::beforeFilter();
		$this->Auth->allow('index','confirmation');
	}
	
	public function fnAddMyEducationf($portalid)
	{

		//Configure::write('debug','2');
		$this->loadModel('Candidate_summ');
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_prof_exp_acc');
		$arrLoggedUser = $this->Auth->user();
		$intOperationSuccess = "";

	

		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{

			$resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$intEdCnt = $_POST['education_count'];
			$this->request->data['Candidate_summ']['candidate_cv_id']= $resumeid;
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$strrType= $arrCv['Candidate_Cv']['mode'];
			

			//print("<pre>");
			//print_r($_POST);
			//exit;
			$this->Candidate_summ->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$education_id = $_POST['education_id'.$i];
				if($education_id)
				{
					$this->request->data['Candidate_summ']['skillarea'] = $degree = $_POST['degree'.$i];
					$this->request->data['Candidate_summ']['acc'] = $institution = $_POST['institution'.$i];
					$this->Candidate_summ->create(false);
					$boolUserprocessSaved = $this->Candidate_summ->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					/*$boolUserprocess =  $this->Candidate_Education->updateAll(array('degree' => "'$degree'",'institution' => "'$institution'",'city' => "'$city'",'tution_percentage' => "'$percentage'"),array('candidate_education_id' => $education_id));
					if($boolUserprocess)
					{
						$intOperationSuccess = "1";
					}*/
				}
				else
				{
					$this->request->data['Candidate_summ']['skillarea']= $_POST['degree'.$i];
					$this->request->data['Candidate_summ']['acc'] = $_POST['institution'.$i];
					$this->Candidate_summ->create(false);
					$boolUserprocessSaved = $this->Candidate_summ->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
				}
			}
			$arrLoggedUser = $this->Auth->user();
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('education_id',$education_id);
			$view->set('resumeid',$resumeid);
			$view->set('arrLoggedUser',$arrLoggedUser);
			if($resumeid)
			{
				$this->loadModel('Candidate_prof_exp');
				$proffsionalexp = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
				//print("<pre>");
				//print_r($proffsionalaffilations);
				//exit;
				if(is_array($proffsionalexp) && (count($proffsionalexp)>0))
				{
					$intFrnt = 0;
					foreach($proffsionalexp as $arrPExp)
					{
						$intPrEId = $arrPExp['Candidate_prof_exp']['candidate_prof_exp_id'];
						$arrCDetail = $this->Candidate_prof_exp_acc->find('all',array('conditions'=>array('prof_exp_id'=>$intPrEId)));
						if(is_array($arrCDetail) && (count($arrCDetail)>0))
						{
							$proffsionalexp[$intFrnt]['Candidate_prof_exp']['acc'] = $arrCDetail;
						}
						$intFrnt++;
					}
				}
				$view->set('proffsionalexp',$proffsionalexp);
			}
			$strWidgetListerHtml = $view->element('proffessionalexpf');
			$arrResponse['contactshtml'] = $strWidgetListerHtml;
			if($arrResponse['contactshtml'])
			{
				$arrResponse['status'] = "success";
			}
			if($intOperationSuccess)
			{
				$arrResponse['operationstatus'] = "success";
			}
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function dashboard($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$this->set('strSeekerHomeUrl',Configure::read('Jobber.seekerhomeurl'));
			
			
			
			/*$this->loadModel('Job');
			$arrMatchedJobsForCandidates = $this->Job->find('all',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			$this->set('arrMatchedJobs',$arrMatchedJobsForCandidates); */
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
		
	}
	
	public function jobs($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
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
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandJobUrl = Configure::read('Jobber.seekerjobsurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerJobsUrl',$strJobberlandJobUrl);
			
			/*$this->loadModel('Job');
			$arrMatchedJobsForCandidates = $this->Job->find('all',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			$this->set('arrMatchedJobs',$arrMatchedJobsForCandidates); */
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
		
	}
	
	public function searchwebinars($intPortalId = "")
	{
		$this->autoRender = false;
		$this->layout = NULL;
		$arrResonse = array();
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				//$this->set('arrPortalDetail',$arrPortalDetail);
				//$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				//$this->set('intPortalId',$intPortalId);
				// courses detail
				//$compLmsBridge = $this->Components->load('LmsBridge');
				//$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				/*print("<pre>");
				print_r($arrCourseDetails);*/
				//$this->set('arrCoursesDetails',$arrCourseDetails);
				$arrSearchCriteria = array();
				if(isset($_REQUEST['webinar_name']))
				{
					$arrSearchCriteria['webinar_name'] = $_REQUEST['webinar_name'];
				}
				
				$compLmsBridge = $this->Components->load('LmsBridge');
				$arrWebinarDetails = $compLmsBridge->fnSearchPortalWebinars($arrPortalDetail['0']['Portal']['career_portal_id'],$arrSearchCriteria);
				
				if(is_array($arrWebinarDetails) && (count($arrWebinarDetails)>0))
				{
					/*print('<pre>');
					print_r($arrCourseDetails);
					exit;*/
					// code to get the html content
					$view = new View($this, false);
					$view->set('arrWebinarDetails', $arrWebinarDetails);
					$view->viewPath = 'Elements';
					 
					/* Grab output into variable without the view actually outputting! */
					$strMatchedCourses = $view->render('webinarmaterial');
					
					$arrResonse['status'] = 'success';
					$arrResonse['message'] = '';
					$arrResonse['htmldata'] = $strMatchedCourses;
				}
				else
				{
					$arrResonse['status'] = 'fail';
					$arrResonse['message'] = 'The No Such Matched Records';
				}
			}
			else
			{
				$arrResonse['status'] = 'fail';
				$arrResonse['message'] = 'Bad URL';
			}
		}
		else
		{
			$arrResonse['status'] = 'fail';
			$arrResonse['message'] = 'Bad URL';
		}
		
		echo json_encode($arrResonse);
		exit;
	}
	
	public function getcourses($intPortalId = "")
	{
		$this->autoRender = false;
		$this->layout = NULL;
		$arrResonse = array();
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				//$this->set('arrPortalDetail',$arrPortalDetail);
				//$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				//$this->set('intPortalId',$intPortalId);
				// courses detail
				//$compLmsBridge = $this->Components->load('LmsBridge');
				//$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
				/*print("<pre>");
				print_r($arrCourseDetails);*/
				//$this->set('arrCoursesDetails',$arrCourseDetails);
				$arrSearchCriteria = array();
				if(isset($_REQUEST['course_name']))
				{
					$arrSearchCriteria['course_name'] = $_REQUEST['course_name'];
				}
				
				$compLmsBridge = $this->Components->load('LmsBridge');
				$arrCourseDetails = $compLmsBridge->fnSearchPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id'],$arrSearchCriteria);
				
				if(is_array($arrCourseDetails) && (count($arrCourseDetails)>0))
				{
					/*print('<pre>');
					print_r($arrCourseDetails);
					exit;*/
					// code to get the html content
					$view = new View($this, false);
					$view->set('arrCoursesDetails', $arrCourseDetails);
					$view->viewPath = 'Elements';
					 
					/* Grab output into variable without the view actually outputting! */
					$strMatchedCourses = $view->render('elearningmaterial');
					
					$arrResonse['status'] = 'success';
					$arrResonse['message'] = '';
					$arrResonse['htmldata'] = $strMatchedCourses;
				}
				else
				{
					$arrResonse['status'] = 'fail';
					$arrResonse['message'] = 'The No Such Matched Records';
				}
			}
			else
			{
				$arrResonse['status'] = 'fail';
				$arrResonse['message'] = 'Bad URL';
			}
		}
		else
		{
			$arrResonse['status'] = 'fail';
			$arrResonse['message'] = 'Bad URL';
		}
		
		echo json_encode($arrResonse);
		exit;
	}
	
	public function elearning($intPortalId = "")
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
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			// courses detail
			$compLmsBridge = $this->Components->load('LmsBridge');
			$arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrCourseDetails);*/
			$this->set('arrCoursesDetails',$arrCourseDetails);
		}
		
	}
	
	public function library($intPortalId = "")
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
			$arrAllMaterialDetails = $compLmsBridge->fnGetAllMaterial($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrPaidCourseDetails);
			exit;*/
			$this->set('arrAllMaterialDetails',$arrAllMaterialDetails);
		}
		
	}
	
	public function badges($intPortalId = "")
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
			$arrCandidatesBadges = $compLmsBridge->fnGetCandidatesBadges($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrCandidatesBadges);*/
			
			//exit;*/
			
			if($arrCandidatesBadges['status'] == "success")
			{
				$this->set('arrCandidatesBadges',$arrCandidatesBadges);
			}
			
		}
		
	}
	
	public function webinars($intPortalId = "")
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
			$arrWebinarsDetails = $compLmsBridge->fnGetPortalWebinars($arrPortalDetail['0']['Portal']['career_portal_id']);
			/*print("<pre>");
			print_r($arrWebinarsDetails);
			exit;*/
			$this->set('arrWebinarsDetails',$arrWebinarsDetails);
		}
		
	}
	
	public function latestjobs($intPortalId = "")
	{
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
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
			
			$this->loadModel('PortalPages');
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			$strJobberlandJobUrl = Configure::read('Jobber.seekerlatestjobsurl')."?portid=".$intPortalId;
			$this->set('strSeekerLatestJobsUrl',$strJobberlandJobUrl);
			
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
			
			$this->loadModel('Job');
			$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
			/* print("<pre>");
			print_r($arrLatesJobDetail); */			
		}
		
	}
	
	public function savesearch($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			//$strJobberlandSaveSearchUrl = Configure::read('Jobber.seekersavesearchsurl')."?portid=".$intPortalId;
			$strJobberlandSaveSearchUrl = Configure::read('Jobber.seekersavesearchsurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerSaveSearchUrl',$strJobberlandSaveSearchUrl);
			
			/*$this->loadModel('Job');
			$arrMatchedJobsForCandidates = $this->Job->find('all',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			$this->set('arrMatchedJobs',$arrMatchedJobsForCandidates); */
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
		
	}
	
	public function savejobs($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandSaveJobUrl = Configure::read('Jobber.seekersavejobsurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerSaveJobsUrl',$strJobberlandSaveJobUrl);
			
			/*$this->loadModel('Job');
			$arrMatchedJobsForCandidates = $this->Job->find('all',array('conditions'=>array('is_active'=>'1','portal_id'=>$intPortalId)));
			$this->set('arrMatchedJobs',$arrMatchedJobsForCandidates); */
			/* print("<pre>");
			print_r($arrMatchedJobsForCandidates); */
			
			
		}
		
	}
	
	public function index($intCvid = "",$intjUid = "")
	{
		$this->layout = 'candidates';
		$strJobberlandProfileUrl = Configure::read('Jobber.seekercvviewurl')."?id=".$intCvid."&u=".$intjUid;
		$this->set('strSeekerProfileUrl',$strJobberlandProfileUrl);
	}
	
	public function profile($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			//$strJbToken = $this->Session->read('Auth.FrontendUser_'.$intPortalId.".jbloggtoken_".$arrLoggedUser['candidate_id']);
			
			/*print("<pre>");
			print_r($_SESSION);*/
			
			$strJobberlandProfileUrl = Configure::read('Jobber.seekerprofileurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerProfileUrl',$strJobberlandProfileUrl);
		}
	}
	
	public function logindetail($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandProfileLoginUrl = Configure::read('Jobber.seekerprofileloginurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerProfileUrl',$strJobberlandProfileLoginUrl);
		}
	}
	
	public function cv($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandCVUrl = Configure::read('Jobber.seekercvurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerCvUrl',$strJobberlandCVUrl);
		}
	}
	
	public function defaultcv($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandDefaultCVUrl = Configure::read('Jobber.seekerdefaultcvurl')."".$this->strCandidateDefaultId."/review/"."?portid=".$intPortalId;
			
			$this->set('strSeekerDefaultCvUrl',$strJobberlandDefaultCVUrl);
		}
	}
	
	public function cletter($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			
			$strJobberlandCletterUrl = Configure::read('Jobber.seekercletterurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerCletterUrl',$strJobberlandCletterUrl);
		}
	}
	
	public function course($intPortalId = "",$intCourseId = "")
	{
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
		
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				$this->set('intPortalId',$intPortalId);

				/*$compCandidates = $this->Components->load('Candidates');
				$strJbToken = $compCandidates->fnGetCandidateLmsToken($arrLoggedUser['candidate_id'],$intPortalId);*/
				$strRequiredSessionVar = "0_".$arrLoggedUser['candidate_id']."_sesskey";
				//echo "-----".$this->Session->read($strRequiredSessionVar);
				$strJbToken = $this->Session->read($strRequiredSessionVar);
				
				
				$strCourseUrl = Configure::read('Lms.courseview')."?id=".$intCourseId."&candidate_portal_request=".$intPortalId;
				
				$this->set('strCourseDetailUrl',$strCourseUrl);
			}
		}
	}
	
	public function confirmation($intPortalId = "",$strCandidateId = "")
	{
		$this->layout = "candidates";
		$arrResponse = array();
		if($strCandidateId)
		{
			$intCandidateId = base64_decode($strCandidateId);
			$this->loadModel('Candidate');
			$intCandidateExists = $this->Candidate->find('count',array('conditions'=>array('candidate_id'=>$intCandidateId)));
			if($intCandidateExists)
			{
				$intConifrmedLit = '0';
				$intCandidateConfirmed = $this->Candidate->find('count',array('conditions'=>array('candidate_id'=>$intCandidateId,"candidate_confirmed"=>'0')));
				if($intCandidateConfirmed)
				{
					$boolUpdated = $this->Candidate->updateAll(array('Candidate.candidate_confirmed' => "'1'"),array('Candidate.candidate_id =' =>$intCandidateId));
					if($boolUpdated)
					{
						$this->Session->setFlash("Your Account has been confirmed",'default',array('class' => 'success'));
						$arrCandidateDetailed = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$intCandidateId)));
						$this->loadModel('Portal');
						$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
						
						$this->set('isCandidateConfirmed',"1");
						$arrMixPanelCandidateConfirmData = array();
						$arrMixPanelCandidateConfirmData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
						$arrMixPanelCandidateConfirmData['username'] = $arrCandidateDetailed[0]['Candidate']['candidate_first_name'];
						$arrMixPanelCandidateConfirmData['userid'] = $arrCandidateDetailed[0]['Candidate']['candidate_id'];
						$arrMixPanelCandidateConfirmData['useremail'] = $arrCandidateDetailed[0]['Candidate']['candidate_email'];
						$this->set('arrMixpanelUserConfirmData',$arrMixPanelCandidateConfirmData);
					}
					else
					{
						$this->Session->setFlash("Please try again");
					}
				}
				else
				{
					$this->Session->setFlash("Your Account has already been confirmed");
				}
			}
			else
			{
				$this->Session->setFlash("Sorry This Candidate is not registered and cannot be Confirmed");
			}
		}
		else
		{
			$this->Session->setFlash("Sorry You Account Cannot be Confirmed, Missing parameter");
		}
	}
	
	
	public function search($intPortalId = "")
	{
		//$this->autoRender = FALSE;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('Job');
			$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
			
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
		}
	}
	
	public function advancesearch($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			$this->loadModel('Job');
			$arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
			
			$this->set('arrPortalLatestJobDetail',$arrLatesJobDetail);
		}
	}
}