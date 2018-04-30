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
class VendorservicesController extends AppController {

	public $components = array('Paginator');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = "admin";
	public $name = 'Vendorservices';
	
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
				$this->loadModel('Resources');
				$arrContentDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$intProductId)));
				if(is_array($arrContentDetail) && (count($arrContentDetail)>0))
				{
					if($arrContentDetail[0]['Resources']['content_added'])
					{
						$this->loadModel('Content');
						$arrRContentDetail = $this->Content->find('all',array('conditions'=>array('resource_id'=>$intProductId)));
						
						$this->loadModel('ResourcesImages');
						$arrContentDetailImages = $this->ResourcesImages->find('all',array('conditions'=>array('product_id'=>$intProductId),'limit'=>'1'));
						
						if(is_array($arrRContentDetail) && (count($arrRContentDetail)>0))
						{
							$arrContentDetail[0]['Content'] = $arrRContentDetail[0]['Content'];
							$arrContentDetail[0]['Resourceimages'] = $arrContentDetailImages[0]['ResourcesImages'];
						}
					}
				}
				$this->set('arrContentDetail',$arrContentDetail);
			}
		}
	}
	
	public function serviceimagedelete($intProductId)
	{
		$arrResponse = array();
		if($intProductId)
		{
			
			$this->loadModel('ResourcesImages');
			$intCorrectProductId = $this->ResourcesImages->find('count',array('conditions'=>array('product_images_id'=>$intProductId)));
			if($intCorrectProductId)
			{
				$intContentDeleted = $this->ResourcesImages->deleteAll(array('product_images_id' => $intProductId),false);
				if($intContentDeleted)
				{
					
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
	
	public function changeVendorServiceStatus($intProductId)
	{
		$arrResponse = array();
		if($intProductId)
		{
			
			$this->loadModel('Vendorservice');
			$arrCorrectProductId = $this->Vendorservice->find('all',array('conditions'=>array('vendor_service_id'=>$intProductId)));
			if(is_array($arrCorrectProductId) && (count($arrCorrectProductId)>0))
			{
				$strCurrentStatus = $arrCorrectProductId[0]['Vendorservice']['status'];
				if($strCurrentStatus == "Active")
				{
					$strNewStatus = "Inactive";
					$strNewActStatus = "Activate";
				}
				
				if($strCurrentStatus == "Inactive")
				{
					$strNewStatus = "Active";
					$strNewActStatus = "Inactivate";
				}
				
				$isUpdated = $this->Vendorservice->updateAll(
					array('status'=>"'".$strNewStatus."'"),
					array('vendor_service_id =' => $intProductId)
				);
				
				if($isUpdated)
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('Status has been updated successfully','success');
					$this->set('strMessage',$strMessage);
					
					$arrResponse['status'] = "success";
					$arrResponse['message'] = $strMessage;
					$arrResponse['newstatus'] = ucfirst($strNewStatus);
					$arrResponse['newactstatus'] = ucfirst($strNewActStatus);
					
					echo json_encode($arrResponse);exit;
				}
				else
				{
					$compMessage = $this->Components->load('Message');
					$strMessage = $compMessage->fnGenerateMessageBlock('There is some problem, please try again','error');
					
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
	
	public function productdelete($intProductId)
	{
		$arrResponse = array();
		if($intProductId)
		{
			
			$this->loadModel('Vendorservice');
			$arrCorrectProductId = $this->Vendorservice->find('all',array('conditions'=>array('vendor_service_id'=>$intProductId)));
			if(is_array($arrCorrectProductId) && (count($arrCorrectProductId)>0))
			{
				$this->loadModel('Vendors');
				$this->loadModel('Resources');
				
				$arrVendDet = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrCorrectProductId[0]['Vendorservice']['vendor_id'],"vendor_type"=>"Course")));
				$arrResourcesDet = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrCorrectProductId[0]['Vendorservice']['service_id'],"product_type"=>"Course")));
				
				if(is_array($arrVendDet) && (count($arrVendDet)>0))
				{
					if(is_array($arrResourcesDet) && (count($arrResourcesDet)>0))
					{
						$arrCourseData['Resources']['product_name'] = $arrResourcesDet[0]['Resources']['product_name'];
						$arrCourseData['Resources']['external_content_id'] = $arrResourcesDet[0]['Resources']['external_content_id'];
						$arrCourseData['Resources']['categoryid'] = "1";
						
						$compLms = $this->Components->load('LmsBridge');
						$arrCourseCreated = $compLms->fnUpdateLmsCourse($arrCourseData);
						if($arrCourseCreated['status'] == "success")
						{
							
							$intContentDeleted = $this->Vendorservice->deleteAll(array('vendor_service_id' => $intProductId),false);
							$this->loadModel('substepProducts');	
							$intContentDeleted = $this->substepProducts->deleteAll(array('vendor_service_id' => $intProductId),false);
							if($intContentDeleted)
							{
								
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
							$strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again','error');
							$arrResponseData['status'] = 'fail';
							$arrResponseData['message'] = $strMessage;
							echo json_encode($arrResponseData);exit;
						}
					}
					else
					{
						$intContentDeleted = $this->Vendorservice->deleteAll(array('vendor_service_id' => $intProductId),false);
						if($intContentDeleted)
						{
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
				}
				else
				{
					
					if(is_array($arrVendDet) && (count($arrVendDet)>0))
					{
						$intContentDeleted = $this->Vendorservice->deleteAll(array('vendor_service_id' => $intProductId),false);
						if($intContentDeleted)
						{
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
						$intContentDeleted = $this->Vendorservice->deleteAll(array('vendor_service_id' => $intProductId),false);
						if($intContentDeleted)
						{
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
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_service_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'resource','action'=>'index'),true));
		
		$this->loadModel('Vendorservice');
		$this->Vendorservice->recursive = 0;
		$this->Paginator->settings = array(
			'Vendorservice' => array(
				'limit' => 20,
				'conditions' => array('vendor_name'=>$strKeywordSearch)
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('Vendorservice');
		/*print("<pre>");
		print_r($arrProductContentList);exit;*/
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$this->loadModel('Vendors');
				$arrVendorDetail = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrProductContent['vendor_service']['vendor_id'])));
				
				if(is_array($arrVendorDetail) && count($arrVendorDetail)>0)
				{
					foreach($arrVendorDetail as $arrVendDetail)
					{
						$arrProductContentList[$intProductCount]['Vendors'] = $arrVendDetail['Vendors'];
					}
				}
				
				$this->loadModel('Resources');
				$arrResourcesDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrProductContent['vendor_service']['service_id'])));
				
				if(is_array($arrResourcesDetail) && count($arrResourcesDetail)>0)
				{
					foreach($arrResourcesDetail as $arrResDetail)
					{
						$arrProductContentList[$intProductCount]['Resources'] = $arrResDetail['Resources'];
					}
				}
				
				$intProductCount++;
			}
		}
		$this->set('arrProductList',$arrProductContentList);
		$this->set('strKeywordSearch',$strKeywordSearch);
	
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no vendors with provided name','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function serviceimagessearch($strKeywordSearch)
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/serviceimage_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'resource','action'=>'index'),true));
		
		$this->loadModel('ResourcesImages');
		$this->ResourcesImages->recursive = 0;
		$this->Paginator->settings = array(
			'ResourcesImages' => array(
				'limit' => 20,
				'conditions' => array('product_image'=>$strKeywordSearch)
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('ResourcesImages');
		/*print("<pre>");
		print_r($arrProductContentList);exit;*/
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$intProductCount = 0;
			$this->loadModel('Resources');
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrProductContent['product_images']['product_id'])));
				if(is_array($isContentParent) && (count($isContentParent)>0))
				{
					$arrProductContentList[$intProductCount]['product_images']['service'] = $isContentParent[0]['Resources']['product_name']; 
				}
				$intProductCount++;
			}
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
	
	public function serviceimages() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/serviceimage_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'index'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			
			$this->redirect(array('controller'=>'resource','action'=>'serviceimagessearch',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('ResourcesImages');
		$this->ResourcesImages->recursive = 0;
		$this->Paginator->settings = array(
			'ResourcesImages' => array(
				'limit' => 20
			)
		);

		$arrProductContentList = $this->Paginator->paginate('ResourcesImages');
		//print("<pre>");
		//print_r($arrProductContentList);
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$intProductCount = 0;
			$this->loadModel('Resources');
			foreach($arrProductContentList as $arrProductContent)
			{
				$isContentParent = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrProductContent['product_images']['product_id'])));
				if(is_array($isContentParent) && (count($isContentParent)>0))
				{
					$arrProductContentList[$intProductCount]['product_images']['service'] = $isContentParent[0]['Resources']['product_name']; 
				}
				$intProductCount++;
			}
		}
		
		$this->set('arrProductList',$arrProductContentList);
		
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no images present, Please upload one','info');
			$this->set('strMessage',$strMessage);
		}
	}
	
	public function index() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_service_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$this->Session->write('strCancelUrl',Router::url(array('controller'=>'content','action'=>'index'),true));
		if($this->request->is('Post') && ($this->request->data['filter_on']))
		{
			$strProductFilterKeyword = $this->request->data['product_keyword'];
			$this->redirect(array('controller'=>'vendorservices','action'=>'search',$strProductFilterKeyword));
		}
		
		
		$this->loadModel('Vendorservice');
		$this->Vendorservice->recursive = 0;
		$this->Vendorservice->settings = array(
			'Vendorservice' => array(
				'limit' => 20
			)
		);
		
		$arrProductContentList = $this->Paginator->paginate('Vendorservice');
		
		
		if(is_array($arrProductContentList) && (count($arrProductContentList)>0))
		{
			$this->loadModel('Vendors');
			$this->loadModel('Portal');
			$intProductCount = 0;
			foreach($arrProductContentList as $arrProductContent)
			{
				$intVendorServiceType = $arrProductContent['vendor_service']['vendor_service_type'];
				
				if($intVendorServiceType == "Product")
				{
					$arrVendorDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_id'=>$arrProductContent['vendor_service']['vendor_id'])));
					if(is_array($arrVendorDetail) && count($arrVendorDetail)>0)
					{
						foreach($arrVendorDetail as $arrVendDetail)
						{
							$arrProductContentList[$intProductCount]['vendors']['vendor_name'] = $arrVendDetail['Portal']['career_portal_name'];
							$arrProductContentList[$intProductCount]['vendors']['vendor_id'] = $arrVendDetail['Portal']['career_portal_id'];
						}
					}
					
					$this->loadModel('Resources');
					$arrResourcesDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrProductContent['vendor_service']['service_id'])));
					
					if(is_array($arrResourcesDetail) && count($arrResourcesDetail)>0)
					{
						foreach($arrResourcesDetail as $arrResDetail)
						{
							$arrProductContentList[$intProductCount]['Resources'] = $arrResDetail['Resources'];
						}
					}
				}
				else
				{
					$arrVendorDetail = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrProductContent['vendor_service']['vendor_id'])));
			
					if(is_array($arrVendorDetail) && count($arrVendorDetail)>0)
					{
						foreach($arrVendorDetail as $arrVendDetail)
						{
							//$arrProductContentList[$intProductCount]['Vendors'] = $arrVendDetail['Vendors'];
							$arrProductContentList[$intProductCount]['vendors']['vendor_name'] = $arrVendDetail['Vendors']['vendor_first_name']." ".$arrVendDetail['Vendors']['vendor_last_name'];
							$arrProductContentList[$intProductCount]['vendors']['vendor_id'] = $arrVendDetail['Vendors']['vendor_id'];
						}
					}
					
					$this->loadModel('Resources');
					$arrResourcesDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrProductContent['vendor_service']['service_id'])));
					
					if(is_array($arrResourcesDetail) && count($arrResourcesDetail)>0)
					{
						foreach($arrResourcesDetail as $arrResDetail)
						{
							$arrProductContentList[$intProductCount]['Resources'] = $arrResDetail['Resources'];
						}
					}
				}
				$intProductCount++;
			}
		}
		//print("<pre>");
		//print_r($arrProductContentList);
		//exit;
		$this->set('arrProductList',$arrProductContentList);
		
		//$arrProductContentList = $this->Content->fnGetProductList();
		
		if(count($arrProductContentList)==0)
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('There are no Vendor to service allocation created, Please create one','info');
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
			
			
			$this->loadModel('Vendors');
			//$arrProductContent = $this->Content->fnGetProduct($intProductId);
			$arrProductContent = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$intProductId)));
			
			/*print("<pre>");
			print_r($arrProductContent);
			exit;*/
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
					//$arrCategories[] = $strDefaultCategory;
					$arrCategories = array_unique($arrCategories);
					/*print("<pre>");
					print_r($arrCategories);
					exit;*/
					
					$boolSaveFlag = "0";
					if(is_array($arrCategories) && (count($arrCategories)>0))
					{
						//$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>'4'),false);
						$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId),false);
						
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
						$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId),false);
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
					
					//$intAssignedCategoryDeleted = $this->CategoriesAssignment->fnClearCategories($intContentId,$strDefaultCategory);
					$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId),false);
					
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
	
	public function addimage()
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
		$this->loadModel('Resources');
		$arrResourceList = $this->Resources->find('all',array('conditions'=>array('product_publish_status'=>"1")));
		$this->set('arrResourceList',$arrResourceList);
		
		$this->set('strDateFormat',Configure::read('Productdate.format'));
		
		if($this->request->is('Post'))
		{
			/*print('<pre>');
			print_r($this->request->data);
			exit;*/
			
			//echo "HI";exit;
			
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
			$arrContentData['Content']['content_default_category'] = $strDefaultCate;
			$arrContentData['Content']['content_intro_text'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
			$arrContentData['Content']['content'] = htmlspecialchars(addslashes($this->request->data['main_content']));
			$arrContentData['Content']['content_type'] = "1";
			$arrContentData['Content']['content_for_user'] = "4";
			$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['content_pub_date']));
			$intEditModeId = $this->request->data['content_edit_id'];
			
			$arrContentData['Resources']['product_name'] = $this->request->data['service_name'];
			$arrContentData['Resources']['product_cost'] = $this->request->data['service_cost'];
			$arrContentData['Resources']['product_type'] = "Services";
			if($this->request->data['to_publish'])
			{
				$arrContentData['Resources']['product_publish_status'] = "1";
				$arrContentData['Content']['content_status']  = "published";
			}
			else
			{
				$arrContentData['Resources']['product_publish_status'] = null;
				$arrContentData['Content']['content_status']  = null;
			}

			$this->loadModel('Resources');
			if($intEditModeId)
			{	
				$boolContentUpdated = $this->Resources->updateAll(
						array('product_name'=>"'".$arrContentData['Resources']['product_name']."'",'product_publish_status' => "'".$arrContentData['Resources']['product_publish_status']."'",'product_type' => "'".$arrContentData['Resources']['product_type']."'",'product_cost' => "'".$arrContentData['Resources']['product_cost']."'"),
						array('productd_id =' => $intEditModeId)
					);
				if($boolContentUpdated)
				{
					$compMessage = $this->Components->load('Message');
					$strForMessage = "Updation was successfull.";						
					$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
					$arrResponseData['status'] = 'success';
					$arrResponseData['message'] = $strMessage;
					$isContentAdded = "0";
					if($arrContentData['Content']['content'] || $arrContentData['Content']['content_intro_text'])
					{
						$this->loadModel('Content');
						$boolContentUpdated = $this->Content->updateAll(
							array('content_default_category'=>"'".$arrContentData['Content']['content_default_category']."'",'content_title_alias' => "'".$arrContentData['Content']['content_title_alias']."'",'content_title' => "'".$arrContentData['Content']['content_title']."'",'content_name' => "'".$arrContentData['Content']['content_name']."'",'content_intro_text'=>"'".$arrContentData['Content']['content_intro_text']."'",'content'=>"'".$arrContentData['Content']['content']."'",'content_status'=>"'".$arrContentData['Content']['content_status']."'",'content_type'=>"'".$arrContentData['Content']['content_type']."'"),
							array('resource_id =' => $intEditModeId)
						);
						
						if($boolContentUpdated)
						{
							$isContentAdded = "1";
						}
					}
					else
					{
						$this->loadModel('Content');
						$isDeleted = $this->Content->deleteAll(array('resource_id' => $intEditModeId),false);
						if($isDeleted)
						{
							$isContentAdded = "0";
						}
					}
					$boolContentUpdated = $this->Resources->updateAll(
						array('content_added'=>"'".$isContentAdded ."'"),
						array('productd_id =' => $intEditModeId)
					);
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
				$intContentExists = $this->Resources->find('count', array(
									'conditions' => array('product_name' => $arrContentData['Resources']['product_name'])
								));
					if($intContentExists)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('This Service is already present','info');
						$arrResponseData['status'] = 'fail';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
					else
					{
						$boolContentCreated = $this->Resources->save($arrContentData);
						if($boolContentCreated)
						{
							$intCreatedContentId = $this->Resources->getLastInsertID();
							$arrResponseData['createdid'] = $intCreatedContentId;
							$arrResponseData['status'] = 'success';
							
							$this->loadModel('Content');
							$arrContentData['Content']['resource_id'] = $intCreatedContentId;
							
							$arrContentAdded = $this->Content->save($arrContentData);
							if(is_array($arrContentAdded) && (count($arrContentAdded)>0))
							{
								$boolContentUpdated = $this->Resources->updateAll(
									array('content_added'=>"'1'"),
									array('productd_id =' => $intCreatedContentId)
								);
							}
						}
						$compMessage = $this->Components->load('Message');
						$strForMessage = "You have successfully created Service.";
						$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
			}
		}
	}
	
	public function contentadd()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponseData = array();
		
		if($this->request->is('Post'))
		{
			
			$arrResponseData = array();
			$intEditModeId = "";
			$arrContentData = array();
			$strRequestFor = $this->request->data['content_request_for'];
			$strDefaultCate = '0';
			$arrContentData['Content']['content_title'] = htmlspecialchars(addslashes($this->request->data['content_title']));
			$arrContentData['Content']['content_title_alias'] = htmlspecialchars(addslashes($this->request->data['content_title_alias']));
			$arrContentData['Content']['content_name'] = addslashes($this->request->data['content_name']);
			$arrContentData['Content']['content_default_category'] = $strDefaultCate;
			$arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['content_pub_date']));
			$arrContentData['Content']['content_intro_text'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
			$arrContentData['Content']['content'] = htmlspecialchars(addslashes($this->request->data['main_content']));

			$arrContentData['Content']['vendor_id'] = $intEditModeId = $this->request->data['content_edit_id'];
			
			
			if($this->request->data['to_publish'])
			{
				$arrContentData['Content']['content_status']  = "published";
			}
			else
			{
				$arrContentData['Content']['content_status']  = null;
			}
			//echo $intEditModeId;exit;
			
			$this->loadModel('Content');
			$this->Content->set($arrContentData);
			if($this->Content->validates())
			{
				// edit here
				if($intEditModeId)
				{
					$isContentExists = $this->Content->find('count',array('conditions'=>array('vendor_id'=>$intEditModeId)));
					if($isContentExists)
					{
						$boolContentUpdated = $this->Content->updateAll(
							array('content_default_category'=>"'".$arrContentData['Content']['content_default_category']."'",'content_title_alias' => "'".$arrContentData['Content']['content_title_alias']."'",'content_title' => "'".$arrContentData['Content']['content_title']."'",'content_intro_text'=>"'".$arrContentData['Content']['content_intro_text']."'",'content'=>"'".$arrContentData['Content']['content']."'",'content_status'=>"'".$arrContentData['Content']['content_status']."'",'content_published_date'=>"'".$arrContentData['Content']['content_published_date']."'"),
							array('vendor_id =' => $intEditModeId)
						);
						if($boolContentUpdated)
						{
							$compMessage = $this->Components->load('Message');
							$strForMessage = "You have successfully updated Content.";

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
						$boolContentCreated = $this->Content->save($arrContentData);
						if($boolContentCreated)
						{
							$intCreatedContentId = $this->Content->getLastInsertID();
							$arrResponseData['createdid'] = $intCreatedContentId;
							$arrResponseData['status'] = 'success';
						}
						$compMessage = $this->Components->load('Message');
						$strForMessage = "You have successfully added Content.";
						$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
				}
				else
				{
					$arrResponseData['status'] = 'fail';
					$compMessage = $this->Components->load('Message');
					$strForMessage = "Something is missing, Please try again.";
					$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
					$arrResponseData['message'] = $strMessage;
					echo json_encode($arrResponseData);exit;
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
	
	public function getservicedetails($intServiceId = "")
	{
		$this->layout = false;
		$this->autoRender = false;
		$arrResponse = array();
		
		if($intServiceId)
		{
			$this->loadModel('Resources');
			$arrResources = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$intServiceId)));
			if(is_array($arrResources) && (count($arrResources)>0))
			{
				$arrResponse['status'] = 'success';
				$arrResponse['cost'] = $arrResources[0]['Resources']['product_cost'];
			}
			else
			{
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = 'There is no such service present';
			}
		}
		else
		{
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = 'Parameter missing';
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function testrefund()
	{
		Configure::write('debug','2');
		$this->autoRender = false;
		$this->layout = NULL;
		$compAuth = $this->Components->load('Authorize');
		$compAuth->fnRefundTransaction();
		
	}
	
	public function initiateRefund($intOrderId = "")
	{
		Configure::write('debug','2');
		$arrResponse = array();
		$this->autoRender = false;
		$this->layout = NULL;
		$compMessage = $this->Components->load('Message');
		if($intOrderId)
		{
			$this->loadModel('Resourceorderdetail');
			$arrOrderDetail = $this->Resourceorderdetail->find('all',array(
				'fields'=>array('Resourceorderdetail.*','Resourceorder.*'),
				'joins' => array(
								array(
						'table' => 'resource_order',
						'alias' => 'Resourceorder',
						'type' => 'inner',				
						'conditions'=> array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
						)
					),
				'conditions'=>array('order_detail_id'=>$intOrderId)
			));
			//print("<pre>");
			//print_r($arrOrderDetail);
			//exit;
			if(is_array($arrOrderDetail) && (count($arrOrderDetail)>0))
			{
				$compAuth = $this->Components->load('Authorize');
				$arrTransactionResult = $compAuth->fnRefundTransaction($arrOrderDetail);
				if(is_array($arrTransactionResult) && (count($arrTransactionResult)>0))
				{
					if($arrTransactionResult['status'] == "success")
					{
						$boolContentUpdated = $this->Resourceorderdetail->updateAll(
							array('refund_status'=>"'1'",'refund_transaction_id' => "'".$arrTransactionResult['transid']."'"),
							array('order_detail_id =' => $arrOrderDetail[0]['Resourceorderdetail']['order_detail_id'])
						);
						
						$arrResponse['status'] = "success";						
						$strForMessage = "Order Cancelled & Refund Initiated Successfully";					
						$arrResponse['message'] =  $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
						
						$arrResponse['messagenew'] = "Order Cancelled & Refund Initiated Successfully";	
					}
					else
					{
						$arrResponse['status'] = "fail";
						$strForMessage = $arrTransactionResult['message'];
						$arrResponse['message'] = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
					}
				}
				else
				{
					$arrResponse['status'] = "fail";
					$strForMessage = "There is some problem, Please try again.";
					$arrResponse['message'] = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
				}
				
			}
			else
			{
				$arrResponse['status'] = "fail";
				$strForMessage = "Please provide order Id";
				$arrResponse['message'] = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$strForMessage = "Please provide order Id";
			$arrResponse['message'] = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
			
		}
		echo json_encode($arrResponse);
		exit;
		
		
	}
	
	public function sales()
	{
		//Configure::write('debug','2');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		$this->loadModel('Vendors');
		//$this->loadModel('Subvendororders');
		$arrNewOrders = $this->Resourceorderdetail->find('all',array('order'=>array('order_detail_id'=>'desc')));
		
		//print("<pre>");
		//print_r($arrNewOrders);
		//exit;
		
		if(is_array($arrNewOrders) && count($arrNewOrders)>0)
		{
			$this->loadModel('Resourceorder');
			$this->loadModel('Candidate');
			$this->loadModel('Resources');
			$intFrCnt = 0;
			foreach($arrNewOrders as $arrOrder)
			{
				
				$intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
				$arrOrderDetail = $this->Resourceorder->find('all',array('conditions'=>array('resource_order_id'=>$intOrderId)));
				if(is_array($arrOrderDetail) && (count($arrOrderDetail)>0))
				{
					$arrNewOrders[$intFrCnt]['mainorder'] = $arrOrderDetail[0];
				}
				$intServiceId = $arrOrder['Resourceorderdetail']['product_id'];
				$arrServiceDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$intServiceId)));
				if(is_array($arrServiceDetail) && (count($arrServiceDetail)>0))
				{
					$arrNewOrders[$intFrCnt]['service'] = $arrServiceDetail[0];
				}
				$intCustomerId = $arrOrder['Resourceorderdetail']['seeker_id'];
				$arrCustomerDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$intCustomerId)));
				if(is_array($arrCustomerDetail) && (count($arrCustomerDetail)>0))
				{
					$arrNewOrders[$intFrCnt]['customer'] = $arrCustomerDetail[0];
				}
				
				$arrSubVendorsFor = $this->Vendors->find('all',array(
				'fields'=>array('Vendors.*'),
				'joins' => array(
								array(
						'table' => 'resource_order_detail',
						'alias' => 'Resourceorderdetail',
						'type' => 'left',				
						'conditions'=> array('Vendors.vendor_id=Resourceorderdetail.vendor_id')
						)
					),
				'conditions'=>array('Resourceorderdetail.order_id'=>$intOrderId)
				));
				
				
				/*$arrSubVendorsFor = $this->Subvendororders->find('all',array(
				'fields'=>array('Vendors.*','Subvendororders.*'),
				'joins' => array(
								array(
						'table' => 'vendors',
						'alias' => 'Vendors',
						'type' => 'left',				
						'conditions'=> array('Subvendororders.vendor_id=Vendors.vendor_id')
						)
					),
				'conditions'=>array('order_id'=>$intOrderId)
				));*/
				
				
				//print("<pre>");
				//print_r($arrSubVendorsFor);
				
				$arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
				
				/*if(is_array($arrSubVendorsFor) && (count($arrSubVendorsFor)>0))
				{
					$arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
				}
				else
				{
					
				}*/
				$intFrCnt++;
			}
		}
		
		//print("<pre>");
		//print_r($arrNewOrders);
		
		$this->set('arrProductList',$arrNewOrders);
		
	}
	
	public function gettypevendorproducts()
	{
		//Configure::write('debug','2');
		$arrResponse = array();
		$this->autoRender = false;
		$this->layout = NULL;
		$strType = "";
		$strType = $this->request->data['type'];
		//$strType = "Product";
		$compMessage = $this->Components->load('Message');
		
		if($strType)
		{
			$view = new View($this, false);
			//$strType = $this->request->data['type'];
			if($strType == "Services")
			{
				$this->loadModel('Vendors');
				$arrVendorDetails = $this->Vendors->find('all',array('conditions'=>array('vendor_type'=>$strType)));
			}
			else if($strType == "Course")
			{
				$this->loadModel('Vendors');
				$arrVendorDetails = $this->Vendors->find('all',array('conditions'=>array('vendor_type'=>$strType)));
			}
			else
			{
				$this->loadModel('User');
				$arrVendorDetails = $this->User->find('all',array(
				'fields'=>array('User.*','Portal.*','Owner.*'),
				'joins' => array(
						array(
							'table' => 'career_portal',
							'alias' => 'Portal',
							'type' => 'inner',				
							'conditions'=> array('User.portal_id = Portal.career_portal_id')
						),
						array(
							'table' => 'employer_detail',
							'alias' => 'Owner',
							'type' => 'inner',				
							'conditions'=> array('User.id = Owner.employer_id')
						)
					),
				'conditions'=>array('User.is_active'=>'1')
				));
				
				if(is_array($arrVendorDetails) && (count($arrVendorDetails)>0))
				{
					$arrVendorDetail = array();
					$intVendorCnt = 0;
					foreach($arrVendorDetails as $arrVendor)
					{
						$arrVendorDetail[$intVendorCnt]['Vendors']['vendor_id'] = $arrVendor['Portal']['career_portal_id'];
						$arrVendorDetail[$intVendorCnt]['Vendors']['vendor_name'] = $arrVendor['Portal']['career_portal_name'];
						$intVendorCnt++;
					}
					$arrVendorDetails = $arrVendorDetail;
				}
			}
			
			$arrVendorServiceDetail['Vendors'] = $arrVendorDetails;
			$this->loadModel('Resources');
			$arrResourcesDetails = $this->Resources->find('all',array('conditions'=>array('product_type like'=> '%'.$strType.'%')));
			//print("<pre>");
			//print_r($arrResourcesDetails);
			//exit;
			
			$arrVendorServiceDetail['Services'] = $arrResourcesDetails;
			$view->set('arrVendorServiceDetail',$arrVendorServiceDetail);
			if($strType == "Services")
			{
				$strFileUploaderHtml = $view->element('servicevendors', $params);
			}
			else if($strType == "Course")
			{
				$strFileUploaderHtml = $view->element('coursevendors', $params);
			}
			else
			{
				$strFileUploaderHtml = $view->element('productvendors', $params);
			}
			
			if($strFileUploaderHtml)
			{
				$arrRespnse['status'] = 'success';
				$arrRespnse['html'] = $strFileUploaderHtml;
			}
			else
			{
				$arrRespnse['status'] = 'fail';
				$strForMessage = "There is some issue, Please try again.";						
				$arrRespnse['message'] = $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
			}
		}
		else
		{
			$arrRespnse['status'] = 'fail';
			$strForMessage = "There is some issue, Please try again.";						
			$arrRespnse['message'] = $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'error');
		}
		echo json_encode($arrRespnse);
		exit;
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
			//print('<pre>');
			//print_r($this->request->data);
			//exit;
			
			//echo "HI";exit;
			
			$arrResponseData = array();
			$intEditModeId = "";
			$arrContentData = array();
			$strRequestFor = $this->request->data['content_request_for'];
			$strDefaultCate = '0';
			if($this->request->data['content_request_for_id'])
			{
				$strDefaultCate = $this->request->data['content_request_for_id'];
			}
			$arrContentData['Vendorservice']['vendor_id'] = addslashes($this->request->data['vendor']);
			$arrContentData['Vendorservice']['service_id'] = addslashes($this->request->data['service']);
			$arrContentData['Vendorservice']['service_cost'] = addslashes($this->request->data['service_cost']);
			$arrContentData['Vendorservice']['vendor_cost'] = addslashes($this->request->data['vendor_cost']);
			$arrContentData['Vendorservice']['merchant_cost'] = addslashes($this->request->data['merchant_cost']);
			$arrContentData['Vendorservice']['portal_cost'] = $this->request->data['portal_cost'];
			$arrContentData['Vendorservice']['hc_cost'] = $this->request->data['hc_cost'];
			$arrContentData['Vendorservice']['merchant_cost_type'] = addslashes($this->request->data['merchant_cost_type']);
			$arrContentData['Vendorservice']['portal_cost_type'] = $this->request->data['portalowner_cost_type'];
			$arrContentData['Vendorservice']['hc_cost_type'] = $this->request->data['hc_cost_type'];
			$arrContentData['Vendorservice']['vendor_service_type'] = $this->request->data['product_type'];
			
			//print("<pre>");
			//print_r($arrContentData);
			//exit;
			
			$intEditModeId = $this->request->data['content_edit_id'];

			$this->loadModel('Vendorservice');
			if($intEditModeId)
			{	
				$boolContentUpdated = $this->Vendorservice->updateAll(
						array('vendor_id'=>"'".$arrContentData['Vendorservice']['vendor_id']."'",'service_id' => "'".$arrContentData['Vendorservice']['service_id']."'",'service_cost' => "'".$arrContentData['Vendorservice']['service_cost']."'",'vendor_cost'=> "'".$arrContentData['Vendorservice']['vendor_cost']."'","merchant_cost"=>"'".$arrContentData['Vendorservice']['merchant_cost']."'","portal_cost"=>"'".$arrContentData['Vendorservice']['portal_cost']."'","hc_cost"=>"'".$arrContentData['Vendorservice']['hc_cost']."'","merchant_cost_type"=>"'".$arrContentData['Vendorservice']['merchant_cost_type']."'","portal_cost_type"=>"'".$arrContentData['Vendorservice']['portal_cost_type']."'","hc_cost_type"=>"'".$arrContentData['Vendorservice']['hc_cost_type']."'",'vendor_service_type'=>"'".$arrContentData['Vendorservice']['vendor_service_type']."'"),
						array('vendor_service_id =' => $intEditModeId)
					);
				if($boolContentUpdated)
				{
					$compMessage = $this->Components->load('Message');
					$strForMessage = "Updation was successfull.";						
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
				$intContentExists = $this->Vendorservice->find('count', array(
									'conditions' => array('vendor_id' => $arrContentData['Vendors']['vendor_id'],"service_id"=>$arrContentData['Vendors']['service_id'])
								));
					if($intContentExists)
					{
						$compMessage = $this->Components->load('Message');
						$strMessage = $compMessage->fnGenerateMessageBlock('These details are already present','info');
						$arrResponseData['status'] = 'fail';
						$arrResponseData['message'] = $strMessage;
						echo json_encode($arrResponseData);exit;
					}
					else
					{
						$this->loadModel('Vendors');
						$this->loadModel('Resources');
						
						$arrVendDet = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrContentData['Vendorservice']['vendor_id'],"vendor_type"=>"Course")));
						$arrResourcesDet = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$arrContentData['Vendorservice']['service_id'],"product_type like"=>"%Course%")));
						
						if(is_array($arrVendDet) && (count($arrVendDet)>0))
						{
							if(is_array($arrResourcesDet) && (count($arrResourcesDet)>0))
							{
								$arrCourseData['Resources']['product_name'] = $arrResourcesDet[0]['Resources']['product_name'];
								$arrCourseData['Resources']['external_content_id'] = $arrResourcesDet[0]['Resources']['external_content_id'];
								$arrCourseData['Resources']['categoryid'] = $arrVendDet[0]['Vendors']['vendor_category_id'];
								
								
								
								$compLms = $this->Components->load('LmsBridge');
								$arrCourseCreated = $compLms->fnUpdateLmsCourse($arrCourseData);
								//echo '<pre>';print_r($arrCourseCreated);exit();
								if($arrCourseCreated['status'] == "success")
								{
									$boolContentCreated = $this->Vendorservice->save($arrContentData);
									if($boolContentCreated)
									{
										$intCreatedContentId = $this->Vendorservice->getLastInsertID();
										$arrResponseData['createdid'] = $intCreatedContentId;
										$arrResponseData['status'] = 'success';
									}
									$compMessage = $this->Components->load('Message');
									$strForMessage = "You have successfully added the details.";
									$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
									$arrResponseData['message'] = $strMessage;
									echo json_encode($arrResponseData);exit;
								}
								else
								{
									$compMessage = $this->Components->load('Message');
									$strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again','error');
									$arrResponseData['status'] = 'fail';
									$arrResponseData['message'] = $strMessage;
									echo json_encode($arrResponseData);exit;
								}
							}
							else
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('This Assignment is not possible','info');
								$arrResponseData['status'] = 'fail';
								$arrResponseData['message'] = $strMessage;
								echo json_encode($arrResponseData);exit;
							}
						}
						else
						{
							
							if(is_array($arrVendDet) && (count($arrVendDet)>0))
							{
								$compMessage = $this->Components->load('Message');
								$strMessage = $compMessage->fnGenerateMessageBlock('This Assignment is not possible','info');
								$arrResponseData['status'] = 'fail';
								$arrResponseData['message'] = $strMessage;
								echo json_encode($arrResponseData);exit;
							}
							else
							{
								$boolContentCreated = $this->Vendorservice->save($arrContentData);
								if($boolContentCreated)
								{
									$intCreatedContentId = $this->Vendorservice->getLastInsertID();
									$arrResponseData['createdid'] = $intCreatedContentId;
									$arrResponseData['status'] = 'success';
								}
								$compMessage = $this->Components->load('Message');
								$strForMessage = "You have successfully added the details.";
								$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
								$arrResponseData['message'] = $strMessage;
								echo json_encode($arrResponseData);exit;
							}
						}
					}
			}
		}
		$arrVendorServiceDetail = array();
		$this->loadModel('Vendors');
		$arrVendorDetails = $this->Vendors->find('all',array('conditions'=>array('vendor_type'=>array('Services'),'vendor_active'=>'1','parent_vendor'=>'0')));
		
		//print("<pre>");
		//print_r($arrVendorDetails);
		//exit;
		
		$arrVendorServiceDetail['Vendors'] = $arrVendorDetails;
		$this->loadModel('Resources');
		$arrResourcesDetails = $this->Resources->find('all',array('conditions'=>array('product_type'=>array('Services'),'product_publish_status'=>'1')));
		
		//print("<pre>");
		//print_r($arrResourcesDetails);
		
		//exit;
		$arrVendorServiceDetail['Services'] = $arrResourcesDetails;
		$this->set('arrVendorServiceDetail',$arrVendorServiceDetail);
		
		//print("<pre>");
		//print_r($arrVendorServiceDetail);
		//exit;
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
	
	public function parentcontentform($intContentId,$intCatForUser="3",$intContentType="1")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$this->loadModel('Content');
		if($intContentId)
		{
			$arrProductContent = $this->Content->find('all',array('conditions'=>array('vendor_id'=>$intContentId)));
			//print("<pre>");
			//print_r($arrProductContent);
			//exit;
			if(is_array($arrProductContent) && count($arrProductContent)>0)
			{
				$view->set('strDateFormat',Configure::read('Productdate.format'));
				$view->set('arrProductContent',$arrProductContent);
			}
			$view->set('strContentId',$intContentId);
		}
		$strContentParentHtml = $view->element('vendors_cotent');
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
			$arrCatList = $this->Categories->find('all',array('conditions'=>array('content_category_parent_id'=>'0','content_cat_for_user'=>$intCatUser,'job_search_category'=>'1')));

		}
		else
		{
			$arrCatList = $this->Categories->find('all',array('conditions'=>array('content_category_parent_id'=>'0','content_cat_for_user'=>$intCatUser,'job_search_category'=>'0')));
		}
		//print("<pre>");
		//print_r($arrCatList);
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
	public function vendorservicesasproduct($vendor_service_id)	
	{		
		//Configure::write('debug', 2);
		$this->loadModel('Resources');		
		$this->loadModel('Categories');	
		$arrVendorServiceDetail = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_name'),'conditions'=>array('job_process_type'=>'Substeps')));	
		//echo '<pre>';print_r($arrVendorServiceDetail);exit();
		$view = new View($this, false);			
		$view->set('arrVendorServiceDetail',$arrVendorServiceDetail);	
		$view->set('vendor_service_id',$vendor_service_id);	
		$strContentCategoryHtml = $view->element('service_substept_assignment');	
		//echo $strContentCategoryHtml;
		if($strContentCategoryHtml)		{			$arrResponse['status'] = "success";			$arrResponse['content'] = $strContentCategoryHtml;		}		else		{			$arrResponse['status'] = "fail";		}	
		echo json_encode($arrResponse);		
		exit;	
	}
	public function vendorReassignProduct($vendor_service_id)	
	{		
		Configure::write('debug', 2);
		$this->loadModel('Resources');		
		$this->loadModel('Categories');	
		$arrVendorServiceDetail = $this->Categories->find('list',array('fields'=>array('content_category_id','content_category_name'),'conditions'=>array('job_process_type'=>'Substeps')));	
		$this->loadModel('substepProducts');
		$arrVendorServiceAssigned = $this->substepProducts->find('all',array('fields'=>array('content_category_id'),'conditions'=>array('vendor_service_id'=>$vendor_service_id)));
		$view = new View($this, false);			
		$view->set('arrVendorServiceDetail',$arrVendorServiceDetail);	
		$view->set('arrVendorServiceAssigned',$arrVendorServiceAssigned);	
		$view->set('vendor_service_id',$vendor_service_id);	
		$strContentCategoryHtml = $view->element('service_substept_reassignment');	
		echo $strContentCategoryHtml;		
		exit;	
	}
	public function setsubstepservice()	
	{				
		$this->loadModel('substepProducts');	
		//echo '<pre>';	print_r($_POST);exit();
		$phaseid = $_POST['stepid'];				
		$vendor_service_id = $_POST['vendor_service_id'];		
		if(count($phaseid)>0)		
		{			
			$intContentDeleted = $this->substepProducts->deleteAll(array('vendor_service_id' => $vendor_service_id),false);
			$count=0;
			foreach($phaseid as $newphaseid)
			{								
				$arrContentData[$count]['substepProducts']['content_category_id'] = $newphaseid;
				$arrContentData[$count]['substepProducts']['vendor_service_id'] = $vendor_service_id;		
				$count++;		
			}		
			$this->substepProducts->saveAll($arrContentData);	
			$arrResponse['status'] = "success";		
			$arrResponse['message'] = "Substeps are assigned vendor services successfully";		
		}		
		else{		
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Something wrong happen please check";
			}		
			echo json_encode($arrResponse);		
			exit;	
	}
	public function reassignSubStepService()	
	{				
		$this->loadModel('substepProducts');	
		//echo '<pre>';	print_r($_POST);exit();
		$phaseid = $_POST['stepid'];				
		$vendor_service_id = $_POST['vendor_service_id'];		
		if(count($phaseid)>0)		
		{			
			$intContentDeleted = $this->substepProducts->deleteAll(array('vendor_service_id' => $vendor_service_id),false);
			$count=0;
			foreach($phaseid as $newphaseid)
			{								
				$arrContentData[$count]['substepProducts']['content_category_id'] = $newphaseid;
				$arrContentData[$count]['substepProducts']['vendor_service_id'] = $vendor_service_id;		
				$count++;		
			}		
			$this->substepProducts->saveAll($arrContentData);	
			$arrResponse['status'] = "success";		
			$arrResponse['message'] = "Substeps are assigned vendor services successfully";		
		}		
		else{		
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Something wrong happen please check";
			}
		    $this->redirect(array('controller'=>'vendorservices','action'=>'index'));		
			return $arrResponse;		
			
	}	
}
