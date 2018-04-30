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
class PrivatelabelsitesController extends AppController 
{
	public $components = array('Paginator');
	
	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Privatelabelsites';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('libcatwebdetail');
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
	
	public function libcatdetail($intCatDetailId = "")
	{
		$arrContentType = array("1"=>"article","2"=>"webinars");
		$intUserType = "2";
		$intContentType = "1";
		$this->set('intCatDetailId',$intCatDetailId);
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
			print_r($arrCatContentTitles);
			
			print("<pre>");
			print_r($arrCatContent);
			exit;*/
			
			/*print("<pre>");
			print_r(array_merge($arrCatContent,$arrCatContentSub));
			exit;*/
		
			$this->set('arrCatContentTitles',$arrCatContentTitles);			
			$this->set('arrCatContent',$arrCatContent);
		}
		
		
		$arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
		/*print("<pre>");
		print_r($arrContentTypeList);
		exit;*/
		$this->set('arrContentTypeList',$arrContentTypeList);
		$this->set('arrContentType',$arrContentType);
		$arrContentListArticle = $this->Content->fnGetContentList($intCatDetailId,$intContentType,$intUserType);
		$this->set('arrContentListArticle',$arrContentListArticle);
		$this->set('strArticleDetailUrl',Router::url(array('controller'=>'privatelabelsites','action'=>'articledetail'),true));
		//$this->set('strReturnUrl',Router::url(array('controller'=>'privatelabelsites','action'=>'library'),true));
	}
	
	public function libcatwebdetail($intPortalId = "",$intCatDetailId = "",$strContentType = "article",$intOnNewTab = "0")
	{
		$arrContent = array("1"=>"article","2"=>"webinars");
		$intUserType = "3";
		$intContentType = "1";
		$intContentType = array_search($strContentType,$arrContent);
		$view = new View($this, false);
		$arrShopDetails = array();
		
		$this->loadModel('Categories');
		$arrCatDetail = $this->Categories->find('all',array('conditions'=>array('content_category_id'=>$intCatDetailId,'content_cat_for_user'=>$intUserType)));
		//print("<pre>");
		//print_r($arrCatDetail);
		$view->set('arrCatDetail',$arrCatDetail);
		
		$this->loadModel('Content');
		$arrContentTypeList = $this->Content->fnGetDistinctContentType($intCatDetailId,$intUserType);
		$view->set('arrContentTypeList',$arrContentTypeList);
		$view->set('arrContentType',$arrContentType);
		$arrContentListWebinars = $this->Content->fnGetContentList($intCatDetailId,$intContentType,"2");
		
		$view->set('arrContentListArticle', $arrContentListWebinars);
		$view->set('strArticleDetailUrl',Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId),true));
		$view->set('strTypeBlock',$arrContent[$intContentType]);
		if($intOnNewTab)
		{
			$view->set('intContentonNewtab',"1");
		}

		$strSubCatHtml = $view->element('article_list');
		//$strSubCatHtml = $view->element('article_list_new');
		if($strSubCatHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strSubCatHtml;
			$arrResponse['contenthtmlid'] = $intContentType;
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
	
	public function articledetail($intArticleId = "")
	{
		if($intArticleId)
		{
			$this->loadModel('Content');
			$arrContentDetail = $this->Content->find('all',array('conditions'=>array('content_id'=>$intArticleId,'content_status'=>'published')));
			$this->set('arrContentDetail',$arrContentDetail);
			
			$arrCatContentTitles = $this->Content->find('list',array('fields'=>array('content_id','content_type'),'conditions'=>array('content_parent_id'=>$intArticleId),"ORDER"=>array('content_id'=>"ASC")));
			//print("<pre>");
			//print_r($arrCatContentTitles);
			
			$this->set('arrCatContentTitles',$arrCatContentTitles);	
		}		
	}
	
	public function library()
	{
		
		
		//echo "Hello";
		$this->loadModel('Categories');
		$arrLibCatDetail = $this->Categories->find('all',array('conditions'=>array('content_cat_for_user'=>'2','job_search_category'=>'0')));
		//print("<pre>");
		//print_r($arrLibCatDetail);
		//exit;
		/*if(is_array($arrLibCatDetail) && (count($arrLibCatDetail)>0))
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
		}*/
		
		$this->set('arrLibCatDetail',$arrLibCatDetail);
	}		public function pages()	{		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		$this->set('strCurrentUser',$strCurrentUser);			}		
	
	public function candidatedetail($intCandidateId = "")
	{
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		$this->loadModel('Candidate');
		$this->loadModel('Candidate_Cv');
		$arrCandidate = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$intCandidateId)));
		if(is_array($arrCandidate) && (count($arrCandidate)>0))
		{
			foreach($arrCandidate as $arrCand)
			{
								
				$arrCvDetail = $this->Candidate_Cv->find('all', array(
										'conditions' => array('candidate_id'=> $intCandidateId)
									));
				$arrCandidate[0]['Candidate']['cvs'] = $arrCvDetail;
			}
		}
		$this->set('intPortalId',$strCurrentUser['portal_id']);
		$this->set('seekerid',$arrCandidate[0]['Candidate']['candidate_id']);
		$this->set('arrCandidate',$arrCandidate);
		
		
		
		//print("<pre>");
		//print_r($arrCandidate);
		//exit;
	}
	
	public function candidates()	
	{		
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		//print("<pre>");
		//print_r($strCurrentUser);
		$this->loadModel('Candidate');
		$arrCandidate = $this->Candidate->find('all',array('conditions'=>array('career_portal_id'=>$strCurrentUser['portal_id'])));
		
		$this->Paginator->settings = array(
			'conditions' => array('career_portal_id'=>$strCurrentUser['portal_id']),
			'order' => array('candidate_id' => 'DESC'),
			'limit' => 20
		);
		
		$arrCandidate = $this->Paginator->paginate('Candidate');
		
		$this->set('arrCandidate',$arrCandidate);
		//print("<pre>");
		//print_r($arrCandidate);
		//exit;
	}		
	
	public function applications()	
	{		
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		
		//print("<pre>");
		//print_r($strCurrentUser);
		
		
		$this->loadModel('JobsApplied');
		/*$arrApplications = $this->JobsApplied->find('all',array('conditions'=>array('job_portal_id'=>$strCurrentUser['portal_id'])));*/
		
		$this->Paginator->settings = array(
			'conditions' => array('job_portal_id'=>$strCurrentUser['portal_id']),
			'order' => array('job_application_id' => 'DESC'),
			'limit' => 20
		);
		
		$arrApplications = $this->Paginator->paginate('JobsApplied');
		
		print("<pre>");
		print_r($arrApplications);
		
		if(is_array($arrApplications) && (count($arrApplications)>0))
		{
			$this->loadModel('Candidate');
			$this->loadModel('Candidate_Cv');
			$this->loadModel('Job');
			$intFrCnt = 0;
			foreach($arrApplications as $arrApp)
			{
				$arrJobDetail = $this->Job->find('all',array('conditions'=>array('id'=>$arrApp['JobsApplied']['job_id'])));
				$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrApp['JobsApplied']['candidate_id'])));
				$arrCandidateCvDetail = $this->Candidate_Cv->find('all',array('conditions'=>array('candidatecv_id'=>$arrApp['JobsApplied']['candidate_cv_id'])));
				if(is_array($arrJobDetail) && (count($arrJobDetail)>0))
				{
					$arrApplications[$intFrCnt]['JobsApplied']['jobdetail'] = $arrJobDetail;
				}
				
				if(is_array($arrCandidateDetail) && (count($arrCandidateDetail)>0))
				{
					$arrApplications[$intFrCnt]['JobsApplied']['candtail'] = $arrCandidateDetail;
				}
				
				if(is_array($arrCandidateCvDetail) && (count($arrCandidateCvDetail)>0))
				{
					$arrApplications[$intFrCnt]['JobsApplied']['candcvdetail'] = $arrCandidateCvDetail;
				}
				
				$intFrCnt++;
			}
		}
		
		//print("<pre>");
		//print_r($arrApplications);
		
		$this->set('arrApplications',$arrApplications);
		$this->set('intPortalId',$strCurrentUser['portal_id']);
		$this->set('seekerid',$arrCandidate[0]['Candidate']['candidate_id']);
		
	}		
	
	public function events()	
	{				
		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
		$this->set('strCurrentUser',$strCurrentUser);
		$this->loadModel('Content');
		$arrContentListArticle = $this->Content->find('all',array('conditions'=>array('content_type'=>'2','content_for_user'=>'2'),'order' => array('content_id' => 'DESC')));
		
		$this->set('arrContentListArticle',$arrContentListArticle);
		
		//print("<pre>");
		//print_r($arrContentListArticle);
		//exit;
	}
	
	public function index()
	{		$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		$this->set('strCurrentUser',$strCurrentUser);
		
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$arrPortals = $this->Portal->find('all',array("conditions"=>array('career_portal_provider_id'=>$arrLoggedUserDetails['id']),
													  "order"=>array('career_portal_created_datetime'=>'DESC')));
		
		$this->Paginator->settings = array(
			'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id']),
			'order' => array('career_portal_id' => 'DESC'),
			'limit' => 10
		);
		
		$arrPortals = $this->Paginator->paginate('Portal');
		$this->set('arrPortals',$arrPortals);
		$this->set('intLoggedInUserId',$arrLoggedUserDetails['id']);
	}
	
	public function resizeImage($source_image, $target_image, $target_width, $target_height)
	{
		// check if we have valid target width and height
		if ($target_width <= 0 && $target_height <= 0)
		{
			trigger_error("resizeImage(): Invalid target width or height", E_USER_ERROR);
			return false;
		}
		
		// detect source image type from extension
		$source_file_name = basename($source_image);
		$source_image_type = substr($source_file_name, -3, 3);
		
		// create an image resource from the source image  
		switch(strtolower($source_image_type))
		{
			case 'jpg':
				$original_image = imagecreatefromjpeg($source_image);
				break;
				
			case 'gif':
				$original_image = imagecreatefromgif($source_image);
				break;

			case 'png':
				$original_image = imagecreatefrompng($source_image);
				break;    
			
			default:
				trigger_error("resizeImage(): Invalid image type", E_USER_ERROR);
				return false;
		}
		
		// detect source width and height
		list($source_width, $source_height) = getimagesize($source_image);
		
		// if target height or width is not specified, calculate it as per the aspect ratio 
		if ($target_height <= 0)
		{
			$target_height = ($source_height/$source_width) * $target_width;
		}
		if ($target_width <= 0)
		{
			$target_width = ($source_width/$source_height) * $target_height;
		}
		
		// create a blank image with target width and height
		// this will be our resized image
		$resized_image = imagecreatetruecolor($target_width, $target_height);
		
		// copy the source image to the blank image created above
		imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, 
						   $target_width, $target_height, $source_width, $source_height); 
		
		// detect target image type from extension
		$target_file_name = basename($target_image);
		$target_image_type = substr($target_file_name, -3, 3);
		
		// save the resized image to disk
		switch(strtolower($target_image_type))
		{
			case 'jpg':
				imagejpeg($resized_image, $target_image, 100);
				break;
				
			case 'gif':
				imagegif($resized_image, $target_image);
				break;

			case 'png':
				imagepng($resized_image, $target_image, 0);
				break;    
			
			default:
				trigger_error("resizeImage(): Invalid target image type", E_USER_ERROR);
				imagedestroy($resized_image);
				imagedestroy($original_image);
				return false;
		}
		
		// free resources
		imagedestroy($resized_image);
		imagedestroy($original_image);
		
		return true;
	}

	public function create()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/* App::import('Vendor', 'ImageTool'); */
		$this->loadModel('Portal');
		$this->set('intAllowedToCreatePortal','1');
		$intPortalCreated = $this->Portal->find('count',array('conditions'=>array('career_portal_created_by'=>$arrLoggedUserDetails['id'])));
		//$intPortalCreated = 0;
		if($intPortalCreated)
		{
			$this->set('intAllowedToCreatePortal','0');
			$this->Session->setFlash('You are not permitted to create Portals');
		}
		else
		{
			if($this->request->is('post'))
			{
				$this->request->data['Portal']['career_portal_name'] = addslashes(trim($this->request->data['Portal']['portal_name']));
				$this->request->data['Portal']['career_portal_logo'] = $this->request->data['Portal']['portal_logo']['name'];
				$this->request->data['Portal']['career_portal_provider_id'] = $arrLoggedUserDetails['id'];
				$this->request->data['Portal']['career_portal_created_by'] = $arrLoggedUserDetails['id'];
				
				$this->Portal->set($this->request->data);
				if($this->Portal->validates())
				{
					$intPortalExists = $this->Portal->find('count', array(
										'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_name'=> $this->request->data['Portal']['career_portal_name'])
									));
					if($intPortalExists)
					{
						$this->Session->setFlash('Portal already exists with provided portal name');
					}
					else
					{
						$this->request->data['Portal']['career_portal_logo'] = $this->fnGeneratePortalName($this->request->data['Portal']['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
						$this->request->data['Portal']['career_portal_thumb_logo'] = $this->fnGeneratePortalThumbLogo($this->request->data['Portal']['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
						$boolPortalCreated = $this->Portal->save($this->request->data);
						if($boolPortalCreated)
						{
							$intCreatedPortalId = $this->Portal->getLastInsertID();
							move_uploaded_file($this->request->data['Portal']['portal_logo']['tmp_name'], WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo']);
							
							$input_file =  WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo'];
							$output_file = WWW_ROOT . 'userdata/portal/' . $this->fnGeneratePortalThumbLogo($this->request->data['Portal']['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
							$this->resizeImage($input_file, $output_file, '100', '40');
							
							// relate portal id to the owner
							$this->loadModel('User');
							$boolUpdated = $this->User->updateAll(
								array('portal_id' => "'".$intCreatedPortalId."'"),
								array('id' => $arrLoggedUserDetails['id'])
							);
							
							// create and set default forms for portal
							$compPortalForm = $this->Components->load('PortalFormsCreator');
							$arrCreatedPortalForm = $compPortalForm->fnCreateDefaultPortalForms($intCreatedPortalId);
							//exit;
							
							// create default pages and menus for portal
							$compPortalPages = $this->Components->load('PortalPages');
							$arrPortalPages = $compPortalPages->fnCreateDefaultPortalPagesMenus($intCreatedPortalId);
							
							// create and set default theme for portal
							$compPortalTheme = $this->Components->load('PortalTheme');
							$arrAllocatedDefaultTheme = $compPortalTheme->fnSetDefaultTheme($intCreatedPortalId);
							
							
							
							// create default LMS course category and assign role in the category
							$compLmsBridge = $this->Components->load('LmsBridge');
							$arrEmployerSetup = array();
							$arrEmployerSetup['categoryname'] = $this->request->data['Portal']['career_portal_name'];
							$arrEmployerSetup['username'] = $arrLoggedUserDetails['email'];
							$arrEmployerSetup['portalid'] = $intCreatedPortalId;
							$arrLmsEmployerSetupOperation = $compLmsBridge->fnSetEmployerInMoodle($arrEmployerSetup);
							
							$this->Session->setFlash('Portal created successfully','default',array('class' => 'success'));
							$this->redirect(array('action'=>'index'));
						}
					}
				}
				else
				{
					$strPortalCreationErrorMessage = "";
					$arrPortalCreationErrors = $this->Portal->invalidFields();
					if(is_array($arrPortalCreationErrors) && (count($arrPortalCreationErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrPortalCreationErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strPortalCreationErrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strPortalCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
					}
					$this->Session->setFlash($strPortalCreationErrorMessage);
				}
			}
		}
	}
	
	public function delete($intPortalId = "")
	{
		if($intPortalId)
		{
			$this->loadModel('Portal');
			$intPortalDeleted = $this->Portal->deleteAll(array('Portal.career_portal_id' => $intPortalId),false);
			if($intPortalDeleted)
			{
				$this->Session->setFlash('Portal deleted successfully','default',array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			}
		}
		else
		{
			$this->redirect(array('action'=>'index'));
		}
	}
	
	public function edit($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$this->loadModel('Portal');
			
			if($this->request->is('post'))
			{
				$this->request->data['Portal']['career_portal_name'] = addslashes(trim($this->request->data['Portal']['portal_name']));
				if($this->request->data['Portal']['portal_logo']['name'])
				{
					$this->request->data['Portal']['career_portal_logo'] = $this->request->data['Portal']['portal_logo']['name'];
				}
				
				$this->request->data['Portal']['career_portal_provider_id'] = $arrLoggedUserDetails['id'];
				$this->request->data['Portal']['career_portal_created_by'] = $arrLoggedUserDetails['id'];
				$intPostedPortalId = $this->request->data['Portal']['portal_id'];
				$strExistingPortalImage = $this->request->data['Portal']['portal_image'];
				$strExistingPortalThumbImage = $this->request->data['Portal']['portal_thumb_image'];
				
				$this->Portal->set($this->request->data);
				if($this->Portal->validates(array('fieldList' => array('career_portal_name'))))
				{					
					if($this->request->data['Portal']['portal_logo']['name'])
					{
						$this->request->data['Portal']['career_portal_logo'] = $this->fnGeneratePortalName($this->request->data['Portal']['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
						$this->request->data['Portal']['career_portal_thumb_logo'] = $this->fnGeneratePortalThumbLogo($this->request->data['Portal']['portal_logo']['name'],$this->request->data['Portal']['career_portal_name'],$arrLoggedUserDetails['id']);
						$boolUpdated = $this->Portal->updateAll(
								array('Portal.career_portal_thumb_logo' => "'".$this->request->data['Portal']['career_portal_thumb_logo']."'",'Portal.career_portal_name' => "'".$this->request->data['Portal']['career_portal_name']."'",'Portal.career_portal_logo'=>"'".$this->request->data['Portal']['career_portal_logo']."'"),
								array('Portal.career_portal_id =' => $intPostedPortalId)
							);
					}
					else
					{
						$boolUpdated = $this->Portal->updateAll(
								array('Portal.career_portal_name' => "'".$this->request->data['Portal']['career_portal_name']."'"),
								array('Portal.career_portal_id =' => $intPostedPortalId)
							);
					}					
					if($boolUpdated)
					{
						if($this->request->data['Portal']['portal_logo']['name'])
						{
							unlink(WWW_ROOT.'/userdata/portal/'.$strExistingPortalImage);
							unlink(WWW_ROOT.'/userdata/portal/'.$strExistingPortalThumbImage);
							move_uploaded_file($this->request->data['Portal']['portal_logo']['tmp_name'], WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo']);
							$input_file =  WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_logo'];
							$output_file = WWW_ROOT . 'userdata/portal/' . $this->request->data['Portal']['career_portal_thumb_logo'];
							$this->resizeImage($input_file, $output_file, '100', '40');			
						}
						$this->Session->setFlash('Portal Updated successfully','default',array('class' => 'success'));
						$this->redirect(array('action'=>'index'));
					}
				}
				else
				{
					$strPortalUpdationErrorMessage = "";
					$arrPortalUpdationErrors = $this->Portal->invalidFields();
					if(is_array($arrPortalUpdationErrors) && (count($arrPortalUpdationErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrPortalUpdationErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strPortalUpdationErrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strPortalUpdationErrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
					}
					$this->Session->setFlash($strPortalUpdationErrorMessage);
				}
				
			}
			
			
			$arrPortalDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_id'=>$intPortalId)));
			$this->set('arrPortals',$arrPortalDetail);
		}
		else
		{
			$this->redirect(array('action'=>'index'));
		}
	}
	
	public function viewpage($intPageId)
	{
		//echo "--".$this->layout;
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		//print("<pre>");
		//print_r($arrPageDetail);
		//exit;
		$arrLoggedUserDetails = $this->Auth->user();
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
	
	public function gettemplatecontent($intTemplateId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intTemplateId)
		{
			$this->loadModel('Portalpagetemplates');
			$arrPortalPageTemplateData = $this->Portalpagetemplates->find('all',array('conditions'=>array('career_portal_page_template_id'=>$intTemplateId)));
			
			if(is_array($arrPortalPageTemplateData) && (count($arrPortalPageTemplateData)>0))
			{
				$arrResponse['status'] = 'success';
				$arrResponse['templatecontent'] = htmlspecialchars_decode($arrPortalPageTemplateData['0']['Portalpagetemplates']['career_portal_page_content']);
				$arrResponse['templatetitle'] = $arrPortalPageTemplateData['0']['Portalpagetemplates']['career_portal_page_tittle'];
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = "No Such template exists";
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = "Bad request, something is missing";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function view($intPortalId)
	{
		//echo $this->layout;
		
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
		
		if($intPortalExists)
		{
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
			
			$this->set('arrPortalDetail',$arrPortalDetail);
			
			// load portal theme and its details
			$this->loadModel('PortalTheme');
			$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPortalId);
			if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
			{
				$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
			}
			
			// load portal theme widgets
			$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
			$this->loadModel('PortalThemeWidgets');
			//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
			$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId,$intPortalId);
			/* print("<pre>");
			print_r($arrPortalThemeWidgets); */
			
			if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
			{
				$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
			}
			
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
			
			$arrPortalHomePageDetail = $this->PortalPages->find('all',array(
									'conditions' => array('career_portal_id' => $intPortalId,'is_career_portal_home_page'=> '1')
								));
			$this->set('arrPortalPageDetail',$arrPortalHomePageDetail);
			
			// load contact form if present
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
				$this->set('arrContactFormDetail',$arrContactFormDetail);
			}
			
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
		else
		{
		
		}
		
	}
	
	public function registereditor($intPortalId)
	{
		$this->layout = "viewportaldefault";
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
								
		if($intPortalExists)
		{
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
			
			$this->set('arrPortalDetail',$arrPortalDetail);
			$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				// load portal theme and its details
				$this->loadModel('PortalTheme');
				$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPortalId);
				if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
				{
					$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
				}
				
				$this->loadModel('TopMenu');
				$arrMenuDetail = $this->TopMenu->find('all',array("order"=>array('career_portal_menu_order'=>'ASC'),'conditions'=>array('career_portal_id'=>$intPortalId),));
				/* print("<pre>");
				print_r($arrMenuDetail); */
				$this->set('arrPortalMenuDetail',$arrMenuDetail);
				
				$this->loadModel('PortalRegistration');
				$arrPortalRegistration = $this->PortalRegistration->find('all', array(
																'conditions' => array('career_portal_id'=> $intPortalId,'career_registration_form_is_active'=>'1')
															));
															
				$this->loadModel('RegistrationFormFields');
				$arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
				/* print('<pre>');
				print_r($arrRegistrationFieldDetail); */
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
						$intForEachCount++;
					}
				}
								
				$this->loadModel('SocialMedialPlugin');
				$arrSocialMediaPlugin = $this->SocialMedialPlugin->find('all',array('conditions'=>array('social_media_plugin_type'=>'register','social_media_plugin_isactive'=>'1')));
				$intSocialAllocatedForIterateCount = 0;
				foreach($arrSocialMediaPlugin as $arrPlugin)
				{
					$this->loadModel('RegistrationSocialMedialField');
					$boolIsFieldAllocated = $this->RegistrationSocialMedialField->find('count',array('conditions'=>array('career_portal_registration_form_id'=>$arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id'],'career_portal_registration_social_plugin_id'=>$arrPlugin['SocialMedialPlugin']['social_media_plugin_id'])));
					if($boolIsFieldAllocated)
					{
						$arrSocialMediaPlugin[$intSocialAllocatedForIterateCount]['SocialMedialPlugin']['field_allocated'] = "1";
					}
					else
					{
						$arrSocialMediaPlugin[$intSocialAllocatedForIterateCount]['SocialMedialPlugin']['field_allocated'] = "0";
					}
					$intSocialAllocatedForIterateCount++;
				}
				$this->set('arrRegistrationSocialPluginData',$arrSocialMediaPlugin);
				
				/* if($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_is_social_media'])
				{
					//$this->loadModel('RegistrationSocialMedialField');
					//$arrSetRegistrationSocialFields = $this->RegistrationSocialMedialField->fnGetSocialMediaFieldDetail($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
					print("<pre>");
					print_r($arrSetRegistrationSocialFields);
					
					//$this->set('arrRegistrationSocialPluginData',$arrSetRegistrationSocialFields);
					$this->set('arrRegistrationSocialPluginData',$arrSocialMediaPlugin);
				} */
				
				$this->set('intPortalId',$intPortalId);
				$this->set('arrRegistrationForm',$arrPortalRegistration);
				$this->set('arrRegistrationFieldDetail',$arrCompleteRegistrationFieldDetail);
			}			
		}
		
	}
	
	public function editor($intPortalId)
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Theme');
		
		$arrThemeData = $this->Theme->find('all');
		/* print("<pre>");
		print_r($arrThemeData); */
		
		$this->set('arrThemeData',$arrThemeData);
		$this->set('portal_id',$intPortalId);
	}
}