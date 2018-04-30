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
class ContentController extends AppController {

	public $components = array('Paginator');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = "admin";
	public $name = 'Content';
	
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
		$this->layout = "portalpreview";
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
			
			$this->loadModel('Content');
			$intCorrectProductId = $this->Content->find('count',array('conditions'=>array('content_id'=>$intProductId)));
			if($intCorrectProductId)
			{
				$intContentDeleted = $this->Content->deleteAll(array('content_id' => $intProductId),false);
				if($intContentDeleted)
				{
					/*$this->loadModel('ContentRelatedProductAssignment');
					//echo "--".$this->ContentRelatedProductAssignment->deleteAll(array('product_id' => $intProductId),false);exit;
					$this->ContentRelatedProductAssignment->fnDeleteRelatedProduct($intProductId);
					$arrChildList = $this->Content->find('list',array('fields'=>array('content_title','content_id'),'conditions'=>array('content_parent_id'=>$intProductId)));
					if(is_array($arrChildList) && (count($arrChildList)>0))
					{
						foreach($arrChildList as $arrChildVal)
						{
							$intContentChildsDeleted = $this->Content->deleteAll(array('content_id' => $arrChildVal),false);
							if($intContentChildsDeleted)
							{
								$this->ContentRelatedProductAssignment->fnDeleteRelatedProduct($arrChildVal);
							}
						}
					}*/					
					$this->loadModel('CategoriesAssignment');
					$boolCatAssigned = $this->CategoriesAssignment->deleteAll(array('content_id' => $intProductId),false);
					
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
	
	
	public function changeProductStatus($intProductId)
	{
		$arrResponse = array();
		if($intProductId)
		{
			
			$this->loadModel('Content');
			$intCorrectProductId = $this->Content->find('count',array('conditions'=>array('content_id'=>$intProductId)));
			if($intCorrectProductId)
			{
				 $this->Content->updateAll(
				array('content_status'=>"''"),
							array('content_id' => $intProductId)
				);
				
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Content Status updated successfully ','success');
								
				
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					
					echo json_encode($arrResponse);exit;
				
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
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'index'),true));
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('content_title'=>$strKeywordSearch,'category'=>"0",'content_for_user'=>3)
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
	
	
	public function ownercontentsearch($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'ownercontent'),true));
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('content_title'=>$strKeywordSearch,'category'=>"0",'content_for_user'=>2)
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
	
	public function subcontentlist($intProductId = "")
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
	
	public function index() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'index'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'content','action'=>'search',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('category'=>"0",'content_for_user'=>3),
				'order' => array('content_id' => 'desc')
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
	
	
	public function ownercontent() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'ownercontent'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'content','action'=>'ownercontentsearch',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('category'=>"0",'content_for_user'=>2),
				'order' => array('content_id' => 'desc')
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
	
	public function vendorcontent() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'vendorcontent'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'content','action'=>'vendorcontentsearch',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('category'=>"0",'content_for_user'=>5),
				'order' => array('content_id' => 'desc')
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
	
