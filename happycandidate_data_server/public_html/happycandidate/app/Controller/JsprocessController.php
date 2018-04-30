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
class JsprocessController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jsprocess';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail','login');
	}
	
	public function getcontentdetail($intPortalId = "",$intContentId = "")
	{
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		
		if($intPortalId && $intContentId)
		{
			$this->loadModel('Content');
			$arrContenDetail = $this->Content->find('all',array('conditions'=>array('content_id'=>$intContentId)));
			if(is_array($arrContenDetail) && (count($arrContenDetail)>0))
			{
				$arrResponse['status'] = 'success';
				$arrResponse['content'] = stripslashes(htmlspecialchars_decode($arrContenDetail[0]['Content']['content']));
			}
			else
			{
				$arrResponse['status'] = 'fail';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter Missing';
		}
		echo json_encode($arrResponse);
		exit;
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
						$this->Session->write("Auth.FrontendUser_".$intPortalId.".jprocess_completeion_per",round($arrUserCompletedStepsPer, 2));
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
														$arrLevelSave['Jobsearchtracker']['completion_date_time'] = date('Y-m-d');
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
						$arrResponse['complete_per'] = round($arrUserCompletedStepsPer, 2);
						$arrResponse['completestep'] = $isStepCompleted;
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
					$arrResponse['complete_per'] = round($arrUserCompletedStepsPer, 2);
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
	
		
	public function advisor($intPortalId = "5",$intSeekerId = "5",$intCvId = "30")
	{
		$this->layout = "defaultnewtheme";
		$this->loadModel('Candidate_Cv');
		$compCandidates = $this->Components->load('TimeCalculation');
		$this->loadModel('Candidate_prof_exp');
		$this->loadModel('Candidate_workexp');
		$arrCvDetail = $this->Candidate_Cv->find('all', array(
			'conditions' => array('candidate_id'=> $intSeekerId,'candidatecv_id'=> $intCvId)
		));
		$strRtype = $arrCvDetail[0]['Candidate_Cv']['mode'];
		//$this->loadModel('Candidate_prof_exp_f_acc');
		
		if($strRtype == "functional")
		{
			$arrPrfExp = $this->Candidate_workexp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
		}
		else
		{
			$arrPrfExp = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
		}
		
		$intTotalWork = count($arrPrfExp);
		
		//print("<pre>");
		//print_r($arrPrfExp);
		
		if(is_array($arrPrfExp) && (count($arrPrfExp)>0))
		{
			$intJobs = 0;
			$intTotalDays = 0;
			$intAverageEmployedYears = "";
			$intTotalNumberOfYearsEmployed = "";
			$arrJoobsD = array();
			$intForCnt = 0;
			$intForJCnt = 0;
			$intTotalDurationDays = 0;
			$view = new View($this, false);
			foreach($arrPrfExp as $arrExp)
			{
				$intDuration = 0;
				if($strRtype == "functional")
				{
					$strStartingMonth = $arrExp['Candidate_workexp']['frommonth'];
					$strStartingYear = $arrExp['Candidate_workexp']['fromyear'];
					$strEndingMonth = $arrExp['Candidate_workexp']['tomonth'];
					$strEndingYear = $arrExp['Candidate_workexp']['toyear'];
				}
				else
				{
					$strStartingMonth = $arrExp['Candidate_prof_exp']['frommonth'];
					$strStartingYear = $arrExp['Candidate_prof_exp']['fromyear'];
					$strEndingMonth = $arrExp['Candidate_prof_exp']['tomonth'];
					$strEndingYear = $arrExp['Candidate_prof_exp']['toyear'];
				}
				
				
				$strStartingDate = date("Y-m-d",strtotime("01-".$strStartingMonth."-".$strStartingYear));
				$strEndingDate = date("Y-m-t",strtotime("01-".$strEndingMonth."-".$strEndingYear));
				
				
				$intDays = $compCandidates->fnGetDurationInDays($strStartingDate,$strEndingDate);
				
				$intTotalDays = $intTotalDays + $intDays;
				/*$arrJoobsD[$intForCnt]['start'] =  date("Y-m-d",strtotime("01-".$strStartingMonth."-".$strStartingYear));
				$arrJoobsD[$intForCnt]['end'] =  date("Y-m-t",strtotime("01-".$strEndingMonth."-".$strEndingYear));*/
				
				$intForJCnt = $intForCnt +1;
				if($intForJCnt < count($arrPrfExp))
				{
					if($strRtype == "functional")
					{
						if((($arrPrfEx[$intForCnt]['Candidate_workexp']['frommonth'] && $arrPrfEx[$intForCnt]['Candidate_workexp']['fromyear']) && ($arrPrfEx[$intForJCnt]['Candidate_workexp']['tomonth'] && $arrPrfEx[$intForJCnt]['Candidate_workexp']['toyear'])))
						{
							$strStartDate = $arrPrfEx[$intForCnt]['Candidate_workexp']['frommonth']."-".$arrPrfEx[$intForCnt]['Candidate_workexp']['fromyear'];
							$strEndDate = $arrPrfEx[$intForJCnt]['Candidate_workexp']['tomonth']."-".$arrPrfEx[$intForJCnt]['Candidate_workexp']['toyear'];
							
							$strStartDate = date("Y-m-d",strtotime("01-".$strStartDate));
							$strEndDate = date("Y-m-t",strtotime("01-".$strEndDate));
							
							$intDuration = $compCandidates->fnGetDurationInDays($strStartDate,$strEndDate);
						}
						else
						{
							$intDuration = 0;
						}
						
					}
					else
					{
						if((($arrPrfEx[$intForCnt]['Candidate_prof_exp']['frommonth'] && $arrPrfEx[$intForCnt]['Candidate_prof_exp']['fromyear']) && ($arrPrfEx[$intForJCnt]['Candidate_prof_exp']['tomonth'] && $arrPrfEx[$intForJCnt]['Candidate_prof_exp']['toyear'])))
						{
							$strStartDate = $arrPrfEx[$intForCnt]['Candidate_prof_exp']['frommonth']."-".$arrPrfEx[$intForCnt]['Candidate_prof_exp']['fromyear'];
							$strEndDate = $arrPrfEx[$intForJCnt]['Candidate_prof_exp']['tomonth']."-".$arrPrfEx[$intForJCnt]['Candidate_prof_exp']['toyear'];
							
							$strStartDate = date("Y-m-d",strtotime("01-".$strStartDate));
							$strEndDate = date("Y-m-t",strtotime("01-".$strEndDate));
							
							$intDuration = $compCandidates->fnGetDurationInDays($strStartDate,$strEndDate);
						}
						else
						{
							$intDuration = 0;
						}
					}
					$intTotalDurationDays = $intTotalDurationDays + $intDuration;
					
					$intForCnt++;
					$intJobs++;
				}
				else
				{
					$intForCnt++;
					$intJobs++;
					continue;
				}
			}
			
			
			
			
			/*$intTotalDurationDays = 0;
			for($intI = 0; $intI<count($arrPrfExp);$intI++)
			{
				$intDuration = 0;
				if(($arrPrfEx[$intI]['Candidate_prof_exp']['frommonth'] && $arrPrfEx[$intI]['Candidate_prof_exp']['fromyear']) && ($arrPrfEx[$intI+1]['Candidate_prof_exp']['tomonth'] && $arrPrfEx[$intI+1]['Candidate_prof_exp']['toyear']))
				{
					$strStartDate = $arrPrfEx[$intI]['Candidate_prof_exp']['frommonth']."-".$arrPrfEx[$intI]['Candidate_prof_exp']['fromyear'];
					$strEndDate = $arrPrfEx[$intI+1]['Candidate_prof_exp']['tomonth']."-".$arrPrfEx[$intI+1]['Candidate_prof_exp']['toyear'];
					
					$strStartDate = date("Y-m-d",strtotime("01-".$strStartDate));
					$strEndDate = date("Y-m-t",strtotime("01-".$strEndDate));
					
					$intDuration = $compCandidates->fnGetDurationInDays($strStartDate,$strEndDate);

				}
				else
				{
					$intDuration = 0;
				}
				
				$intTotalDurationDays = $intTotalDays + $intDuration;
			}*/
			
			$view->set('arrCvDetail',$arrCvDetail);
			$intAverageDays = $intTotalDays / $intJobs;
			$intAverageEmployedYears = $intAverageDays / 365;
			$intTotalNumberOfYearsEmployed = $intTotalDays / 365;
			$intTotalDurationYearWise = $intTotalDurationDays / 30;
			if($intAverageEmployedYears < 1)
			{
				//echo "HI";
				$this->set('averagedurationyear',"Under One Year");
				$strCareeAdvisorAverageEmployedHtml = $view->element('career_advisor_average_under_one');
				
				
			}
			
			if($intAverageEmployedYears >= 1 && $intAverageEmployedYears <= 5)
			{
				//echo "BI";
				$this->set('averagedurationyear',"2 – 10  Years");
				$strCareeAdvisorAverageEmployedHtml = $view->element('career_advisor_average_under_two_to_five');
				
			}
			
			if($intTotalNumberOfYearsEmployed < 2)
			{
				//echo "HI";
				$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_under_2');
				$this->set('averagedurationnumber',"Less than 2 years");
				
			}
			
			if($intTotalNumberOfYearsEmployed >= 2 && $intTotalNumberOfYearsEmployed <= 10)
			{
				//echo "BI";
				$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_two_to_ten');
				$this->set('averagedurationnumber',"2 – 10  Years");
				
			}
			
			if($intTotalNumberOfYearsEmployed >= 10)
			{
				//echo "SI";
				$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_above_ten');
				$this->set('averagedurationnumber',"10+ years");
			}
			
			if($intTotalDurationYearWise < 3)
			{
				$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_under_3');
				$this->set('averagedurationgaps',"Under 3 Months");
			}
			
			/*if($intTotalDurationYearWise > 3)
			{
				$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_under_3');
				$this->set('averagedurationgaps',"Under 3 Months");
			}*/
			
			if($intTotalDurationYearWise >= 3 && $intTotalDurationYearWise <= 12)
			{
				$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_three_to_twelve');
				$this->set('averagedurationgaps',"3-12 Months");
			}
			
			if($intTotalDurationYearWise >12)
			{
				$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_twelve_above');
				$this->set('averagedurationgaps',"12 Months or longer");
			}
			
			$this->set('intPortalId',$intPortalId);
			$this->set('averageduration',$strCareeAdvisorAverageEmployedHtml);
			$this->set('numberduration',$strCareeAdvisorNumberofYearsEmployedHtml);
			$this->set('gapsduration',$strCareeAdvisorGapsEmployedHtml);
			
			//$arrResponse['status'] = 'success';
			//$arrResponse['careeradvisorhtml'] = $view->element('career_advisor');
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = "Candidate has not provided any profession experience detail yet.";
		}
	}
	
	public function getstepsancestors($intPortalId = "",$intStepId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intStepId)
		{
			$strCurrentStepId = $this->request->data['currstep'];
			$arrReturnString = array();
			$this->loadModel('Categories');
			if($strCurrentStepId)
			{
				$arrCurStepDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$strCurrentStepId)));
				if(is_array($arrCurStepDetail) && (count($arrCurStepDetail)>0))
				{
					$arrResponse['currsteporder'] = $arrCurStepDetail[0]['Categories']['job_search_order'];
					
				}
			}
			
			$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('job_search_order'=>$intStepId)));
			if(is_array($arrCatDetail) && (count($arrCatDetail)>0))
			{
				$intChildStepId = $arrCatDetail[0]['Categories']['content_category_id'];
				$arrReturnString[] = $intChildStepId;
			}
			$arrNextSubStepNavgationDetail = array();
			$this->fnGetParentDetail($intChildStepId,$arrNextSubStepNavgationDetail);
			$strReturnString = "";
			if(is_array($arrNextSubStepNavgationDetail) && (count($arrNextSubStepNavgationDetail)>0))
			{
				$arrResponse['status'] = 'success';
				foreach($arrNextSubStepNavgationDetail as $arrNavigation)
				{
					$arrReturnString[] = $arrNavigation['parent_id'];
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
			}
			$arrReturnString = array_reverse($arrReturnString);
			$strReturnString = implode("_",$arrReturnString);
			$arrResponse['returnstring'] = $strReturnString;
		}
		else
		{
			$arrResponse['status'] = 'fail';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function fnGetParentDetail($intChildEleId = "",&$arrParentDetail)
	{
		//$this->layout = NULL;
		//$this->autoRender = false;
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
						//print("<pre>");
						//print_r($arrParentDetail);
					}
					$this->fnGetParentDetail($arrChildDetail['0']['Categories']['content_category_parent_id'],$arrParentDetail);
				}
				else
				{
					//print("<pre>");
					//print_r($arrParentDetail);
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
		//$this->layout = NULL;
		//$this->autoRender = false;
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
				//echo "--".$intFurtherElementParent;exit;
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
				//print($intFurtherElementParent);
				//exit;
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
				$strActionButtonText = "Complete &gt";
				
				$view->set('strCompleteId',"complete_substeps_".$intFurtherElementParent."_".$intPortalId);
				if($isStepCompleted)
				{
					$view->set('strCompleteId',"incomplete_substeps_".$intFurtherElementParent."_".$intPortalId);
					$strActionButtonText = "Reset";
				}
				//echo "--".$strActionButtonText;
				$view->set('strActionButtonText',$strActionButtonText);
				$view->set('strCompletionevent',"onclick='fnCompleteThis(this)'");
				
				//echo "---".$intFurtherElementParent;exit;
				$this->loadModel('Content');
				$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intFurtherElementParent),"ORDER"=>array('content_id'=>"ASC")));
				//print("<pre>");
				//print_r($arrCatContentTitles);
				//exit;
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
	
	public function index($intPortalId = "")
	{
		//echo $this->layout;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			 $stepIncompleteid = "";
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
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
					}
					
					//echo "--".$arrJobSearchPhase['Categories']['content_category_id'];
					$arrStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrJobSearchPhase['Categories']['content_category_id'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
					if($arrStepCompleted)
					{
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completed'] = "1";
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completion_class'] = "stepcomplete";
					}
					
					$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'steps','content_category_parent_id'=>$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));
					if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
					{
						$intFrNewCnt = 0;
						$this->loadModel('Jobsearchtracker');
						foreach($arrJobPhaseSteps as $arrJsteps)
						{//echo $arrJsteps['Categories']['content_category_id'];//exit();
							 $isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['content_category_id'])));							
							if($isStepCompleted)
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "1";
							}
							else
							{
                                                                if ($stepIncompleteid == "") {
                                                                    $stepIncompleteid = $arrJsteps['Categories']['content_category_id'];
                                                                    $phaseIncompleteid = $arrJsteps['Categories']['content_category_parent_id'];

                                                                    $arrfirstStepdata = $arrJsteps['Categories'];
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
                        $arrJobPhasesubSteps = $this->Categories->find('all', array('fields' => array('content_category_id', 'job_search_order', 'content_category_name', 'content_category_parent_id'), 'conditions' => array('job_process_type' => 'substeps', 'content_category_parent_id' => $stepIncompleteid), 'order' => array('job_search_order' => 'ASC')));

                        $incompleteorder = 0;
                        $incompleteSubstepid = 0;
                        $this->loadModel('Jobsearchtracker');
                        if (is_array($arrJobPhasesubSteps) && (count($arrJobPhasesubSteps) > 0)) {
                            foreach ($arrJobPhasesubSteps as $substeps) {

                                $substep_id = $substeps['Categories']['content_category_id'];
                                $job_search_order = $substeps['Categories']['job_search_order'];

                                $issubStepCompleted = $this->Jobsearchtracker->find('count', array('conditions' => array('candidate_id' => $arrLoggedUser['candidate_id'], "step_id" => $substep_id)));
                                if (!$issubStepCompleted) {
                                    if ($incompleteorder == "") {
                                        $arrStepContentData = $this->Content->find('all', array('fields' => array('content_id', 'content', 'content_intro_text'), 'conditions' => array('content_default_category' => $substep_id)));

                                        $arrfirstStepdata = $substeps['Categories'];
                                        $incompleteorder = $job_search_order;
                                        $arrfirstStepcontent = $arrStepContentData[0];
                                    }
                                }
                            }
                        }
                        
			//print("<pre>");
			//print_r($arrJobSearchProcessPhases);
			
			
			/*$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'steps','content_category_parent_id'=>$arrJobSearchProcessPhases[0]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));*/
			/*if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
			{
				$intFrCnt = 0;
				$this->loadModel('Jobsearchtracker');
				foreach($arrJobPhaseSteps as $arrJsteps)
				{
					$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['category_id'])));
					if($isStepCompleted)
					{
						$arrJobPhaseSteps[$intFrCnt]['Categories']['iscompleted'] = "1";
					}
					else
					{
						$arrJobPhaseSteps[$intFrCnt]['Categories']['iscompleted'] = "0";
					}
					$intFrCnt++;
				}
			}*/
			//$arrJobSearchProcessPhases[0]['CategoriesPhaseStep'] = $arrJobPhaseSteps;			
			$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessPhases);
                        $this->set('phaseIncompleteid', $phaseIncompleteid);
                        $this->set('arrfirstStepdata', $arrfirstStepdata);
		}
	}
	
	public function substep($intPortalId = "",$intSbStepId = "",$intStepId = "",$intPhaseId = "",$intBackStepId = "")
	{
		//Configure::write('debug', 2);
		$arrLoggedUser = $this->Auth->user();
		//$this->layout = false;
		//$this->autoRender = false;
		$intUserType = "3";
		$view = new View($this, false);
		$view->set("intSbStepId",$intSbStepId);
		$view->set("intStepId",$intStepId);
		$view->set("intPhaseId",$intPhaseId);
		$view->set("intBackStepId",$intBackStepId);
		//$arrParentDetails = array();
		$this->loadModel('Jobsearchtracker');
		$this->loadModel('Categories');
		$this->loadModel('substepProducts');
		
		$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intSbStepId,'content_cat_for_user'=>$intUserType)));
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
		
		
		$arrParentDetails = array();		
		
		$this->fnGetParentDetail($intSbStepId,$arrParentDetails);		//PRINT("<pre>");		//print_r($arrParentDetails);		//exit;				$arrCriteria = array();		$arrCurrentLocation = array();		if(is_array($arrParentDetails) && (count($arrParentDetails)>0))		{		 foreach($arrParentDetails as $arrParent)		 {		  $arrCurrentLocation['currentposition'][$arrParent['parent_id_type']] = $arrParent['parent_id'];		  $arrCriteria[] = $arrParent['parent_id_type']."-".$arrParent['parent_id']."_".$arrParent['parent_id_childs'];		 }		 $arrCurrentLocation['currentposition']['substep'] = $intFurtherElementParent;		// print("<pre>");		 //print_r($arrCriteria);		 //echo implode("|",$arrCriteria);				 $this->set('arrCurrentLocation',$arrCurrentLocation);		 $this->set('strCriteria',implode("|",$arrCriteria));		}
		
		$arrBackParentDetail = array();
		$strBackUrl = "";
		if($intBackStepId)
		{
			$this->fnGetParentDetail($intBackStepId,$arrBackParentDetail);
			if(is_array($arrBackParentDetail) && (count($arrBackParentDetail)>0))
			{
				foreach($arrBackParentDetail as $arrBack)
				{
					$strBackUrl .= $arrBack['parent_id']."/";
				}
				$strCompleteBackUrl = Router::url('/',true)."jsprocess/substep/".$intPortalId."/".$intBackStepId."/".$strBackUrl;
				$view->set('strCompleteBackUrl',$strCompleteBackUrl);
			}
		}
		//$arrsubstepproducts = $this->substepProducts->find('all',array('conditions'=>array('content_category_id'=>$intSbStepId)));
		$arrsubstepproducts = $this->substepProducts->find('all',array( 
							'fields' => array('products.*','substepProducts.*'),
							'joins' => array(
							array(
							'table' => 'vendor_service',
							'alias' => 'vendor_service',
							'type' => 'inner',
							'recursive' => -1,
							'conditions'=> array('substepProducts.vendor_service_id = vendor_service.vendor_service_id')
							),
							array(
							'table' => 'products',
							'alias' => 'products',
							'type' => 'inner',
							'recursive' => -1,
							'conditions'=> array('products.productd_id = vendor_service.service_id')
							)), 'conditions' =>  array('substepProducts.content_category_id' => $intSbStepId)));
							
							
		/*print("<pre>");
		print_r($arrsubstepproducts);
		exit();*/
		//print($intFurtherElementParent);
		
		$arrCriteria = array();
		$arrCurrentLocation = array();
		if(is_array($arrParentDetails) && (count($arrParentDetails)>0))
		{
			foreach($arrParentDetails as $arrParent)
			{
				$arrCurrentLocation['currentposition'][$arrParent['parent_id_type']] = $arrParent['parent_id'];
				$arrCriteria[] = $arrParent['parent_id_type']."-".$arrParent['parent_id']."_".$arrParent['parent_id_childs'];
			}
			$arrCurrentLocation['currentposition']['substep'] = $intSbStepId;
			//print("<pre>");
			//print_r($arrCriteria);
			//echo implode("|",$arrCriteria);
			$view->set('arrCurrentLocation',$arrCurrentLocation);
			$view->set('strCriteria',implode("|",$arrCriteria));
		}
		
		$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$intSbStepId)));
		$strActionButtonText = "Complete this step";
		$view->set('strCompleteId',"complete_substeps_".$intSbStepId."_".$intPortalId);
		if($isStepCompleted)
		{
			$view->set('strCompleteId',"incomplete_substeps_".$intSbStepId."_".$intPortalId);
			$strActionButtonText = "Reset this step";
		}
		//echo "--".$strActionButtonText;
		$view->set('strActionButtonText',$strActionButtonText);
		$view->set('strCompletionevent',"onclick='fnCompleteThis(this)'");
		//print("<pre>");
		//print_r($arrCurrentLocation);
		//print($arrCriteria);
		//exit;
		
		$this->loadModel('Content');
		$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'Substeps','content_category_parent_id'=>$intStepId),'order'=>array('job_search_order'=>'ASC')));
		//print("<pre>");
		//print_r($arrJobSearchProcessPhases);
		//exit;
		//print("<pre>");
		//print_r($arrParentDetails);
		//print($intSbStepId);
		//exit;
		
		if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
		{
			
			
			$intFrCnt = 0;
			foreach($arrJobSearchProcessPhases as $arrJobSearchPhase)
			{
				
				$arrCatContentData = $this->Content->find('all',array('fields'=>array('content_id','content'),'conditions'=>array('content_default_category'=>$arrJobSearchPhase['Categories']['content_category_id'])));
			
				
				if(is_array($arrCatContentData) && (count($arrCatContentData)>0))
				{
					//echo "--".$arrCatContentData[0]['Content']['content'];
					$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
				}
				
				//echo "--".$arrJobSearchPhase['Categories']['content_category_id'];
				$arrStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrJobSearchPhase['Categories']['content_category_id'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
				if($arrStepCompleted)
				{
					$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completed'] = "1";
					$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completion_class'] = "stepcomplete";
				}
				
				$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'steps','content_category_parent_id'=>$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));
				if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
				{
					$intFrNewCnt = 0;
					$this->loadModel('Jobsearchtracker');
					foreach($arrJobPhaseSteps as $arrJsteps)
					{
						$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['content_category_id'])));
						if($isStepCompleted)
						{
							$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "1";
						}
						else
						{
							$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "0";
						}
						$intFrNewCnt++;
					}
					$arrJobSearchProcessPhases[$intFrCnt]['Categories']['Steps'] = $arrJobPhaseSteps;
				}
				$intFrCnt++;
			}
		}
		
		$view->set('arrJobSearchProcessPhases',$arrJobSearchProcessPhases);
		
		
		
		$this->loadModel('Contenttype');
		$arrContentType = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
		$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intSbStepId),"ORDER"=>array('content_id'=>"ASC")));
		//print("<pre>");
		//print_r($arrContentType);
		//exit;
		if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
		{
			$arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));
			
			$arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;
			
			$arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intSbStepId),"ORDER"=>array('content_id'=>"ASC")));
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
		
		$arrContentTypeList = $this->Content->fnGetDistinctContentType($intSbStepId,$intUserType);
		//print("<pre>");
		//print_r($arrContentTypeList);
		//exit;
		$view->set('arrContentTypeList',$arrContentTypeList);
		$view->set('arrContentType',$arrContentType);
		//$arrContentListArticle = $this->Content->fnGetContentList($intSbStepId,$arrContentTypeList[0]['content']['content_type']);
		$arrContentListArticle = $this->Content->fnGetContentList($intSbStepId);
		//print("<pre>");
		//print_r($arrContentListArticle);
		//exit;
			//$arrContentListWebinars = $this->Content->fnGetContentList($intSbStepId,2);
			/*print("<pre>");
			print_r($arrContentListWebinars);
			exit;*/
			
		$view->set('arrContentListWebinars', $arrContentListWebinars);
		$view->set('arrContentListArticle',$arrContentListArticle);
		$view->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
		$view->set('intCatDetailId',$intSbStepId);
		$view->set('arrsubstepproducts',$arrsubstepproducts);
		$this->set('arrsubstepproducts',$arrsubstepproducts);
		$strWidgetListerHtml = $view->element('substep');
			//echo $strWidgetListerHtml;die;
			if($strWidgetListerHtml)
			{
				$arrResponse['status'] = 'success';
				$arrResponse['substepshtml'] = $strWidgetListerHtml;
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = "There's some problem, needs to be sorted out, please give it a try once more and check.";
			}
			echo json_encode($arrResponse);
						exit;
			
	}
	
	public function phase($intPortalId = "",$intPhaseId = "")
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
			$this->set('intPhaseId',$intPhaseId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
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
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
					}
					
					//echo "--".$arrJobSearchPhase['Categories']['content_category_id'];
					$arrStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrJobSearchPhase['Categories']['content_category_id'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
					if($arrStepCompleted)
					{
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completed'] = "1";
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completion_class'] = "stepcomplete";
					}
					
					$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'steps','content_category_parent_id'=>$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));
					if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
					{
						$intFrNewCnt = 0;
						$this->loadModel('Jobsearchtracker');
						foreach($arrJobPhaseSteps as $arrJsteps)
						{
							$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['content_category_id'])));
							if($isStepCompleted)
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "1";
							}
							else
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "0";
							}
							$intFrNewCnt++;
						}
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['Steps'] = $arrJobPhaseSteps;
					}
					$intFrCnt++;
				}
			}
			//print("<pre>");
			//print_r($arrJobSearchProcessPhases);
			//exit;
			$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessPhases);
		}
	}
	
	public function step($intPortalId = "",$intStepId = "",$intPhaseId = "")
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
			$this->set('intStepId',$intStepId);
			$this->set('intPhaseId',$intPhaseId);
			
			$this->loadModel('PortalPages');	
			$arrPortalContactUsPageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'],'career_portal_page_tittle'=> 'Contact Us')
								));
			$intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
			$this->set('intContactUsPageId',$intContactUsPageDetail);
			
			$this->loadModel('Categories');
			$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'Steps','content_category_parent_id'=>$intPhaseId),'order'=>array('job_search_order'=>'ASC')));
			
			//print("<pre>");
			//print_r($arrJobSearchProcessSteps);
			//exit;
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
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
					}
					
					//echo "--".$arrJobSearchPhase['Categories']['content_category_id'];
					$arrStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('step_id'=>$arrJobSearchPhase['Categories']['content_category_id'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
					if($arrStepCompleted)
					{
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completed'] = "1";
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['step_completion_class'] = "stepcomplete";
					}
					
					$arrJobPhaseSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'substeps','content_category_parent_id'=>$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content_category_id']),'order'=>array('job_search_order'=>'ASC')));
					if(is_array($arrJobPhaseSteps) && (count($arrJobPhaseSteps)>0))
					{
						$intFrNewCnt = 0;
						$this->loadModel('Jobsearchtracker');
						foreach($arrJobPhaseSteps as $arrJsteps)
						{
							$isStepCompleted = $this->Jobsearchtracker->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],"step_id"=>$arrJsteps['Categories']['content_category_id'])));
							if($isStepCompleted)
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "1";
							}
							else
							{
								$arrJobPhaseSteps[$intFrNewCnt]['Categories']['iscompleted'] = "0";
							}
							$intFrNewCnt++;
						}
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['Substeps'] = $arrJobPhaseSteps;
					}
					$intFrCnt++;
				}
			}
			//print("<pre>");
			//print_r($arrJobSearchProcessPhases);
			//exit;
			$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessPhases);
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
}
