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
class JsprocessstepsController extends AppController {
	public $components = array('Paginator');
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Jsprocesssteps';
	public $layout = "admin";

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
	
	public function edit($intProductId = "")
	{
		if($intProductId)
		{
			$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/add_product.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tinymce/tiny_mce.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';

			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tmpl.min.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/load-image.all.min.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/canvas-to-blob.min.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
			//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
			//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
			$this->set('strActionScript',$strActionScript);
			$this->set('strDateFormat',Configure::read('Productdate.format'));
			
			$this->loadModel('Categories');
			$this->loadModel('Content');
			$arrProductContent = $this->Categories->find('all',array("conditions"=>array('content_category_id'=>$intProductId)));
			/*print("<pre>");
			print_r($arrProductContent);
			exit;*/
			
			if(is_array($arrProductContent) && (count($arrProductContent)>0))
			{
				foreach($arrProductContent as $arrProductDetail)
				{
					$intMediaId = $arrProductDetail['Categories']['content_cat_icon'];
					if($intMediaId)
					{
						$this->loadModel('ContentMedia');
						$arrContentMedia = $this->ContentMedia->find('all',array('conditions'=>array('content_media_id'=>$intMediaId)));
						$arrProductContent[0]['content_media']['content_media_title'] = $arrContentMedia[0]['ContentMedia']['content_media_title'];
					}
				}
			}
			$arrContD = $this->Content->find('all',array('conditions'=>array('content_default_category'=>$intProductId)));
			if(is_array($arrContD) && (count($arrContD)>0))
			{
				$arrProductContent[0]['Categories']['content_category_description'] = $arrContD[0]['Content']['content'];
				$arrProductContent[0]['Categories']['content_category_introtext'] = $arrContD[0]['Content']['content_intro_text'];
			}
			
			
			$this->set('arrProductContent',$arrProductContent);
		}
	}
	
	public function add()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/add_product.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tinymce/tiny_mce.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';

		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tmpl.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/load-image.all.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/canvas-to-blob.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$this->set('strDateFormat',Configure::read('Productdate.format'));
		
		$this->loadModel('Categories');
		$this->loadModel('Content');
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrResponseData = array();
			$intEditModeId = "";
			$arrContentData = array();
			$strRequestFor = $this->request->data['content_request_for'];
			$strDefaultCate = '0';
			if($this->request->data['content_request_for_id'])
			{
				$strDefaultCate = $this->request->data['content_request_for_id'];
			}
			$arrContentData['Categories']['content_category_name'] = htmlspecialchars(addslashes($this->request->data['content_title']));
			
			
			
			//$arrContentData['Categories']['content_banner_image'] = $this->request->data['banner_image_id'];
			
			$arrContentData['Categories']['content_cat_for_user'] = $this->request->data['content_user'];
			$arrContentData['Categories']['content_cat_icon'] = $this->request->data['banner_image_id'];
			
