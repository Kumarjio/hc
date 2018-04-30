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
class CandidatesController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Candidates';

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
		$this->Auth->allow('index','confirmation','getresumeView');
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
		//Configure::write('debug','2');
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
				
				$arrSearchCriteria = array();
				$category = $this->request->data['category'];
				
				if(isset($_POST['webinar_name']))
				{
					$arrSearchCriteria['webinar_name'] = $_POST['webinar_name'];
				}
				if(isset($this->request->data['category']))
				{
					$arrSearchCriteria['category'] = $this->request->data['category'];
				}
			
				$this->loadModel('Content');
				$arrWebinarDetails = $this->Content->fnGetSearchWebinarContentList($arrPortalDetail['0']['Portal']['career_portal_id'],$arrSearchCriteria);
				
				if(is_array($arrWebinarDetails) && (count($arrWebinarDetails)>0))
				{
					
					// code to get the html content
					$view = new View($this, false);
					$view->set('arrWebinarsDetails', $arrWebinarDetails);
					$view->viewPath = 'Elements';
					 
					/* Grab output into variable without the view actually outputting! */
					$strMatchedCourses = $view->render('webinarmaterialnew');
					
					$arrResonse['status'] = 'success';
					$arrResonse['message'] = '';
					$arrResonse['htmldata'] = $strMatchedCourses;
				}
				else
				{
					$arrResonse['status'] = 'success';
					$arrResonse['message'] = 'The No Such Matched Records';
					$arrResonse['htmldata'] = '';
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
		//echo "---".$this->layout;exit;
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
			
			$this->loadModel('Categories');
			$arrLibCatDetail = $this->Categories->find('all',array('order'=>array('Categories.job_search_order'=>'asc'),'conditions'=>array('content_cat_for_user'=>'3','job_search_category'=>'0')));
			if(is_array($arrLibCatDetail) && (count($arrLibCatDetail)>0))
			{
				$intFrCnt = 0;
				foreach($arrLibCatDetail as $arrProductDetail)
				{
					$intMediaId = $arrProductDetail['Categories']['content_cat_icon'];
					
					if($intMediaId)
					{
						$this->loadModel('ContentMedia');
						$arrContentMedia = $this->ContentMedia->find('all',array('conditions'=>array('content_media_id'=>$intMediaId)));
						$arrLibCatDetail[$intFrCnt]['content_media']['content_media_title'] = $arrContentMedia[0]['ContentMedia']['content_media_title'];
					}
					$intFrCnt++;
				}
			}
			
			$this->set('arrLibCatDetail',$arrLibCatDetail);
		}
		
	}
	
	public function libcatdetail($intPortalId = "",$intCatDetailId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Contenttype');
			$arrContentType = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
			$intUserType = "3";
			$intContentType = "1";
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('intCatDetailId',$intCatDetailId);
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			
			$this->loadModel('Categories');
			$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intCatDetailId,'content_cat_for_user'=>$intUserType)));
			//print("<pre>");
			//print_r($arrCatDetail);
			$this->set('arrCatDetail',$arrCatDetail);

			$this->loadModel('Content');
			$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
			if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
			{
				$arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));
				
				$arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;
				
				$arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
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
			
				$this->set('arrCatContentTitles',$arrCatContentTitles);			
				$this->set('arrCatContent',$arrCatContent);
			}
			
			
			$arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
			$this->set('arrContentTypeList',$arrContentTypeList);
			$this->set('arrContentType',$arrContentType);
			$arrContentListArticle = $this->Content->fnGetContentList($intCatDetailId,$arrContentTypeList[0]['content']['content_type']);
			$this->set('arrContentListArticle',$arrContentListArticle);
			$this->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
		}
		
	}
	
	public function getcontent($intPortalId = "",$intContentId = "")
	{
		
		$this->layout = NULL;
		$this->autoResponder = false;
		$arrResponse = array();
		
		if($intContentId)
		{
			$this->loadModel('Content');
			$arrContent = $this->Content->find('list',array('fields'=>array('content_type','content'),'conditions'=>array('content_id'=>$intContentId)));
			if(is_array($arrContent) && (count($arrContent)>0))
			{
				$arrResponse['status'] = "success";
				$arrResponse['title'] = key($arrContent);
				$arrResponse['content'] = htmlspecialchars_decode(stripslashes($arrContent[key($arrContent)]));
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "No Such Content present, Please try again";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Parameter missing, Please try again.";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function libcatwebdetail($intPortalId = "",$intCatDetailId = "",$strContentType = "article",$intOnNewTab = "0")
	{
		$this->loadModel('Contenttype');
		$arrContent = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
		
		$intUserType = "3";
		$intContentType = "1";
		$intContentType = array_search($strContentType,$arrContent);
		$view = new View($this, false);
		if($intPortalId)
		{
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$view->set('arrPortalDetail',$arrPortalDetail);
			$view->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$view->set('intPortalId',$intPortalId);
			
			$this->loadModel('TopMenu');
			$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
			/* print("<pre>");
			print_r($arrMenuDetail); */
			$view->set('arrPortalMenuDetail',$arrMenuDetail);
			
			$this->loadModel('Categories');
			$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intCatDetailId,'content_cat_for_user'=>$intUserType)));
			//print("<pre>");
			//print_r($arrCatDetail);
			$view->set('arrCatDetail',$arrCatDetail);
			
			$this->loadModel('Content');
			$arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
			$view->set('arrContentTypeList',$arrContentTypeList);
			$view->set('arrContentType',$arrContentType);
			$arrContentListWebinars = $this->Content->fnGetContentList($intCatDetailId,$intContentType);
			/*print("<pre>");
			print_r($arrContentListWebinars);
			exit;*/
			
			$view->set('arrContentListArticle', $arrContentListWebinars);
			$view->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
			$view->set('strTypeBlock',$arrContent[$intContentType]);
			if($intOnNewTab)
			{
				$view->set('intContentonNewtab',"1");
			}
			//$strSubCatHtml = $view->element('article_list');
			$strSubCatHtml = $view->element('article_list_new');
			if($strSubCatHtml)
			{
				$arrResponse['status'] = "success";
				$arrResponse['content'] = $strSubCatHtml;
				$arrResponse['contenthtmlid'] = $intContentType."_".$intCatDetailId;
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Missing parameter";
				echo json_encode($arrResponse);
				exit;
			}
		}
		
	}
	
	public function getarticledata($intPortalId = "",$intArticleId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		
		
		if($intPortalId && $intArticleId)
		{
			$this->loadModel('WorksheetContent');
			$arrWorkSheetData = $this->WorksheetContent->find('all',array('conditions'=>array('seeker_id'=>$arrLoggedUser['candidate_id'],'content_id'=>$intArticleId)));
			//print("<pre>");
			//print_r($arrWorkSheetData);
			//exit;
			if(is_array($arrWorkSheetData) && (count($arrWorkSheetData)>0))
			{
				
				
				if($arrWorkSheetData[0]['WorksheetContent']['content'])
				{
					//echo "----".$arrWorkSheetContent = json_decode($arrWorkSheetData[0]['WorksheetContent']['content']);
					$arrResponse['content'] = stripslashes($arrWorkSheetData[0]['WorksheetContent']['content']);
					$arrResponse['contentid'] = $arrWorkSheetData[0]['WorksheetContent']['content_ele_id'];
					$arrResponse['status'] = "success";
					
					//echo "----".$arrWorkSheetContent = json_decode($arrWorkSheetData[0]['WorksheetContent']['content']);
				}
				else
				{
					$arrResponse['status'] = 'fail';
				}
			}
			else
			{
				$arrResponse['status'] = 'fail';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Missing Parameters';
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function savearticle($intPortalId = "",$intArticleId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		/*$arrCompleteHtml = explode("~",$this->request->data['strcont']);
		$arrCompleteHtmlId = explode("~",$this->request->data['strcontid']);
		$intFrcnt = 0;
		$arrStoreHtml = array();
		foreach($arrCompleteHtmlId as $strEleId)
		{
			//echo "<br>---".$strEleId;
			//echo "---".$arrCompleteHtml[$intFrcnt];
			$arrStoreHtml[$intFrcnt]['eleid'] = $strEleId;
			$arrStoreHtml[$intFrcnt]['elecontent'] = addslashes($arrCompleteHtml[$intFrcnt]);
			$intFrcnt++;
		}*/
		//foreach($arrCompleteHtml as )
		$arrWorksheeData['WorksheetContent']['content'] = $strContToSave = addslashes($this->request->data['strcont']);
		$arrWorksheeData['WorksheetContent']['content_ele_id'] = $strContToSaveId = $this->request->data['strcontid'];
		$arrWorksheeData['WorksheetContent']['seeker_id'] = $arrLoggedUser['candidate_id'];
		$arrWorksheeData['WorksheetContent']['content_id'] = $intArticleId;
		if($intPortalId && $intArticleId)
		{
			$this->loadModel('WorksheetContent');
			$intContExists = $this->WorksheetContent->find('count',array('conditions'=>array('seeker_id'=>$arrLoggedUser['candidate_id'],'content_id'=>$intArticleId)));
			if($intContExists)
			{
				$boolUpdated = $this->WorksheetContent->updateAll(array('content'=>"'".$strContToSave."'",'content_ele_id'=>"'".$strContToSaveId."'"),array("seeker_id"=>$arrLoggedUser['candidate_id'],'content_id'=>$intArticleId));
			}
			else
			{
				
				$boolUpdated = $this->WorksheetContent->save($arrWorksheeData);
			}
			
			if($boolUpdated)
			{
				$arrResponse['status'] = "success";
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try again, Some issue occured";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing Parameters";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getworksheet($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$strWorksheetFolder = 'seekerworksheet';
		$strWorksheetName = $this->request->data['sheetname'].'.pdf';
		if($intPortalId)
		{
			$strCompleteStorageLocation = $strWorksheetFolder."/".$strWorksheetName;
			$html = $this->request->data['htm'];
			App::import('Vendor', 'mpdf/mpdf');
			$mpdf=new mPDF();
			$mpdf->SetDisplayMode('fullpage');
			$strStyleSheetUrl = Router::url('/',true)."css/hometheme/worksheet.css";
			$stylesheet = file_get_contents($strStyleSheetUrl);
			$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html);
			$strFileCreated = $mpdf->Output($strCompleteStorageLocation,'F');
			if($strFileCreated)
			{
				$arrResponse['status'] = "success";
				$arrResponse['filename'] = $strWorksheetName;
			}
			else
			{
				$arrResponse['status'] = "fail";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function articledetail($intPortalId = "",$intArticleId = "")
	{
		//$this->layout = "defaultnewtheme";
		//echo $this->layout;
		$arrLoggedUser = $this->Auth->user();
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
			// load portal theme and its details
			$this->loadModel('PortalTheme');
			$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPortalId);
			if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
			{
				$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
			}
			$this->set('arrPortalMenuDetail',$arrMenuDetail);
			if($intArticleId)
			{
				$this->loadModel('Content');
				$arrContentDetail = $this->Content->find('all',array('conditions'=>array('content_id'=>$intArticleId,'content_status'=>'published')));
				/*if(is_array($arrContentDetail) && (count($arrContentDetail)>0))
				{
					$isContentWorksheet = $this->Content->find('count',array('conditions'=>array('content_id'=>$intArticleId,'content_type'=>'6')));
					if($isContentWorksheet)
					{
						$this->loadModel('WorksheetContent');
						$arrSeekerWorksheetContent = $this->WorksheetContent->find('all',array('conditions'=>array('seeker_id'=>$arrLoggedUser['candidate_id'],'content_id'=>$intArticleId)));
						if(is_array($arrSeekerWorksheetContent) && (count($arrSeekerWorksheetContent)>0))
						{
							$arrContentDetail[0]['Content']['content'] = $arrSeekerWorksheetContent[0]['WorksheetContent']['content'];
						}
					}
				}*/
				
				$this->set('arrContentDetail',$arrContentDetail);
				
				$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>$intArticleId),"ORDER"=>array('content_id'=>"ASC")));
				//print("<pre>");
				//print_r($arrCatContentTitles);
				
				$this->set('arrCatContentTitles',$arrCatContentTitles);	
			}
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
	
	public function upcomingwebinars($intPortalId = "",$intCatDetailId = "")
	{
		$this->layout = "webinardefault";
		if($intPortalId)
		{
			$this->loadModel('Contenttype');
			$arrContentType = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
			$intUserType = "3";
			$intContentType = "2";
			$strDate = date('Y-m-d');
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('intCatDetailId',$intCatDetailId);
		
			
			$this->loadModel('Categories');
			$arrCatDetail = $this->Categories->find('list',array('fields' => array('content_category_id', 'content_category_name'),'conditions'=>array('content_cat_for_user'=>'3','job_search_category'=>'0')));
			/*print("<pre>");
			print_r($arrCatDetail);
			exit();*/
			$this->set('arrCatDetail',$arrCatDetail);
			$arrConditions = array();
			$this->loadModel('Content');
			if($intCatDetailId)
			{
				$arrConditions['content_default_category'] = "'".$intCatDetailId."'";
				
			}
			$arrConditions['Content.content_published_date >='] = $strDate;
			//$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
			
			//print("<pre>");
			//print_r($arrConditions);
			//exit;
			$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>$arrConditions,"ORDER"=>array('content_id'=>"ASC")));
			if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
			{
				$arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));
				
				$arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;
				
				$arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
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
				
				$arrContentListArticle = $this->Content->fnGetWebinarContentListUpcoming("0","2");
			
				$this->set('arrWebinarsDetails',$arrContentListArticle);
			
				//$this->set('arrWebinarsDetails',$arrCatContentTitles);			
				$this->set('arrCatContent',$arrCatContent);
			}
			
		}
		
	}
	
	public function webinars($intPortalId = "",$intCatDetailId = "")
	{
		//echo $this->layout;
		if($intPortalId)
		{
			$this->loadModel('Contenttype');
			$arrContentType = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
			$intUserType = "3";
			$intContentType = "2";
			$strDate = date('Y-m-d');
			$arrShopDetails = array();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('intCatDetailId',$intCatDetailId);
		
			
			$this->loadModel('Categories');
			$arrCatDetail = $this->Categories->find('list',array('fields' => array('content_category_id', 'content_category_name'),'conditions'=>array('content_cat_for_user'=>'3','job_search_category'=>'0')));
			/*print("<pre>");
			print_r($arrCatDetail);
			exit();*/
			$this->set('arrCatDetail',$arrCatDetail);
			$arrConditions = array();
			$this->loadModel('Content');
			if($intCatDetailId)
			{
				$arrConditions['content_default_category'] = "'".$intCatDetailId."'";
				
			}
			$arrConditions['Content.content_published_date >='] = $strDate;
			//$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
			
			//print("<pre>");
			//print_r($arrConditions);
			//exit;
			$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>$arrConditions,"ORDER"=>array('content_id'=>"ASC")));
			if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
			{
				$arrCatContentTitlesSub = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>key($arrCatContentTitles)),"ORDER"=>array('content_id'=>"ASC")));
				
				$arrCatContentTitles = $arrCatContentTitles + $arrCatContentTitlesSub;
				
				$arrCatContent = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content'),'conditions'=>array('content_default_category'=>$intCatDetailId),"ORDER"=>array('content_id'=>"ASC")));
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
			
				$this->set('arrWebinarsDetails',$arrCatContentTitles);			
				$this->set('arrCatContent',$arrCatContent);
			}
			//echo "--".$intCatDetailId;
			
			$arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
			$this->set('arrContentTypeList',$arrContentTypeList);
			$this->set('arrContentType',$arrContentType);
			$arrContentListArticle = $this->Content->fnGetWebinarContentList($intCatDetailId,$arrContentTypeList[0]['content']['content_type']);
			
			$this->set('arrWebinarsDetails',$arrContentListArticle);
			$this->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
		}
		
	}
	
	
	public function webinardetail($intPortalId = "",$intArticleId = "")
	{
		//$this->layout = "defaultnewtheme";
		//echo "---".$this->layout;
		$arrLoggedUser = $this->Auth->user();
		$strDate = date('Y-m-d');
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
			
			if($intArticleId)
			{
				$this->loadModel('Content');
				$arrContentDetail = $this->Content->find('all',array('conditions'=>array('content_id'=>$intArticleId,'content_status'=>'published')));
				
				$this->set('arrContentDetail',$arrContentDetail);
				
			}
			else
			{
				$this->loadModel('Content');
				$arrContentDetail = $this->Content->find('all',array('conditions'=>array('content_status'=>'published','content_published_date >='=>$strDate),'limit'=>'1'));
				//print("<pre>");
				//print_r($arrContentDetail);
				//exit;
				$this->set('strOtherWebinar',"1");
				$this->set('arrContentDetail',$arrContentDetail);
			}
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
	
	public function index($intPortalId = "")
	{
	
	}
	
	public function profile($intPortalId = "",$type="")
	{
//		Configure::write('debug','2');
//		echo $this->layout;die;
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
//                        echo '<pre>';print_r($arrLoggedUser);die;
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			$this->set('type',$type);
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			  $this->loadModel('CandidateProfile');
			  //$profileDetail = $this->CandidateProfile->fnGetCandidateData($arrLoggedUser['candidate_id']);
			  $this->loadModel('Candidate');
			  $this->loadModel('JobberlandCounties');
			  
			  $profilePicture =  $this->Candidate->field('candidate_picture', array('candidate_id' => $arrLoggedUser['candidate_id']));
			  $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
				$profileDetail = $this->CandidateProfile->find('first', array('conditions'=>array('hc_uid'=>$arrLoggedUser['candidate_id'])));				
			//$strJbToken = $this->Session->read('Auth.FrontendUser_'.$intPortalId.".jbloggtoken_".$arrLoggedUser['candidate_id']);
			
//			echo '<pre>',print_r($profileDetail);
				$this->loadModel('JobberlandCounties');
			 $countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
				$this->loadModel('JobberlandCounties');	
			
			 $strJobberlandProfileUrl = Configure::read('Jobber.seekerprofileurl')."?portid=".$intPortalId;
			
			
			$this->set('profilePicture',$profilePicture);
			$this->set('countrylist',$countrylist);
			$this->set('profileDetail',$profileDetail);
			$this->set('strSeekerProfileUrl',$strJobberlandProfileUrl);
			
			
		}
	}
	public function updateProfile($intPortalId)
	{
		 $this->loadModel('CandidateProfile');
		 
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$fname = ucfirst($_POST['txt_fname']);
			$sname = ucfirst($_POST['txt_sname']);
			$address = $_POST['txt_address'];
			$address2 = $_POST['txt_address2'];
			$city = $_POST['txtcity'];
			$county = $_POST['txtcounty'];
			$state_province = $_POST['txtstateprovince'];
			$country = $_POST['txt_country'];
			$post_code = strtoupper($_POST['txt_post_code']);
			$phone_number = strtoupper($_POST['txt_phone_number']);
			$job_title = ucfirst($_POST['txt_job_title']);
				
			if(isset($_FILES["profilePicture"]["tmp_name"]))
			{					
					$profilePicture = $_FILES["profilePicture"]["name"];	
					if($profilePicture!="")
					{	
						$oldprofilePicture =  $this->Candidate->field('candidate_picture', array('candidate_id' => $arrLoggedUser['candidate_id']));
							
						$picturepath = "assets/candidateprofile/".$oldprofilePicture;		
						if(file_exists($picturepath))							 
						{		
							unlink($picturepath);	
						}							  							 			
						$uploaddir = "assets/candidateprofile/";					
						$newimageName = rand().$_FILES["profilePicture"]["name"];							
						$newuploaddir = $uploaddir."".$newimageName;						
						move_uploaded_file( $_FILES['profilePicture']['tmp_name'], $newuploaddir);							 						
						$boolimagesaved = $this->Candidate->updateAll(array('candidate_picture' => "'$newimageName'"),array('candidate_id' => $arrLoggedUser['candidate_id']));	
									
					}
			}		
		
			$boolUpdated = $this->CandidateProfile->updateAll(array('fname' =>"'$fname'",'sname' => "'$sname'",'address'  => "'$address'",'address2'  => "'$address2'",'city'  => "'$city'",'county'  => "'$county'",'state_province'  => "'$state_province'",'country'=> "'$country'",'post_code'=> "'$post_code'",'phone_number'=>"'$phone_number'",'job_title'=>"'$job_title'"),array('id' => $arrLoggedUser['candidate_id']));	
			if($boolUpdated)
			{
				$response = array('status'=>1,'message'=>'<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Profile updated successfully.
						</div>');
			}
			else{
				$response = array('status'=>0,'message'=>'<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Error occured.
						</div>');
			}
			echo json_encode($response);
					exit();
		}
	}
	
	public function fnAddMyCv($intPortalId)
	{
		
		if($intPortalId)
		{
			 $this->loadModel('CandidateCvDetail');
			$arrLoggedUser = $this->Auth->user();
			
			
			if(isset($_POST))
			{
			
				$txt_title = $_POST['txt_title'];
				$txt_desc = $_POST['txt_desc'];
				if(isset($_FILES['txt_file_cv']))
				{
					$allowed_files = array('doc','docx','pdf','rtf','txt');
				}
				  $file = $_FILES['txt_file_cv'];
				
			
				if(!$file || empty($file)) 
				{
				  $errors[] = 'File not available';
					$RespArray['status'] = "fail";
					$RespArray['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  File not available.
						</div>';

				}
				else if($file['error'] != 0) 
				{

					$errors[] = "File upload error occured";
					$RespArray['status'] = "fail";
					$RespArray['message'] = " File upload error occured";

				} 
				else 
				{
				
					
					$ext = explode(".", basename($file['name']) );
					
					 $ext = strtolower($ext[1]);
					

					if( !in_array($ext, $allowed_files) )
					{
						$RespArray['status'] = "fail";
						$RespArray['message'] = " File ".basename($file['name'])." is not allowed";
						$errors[] = " File ".basename($file['name'])." is not allowed";
						
					}
					else
					{
								/*$oldcv =  $this->CandidateCvDetail->field('cv_file_name', array('fk_employee_id' => $arrLoggedUser['candidate_id']));
								if($oldcv!="")
								{
									$cvpath = "assets/candidatecv/".$oldcv;
										if(file_exists($cvpath))
										{
											unlink($cvpath);
										}
								}*/
								$this->request->data['CandidateCvDetail']['cv_title']	= $_POST['txt_title'];
								
								$this->request->data['CandidateCvDetail']['cv_description']	= $_POST['txt_desc'];
								
								$this->request->data['CandidateCvDetail']['tmp_name']	= $file['tmp_name'];
								
								$this->request->data['CandidateCvDetail']['fk_employee_id']	= $arrLoggedUser['candidate_id'];
								
								$this->request->data['CandidateCvDetail']['cv_file_name'] 	= $arrLoggedUser['candidate_id']."_".time().".".$ext;

								$this->request->data['CandidateCvDetail']['original_name']	= basename($file['name']);

								$this->request->data['CandidateCvDetail']['cv_file_exe']   	= $ext;

								$this->request->data['CandidateCvDetail']['cv_file_type'] 	= $file['type'];

								$this->request->data['CandidateCvDetail']['cv_file_size'] 	= $file['size'];
								
								
									
								
								$target_path="";
						if( sizeof($errors) == 0 ) 
						{
							
							if( !empty( $file['tmp_name']) && !empty($this->request->data['CandidateCvDetail']['cv_file_name']) )
								{

								$target_path=  "assets/candidatecv/".$this->request->data['CandidateCvDetail']['cv_file_name'];

								// Attempt to move the file 

									if(!move_uploaded_file( $file['tmp_name'], $target_path))
									{

										$errors[] = "File upload error occured";

										//$this->id = $db->insert_id();

										//$this->delete();

										$RespArray['status'] = "fail";
										$RespArray['message'] = "File upload error occured";

									}
									else
									{
										$created_at 	= date("Y-m-d H:i:s",time() );
										$this->request->data['CandidateCvDetail']['created_at']= $created_at; 
										//$this->modified_at 	= date("Y-m-d H:i:s",time() );

										//$this->request->data['CandidateCvDetail']['cv_file_path']	= $target_path;

										$this->request->data['CandidateCvDetail']['cv_status'] 	= "private";
										$this->request->data['CandidateCvDetail']['cv_file_path'] 	= $target_path;
										$boolUserprocessSaved = $this->CandidateCvDetail->save($this->request->data);
										$getInsertid_UsersID = $this->CandidateCvDetail->getLastInsertID();
										if($getInsertid_UsersID>0)
										{
											$RespArray['status'] = "success";
											$RespArray['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  File uploaded successfully.
						</div>';
										}
										else
										{
											$RespArray['status'] = "fail";
											$RespArray['message'] = " File upload error occured";
										}
									}

								}

						}

					}

	

				}
				echo json_encode($RespArray);
						exit;
			}
		}
		
	}
	
	
	public function getCongocvform($intPortalId)
	{
		
	$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$view->set('intPortalId',$intPortalId);
		//$view->set('arrAppointmentNotes',$arrContacts);
		$arrCovervDetail=array();
	
		
		$strWidgetListerHtml = $view->element('congocv');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
		
	}
	
	
	public function fnAddMyCoverLetter($intPortalId)
	{
		if($intPortalId)
		{
			 $this->loadModel('CandidateCoverDetail');
			$arrLoggedUser = $this->Auth->user();
			
			
			if(isset($_POST))
			{
				
			
				$txt_name = $_POST['txt_name'];
				$txt_letter = $_POST['txt_letter'];
				$coverid = $_POST['coverid'];
				
				//print("<pre>");
				//print_r($_POST);
				//exit;
				
				$this->request->data['CandidateCoverDetail']['cover_title'] = addslashes(trim($this->request->data['txt_letter_title']));
				
				$this->request->data['CandidateCoverDetail']['name'] = addslashes(trim($this->request->data['txt_your_name']));
				
				$this->request->data['CandidateCoverDetail']['address'] = addslashes(trim($this->request->data['txt_your_address']));
				$this->request->data['CandidateCoverDetail']['zipcode'] = addslashes(trim($this->request->data['txt_your_post_code']));
				$this->request->data['CandidateCoverDetail']['country'] = addslashes(trim($this->request->data['txt_your_country_ref']));
				$this->request->data['CandidateCoverDetail']['state'] = addslashes(trim($this->request->data['txtyourstateprovinceref']));
				$this->request->data['CandidateCoverDetail']['county'] = addslashes(trim($this->request->data['txtyourcountyref']));
				$this->request->data['CandidateCoverDetail']['city'] = addslashes(trim($this->request->data['yourlocalityvalref']));
				
				$this->request->data['CandidateCoverDetail']['ename'] = addslashes(trim($this->request->data['txt_emp_name']));
				
				$this->request->data['CandidateCoverDetail']['ecomp'] = addslashes(trim($this->request->data['txt_emp_comp']));
				
				$this->request->data['CandidateCoverDetail']['eaddress'] = addslashes(trim($this->request->data['txt_emp_address']));
				$this->request->data['CandidateCoverDetail']['ezipcode'] = addslashes(trim($this->request->data['txt_emp_post_code']));
				$this->request->data['CandidateCoverDetail']['ecountry'] = addslashes(trim($this->request->data['txt_emp_country_ref']));
				$this->request->data['CandidateCoverDetail']['estate'] = addslashes(trim($this->request->data['txtempstateprovinceref']));
				$this->request->data['CandidateCoverDetail']['ecounty'] = addslashes(trim($this->request->data['txtempcountyref']));
				$this->request->data['CandidateCoverDetail']['ecity'] = addslashes(trim($this->request->data['yourlocalityvalref']));
				$this->request->data['CandidateCoverDetail']['cl_title']	= addslashes(trim($this->request->data['emp_salutation']));
				$this->request->data['CandidateCoverDetail']['cl_text']	= addslashes(trim($this->request->data['txt_letter']));
				$this->request->data['CandidateCoverDetail']['fk_employer_id']	= $arrLoggedUser['candidate_id'];
				 
				if($coverid>0)
				{
						$modified_at 	= date("Y-m-d H:i:s",time() );
						$this->request->data['CandidateCoverDetail']['modified_at']= $modified_at;
						$boolupdated = $this->CandidateCoverDetail->updateAll(array('cl_title' => "'".$this->request->data['CandidateCoverDetail']['cl_title']."'",'cl_text'=>"'".$this->request->data['CandidateCoverDetail']['cl_text']."'",'name'=>"'".$this->request->data['CandidateCoverDetail']['name']."'",'address'=>"'".$this->request->data['CandidateCoverDetail']['address']."'",'zipcode'=>"'".$this->request->data['CandidateCoverDetail']['zipcode']."'",'country'=>"'".$this->request->data['CandidateCoverDetail']['country']."'",'state'=>"'".$this->request->data['CandidateCoverDetail']['state']."'",'county'=>"'".$this->request->data['CandidateCoverDetail']['county']."'",'city'=>"'".$this->request->data['CandidateCoverDetail']['city']."'",'ename'=>"'".$this->request->data['CandidateCoverDetail']['ename']."'",'etitle'=>"'".$this->request->data['CandidateCoverDetail']['etitle']."'",'eaddress'=>"'".$this->request->data['CandidateCoverDetail']['eaddress']."'",'ezipcode'=>"'".$this->request->data['CandidateCoverDetail']['ezipcode']."'",'ecountry'=>"'".$this->request->data['CandidateCoverDetail']['ecountry']."'",'estate'=>"'".$this->request->data['CandidateCoverDetail']['estate']."'",'ecounty'=>"'".$this->request->data['CandidateCoverDetail']['ecounty']."'",'ecity'=>"'".$this->request->data['CandidateCoverDetail']['ecity']."'",'ecomp'=>"'".$this->request->data['CandidateCoverDetail']['ecomp']."'",'cover_title'=>"'".$this->request->data['CandidateCoverDetail']['cover_title']."'",'modified_at'=>"'$modified_at'"),array('id' => $coverid));
												
						if($boolupdated)
						{
								$RespArray['status'] = "success";
										$RespArray['message'] = '<div class="alert alert-success">
					  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
					  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
					  Cover Letter updated successfully.
					</div>';
						}
						else
						{
							$RespArray['status'] = "fail";
								$RespArray['message'] = " Error occured. Please try again.";
						}
				}
				else
				{
					$created_at 	= date("Y-m-d H:i:s",time() );
					$this->request->data['CandidateCoverDetail']['created_at']= $created_at;
					$boolUserprocessSaved = $this->CandidateCoverDetail->save($this->request->data);
					$getInsertid_UsersID = $this->CandidateCoverDetail->getLastInsertID();
						if($getInsertid_UsersID>0)
						{
										$RespArray['status'] = "success";
										$RespArray['message'] = '<div class="alert alert-success">
					  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
					  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
					  Cover Letter added successfully.
					</div>';
						}
						else
						{
								$RespArray['status'] = "fail";
								$RespArray['message'] = " Error occured. Please try again.";

						}
				}
				echo json_encode($RespArray);
						exit;
			}
		}
	}
	
	public function getinvoice($intPortalId = "",$intProdId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('JobberlandCounties');
		if($intPortalId)
		{
			if($intProdId)
			{
				
				$this->loadModel('Candidate');
				$this->loadModel('Employee');
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $intPortalId)
								));
								
				//print("<pre>");
				//print_r($arrPortalDetail);
				//exit;
				
				$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				
				$arrCandidateECDetail = $this->Employee->find('all',array('conditions'=>array('hc_uid'=>$arrLoggedUser['candidate_id'])));
				//print("<pre>");
				//print_r($arrCandidateCDetail);
				//exit;
				
				$this->loadModel('Resourceorderdetail');
				$this->loadModel('Resources');
				$this->loadModel('Resourceorder');
				$arrOrderDetail = $this->Resourceorderdetail->find('all',array('conditions'=>array('order_detail_id'=>$intProdId)));
				
				if(is_array($arrOrderDetail)&& (count($arrOrderDetail)>0))
				{
					$intFrCnt = 0;
					foreach($arrOrderDetail as $arrOrdeDet)
					{
						$intOrderId = $arrOrdeDet['Resourceorderdetail']['order_id'];
						$arrOrderNewDetail = $this->Resourceorder->find('all',array('conditions'=>array('resource_order_id'=>$intOrderId)));
						if(is_array($arrOrderNewDetail) && (count($arrOrderNewDetail)>0))
						{
							$arrOrderDetail[$intFrCnt]['mainorder'] = $arrOrderNewDetail;
							$intFrCnt++;
						}
					}
				}
					
				
				
				//print("<pre>");
				//print_r($arrOrderDetail);
				//exit;
				
				$view = new View($this, false);
				$view->set('arrCvDetail',$arrOrderDetail);
				$view->set('arrCandDetail',$arrPortalDetail);
				$view->set('arrCandidateCDetail',$arrCandidateDetail);
				$view->set('arrCandidateECDetail',$arrCandidateECDetail);
				$view->set('strFont',"calibri");
				$view->set('strFontSize',"13");
				
				$html = $view->element('invoicehtml');
				//exit;
				
				$strWorksheetFolder = "candidate_invoice";
				$strWorksheetName = "candidate_invoice_".$intPortalId."_".$intSeekerId."_".$intProdId.".pdf";
				$strCompleteStorageLocation = $strWorksheetFolder."/".$strWorksheetName;
				App::import('Vendor', 'mpdf/mpdf');
				$mpdf=new mPDF();
				$mpdf->SetDisplayMode('fullpage');
				// LOAD a stylesheet
				//$stylesheet = file_get_contents(Router::url('/',true).'css/fontresume.css');
				//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($html);
				$strFileCreated = $mpdf->Output($strCompleteStorageLocation,'F');
				//echo $html;exit;
				if($strFileCreated)
				{
					$arrResponse['status'] = "success";
					$arrResponse['filename'] = $strWorksheetName;
				}
				else
				{
					$arrResponse['status'] = "fail";
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Some thing is missing, Please try again";
			}
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getreferencetemp($intPortalId = "",$intRefId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('JobberlandCounties');
		if($intPortalId)
		{
			if($intRefId)
			{
				
				$this->loadModel('Candidate');
				$this->loadModel('Employee');
				$intSeekerId = $arrLoggedUser['candidate_id'];
				$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
				
				
				$arrCandidateCDetail = $this->Employee->find('all',array('conditions'=>array('hc_uid'=>$arrLoggedUser['candidate_id'])));
				//print("<pre>");
				//print_r($arrCandidateCDetail);
				//exit;
				
				$this->loadModel('CandidateCoverDetail');
				$arrRefDetail = $this->CandidateCoverDetail->find('all',array('conditions'=>array('id'=>$intRefId)));
				
				//print("<pre>");
				//print_r($arrRefDetail);
				//exit;
				
				$view = new View($this, false);
				$view->set('arrCvDetail',$arrRefDetail);
				$view->set('arrCandDetail',$arrCandidateDetail);
				$view->set('arrCandidateCDetail',$arrCandidateCDetail);
				$view->set('strFont',"calibri");
				$view->set('strFontSize',"16");
				
				$html = $view->element('coverletterhtml');
				
				
				$strWorksheetFolder = "candidate_cover_letter";
				$strWorksheetName = "candidate_cover_letter_".$intPortalId."_".$intSeekerId.".pdf";
				$strCompleteStorageLocation = $strWorksheetFolder."/".$strWorksheetName;
				App::import('Vendor', 'mpdf/mpdf');
				$mpdf=new mPDF();
				$mpdf->SetDisplayMode('fullpage');
				// LOAD a stylesheet
				//$stylesheet = file_get_contents(Router::url('/',true).'css/fontresume.css');
				//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($html);
				$strFileCreated = $mpdf->Output($strCompleteStorageLocation,'F');
				//echo $html;exit;
				if($strFileCreated)
				{
					$arrResponse['status'] = "success";
					$arrResponse['filename'] = $strWorksheetName;
				}
				else
				{
					$arrResponse['status'] = "fail";
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Some thing is missing, Please try again";
			}
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getAddCoverform($intPortalId,$intCoverId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$view->set('intPortalId',$intPortalId);
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		//$view->set('arrAppointmentNotes',$arrContacts);
		$arrCovervDetail=array();
		if($intCoverId)
		{
			$this->loadModel('CandidateCoverDetail');
			$arrCovervDetail = $this->CandidateCoverDetail->find('first', array(
									'conditions' => array('id'=>$intCoverId)
								));
			//print("<pre>");
			//print_r($arrCovervDetail);
			//exit;			
			$view->set('arrCovervDetail',$arrCovervDetail);			
		}
		else
		{
			$view->set('arrCovervDetail',$arrCovervDetail);	
		}
		$view->set('countrylist',$countrylist);
		$strWidgetListerHtml = $view->element('coveradd');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function fnrenameMyCv($intPortalId)
	{
		
		if($intPortalId)
		{
			 $this->loadModel('CandidateCvDetail');
			$arrLoggedUser = $this->Auth->user();
			
			
			if(isset($_POST))
			{
			
				$txt_title = $_POST['txt_title'];
				$txt_desc = $_POST['txt_desc'];
				$cvid = $_POST['cvid'];
				
				$modified_at 	= date("Y-m-d H:i:s",time() );
				$this->request->data['CandidateCvDetail']['modified_at']= $modified_at; 
				$boolUserprocess =  $this->CandidateCvDetail->updateAll(array('cv_title' => "'$txt_title'",'cv_description'=>"'$txt_desc'"),array('id' => $cvid));	
				
				if($boolUserprocess)					
				{
					$RespArray['status'] = "success";
											$RespArray['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Resume updated successfully.
						</div>';
				}
				else
				{
					$RespArray['status'] = "fail";
					$RespArray['message'] = " File upload error occured";
				}
				
			
				echo json_encode($RespArray);
						exit;
			}
		
		
		}
	}
	
	public function fnmakecvDefault($intPortalId,$intCvId)
	{
			if($intPortalId)
		{
			 $this->loadModel('CandidateCvDetail');
			$arrLoggedUser = $this->Auth->user();
			
			
			if(isset($_POST))
			{
			
				
				$modified_at 	= date("Y-m-d H:i:s",time() );
				$this->request->data['CandidateCvDetail']['modified_at']= $modified_at; 
				$boolUserprocess =  $this->CandidateCvDetail->updateAll(array('default_cv' => "'N'"),array('fk_employee_id' => $intPortalId));	
				$boolUserprocess =  $this->CandidateCvDetail->updateAll(array('default_cv' => "'Y'"),array('id' => $intCvId));	
				
				if($boolUserprocess)					
				{
					$RespArray['status'] = "success";
											$RespArray['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Cv made default successfully.
						</div>';
				}
				else
				{
					$RespArray['status'] = "fail";
					$RespArray['message'] = " File upload error occured";
				}
				
			
				echo json_encode($RespArray);
						exit;
			}
		
		
		}
	
	}
	
		public function fnmakeCoverDefault($intPortalId,$intCoverId)
	{
			if($intPortalId)
		{
			 $this->loadModel('CandidateCoverDetail');
			$arrLoggedUser = $this->Auth->user();
			
			
			if(isset($_POST))
			{
			
				
				$modified_at 	= date("Y-m-d H:i:s",time() );
				$this->request->data['CandidateCoverDetail']['modified_at']= $modified_at; 
				$boolUserprocess =  $this->CandidateCoverDetail->updateAll(array('is_defult' => "'N'"),array('fk_employer_id' => $intPortalId));	
				$boolUserprocess =  $this->CandidateCoverDetail->updateAll(array('is_defult' => "'Y'"),array('id' => $intCoverId));	
				
				if($boolUserprocess)					
				{
					$RespArray['status'] = "success";
											$RespArray['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Cover made default successfully.
						</div>';
				}
				else
				{
					$RespArray['status'] = "fail";
					$RespArray['message'] = " File upload error occured";
				}
				
			
				echo json_encode($RespArray);
						exit;
			}
		
		
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
	
	public function getAdvisor($intPortalId = "",$intSeekerId = "",$intCvId = "")
	{
		//Configure::write('debug','2');
		
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId)
		{
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
					$strCareeAdvisorAverageEmployedHtml = $view->element('career_advisor_average_under_one');
					
				}
				
				if($intAverageEmployedYears >= 1 && $intAverageEmployedYears <= 5)
				{
					$strCareeAdvisorAverageEmployedHtml = $view->element('career_advisor_average_under_two_to_five');
				}
				
				if($intTotalNumberOfYearsEmployed < 2)
				{
					$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_under_2');
					
				}
				
				if($intTotalNumberOfYearsEmployed >= 2 && $intTotalNumberOfYearsEmployed <= 10)
				{
					$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_two_to_ten');
					
				}
				
				if($intTotalNumberOfYearsEmployed >= 10)
				{
					$strCareeAdvisorNumberofYearsEmployedHtml = $view->element('career_advisor_number_above_ten');
					
				}
				
				if($intTotalDurationYearWise < 3)
				{
					$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_under_3');
				}
				
				if($intTotalDurationYearWise > 3)
				{
					$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_under_3');
				}
				
				if($intTotalDurationYearWise >= 3 && $intTotalDurationYearWise <= 12)
				{
					$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_three_to_twelve');
				}
				
				if($intTotalDurationYearWise >12)
				{
					$strCareeAdvisorGapsEmployedHtml = $view->element('career_advisor_gaps_twelve_above');
				}
				
				
				$view->set('averageduration',$strCareeAdvisorAverageEmployedHtml);
				$view->set('numberduration',$strCareeAdvisorNumberofYearsEmployedHtml);
				$view->set('gapsduration',$strCareeAdvisorGapsEmployedHtml);
				
				$arrResponse['status'] = 'success';
				$arrResponse['careeradvisorhtml'] = $view->element('career_advisor');
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = "Candidate has not provided any profession experience detail yet.";
			}
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getresumefont($intPortalId = "",$intSeekerId = "",$intCvId = "",$strFont = "calibri",$strFontSize = "11")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intPortalId)
		{
			$this->loadModel('Candidate_Cv');				
			$arrCvDetail = $this->Candidate_Cv->find('all', array(
									'conditions' => array('candidate_id'=> $intSeekerId,'candidatecv_id'=> $intCvId)
								));
			if($arrCvDetail[0]['Candidate_Cv']['font'])
			{
				$arrResponse['font'] = $arrCvDetail[0]['Candidate_Cv']['font'];
			}

			if($arrCvDetail[0]['Candidate_Cv']['font-size'])
			{
				$arrResponse['fontsize'] = $arrCvDetail[0]['Candidate_Cv']['font-size'];
			}
			$arrResponse['status'] = 'success';
			$arrResponse['font'] = $strFont = $arrCvDetail[0]['Candidate_Cv']['font'];
			$arrResponse['fontsize'] = $strFontSize = $arrCvDetail[0]['Candidate_Cv']['font-size'];
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getresumeView($intPortalId = "",$intSeekerId = "",$intCvId = "",$strFont = "calibri",$strFontSize = "11",$intFontSave = "")
	{
		if($strFontSize == "null")
		{
			$strFontSize = "11";
		}
		//echo "--".$intSeekerId;exit;
		//Configure::write('debug','2');
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
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
			$this->loadModel('Candidate_Cv');
			if($intFontSave)
			{
				$boolUserprocess =  $this->Candidate_Cv->updateAll(array('font' => "'$strFont'",'font-size' => "'$strFontSize'"),array('candidatecv_id' => $intCvId));
			}
			
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			/*$this->loadModel('CandidateCvDetail');
			$arrCvDetail = $this->CandidateCvDetail->find('all', array(
									'conditions' => array('fk_employee_id'=> $arrLoggedUser['candidate_id'])
								));*/
							
			$arrCvDetail = $this->Candidate_Cv->find('all', array(
									'conditions' => array('candidate_id'=> $intSeekerId,'candidatecv_id'=> $intCvId)
								));
			if($strFont == "no")
			{
				if($arrCvDetail[0]['Candidate_Cv']['font'])
				{
					$strFont = $arrCvDetail[0]['Candidate_Cv']['font'];
				}
				else
				{
					$strFont = "calibri";
				}
			}
			
			if($strFontSize == "no")
			{
				if($arrCvDetail[0]['Candidate_Cv']['font-size'])
				{
					$strFontSize = $arrCvDetail[0]['Candidate_Cv']['font-size'];
				}
				else
				{
					$strFontSize = "11";
				}
			}
			
			$this->loadModel('Candidate_Education');
			$this->loadModel('Candidate_prof_exp');
			$this->loadModel('Candidate_prof_affilations');
			$this->loadModel('Candidate_Awards');
			$this->loadModel('Candidate_Comm_Involve');
			$this->loadModel('Candidate_publications');
			$this->loadModel('Candidate_grants');
			$this->loadModel('Candidate_invited');
			$this->loadModel('Candidate_conference');
			$this->loadModel('Candidate_campus');
			$this->loadModel('Candidate_teaching');
			$this->loadModel('Candidate_research');
			$this->loadModel('Candidate_service');
			$this->loadModel('Candidate_uniservice');
			$this->loadModel('Candidate_lang');
			$this->loadModel('Candidate_prof_affiliation_a');
			$this->loadModel('Candidate_extra');
			$this->loadModel('Jobberlandcountry');
			$this->loadModel('Candidate_prof_exp_acc');
			$this->loadModel('Candidate_prof_exp_f_acc');
			$this->loadModel('Proffdev');
			$this->loadModel('Candidate_workexp');
			$this->loadModel('Candidate_summ');
			$this->loadModel('Candidate_Education_f');
			
			if(is_array($arrCvDetail) && count($arrCvDetail)>0)
			{
				
				$arrCountryDetail = $this->Jobberlandcountry->find('all',array('conditions'=>array('code'=>$arrCvDetail[0]['Candidate_Cv']['country'])));
				if(is_array($arrCountryDetail) && (count($arrCountryDetail)>0))
				{
					$arrCvDetail[0]['Candidate_Cv']['countrydetail'] = $arrCountryDetail;
				}
				
				
				$intCvId = $arrCvDetail[0]['Candidate_Cv']['candidatecv_id'];
				$strAcademicInfo = $arrCvDetail[0]['Candidate_Cv']['work_history'];
				$strRtype = $arrCvDetail[0]['Candidate_Cv']['mode'];
				
				if($strRtype == "functional")
				{
					$arrCvDetail[0]['Candidate_Cv']['education'] = $arrEducationDetail = $this->Candidate_Education_f->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
					
					$arrCvDetail[0]['Candidate_Cv']['candsum'] = $arrEducationDetail = $this->Candidate_summ->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
					
					$arrCvDetail[0]['Candidate_Cv']['profdev'] = $arrEducationDetail = $this->Proffdev->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
					
					$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail = $this->Candidate_workexp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						if(is_array($arrProDetail) && (count($arrProDetail)>0))
						{
							$intFrcnt = 0;
							foreach($arrProDetail as $aPro)
							{
								$arrPorexpAcc = $this->Candidate_prof_exp_f_acc->find('all',array('conditions'=>array('prof_exp_id'=>$aPro['Candidate_workexp']['candidate_prof_exp_id'],'acc !='=>'')));
								if(is_array($arrPorexpAcc) && (count($arrPorexpAcc)>0))
								{
									$arrProDetail[$intFrcnt]['Candidate_prof_exp']['acc'] = $arrPorexpAcc;
								}
								$intFrcnt++;
							}
						}
						$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail;
				}
				else
				{
					if($strAcademicInfo == "academia")
					{
						
						$arrCvDetail[0]['Candidate_Cv']['education'] = $arrEducationDetail = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						if(is_array($arrProDetail) && (count($arrProDetail)>0))
						{
							$intFrcnt = 0;
							foreach($arrProDetail as $aPro)
							{
								$arrPorexpAcc = $this->Candidate_prof_exp_acc->find('all',array('conditions'=>array('prof_exp_id'=>$aPro['Candidate_prof_exp']['candidate_prof_exp_id'])));
								if(is_array($arrPorexpAcc) && (count($arrPorexpAcc)>0))
								{
									$arrProDetail[$intFrcnt]['Candidate_prof_exp']['acc'] = $arrPorexpAcc;
								}
								$intFrcnt++;
							}
						}
						$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail;
						//print("<pre>");
						//print_r($arrProDetail);
						//exit;
						$arrCvDetail[0]['Candidate_Cv']['publication'] = $arrProAddDetail = $this->Candidate_publications->find('all',array('conditions'=>array('candidatecv_id'=>$intCvId)));

						
						$arrCvDetail[0]['Candidate_Cv']['awards'] = $arrAwDetail = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						//print("<pre>");
						//print_r($arrCvDetail);
						
						$arrCvDetail[0]['Candidate_Cv']['grants'] = $arrProAddDetail = $this->Candidate_grants->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['invited'] = $arrProAddDetail = $this->Candidate_invited->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['conferrence'] = $arrProAddDetail = $this->Candidate_conference->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['campus'] = $arrProAddDetail = $this->Candidate_campus->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['teaching'] = $arrProAddDetail = $this->Candidate_teaching->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['research'] = $arrProAddDetail = $this->Candidate_research->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['service'] = $arrProAddDetail = $this->Candidate_service->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['uniservice'] = $arrProAddDetail = $this->Candidate_uniservice->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['lang'] = $arrProAddDetail = $this->Candidate_lang->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['porfaff'] = $arrProAddDetail = $this->Candidate_prof_affiliation_a->find('all',array('conditions'=>array('candidatecv_id'=>$intCvId)));
						
						$arrCvDetail[0]['Candidate_Cv']['extra'] = $arrProAddDetail = $this->Candidate_extra->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
					}
					else
					{
						if($strAcademicInfo == "military")
						{
							$arrCvDetail[0]['Candidate_Cv']['education'] = $arrEducationDetail = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
							$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
							if(is_array($arrProDetail) && (count($arrProDetail)>0))
							{
								$intFrcnt = 0;
								foreach($arrProDetail as $aPro)
								{
									$arrPorexpAcc = $this->Candidate_prof_exp_acc->find('all',array('conditions'=>array('prof_exp_id'=>$aPro['Candidate_prof_exp']['candidate_prof_exp_id'])));
									if(is_array($arrPorexpAcc) && (count($arrPorexpAcc)>0))
									{
										$arrProDetail[$intFrcnt]['Candidate_prof_exp']['acc'] = $arrPorexpAcc;
									}
									$intFrcnt++;
								}
							}
							$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail;
							$arrCvDetail[0]['Candidate_Cv']['awards'] = $arrAwDetail = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						}
						else
						{
							$arrCvDetail[0]['Candidate_Cv']['education'] = $arrEducationDetail = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
							$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
							if(is_array($arrProDetail) && (count($arrProDetail)>0))
							{
								$intFrcnt = 0;
								foreach($arrProDetail as $aPro)
								{
									$arrPorexpAcc = $this->Candidate_prof_exp_acc->find('all',array('conditions'=>array('prof_exp_id'=>$aPro['Candidate_prof_exp']['candidate_prof_exp_id'])));
									if(is_array($arrPorexpAcc) && (count($arrPorexpAcc)>0))
									{
										$arrProDetail[$intFrcnt]['Candidate_prof_exp']['acc'] = $arrPorexpAcc;
									}
									$intFrcnt++;
								}
							}
							$arrCvDetail[0]['Candidate_Cv']['prof_exp'] = $arrProDetail;
							
							$arrCvDetail[0]['Candidate_Cv']['prof_aff'] = $arrProAddDetail = $this->Candidate_prof_affilations->find('all',array('conditions'=>array('candidatecv_id'=>$intCvId)));
							$arrCvDetail[0]['Candidate_Cv']['awards'] = $arrAwDetail = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
							$arrCvDetail[0]['Candidate_Cv']['comm_inv'] = $arrCommDetail = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id'=>$intCvId)));
						}
					}
				}
			}
			
			//print("<pre>");
			//print_r($arrCvDetail);
			//exit;
			
			
			//$strJobberlandCVUrl = Configure::read('Jobber.seekercvurl')."?portid=".$intPortalId;
			$view = new View($this, false);
			$view->set('arrCvDetail',$arrCvDetail);
			$view->set('strFont',$strFont);
			$view->set('strFontSize',$strFontSize);
			//$view->set('strSeekerCvUrl',$strJobberlandCVUrl);
			$view->set('intPortalId',$intPortalId);
			$html = $view->element('resumehtml');
			if($arrCvDetail[0]['Candidate_Cv']['mode'] == "functional")
			{
				$html = $view->element('resumehtmlF');	
			}
			else
			{
				if($arrCvDetail[0]['Candidate_Cv']['experience_level'] == "Student" || $arrCvDetail[0]['Candidate_Cv']['experience_level'] == "Entrylevel")
				{
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "no_experience")
					{
						//echo "hi";exit;
						$html = $view->element('resumehtml');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "experiencedTargeted")
					{
						//echo "hi";exit;
						$html = $view->element('resumehtmlsamec');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "experiencedChanging")
					{
						$html = $view->element('resumehtmlsamechange');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "academia")
					{
						$html = $view->element('resumehtmlacademic');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "military")
					{
						$html = $view->element('resumehtmlm');
					}
					
				}
				if($arrCvDetail[0]['Candidate_Cv']['experience_level'] == "Experienced" || $arrCvDetail[0]['Candidate_Cv']['experience_level'] == "Manager")
				{
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "experiencedTargeted")
					{
						$html = $view->element('resumehtmlsamemc');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "experiencedChanging")
					{
						$html = $view->element('resumehtmlsamemccc');
					}
					
					if($arrCvDetail[0]['Candidate_Cv']['work_history'] == "military")
					{
						$html = $view->element('resumehtmlm');
					}
				}
			}
			
			//echo $html;exit;
			//$strWorksheetFolder = Router::url('/',true)."candidate_resume";
			$strWorksheetFolder = "candidate_resume";
			$strWorksheetName = "candidate_resume_".$intPortalId."_".$intSeekerId."_".$intCvId.".pdf";
			$strCompleteStorageLocation = $strWorksheetFolder."/".$strWorksheetName;
			App::import('Vendor', 'mpdf/mpdf');
			$mpdf=new mPDF();
			$mpdf->SetDisplayMode('fullpage');
			// LOAD a stylesheet
			//$stylesheet = file_get_contents(Router::url('/',true).'css/fontresume.css');
			//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html);
			$strFileCreated = $mpdf->Output($strCompleteStorageLocation,'F');
			//echo $html;exit;
			if($strFileCreated)
			{
				$arrResponse['status'] = "success";
				$arrResponse['filename'] = $strWorksheetName;
			}
			else
			{
				$arrResponse['status'] = "fail";
			}
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function getresumehtml($intPortalId = "")
	{
            Configure::write('debug', 2);
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array('conditions' => array('career_portal_id'=> $intPortalId)));
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			$this->set('intPortalId',$intPortalId);
			
			//$compCandidates = $this->Components->load('Candidates');
			//$strJbToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
			
			$strRequiredSessionVar = "current_user_".$arrLoggedUser['candidate_id'];
			//echo "-----".$this->Session->read($strRequiredSessionVar);
			$strJbToken = $this->Session->read($strRequiredSessionVar);
			/*$this->loadModel('CandidateCvDetail');
			$arrCvDetail = $this->CandidateCvDetail->find('all', array(
									'conditions' => array('fk_employee_id'=> $arrLoggedUser['candidate_id'])
								));*/
			$this->loadModel('Candidate_Cv');				
			$arrCvDetail = $this->Candidate_Cv->find('all', array(
									'conditions' => array('candidate_id'=> $arrLoggedUser['candidate_id'])
								));
			
			//print("<pre>");
			//print_r($arrCvDetail);
			
			$strJobberlandCVUrl = Configure::read('Jobber.seekercvurl')."?portid=".$intPortalId;
			$view = new View($this, false);
			$view->set('arrCvDetail',$arrCvDetail);
			$view->set('strSeekerCvUrl',$strJobberlandCVUrl);
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('intPortalId',$intPortalId);
			$strCvHtml = $view->element('resume');
			
			if($strCvHtml)
			{
				$arrResponse['status'] = "success";
				$arrResponse['content'] = $strCvHtml;
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Missing parameter";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	
	public function changecvstatus($intPortalId,$intCvId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intCvId)
		{
			$view = new View($this, false);
			$view->set('intPortalId',$intPortalId);
		//$view->set('arrAppointmentNotes',$arrContacts);
			$strWidgetListerHtml = $view->element('resumebuilder');
			$arrResponse['status'] = 'success';
			$arrResponse['html'] = $strWidgetListerHtml;
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function deleteCv($intPortalId,$intCvId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intCvId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				$compCv = $this->Components->load('Cv');
				$intCvDeleted = $compCv->fnDeleteCv($intCvId);
				if($intCvDeleted)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Cv  deleted Successfully.
						</div>';
					$arrResponse['alldeleted'] = $compCv->fnCheckCVForSeeker($intSeekerId);
			
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
	
	
	public function deleteCover($intPortalId,$intCvId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intCvId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				$this->loadModel('CandidateCoverDetail');
				$intCovervDeleted = $this->CandidateCoverDetail->delete($intCvId);
				if($intCovervDeleted)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = '<div class="alert alert-success">
						  <img alt="image description" src="'.Router::url('/', true).'images/icon-alert-success.png">
						  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
						  Cover  deleted Successfully.
						</div>';
					
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
	
	
	public function downloadCv($intPortalId,$intCvId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intPortalId && $intCvId)
		{
			$arrLoggedUser = $this->Auth->user();
			if($this->request->is('Post'))
			{
				$intSeekerId = $arrLoggedUser['candidate_id'];
				
				 $this->loadModel('CandidateCvDetail');
				 $intCvDownloaded = $this->CandidateCvDetail->find('first',array('conditions'=>array('id' => $intCvId)),false);
				
				 $file_name 	 = $intCvDownloaded['CandidateCvDetail']['cv_file_name'];
				 $orginal_name 	= $intCvDownloaded['CandidateCvDetail']['original_name'];
				 $file_type		= $intCvDownloaded['CandidateCvDetail']['cv_file_type'];
				 $file_size		= $intCvDownloaded['CandidateCvDetail']['cv_file_size'];
				 $file_path		= $intCvDownloaded['CandidateCvDetail']['cv_file_path'];
				 $location		= $file_path;
			
				
				
				
				$this->response->file( Router::url('/', true)."".$file_path, array('download' => true));
				echo  $this->response;
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
		
	}
	
	
	public function getAddCvform($intPortalId)
	{		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$view->set('intPortalId',$intPortalId);
		//$view->set('arrAppointmentNotes',$arrContacts);
		$strWidgetListerHtml = $view->element('cvadd');
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}		
	public function fnSaveRType($portalid,$intCvType,$intCvId)	
{		
	$this->layout = NULL;		
	$this->autoRender = false;		
	$arrResponse = array();		
	$this->loadModel('Candidate_Cv');		
	$arrLoggedUser = $this->Auth->user();		
	$intSeekerId = $arrLoggedUser['candidate_id'];				
	$resumeid = $intCvId;		
	$mode = $intCvType;		
	if($resumeid)		
	{			
		$boolUserprocess =  $this->Candidate_Cv->updateAll(array('mode' => "'$mode'"),array('candidatecv_id' => $resumeid));			
		if($mode == "chronological")			
		{				
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);				
			$arrLoggedUser = $this->Auth->user();				
			$view = new View($this, false);				
			$view->set('seekerid',$arrLoggedUser['candidate_id']);				
			$view->set('experienceLevel',$experienceLevel);				
			$view->set('resumeid',$resumeid);				
			$strWidgetListerHtml = $view->element('createcv');			
		}			
		else			
		{				
			
			$this->loadModel('JobberlandCounties');
			$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
			asort($countrylist);
			$view->set('countrylist',$countrylist);
			$strWidgetListerHtml = $view->element('contactinfof');			
		}			
		$arrResponse['contactshtml'] = $strWidgetListerHtml;			
		if($arrResponse['contactshtml'])			
		{				
			$arrResponse['status'] = "success";			
		}			
		echo json_encode($arrResponse);			
		exit;		
	}		
	else		
	{			
		$this->request->data['Candidate_Cv']['mode']= $mode;			$boolUserprocessSaved = $this->Candidate_Cv->save($this->request->data);			
		$getInsertid_UsersID = $this->Candidate_Cv->getLastInsertID();			
		if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))			
		{				
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $getInsertid_UsersID)),false);				
			$view = new View($this, false);				
			$view->set('resumeid',$getInsertid_UsersID);				
			$view->set('seekerid',$intSeekerId);				
			$view->set('arrLoggedUser',$arrLoggedUser);				
			$view->set('experienceLevel',$experienceLevel);				
			if($mode == "chronological")				
			{					
				$strWidgetListerHtml = $view->element('createcv');				
			}				
			else				
			{					
				$this->loadModel('JobberlandCounties');
				$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
				asort($countrylist);
				$view->set('countrylist',$countrylist);
				$strWidgetListerHtml = $view->element('contactinfof');				
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
}
	public function fnChooseCVType($intPortalId = "",$intCvId = "")	{		$this->layout = NULL;		$this->autoRender = false;		$arrResponse = array();		$this->loadModel('Candidate_Cv');				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $intCvId)),false);				$view = new View($this, false);		$view->set('intPortalId',$intPortalId);		$view->set('resumeid',$intCvId);		$view->set('experienceLevel',$experienceLevel);		$strWidgetListerHtml = $view->element('choosecv');				$arrResponse['contactshtml'] = $strWidgetListerHtml;		if($arrResponse['contactshtml'])		{			$arrResponse['status'] = "success";		}		echo json_encode($arrResponse);		exit;	}
	public function getCreateCvform($intPortalId = "",$strResumeType = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$view->set('intPortalId',$intPortalId);		$view->set('rtype',$strResumeType);
		$this->loadModel('Resumesteps');
		$arrResumeStepDetail = $this->Resumesteps->find('all');
		$view->set('arrResumeStepDetail',$arrResumeStepDetail);		if($strResumeType == "chronological")		{			$strWidgetListerHtml = $view->element('createcv');		}		else		{			$strWidgetListerHtml = $view->element('contactinfo');		}
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function fnAddMyExperienceLevel($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('CandidateProfile');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('JobberlandCounties');
		$countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y')));
		asort($countrylist);
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);	
		//print("<pre>");
		//print_r($_POST);
		//exit;		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			//exit;
			
			$resumeid = $_POST['resumeid'];
			$experienceLevel = $contactinfo = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $contactinfo['Candidate_Cv']['work_history'];
			
			if($resumeid>0)
			{
				//print("<pre>");
				//print_r($contactinfo);
				
				
				//print("<pre>");
				//print_r($_POST);
				//exit;
				
				$experience = $_POST['experience'];
				$workhistory = $_POST['workhistory'];				$mode = $_POST['rtype'];
				//print("<pre>");
				//print_r($_POST);
				//exit;
				
				$boolUserprocess =  $this->Candidate_Cv->updateAll(array('experience_level' => "'$experience'",'work_history' => "'$workhistory'"),array('candidatecv_id' => $resumeid));
				//exit;
					$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
					$arrCandidateDetail = $this->CandidateProfile->find('all',array('conditions'=>array('hc_uid'=>$arrLoggedUser['candidate_id'])));
					//print("<pre>");
					//print_r($arrLoggedUser);
					//exit;
					$view->set('resumeid',$resumeid);
					$view->set('arrLoggedUser',$arrLoggedUser);
					$view->set('seekerid',$intSeekerId);
					$view->set('contactinfo',$contactinfo);
					$view->set('countrylist',$countrylist);
					$view->set('arrCandidateDetail',$arrCandidateDetail);
					$view->set('experienceLevel',$experienceLevel);
					//print("<pre>");
					//print_r($countrylist);
					//exit;
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
					
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$this->request->data['Candidate_Cv']['resume_title']= addslashes(trim($_POST['resume_title']));
				$this->request->data['Candidate_Cv']['candidate_id']= $intSeekerId;
				$this->request->data['Candidate_Cv']['experience_level']= $_POST['experience'];
				$this->request->data['Candidate_Cv']['work_history']= $_POST['workhistory'];
				$this->request->data['Candidate_Cv']['firstName']= $arrLoggedUser['candidate_first_name'];
				$this->request->data['Candidate_Cv']['lastName']= $arrLoggedUser['candidate_last_name'];				

				//$this->request->data['Candidate_Cv']['work_history']= $_POST['workhistory'];
				//$this->request->data['Candidate_Cv']['work_history']= $_POST['workhistory'];
				
				$boolUserprocessSaved = $this->Candidate_Cv->save($this->request->data);
				$getInsertid_UsersID = $this->Candidate_Cv->getLastInsertID();
				if($getInsertid_UsersID>0)
				{
					$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $boolUserprocessSaved['Candidate_Cv']['id'])),false);
					//print("<pre>");
					//print_r($experienceLevel);
					//exit;
					$view->set('resumeid',$getInsertid_UsersID);
					$view->set('seekerid',$intSeekerId);
					$view->set('arrLoggedUser',$arrLoggedUser);
					$view->set('countrylist',$countrylist);
					$view->set('experienceLevel',$experienceLevel);
					if($strAcademicInfo == "academia")	
					{
						$strWidgetListerHtml = $view->element('contactinfoa');
					}
					else
					{
						if($strAcademicInfo == "academia")
						{
							$strWidgetListerHtml = $view->element('contactinfom');
						}
						else
						{
							$strWidgetListerHtml = $view->element('contactinfo');
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
					
		}
		
	}
	
	public function fnAddExistingResume($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
				
			$resumeid = $_POST['resumeid'];
			$resume_title = addslashes(trim($_POST['existing_resume_title_name']));
			if($resumeid)
			{
				$boolUserprocess =  $this->Candidate_Cv->updateAll(array('resume_title' => "'$resume_title'",'status'=>"'complete'"),array('candidatecv_id' => $resumeid));
				if($boolUserprocess)
				{
					$intCvId =  $resumeid;
					if($_FILES['existing_resume_title']['name'] != "")
					{
						//$get_microtime = $this->fnToGetMicroTime();
						$strVehicleImgName = $_FILES['existing_resume_title']['name'];
						$strFileExt = pathinfo($strVehicleImgName);
						$customVehicleimgName = $strVehicleImgName;
						$arrProDetail= array();					
						$strVehicleImageTmpName = $_FILES['existing_resume_title']['tmp_name'];
						//echo "--".$strVehicleImageTmpName;
						//echo "--".$strVehicleImgName;
						//exit;
						$strNewVehicleImgName = "Portal_".$portalid."_".$intCvId."_".$strVehicleImgName;
						move_uploaded_file($strVehicleImageTmpName,WWW_ROOT . 'candidate_cv/'.$strNewVehicleImgName);		
						$boolUpdated = $this->Candidate_Cv->updateAll(array(
							'cv_file_path' => "'".$strNewVehicleImgName."'"),
							array('candidatecv_id' => $intCvId)
						);
						//print("<pre>");
						//print_r($_FILES);
						//exit;
					}
				}
			}
			else
			{
				$arrResumeDetail['Candidate_Cv']['resume_title'] = $resume_title;
				$arrResumeDetail['Candidate_Cv']['type'] = 'existing';
				$arrResumeDetail['Candidate_Cv']['candidate_id'] = $intSeekerId;
				$arrResumeDetail['Candidate_Cv']['status'] = 'complete';
				$arrSavedData = $this->Candidate_Cv->save($arrResumeDetail);
				if(is_array($arrSavedData) && (count($arrSavedData)>0))
				{
					$intCvId =  $this->Candidate_Cv->getLastInsertId();
					if($_FILES['existing_resume_title']['name'] != "")
					{
						//$get_microtime = $this->fnToGetMicroTime();
						$strVehicleImgName = $_FILES['existing_resume_title']['name'];
						$strFileExt = pathinfo($strVehicleImgName);
						$customVehicleimgName = $strVehicleImgName;
						$arrProDetail= array();					
						$strVehicleImageTmpName = $_FILES['existing_resume_title']['tmp_name'];
						//echo "--".$strVehicleImageTmpName;
						//echo "--".$strVehicleImgName;
						//exit;
						$strNewVehicleImgName = "Portal_".$portalid."_".$intCvId."_".$strVehicleImgName;
						move_uploaded_file($strVehicleImageTmpName,WWW_ROOT . 'candidate_cv/'.$strNewVehicleImgName);		
						$boolUpdated = $this->Candidate_Cv->updateAll(array(
							'cv_file_path' => "'".$strNewVehicleImgName."'"),
							array('candidatecv_id' => $intCvId)
						);
						//print("<pre>");
						//print_r($_FILES);
						//exit;
					}
				}
			}
			
			
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
	
	public function getMyExisting($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		//print("<pre>");
		//print_r($experienceLevel);
		
		$view = new View($this, false);	
		$view->set('resumeid',$candidatecv_id);
		$view->set('resume_title',$experienceLevel['Candidate_Cv']['resume_title']);
		$view->set('resume_path',$experienceLevel['Candidate_Cv']['cv_file_path']);
		//print("<pre>");
		//print_r($experienceLevel);
		//exit;
		$view->set('experienceLevel',$experienceLevel);
		$strWidgetListerHtml = $view->element('uploadexisting');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		//$arrResponse['contactshtml'] = '';
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	
	public function getMyExplevel($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		//print("<pre>");
		//print_r($experienceLevel);
		//exit;
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('createcva');
		}
		else
		{
			if($strAcademicInfo == "military")
			{
				$strWidgetListerHtml = $view->element('createcvm');
			}
			else
			{
				$strWidgetListerHtml = $view->element('createcv');
			}
		}
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		//$arrResponse['contactshtml'] = '';
		
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
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getUploadExisting($portalid)
	{
		$this->loadModel('Candidate_Cv');
		//$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $candidatecv_id));
	
		
		$view = new View($this, false);	
		
		//$view->set('resumeid',$candidatecv_id);
		
		//$view->set('Career_Summary',$Career_Summary);
		$strWidgetListerHtml = $view->element('uploadexisting');
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
		if($strAcademicInfo == "military")
		{
			$strWidgetListerHtml = $view->element('career_summarym');
		}
		else
		{
			$strWidgetListerHtml = $view->element('career_summary');
		}
		
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
		if($strAcademicInfo == "military")
		{
			$strWidgetListerHtml = $view->element('core_competenciesm');
		}
		else
		{
			$strWidgetListerHtml = $view->element('core_competencies');
		}
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	
	public function getMyEducation($portalid,$candidatecv_id)
	{
		//Configure:write('debug','2');
		$this->loadModel('Candidate_Education');
		$this->loadModel('Candidate_Cv');
		$candidateEducation = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),"order"=>array('candidate_education_id'=>'ASC')),false);
		$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
		//print("<pre>");
		//print_r($candidateEducation);
		//exit;
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		$view->set('candidateEducation',$candidateEducation);
		if($strAcademicInfo == "military")
		{
			$strWidgetListerHtml = $view->element('educationm');
		}
		else
		{
			$strWidgetListerHtml = $view->element('education');
		}
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getProfExperience($portalid,$candidatecv_id)
	{
		Configure::write('debug','2');
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_prof_exp');
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_prof_exp_acc');
		
		$proffsionalexp = $this->Candidate_prof_exp->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')	));
		$proffsionalaffilations = $this->Candidate_prof_affilations->find('all',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
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
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('proffessionalexpa');
		}
		else
		{
			if($strAcademicInfo == "military")	
			{
				$strWidgetListerHtml = $view->element('proffessionalexpm');
			}
			else
			{
				$strWidgetListerHtml = $view->element('proffessionalexp');
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
	
	public function getMyGrants($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_grants');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];

		$candidateawards = $this->Candidate_grants->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'ORDER'=>array('candidate_awards_id','ASC')),false);
		
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			//print("<pre>");
			//print_r($candidateawards);
			//exit;
			
			$view->set('candidateawards',$candidateawards);
			$strWidgetListerHtml = $view->element('grants');
		}
		else
		{
			$view->set('candidateawards',$candidateawards);
			$strWidgetListerHtml = $view->element('grants');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyInvites($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_invited');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];

		$candidateawards = $this->Candidate_invited->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		//print("<pre>");
		//print_r($candidateawards);
		//exit;
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('inviteda');
		}
		else
		{
			$strWidgetListerHtml = $view->element('inviteda');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyConference($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_conference');
		$candidateawards = $this->Candidate_conference->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		//print("<pre>");
		//print_r($candidateawards);
		//exit;
		
		
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			
			$strWidgetListerHtml = $view->element('conference');
		}
		else
		{
			$strWidgetListerHtml = $view->element('conference');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyCampus($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_campus');
		$candidateawards = $this->Candidate_campus->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		
		
		
		
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('campus');
		}
		else
		{
			$strWidgetListerHtml = $view->element('campus');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyTeaching($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		
		$this->loadModel('Candidate_teaching');
		$candidateawards = $this->Candidate_teaching->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		
		
		
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('teaching');
		}
		else
		{
			$strWidgetListerHtml = $view->element('teaching');
		}
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyResearch($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		
		$this->loadModel('Candidate_research');
		$candidateawards = $this->Candidate_research->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		//print("<pre>");
		//print_r($candidateawards);
		//exit;
		
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			
			$strWidgetListerHtml = $view->element('research');
		}
		else
		{
			$strWidgetListerHtml = $view->element('research');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyPublications($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_publications');
		$this->loadModel('Candidate_prof_affilations');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		$publications = $this->Candidate_publications->find('all',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('publications',$publications);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('publications');
		}
		else
		{
			$strWidgetListerHtml = $view->element('publications');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyLang($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
				$this->loadModel('Candidate_lang');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		

		$candidateawards = $this->Candidate_lang->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
		
		
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('candidatelang');
		}
		else
		{
			$strWidgetListerHtml = $view->element('candidatelang');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyUniService($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_uniservice');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		$candidateawards = $this->Candidate_uniservice->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('uniservice');
		}
		else
		{
			$strWidgetListerHtml = $view->element('uniservice');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyPrffAffA($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		$this->loadModel('Candidate_prof_affiliation_a');
		$candidateawards = $this->Candidate_prof_affiliation_a->find('all',array('conditions'=>array('candidatecv_id' => $candidatecv_id),'order'=>array('candidate_prof_affilations_id'=>'ASC')),false);
		
		
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('proffsionalaffilations',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('professionalaffiliationsa');
		}
		else
		{
			$strWidgetListerHtml = $view->element('professionalaffiliationsa');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	
	}
	
	public function getMyExtra($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		$this->loadModel('Candidate_extra');
		$candidateawards = $this->Candidate_extra->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('extra');
		}
		else
		{
			$strWidgetListerHtml = $view->element('extra');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyService($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_service');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		
		$candidateawards = $this->Candidate_service->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
		
		
		
		//print("<pre>");
		//print_r($proffsionalexp);
		//exit;
		$view = new View($this, false);	
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		$view->set('proffsionalexp',$proffsionalexp);
		$view->set('candidateawards',$candidateawards);
		$view->set('experienceLevel',$experienceLevel);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('service');
		}
		else
		{
			$strWidgetListerHtml = $view->element('service');
		}
		
		
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	public function getMyAffiliates($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_Cv');
		$proffsionalaffilations = $this->Candidate_prof_affilations->find('all',array('conditions'=>array('candidatecv_id' => $candidatecv_id),'order'=>array('candidate_prof_affilations_id'=>'ASC')),false);
	
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		$view->set('proffsionalaffilations',$proffsionalaffilations);
		$strWidgetListerHtml = $view->element('professionalaffiliations');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
				exit;
	}
	
	
	public function getMyAwards($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Awards');
		$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id),'order'=>array('candidate_awards_id'=>'ASC')),false);
		$this->loadModel('Candidate_Cv');
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$strAcademicInfo = $experienceLevel['Candidate_Cv']['work_history'];
		
		$view = new View($this, false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		$view->set('candidateawards',$candidateawards);
		if($strAcademicInfo == "academia")	
		{
			$strWidgetListerHtml = $view->element('awardsa');
		}
		else
		{
			if($strAcademicInfo == "military")	
			{
				$strWidgetListerHtml = $view->element('awardsm');
			}
			else
			{
				$strWidgetListerHtml = $view->element('awards');
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
	
	public function getCommunityInvolve($portalid,$candidatecv_id)
	{
		$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $candidatecv_id)),false);
		
		$view = new View($this, false);
		$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $candidatecv_id)),false);
		$view->set('experienceLevel',$experienceLevel);
		$arrLoggedUser = $this->Auth->user();
		$view->set('seekerid',$arrLoggedUser['candidate_id']);
		$view->set('resumeid',$candidatecv_id);
		
		$view->set('candidatecomminvolves',$candidatecomminvolves);
		$strWidgetListerHtml = $view->element('community_involvement');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	

	public function fnAddMyContactInfo($portalid)
	{
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		$intCandId = $arrLoggedUser['candidate_id'];
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$resumeid = $_POST['resumeid'];
			$firstName = addslashes($_POST['firstName']);
			$middle_initial = addslashes($_POST['middle_initial']);
			$lastName = addslashes($_POST['lastName']);
			$streetAddress = addslashes($_POST['streetAddress']);
			$city = $_POST['city'];
			$country = $_POST['country'];
			$state = $_POST['state'];
			$zipCode = $_POST['zipCode'];
			$homePhone= $_POST['homePhone'];
			$cellPhone = $_POST['cellPhone'];
			$email_address= $_POST['email_address'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$boolUserprocess =  $this->Candidate_Cv->updateAll(array('candidate_id'=>"'$intCandId'",'firstName' => "'$firstName'",'middle_initial' => "'$middle_initial'",'lastName' => "'$lastName'",'streetAddress' => "'$streetAddress'",'city' => "'$city'",'country' => "'$country'",'state' => "'$state'",'zipCode' => "'$zipCode'",'homePhone' => "'$homePhone'",'cellPhone' => "'$cellPhone'",'email_address'=>"'$email_address'"),array('candidatecv_id' => $resumeid));	
			$Career_Summary = $this->Candidate_Cv->field('Career_Summary', array('candidatecv_id' => $resumeid));
			if($resumeid>0)
			{
				$arrLoggedUser = $this->Auth->user();
				$view->set('seekerid',$arrLoggedUser['candidate_id']);
				$view->set('resumeid',$resumeid);
				$view->set('arrLoggedUser',$arrLoggedUser);
				$view->set('Career_Summary',$Career_Summary);
				
				$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$strRtype = $arrCv['Candidate_Cv']['mode'];
				$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
				if($strRtype == "functional")
				{
					$strWidgetListerHtml = $view->element('career_summaryf');
				}
				else
				{
					if($strAcademicInfo == "academia")
					{
						$this->loadModel('Candidate_Education');
						$candidateEducation = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),"order"=>array('candidate_education_id'=>'ASC')),false);
						//print("<pre>");
						//print_r($candidateEducation);
						//exit;
						$view->set('candidateEducation',$candidateEducation);
						$strWidgetListerHtml = $view->element('educationa');	
					}
					else
					{
						if($strAcademicInfo == "military")
						{
							//echo "hi";exit;
							$strWidgetListerHtml = $view->element('career_summarym');
						}
						else
						{
							$strWidgetListerHtml = $view->element('career_summary');
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
		
	}
	
	
	
	
	public function fnAddMyCareerSummary($portalid)
	{
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strRtype = $arrCv['Candidate_Cv']['mode'];
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$career_summary= $_POST['career_summary'];
			$boolUserprocess =  $this->Candidate_Cv->updateAll(array('career_summary' => "'$career_summary'"),array('candidatecv_id' => $resumeid));	
			$keywords = $this->Candidate_Cv->field('keywords', array('candidatecv_id' => $resumeid));
			if($resumeid>0)
			{
				$arrLoggedUser = $this->Auth->user();
				$view->set('seekerid',$arrLoggedUser['candidate_id']);
				$view->set('resumeid',$resumeid);
				$view->set('arrLoggedUser',$arrLoggedUser);
				$view->set('keywords',$keywords);
				
				if($strRtype == "functional")
				{
					$strWidgetListerHtml = $view->element('core_competenciesf');
				}
				else
				{
					if($strAcademicInfo == "military")
					{
						$strWidgetListerHtml = $view->element('core_competenciesm');
					}
					else
					{
						$strWidgetListerHtml = $view->element('core_competencies');
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
		
	}
	
	public function fnAddMyKeywords($portalid)
	{
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strRtype = $arrCv['Candidate_Cv']['mode'];
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$keywords= $_POST['keywords'];
			$boolUserprocess =  $this->Candidate_Cv->updateAll(array('keywords' => "'$keywords'"),array('candidatecv_id' => $resumeid));	
		
			if($resumeid>0)
			{
				$this->loadModel('Candidate_Education');
				$candidateEducation = $this->Candidate_Education->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
				$arrLoggedUser = $this->Auth->user();
				$view->set('seekerid',$arrLoggedUser['candidate_id']);
				$view->set('resumeid',$resumeid);
				$view->set('arrLoggedUser',$arrLoggedUser);
				$view->set('candidateEducation',$candidateEducation);
				if($strRtype == "functional")
				{
					$this->loadModel('Candidate_summ');
					$candidateEducation = $this->Candidate_summ->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);	
					$view->set('candidateEducation',$candidateEducation);
					$strWidgetListerHtml = $view->element('educationf');
					
					//echo "asdasd";exit;
				}
				else
				{
					if($strAcademicInfo == "military")
					{
						$strWidgetListerHtml = $view->element('educationm');
					}
					else
					{
						$strWidgetListerHtml = $view->element('education');
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
		
	}
	
	
	public function fnAddMyEducation($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_Education');
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
			$this->request->data['Candidate_Education']['candidate_cv_id']= $resumeid;
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			
			//print("<pre>");
			//print_r($_POST);
			//exit;
			$this->Candidate_Education->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$education_id = $_POST['education_id'.$i];
				if($education_id)
				{
					$this->request->data['Candidate_Education']['degree'] = $degree = $_POST['degree'.$i];
					$this->request->data['Candidate_Education']['institution'] = $institution = $_POST['institution'.$i];
					$this->request->data['Candidate_Education']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_Education']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_Education']['tution_percentage'] = $percentage = $_POST['percentage'.$i];
					$this->request->data['Candidate_Education']['year'] = $percentage = $_POST['date-start'.$i];
					$this->Candidate_Education->create(false);
					$boolUserprocessSaved = $this->Candidate_Education->save($this->request->data);
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

					
					$this->request->data['Candidate_Education']['degree']= $_POST['degree'.$i];
					$this->request->data['Candidate_Education']['institution'] = $_POST['institution'.$i];
					$this->request->data['Candidate_Education']['city']= $_POST['city'.$i];
					$this->request->data['Candidate_Education']['state'] = $_POST['state'.$i];
					$this->request->data['Candidate_Education']['tution_percentage']= $_POST['percentage'.$i];
					$this->request->data['Candidate_Education']['completion_year'] = $_POST['date-start'.$i];
					$this->Candidate_Education->create(false);
					$boolUserprocessSaved = $this->Candidate_Education->save($this->request->data);
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
			if($strAcademicInfo == "academia")
			{
				$strWidgetListerHtml = $view->element('proffessionalexpa');
			}
			else
			{
				if($strAcademicInfo == "military")
				{
					$strWidgetListerHtml = $view->element('proffessionalexpm');
				}
				else
				{
					$strWidgetListerHtml = $view->element('proffessionalexp');
				}
			}
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
	
	
	public function fnAddMyProfExp($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_Awards');
		$this->loadModel('Candidate_prof_exp');
		$this->loadModel('Candidate_Cv');
		$this->loadModel('Candidate_publications');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_prof_exp_acc');
		$intOperationSuccess = "";
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			//exit;
			$intEdCnt = $_POST['pexp_count'];
			$this->request->data['Candidate_prof_exp']['candidate_cv_id']= $resumeid = $_POST['resumeid'];
			$this->Candidate_prof_exp->deleteAll(array('candidate_cv_id' => $resumeid),false);
			$this->Candidate_prof_exp_acc->deleteAll(array('cv_id' => $resumeid),false);
			$this->request->data['Candidate_prof_exp']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$prof_exp_id = $_POST['prof_exp_id'.$i];
				if($prof_exp_id)
				{
					//echo "--".date("M",strtotime("2016-03"));
					$this->request->data['Candidate_prof_exp']['company'] = $company = $_POST['company'.$i];
					$this->request->data['Candidate_prof_exp']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_prof_exp']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_prof_exp']['jobTitle'] = $jobTitle = $_POST['jobTitle'.$i];
					$this->request->data['Candidate_prof_exp']['fromDate'] = $fromDate = $_POST['date-start'.$i];
					$this->request->data['Candidate_prof_exp']['toDate'] = $toDate = $_POST['date-end'.$i];
					$this->request->data['Candidate_prof_exp']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_prof_exp']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_prof_exp']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_prof_exp']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_prof_exp']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					
					$this->request->data['Candidate_prof_exp']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_prof_exp']['description'] = $description = $_POST['description'.$i];
					//print("<pre>");
					//print_r($this->request->data['Candidate_prof_exp']);
					//exit;
					$this->Candidate_prof_exp->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_exp->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intProfExpId = $boolUserprocessSaved['Candidate_prof_exp']['id'];
						$intOperationSuccess = "1";
						$intAccCnt = $_POST['pexp_acc_cnt'.$i];
						if($intAccCnt)
						{
							
							for($j = 1;$j <=$intAccCnt; $j++)
							{
								$arrProfAcc['Candidate_prof_exp_acc']['acc'] = $strAcc = $_POST['acc'.$i.$j];
								$arrProfAcc['Candidate_prof_exp_acc']['prof_exp_id'] = $intProfExpId;
								$arrProfAcc['Candidate_prof_exp_acc']['cv_id'] = $resumeid;
								$this->Candidate_prof_exp_acc->create(false);
								$this->Candidate_prof_exp_acc->save($arrProfAcc);
							}
						}
					}
					
					
					
					
					
					/*$boolUserprocess =  $this->Candidate_prof_exp->updateAll(array('company' => "'$company'",'city' => "'$city'",'state' => "'$state'",'jobTitle' => "'$jobTitle'",'fromDate' => "'$fromDate'",'toDate' => "'$toDate'",'description' => "'$description'"),array('candidate_prof_exp_id' => $prof_exp_id));	
					
					
					$this->loadModel('Candidate_prof_exp');*/
				}
				else
				{
					$this->request->data['Candidate_prof_exp']['candidate_cv_id']= $resumeid;
					$this->request->data['Candidate_prof_exp']['company'] = $company = $_POST['company'.$i];
					$this->request->data['Candidate_prof_exp']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_prof_exp']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_prof_exp']['jobTitle'] = $jobTitle = $_POST['jobTitle'.$i];
					$this->request->data['Candidate_prof_exp']['fromDate'] = $fromDate = $_POST['date-start'.$i];
					$this->request->data['Candidate_prof_exp']['toDate'] = $toDate = $_POST['date-end'.$i];
					$this->request->data['Candidate_prof_exp']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_prof_exp']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_prof_exp']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_prof_exp']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_prof_exp']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					$this->request->data['Candidate_prof_exp']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_prof_exp']['description'] = $description = $_POST['description'.$i];
					$this->Candidate_prof_exp->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_exp->save($this->request->data);
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
			$arrResponse['contactshtml'] = $strWidgetListerHtml;
			if($arrResponse['contactshtml'])
			{
					$arrResponse['status'] = "success";
			}
				
			echo json_encode($arrResponse);
			exit;
		}
		
	}
	
	public function fnAddMyPublications($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_publications');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_Awards');
		$intOperationSuccess = "";
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			//exit;
			
			$this->request->data['Candidate_publications']['candidatecv_id'] = $resumeid = $_POST['resumeid'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			//print("<pre>");
			//print_r($arrCv);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			
			$intEdCnt = $_POST['education_count'];
			$this->Candidate_publications->deleteAll(array('candidatecv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$prof_aff_id = $_POST['publication_id'.$i];
				if($prof_aff_id)
				{
					$this->request->data['Candidate_publications']['subheading'] = $org = $_POST['degree'.$i];
					$this->request->data['Candidate_publications']['publications'] = $acr = $_POST['institution'.$i];
					$this->request->data['Candidate_publications']['citation'] = $acr = $_POST['citation'.$i];
					$this->request->data['Candidate_publications']['date'] = $leader = $_POST['date-start'.$i];
					$this->request->data['Candidate_publications']['page_numbers'] = $leader = $_POST['pagenum'.$i];
					$this->Candidate_prof_affilations->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_affilations->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}

					/*$boolUserprocess =  $this->Candidate_prof_affilations->updateAll(array('organization_name' => "'$org'",'acronym' => "'$acr'",'leadership' => "'$leader'",'candidatecv_id' => "'$resumeid'"),array('candidate_prof_affilations_id' => $prof_aff_id));*/	
					//exit;
				}
				else
				{
					//$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$this->request->data['Candidate_publications']['subheading'] = $org = $_POST['degree'.$i];
					$this->request->data['Candidate_publications']['publications'] = $acr = $_POST['institution'.$i];
					$this->request->data['Candidate_publications']['citation'] = $acr = $_POST['citation'.$i];
					$this->request->data['Candidate_publications']['date'] = $leader = $_POST['date-start'.$i];
					$this->request->data['Candidate_publications']['page_numbers'] = $leader = $_POST['pagenum'.$i];
					$this->Candidate_publications->create(false);
					$boolUserprocessSaved = $this->Candidate_publications->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
				}
			}
			if($resumeid)
			{
				$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			}
			
			$arrLoggedUser = $this->Auth->user();
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('candidateawards',$candidateawards);
			$view->set('resumeid',$resumeid);
			$view->set('arrLoggedUser',$arrLoggedUser);
			$view->set('experienceLevel',$experienceLevel);
			//echo "--".$strAcademicInfo;
			if($strAcademicInfo == "academia")
			{
				$strWidgetListerHtml = $view->element('awardsa');
			}
			else
			{
				$strWidgetListerHtml = $view->element('awards');
			}	
			
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
	
	public function fnAddMyProffesionalAff($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_prof_affilations');
		$this->loadModel('Candidate_Cv');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_Awards');
		$intOperationSuccess = "";
	
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_prof_affilations']['candidatecv_id'] = $resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$intEdCnt = $_POST['profaff_count'];
			$this->Candidate_prof_affilations->deleteAll(array('candidatecv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$prof_aff_id = $_POST['prof_aff_id'.$i];
				if($prof_aff_id)
				{
					$this->request->data['Candidate_prof_affilations']['organization_name'] = $org = $_POST['organization_name'.$i];
					$this->request->data['Candidate_prof_affilations']['acronym'] = $acr = $_POST['acronym'.$i];
					$this->request->data['Candidate_prof_affilations']['leadership'] = $leader = $_POST['leadershiproles'.$i];
					$this->Candidate_prof_affilations->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_affilations->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}

					/*$boolUserprocess =  $this->Candidate_prof_affilations->updateAll(array('organization_name' => "'$org'",'acronym' => "'$acr'",'leadership' => "'$leader'",'candidatecv_id' => "'$resumeid'"),array('candidate_prof_affilations_id' => $prof_aff_id));*/	
					//exit;
				}
				else
				{
					$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$this->request->data['Candidate_prof_affilations']['candidatecv_id']= $resumeid;
					$this->request->data['Candidate_prof_affilations']['organization_name']= $_POST['organization_name'.$i];
					$this->request->data['Candidate_prof_affilations']['acronym']= $_POST['acronym'.$i];
					$this->request->data['Candidate_prof_affilations']['leadership']= $_POST['leadershiproles'.$i];
					$this->Candidate_prof_affilations->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_affilations->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
				}
			}
			if($resumeid)
			{
				$candidateawards = $this->Candidate_Awards->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
			}
			
			$arrLoggedUser = $this->Auth->user();
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('candidateawards',$candidateawards);
			$view->set('resumeid',$resumeid);
			$view->set('arrLoggedUser',$arrLoggedUser);
				
			$strWidgetListerHtml = $view->element('awards');
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
	
	public function fnSaveConf($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_conference');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			//exit;
			
			$this->request->data['Candidate_conference']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['conf_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_conference->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_conference']['date'] = $award_name = $_POST['date-start'.$i];
					$this->request->data['Candidate_conference']['year'] = $award_name = $_POST['date-start'.$i];
					$this->request->data['Candidate_conference']['name'] = $organization = $_POST['award_name'.$i];
					$this->request->data['Candidate_conference']['paper_name'] = $description = $_POST['organization'.$i];
					$this->Candidate_conference->create(false);
					$boolUserprocessSaved = $this->Candidate_conference->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_conference']['date'] = $award_name = $_POST['date-start'.$i];
					$this->request->data['Candidate_conference']['name'] = $organization = $_POST['award_name'.$i];
					$this->request->data['Candidate_conference']['paper_name'] = $description = $_POST['organization'.$i];
					$this->Candidate_conference->create(false);
					$boolUserprocessSaved = $this->Candidate_conference->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_campus');
					$candidateawards = $this->Candidate_campus->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('campus');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveTeaching($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_teaching');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_teaching']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['teaching_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_teaching->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_teaching']['title'] = $award_name = $_POST['award_name'.$i];
					$this->Candidate_teaching->create(false);
					$boolUserprocessSaved = $this->Candidate_teaching->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_teaching']['title'] = $award_name = $_POST['award_name'.$i];
					$this->Candidate_teaching->create(false);
					$boolUserprocessSaved = $this->Candidate_teaching->save($this->request->data);
					$this->Candidate_teaching->create(false);
					$boolUserprocessSaved = $this->Candidate_teaching->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_research');
					$candidateawards = $this->Candidate_research->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_awards_id'=>'ASC')),false);
					//print("<pre>");
					//print_r($candidateawards);
					//exit;
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('research');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveResearch($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_research');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			//print("<pre>");
			//print_r($_POST);
			
			$this->request->data['Candidate_research']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['research_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_research->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_research']['research_exp'] = $award_name = $_POST['description'.$i];
					$this->Candidate_research->create(false);
					$boolUserprocessSaved = $this->Candidate_research->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_research']['research_exp'] = $award_name = $_POST['description'.$i];
					$this->Candidate_research->create(false);
					$boolUserprocessSaved = $this->Candidate_research->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_service');
					$candidateawards = $this->Candidate_service->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('service');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveLang($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_lang');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_lang']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['lang_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_lang->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_lang']['lang'] = $organization = $_POST['lang'.$i];
					$this->request->data['Candidate_lang']['reading'] = $description = $_POST['reading'.$i];
					$this->request->data['Candidate_lang']['speaking'] = $description = $_POST['speaking'.$i];
					$this->request->data['Candidate_lang']['writing'] = $description = $_POST['writing'.$i];
					$this->Candidate_lang->create(false);
					
					$boolUserprocessSaved = $this->Candidate_lang->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_lang']['lang'] = $organization = $_POST['lang'.$i];
					$this->request->data['Candidate_lang']['reading'] = $description = $_POST['reading'.$i];
					$this->request->data['Candidate_lang']['speaking'] = $description = $_POST['speaking'.$i];
					$this->request->data['Candidate_lang']['writing'] = $description = $_POST['writing'.$i];
					$this->Candidate_lang->create(false);
					$boolUserprocessSaved = $this->Candidate_lang->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_prof_affiliation_a');
					$candidateawards = $this->Candidate_prof_affiliation_a->find('all',array('conditions'=>array('candidatecv_id' => $resumeid),'order'=>array('candidate_prof_affilations_id'=>'ASC')),false);
					$view->set('proffsionalaffilations',$candidateawards);
					$strWidgetListerHtml = $view->element('professionalaffiliationsa');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveExtra($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_extra');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_extra']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['extra_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_extra->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['prof_aff_id'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_extra']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_extra']['involvement'] = $description = $_POST['description'.$i];
					$this->Candidate_extra->create(false);
					$boolUserprocessSaved = $this->Candidate_extra->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_extra']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_extra']['involvement'] = $description = $_POST['description'.$i];
					$this->Candidate_extra->create(false);
					$boolUserprocessSaved = $this->Candidate_extra->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_Cv');
					$resume_title = $this->Candidate_Cv->field('resume_title', array('candidatecv_id' => $resumeid));
					$view->set('resume_title',$resume_title);
					$strWidgetListerHtml = $view->element('generalinfoa');
				}
				else
				{
					$this->loadModel('Candidate_Cv');
					$resume_title = $this->Candidate_Cv->field('resume_title', array('candidatecv_id' => $resumeid));
					$view->set('resume_title',$resume_title);
					$strWidgetListerHtml = $view->element('generalinfo');
				}
			}
			
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
	
	public function fnSaveProfAffA($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_prof_affiliation_a');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_prof_affiliation_a']['candidatecv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['aca_profaff_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_prof_affiliation_a->deleteAll(array('candidatecv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['prof_aff_id'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_prof_affiliation_a']['organization_name'] = $organization = $_POST['organization_name'.$i];
					$this->request->data['Candidate_prof_affiliation_a']['year'] = $description = $_POST['date-start'.$i];
					$this->Candidate_prof_affiliation_a->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_affiliation_a->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_prof_affiliation_a']['organization_name'] = $organization = $_POST['organization_name'.$i];
					$this->request->data['Candidate_prof_affiliation_a']['year'] = $description = $_POST['date-start'.$i];
					$this->Candidate_prof_affiliation_a->create(false);
					$boolUserprocessSaved = $this->Candidate_prof_affiliation_a->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_extra');
					$candidateawards = $this->Candidate_extra->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('extra');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveUniService($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_uniservice');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_uniservice']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['uniservice_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_uniservice->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_uniservice']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_uniservice']['jobTitle'] = $description = $_POST['description'.$i];
					//$this->request->data['Candidate_uniservice']['date'] = $description = $_POST['date-start'.$i];
					$this->Candidate_uniservice->create(false);
					$boolUserprocessSaved = $this->Candidate_uniservice->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_uniservice']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_uniservice']['jobTitle'] = $description = $_POST['description'.$i];
					//$this->request->data['Candidate_uniservice']['date'] = $description = $_POST['date-start'.$i];
					$this->Candidate_uniservice->create(false);
					$boolUserprocessSaved = $this->Candidate_uniservice->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_lang');
					$candidateawards = $this->Candidate_lang->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('candidatelang');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnSaveService($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_service');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			
			$this->request->data['Candidate_service']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['service_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_service->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_service']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_service']['jobTitle'] = $description = $_POST['award_name'.$i];
					$this->request->data['Candidate_service']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_service']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_service']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_service']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_service']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_service']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					
					$this->request->data['Candidate_service']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->Candidate_service->create(false);
					$boolUserprocessSaved = $this->Candidate_service->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_service']['company'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_service']['jobTitle'] = $description = $_POST['award_name'.$i];
					$this->request->data['Candidate_service']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_service']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_service']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_service']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_service']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_service']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					
					$this->request->data['Candidate_service']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->Candidate_service->create(false);
					$boolUserprocessSaved = $this->Candidate_service->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_uniservice');
					$candidateawards = $this->Candidate_uniservice->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_prof_exp_id'=>'ASC')),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('uniservice');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	
	public function fnSaveCamp($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_campus');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_campus']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['camp_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_campus->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_campus']['location'] = $award_name = $_POST['amt'.$i];
					$this->request->data['Candidate_campus']['organization'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_campus']['title'] = $description = $_POST['award_name'.$i];
					$this->request->data['Candidate_campus']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_campus']['year'] = $description = $_POST['date-start'.$i];
					$this->Candidate_campus->create(false);
					$boolUserprocessSaved = $this->Candidate_campus->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_campus']['location'] = $award_name = $_POST['amt'.$i];
					$this->request->data['Candidate_campus']['organization'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_campus']['title'] = $description = $_POST['award_name'.$i];
					$this->request->data['Candidate_campus']['date'] = $description = $_POST['date-start'.$i];
					$this->Candidate_campus->create(false);
					$boolUserprocessSaved = $this->Candidate_campus->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_teaching');
					$candidateawards = $this->Candidate_teaching->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('teaching');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	
	public function fnSaveInvites($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_invited');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_invited']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['invited_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_invited->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_invited']['location'] = $award_name = $_POST['amt'.$i];
					$this->request->data['Candidate_invited']['organization'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_invited']['title'] = $description = $_POST['award_name'.$i];
					$this->request->data['Candidate_invited']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_invited']['year'] = $description = $_POST['date-start'.$i];
					$this->Candidate_invited->create(false);
					$boolUserprocessSaved = $this->Candidate_invited->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_invited']['candidate_cv_id']= $resumeid;
					$this->request->data['Candidate_invited']['location']= $_POST['amt'.$i];
					$this->request->data['Candidate_invited']['organization']= $_POST['organization'.$i];
					$this->request->data['Candidate_invited']['title']= $_POST['award_name'.$i];
					$this->request->data['Candidate_invited']['date']= $_POST['date-start'.$i];
					$this->Candidate_invited->create(false);
					$boolUserprocessSaved = $this->Candidate_invited->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_conference');
					$candidateawards = $this->Candidate_conference->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_awards_id'=>'ASC')),false);
					//print("<pre>");
					//print_r($candidateawards);
					//exit;
					
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('conference');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnAddMyGrants($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_grants');
		$arrLoggedUser = $this->Auth->user();
		//$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			$this->request->data['Candidate_grants']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$intEdCnt = $_POST['award_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_grants->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_grants']['funder'] = $award_name = $_POST['award_name'.$i];
					$this->request->data['Candidate_grants']['organization'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_grants']['description'] = $description = $_POST['description'.$i];
					$this->request->data['Candidate_grants']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_grants']['amount'] = $description = $_POST['amt'.$i];
					$this->Candidate_grants->create(false);
					$boolUserprocessSaved = $this->Candidate_grants->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_grants']['candidate_cv_id']= $resumeid;
					$this->request->data['Candidate_grants']['funder']= $_POST['award_name'.$i];
					$this->request->data['Candidate_grants']['organization']= $_POST['organization'.$i];
					$this->request->data['Candidate_grants']['description']= $_POST['description'.$i];
					$this->Candidate_grants->create(false);
					$boolUserprocessSaved = $this->Candidate_grants->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
				$view->set('experienceLevel',$experienceLevel);
				if($strAcademicInfo == "academia")
				{
					//echo "--".$resumeid;
					$this->loadModel('Candidate_invited');
					$candidateawards = $this->Candidate_invited->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'order'=>array('candidate_awards_id'=>'ASC')),false);
					//print("<pre>");
					//print_r($candidateawards);
					//exit;
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('inviteda');
				}
				else
				{
					$this->loadModel('Candidate_Comm_Involve');
					$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					//print("<pre>");
					//print_r($proffsionalaffilations);
					//exit;
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$strWidgetListerHtml = $view->element('community_involvement');
				}
			}
			
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
	
	public function fnAddMyAwards($portalid)
	{
		//Configure::write('debug','2');
		$this->loadModel('Candidate_awards');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_Comm_Involve');
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			
			
			$this->request->data['Candidate_awards']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$intEdCnt = $_POST['award_count'];
			$arrCv = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$strAcademicInfo = $arrCv['Candidate_Cv']['work_history'];
			$this->Candidate_awards->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$awardsid = $_POST['awardsid'.$i];
				if($awardsid)
				{
					$this->request->data['Candidate_awards']['award'] = $award_name = $_POST['award_name'.$i];
					$this->request->data['Candidate_awards']['organization'] = $organization = $_POST['organization'.$i];
					$this->request->data['Candidate_awards']['description'] = $description = $_POST['description'.$i];
					$this->request->data['Candidate_awards']['date'] = $description = $_POST['date-start'.$i];
					$this->request->data['Candidate_awards']['amount'] = $description = $_POST['amt'.$i];
					$this->Candidate_awards->create(false);
					$boolUserprocessSaved = $this->Candidate_awards->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					
					
					/*$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
					$boolUserprocess =  $this->Candidate_awards->updateAll(array('award' => "'$award_name'",'organization' => "'$organization'",'description' => "'$description'"),array('candidate_awards_id' => $awardsid));	
					$arrLoggedUser = $this->Auth->user();
					$view->set('seekerid',$arrLoggedUser['candidate_id']);
					$view->set('resumeid',$resumeid);
					$view->set('candidatecomminvolves',$candidatecomminvolves);
					$view->set('arrLoggedUser',$arrLoggedUser);
					
					$strWidgetListerHtml = $view->element('community_involvement');
					$arrResponse['contactshtml'] = $strWidgetListerHtml;
					if($arrResponse['contactshtml'])
					{
						$arrResponse['status'] = "success";
					}
					
					echo json_encode($arrResponse);
					exit;*/
				}
				else
				{
					
					$this->request->data['Candidate_awards']['candidate_cv_id']= $resumeid;
					$this->request->data['Candidate_awards']['award']= $_POST['award_name'.$i];
					$this->request->data['Candidate_awards']['organization']= $_POST['organization'.$i];
					$this->request->data['Candidate_awards']['description']= $_POST['description'.$i];
					$this->Candidate_awards->create(false);
					$boolUserprocessSaved = $this->Candidate_awards->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
					
					/*$getInsertid_UsersID = $this->Candidate_awards->getLastInsertID();
					if($getInsertid_UsersID>0)
					{
						$arrLoggedUser = $this->Auth->user();
						$view->set('seekerid',$arrLoggedUser['candidate_id']);
						$view->set('resumeid',$resumeid);
						$view->set('arrLoggedUser',$arrLoggedUser);
						
						$strWidgetListerHtml = $view->element('community_involvement');
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
				if($strAcademicInfo == "academia")
				{
					$this->loadModel('Candidate_grants');
					$candidateawards = $this->Candidate_grants->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid),'ORDER'=>array('candidate_awards_id','ASC')),false);
					$view->set('candidateawards',$candidateawards);
					$strWidgetListerHtml = $view->element('grants');
				}
				else
				{
					if($strAcademicInfo == "military")
					{
						$this->loadModel('Candidate_Cv');
						$resume_title = $this->Candidate_Cv->field('resume_title', array('candidatecv_id' => $resumeid));
						$view->set('resume_title',$resume_title);
						$strWidgetListerHtml = $view->element('generalinfom');
					}
					else
					{
						$this->loadModel('Candidate_Comm_Involve');
						$candidatecomminvolves = $this->Candidate_Comm_Involve->find('all',array('conditions'=>array('candidate_cv_id' => $resumeid)),false);
						//print("<pre>");
						//print_r($proffsionalaffilations);
						//exit;
						$view->set('candidatecomminvolves',$candidatecomminvolves);
						$strWidgetListerHtml = $view->element('community_involvement');
					}
					
				}
			}
			
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
	
	
	public function fnAddCommunityInvolvement($portalid)
	{
		$this->loadModel('Candidate_Comm_Involve');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Candidate_Cv');
		$intOperationSuccess = "";
		$intSeekerId = $arrLoggedUser['candidate_id'];	
		$view = new View($this, false);		
		if($_POST)
		{
			
			
			$this->request->data['Candidate_Comm_Involve']['candidate_cv_id'] = $resumeid = $_POST['resumeid'];
			$experienceLevel = $this->Candidate_Cv->find('first',array('conditions'=>array('candidatecv_id' => $resumeid)),false);
			$view->set('experienceLevel',$experienceLevel);
			$intEdCnt = $_POST['comm_count'];
			$this->Candidate_Comm_Involve->deleteAll(array('candidate_cv_id' => $resumeid),false);
			for($i = 1;$i <=$intEdCnt; $i++)
			{
				$comm_involve_id = $_POST['comm_involve_id'.$i];
				if($comm_involve_id)
				{
					$this->request->data['Candidate_Comm_Involve']['organization'] = $organization_name = $_POST['organization_name'.$i];
					$this->request->data['Candidate_Comm_Involve']['city'] = $city = $_POST['city'.$i];
					$this->request->data['Candidate_Comm_Involve']['state'] = $state = $_POST['state'.$i];
					$this->request->data['Candidate_Comm_Involve']['title'] = $title = $_POST['title'.$i];
					$this->request->data['Candidate_Comm_Involve']['dateStart'] = $dateStart = $_POST['date-start'.$i];
					$this->request->data['Candidate_Comm_Involve']['dateEnd'] = $dateEnd = $_POST['date-end'.$i];
					$this->request->data['Candidate_Comm_Involve']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_Comm_Involve']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_Comm_Involve']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_Comm_Involve']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_Comm_Involve']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					$this->request->data['Candidate_Comm_Involve']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_Comm_Involve']['description'] = $_POST['description'.$i];
					//print("<pre>");
					//print_r($this->request->data);
					//exit;
					$this->Candidate_Comm_Involve->create(false);
					$boolUserprocessSaved = $this->Candidate_Comm_Involve->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
				}
				else
				{
					$this->request->data['Candidate_Comm_Involve']['organization']= $_POST['organization_name'.$i];
					$this->request->data['Candidate_Comm_Involve']['city']= $_POST['city'.$i];
					$this->request->data['Candidate_Comm_Involve']['state']= $_POST['state'.$i];
					$this->request->data['Candidate_Comm_Involve']['title']= $_POST['title'.$i];
					$this->request->data['Candidate_Comm_Involve']['dateStart']= $_POST['date-start'.$i];
					$this->request->data['Candidate_Comm_Involve']['dateEnd']= $_POST['date-end'.$i];
					$this->request->data['Candidate_Comm_Involve']['tilldate'] = $toDate = $_POST['tilldate'.$i];
					$this->request->data['Candidate_Comm_Involve']['frommonth'] = $toDate = date("M",strtotime($_POST['dateyear'.$i]."-".$_POST['datemonth'.$i]));
					$this->request->data['Candidate_Comm_Involve']['fromyear'] = $toDate = $_POST['dateyear'.$i];
					if($_POST['dateemonth'.$i] == "13")
					{
						$this->request->data['Candidate_Comm_Involve']['tomonth'] = $toDate = "13";
					}
					else
					{
						$this->request->data['Candidate_Comm_Involve']['tomonth'] = $toDate = date("M",strtotime($_POST['dateeyear'.$i]."-".$_POST['dateemonth'.$i]));
					}
					$this->request->data['Candidate_Comm_Involve']['toyear'] = $toDate = $_POST['dateeyear'.$i];
					$this->request->data['Candidate_Comm_Involve']['description']= $_POST['description'.$i];
					//print("<pre>");
					//print_r($this->request->data);
					//exit;
					$this->Candidate_Comm_Involve->create(false);
					$boolUserprocessSaved = $this->Candidate_Comm_Involve->save($this->request->data);
					if(is_array($boolUserprocessSaved) && (count($boolUserprocessSaved)>0))
					{
						$intOperationSuccess = "1";
					}
				}
			}
			$arrLoggedUser = $this->Auth->user();
			$view->set('seekerid',$arrLoggedUser['candidate_id']);
			$view->set('resumeid',$resumeid);
			$view->set('arrLoggedUser',$arrLoggedUser);
			if($resumeid)
			{
				$this->loadModel('Candidate_Cv');
				$resume_title = $this->Candidate_Cv->field('resume_title', array('candidatecv_id' => $resumeid));
				$view->set('resume_title',$resume_title);
				
			}
			$strWidgetListerHtml = $view->element('generalinfo');
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
	
	
	public function getAddRenameform($intPortalId,$intCvId)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$view = new View($this, false);
		$this->loadModel('CandidateCvDetail');
		$view->set('intPortalId',$intPortalId);
		
		$intCvDetail = $this->CandidateCvDetail->find('first',array('conditions'=>array('id' => $intCvId)),false);
		//$view->set('arrAppointmentNotes',$arrContacts);
		
		$view->set('intCvDetail',$intCvDetail);
		$strWidgetListerHtml = $view->element('cvrename');
		$arrResponse['contactshtml'] = $strWidgetListerHtml;
		if($arrResponse['contactshtml'])
		{
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	
	
	public function getCv($intPortalId,$intContactId = "")
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
				if(is_array($arrContact) && (count($arrContact)>0))
				{
					$arrResponse['status'] = 'success';
					$arrResponse['contact'] = $arrContact[0];
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
	
	public function getCoverhtml($intPortalId = "")
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
			$this->loadModel('CandidateCoverDetail');
			$arrCovervDetail = $this->CandidateCoverDetail->find('all', array(
									'conditions' => array('fk_employer_id'=> $arrLoggedUser['candidate_id'])
								));
								
			$strJobberlandCVUrl = Configure::read('Jobber.seekercvurl')."?portid=".$intPortalId;
			$view = new View($this, false);
			$view->set('arrCovervDetail',$arrCovervDetail);
			$view->set('strseekercvurl',$strJobberlandCVUrl);
			$view->set('intPortalId',$intPortalId);
		
			
			$strCoverHtml = $view->element('coverletter');
			
			if($strCoverHtml)
			{
				$arrResponse['status'] = "success";
				$arrResponse['content'] = $strCoverHtml;
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Missing parameter";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	
	public function course($intPortalId = "",$intCourseId = "")
	{
		$this->layout = "webinardefault";
		
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
				
				
				$this->loadModel('Resourceorderdetail');
				$this->loadModel('Resources');
				$intIsUserEnrolled = $this->Resourceorderdetail->find('count',array('conditions'=>array('product_id'=>$intCourseId,'seeker_id'=>$arrLoggedUser['candidate_id'],'payment_status'=>'captured','order_detail_status'=>'approved')));
				if($intIsUserEnrolled)
				{
					$arrCourseDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$intCourseId)));
					
					$strCourseUrl = Configure::read('Lms.courseview')."?id=".$arrCourseDetail[0]['Resources']['external_content_id']."&candidate_portal_request=".$intPortalId;
					$this->set('strCourseDetailUrl',$strCourseUrl);
				}
				else
				{
					$this->Session->setFlash("You are not enrolled user to access this resources, Please contact owner for the same");
				}
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
        
        public function contactus($intPortalId ='') {
          
        $this->layout = 'defaultnewtheme';
        $arrCurrentUser = $this->Auth->user();
        $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
        $this->loadModel('User');
        $arrUserDetail = $this->User->find('all', array('conditions' => array('id' => $arrPortalDetail[0]['Portal']['career_portal_provider_id'])));
        // shoot email to admin
        $arrPortalOwn = $this->User->fnFindOwnerDetail($arrUserDetail[0]['User']['id']);
                                
                                
        $this->set('arrLoggedInUserDetail', $arrCurrentUser);
        if ($this->request->is('Post')) {
            $arrContactDetail = array();
            $arrContactDetail['name'] = $this->request->data['name'];
            $arrContactDetail['email'] = $this->request->data['email'];
            $arrContactDetail['message'] = $this->request->data['message'];
            $arrContactDetail['subject'] = $this->request->data['subject'];
            $isSent = $this->fnSendAdminPortalContactusEmail($arrUserDetail, $arrPortalDetail[0]['Portal']['career_portal_name'], $arrContactDetail, $arrPortalOwn);
            if ($isSent) {
                $strMssg = "Your request was sent. We will get back to you soon";
                $strMssgClass = "alert-success";
            } else {
                $strMssg = "Some issues, Please try again.";
                $strMssgClass = "alert-error";
            }
            $this->set('strMssg', $strMssg);
            $this->set('strMssgClass', $strMssgClass);
            
        }
    }
}