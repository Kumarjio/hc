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
class VendorordersController extends AppController 
{

	var $helpers = array ('Html','Form');


/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Vendororders';

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
		$this->Auth->allow('login','forgotpassword');
	}
	
	public function addorderupdates($intOrderMId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$arrLoggedUser = $this->Auth->user();
		if($intOrderMId)
		{
			$this->loadModel('Serviceupdates');
			$this->loadModel('Resourceorderdetail');
			$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array('order_detail_id'=>$intOrderMId)));
			
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
					$intFrCnt++;
				}
			}

			
			$arrOrderUpdateDetail['Serviceupdates']['order_id'] = $intOrderMId ;
			$arrOrderUpdateDetail['Serviceupdates']['order_name'] = $arrNewOrders[0]['mainorder']['Resourceorder']['order_name'];
			$arrOrderUpdateDetail['Serviceupdates']['order_update_from'] = $arrLoggedUser['vendor_id'];
			$arrOrderUpdateDetail['Serviceupdates']['order_service_update_to'] = $arrNewOrders[0]['customer']['Candidate']['candidate_id'];
			$arrOrderUpdateDetail['Serviceupdates']['order_service_update_to'] = $arrNewOrders[0]['customer']['Candidate']['candidate_id'];
			$arrOrderUpdateDetail['Serviceupdates']['order_update_by_type'] = "vendor";
			$arrOrderUpdateDetail['Serviceupdates']['order_updated_by_name'] = $arrLoggedUser['vendor_first_name']." ".$arrLoggedUser['vendor_last_name'];
			$arrOrderUpdateDetail['Serviceupdates']['order_service_subject'] = addslashes($this->request->data['content_title']);
			
			$arrOrderUpdateDetail['Serviceupdates']['order_updated_text'] = htmlspecialchars(addslashes($this->request->data['main_content']));
			
			$this->Serviceupdates->set($arrOrderUpdateDetail);
			$arrOrderSaved = $this->Serviceupdates->save($arrOrderUpdateDetail);
			if($arrOrderSaved)
			{
				$intCreatedContentId = $this->Serviceupdates->getLastInsertID();
				$arrResponse['createdid'] = $intCreatedContentId;
				$arrResponse['status'] = 'success';
				$compMessage = $this->Components->load('Message');
				$strForMessage = "You have successfully updated you order.";
				$strMessage = $compMessage->fnGenerateMessageBlock($strForMessage,'success');
				$arrResponse['message'] = $strMessage;
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('There was some issue, please try again','error');
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = $strMessage;
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Sorry, Some Parameter missing.','error');
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = $strMessage;
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function mediauploader($isServiceImage = "",$strVendor = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($isServiceImage)
		{
			$view->set('forService',$strVendor);
		}
		
		$strMediaUploaderHtml = $view->element('vendormediaselector', $params);
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
	
	public function addupdates($intOrderMId = "")
	{		
		if($intOrderMId)
		{
			$arrLoggedUser = $this->Auth->user();
			$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
			$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/add_vendor_update.js').'"></script>';
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
			
			
			$this->loadModel('Serviceupdates');
			$this->loadModel('Resourceorderdetail');
			$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array('order_detail_id'=>$intOrderMId)));
			
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
					$intFrCnt++;
				}
			}
			
			
			
			
			$this->set('arrProductList',$arrNewOrders);
			$this->set('arrCurrentUser',$arrLoggedUser);
			$this->set('intOrderId',$intOrderMId);
		}
		else
		{
			$this->Session->setFlash('Sorry, Some Parameter missing.');
		}
	}
	
	public function viewupdate($intOrderMId = "",$intUpdateId = "")
	{
		if($intOrderMId && $intUpdateId)
		{
			$arrLoggedUser = $this->Auth->user();
			$this->loadModel('Resourceorderdetail');
			$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array('order_detail_id'=>$intOrderMId)));
			
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
					$intFrCnt++;
				}
			}
			
			$this->loadModel('Serviceupdates');
			$arrServiceUpdateDetails = $this->Serviceupdates->find('all',array('conditions'=>array('order_service_update_id'=>$intUpdateId)));
			if(is_array($arrServiceUpdateDetails) && (count($arrServiceUpdateDetails)>0))
			{
				$this->loadModel('Vendorfiles');
				$arrVendorUpdateFiles = $this->Vendorfiles->find('all',array('conditions'=>array('vendor_update_id'=>$intUpdateId)));
				
				if(is_array($arrVendorUpdateFiles) && count($arrVendorUpdateFiles)>0)
				{
					$arrServiceUpdateDetails[0]['files'] = $arrVendorUpdateFiles;
				}
			}
			//print("<pre>");
			//print_r($arrServiceUpdateDetails);
			//exit;
			$this->set('arrCurrentUser',$arrLoggedUser);
			$this->set('arrProductList',$arrNewOrders);
			$this->set('arrServiceUpdateDetails',$arrServiceUpdateDetails);
		}
		else
		{
			$this->Session->setFlash('Sorry, Some Parameter missing.');
		}
	}
	
	public function orderdetail($intOrderMId = "")
	{
		if($intOrderMId)
		{
			$arrLoggedUser = $this->Auth->user();
			
			$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_index.js').'"></script>';
			$this->set('strActionScript',$strActionScript);
			
			
			$this->loadModel('Serviceupdates');
			$this->loadModel('Resourceorderdetail');
			$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array('order_detail_id'=>$intOrderMId)));
			
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
					$intFrCnt++;
				}
			}
			
			$arrServiceUpdates = $this->Serviceupdates->find('all',array('conditions'=>array('order_id'=>$intOrderMId)));
			if(is_array($arrServiceUpdates) && count($arrServiceUpdates)>0)
			{
				$intFrCnt = 0;
				$this->loadModel('Vendor');
				$this->loadModel('Candidate');
				foreach($arrServiceUpdates as $arrServiceUpdate)
				{
					$stUpdateFrom = $arrServiceUpdate['Serviceupdates']['order_update_by_type'];
					if($stUpdateFrom == "vendor")
					{
						$arrUpdateByDetail = $this->Vendor->find('all',array('conditions'=>array('vendor_id'=>$arrServiceUpdate['Serviceupdates']['order_update_from'])));
						$arrServiceUpdates[$intFrCnt]['Serviceupdates']['updatefrom'] = $arrUpdateByDetail[0]['Vendor']['vendor_first_name']." ".$arrUpdateByDetail[0]['Vendor']['vendor_last_name'];
					}
					if($stUpdateFrom == "candidate")
					{
						$arrUpdateByDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrServiceUpdate['Serviceupdates']['order_update_from'])));
						$arrServiceUpdates[$intFrCnt]['Serviceupdates']['updatefrom'] = $arrUpdateByDetail[0]['Candidate']['candidate_first_name']." ".$arrUpdateByDetail[0]['Candidate']['candidate_last_name'];
					}
					$intFrCnt++;
				}
			}
			
			$this->set('arrServiceUpdates',$arrServiceUpdates);
			$this->set('arrProductList',$arrNewOrders);
			$this->set('arrCurrentUser',$arrLoggedUser);
			$this->set('intOrderMId',$intOrderMId);
		}
		else
		{
			$this->Session->setFlash('Sorry, Some Parameter missing.');
		}
	}
	
	public function changeorderstatus($intOrderId = "",$strOrderStatus = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intOrderId && $strOrderStatus)
		{
			$this->loadModel('Resourceorderdetail');
			$boolUpdated = $this->Resourceorderdetail->updateAll(
									array('Resourceorderdetail.vendor_order_state' => "'".$strOrderStatus."'"),
									array('Resourceorderdetail.order_detail_id =' => $intOrderId)
								);
								
			if($boolUpdated)
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Your order was updated successfully.','success');
				$arrResponse['status'] = 'success';
				$arrResponse['message'] = $strMessage;
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('There was some error, please try again later.','error');
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = $strMessage;
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Parameter missing, please try again.','error');
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = $strMessage;
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function closeorder($intOrderId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		if($intOrderId)
		{
			$this->loadModel('Resourceorderdetail');
			$boolUpdated = $this->Resourceorderdetail->updateAll(
									array('Resourceorderdetail.vendor_order_state' => "'Closed'"),
									array('Resourceorderdetail.order_detail_id =' => $intOrderId)
								);
								
			if($boolUpdated)
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('Your order was closed successfully.','success');
				$arrResponse['status'] = 'success';
				$arrResponse['message'] = $strMessage;
			}
			else
			{
				$compMessage = $this->Components->load('Message');
				$strMessage = $compMessage->fnGenerateMessageBlock('There was some error, please try again later.','error');
				$arrResponse['status'] = 'fail';
				$arrResponse['message'] = $strMessage;
			}
		}
		else
		{
			$compMessage = $this->Components->load('Message');
			$strMessage = $compMessage->fnGenerateMessageBlock('Parameter missing, please try again.','error');
			$arrResponse['status'] = 'fail';
			$arrResponse['message'] = $strMessage;
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function index()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		
		$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array("vendor_id"=>$arrLoggedUser['vendor_id'])));
		
		
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
				$intFrCnt++;
			}
		}
		$this->set('arrProductList',$arrNewOrders);
	}
	
	public function neworders()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		
		$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array("vendor_order_state"=>"New Order","vendor_id"=>$arrLoggedUser['vendor_id'])));
		
		
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
				$intFrCnt++;
			}
		}
		$this->set('arrProductList',$arrNewOrders);
	}
	
	public function openorders()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		
		$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array("vendor_order_state"=>"Open","vendor_id"=>$arrLoggedUser['vendor_id'])));
		
		
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
				$intFrCnt++;
			}
		}
		$this->set('arrProductList',$arrNewOrders);
	}
	
	public function closedorders()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/vendor_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		
		$arrNewOrders = $this->Resourceorderdetail->find('all',array('conditions'=>array("vendor_order_state"=>"Closed","vendor_id"=>$arrLoggedUser['vendor_id'])));
		
		
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
				$intFrCnt++;
			}
		}
		$this->set('arrProductList',$arrNewOrders);
	}
	
	public function logout($strSwictchBack = "") 
	{
		$this->layout = NULL;
		$this->autoRender = False;
		$arrResponse = array();
		
		$arrResponse['logoutredirecturl'] = $this->Auth->logout();
		
		if($arrResponse['logoutredirecturl'])
		{
			$arrResponse['logoutredirecturl'] = Router::url(array('controller'=>'vendoraccount','action'=>'index'),true);
			$arrResponse['status'] = "success";
		}
		
		echo json_encode($arrResponse);
		exit;
	}
	
	public function login($strSwictchBack = "")
	{

		if($this->request->is('post'))
		{
			/* print("<pre>");
			print_r($this->request->data);
			exit; */
			
			$this->loadModel('Vendors');
			$arrPostedData = array();
			//$arrPostedData['email'] = $this->request->data['User']['user_email'];
			//$arrPostedData['pass'] = $this->request->data['User']['user_pass'];
			
			$this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['Vendors']['user_email']));
			$this->request->data['Vendors']['vendor_password_encrypted'] = addslashes(trim($this->request->data['Vendors']['password']));
			
			//$this->request->data['Vendors']['vendor_email'] = "rajendra4uaty@yahoo.com";
			//$this->request->data['Vendors']['vendor_password_encrypted'] = "test123";
			
			$this->Vendors->set($this->request->data);
			
			
			/*if($this->User->validates())
			{*/
				if($this->Auth->login())
				{
					$arrLoggedInUser = $this->Auth->user();
					if($arrLoggedInUser['vendor_active'] == "0")
					{
						$this->Auth->logout();
						$arrResultSet = array();
						$arrResultSet['status'] = "failure";
						$arrResultSet['message'] = "Sorry, Your account is not being confirmed yet, Please confirm your account first.";
						$this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
						echo json_encode($arrResultSet);
						exit;
						
						/*$this->Session->setFlash('Sorry, Your account is not being confirmed yet, Please confirm your account first.');
						$this->redirect(array('controller'=>'users','action'=>'login')); */
					}
					else
					{
						$arrResultSet = array();
						$arrResultSet['status'] = "success";
						$arrResultSet['redirecturl'] = Router::url($this->Auth->redirectUrl(),true);
						$arrResultSet['userid'] = $arrLoggedInUser['vendor_id'];
						$arrResultSet['username'] = $arrLoggedInUser['vendor_name'];
						$arrResultSet['useremail'] = $arrLoggedInUser['vendor_email'];
						
						echo json_encode($arrResultSet);
						exit;
						//$this->redirect($this->Auth->redirectUrl());
					}
				}
				else
				{
					$arrResultSet = array();
					$arrResultSet['status'] = "failure";
					$arrResultSet['message'] = "Your username and password combination was incorrect.";
					$this->Session->setFlash('Your username and password combination was incorrect');
					echo json_encode($arrResultSet);
					exit;
					//$this->Session->setFlash('Your username and password combination was incorrect');
				}
			/*}
			else
			{
				$errors = $this->User->invalidFields();
				$strLoginerrorMessage = "";
				if(is_array($errors) && (count($errors)>0))
				{
					$intForIterateCount = 0;
					foreach($errors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount == 1)
						{
							$strLoginerrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strLoginerrorMessage .= "<br> Error: ".$errorVal['0'];
						}
						
					}
					$this->Session->setFlash($strLoginerrorMessage);
					$arrResultSet = array();
					$arrResultSet['status'] = "failure";
					$arrResultSet['message'] = $strLoginerrorMessage;
					echo json_encode($arrResultSet);
					exit;
				}
			}*/
			//$this->redirect(array('controller'=>'home','action'=>'index'));
		
		}
	
	}
	
	public function forgotpassword()
	{
		if($this->request->is('post'))
		{
			/*print("<pre>");
			print_r($this->request->data);
			exit;*/
				
			$this->request->data['Vendors']['vendor_email'] = addslashes(trim($this->request->data['User']['user_email']));
			
			$this->loadModel('Vendors');
			$this->Vendors->set($this->request->data);
			
			/*if($this->User->validates())
			{*/
				$arrUserExists = $this->Vendors->find('all', array(
								'conditions' => array('vendor_email' => $this->request->data['User']['user_email'])
							));
				/* print("<pre>");
				print_r($arrUserExists);
				exit; */
				if(is_array($arrUserExists) && (count($arrUserExists)>0))
				{
					
					$strUsersName = $arrUserExists[0]['Vendors']['vendor_name'];
					/* echo "---".$strUsersName;
					exit; */
					$strNewPassword = $this->fnRegeneratePassword($arrUserExists[0]['Vendors']['vendor_id']);
					$boolUpdated = $this->Vendors->updateAll(
									array('Vendors.vendor_password_encrypted' => "'".AuthComponent::password($strNewPassword)."'",'Vendors.vendor_password' => "'".$strNewPassword."'"),
									array('Vendors.vendor_email =' => $this->request->data['User']['user_email'])
								);
					if($boolUpdated)
					{
						$intMailSent = $this->fnSendPassowordRegenerationMail($strUsersName, $this->request->data['User']['user_email'],$strNewPassword);
						if($intMailSent)
						{
							$this->Session->setFlash("Congratulation, your Password has been reset, Please check your Mail",'default',array('class' => 'success'));
						}
						else
						{
							$this->Session->setFlash("Please try again.");
						}
					}
					else
					{
						$this->Session->setFlash("Please try again.");
					}
				}
				else
				{
					$this->Session->setFlash("In-Correct email address, Account not registered.");
				}
			/*}
			else
			{
				$errors = $this->User->invalidFields();
				$strRegerrorMessage = "";
				if(is_array($errors) && (count($errors)>0))
				{
					$intForIterateCount = 0;
					foreach($errors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount)
						{
							$strRegerrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strRegerrorMessage .= "<br> Error: ".$errorVal['0'];
						}
						
					}
					
					$this->Session->setFlash($strRegerrorMessage);
				}
			}*/
		}
	}
	
	public function editpayout()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/*print("<pre>");
		print_r($arrLoggedUserDetails);
		exit;*/
		$this->loadModel('Vendorpayout');
		$strRegerrorMessage = "";
		if($this->request->is('post'))
		{
			$arrContentData['Vendorpayout']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];
			$arrContentData['Vendorpayout']['payout_to'] = addslashes($this->request->data['User']['payoutto']);
			$arrContentData['Vendorpayout']['tax_id'] = addslashes($this->request->data['User']['taxid']);
			$arrContentData['Vendorpayout']['minimum_check_amt'] = addslashes($this->request->data['User']['minamt']);
			$arrContentData['Vendorpayout']['commission_pct'] = addslashes($this->request->data['User']['compct']);
			$arrContentData['Vendorpayout']['indeed_registration'] = addslashes($this->request->data['User']['inreg']);
			
						
			/*print("<pre>");
			print_r($arrContentData);
			exit;*/
			
			$intVendorCompanyExists = $this->Vendorpayout->find('count',array('conditions'=>array('vendor_id'=>$intEditModeId)));
			if($intVendorCompanyExists)
			{
				$this->Vendorpayout->deleteAll(array('Vendorpayout.vendor_id' => $intEditModeId),false);
			}

			$arrCompanyDetailsEntered = $this->Vendorpayout->save($arrContentData);
				
			if($arrCompanyDetailsEntered)
			{
				$this->Session->setFlash('Vendor Payment Details Saved Successfully!','default',array('class' => 'success'));
			}
			else
			{
				$this->Session->setFlash('Please try again');
			}
		}

		$arrViewUserDetail = $this->Vendorpayout->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));

		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
	}
	
	public function editcompany()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/*print("<pre>");
		print_r($arrLoggedUserDetails);
		exit;*/
		$this->loadModel('Vendorcompany');
		$strRegerrorMessage = "";
		if($this->request->is('post'))
		{
			$arrContentData['Vendorcompany']['vendor_id'] = $intEditModeId = $arrLoggedUserDetails['vendor_id'];
			$arrContentData['Vendorcompany']['company_name'] = addslashes($this->request->data['User']['vendorcname']);
			$arrContentData['Vendorcompany']['vendor_f_name'] = addslashes($this->request->data['User']['vendorfname']);
			$arrContentData['Vendorcompany']['vendor_l_name'] = addslashes($this->request->data['User']['vendorlname']);
			$arrContentData['Vendorcompany']['vendor_email'] = addslashes($this->request->data['User']['vendorcemail']);
			$arrContentData['Vendorcompany']['address'] = addslashes($this->request->data['User']['vendor_company_address']);
			$arrContentData['Vendorcompany']['zip'] = addslashes($this->request->data['User']['zip']);
			$arrContentData['Vendorcompany']['phone'] = addslashes($this->request->data['User']['vendorcphone']);
			$arrContentData['Vendorcompany']['fax'] = addslashes($this->request->data['User']['vendorfax']);
			$arrContentData['Vendorcompany']['web_address'] = addslashes($this->request->data['User']['vendorwaddress']);
			$arrContentData['Vendorcompany']['billing_phone'] = addslashes($this->request->data['User']['vendorbphone']);
			
						
			/*print("<pre>");
			print_r($arrContentData);
			exit;*/
			
			$intVendorCompanyExists = $this->Vendorcompany->find('count',array('conditions'=>array('vendor_id'=>$intEditModeId)));
			if($intVendorCompanyExists)
			{
				$this->Vendorcompany->deleteAll(array('Vendorcompany.vendor_id' => $intEditModeId),false);
			}

			$arrCompanyDetailsEntered = $this->Vendorcompany->save($arrContentData);
				
			if($arrCompanyDetailsEntered)
			{
				$this->Session->setFlash('Vendor Company Details Updated Successfully!','default',array('class' => 'success'));
			}
			else
			{
				$this->Session->setFlash('Please try again');
			}
		}

		$arrViewUserDetail = $this->Vendorcompany->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));

		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
	}
	
	public function edit()
	{
		$arrLoggedUserDetails = $this->Auth->user();
		/*print("<pre>");
		print_r($arrLoggedUserDetails);
		exit;*/
		$this->loadModel('Vendors');
		$strRegerrorMessage = "";
		if($this->request->is('post'))
		{
			$arrAdminBasicPostedData = array();
			$arrAdminBasicPostedData['vendor_name'] = addslashes(trim($this->request->data['User']['vendorname']));
			$arrAdminBasicPostedData['vendor_first_name'] = addslashes(trim($this->request->data['User']['vendorfname']));
			$arrAdminBasicPostedData['vendor_last_name'] = addslashes(trim($this->request->data['User']['vendorlname']));
			$arrAdminBasicPostedData['vendor_phone'] = addslashes(trim($this->request->data['User']['vendorphone']));
			if($this->request->data['User']['vendor_pass'])
			{
				$arrAdminBasicPostedData['vendor_password'] = $this->request->data['User']['vendor_pass'];
				$arrAdminBasicPostedData['vendor_password_encrypted'] = AuthComponent::password($this->request->data['User']['vendor_pass']);
			}
			
			//print("<pre>");
			//print_r($arrAdminBasicPostedData);
			//exit;
			
			$this->Vendors->set($arrAdminBasicPostedData);
			if($this->request->data['User']['vendor_pass'])
			{
				
				
				$boolUpdated = $this->Vendors->updateAll(
					array('Vendors.vendor_name' => "'".$arrAdminBasicPostedData['vendor_name']."'",'Vendors.vendor_first_name'=>"'".$arrAdminBasicPostedData['vendor_first_name']."'",'Vendors.vendor_last_name'=>"'".$arrAdminBasicPostedData['vendor_last_name']."'",'Vendors.vendor_phone'=>"'".$arrAdminBasicPostedData['vendor_phone']."'",'Vendors.vendor_password'=>"'".$arrAdminBasicPostedData['vendor_password']."'",'Vendors.vendor_password_encrypted'=>"'".$arrAdminBasicPostedData['vendor_password_encrypted']."'"),
					array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])
				);
			}
			else
			{
				$boolUpdated = $this->Vendors->updateAll(
					array('Vendors.vendor_name' => "'".$arrAdminBasicPostedData['vendor_name']."'",'Vendors.vendor_first_name'=>"'".$arrAdminBasicPostedData['vendor_first_name']."'",'Vendors.vendor_last_name'=>"'".$arrAdminBasicPostedData['vendor_last_name']."'",'Vendors.vendor_phone'=>"'".$arrAdminBasicPostedData['vendor_phone']."'"),
					array('Vendors.vendor_id =' => $arrLoggedUserDetails['vendor_id'])
				);
			}
				
			if($boolUpdated)
			{
				$this->Session->setFlash('Profile Updated Successfully!','default',array('class' => 'success'));
			}
			else
			{
				$this->Session->setFlash('Please try again');
			}
		}
		
		
		$arrViewUserDetail = $this->Vendors->find('all',array('conditions'=>array('vendor_id'=>$arrLoggedUserDetails['vendor_id'])));

		$this->set('arrCompleteLoggedInUserDetail',$arrViewUserDetail);
	}
	
	public function dashboard()
	{
		$arrLoggedVendor = $this->Auth->user();
		$this->compTime = $this->Components->load('TimeCalculation'); 
		
		$strMonth = $this->compTime->fnFindCurrentMonth();
		$arrNewYear = $this->compTime->fnFindCurrentYear();
		
		$strDatFormMonthToCompare = $arrNewYear."-".$strMonth."-"."01 00:00:00";
		$strEndDatFormMonthToCompare = date($arrNewYear.'-'.$strMonth.'-t')." 23:59:59";
		
		
		$this->loadModel('Resourceorderdetail');
		$arrNewOrderCountForMonth = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id'],$strDatFormMonthToCompare,$strEndDatFormMonthToCompare);
		
		if(is_array($arrNewOrderCountForMonth) && (count($arrNewOrderCountForMonth)>0))
		{
			if($arrNewOrderCountForMonth[0][0]['count(*)'])
			{
				$this->set('intPortalOwners',$arrNewOrderCountForMonth[0][0]['count(*)']);
			}
		}
		
		$arrNewOrderCountTotal = $this->Resourceorderdetail->fnGetNewOrderCount($arrLoggedVendor['vendor_id']);
		//print("<pre>");
		//print_r($arrNewOrderCountTotal);
		//exit;
		if(is_array($arrNewOrderCountTotal) && (count($arrNewOrderCountTotal)>0))
		{
			if($arrNewOrderCountTotal[0][0]['count(*)'])
			{
				$this->set('intPortalCandidates',$arrNewOrderCountTotal[0][0]['count(*)']);
			}
		}
	}
	
	public function changepassword()
	{
		if($this->request->is('post'))
		{
			$this->loadModel('User');
			$arrPostedData = array();
			$this->request->data['User']['pass'] = addslashes(trim($this->request->data['User']['new_password']));
			$this->request->data['User']['confirm_pass'] = addslashes(trim($this->request->data['User']['new_password_again']));
			$this->request->data['User']['old_pass'] = addslashes(trim($this->request->data['User']['old_pass']));
			$arrCurrentUser = $this->Auth->user();
			
			$this->User->set($this->request->data);
			if($this->User->validates())
			{
				if($this->request->data['User']['pass'] == $this->request->data['User']['confirm_pass'])
				{
					$intUserExists = $this->User->find('count', array(
										'conditions' => array('id' => $arrCurrentUser['id'],'pass'=>AuthComponent::password($this->request->data['User']['old_pass']))
									));
					if($intUserExists)
					{
						$boolUpdated = $this->User->updateAll(
								array('User.pass' => "'".AuthComponent::password($this->request->data['User']['pass'])."'"),
								array('User.id =' => $arrCurrentUser['id'])
							);
						if($boolUpdated)
						{
							$this->Session->setFlash("Your Password has been Changed",'default',array('class' => 'success'));
						}
						else
						{
							$this->Session->setFlash("Please try again");
						}
					}
					else
					{
						$this->Session->setFlash("Please provide correct Old Password");
					}
				}
				else
				{
					$this->Session->setFlash("Your New Password does not match");
				}
			}
			else
			{
				$errors = $this->User->invalidFields();
				$strErrorMessage = "";
				if(is_array($errors) && (count($errors)>0))
				{
					$intForIterateCount = 0;
					foreach($errors as $errorVal)
					{
						$intForIterateCount++;
						if($intForIterateCount == 1)
						{
							$strErrorMessage .= "Error: ".$errorVal['0'];
						}
						else
						{
							$strErrorMessage .= "<br> Error: ".$errorVal['0'];
						}
					}
					$this->Session->setFlash($strErrorMessage);
				}
			}
		}
	}
}