			//$arrContentData['Categories']['content_published_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['content_pub_date']));
			

			
			$arrContentData['Categories']['content_category_descriptions'] = htmlspecialchars(addslashes($this->request->data['main_content']));
			$arrContentData['Categories']['content_category_introtext'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
			/*if(isset($this->request->data['leftcontent_widgets']))
			{
				$arrContentData['Categories']['left_content_widgets'] = $this->request->data['leftcontent_widgets'];
			}*/
			$intEditModeId = $this->request->data['content_edit_id'];
			
			/*print("<pre>");
			print_r($arrContentData);
			exit;*/
			//echo $intEditModeId;exit;
			
			
			$this->Categories->set($arrContentData);
			if($this->Categories->validates())
			{
				// edit here
				if($intEditModeId)
				{
					$boolContentUpdated = $this->Categories->updateAll(
							array('content_category_name'=>"'".$arrContentData['Categories']['content_category_name']."'",'content_cat_for_user'=>"'".$arrContentData['Categories']['content_cat_for_user']."'",'content_cat_icon'=>"'".$arrContentData['Categories']['content_cat_icon']."'"),
							array('content_category_id =' => $intEditModeId)
						);
					if($boolContentUpdated)
					{
						
						$arrContentData['Content']['content_title'] = $arrContentData['Categories']['content_category_name'];
						$arrContentData['Content']['content_title_alias'] = "Articles";
						$arrContentData['Content']['content_type'] = "1";
						$arrContentData['Content']['content'] = $arrContentData['Categories']['content_category_descriptions'];
						$arrContentData['Content']['content_intro_text'] = $arrContentData['Categories']['content_category_introtext'];
						$arrContentData['Content']['content_for_user'] = $arrContentData['Categories']['content_cat_for_user'];
						$arrContentData['Content']['content_default_category'] = $intCreatedContentId;
						$arrContentData['Content']['content_status']  = "published";
						$boolContentUpdated = $this->Content->updateAll(
							array('content_default_category'=>"'".$intEditModeId."'",'content_title_alias' => "'".$arrContentData['Content']['content_title_alias']."'",'content_title' => "'".$arrContentData['Content']['content_title']."'",'content_intro_text'=>"'".$arrContentData['Content']['content_intro_text']."'",'content'=>"'".$arrContentData['Content']['content']."'",'content_status'=>"'".$arrContentData['Content']['content_status']."'",'content_for_user'=>"'".$arrContentData['Content']['content_for_user']."'",'content_type'=>"'".$arrContentData['Content']['content_type']."'"),
							array('content_default_category =' => $intEditModeId)
						);
						
						$compMessage = $this->Components->load('Message');
						$strForMessage = "You have successfully updated category.";
						
						$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
						$arrResponseData['status'] = 'success';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
					else
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('Some Error, Please try again','error');
						$arrResponseData['status'] = 'fail';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
				}
				else
				{
					$intContentExists = $this->Categories->find('count', array(
									'conditions' => array('content_category_name' => $arrContentData['Categories']['content_title'])
								));
					if($intContentExists)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('This Category is already present','info');
						$arrResponseData['status'] = 'fail';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
					else
					{
						$boolContentCreated = $this->Categories->save($arrContentData);
						if($boolContentCreated)
						{
							$intCreatedContentId = $this->Categories->getLastInsertID();
							
							
							$arrContentData['Content']['content_title'] = $arrContentData['Categories']['content_category_name'];
							$arrContentData['Content']['content_title_alias'] = "Articles";
							$arrContentData['Content']['content_type'] = "1";
							$arrContentData['Content']['content'] = $arrContentData['Categories']['content_category_descriptions'];
							$arrContentData['Content']['content_intro_text'] = $arrContentData['Categories']['content_category_introtext'];
							$arrContentData['Content']['content_for_user'] = $arrContentData['Categories']['content_cat_for_user'];
							$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s');
							$arrContentData['Content']['content_default_category'] = $intCreatedContentId;
							$arrContentData['Content']['content_status']  = "published";
							
							$arrRes = $this->Content->save($arrContentData);
							
							$arrResponseData['createdid'] = $intCreatedContentId;
							$arrResponseData['status'] = 'success';
						}
						$compMessage = $this->Components->load('Message');
						$strForMessage = "You have successfully added category.";
						$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
				}
			}
			else
			{
				$strContentCreationErrorMessage = "<br>";
				$arrContentCreationErrors = $this->Categories->invalidFields();
				if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
				{
					$intForIterateCount = 0;
					foreach($arrContentCreationErrors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount == 1)
						{
							$strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
						}
					}
				}
				if($strContentCreationErrorMessage)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
				}
				$arrResponseData['status'] = "fail";
				$arrResponseData['message'] = $strMessage;
				
				echo json_encode($arrResponseData);exit;
			}
		}
		
