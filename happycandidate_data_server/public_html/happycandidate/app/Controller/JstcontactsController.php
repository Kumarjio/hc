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
class JstcontactsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $components = array('Paginator');
	public $name = 'Jstcontacts';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail','deleteallcontacts');
	}
	
	public function getProfExperience($portalid,$candidatecv_id)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_workexp');
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_prof_exp_f_acc');
		
		$proffsionalexp = $this->Candidate_workexp->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')	));
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		if(is_array($proffsionalexp) && (count($proffsionalexp)>0))
		{
			$intFrnt = 0;
			foreach($proffsionalexp as $arrPExp)
			{
				$intPrEId = $arrPExp['Candidate_workexp']['candidate_prof_exp_id'];
				$arrCDetail = $this->Candidate_prof_exp_f_acc->find('all',array('conditions'=>array('prof_exp_id'=>$intPrEId)));
				if(is_array($arrCDetail) && (count($arrCDetail)>0))
				{
					$proffsionalexp[$intFrnt]['Candidate_workexp']['acc'] = $arrCDetail;
				}
				$intFrnt++;
			}
		}
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);		
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('proffsionalaffilations',$proffsionalaffilations);
		$strWidgetListerHtml = $view->element('proffessionalexpf');
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getCareerSummary($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $candidatecv_id));
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('Career_Summary',$Career_Summary);
		$strWidgetListerHtml = $view->element('career_summaryf');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getFEducation($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_Education_f');
		$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $candidatecv_id));
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		
		$candidateEducation = $this->Candidate_Education_f->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id)),false);
		$view->set('candidateEducation',$candidateEducation);
					
		
		
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('Career_Summary',$Career_Summary);
		$strWidgetListerHtml = $view->element('feducation');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getProfDev($portalid,$candidatecv_id)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Cv');
		$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $candidatecv_id));
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		
		$this->loadModel('Proffdev');
		$candidateEducation = $this->Proffdev->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id)),false);	
		$view->set('candidateEducation',$candidateEducation);
		
		
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('Career_Summary',$Career_Summary);
		$strWidgetListerHtml = $view->element('profdev');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getEducationF($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $candidatecv_id));
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		
		$this->loadModel('Candidate_summ');
		$candidateEducation = $this->Candidate_summ->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id)),false);	
		$view->set('candidateEducation',$candidateEducation);
		
		
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('Career_Summary',$Career_Summary);
		$strWidgetListerHtml = $view->element('educationf');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getCoreCompentents($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$keywords = $this->Candidate_Cv->field('keywords', array('candidatecv_id' => $candidatecv_id));
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);	
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		$view->set('keywords',$keywords);
		$strWidgetListerHtml = $view->element('core_competenciesf');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyContactInfo($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$ContactInfo = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strRtype = $ContactInfo['Candidate_Cv']['mode'];
		$strAcademicInfo = $ContactInfo['Candidate_Cv']['work_history'];
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		
		$view = new View($this, false);	
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('countrylist',$countrylist);
		
		$view->set('contactinfo',$ContactInfo);
		if($strRtype == "functional")
		{
			$strWidgetListerHtml = $view->element('contactinfof');
		}
		else
		{
			if($strAcademicInfo == "academia")	
			{
				$strWidgetListerHtml = $view->element('contactinfoa');
			}
			else
			{
				if($strAcademicInfo == "military")
				{
					$strWidgetListerHtml = $view->element('contactinfom');
				}
				else
				{
					$strWidgetListerHtml = $view->element('contactinfo');
				}
			}
		}
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function fnAddMyResumeTitle($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
				
			$resumeid = $_POST['resumeid'];
			$resume_title = addslashes($_POST['resume_title']);
			$boolUserprocess =  $this->Candidate_Cv->updateAll(array('resume_title' => "'$resume_title'",'status'=>"'complete'"),array('candidatecv_id' => $resumeid));
			$view->set('resumeid',$resumeid);
			$strWidgetListerHtml = $view->element('thankyouhtml');
			$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
			if($arrResponse['contactshtml'])
			{
				$arrResponse['status'] = "success";
			}
			echo json_encode($arrResponse);
			exit;
		
					
		}
		
	}
	
	public function fnAddMyProfDevf($portalid)
	{

		//Configure::write('debug','2');
		$this->loadModel('Proffdev');
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
			$this->request->data['Proffdev']['candidate_cv_id']= $resumeid;
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$strrType= $arrCv['Candidate_Cv']['mode'];
			

			//print("<pre>");
			//print_r($_POST);
			//exit;
			$this->Proffdev->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$education_id = $_POST['education_id'.$i];
				if($education_id)
				{
					$this->request->data['Proffdev']['skillarea'] = $degree = $_POST['skillarea'.$i];
					$this->request->data['Proffdev']['acc'] = $institution = $_POST['institution'.$i];
					$this->Proffdev->create(false);
					$boolUserprocessSaved = $this->Proffdev->save($this->request->data);
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
					$this->request->data['Proffdev']['skillarea']= $_POST['skillarea'.$i];
					$this->request->data['Proffdev']['acc'] = $_POST['institution'.$i];
					$this->Proffdev->create(false);
					$boolUserprocessSaved = $this->Proffdev->save($this->request->data);
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
				$this->loadModel('Candidate_Cv');
				$resume_title = $this->Candidate_Cv->field('resume_title', array('candidatecv_id' => $resumeid));
				$view->set('resume_title',$resume_title);
			}
			$strWidgetListerHtml = $view->element('generalinfof');
			//exit;
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
	
	public function fnAddMyEducationf($portalid)
	{

		//Configure::write('debug','2');
		$this->loadModel('Candidate_summ');
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_prof_exp_f_acc');
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
					$this->request->data['Candidate_summ']['skillarea'] = $degree = $_POST['skillarea'.$i];
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
					$this->request->data['Candidate_summ']['skillarea']= $_POST['skillarea'.$i];
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
				$this->loadModel('Candidate_workexp');
				$proffsionalexp = $this->Candidate_workexp->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
				//print("<pre>");
				//print_r($proffsionalexp);
				//exit;
				if(is_array($proffsionalexp) && (count($proffsionalexp)>0))
				{
					$intFrnt = 0;
					foreach($proffsionalexp as $arrPExp)
					{
						$intPrEId = $arrPExp['Candidate_workexp']['candidate_prof_exp_id'];
						$arrCDetail = $this->Candidate_prof_exp_f_acc->find('all',array('conditions'=>array('prof_exp_id'=>$intPrEId)));
						if(is_array($arrCDetail) && (count($arrCDetail)>0))
						{
							$proffsionalexp[$intFrnt]['Candidate_workexp']['acc'] = $arrCDetail;
						}
						$intFrnt++;
					}
				}
				$view->set('proffsionalexp',$proffsionalexp);
			}
			$strWidgetListerHtml = $view->element('proffessionalexpf');
			//exit;
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
	
	public function fnAddMyEducationNew($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Education_f');
		$this->loadModel('Proffdev');
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
			$this->request->data['Candidate_Education_f']['candidate_cv_id']= $resumeid;
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			
			//print("<pre>");
			//print_r($_POST);
			//exit;
			$this->Candidate_Education_f->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$education_id = $_POST['education_id'.$i];
				if($education_id)
				{
					$this->request->data['Candidate_Education_f']['degree'] = $degree = $_POST['degree'.$i];
					$this->request->data['Candidate_Education_f']['institution'] = $institution = $_POST['institution'.$i];
					$this->request->data['Candidate_Education_f']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_Education_f']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_Education_f']['tution_percentage'] = $percentage = $_POST['percentage'.$i];
					$this->request->data['Candidate_Education_f']['year'] = $percentage = $_POST['date-start'.$i];
					$this->Candidate_Education_f->create(false);
					$boolUserprocessSaved = $this->Candidate_Education_f->save($this->request->data);
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

					
					$this->request->data['Candidate_Education_f']['degree']= $_POST['degree'.$i];
					$this->request->data['Candidate_Education_f']['institution'] = $_POST['institution'.$i];
					$this->request->data['Candidate_Education_f']['city']= $_POST['city'.$i];
					$this->request->data['Candidate_Education_f']['state'] = $_POST['state'.$i];
					$this->request->data['Candidate_Education_f']['tution_percentage']= $_POST['percentage'.$i];
					$this->request->data['Candidate_Education_f']['completion_year'] = $_POST['date-start'.$i];
					$this->Candidate_Education_f->create(false);
					$boolUserprocessSaved = $this->Candidate_Education_f->save($this->request->data);
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
				$candidateEducation = $this->Proffdev->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_education_id'=>'ASC')),false);
				//print("<pre>");
				$view->set('candidateEducation',$candidateEducation);
				
			}
			$strWidgetListerHtml = $view->element('profdev');
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
	
	public function fnAddMyWorkExp($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_workexp');
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_Education_f');
		$this->loadModel('Candidate_prof_exp_f_acc');
		$intOperationSuccess = "";
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			//exit;
			$intEdCnt = $_POST['pexp_count'];
			$this->request->data['Candidate_workexp']['candidate_cv_id']= $resumeid = $_POST['resumeid'];
			$this->Candidate_workexp->deleteAll(array('candidate_cv_id' => $resumeid),false);
			$this->Candidate_prof_exp_f_acc->deleteAll(array('cv_id' => $resumeid),false);
			$this->request->data['Candidate_workexp']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strRtype = $arrCv['Candidate_Cv']['mode'];
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$prof_exp_id = $_POST['prof_exp_id'.$i];
				if($prof_exp_id)
				{
					//echo "--".date("M",strtotime("2016-03"));
					$this->request->data['Candidate_workexp']['company'] = $company = $_POST['company'.$i];
					$this->request->data['Candidate_workexp']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_workexp']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_workexp']['jobTitle'] = $jobTitle = $_POST['jobTitle'.$i];
					$this->request->data['Candidate_workexp']['fromDate'] = $fromDate = $_POST['date-start'.$i];
					$this->request->data['Candidate_workexp']['toDate'] = $toDate = $_POST['date-end'.$i];
					$this->request->data['Candidate_workexp']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_workexp']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_workexp']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_workexp']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_workexp']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					
					$this->request->data['Candidate_workexp']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_workexp']['description'] = $description = $_POST['description'.$i];
					//print("<pre>");
					//print_r($this->request->data['Candidate_prof_exp']);
					//exit;
					$this->Candidate_workexp->create(false);
					$boolUserprocessSaved = $this->Candidate_workexp->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intProfExpId = $boolUserprocessSaved['Candidate_workexp']['id'];
						$intOperationSuccess = "1";
						$intAccCnt = $_POST['pexp_acc_cnt'.$i];
						if($intAccCnt)
						{
							
							for($j = 1;$j <=$intAccCnt; $j++)
							{
								$arrProfAcc['Candidate_prof_exp_f_acc']['acc'] = $strAcc = $_POST['acc'.$i.$j];
								$arrProfAcc['Candidate_prof_exp_f_acc']['prof_exp_id'] = $intProfExpId;
								$arrProfAcc['Candidate_prof_exp_f_acc']['cv_id'] = $resumeid;
								$this->Candidate_prof_exp_f_acc->create(false);
								$this->Candidate_prof_exp_f_acc->save($arrProfAcc);
							}
						}
					}
					
					
					
					
					
					/*$boolUserprocess =  $this->Candidate_prof_exp->updateAll(array('company' => "'$company'",'city' => "'$city'",'state' => "'$state'",'jobTitle' => "'$jobTitle'",'fromDate' => "'$fromDate'",'toDate' => "'$toDate'",'description' => "'$description'"),array('candidate_prof_exp_id' => $prof_exp_id));	
					
					
					$this->loadModel('Candidate_prof_exp');*/
				}
				else
				{
					$this->request->data['Candidate_workexp']['candidate_cv_id']= $resumeid;
					$this->request->data['Candidate_workexp']['company'] = $company = $_POST['company'.$i];
					$this->request->data['Candidate_workexp']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_workexp']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_workexp']['jobTitle'] = $jobTitle = $_POST['jobTitle'.$i];
					$this->request->data['Candidate_workexp']['fromDate'] = $fromDate = $_POST['date-start'.$i];
					$this->request->data['Candidate_workexp']['toDate'] = $toDate = $_POST['date-end'.$i];
					$this->request->data['Candidate_workexp']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_workexp']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_workexp']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_workexp']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_workexp']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					$this->request->data['Candidate_workexp']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_workexp']['description'] = $description = $_POST['description'.$i];
					$this->Candidate_workexp->create(false);
					$boolUserprocessSaved = $this->Candidate_workexp->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					/*$getInsertid_UsersID = $this->Candidate_prof_exp->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('professionalaffiliations');
						$arrResponse['contactshtml'] = $strWidgetListerHtml;
						if($arrResponse['contactshtml'])
						{
							$arrResponse['status'] = "success";
						}
						
						echo json_encode($arrResponse);
						exit;
					}*/
				}
			}
			$arrLoggedUser = $this->Auth->user();
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('resumeid',$resumeid);
			$view->set('arrLoggedUser',$arrLoggedUser);
			if($resumeid)
			{
				if($strRtype == "functional")
				{
					$candidateEducation = $this->Candidate_Education_f->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$view->set('candidateEducation',$candidateEducation);
					$strWidgetListerHtml = $view->element('feducation');
					//echo $strWidgetListerHtml;exit;
				}
				else
				{
						if($strAcademicInfo == "academia")
						{
							$publications = $this->Candidate_publications->find('all',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
							$view->set('publications',$publications);
							$strWidgetListerHtml = $view->element('publications');
						}
						else
						{
							
							if($strAcademicInfo == "military")
							{
								$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
								$view->set('candidateawards',$candidateawards);
								$strWidgetListerHtml = $view->element('awardsm');	
							}
							else
							{
								$proffsionalaffilations = $this->Candidate_prof_affilations->find('all',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
								//print("<pre>");
								//print_r($proffsionalaffilations);
								//exit;
								$view->set('proffsionalaffilations',$proffsionalaffilations);
								$strWidgetListerHtml = $view->element('professionalaffiliations');
							}
						}
				}
				
			}
			else
			{
				//echo $strRtype;exit;
				if($strRtype == "functional")
				{
					$strWidgetListerHtml = $view->element('feducation');
				}
				else
				{
					if($strAcademicInfo == "academia")
					{
						$strWidgetListerHtml = $view->element('publications');
					}
					else
					{
						$strWidgetListerHtml = $view->element('professionalaffiliations');
					}
				}
				
			}
			$arrResponse['contactshtml'] = $strWidgetListerHtml;
			if($arrResponse['contactshtml'])
			{
					$arrResponse['status'] = "success";
			}
				
			echo json_encode($arrResponse);
			exit;
		}
		
	}
	
	public function completesteps($intPortalId = "",$strStepAction = "",$strStepType = "",$strStepId = "")
	{
		/*print("<pre>");
		print_r($this->request->data);
		exit;*/
		
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		
		if($intPortalId)
		{
			//echo "HI";
			//echo $this->Session->read('Auth.j_process_substeps_completed');
			
			//exit;
			
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('PortalUser');
			$this->loadModel('Jobsearchtracker');
			$this->loadModel('Categories');
			
			$arrCompleteTrackingData = array();
			$arrCompleteTrackingData['Jobsearchtracker']['candidate_id'] = $arrLoggedUser['candidate_id'];
			$arrCompleteTrackingData['Jobsearchtracker']['step_id'] = $strStepId;
			$arrCompleteTrackingData['Jobsearchtracker']['step_type'] = $strStepType;
			$strStepsCompletion = $this->request->data['comcriteria'];
			
			//$strCompletionCriteria = 
			if($strStepAction == "complete")
			{
				$isStepTracked = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrCompleteTrackingData['Jobsearchtracker']['candidate_id'],'step_id'=>$arrCompleteTrackingData['Jobsearchtracker']['step_id'])));
				
				if($isStepTracked)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = "This Step is already completed";
				}
				else
				{
					$arrStepCompleted = $this->Jobsearchtracker->save($arrCompleteTrackingData);
					if($arrStepCompleted)
					{
						$arrUserCompletedSteps = $arrLoggedUser['j_process_substeps_completed'];
						$arrUserCompletedSteps = ($arrUserCompletedSteps + 1);
						$arrUserCompletedStepsPer = (($arrUserCompletedSteps/$arrLoggedUser['jprocess_total_completion_substeps'])*100);
						$strCandidateStepsUpdated = $this->PortalUser->updateAll(
									array('j_process_substeps_completed'=>$arrUserCompletedSteps,"jprocess_completeion_per"=>$arrUserCompletedStepsPer),
									array('candidate_id =' => $arrLoggedUser['candidate_id'])
								);
						
						$this->Session->write("Auth.FrontendUser_".$intPortalId.".j_process_substeps_completed",$arrUserCompletedSteps);
						$this->Session->write("Auth.FrontendUser_".$intPortalId.".jprocess_completeion_per",$arrUserCompletedStepsPer);
						//echo "--".$this->Session->read("Auth.FrontendUser_".$intPortalId.".j_process_substeps_completed");
						
						/*$arrStepDetail = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_parent_id'),'conditions'=>array('content_category_id'=>$strStepId,'content_cat_for_user'=>$intUserType)));*/
						
						if($strStepsCompletion)
						{
							$arrLevelCompletion = explode("|",$strStepsCompletion);
							if(is_array($arrLevelCompletion) && (count($arrLevelCompletion)>0))
							{
								foreach($arrLevelCompletion as $arrLevel)
								{
									$strLevel = $arrLevel;
									$arrLevelDetail = explode("_",$arrLevel);
									//print("<pre>");
									//print_r($arrLevelDetail);
									if(is_array($arrLevelDetail) && (count($arrLevelDetail)>0))
									{
										$arrLeveType = explode("-",$arrLevelDetail[0]);
										
										$strLeveType = ucfirst($arrLeveType[0]);
										$strLeveTypeId = $arrLeveType[1];
										$intFrCnt = 0;
										foreach($arrLevelDetail as $arrLevelDet)
										{
											$intFrCnt++;
											if($intFrCnt == "1")
											{
												continue;
											}
											else
											{
												$arrLevelChilds = explode("~",$arrLevelDet);
												if(is_array($arrLevelChilds) && (count($arrLevelChilds)>0))
												{
													$strChildPresent = true;
													$this->Jobsearchtracker->create(false);
													foreach($arrLevelChilds as $arrChild)
													{
														$strJobCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrChild,'candidate_id'=>$arrCompleteTrackingData['Jobsearchtracker']['candidate_id'])));
														if($strJobCompleted <= 0)
														{
															$strChildPresent = false;
														}
													}
													
													if($strChildPresent)
													{
														$arrLevelSave['Jobsearchtracker']['step_type'] = $strLeveType;
														$arrLevelSave['Jobsearchtracker']['step_id'] = $strLeveTypeId;
														$arrLevelSave['Jobsearchtracker']['candidate_id'] = $arrCompleteTrackingData['Jobsearchtracker']['candidate_id'];
														//print("<pre>");
														//print_r($arrLevelSave);
														
														$arrLevelSaved = $this->Jobsearchtracker->save($arrLevelSave);
														if($arrLevelSaved)
														{
															$arrResponse['level_updation'] = "1";
															$arrResponse['level_type'] .= strtolower($strLeveType)."|";
															$arrResponse['level_ids'] .= $strLeveTypeId."|";
														}
													}
												}
											}
										}
									}
								}
							}
						}
						$arrResponse['level_type'] = rtrim($arrResponse['level_type'],"|");
						$arrResponse['level_ids'] = rtrim($arrResponse['level_ids'],"|");
						$arrResponse['status'] = 'success';
						$arrResponse['message'] = "You have completed this Step";
					}
					else
					{
						$arrResponse['status'] = 'fail';
						$arrResponse['message'] = "Please try again, Somethings is missing.";
					}
				}
			}
			
			if($strStepAction == "incomplete")
			{
				$isStepRemoved = $this->Jobsearchtracker->deleteAll(array('candidate_id' => $arrCompleteTrackingData['Jobsearchtracker']['candidate_id'],'step_id'=>$arrCompleteTrackingData['Jobsearchtracker']['step_id']),false);
				
				if($isStepRemoved)
				{
					$arrUserCompletedSteps = $arrLoggedUser['j_process_substeps_completed'];
					$arrUserCompletedSteps = ($arrUserCompletedSteps - 1);
					if($arrUserCompletedSteps<=0)
					{
						$arrUserCompletedSteps = 0;
					}
					$arrUserCompletedStepsPer = (($arrUserCompletedSteps/$arrLoggedUser['jprocess_total_completion_substeps'])*100);
					$strCandidateStepsUpdated = $this->PortalUser->updateAll(
								array('j_process_substeps_completed'=>$arrUserCompletedSteps,"jprocess_completeion_per"=>$arrUserCompletedStepsPer),
								array('candidate_id =' => $arrLoggedUser['candidate_id'])
							);
					$this->Session->write("Auth.FrontendUser_".$intPortalId.".j_process_substeps_completed",$arrUserCompletedSteps);
					$this->Session->write("Auth.FrontendUser_".$intPortalId.".jprocess_completeion_per",$arrUserCompletedStepsPer);
					
					if($strStepsCompletion)
					{
						$arrResponse['level_updation'] = "1";
						$arrLevelCompletion = explode("|",$strStepsCompletion);
						if(is_array($arrLevelCompletion) && (count($arrLevelCompletion)>0))
						{
							foreach($arrLevelCompletion as $arrLevel)
							{
								$strLevel = $arrLevel;
								$arrLevelDetail = explode("_",$arrLevel);
								if(is_array($arrLevelDetail) && (count($arrLevelDetail)>0))
								{
									$arrLeveType = explode("-",$arrLevelDetail[0]);
									$strLeveType = ucfirst($arrLeveType[0]);
									$strLeveTypeId = $arrLeveType[1];
									$arrResponse['level_type'] .= strtolower($strLeveType)."|";
									$arrResponse['level_ids'] .= $strLeveTypeId."|";
									
									$this->Jobsearchtracker->deleteAll(array('candidate_id' => $arrCompleteTrackingData['Jobsearchtracker']['candidate_id'],'step_id'=> $strLeveTypeId),false);
								}
							}
						}
					}
					
					$arrResponse['level_type'] = rtrim($arrResponse['level_type'],"|");
					$arrResponse['level_ids'] = rtrim($arrResponse['level_ids'],"|");
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = "Your operation was successfull";
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = "Please try again, Somethings is missing.";
				}
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = "There is a parameter missing, wrong request.";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function fnGetParentDetail($intChildEleId = "",&$arrParentDetail)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		//print("<pre>");
		//print_r($arrParentDetail);
		if($intChildEleId)
		{
			$this->loadModel('Categories');
			$arrChildDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intChildEleId)));
			if(is_array($arrChildDetail) && (count($arrChildDetail)>0))
			{
				
				if($arrChildDetail['0']['Categories']['content_category_parent_id'])
				{
					$arrParentDetail[$intChildEleId]['parent_id'] = $arrChildDetail['0']['Categories']['content_category_parent_id'];
					if($arrChildDetail['0']['Categories']['job_process_type'] == "Substeps")
					{
						$arrParentDetail[$intChildEleId]['parent_id_type'] = "Steps";
					}
					if($arrChildDetail['0']['Categories']['job_process_type'] == "Steps")
					{
						$arrParentDetail[$intChildEleId]['parent_id_type'] = "Phase";
					}
					//print("<pre>");
					//print_r($arrParentDetail);
					//echo "---".$intChildEleId;
					$arrChilds = $this->Categories->find('all',array('fields'=>array('content_category_parent_id','content_category_id'),'conditions'=>array('content_category_parent_id'=>$arrParentDetail[$intChildEleId]['parent_id'])));
					$arrC = array();
					if(is_array($arrChilds) && (count($arrChilds)>0))
					{
						foreach($arrChilds as $arChild)
						{
							$arrC[] = $arChild['Categories']['content_category_id'];
						}
						$strParentChild = implode("~",$arrC);
						$arrParentDetail[$intChildEleId]['parent_id_childs'] = $strParentChild;
					}
					$this->fnGetParentDetail($arrChildDetail['0']['Categories']['content_category_parent_id'],$arrParentDetail);
				}
				else
				{
					//$arrParentDetail[$intChildEleId]['parent_id'] = false;
					return $arrParentDetail;
				}
			}
			else
			{
				//$arrParentDetail[$intChildEleId]['parent_id'] = false;
				return $arrParentDetail;
			}
		}
		else
		{
			//$arrParentDetail[$intChildEleId]['parent_id'] = false;
			return $arrParentDetail;
		}		
	}
	
	public function fnGetStepsNavigationDetail($arrSubStepDetail = array())
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrStepsNavigationDetail = array();
		
		if(is_array($arrSubStepDetail) && (count($arrSubStepDetail)>0))
		{
			$arrNextSubStepNavgationDetail = array();
			$arrPreviousSubStepNavgationDetail = array();
			$this->loadModel('Categories');
			$intNextStepOrder = ($arrSubStepDetail['Categories']['job_search_order'] + 1);
			$arrNextSubStepDetail = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'Substeps','job_search_order'=>$intNextStepOrder)));
			if(is_array($arrNextSubStepDetail) && (count($arrNextSubStepDetail)>0))
			{
				$this->fnGetParentDetail($arrNextSubStepDetail[0]['Categories']['content_category_id'],$arrNextSubStepNavgationDetail);
				if(is_array($arrNextSubStepNavgationDetail) && (count($arrNextSubStepNavgationDetail)>0))
				{
					//print("<pre>");
					//print_r($arrNextSubStepNavgationDetail);
					
					foreach($arrNextSubStepNavgationDetail as $arrNextNavigat)
					{
						$arrStepsNavigationDetail['nextnavigation'][$arrNextNavigat['parent_id_type']] = $arrNextNavigat['parent_id'];
					}
					$arrStepsNavigationDetail['nextnavigation']['substep'] = $arrNextSubStepDetail[0]['Categories']['content_category_id'];
				}
			}
			$intPreviousStepOrder = ($arrSubStepDetail['Categories']['job_search_order'] - 1);
			if($intPreviousStepOrder >0)
			{
				$arrPreviousSubStepDetail = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'Substeps','job_search_order'=>$intPreviousStepOrder)));
			
				if(is_array($arrPreviousSubStepDetail) && (count($arrPreviousSubStepDetail)>0))
				{
					$this->fnGetParentDetail($arrPreviousSubStepDetail[0]['Categories']['content_category_id'],$arrPreviousSubStepNavgationDetail);
					if(is_array($arrPreviousSubStepNavgationDetail) && (count($arrPreviousSubStepNavgationDetail)>0))
					{
						//print("<pre>");
						//print_r($arrNextSubStepNavgationDetail);
						
						foreach($arrPreviousSubStepNavgationDetail as $arrPrevNavigat)
						{
							$arrStepsNavigationDetail['previousnavigation'][$arrPrevNavigat['parent_id_type']] = $arrPrevNavigat['parent_id'];
							//$arrStepsNavigationDetail['previousnavigation']['previousnavigationid'] = $arrPrevNavigat['parent_id'];
						}
						$arrStepsNavigationDetail['previousnavigation']['substep'] = $arrPreviousSubStepDetail[0]['Categories']['content_category_id'];
					}
				}
			}
			
			return $arrStepsNavigationDetail;
		}
		else
		{
			return $arrStepsNavigationDetail;
		}
	}
	
	public function jssteps($intPortalId = "",$strFurtherElement = "",$intFurtherElementParent = "")
	{
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		$intUserType = "3";
		$intContentType = "1";
		$this->loadModel('Contenttype');
		$arrContentType = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			
			
			if($strFurtherElement == "content")
			{
				$arrParentDetails = array();
				$view = new View($this, false);
				$view->set('intPortalId',$intPortalId);
				$this->loadModel('Categories');
				$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intFurtherElementParent,'content_cat_for_user'=>$intUserType)));
				if(is_array($arrCatDetail) && (count($arrCatDetail)>0))
				{
					foreach($arrCatDetail as $arrCat)
					{
						$arrStepsNavigationDetails = $this->fnGetStepsNavigationDetail($arrCat);
						//print("<pre>");
						//print_r($arrStepsNavigationDetails);
						
						$view->set('arrStepsNavigationDetails',$arrStepsNavigationDetails);
					}
				}
				
				//print("<pre>");
				//print_r($arrCatDetail);exit;
				$view->set('arrCatDetail',$arrCatDetail);
				$view->set('intCatDetailId',$intFurtherElementParent);
				$view->set('intContentonNewtab',"1");
				$this->loadModel('Jobsearchtracker');
				
				$this->fnGetParentDetail($intFurtherElementParent,$arrParentDetails);
				//print("<pre>");
				//print_r($arrParentDetails);
				$arrCriteria = array();
				$arrCurrentLocation = array();
				if(is_array($arrParentDetails) && (count($arrParentDetails)>0))
				{
					foreach($arrParentDetails as $arrParent)
					{
						$arrCurrentLocation['currentposition'][$arrParent['parent_id_type']] = $arrParent['parent_id'];
						$arrCriteria[] = $arrParent['parent_id_type']."-".$arrParent['parent_id']."_".$arrParent['parent_id_childs'];
					}
					$arrCurrentLocation['currentposition']['substep'] = $intFurtherElementParent;
					//print("<pre>");
					//print_r($arrCriteria);
					//echo implode("|",$arrCriteria);
					$view->set('arrCurrentLocation',$arrCurrentLocation);
					$view->set('strCriteria',implode("|",$arrCriteria));
				}
				
				$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$intFurtherElementParent)));
				$strActionButtonText = "Complete";
				$view->set('strCompleteId',"complete_substeps_".$intFurtherElementParent."_".$intPortalId);
				if($isStepCompleted)
				{
					$view->set('strCompleteId',"incomplete_substeps_".$intFurtherElementParent."_".$intPortalId);
					$strActionButtonText = "Reset";
				}
				//echo "--".$strActionButtonText;
				$view->set('strActionButtonText',$strActionButtonText);
				$view->set('strCompletionevent',"onclick='fnCompleteThis(this)'");
				

				$this->loadModel('Content');
				$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intFurtherElementParent),"ORDER"=>array('content_id'=>"ASC")));
				if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
				{
					$arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));
					
					$arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;
					
					$arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intFurtherElementParent),"ORDER"=>array('content_id'=>"ASC")));
					//echo $arrCatContent[0]['Content']['content_id'];exit;
					
					$arrCatContentSub = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_parent_id'=>$arrCatContent[0]['Content']['content_id']),"ORDER"=>array('content_id'=>"ASC")));
					$arrCatContent = array_merge($arrCatContent,$arrCatContentSub);
				
					/*print("<pre>");
					print_r($arrCatContent);
					
					print("<pre>");
					print_r($arrCatContentSub);
					
					print("<pre>");
					print_r(array_merge($arrCatContent,$arrCatContentSub));
					exit;*/
					
					//print("<pre>");
					//print_r($arrCatContentTitles);
					
					//print("<pre>");
					//print_r($arrCatContent);
					
					//exit;
				
					$view->set('arrCatContentTitles',$arrCatContentTitles);			
					$view->set('arrCatContent',$arrCatContent);
				}
				
				
				$arrContentTypeList = $this->Content->fnGetDistinctContentType($intFurtherElementParent,$intUserType);
				
				$view->set('arrContentTypeList',$arrContentTypeList);
				$view->set('arrContentType',$arrContentType);
				$arrContentListArticle = $this->Content->fnGetContentList($intFurtherElementParent,$arrContentTypeList[0]['content']['content_type']);
				$view->set('arrContentListArticle',$arrContentListArticle);
				$view->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
				$strWidgetListerHtml = $view->element('stepdetail');
				if($strWidgetListerHtml)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['jsstepshtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = "There's some problem, needs to be sorted out, please give it a try once more and check.";
				}
			}
			else
			{
				$this->loadModel('Categories');
				/*$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'phase'),'order'=>array('job_search_order'=>'ASC')));*/
				
				$arrJobSearchProcessSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>$strFurtherElement,'content_category_parent_id'=>$intFurtherElementParent),'order'=>array('job_search_order'=>'ASC')));
				//$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessSteps);
				if(is_array($arrJobSearchProcessSteps) && (count($arrJobSearchProcessSteps)>0))
				{
					//if($strFurtherElement == "substeps")
					//{
						$this->loadModel('Content');
						$this->loadModel('Jobsearchtracker');
						$intFrCnt = 0;
						foreach($arrJobSearchProcessSteps as $arrStep)
						{
							$arrCatContentData = $this->Content->find('all',array('fields'=>array('content_id','content'),'conditions'=>array('content_default_category'=>$arrStep['Categories']['content_category_id'])));
							if(is_array($arrCatContentData) && (count($arrCatContentData)>0))
							{
								$arrJobSearchProcessSteps[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
							}
							
							
							$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrStep['Categories']['content_category_id'])));
							if($isStepCompleted)
							{
								$arrJobSearchProcessSteps[$intFrCnt]['Categories']['iscompleted'] = "1";
							}
							else
							{
								$arrJobSearchProcessSteps[$intFrCnt]['Categories']['iscompleted'] = "0";
							}
							$intFrCnt++;
						}
					//}
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('strAccord', $strFurtherElement);
					$view->set('strAccordId', $intFurtherElementParent);
					$view->set('arrPhaseStep', $arrJobSearchProcessSteps);
					$strWidgetListerHtml = $view->element('phasesteps');
					if($strWidgetListerHtml)
					{
						$arrResponse['status'] = 'success';
						$arrResponse['jsstepshtml'] = $strWidgetListerHtml;
					}
					else
					{
						$arrResponse['status'] = 'fail';
						$arrResponse['message'] = "There's some problem, needs to be sorted out, please give it a try once more and check.";
					}
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = "There are no further steps under this.";
				}
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = "There is a parameter missing, wrong request.";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getcontact($intPortalId,$intContactId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];				
				$this->loadModel('JstContacts');
				$arrContact = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_id'=>$intContactId)));
				//print("<pre>");
				//print_r($arrContact);
				//exit;
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
					$view = new View($this, false);
					$view->set('intPortalId',$intPortalId);
					$view->set('arrContactDetail',$arrContact);
					$view->set('strHeader',"Edit");
					// call to function which gives list of countries
					$view->set('arrCountryList',$this->fnLoadCountryListToPrint());
					/* print("<pre>");
					print_r($this->fnLoadCountryListToPrint()); */
					
					// call to function which gives list of states belonging to countries
					$view->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrContact[0]['JstContacts']['jstcontacts_country']));
					
					/* print("<pre>");
					print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
					
					/* print("<pre>");
					print_r($arrListOfStates); */
					
					// call to function which gives list of cities belonging to states
					$view->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrContact[0]['JstContacts']['jstcontacts_state']));
					$strWidgetListerHtml = $view->element('contact_add_tpl_new');
					$arrResponse['contacthtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'Contact does not exists anymore';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function delcontact($intPortalId,$intContactId = "",$intDetailMode = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$this->loadModel('JstContacts');
				$intPortalThemeWidgetDeleted = $this->JstContacts->deleteAll(array('JstContacts.jstcontacts_id' => $intContactId),false);
				if($intPortalThemeWidgetDeleted)
				{
					$intContactCount = $this->JstContacts->find('count',array('jstcontacts_seeker_id'=>$intSeekerId));
					
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Contact was deleted Successfully';
					if($intDetailMode == "1")
					{
						$arrResponse['detailmode'] = "1";
					}
					
					if($intContactCount)
					{
						$arrResponse['alldeleted'] = "0";
					}
					else
					{
						$arrResponse['alldeleted'] = "1";
					}
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function getcontactform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();

			$arrResponse['status'] = 'success';
			$view = new View($this, false);
			$view->set('intPortalId',$intPortalId);
			$view->set('arrContactDetail',$arrContacts);
			// call to function which gives list of countries
			$view->set('arrCountryList',$this->fnLoadCountryListToPrint());
			/* print("<pre>");
			print_r($this->fnLoadCountryListToPrint()); */
			
			// call to function which gives list of states belonging to countries
			$view->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id']));
			
			/* print("<pre>");
			print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
			
			/* print("<pre>");
			print_r($arrListOfStates); */
			
			// call to function which gives list of cities belonging to states
			$view->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id']));
			$strWidgetListerHtml = $view->element('contact_add_tpl_new');
			$arrResponse['contactshtml'] = $strWidgetListerHtml;
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function addform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				//print("<pre>");
				//print_r($this->request->data);
				//exit;
				$intContactId = $this->request->data['contactid'];
				$intDetailMode = $this->request->data['deteailmode'];
				$arrJSContacts['JstContacts']['jstcontacts_seeker_id'] = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstContacts']['jstcontacts_fname'] = $this->request->data['c_f_name'];
				$arrJSContacts['JstContacts']['jstcontacts_lname'] = $this->request->data['c_l_name'];
				$arrJSContacts['JstContacts']['jstcontacts_cname'] = $this->request->data['comp_name'];
				$arrJSContacts['JstContacts']['jstcontacts_jtitle'] = $this->request->data['c_job_title'];
				$arrJSContacts['JstContacts']['jstcontacts_ptype'] = $this->request->data['c_person_type'];
				$arrJSContacts['JstContacts']['jstcontacts_address'] = $this->request->data['address1'];
				$arrJSContacts['JstContacts']['jstcontacts_address2'] = $this->request->data['address2'];
				$arrJSContacts['JstContacts']['jstcontacts_city'] = $this->request->data['UserCity'];
				$arrJSContacts['JstContacts']['jstcontacts_state'] = $this->request->data['UserState'];
				$arrJSContacts['JstContacts']['jstcontacts_postalcode'] = $this->request->data['UserZipcode'];
				$arrJSContacts['JstContacts']['jstcontacts_country'] = $this->request->data['UserCountry'];
				$arrJSContacts['JstContacts']['jstcontacts_phone1'] = $this->request->data['c_ph1_no'];
				$arrJSContacts['JstContacts']['jstcontacts_phonetype1'] = $this->request->data['c_ph1_type'];
				$arrJSContacts['JstContacts']['jstcontacts_phone2'] = $this->request->data['c_ph2_no'];
				$arrJSContacts['JstContacts']['jstcontacts_phonetype2'] = $this->request->data['c_ph2_type'];
				$arrJSContacts['JstContacts']['jstcontacts_fax'] = $this->request->data['c_fax'];
				$arrJSContacts['JstContacts']['jstcontacts_emailaddress'] = $this->request->data['c_email'];
				$arrJSContacts['JstContacts']['jstcontacts_website'] = $this->request->data['c_website'];
				$arrJSContacts['JstContacts']['jstcontacts_twitterid'] = $this->request->data['c_twitter'];
				$arrJSContacts['JstContacts']['jstcontacts_fbid'] = $this->request->data['c_facebook'];
				
				
				$this->loadModel('JstContacts');
				if($intContactId)
				{
					$boolUpdated = $this->JstContacts->updateAll(
								array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'],"jstcontacts_fname"=>"'".$arrJSContacts['JstContacts']['jstcontacts_fname']."'","jstcontacts_lname"=>"'".$arrJSContacts['JstContacts']['jstcontacts_lname']."'","jstcontacts_cname"=>"'".$arrJSContacts['JstContacts']['jstcontacts_cname']."'","jstcontacts_jtitle"=>"'".$arrJSContacts['JstContacts']['jstcontacts_jtitle']."'","jstcontacts_ptype"=>"'".$arrJSContacts['JstContacts']['jstcontacts_ptype']."'","jstcontacts_address"=>"'".$arrJSContacts['JstContacts']['jstcontacts_address']."'","jstcontacts_address2"=>"'".$arrJSContacts['JstContacts']['jstcontacts_address2']."'","jstcontacts_city"=>"'".$arrJSContacts['JstContacts']['jstcontacts_city']."'","jstcontacts_state"=>"'".$arrJSContacts['JstContacts']['jstcontacts_state']."'","jstcontacts_postalcode"=>"'".$arrJSContacts['JstContacts']['jstcontacts_postalcode']."'","jstcontacts_country"=>"'".$arrJSContacts['JstContacts']['jstcontacts_country']."'","jstcontacts_phone1"=>"'".$arrJSContacts['JstContacts']['jstcontacts_phone1']."'","jstcontacts_phonetype1"=>"'".$arrJSContacts['JstContacts']['jstcontacts_phonetype1']."'","jstcontacts_phone2"=>"'".$arrJSContacts['JstContacts']['jstcontacts_phone2']."'","jstcontacts_phonetype2"=>"'".$arrJSContacts['JstContacts']['jstcontacts_phonetype2']."'","jstcontacts_fax"=>"'".$arrJSContacts['JstContacts']['jstcontacts_fax']."'","jstcontacts_emailaddress"=>"'".$arrJSContacts['JstContacts']['jstcontacts_emailaddress']."'","jstcontacts_website"=>"'".$arrJSContacts['JstContacts']['jstcontacts_website']."'","jstcontacts_twitterid"=>"'".$arrJSContacts['JstContacts']['jstcontacts_twitterid']."'","jstcontacts_fbid"=>"'".$arrJSContacts['JstContacts']['jstcontacts_fbid']."'"),
								array('jstcontacts_id =' => $intContactId)
							);
					if($boolUpdated)
					{
						$arrResponse['status'] = 'success';
						$arrResponse['message'] = 'You have successfully updated the contact';
						$arrContacts = array();
						$arrJSContacts['JstContacts']['jstcontacts_id'] = $intContactId;
						$arrContacts[0] = $arrJSContacts;
						$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
						if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
						{
							$this->loadModel('User');
							$intFrCnt = 0;
							foreach($arrContactDetail as $arrContact)
							{
								
								if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'])
								{
									$arrContryName = $this->User->fnGetCountryName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country']);
									$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'] = $arrContryName['0']['country']['country_name'];
								}
								
								if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'])
								{
									$arrCityName = $this->User->fnGetCityName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city']);
									
									$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'] = $arrCityName['0']['city']['city_name'];
								}
								$intFrCnt++;
							}
						}
						$view = new View($this, false);
						$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
						$view->set('arrContactDetail',$arrContactDetail);
						$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Contact added successfully</div>');
						if($intDetailMode)
						{
							$strWidgetListerHtml = $view->element('contact_detail');
							$arrResponse['detailmode'] = "1";
						}
						else
						{
							//$strWidgetListerHtml = $view->element('contact_list');
							$strWidgetListerHtml = $view->element('contact_list_new');
						}
						$arrResponse['contactshtml'] = $strWidgetListerHtml;
						$arrResponse['contact_f_name'] = $arrJSContacts['JstContacts']['jstcontacts_fname'];
						$arrResponse['contact_l_name'] = $arrJSContacts['JstContacts']['jstcontacts_lname'];
						$arrResponse['contact_id'] = $intContactId;
						$arrResponse['updated'] = "1";
					}
					else
					{
						$arrResponse['status'] = 'fail';
						$arrResponse['message'] = 'Some error, Please try again';
						$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
					}
				}
				else
				{
					$intContactExists = $this->JstContacts->find('count',array('conditions'=>array('jstcontacts_emailaddress'=>$arrJSContacts['JstContacts']['jstcontacts_emailaddress'])));
					if($intContactExists)
					{
						$arrResponse['status'] = 'fail';
						$arrResponse['message'] = 'This Contact already exists in your contact list';
					}
					else
					{
						$arrContactSaved = $this->JstContacts->save($arrJSContacts);
						if($arrContactSaved)
						{
							$arrResponse['status'] = 'success';
							$arrResponse['message'] = 'You have successfully added the contact';
							$arrContacts = array();
							$arrJSContacts['JstContacts']['jstcontacts_id'] = $this->JstContacts->getLastInsertID();
							$arrContacts[0] = $arrJSContacts;
							$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
                                                        
                                                        /** Job Click Candidate User Entry **/
                                                            $arrContactData['candidate_id'] = $arrLoggedUser['candidate_id'];
                                                            $arrContactData['reference_id'] = $this->JstContacts->getLastInsertID();
                                                            $arrContactData['career_portal_id'] = $intPortalId;
                                                            $arrContactData['action_type'] = "contact add";
                                                            $arrContactData['feature'] = "CRM";
                                                            $arrContactData['action_date'] = date('Y-m-d');
                                                            $this->loadModel('JobStatistics');
                                                            $this->JobStatistics->save($arrContactData);
                                                        /** Job Click Candidate User Entry * */
                                                        
                                                        
							if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
							{
								$this->loadModel('User');
								$intFrCnt = 0;
								foreach($arrContactDetail as $arrContact)
								{
									
									if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'])
									{
										$arrContryName = $this->User->fnGetCountryName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country']);
										$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'] = $arrContryName['0']['country']['country_name'];
									}
									
									if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'])
									{
										$arrCityName = $this->User->fnGetCityName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city']);
										
										$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'] = $arrCityName['0']['city']['city_name'];
									}
									$intFrCnt++;
								}
							}
							$view = new View($this, false);
							$view->set('arrContactDetail',$arrContactDetail);
							$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
							$view->set('arrContactDetail',$arrContactDetail);
							$this->Session->setFlash('<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Contact added successfully</div>');
							$strWidgetListerHtml = $view->element('contact_list_new');
							$arrResponse['contactshtml'] = $strWidgetListerHtml;
							$arrResponse['contact_f_name'] = $arrJSContacts['JstContacts']['jstcontacts_fname'];
							$arrResponse['contact_l_name'] = $arrJSContacts['JstContacts']['jstcontacts_lname'];
							$arrResponse['contact_id'] = $this->JstContacts->getLastInsertID();
						}
						else
						{
							$arrResponse['status'] = 'fail';
							$arrResponse['message'] = 'Some error, Please try again';
							$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
						}
					}
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
				$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
			$this->Session->setFlash('<div class="alert alert-danger">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Some error, Please try again.</div>');
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function searchform($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$arrJSContacts['JstContacts']['jstcontacts_fname'] = $this->request->data['contact_fname'];
				$arrJSContacts['JstContacts']['jstcontacts_lname'] = $this->request->data['contact_lname'];
				$arrJSContacts['JstContacts']['jstcontacts_emailaddress'] = $this->request->data['contact_email'];
				$arrConditionArray = array();
				$arrConditionArray['jstcontacts_seeker_id'] = $intSeekerId;
				
				if($arrJSContacts['JstContacts']['jstcontacts_fname'])
				{
					$arrConditionArray['jstcontacts_fname'] = $arrJSContacts['JstContacts']['jstcontacts_fname'];
				}
				
				if($arrJSContacts['JstContacts']['jstcontacts_lname'])
				{
					$arrConditionArray['jstcontacts_lname'] = $arrJSContacts['JstContacts']['jstcontacts_lname'];
				}
				
				if($arrJSContacts['JstContacts']['jstcontacts_emailaddress'])
				{
					$arrConditionArray['jstcontacts_emailaddress'] = $arrJSContacts['JstContacts']['jstcontacts_emailaddress'];
				}
				
				
				$this->loadModel('JstContacts');
				$arrContacts = $this->JstContacts->find('all',array('conditions'=>$arrConditionArray));
				if(is_array($arrContacts) && (count($arrContacts)>0))
				{
					$arrResponse['status'] = 'success';
					$view = new View($this, false);
					$view->set('arrContactDetail',$arrContacts);
					$strWidgetListerHtml = $view->element('contact_list');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'There is no Contact matching with provided filteration criteria';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'Bad Request';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing, Please try again';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function add($intPortalId = "")
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
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true).'">Appointments</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->set('contactlistsurl',Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true));
			
			//print("<pre>");
			//print_r($arrContactDetail);
			
			// call to function which gives list of countries
			$this->set('arrCountryList',$this->fnLoadCountryListToPrint());
			/* print("<pre>");
			print_r($this->fnLoadCountryListToPrint()); */
			
			// call to function which gives list of states belonging to countries
			$this->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id']));
			
			/* print("<pre>");
			print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
			
			/* print("<pre>");
			print_r($arrListOfStates); */
			
			// call to function which gives list of cities belonging to states
			$this->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id']));
		}
	}
	
	public function contactdetail($intPortalId = "",$intContactId = "")
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
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			$this->loadModel('JstContacts');
			$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'],"jstcontacts_id"=>$intContactId)));
			if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
			{
				$this->loadModel('User');
				if($arrContactDetail[0]['JstContacts']['jstcontacts_country'])
				{
					$arrContryName = $this->User->fnGetCountryName($arrContactDetail[0]['JstContacts']['jstcontacts_country']);
					$arrContactDetail[0]['JstContacts']['jstcontacts_country'] = $arrContryName['0']['country']['country_name'];
				}
				
				if($arrContactDetail[0]['JstContacts']['jstcontacts_state'])
				{
					
					$arrStateName = $this->User->fnGetStateName($arrContactDetail[0]['JstContacts']['jstcontacts_state']);
					//print("<pre>");
					//print_r($arrStateName);
					
					$arrContactDetail[0]['JstContacts']['jstcontacts_state'] = $arrStateName['0']['state']['state_name'];
				}
				
				if($arrContactDetail[0]['JstContacts']['jstcontacts_city'])
				{
					$arrCityName = $this->User->fnGetCityName($arrContactDetail[0]['JstContacts']['jstcontacts_city']);
					
					$arrContactDetail[0]['JstContacts']['jstcontacts_city'] = $arrCityName['0']['city']['city_name'];
				}
			}
			$this->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
			$this->set('strListcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'index',$intPortalId),true));
			$this->set('arrContactDetail',$arrContactDetail);
			//print("<pre>");
			//print_r($arrContactDetail);
			
		}
	}
	
	public function getcontactshtml($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		if($intPortalId)
		{
			$this->loadModel('JstContacts');
			//$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
			$this->JstContacts->recursive = 0;

		$this->Paginator->settings = array(

			'JstContacts' => array(

				'conditions' => array('jstcontacts_seeker_id' => $arrLoggedUser['candidate_id']),

			)

		);
		$arrContactDetail = $this->Paginator->paginate('JstContacts');
		
		
			if(is_array($arrContactDetail) && (count($arrContactDetail)>0))
			{
				$this->loadModel('User');
				$intFrCnt = 0;
				foreach($arrContactDetail as $arrContact)
				{
					
					if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'])
					{
						$arrContryName = $this->User->fnGetCountryName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country']);
						$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_country'] = $arrContryName['0']['country']['country_name'];
					}
					
					if($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'])
					{
						$arrCityName = $this->User->fnGetCityName($arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city']);
						
						$arrContactDetail[$intFrCnt]['JstContacts']['jstcontacts_city'] = $arrCityName['0']['city']['city_name'];
					}
					$intFrCnt++;
				}
			}
			
			//echo "<pre>";
			//print_r($arrContactDetail);
			//exit();
			$view = new View($this, false);
			$view->set('arrContactDetail',$arrContactDetail);
			$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
			$view->set('arrContactDetail',$arrContactDetail);
			$strWidgetListerHtml = $view->element('contact_list_new');
			$arrResponse['status'] = "success";
			$arrResponse['html'] = $strWidgetListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter missing";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function index($intPortalId = "")
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
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			$this->set('strFooter1','<a href="'.Router::url(array('controller'=>'jstappointments','action'=>'index',$intPortalId),true).'">Appointments</a>');
			$this->set('strFooter2','<a href="'.Router::url(array('controller'=>'jsttasks','action'=>'index',$intPortalId),true).'">Tasks</a>');
			$this->set('strFooter3','<a href="'.Router::url(array('controller'=>'jsprocess','action'=>'index',$intPortalId),true).'">Job Search Process</a>');
			
			$this->loadModel('JstContacts');
			$arrContactDetail = $this->JstContacts->find('all',array('conditions'=>array('jstcontacts_seeker_id'=>$arrLoggedUser['candidate_id'])));
			$this->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
			$this->set('arrContactDetail',$arrContactDetail);
			//print("<pre>");
			//print_r($arrContactDetail);
			
			// call to function which gives list of countries
			$this->set('arrCountryList',$this->fnLoadCountryListToPrint());
			/* print("<pre>");
			print_r($this->fnLoadCountryListToPrint()); */
			
			// call to function which gives list of states belonging to countries
			$this->set('arrStateList',$this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id']));
			
			/* print("<pre>");
			print_r($this->fnLoadStatesListForCountryToPrint($arrViewUserDetail[0]['country_id'])); */
			
			/* print("<pre>");
			print_r($arrListOfStates); */
			
			// call to function which gives list of cities belonging to states
			$this->set('arrCityList',$this->fnLoadCityListForStateToPrint($arrViewUserDetail[0]['state_id']));
			
		}
	}
	
	public function removeref($intPortalId = "",$intCandRefId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$arrLogedUser = $this->Auth->user();
				
				//$this->request->data['can_ref_id'] = '17';
				
				if($this->request->data['can_ref_id'])
				{
					
					// code to delete
					$this->loadModel('CandidateReferences');
					$intCandidateReferenceDeleted = $this->CandidateReferences->deleteAll(array('CandidateReferences.candidate_reference_id' => $this->request->data['can_ref_id']),false);
					if($intCandidateReferenceDeleted)
					{
						$intPortalReferenceExists = $this->CandidateReferences->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'])
						));
						
						$arrResponse['delstatus'] = "success";
						$arrResponse['message'] = "Reference Removed successfully!!";
						$arrResponse['updateid'] = $this->request->data['can_ref_id'];
						$arrResponse['remainingref'] = $intPortalReferenceExists;
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse['delstatus'] = "fail";
						$arrResponse['message'] = "Please try deleting again!!";
						echo json_encode($arrResponse);
						exit;
					}
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Bad Url";
				
				echo json_encode($arrResponse);
				exit;
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Bad Url";
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function modify($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$arrLogedUser = $this->Auth->user();
				$this->loadModel('CandidateReferences');
				$this->request->data['CandidateReferences']['candidate_id'] = $arrLogedUser['candidate_id'];
				$this->request->data['CandidateReferences']['reference_name'] = addslashes(trim($this->request->data['reference_name']));
				$this->request->data['CandidateReferences']['reference_job_title'] = addslashes(trim($this->request->data['job_title']));
				$this->request->data['CandidateReferences']['reference_company_name'] = addslashes(trim($this->request->data['company_name']));
				$this->request->data['CandidateReferences']['reference_tele_number'] = addslashes(trim($this->request->data['tele_number']));
				$this->request->data['CandidateReferences']['reference_phone_number'] = addslashes(trim($this->request->data['cell_number']));
				$this->request->data['CandidateReferences']['reference_email_address'] = addslashes(trim($this->request->data['email_address']));
				$this->request->data['CandidateReferences']['reference_creator_id'] = $arrLogedUser['candidate_id'];
				
				if($this->request->data['edit_reference_id'])
				{
					// code to edit
					$boolUpdated = $this->CandidateReferences->updateAll(
								array('CandidateReferences.reference_name' => "'".$this->request->data['CandidateReferences']['reference_name']."'",'CandidateReferences.reference_job_title'=>"'".$this->request->data['CandidateReferences']['reference_job_title']."'",'CandidateReferences.reference_company_name'=>"'".$this->request->data['CandidateReferences']['reference_company_name']."'",'CandidateReferences.reference_tele_number'=>"'".$this->request->data['CandidateReferences']['reference_tele_number']."'",'CandidateReferences.reference_phone_number'=>"'".$this->request->data['CandidateReferences']['reference_phone_number']."'",'CandidateReferences.reference_email_address'=>"'".$this->request->data['CandidateReferences']['reference_email_address']."'"),
								array('CandidateReferences.candidate_reference_id =' => $this->request->data['edit_reference_id'])
							);
					if($boolUpdated)
					{
						$arrResponse['status'] = "success";
						$arrResponse['message'] = "Reference Updated successfully!!";
						$arrResponse['updateid'] = $this->request->data['edit_reference_id'];
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Please try editing again!!";
						
						echo json_encode($arrResponse);
						exit;
					}
				}
				else
				{
					// code to add
					$intPortalReferenceExists = $this->CandidateReferences->find('count', array(
									'conditions' => array('candidate_id' => $arrLogedUser['candidate_id'],'reference_email_address'=> $this->request->data['CandidateReferences']['reference_email_address'])
								));
					if($intPortalReferenceExists)
					{
						$arrResponse['status'] = "fail";
						$arrResponse['message'] = "Reference already Exists!!";
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$this->CandidateReferences->set($this->request->data);
						$boolReferenceCreated = $this->CandidateReferences->save($this->request->data);
						$intReferenceCreatedId = $this->CandidateReferences->getLastInsertID();
						if($boolReferenceCreated)
						{
							$arrResponse['status'] = "success";
							$arrResponse['message'] = "Reference created successfully!!";
							$arrResponse['createdid'] = $intReferenceCreatedId;
							
							echo json_encode($arrResponse);
							exit;
						}
						//print("<pre>");
						//print_r($this->request->data['CandidateReferences']);
						//exit;
					}
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Bad Url";
				
				echo json_encode($arrResponse);
				exit;
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Bad Url";
			
			echo json_encode($arrResponse);
			exit;
		}
	}
        
        
	public function deleteallcontacts()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$intContactId = $this->request->data['contactId'];
		$intPortalId = $this->request->data['PortalId'];
                
		if($intPortalId && $intContactId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
                            $contactId = explode(",", $intContactId);
                            foreach ($contactId as $Id){
                                $this->loadModel('JstContacts');
                                $Deletedarr = $this->JstContacts->deleteAll(array('JstContacts.jstcontacts_id' => $Id),false);
                            }
                            
                            $arrResponse['status'] = 'success';
//                            $arrResponse['message'] = 'Contact was deleted Successfully';
                            $arrResponse['intContactId'] = $intContactId;
                            $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Contact was deleted Successfully.</div>';
//                            $this->Session->setFlash('<div class="alert alert-success">
//						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//						  Contact was deleted Successfully.</div>');
			}
			else
			{
				$arrResponse['status'] = 'fail';
//				$arrResponse['message'] = 'Bad Request';
                                $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Bad Request.</div>';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
//			$arrResponse['message'] = 'Parameter missing, Please try again';
                        $arrResponse['message'] = '<div class="alert alert-success">
						  <img src="'.Router::url('/', true).'/images/icon-alert-success.png" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  Parameter missing, Please try again.</div>';
		}
		echo json_encode($arrResponse);
		exit;
	}
        
}