	public function vendorcontentsearch($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/product_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'vendorcontent'),true));
		
		$this->loadModel('Content');
		$this->Content->recursive = 0;
		$this->Paginator->settings = array(
			'Content' => array(
				'limit' => 20,
				'conditions' => array('content_title'=>$strKeywordSearch,'category'=>"0",'content_for_user'=>5)
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
			//$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
			//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
			//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
			$this->set('strActionScript',$strActionScript);
			$this->set('strDateFormat',Configure::read('Productdate.format'));
			$this->loadModel('Contenttype');
			$arrContentTypeList = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
			$this->set('arrContentTypeList',$arrContentTypeList);
			
			$this->loadModel('Content');
			$arrProductContent = $this->Content->fnGetProduct($intProductId);
			/*print("<pre>");
			print_r($arrProductContent);
			exit;*/
			
			if(is_array($arrProductContent) && (count($arrProductContent)>0))
			{	
				/*print("<pre>");
				print_r($arrProductContent);
				exit;*/
				/*$isContRelatedProductAssigned = $arrProductContent[0]['content']['content_related_products_assign'];
				if($isContRelatedProductAssigned)
				{
					$this->loadModel('ContentRelatedProductAssignment');
					$arrContRelatedWidgets = $this->ContentRelatedProductAssignment->find('list',array('fields'=>array('product_name','product_id'),'conditions'=>array('content_id'=>$intProductId,'related_product_position'=>'content')));
					$this->set('arrContRelatedWidgets',$arrContRelatedWidgets);
				}
				
				$isContWidgetAssigned = $arrProductContent[0]['content']['content_widget_assignment'];
				if($isContWidgetAssigned)
				{
					$this->loadModel('ContentWidgetAssignment');
					$arrContWidgets = $this->ContentWidgetAssignment->find('list',array('fields'=>array('widget_name','widget_id'),'conditions'=>array('content_id'=>$intProductId,'widget_position'=>'content')));
					$this->set('arrContWidgets',$arrContWidgets);
				}
				
				$isLeftContWidgetAssigned = $arrProductContent[0]['content']['content_left_widget_assignment'];
				if($isLeftContWidgetAssigned)
				{
					$this->loadModel('ContentWidgetAssignment');
					$arrLeftContWidgets = $this->ContentWidgetAssignment->find('list',array('fields'=>array('widget_name','widget_id'),'conditions'=>array('content_id'=>$intProductId,'widget_position'=>'left')));
					$this->set('arrLeftContWidgets',$arrLeftContWidgets);
				}
				
				$isRightContWidgetAssigned = $arrProductContent[0]['content']['content_right_widget_assignment'];
				if($isRightContWidgetAssigned)
				{
					$this->loadModel('ContentWidgetAssignment');
					$arrRightContWidgets = $this->ContentWidgetAssignment->find('list',array('fields'=>array('widget_name','widget_id'),'conditions'=>array('content_id'=>$intProductId,'widget_position'=>'right')));
					$this->set('arrRightContWidgets',$arrRightContWidgets);
				}*/
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
		$arrMediaList = $this->ContentMedia->find('all',array('conditions'=>array('OR'=>array(array('content_media_type' => 'image/png'), array('content_media_type' => 'image/jpeg'), array('content_media_type' => 'image/jpg'), array('content_media_type' => 'image/gif'), array('content_media_type' => 'audio/mpeg'), array('content_media_type' => 'application/pdf'))),'ORDER' => array('content_media_id' => 'ASC')));
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
	
	public function setcategory() {
        if ($this->request->is('Post')) {
            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $strCategories = rtrim($this->request->data['maincategoryselected'], ",");
            $strDefaultCategory = $this->request->data['defaultcategory'];
            $strCategory_for = $this->request->data['category_for'];
            $intContentId = $this->request->data['content_id'];

            if ($intContentId != '') {
                $this->loadModel('CategoriesAssignment');
                if ($strCategories) {
                    $arrCategories = explode(",", $strCategories);
                    //$arrCategories[] = $strDefaultCategory;
                    $arrCategories = array_unique($arrCategories);
                    /* print("<pre>");
                      print_r($arrCategories);
                      exit; */

                    $boolSaveFlag = "0";
                    if (is_array($arrCategories) && (count($arrCategories) > 0)) {
                        //$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>'4'),false);
                        $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId), false);

                        foreach ($arrCategories as $arrCat) {

                            $isCatPresentForContent = $this->CategoriesAssignment->find('count', array('conditions' => array('content_id' => $intContentId, 'category_id' => $arrCat)));
                            if ($isCatPresentForContent) {
                                continue;
                            } else {
                                $arrCategoryData = array();
                                $arrCategoryData['CategoriesAssignment']['category_id'] = $arrCat;
                                $arrCategoryData['CategoriesAssignment']['content_id'] = $intContentId;
                                $arrCategoryData['CategoriesAssignment']['category_for'] = '0';
                                $this->CategoriesAssignment->create(false);
                                $boolCatAssigned = $this->CategoriesAssignment->save($arrCategoryData);
                                if ($boolCatAssigned) {
                                    $boolSaveFlag = "1";
                                }
                            }
                        }
                        if ($boolSaveFlag == "1") {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Categories assigned successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    } else {
                        $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId), false);
                        if ($intAssignedCategoryDeleted) {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    }
                } else {
                    //echo $strDefaultCategory;exit;
                    //$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>"'".$strDefaultCategory."'"),false);
                    //$intAssignedCategoryDeleted = $this->CategoriesAssignment->fnClearCategories($intContentId,$strDefaultCategory);

                    $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId), false);

                    if ($intAssignedCategoryDeleted) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function subcatcontent()
	{
		if($this->request->is('Post'))
		{
			//print('<pre>');
			//print_r($this->request->data);
			//exit;
			
			$arrContentOtherData = array();
			$arrContentData = array();
			$arrResponseData = array();
			
			$arrContentData['Categories']['content_category_parent_id'] = $this->request->data['content_parent_cat'];
			$intCurrentParentId = $this->request->data['current_parent_cat_id'];
			$intContentId = $this->request->data['content_id'];
			
			if($intContentId)
			{
				$this->loadModel('Categories');
				/*$isParent = $this->Categories->find('count',array('conditions'=>array('content_category_id'=>$intContentId,'content_category_parent_id'=>'0')));
				echo "--".$isParent;
				exit;
				if($isParent)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Main Category cannot be assigned as subcategory','info');
					$arrResponseData ['status'] = "fail";
					$arrResponseData ['message'] = $strMessage;
				}
				else
				{*/
					if($arrContentData['Categories']['content_category_parent_id'])
					{
						/*$this->Content->set($arrContentData);
						if($this->Content->validates())
						{*/
							$boolContentUpdated = $this->Categories->updateAll(
								array('content_category_parent_id'=>"'".$arrContentData['Categories']['content_category_parent_id']."'"),
								array('content_category_id =' => $intContentId)
							);
							
							if($boolContentUpdated)
							{
								$intSubChildCount = $this->Categories->find('count',array('conditions'=>array('content_category_parent_id'=>$arrContentData['Categories']['content_category_parent_id'])));
								
								$isParentUpdate = $this->Categories->updateAll(
									array('content_category_has_child'=>"'1'","no_of_childs"=>$intSubChildCount),
									array('content_category_id =' => $arrContentData['Categories']['content_category_parent_id'])
								);
								
								
								
								
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Category set as sub category successfully','success');
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
							$boolContentUpdated = $this->Categories->updateAll(
								array('content_category_parent_id'=>'0'),
								array('content_category_id =' => $intContentId)
							);
							
							if($boolContentUpdated)
							{
								$intParentCount = $this->Categories->find('count',array('conditions'=>array('content_category_parent_id'=>$intCurrentParentId)));
								if(!$intParentCount)
								{
									$boolContentParentUpdated = $this->Categories->updateAll(
										array('content_category_has_child'=>'0'),
										array('content_category_id =' => $intCurrentParentId)
									);
								}
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('Sub category set successfully','success');
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
							$strMessage = $compMessage->fnGenerateMessageBlock('Sub category set successfully','success');
							$arrResponseData ['status'] = "success";
							$arrResponseData ['message'] = $strMessage;
						}
					}
				//}
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Category missing, please add category first before saving this','error');
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
		//$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
		//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$this->set('strDateFormat',Configure::read('Productdate.format'));
		$this->loadModel('Contenttype');
		$arrContentTypeList = $this->Contenttype->find('list',array('fields'=>array('content_type_id','content_type_name')));
		$this->set('arrContentTypeList',$arrContentTypeList);
		
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
			$arrContentData['Content']['content_title'] = htmlspecialchars(addslashes($this->request->data['content_title']));
			$arrContentData['Content']['content_title_alias'] = htmlspecialchars(addslashes($this->request->data['content_title_alias']));
			$arrContentData['Content']['content_name'] = addslashes($this->request->data['content_name']);
			//$arrContentData['Content']['content_title'] = addslashes($this->request->data['content_title']);
			//$arrContentData['Content']['content_title_alias'] = addslashes($this->request->data['content_title_alias']);
			$arrContentData['Content']['content_default_category'] = $strDefaultCate;
			$arrContentData['Content']['content_layout'] = $this->request->data['content_layout_style'];
			$arrContentData['Content']['content_banner_image'] = $this->request->data['banner_image_id'];
			$arrContentData['Content']['content_intro_text'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
			$arrContentData['Content']['content_meta_title'] = htmlspecialchars(addslashes($this->request->data['content_meta_title']));
			$arrContentData['Content']['content_meta_keyword'] = htmlspecialchars(addslashes($this->request->data['content_meta_keyword']));
			$arrContentData['Content']['content_meta_description'] = htmlspecialchars(addslashes($this->request->data['content_meta_description']));
			$arrContentData['Content']['content_type'] = $this->request->data['content_type'];
			$arrContentData['Content']['content_for_user'] = $this->request->data['content_user'];
			$arrContentData['Content']['content_meta_other'] = htmlspecialchars(addslashes($this->request->data['content_meta_other']));
			$arrContentData['Content']['content_widgets'] = "";
			$arrContentData['Content']['content_widgets'] = "";
			$arrContentData['Content']['left_content_widgets'] = "";
			$arrContentData['Content']['rightcontent_widgets'] = "";
			$arrContentData['Content']['content_related_products_assign'] = "";
			$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['content_pub_date']));
			$linkRegister='';
				
			if($this->request->data['content_type']==2)
			{
				 $linkRegister = $this->request->data['linkRegister'];
				
				
				$arrContentData['Content']['webinarRegisterLink'] = $linkRegister;
			}
			else
			{
				$arrContentData['Content']['webinarRegisterLink'] = $linkRegister;
			}
			
			if(isset($this->request->data['relate_products_ids']))
			{
				$arrContentData['Content']['content_related_products_assign'] = $this->request->data['relate_products_ids'];
			}
			
			if(isset($this->request->data['content_widgets']))
			{
				$arrContentData['Content']['content_widgets'] = $this->request->data['content_widgets'];
			}
			$arrContentData['Content']['content'] = htmlspecialchars(addslashes($this->request->data['main_content']));
			if(isset($this->request->data['leftcontent_widgets']))
			{
				$arrContentData['Content']['left_content_widgets'] = $this->request->data['leftcontent_widgets'];
			}
			
			$arrContentData['Content']['content_left_content'] = htmlspecialchars(addslashes($this->request->data['left_content']));
			if(isset($this->request->data['rightcontent_widgets']))
			{
				$arrContentData['Content']['rightcontent_widgets'] = $this->request->data['rightcontent_widgets'];
			}
			
			
			$arrContentData['Content']['content_right_content'] = htmlspecialchars(addslashes($this->request->data['right_content']));
			//echo "--".$intEditModeId = $this->request->data['content_edit_id'];exit;
			 $intEditModeId = $this->request->data['content_edit_id'];
		
			$arrContentData['Content']['content_status']  = "published";
			
			/*if($this->request->data['to_publish'])
			{
				$arrContentData['Content']['content_status']  = "published";
			}
			else
			{
				$arrContentData['Content']['content_status']  = null;
			}*/
			
			if($arrContentData['Content']['content_related_products_assign'])
			{
				$arrContentData['Content']['content_related_products_assign'] = rtrim($arrContentData['Content']['content_related_products_assign'],",");
			}
			
			if($arrContentData['Content']['content_widgets'])
			{
				$arrContentData['Content']['content_widgets'] = rtrim($arrContentData['Content']['content_widgets'],",");
			}
			if($arrContentData['Content']['rightcontent_widgets'])
			{
				$arrContentData['Content']['rightcontent_widgets'] = rtrim($arrContentData['Content']['rightcontent_widgets'],",");
			}
			if($arrContentData['Content']['left_content_widgets'])
			{
				$arrContentData['Content']['left_content_widgets'] = rtrim($arrContentData['Content']['left_content_widgets'],",");
			}
			$content_type = $arrContentData['Content']['content_type'];
			if($content_type==2)
			{
				
			}
			
			/*print("<pre>");
			print_r($arrContentData);
			exit;*/
			
			
			$this->loadModel('Content');
			$this->Content->set($arrContentData);
			if($this->Content->validates())
			{
				// edit here
				if($intEditModeId)
				{
					$boolContentUpdated = $this->Content->updateAll(
							array('content_default_category'=>"'".$arrContentData['Content']['content_default_category']."'", 'webinarRegisterLink' =>"'".$arrContentData['Content']['webinarRegisterLink']."'",'content_title_alias' => "'".$arrContentData['Content']['content_title_alias']."'",'content_title' => "'".$arrContentData['Content']['content_title']."'",'content_name' => "'".$arrContentData['Content']['content_name']."'",'content_layout'=>"'".$arrContentData['Content']['content_layout']."'",'content_banner_image'=>"'".$arrContentData['Content']['content_banner_image']."'",'content_intro_text'=>"'".$arrContentData['Content']['content_intro_text']."'",'content_meta_title'=>"'".$arrContentData['Content']['content_meta_title']."'",'content_meta_keyword'=>"'".$arrContentData['Content']['content_meta_keyword']."'",'content_meta_description'=>"'".$arrContentData['Content']['content_meta_description']."'",'content_meta_other'=>"'".$arrContentData['Content']['content_meta_other']."'",'content'=>"'".$arrContentData['Content']['content']."'",'content_left_content'=>"'".$arrContentData['Content']['content_left_content']."'",'content_right_content'=>"'".$arrContentData['Content']['content_right_content']."'",'content_status'=>"'".$arrContentData['Content']['content_status']."'",'content_published_date'=>"'".$arrContentData['Content']['content_published_date']."'",'content_for_user'=>"'".$arrContentData['Content']['content_for_user']."'",'content_type'=>"'".$arrContentData['Content']['content_type']."'"),
							array('content_id =' => $intEditModeId)
						);
					if($boolContentUpdated)
					{
					
						$compMessage = $this->Components->load('Message');
						$strForMessage = "You have successfully updated Content.";
						if($strDefaultCate == "4")
						{
							$strForMessage = "You have successfully updated Content.";
						}
						
						if($strDefaultCate == "99")
						{
							$strForMessage = "You have successfully updated page.";
						}
						if($strDefaultCate == "2")
						{
							$strForMessage = "You have successfully updated Affiliate.";
						}
						
						if($strDefaultCate == "3")
						{
							$strForMessage = "You have successfully updated News.";
						}
						
						if($strDefaultCate == "1")
						{
							$strForMessage = "You have successfully updated Industry.";
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
					$intContentExists = $this->Content->find('count', array(
									'conditions' => array('content_title' => $arrContentData['Content']['content_title'])
								));
					if($intContentExists)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('This Content is already present','info');
						$arrResponseData['status'] = 'fail';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
					else
					{
						/*echo "<pre>";
						print_R($arrContentData);
						exit();*/
						$boolContentCreated = $this->Content->save($arrContentData);
						if($boolContentCreated)
						{
							$intCreatedContentId = $this->Content->getLastInsertID();
							$arrResponseData['createdid'] = $intCreatedContentId;
							$arrResponseData['status'] = 'success';
							
							$this->loadModel('CategoriesAssignment');
							$arrCategoryData = array();
							$arrCategoryData['CategoriesAssignment']['category_id'] = $strDefaultCate;
							$arrCategoryData['CategoriesAssignment']['content_id'] = $intCreatedContentId;
							$this->CategoriesAssignment->create(false);
							$boolCatAssigned = $this->CategoriesAssignment->save($arrCategoryData);
						
						}
						$compMessage = $this->Components->load('Message');
						if($strDefaultCate == "4")
						{
							$strForMessage = "You have successfully added Content.";
						}
						
						if($strDefaultCate == "99")
						{
							$strForMessage = "You have successfully added page.";
						}
						if($strDefaultCate == "2")
						{
							$strForMessage = "You have successfully added Affiliate.";
						}
						
						if($strDefaultCate == "3")
						{
							$strForMessage = "You have successfully added News.";
						}
						
						if($strDefaultCate == "1")
						{
							$strForMessage = "You have successfully added Industry.";
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
				
				echo json_encode($arrResponseData);exit;
			}
		}
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
	
	public function mediauploader($isServiceImage = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($isServiceImage)
		{
			$view->set('forService',$isServiceImage);
		}
		
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
	
	public function parentcontentform($intContentId,$intCatForUser="3",$intContentType="1")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Content');
		$arrContentAllocatedParent = $this->Content->fnGetContentParentData($intContentId,$intCatForUser);
		$view->set('arrContentAllocatedParent',$arrContentAllocatedParent);
		$view->set('strContentId',$intContentId);
		$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null,'content_id !='=>$intContentId,'content_for_user'=>$intCatForUser)));
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
	
	public function parentcatcontentform($intContentId="0",$intCatForUser="3",$strParenCatType = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Categories');
		$arrContentAllocatedParent = $this->Categories->fnGetCatContentParentData($intContentId,$intCatForUser);
		$view->set('arrContentAllocatedParent',$arrContentAllocatedParent);
		$view->set('strContentId',$intContentId);
		$arrParentProductList = $this->Categories->find('all',array('conditions'=>array('content_category_id !='=>$intContentId,'content_cat_for_user'=>$intCatForUser,'content_category_parent_id !='=>$intContentId,"job_process_type"=>$strParenCatType)));
		
		//$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
		$view->set('arrProductParentList',$arrParentProductList);
		/*print("<pre>");
		print_r($arrParentProductList);
		exit;*/
		$strContentParentHtml = $view->element('content_cat_parent');
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
	
	public function contentcategoryassform($intContentId = "0",$intCatUser = "",$strCatType = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		
		$this->loadModel('Categories');
		if($strCatType)
		{                                                                                                                                                         
			$arrCatList = $this->Categories->find('all',array('conditions'=>array('category_type'=>'0','content_category_parent_id'=>'0','content_cat_for_user'=>$intCatUser,'job_search_category'=>'1')));

		}
		else
		{
			$arrCatList = $this->Categories->find('all',array('conditions'=>array('category_type'=>'0','content_category_parent_id'=>'0','content_cat_for_user'=>$intCatUser,'job_search_category'=>'0')));
		}
		/*print("<pre>");
		print_r($arrCatList);
		exit();*/
		
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('CategoriesAssignment');
		$arrContentCatAssigned = $this->CategoriesAssignment->find('list',array('fields'=>array('content_category_assig_id','category_id'),'conditions'=>array('content_id'=>$intContentId)));
		$view->set('arrCatAssigned', $arrContentCatAssigned);
		$view->set('arrCatList', $arrCatList);
		if(!$intContentId)
		{
			$intContentId = "";
		}
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