		$arrCategories = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_name'),'ORDER'=>array('content_category_id'=>'ASC')));
		$this->set('arrCategories',$arrCategories);
	}
	
	public function jssteps($intPortalId = "",$strFurtherElement = "",$intFurtherElementParent = "")
	{
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$this->loadModel('Portal');
			
			$this->loadModel('Categories');
			/*$arrJobSearchProcessPhases = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>'phase'),'order'=>array('job_search_order'=>'ASC')));*/
			
			$arrJobSearchProcessSteps = $this->Categories->find('all',array('conditions'=>array('job_process_type'=>$strFurtherElement,'content_category_parent_id'=>$intFurtherElementParent),'order'=>array('job_search_order'=>'ASC')));
			
			//$this->set('arrJobSearchProcessPhases',$arrJobSearchProcessSteps);
			if(is_array($arrJobSearchProcessSteps) && (count($arrJobSearchProcessSteps)>0))
			{
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
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = "There is a parameter missing, wrong request.";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contentsearch($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'jsprocessphase','action'=>'contentsearch'),true));
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('content_title'=>$strKeywordSearch,'category'=>"0","No"=>"2")
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('Content');
		/*print("<pre>");
		print_r($arrProductContentList);exit;*/
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			/*$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Content->find('count',array('conditions'=>array('content_parent_id'=>$arrProductContent['content']['content_id'])));
				if($isContentParent)
				{
					$arrProductContentList[$intProductCount]['haschild'] = "1"; 
				}
				$intProductCount++;
			}*/
		}
		$this->set('arrProductList',$arrProductContentList);
		$this->set('strKeywordSearch',$strKeywordSearch);
	
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no products with provided title','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function content() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'contentcategories','action'=>'content'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'jsprocessphase','action'=>'contentsearch',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('category'=>"0",'No'=>'2')
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('Content');
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Content->find('count',array('conditions'=>array('content_parent_id'=>$arrProductContent['content']['content_id'])));
				if($isContentParent)
				{
					$arrProductContentList[$intProductCount]['haschild'] = "1"; 
				}
				$intProductCount++;
			}
		}
		
		$this->set('arrProductList',$arrProductContentList);
		
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no content present, Please add one','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function search($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index_cat.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'jsprocesssteps','action'=>'search'),true));
		$this->loadModel('Categories');
		$arrProductContents = $this->Categories->find('all',array("conditions"=>array("content_category_name LIKE" => "%".$strKeywordSearch."%"),"order"=>array('content_category_id'=>'DESC')));
		
		//print("<pre>");
		//print_r($arrProductContents);
		//exit;
		$this->Paginator->settings = array(
			'conditions' => array("content_category_name LIKE"=> "%".$strKeywordSearch."%",'job_search_category'=>'1','job_process_type'=>'Steps'),
			'order' => array('content_category_id' => 'DESC'),
			'limit' => 20
		);
		
		$arrProductContentList = $this->Paginator->paginate('Categories');
		//$arrProductContentList = $arrProductContents;
		/*print("<pre>");
		print_r($arrProductContentList);exit;*/
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			/*$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Content->find('count',array('conditions'=>array('content_parent_id'=>$arrProductContent['content']['content_id'])));
				if($isContentParent)
				{
					$arrProductContentList[$intProductCount]['haschild'] = "1"; 
				}
				$intProductCount++;
			}*/
		}
		$this->set('arrProductList',$arrProductContentList);
		$this->set('strKeywordSearch',$strKeywordSearch);
	
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no Steps with provided title','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function index() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index_cat.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'jsprocesssteps','action'=>'index'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'jsprocesssteps','action'=>'search',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Categories');
		/*$this->Categories->recursive = 0;
		$this->Paginator->settings = array(
			'Categories' => array(
				'limit' => 20,
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('Categories',array('content_id'=>"2"));*/
		
		$arrProductContents = $this->Categories->find('all',array("order"=>array('content_category_id'=>'DESC')));
		
		$this->Paginator->settings = array(
			'conditions' => array('job_search_category'=>'1','job_process_type'=>'Steps'),
			'order' => array('content_category_name' => 'ASC'),
			'limit' => 20
		);
		
		$arrProductContentList = $this->Paginator->paginate('Categories');
		
		
		
		
		
		/*if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Content->find('count',array('conditions'=>array('content_parent_id'=>$arrProductContent['content']['content_id'])));
				if($isContentParent)
				{
					$arrProductContentList[$intProductCount]['haschild'] = "1"; 
				}
				$intProductCount++;
			}
		}*/
		//print("<pre>");
		//print_r($arrProductContentList);
		//exit;
		$this->set('arrProductList',$arrProductContentList);
		
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no steps present, Please add one','info');
			$this->set('strMessage',$strMessage);
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
