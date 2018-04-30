<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

class ContentcategoriesController extends AppController {
	public $components = array('Paginator');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = "admin";
	public $name = 'Contentcategories';
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		parent::beforeFilter();
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
 
	public function preview($intPortalId = "",$intProductId = "")
	{
		$this->layout = "contentarticlepreview";
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
			if($intProductId)
			{
				$this->loadModel('Content');
				$arrContentDetail = $this->Content->find('all',array('conditions'=>array('content_id'=>$intProductId)));
				$this->set('arrContentDetail',$arrContentDetail);
				
				/*if($arrContentDetail[0]['Content']['content_featured_image'])
				{
				$this->loadModel('ContentMedia');
					$arrFeaturedImg = $this->ContentMedia->find('all',array('conditions'=>array('content_media_id'=>$arrContentDetail[0]['Content']['content_featured_image'])));
					$this->set('arrFeaturedImg',$arrFeaturedImg);
				}*/
				/*if($arrContentDetail[0]['Content']['content_banner_image'])
				{
					$this->loadModel('ContentMedia');
					$arrBannerImageDetail = $this->ContentMedia->find('all',array('conditions'=>array('content_media_id'=>$arrContentDetail[0]['Content']['content_banner_image'])));
					$this->set('arrBannerImageDetail',$arrBannerImageDetail);
				}
				else
				{
					if($arrContentDetail[0]['Content']['content_parent_id'])
					{
						$arrParentContentDetails = $this->Content->find('all',array('conditions'=>array('content_id'=>$arrContentDetail[0]['Content']['content_parent_id'])));
						$this->loadModel('ContentMedia');
						$arrBannerImageDetail = $this->ContentMedia->find('all',array('conditions'=>array('content_media_id'=>$arrParentContentDetails[0]['Content']['content_banner_image'])));
						$this->set('arrBannerImageDetail',$arrBannerImageDetail);
					}
				}
				$isParent=false;
				$mailTO=false;
				$parentTo="";
				if($arrContentDetail[0]['Content']['content_parent_id'])
				{
					$this->set('isParent',true);
					$intProductMenuId = $arrContentDetail[0]['Content']['content_parent_id'];
					$arrContentMenu = $this->Content->find('list',array('fields'=>array('content_title_alias','content_id'),'conditions'=>array('content_parent_id'=>$intProductMenuId)));
					if(is_array($arrContentMenu) && (count($arrContentMenu)>0))
					{
						$arrParentContentDetail = $this->Content->find('all',array('fields'=>array('content_id','content_title_alias','content_title','cont_contact_cc','cont_contact_to'),'conditions'=>array('content_id'=>$intProductMenuId)));
						$arrContentMenu[$arrParentContentDetail[0]['Content']['content_title_alias']] = $arrParentContentDetail[0]['Content']['content_id'];
						if ($arrParentContentDetail[0]['Content']['cont_contact_to'])
						{
							$mailTO=true;
							$this->set('parentTo',$arrParentContentDetail[0]['Content']['cont_contact_to']);
							//echo '<script>alert("yes '.$arrParentContentDetail[0]['Content']['cont_contact_to'].'");</script>';
					//exit;
						}
						$arrContentMenu = array_unique($arrContentMenu);
						asort($arrContentMenu);
						$this->set('arrContentMenu',$arrContentMenu);
						$this->set('productName',$arrParentContentDetail[0]['Content']['content_title']);
					}
				}
				else
				{
					$isParent=false;
					$intProductMenuId = $arrContentDetail[0]['Content']['content_id'];
					if ($arrContentDetail[0]['Content']['cont_contact_to'])
						{
							$mailTO=true;
						}
					$arrContentMenu=array();
					$intProductMenuId = $arrContentDetail[0]['Content']['content_id'];
					$arrContentMenu = $this->Content->find('list',array('fields'=>array('content_title_alias','content_id'),'conditions'=>array('content_parent_id'=>$intProductMenuId)));
					if(is_array($arrContentMenu) && (count($arrContentMenu)>0))
					{
						$arrContentMenu[$arrContentDetail[0]['Content']['content_title_alias']] = $arrContentDetail[0]['Content']['content_id'];
						asort($arrContentMenu);
						$this->set('arrContentMenu',$arrContentMenu);
						$this->set('productName',$arrContentDetail[0]['Content']['content_title']);
					}
					else
					{
					/* $arrContentMenu[$arrContentDetail[0]['Content']['content_title_alias']] = $arrContentDetail[0]['Content']['content_id'];
					 asort($arrContentMenu);
					 $this->set('arrContentMenu',$arrContentMenu);
					 $this->set('productName',$arrContentDetail[0]['Content']['content_title']);*/
					/*}
				}
				$content_id="";
				if($arrContentDetail[0]['Content']['content_parent_id'])
				{
					$content_id=$arrContentDetail[0]['Content']['content_parent_id'];
					$this->set('content_id',$arrContentDetail[0]['Content']['content_parent_id']);
				}
				else
				{
					$content_id=$arrContentDetail[0]['Content']['content_id'];
					$this->set('content_id',$arrContentDetail[0]['Content']['content_id']);
				}
				if($arrContentDetail[0]['Content']['content_related_products_assign'] || $arrContentDetail[0]['Content']['content_parent_id'])
				{
					$this->loadModel('ContentRelatedProductAssignment');
					//$arrRelatedProductsDetail = $this->ContentRelatedProductAssignment->find('all',array('conditions'=>array('content_id'=>$arrContentDetail[0]['Content']['content_id'])));
					$arrRelatedProductsDetail = $this->ContentRelatedProductAssignment->fnGetRelatedProductsDetails($content_id);
					/*print("<pre>");
					print_r($arrRelatedProductsDetail);
					exit;*/
					/*$this->set('arrRelatedProductsDetail',$arrRelatedProductsDetail);
				}
				
				$this->loadModel('ContentOther');
				$arrOtherContentDetail = $this->ContentOther->find('all',array('conditions'=>array('content_id'=>$content_id)));
				$this->set('arrOtherContentDetail',$arrOtherContentDetail);
				
				$this->loadModel('Categories');
				$arrCategoryDetail = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_description'),'conditions'=>array('content_category_id'=>$arrContentDetail[0]['Content']['content_default_category'])));
				$this->set('arrCategoryDetail',$arrCategoryDetail);
				
				$this->loadModel('ContentLocation');
				$arrContactLocationDetailList = $this->ContentLocation->find('all',array('conditions'=>array('content_id'=>$intProductId)));
				$this->set('arrContactLocationDetailList',$arrContactLocationDetailList);*/
			}
		}
	}
	
	public function productdelete($intProductId)
	{
		$arrResponse = array();
		if($intProductId)
		{
			
			$this->loadModel('Categories');
			$this->loadModel('Content');
			$intCorrectProductId = $this->Categories->find('count',array('conditions'=>array('content_category_id'=>$intProductId)));
			if($intCorrectProductId)
			{
				$intContentDeleted = $this->Categories->deleteAll(array('content_category_id' => $intProductId),false);
				if($intContentDeleted)
				{
					//$intSubContentDeleted = $this->Categories->deleteAll(array('content_category_parent_id' => $intProductId),false);
					$intSubContentFreed = $this->Categories->updateAll(
								array('content_category_parent_id'=>'0'),
								array('content_category_parent_id =' => $intProductId)
							);
							
					$intCatContentDeleted = $this->Content->deleteAll(array('content_default_category' => $intProductId),false);
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Entry has been deleted successfully','success');
					$this->set('strMessage',$strMessage);
					
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					
					echo json_encode($arrResponse);exit;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again','error');
					$this->set('strMessage',$strMessage);
					
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = $strMessage;
					
					echo json_encode($arrResponse);exit;
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Entry does not exists','info');
				$this->set('strMessage',$strMessage);
				
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = $strMessage;
				
				echo json_encode($arrResponse);exit;
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Something is missing, Please try again','error');
			$this->set('strMessage',$strMessage);
			
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = $strMessage;
			
			echo json_encode($arrResponse);exit;
		}
	}
	
	public function search($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index_cat.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'contentcategories','action'=>'search'),true));
		$this->loadModel('Categories');
		$arrProductContents = $this->Categories->find('all',array("conditions"=>array("content_category_name LIKE" => "%".$strKeywordSearch."%"),"order"=>array('content_category_id'=>'DESC')));
		
		//print("<pre>");
		//print_r($arrProductContents);
		//exit;
		$this->Paginator->settings = array(
			'conditions' => array("content_category_name LIKE"=> "%".$strKeywordSearch."%"),
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
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no products with provided title','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function productsubpages($intProductId = "")
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$this->loadModel('Content');
		$arrProductSubpages = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>$intProductId),'order' => array('content_id' => 'ASC'),));
		
		$this->set('arrProductList',$arrProductSubpages);
		
		/*print("<pre>");
		print_r($arrProductSubpages);
		exit;*/
	}
	
	public function contentsearch($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'contentcategories','action'=>'contentsearch'),true));
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('content_title'=>$strKeywordSearch,'category'=>"0","No"=>"1")
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
			
			$this->redirect(array('controller'=>'contentcategories','action'=>'contentsearch',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('category'=>"0",'No'=>'1')
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
	
	public function index() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index_cat.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'contentcategories','action'=>'index'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'contentcategories','action'=>'search',$strProductFilterKeyword));
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
			'conditions' => array('job_search_category'=>'0'),
			'order' => array('content_category_id' => 'DESC'),
			'limit' => 10
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
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no categories present, Please add one','info');
			$this->set('strMessage',$strMessage);
		}
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
	
	public function relatedproductlist($intEditContId = "",$intRelatedCategory = "")
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		$this->autoRender = false;
		
		$arrResponse = array();
		//$this->autoRender = false;
		$this->loadModel('Content');
		$arrConditions = array();
		$arrConditions['content_default_category'] = '4';
		if($intRelatedCategory)
		{
			if($intRelatedCategory == "99")
			{
				$arrConditions['content_default_category'] = array('99','2','1');
			}
			else
			{
				$arrConditions['content_default_category'] = $intRelatedCategory;
			}
		}
		if($intEditContId)
		{
			$arrConditions['content_id !='] = $intEditContId;
		}
		
		$arrRelatedProductList = $this->Content->find('all',array('conditions'=>$arrConditions));
		
		/*if($intEditContId)
		{
			//$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null,'content_id !='=>$intEditContId)));
			
			$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_default_category'=>'4','content_id !='=>$intEditContId)));
		}
		else
		{
			//$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
			$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_default_category'=>'4')));
		}*/
		$view = new View($this, false);
		$view->set('arrRelatedProductList', $arrRelatedProductList);
		if(is_array($arrRelatedProductList) && (count($arrRelatedProductList)<=0))
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no records for assignments','info');
			$view->set('strInfoMessage', $strMessage);
		}
		if($strWidgetAssigned)
		{
			$strWidgetAssigned = rtrim($strWidgetAssigned,",");
			$arrAssignedWidgets = explode(",",$strWidgetAssigned);
			$view->set('arrWidgetAssigned', $arrAssignedWidgets);
		}
		else
		{
			$view->set('arrWidgetAssigned','');
		}
		$view->set('strMessage','');
		$strWidgetListerHtml = $view->element('related_product_list');
		if($strWidgetListerHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strWidgetListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing parameter";
			echo json_encode($arrResponse);
			exit;
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function assignwidgetlist($strCategory = "",$strWidgetAssigned = "")
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		$this->autoRender = false;
		
		$arrResponse = array();
		//$this->autoRender = false;
		$this->loadModel('Widgets');
		if($strCategory)
		{
			$arrWidgetList = $this->Widgets->find('all',array('conditions'=>array('widget_category'=>$strCategory)));
		}
		else
		{
			$arrWidgetList = $this->Widgets->find('all');
		}
		$view = new View($this, false);
		$view->set('arrWidgetList', $arrWidgetList);
		if($strWidgetAssigned)
		{
			$strWidgetAssigned = rtrim($strWidgetAssigned,",");
			$arrAssignedWidgets = explode(",",$strWidgetAssigned);
			$view->set('arrWidgetAssigned', $arrAssignedWidgets);
		}
		else
		{
			$view->set('arrWidgetAssigned','');
		}
		$view->set('strMessage','');
		$strWidgetListerHtml = $view->element('assign_widget_lister');
		if($strWidgetListerHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strWidgetListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing parameter";
			echo json_encode($arrResponse);
			exit;
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	
	public function getcategories($intParentCatId = "",$strParentElementId = "",$intCurrentContId = "")
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		$arrResponse = array();
		$this->autoRender = false;
		if($intParentCatId)
		{
			$this->loadModel('Categories');
			$arrSubCatList = $this->Categories->find('all',array('conditions'=>array('content_category_parent_id'=>$intParentCatId)));
			// code to get the html content
			$view = new View($this, false);
			
			$this->loadModel('CategoriesAssignment');
			$arrContentCatAssigned = $this->CategoriesAssignment->find('list',array('fields'=>array('content_category_assig_id','category_id'),'conditions'=>array('content_id'=>$intCurrentContId)));
			$view->set('arrCatAssigned', $arrContentCatAssigned);
			$view->set('arrSubCatList', $arrSubCatList);
			$view->set('strParentElementId', $strParentElementId);
			$strSubCatHtml = $view->element('content_subcat');
			if($strSubCatHtml)
			{
				$arrResponse['status'] = "success";
				$arrResponse['content'] = $strSubCatHtml;
			}
			else
			{
				$arrResponse['status'] = "fail";
			}
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
	
	public function filescontentlister()
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		
		$arrResponse = array();
		$this->autoRender = false;
		
		$this->loadModel('ContentMedia');
		$arrFilesList = $this->ContentMedia->find('all',array('conditions'=>array('content_media_type '=>'text/html')));
		// code to get the html content
		$view = new View($this, false);
		$view->set('arrFilesList',$arrFilesList);
		$strFilesListerHtml = $view->element('filescontentlister', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strFilesListerHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strFilesListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function fileslister()
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		
		$arrResponse = array();
		$this->autoRender = false;
		
		$this->loadModel('ContentMedia');
		$arrFilesList = $this->ContentMedia->find('all',array('conditions'=>array('content_media_type '=>'application/pdf')));
		// code to get the html content
		$view = new View($this, false);
		$view->set('arrFilesList',$arrFilesList);
		$strFilesListerHtml = $view->element('fileslister', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strFilesListerHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strFilesListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function medialister()
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		
		$arrResponse = array();
		$this->autoRender = false;
		
		$this->loadModel('ContentMedia');
		$arrMediaList = $this->ContentMedia->find('all',array('conditions'=>array('OR'=>array(array('content_media_type' => 'image/png'), array('content_media_type' => 'image/jpeg'), array('content_media_type' => 'image/jpg'), array('content_media_type' => 'image/gif')))));
		/*print("<pre>");
		print_r($arrMediaList);
		exit;*/
		// code to get the html content
		$view = new View($this, false);
		$view->set('arrMediaList',$arrMediaList);
		$strMediaListerHtml = $view->element('medialister', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strMediaListerHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strMediaListerHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function updatecontactlocationinfo()
	{
		$arrResponseData = array();
		if($this->request->is('Post'))
		{
			
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['ContentLocation']['content_product_contact_form_location'] = $this->request->data['contact_location_name'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_address'] = htmlspecialchars(addslashes($this->request->data['contact_location_address']));
			$arrContentData['ContentLocation']['content_product_contact_form_title'] = $this->request->data['contact_location_form_title'];
			$arrContentData['ContentLocation']['content_product_contact_form_name'] = $this->request->data['contact_location_form_url'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'] = $this->request->data['contact_lcoation_to'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'] = $this->request->data['location_contact_cc'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc'] = $this->request->data['location_contact_bcc'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'] = $this->request->data['contact_location_subject'];
			$arrContentData['ContentLocation']['content_id'] = $intContentId = $this->request->data['content_id'];
			$intLocationId = $this->request->data['update_location_id'];
			//print('<pre>');
			//print_r($arrContentData);
			//exit;
			if($intLocationId)
			{
				$this->loadModel('ContentLocation');
				/*$this->Content->set($arrContentData);
				if($this->Content->validates())
				{*/
					$isLocationDetailPresent = $this->ContentLocation->find('count',array('conditions'=>array('content_product_contact_form_id'=>$intLocationId)));
					if($isLocationDetailPresent)
					{
						$boolContentLocationUpdated = $this->ContentLocation->updateAll(
							array('content_product_contact_form_title'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_title']."'",'content_product_contact_form_name'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_name']."'",'content_product_contact_form_location'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location']."'",'content_product_contact_form_location_address'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location_address']."'",'content_product_contact_form_location_mail_to'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location_mail_to']."'",'content_product_contact_form_location_mail_cc'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc']."'",'content_product_contact_form_location_mail_bcc'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc']."'",'content_product_contact_form_location_mail_subject'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject']."'"),
							array('content_product_contact_form_id =' => $intLocationId)
						);
						if($boolContentLocationUpdated)
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
						}
					}
					else
					{
						$boolContentLocationSaved = $this->ContentLocation->save($arrContentData);
						if($boolContentLocationSaved)
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
							$arrResponseData ['createdid'] = $this->ContentLocation->getLastInsertID();
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
							
						}
					}
				/*}
				else
				{
					$strContentCreationErrorMessage = "<br>";
					$arrContentCreationErrors = $this->Content->invalidFields();
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
				}*/
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
		echo json_encode($arrResponseData);exit;
	}
	
	public function deletecontactlocation($intLocationId)
	{
		$arrResponseData = array();
		if($intLocationId)
		{
			$this->loadModel('ContentLocation');
			$isLocationDetailPresent = $this->ContentLocation->find('count',array('conditions'=>array('content_product_contact_form_id'=>$intLocationId)));
			if($isLocationDetailPresent)
			{
				$intLocationDeleted = $this->ContentLocation->deleteAll(array('content_product_contact_form_id' => $intLocationId),false);
				if($intLocationDeleted)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Location deleted Successfully','success');
					$arrResponseData ['status'] = "success";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again, Please','warning');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Location Missing, Please','error');
			$arrResponseData ['status'] = "fail";
			$arrResponseData ['message'] = $strMessage;
		}
		echo json_encode($arrResponseData);exit;
	}
	
	public function setcontactlocationinfo()
	{
		if($this->request->is('Post'))
		{
			
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['ContentLocation']['content_product_contact_form_title'] = $this->request->data['contact_location_form_title'];
			$arrContentData['ContentLocation']['content_product_contact_form_name'] = $this->request->data['contact_location_form_url'];
			$arrContentData['ContentLocation']['content_product_contact_form_location'] = $this->request->data['contact_location_name'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_address'] = htmlspecialchars(addslashes($this->request->data['contact_location_address']));
			
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'] = $this->request->data['contact_lcoation_to'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'] = $this->request->data['location_contact_cc'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc'] = $this->request->data['location_contact_bcc'];
			$arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'] = $this->request->data['contact_location_subject'];
			$arrContentData['ContentLocation']['content_id'] = $intContentId = $this->request->data['content_id'];
			/*print('<pre>');
			print_r($arrContentData);
			exit;*/
			if($intContentId)
			{
				$this->loadModel('ContentLocation');
				/*$this->Content->set($arrContentData);
				if($this->Content->validates())
				{*/
					$isLocationDetailPresent = $this->ContentLocation->find('count',array('conditions'=>array('content_id'=>$intContentId,'content_product_contact_form_location_mail_to'=>$arrContentData['ContentLocation']['content_product_contact_form_location'],'content_product_contact_form_location_mail_to'=>$arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'],'content_product_contact_form_location_mail_cc'=>$arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'],'content_product_contact_form_location_mail_subject'=>$arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'])));
					if($isLocationDetailPresent)
					{
						$boolContentLocationUpdated = $this->ContentLocation->updateAll(
							array('content_product_contact_form_title'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_title']."'",'content_product_contact_form_name'=>"'".$arrContentData['ContentLocation']['content_product_contact_form_name']."'",'cont_contact_to'=>"'".$arrContentData['ContentLocation']['cont_contact_to']."'",'cont_contact_cc'=>"'".$arrContentData['ContentLocation']['cont_contact_cc']."'",'cont_contact_subject'=>"'".$arrContentData['ContentLocation']['cont_contact_subject']."'"),
							array('content_id =' => $intContentId)
						);
						if($boolContentLocationUpdated)
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
						}
					}
					else
					{
						$boolContentLocationSaved = $this->ContentLocation->save($arrContentData);
						if($boolContentLocationSaved)
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
							$arrResponseData ['createdid'] = $this->ContentLocation->getLastInsertID();
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
							
						}
					}
				/*}
				else
				{
					$strContentCreationErrorMessage = "<br>";
					$arrContentCreationErrors = $this->Content->invalidFields();
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
				}*/
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function setcontactinfo()
	{
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['Content']['content_contact_form_title'] = $this->request->data['contact_form_title'];
			$arrContentData['Content']['content_contact_form_name'] = $this->request->data['contact_form_url'];
			$arrContentData['Content']['cont_contact_to'] = $this->request->data['contact_to'];
			$arrContentData['Content']['cont_contact_cc'] = $this->request->data['contact_cc'];
			$arrContentData['Content']['cont_contact_bcc'] = $this->request->data['contact_bcc'];
			$arrContentData['Content']['cont_contact_subject'] = $this->request->data['contact_subject'];
			$arrContentData['Content']['contact_address'] = $this->request->data['contact_address'];
			$intContentId = $this->request->data['content_id'];
			
			if($intContentId)
			{
				$this->loadModel('Content');
				/*$this->Content->set($arrContentData);
				if($this->Content->validates())
				{*/
					$boolContentUpdated = $this->Content->updateAll(
						array('content_contact_form_title'=>"'".$arrContentData['Content']['content_contact_form_title']."'",'content_contact_form_name'=>"'".$arrContentData['Content']['content_contact_form_name']."'",'cont_contact_to'=>"'".$arrContentData['Content']['cont_contact_to']."'",'cont_contact_cc'=>"'".$arrContentData['Content']['cont_contact_cc']."'",'cont_contact_bcc'=>"'".$arrContentData['Content']['cont_contact_bcc']."'",'cont_contact_subject'=>"'".$arrContentData['Content']['cont_contact_subject']."'",'contact_address'=>"'".$arrContentData['Content']['contact_address']."'"),
						array('content_id =' => $intContentId)
					);
					
					if($boolContentUpdated)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('Content location saved successfully','success');
						$arrResponseData ['status'] = "success";
						$arrResponseData ['message'] = $strMessage;
					}
					else
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
						$arrResponseData ['status'] = "fail";
						$arrResponseData ['message'] = $strMessage;
					}
				/*}
				else
				{
					$strContentCreationErrorMessage = "<br>";
					$arrContentCreationErrors = $this->Content->invalidFields();
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
				}*/
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function setcategory()
	{
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$strCategories = rtrim($this->request->data['maincategoryselected'],",");
			$strDefaultCategory = $this->request->data['defaultcategory'];
			$intContentId = $this->request->data['content_id'];
			
			if($intContentId)
			{
				$this->loadModel('CategoriesAssignment');
				if($strCategories)
				{
					$arrCategories = explode(",",$strCategories);
					$arrCategories[] = $strDefaultCategory;
					$arrCategories = array_unique($arrCategories);
					/*print("<pre>");
					print_r($arrCategories);
					exit;*/
					
					$boolSaveFlag = "0";
					if(is_array($arrCategories) && (count($arrCategories)>0))
					{
						//$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>'4'),false);
						$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId),false);
						if($strDefaultCategory == "99")
						{
							$this->loadModel('Content');
							{
								$boolContentUpdated = $this->Content->updateAll(
									array('content_default_page_sub_category'=>NULL),
									array('content_id =' => $intContentId)
								);
							}
						}
						foreach($arrCategories as $arrCat)
						{
							$isCatPresentForContent = $this->CategoriesAssignment->find('count',array('conditions'=>array('content_id'=>$intContentId,'category_id'=>$arrCat)));
							if($isCatPresentForContent)
							{
								continue;
							}
							else
							{
								$arrCategoryData = array();
								$arrCategoryData['CategoriesAssignment']['category_id'] = $arrCat;
								$arrCategoryData['CategoriesAssignment']['content_id'] = $intContentId;
								$this->CategoriesAssignment->create(false);
								$boolCatAssigned = $this->CategoriesAssignment->save($arrCategoryData);
								if($boolCatAssigned)
								{
									$boolSaveFlag = "1";
								}
							}
							if($strDefaultCategory == "99")
							{
								if($arrCat != $strDefaultCategory)
								{
									$this->loadModel('Content');
									{
										$boolContentUpdated = $this->Content->updateAll(
											array('content_default_page_sub_category'=>"'".$arrCat."'"),
											array('content_id =' => $intContentId)
										);
									}
								}
							}
						}
						if($boolSaveFlag == "1")
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Categories assigned successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
						}
					}
					else
					{
						$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>'4'),false);
						if($intAssignedCategoryDeleted)
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
							$arrResponseData ['status'] = "fail";
							$arrResponseData ['message'] = $strMessage;
						}
					}
				}
				else
				{
					//echo $strDefaultCategory;exit;
					//$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>"'".$strDefaultCategory."'"),false);
					
					$intAssignedCategoryDeleted = $this->CategoriesAssignment->fnClearCategories($intContentId,$strDefaultCategory);
					
					if($intAssignedCategoryDeleted)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully','success');
						$arrResponseData ['status'] = "success";
						$arrResponseData ['message'] = $strMessage;
					}
					else
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
						$arrResponseData ['status'] = "fail";
						$arrResponseData ['message'] = $strMessage;
					}
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function subcontent()
	{
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['Content']['content_parent_id'] = $this->request->data['content_parent'];
			$intCurrentParentId = $this->request->data['current_parent_id'];
			$intContentId = $this->request->data['content_id'];
			
			if($intContentId)
			{
				$this->loadModel('Content');
				$isParent = $this->Content->find('count',array('conditions'=>array('content_parent_id'=>$intContentId)));
				if($isParent)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Main product cannot be assigned as subcontent','info');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{
					if($arrContentData['Content']['content_parent_id'])
					{
						/*$this->Content->set($arrContentData);
						if($this->Content->validates())
						{*/
							$boolContentUpdated = $this->Content->updateAll(
								array('content_parent_id'=>"'".$arrContentData['Content']['content_parent_id']."'"),
								array('content_id =' => $intContentId)
							);
							
							if($boolContentUpdated)
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Content set as sub content successfully','success');
								$arrResponseData ['status'] = "success";
								$arrResponseData ['message'] = $strMessage;
							}
							else
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
								$arrResponseData ['status'] = "fail";
								$arrResponseData ['message'] = $strMessage;
							}
						/*}
						else
						{
							$strContentCreationErrorMessage = "<br>";
							$arrContentCreationErrors = $this->Content->invalidFields();
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
						}*/
					}
					else
					{
						if($intCurrentParentId)
						{
							$boolContentUpdated = $this->Content->updateAll(
								array('content_parent_id'=>NULL),
								array('content_id =' => $intContentId)
							);
							
							if($boolContentUpdated)
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Sub content set successfully','success');
								$arrResponseData ['status'] = "success";
								$arrResponseData ['message'] = $strMessage;
							}
							else
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Something is missing before saving','error');
								$arrResponseData ['status'] = "fail";
								$arrResponseData ['message'] = $strMessage;
							}
						}
						else
						{
							$compMessage = $this->Components->load('Message');
							$strMessage = $compMessage->fnGenerateMessageBlock('Sub content set successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
					}
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function featured()
	{
		if($this->request->is('Post'))
		{
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			
			$arrContentData['Content']['content_is_featured'] = "0";
			
			
			if($this->request->data['is_featured'])
			{
				$arrContentData['Content']['content_is_featured'] = "1";
			}
			$intContentId = $this->request->data['content_id'];
			$arrContentOtherData['ContentOther']['content_featured_image'] = $this->request->data['featured_image_id'];
			
			if($intContentId)
			{
				$this->loadModel('Content');
				$boolContentUpdated = $this->Content->updateAll(
						array('content_is_featured'=>"'".$arrContentData['Content']['content_is_featured']."'",'content_featured_image'=>"'".$arrContentOtherData['ContentOther']['content_featured_image']."'"),
						array('content_id =' => $intContentId)
					);
					
				if($boolContentUpdated)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Content set as featured successfully','success');
					$arrResponseData ['status'] = "success";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function other()
	{
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['Content']['content_is_branded'] = $this->request->data['is_branded'];
			$arrContentData['ContentOther']['content_brand_title'] = $this->request->data['brand_title'];
			$arrContentData['ContentOther']['content_brand_description'] = $this->request->data['brand_description'];
			$arrContentOtherData['ContentOther']['content_website'] = $this->request->data['content_website'];
			$intContentId = $this->request->data['content_id'];
			$arrContentOtherData['ContentOther']['content_product_highlight_text'] = htmlspecialchars(addslashes($this->request->data['content_highlight']));
			$arrContentOtherData['ContentOther']['content_product_download_text'] = htmlspecialchars(addslashes($this->request->data['content_download']));
			$arrContentOtherData['ContentOther']['content_id'] = $intContentId;
			$arrContentOtherData['ContentOther']['content_product_other_details_id'] = $intContentOtherId = $this->request->data['content_other_id'];
			
			if($intContentId)
			{
				$this->loadModel('Content');
				if($arrContentData['Content']['content_is_branded'])
				{
					$boolContentUpdated = $this->Content->updateAll(
							array('content_is_branded'=>"'1'"),
							array('content_id =' => $intContentId)
						);
				}
				else
				{
					$boolContentUpdated = $this->Content->updateAll(
							array('content_is_branded'=>"'0'"),
							array('content_id =' => $intContentId)
						);
				}
				
				$this->loadModel('ContentOther');
				if($intContentOtherId)
				{
					// update
					$boolContentOther = $this->ContentOther->updateAll(
							array('content_id' => $intContentId,'content_brand_description'=>"'".$arrContentData['ContentOther']['content_brand_description']."'",'content_brand_title'=>"'".$arrContentData['ContentOther']['content_brand_title']."'",'content_product_highlight_text'=>"'".$arrContentOtherData['ContentOther']['content_product_highlight_text']."'",'content_website'=>"'".$arrContentOtherData['ContentOther']['content_website']."'",'content_product_download_text'=>"'".$arrContentOtherData['ContentOther']['content_product_download_text']."'"),
							array('content_product_other_details_id =' => $intContentOtherId)
						);
				}
				else
				{
					// insert
					$intOtherExists = $this->ContentOther->find('count',array('conditions'=>array('content_id'=>$intContentId)));
					if($intOtherExists)
					{
						$boolContentOther = $this->ContentOther->updateAll(
								array('content_brand_description'=>"'".$arrContentData['ContentOther']['content_brand_description']."'",'content_brand_title'=>"'".$arrContentData['ContentOther']['content_brand_title']."'",'content_product_highlight_text'=>"'".$arrContentOtherData['ContentOther']['content_product_highlight_text']."'",'content_product_download_text'=>"'".$arrContentOtherData['ContentOther']['content_product_download_text']."'",'content_website'=>"'".$arrContentOtherData['ContentOther']['content_website']."'"),
								array('content_id =' => $intContentId)
							);
					}
					else
					{
						$boolContentOther = $this->ContentOther->save($arrContentOtherData);
					}
				}
				if($boolContentOther)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Other Detail recorded successfully','success');
					$arrResponseData ['status'] = "success";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
		}
	}
	
	public function otheraff()
	{
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['Content']['content_featured_image'] = $this->request->data['featured_image_id'];
			$intContentId = $this->request->data['content_id'];
			$arrContentOtherData['ContentOther']['content_phone_no'] = addslashes($this->request->data['content_phone_no']);
			$arrContentOtherData['ContentOther']['content_fax_no'] = addslashes($this->request->data['content_fax_no']);
			$arrContentOtherData['ContentOther']['content_website'] = addslashes($this->request->data['content_website']);
			$arrContentOtherData['ContentOther']['content_address'] = htmlspecialchars(addslashes($this->request->data['content_address']));
			$arrContentOtherData['ContentOther']['content_id'] = $intContentId;
			$arrContentOtherData['ContentOther']['content_product_other_details_id'] = $intContentOtherId = $this->request->data['content_other_id'];
			
			if($intContentId)
			{
				$this->loadModel('Content');
				if($arrContentData['Content']['content_featured_image'])
				{
					$boolContentUpdated = $this->Content->updateAll(
							array('content_featured_image'=>"'".$arrContentData['Content']['content_featured_image']."'"),
							array('content_id =' => $intContentId)
						);
				}
				else
				{
					$boolContentUpdated = $this->Content->updateAll(
							array('content_featured_image'=>NULL),
							array('content_id =' => $intContentId)
						);
				}
				
				$this->loadModel('ContentOther');
				if($intContentOtherId)
				{
					// update
					$boolContentOther = $this->ContentOther->updateAll(
							array('content_id' => $intContentId,'content_phone_no'=>"'".$arrContentOtherData['ContentOther']['content_phone_no']."'",'content_fax_no'=>"'".$arrContentOtherData['ContentOther']['content_fax_no']."'",'content_website'=>"'".$arrContentOtherData['ContentOther']['content_website']."'",'content_address'=>"'".$arrContentOtherData['ContentOther']['content_address']."'"),
							array('content_product_other_details_id =' => $intContentOtherId)
						);
				}
				else
				{
					// insert
					$intOtherExists = $this->ContentOther->find('count',array('conditions'=>array('content_id'=>$intContentId)));
					if($intOtherExists)
					{
						$boolContentOther = $this->ContentOther->updateAll(
								array('content_phone_no'=>"'".$arrContentOtherData['ContentOther']['content_phone_no']."'",'content_fax_no'=>"'".$arrContentOtherData['ContentOther']['content_fax_no']."'",'content_website'=>"'".$arrContentOtherData['ContentOther']['content_website']."'",'content_address'=>"'".$arrContentOtherData['ContentOther']['content_address']."'"),
								array('content_id =' => $intContentId)
							);
					}
					else
					{
						$boolContentOther = $this->ContentOther->save($arrContentOtherData);
					}
				}
				if($boolContentOther)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Other Detail recorded successfully','success');
					$arrResponseData ['status'] = "success";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again','error');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this','error');
				$arrResponseData ['status'] = "fail";
				$arrResponseData ['message'] = $strMessage;
			}
			echo json_encode($arrResponseData);exit;
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
			//print('<pre>');
			//print_r($this->request->data);
			//exit;
			
			$arrResponseData = array();
			$intEditModeId = "";
			$arrContentData = array();
			$strRequestFor = $this->request->data['content_request_for'];
			$strDefaultCate = '0';
			if($this->request->data['content_request_for_id'])
			{
				$strDefaultCate = $this->request->data['content_request_for_id'];
			}
			
			$contentId = $this->request->data['content_user'];
			$catName = $this->request->data['content_title'];
			
			//Duplicate Category Code Validation. 
			$arrCategoriesName = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_name'),'conditions'=>array('content_cat_for_user'=>$contentId)));
			$this->set('arrCategoriesName',$arrCategoriesName);
			if(in_array($catName,$arrCategoriesName)) {
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Category already exist for this content user','error');
				$arrResponseData['status'] = 'fail';
				$arrResponseData['message'] = $strMessage;
				echo json_encode($arrResponseData);exit;
			} else {
				$arrContentData['Categories']['content_category_name'] = htmlspecialchars(addslashes($this->request->data['content_title']));
			}
			
			//$arrContentData['Categories']['content_banner_image'] = $this->request->data['banner_image_id'];
			
			$arrContentData['Categories']['content_cat_for_user'] = $this->request->data['content_user'];
			$arrContentData['Categories']['content_cat_icon'] = $this->request->data['banner_image_id'];
			
			//$arrContentData['Categories']['content_published_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['content_pub_date']));
			

			
			$arrContentData['Categories']['content_category_descriptions'] = htmlspecialchars(addslashes($this->request->data['main_contentnew']));
			$arrContentData['Categories']['content_category_intro_content'] = htmlspecialchars(addslashes($this->request->data['intro_contentnew']));
			/*if(isset($this->request->data['leftcontent_widgets']))
			{
				$arrContentData['Categories']['left_content_widgets'] = $this->request->data['leftcontent_widgets'];
			}*/
                        
                        if($this->request->data['content_user'] == '3'){
                            $arrContentData['Categories']['category_type'] = "1";
                        }else{
                            $arrContentData['Categories']['category_type'] = "0";
                        }
                        
			if($this->request->data['cat_type'])
			{
				if(strtolower($this->request->data['cat_type']) == "phase" || strtolower($this->request->data['cat_type']) == "steps" || strtolower($this->request->data['cat_type']) == "substeps")
				{

					$arrContentData['Categories']['content_cat_for_user'] = "3";
					$arrContentData['Categories']['job_search_category'] = "1";
					$arrContentData['Content']['job_search_process_content']  = "1";
				}
				if(strtolower($this->request->data['cat_type']) == "phase" || strtolower($this->request->data['cat_type']) == "steps")
				{
					$arrContentData['Categories']['content_category_has_child'] = "1";
				}
				
				if(strtolower($this->request->data['cat_type']) == "substeps")
				{
					$arrContentData['Categories']['job_search_track'] = "1";
				}
				$arrContentData['Categories']['job_process_type'] = $this->request->data['cat_type'];
			}
			
			$intEditModeId = $this->request->data['content_edit_id'];
			
			//print("<pre>");
			//print_r($_FILES);
			//exit;
			//echo $intEditModeId;exit;
			//echo WWW_ROOT.'<br/>';
			
			if(!empty($_FILES["content_category_image"]))
			{
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randstring = '';
				for ($i = 0; $i < 10; $i++) {
					$randstring .= $characters[rand(0, strlen($characters))];
				}
			    $image=$_FILES["content_category_image"]["name"];
				$imag=explode('.',$image);
				$ext=$imag[count($image)];
				$allowed_type=array('jpeg','jpg','png','gif','JPEG','JPG','PNG','GIF');
				$size=$_FILES["content_category_image"]["size"];
				//echo "<br/>".$ext;
				//echo "<pre>";print_r($allowed_type);
				//var_dump(!in_array($ext,$allowed_type));exit;
				//echo $size;exit;
				if(!in_array($ext,$allowed_type))
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Invalid filetype.Attach only file having extension jpeg,jpg,png,gif.','error');
					$arrResponseData['status'] = 'fail';
					$arrResponseData['message'] = $strMessage;
					echo json_encode($arrResponseData);exit;
				}
				else if($size>(1024*1024))
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('File size too big.Upload file less than 1 Mb.','error');
					$arrResponseData['status'] = 'fail';
					$arrResponseData['message'] = $strMessage;
					echo json_encode($arrResponseData);exit;
				}
				else
				{
					$content_category_image=$randstring.date('Ymdhis').'.'.$ext;
					$target_file=WWW_ROOT.'/contentcat'.'/'.$content_category_image;
					//echo $target_file.'<br/>';
					move_uploaded_file($_FILES["content_category_image"]["tmp_name"], $target_file);
				}
				
			}
			
			
			$this->Categories->set($arrContentData);
			if($this->Categories->validates())
			{
				// edit here
				if($intEditModeId)
				{
					//print("<pre>");
					//print_r($_FILES);
					//exit;
					//$arrContentData['Categories']['content_category_image']=$_FILES['content_category_image']['name'];
					$boolContentUpdated = $this->Categories->updateAll(
							array('content_category_name'=>"'".$arrContentData['Categories']['content_category_name']."'",'content_cat_for_user'=>"'".$arrContentData['Categories']['content_cat_for_user']."'",'content_cat_icon'=>"'".$arrContentData['Categories']['content_cat_icon']."'",'job_process_type'=>"'".$arrContentData['Categories']['job_process_type']."'",'job_search_category'=>"'".$arrContentData['Categories']['job_search_category']."'",'job_search_track'=>"'".$arrContentData['Categories']['job_search_track']."'",'content_category_image'=>"'".$content_category_image."'"),
							array('content_category_id =' => $intEditModeId)
						);
						
					if($boolContentUpdated)
					{
						
						$intContentDeleted = $this->Content->deleteAll(array('content_default_category' => $intEditModeId),false);
						
						$arrContentData['Content']['content_title'] = $arrContentData['Categories']['content_category_name'];
						$arrContentData['Content']['content_title_alias'] = "Articles";
						$arrContentData['Content']['content_type'] = "1";
						$arrContentData['Content']['content'] = $arrContentData['Categories']['content_category_descriptions'];
						$arrContentData['Content']['content_intro_text'] = $arrContentData['Categories']['content_category_intro_content'];
						$arrContentData['Content']['content_for_user'] = $arrContentData['Categories']['content_cat_for_user'];
						$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s');
						$arrContentData['Content']['content_default_category'] = $intEditModeId;
						$arrContentData['Content']['content_status']  = "published";
						
						//print("<pre>");
						//print_r($arrContentData);
						//exit;
						$arrRes = $this->Content->save($arrContentData);
						/*$boolContentUpdated = $this->Content->updateAll(
							array('content_default_category'=>"'".$intEditModeId."'",'content_title_alias' => "'".$arrContentData['Content']['content_title_alias']."'",'content_title' => "'".$arrContentData['Content']['content_title']."'",'content_intro_text'=>"'".$arrContentData['Content']['content_intro_text']."'",'content'=>"'".$arrContentData['Content']['content']."'",'content_status'=>"'".$arrContentData['Content']['content_status']."'",'content_for_user'=>"'".$arrContentData['Content']['content_for_user']."'",'content_type'=>"'".$arrContentData['Content']['content_type']."'",'job_search_process_content'=>"'".$arrContentData['Content']['job_search_process_content']."'"),
							array('content_default_category =' => $intEditModeId)
						);*/
						
						$compMessage = $this->Components->load('Message');
						if(strtolower($arrContentData['Categories']['job_process_type']) == "phase")
						{
							$strForMessage = "You have successfully updated Phase.";
						}
						else
						{
							if(strtolower($arrContentData['Categories']['job_process_type']) == "steps")
							{
								$strForMessage = "You have successfully updated Step.";
							}
							else
							{
								if(strtolower($arrContentData['Categories']['job_process_type']) == "substeps")
								{
									$strForMessage = "You have successfully updated Substep.";
								}
								else
								{
									$strForMessage = "You have successfully updated category.";
								}
							}
						}
						
						
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
						$arrContentData['Categories']['content_category_image']=$content_category_image;
						$boolContentCreated = $this->Categories->save($arrContentData);
						if($boolContentCreated)
						{
							$intCreatedContentId = $this->Categories->getLastInsertID();
							
							
							$arrContentData['Content']['content_title'] = $arrContentData['Categories']['content_category_name'];
							$arrContentData['Content']['content_title_alias'] = "Articles";
							$arrContentData['Content']['content_type'] = "1";
							$arrContentData['Content']['content'] = $arrContentData['Categories']['content_category_descriptions'];
							$arrContentData['Content']['content_intro_text'] = $arrContentData['Categories']['content_category_descriptions'];
							$arrContentData['Content']['content_for_user'] = $arrContentData['Categories']['content_cat_for_user'];
							$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s');
							$arrContentData['Content']['content_default_category'] = $intCreatedContentId;
							$arrContentData['Content']['content_status']  = "published";
							
							$arrRes = $this->Content->save($arrContentData);
							
							$arrResponseData['createdid'] = $intCreatedContentId;
							$arrResponseData['status'] = 'success';
						}
						$compMessage = $this->Components->load('Message');
						if(strtolower($arrContentData['Categories']['job_process_type']) == "phase")
						{
							$strForMessage = "You have successfully added Phase.";
						}
						else
						{
							if(strtolower($arrContentData['Categories']['job_process_type']) == "steps")
							{
								$strForMessage = "You have successfully added Step.";
							}
							else
							{
								if(strtolower($arrContentData['Categories']['job_process_type']) == "substeps")
								{
									$strForMessage = "You have successfully added Substep.";
								}
								else
								{
									$strForMessage = "You have successfully added category.";
								}
							}
						}
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
		
		/* $arrCategories = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_name'),'conditions'=>array('content_cat_for_user'=>'5')));
		$this->set('arrCategories',$arrCategories);
		if(in_array("Communicator",$arrCategories)) {
			echo "<pre>"; print_r($arrCategories);
			exit;
		} */
		
	}
	
	public function htmlfileuploader($strUploaderFor = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($strUploaderFor)
		{
			$view->set('uploaderfor',$strUploaderFor);
		}
		$strFileUploaderHtml = $view->element('contentfileuploader', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strFileUploaderHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strFileUploaderHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function fileuploader($strUploaderFor = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($strUploaderFor)
		{
			$view->set('uploaderfor',$strUploaderFor);
		}
		$strFileUploaderHtml = $view->element('fileuploader', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strFileUploaderHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strFileUploaderHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function mediauploader()
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$strMediaUploaderHtml = $view->element('mediaselector', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strMediaUploaderHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strMediaUploaderHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contentaffotherform($intContentId,$intCatId = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($intContentId)
		{
			$this->loadModel('Content');
			$arrFeaturedDetails = $this->Content->fnGetProductsFeaturedDetails($intContentId);
			/*print("<pre>");
			print_r($arrFeaturedDetails);
			exit;*/
			$view->set('arrFeaturedDetails',$arrFeaturedDetails);
			
			$this->loadModel('ContentOther');
			$arrContentOtherDetail = $this->ContentOther->find('all',array('conditions'=>array('content_id'=>$intContentId)));
			/*print("<pre>");
			print_r($arrContentOtherDetail);exit;*/
			$view->set('arrContentOtherDetail',$arrContentOtherDetail);
			$view->set('strContentId',$intContentId);
			$view->set('strCatId',$intCatId);
		}
		$strContentOtherHtml = $view->element('content_other_aff', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContentOtherHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContentOtherHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contentotherform($intContentId)
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($intContentId)
		{
			$this->loadModel('Content');
			$arrContentBranded = $this->Content->fnGetBrandedProductDetails($intContentId);
			$view->set('arrContentBranded',$arrContentBranded);
			
			$this->loadModel('ContentOther');
			$arrContentOtherDetail = $this->ContentOther->find('all',array('conditions'=>array('content_id'=>$intContentId)));
			/*print("<pre>");
			print_r($arrContentOtherDetail);exit;*/
			$view->set('arrContentOtherDetail',$arrContentOtherDetail);
			$view->set('strContentId',$intContentId);
		}
		$strContentOtherHtml = $view->element('content_other', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContentOtherHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContentOtherHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function parentcontentform($intContentId)
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Content');
		$arrContentAllocatedParent = $this->Content->fnGetContentParentData($intContentId);
		$view->set('arrContentAllocatedParent',$arrContentAllocatedParent);
		$view->set('strContentId',$intContentId);
		$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null,'content_id !='=>$intContentId,'content_default_category'=>'4')));
		//$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
		$view->set('arrProductParentList',$arrParentProductList);
		/*print("<pre>");
		print_r($arrParentProductList);
		exit;*/
		$strContentParentHtml = $view->element('content_parent');
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContentParentHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContentParentHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contentcategoryassform($intContentId)
	{
		$arrResponse = array();
		$this->autoRender = false;
		
		$this->loadModel('Categories');
		$arrCatList = $this->Categories->find('all',array('conditions'=>array('content_category_parent_id'=>'0')));
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('CategoriesAssignment');
		$arrContentCatAssigned = $this->CategoriesAssignment->find('list',array('fields'=>array('content_category_assig_id','category_id'),'conditions'=>array('content_id'=>$intContentId)));
		$view->set('arrCatAssigned', $arrContentCatAssigned);
		$view->set('arrCatList', $arrCatList);
		$view->set('strContentId',$intContentId);
		$strContentCategoryHtml = $view->element('content_cat_assignment');
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContentCategoryHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContentCategoryHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function featuredform($intContentId = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Content');
		$arrFeaturedDetails = $this->Content->fnGetProductsFeaturedDetails($intContentId);
		/*print("<pre>");
		print_r($arrFeaturedDetails);
		exit;*/
		$view->set('arrFeaturedDetails',$arrFeaturedDetails);
		$view->set('strContentId',$intContentId);
		$strFeaturedHtml = $view->element('content_featured');
		if($strFeaturedHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strFeaturedHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contact($intContentId)
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Content');
		$arrContactDetails = $this->Content->fnGetBasicContactDetails($intContentId);
		$view->set('arrContactDetails',$arrContactDetails);
		$view->set('strContentId',$intContentId);
		$strContactHtml = $view->element('contact_details');
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContactHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContactHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contactdetail()
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$strContactHtml = $view->element('contact_details', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strContactHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContactHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contactlocation($intContentId = "1")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($intContentId)
		{
			$this->loadModel('ContentLocation');
			$arrContactLocationDetailList = $this->ContentLocation->find('all',array('conditions'=>array('content_id'=>$intContentId)));
			$view->set('arrContactLocationDetailList',$arrContactLocationDetailList);

			if(is_array($arrContactLocationDetailList) && (count($arrContactLocationDetailList)==0))
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('There are no contact location created, you need to create one','info');
				$view->set('strMessage',$strMessage);
			}
		}
		$strContactLocationHtml = $view->element('contact_locations');
		//$view->render('testlogin');
		//echo $strContactLocationHtml;exit;
		if($strContactLocationHtml)
		{
			//echo "HI";exit;
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strContactLocationHtml;
			//$arrResponse['content'] = 'Rajendra';
			echo json_encode($arrResponse);
			exit;
			/*print("<pre>");
			print_r($arrResponse);
			exit;*/
		}
		else
		{
			$arrResponse['status'] = "fail";
			//$arrResponse['status'] = "fail";
			echo json_encode($arrResponse);
			exit;
		}
	}
}
