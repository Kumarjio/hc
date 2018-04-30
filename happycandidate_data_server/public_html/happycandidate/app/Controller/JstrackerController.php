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
class JstrackerController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jstracker';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('registration','reset','jobsearch','forgotpassword','jobdetail');
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
	
	public function index($intPortalId = "")
	{
		//echo $this->layout;
		//exit;
		if($intPortalId)
		{
			$strJobberlandProfileUrl = Configure::read('Jobber.seekerprofileurl')."?portid=".$intPortalId;
			
			$this->set('strSeekerProfileUrl',$strJobberlandProfileUrl);
			
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
			
			$this->loadModel('Categories');
			$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'phase'),'order'=>array('job_search_order'=>'ASC')));
			
			if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
			{
				$this->loadModel('Content');
				$this->loadModel('Jobsearchtracker');
				$intFrCnt = 0;
				foreach($arrJobSearchProcessPhases as $arrJobSearchPhase)
				{
					/*$arrCatContentData = $this->Content->find('all',array('fields'=>array('content_id','content'),'conditions'=>array('content_default_category'=>$arrJobSearchPhase['Categories']['content_category_id'])));
					//print("<pre>");
					//print_r($arrCatContentData);
					
					if(is_array($arrCatContentData) && (count($arrCatContentData)>0))
					{
						//echo "--".$arrCatContentData[0]['Content']['content'];
						$arrJobSearchProcessPhases[$intFrCnt]['Categories']['content'] = $arrCatContentData[0]['Content']['content'];
					}*/
					
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
