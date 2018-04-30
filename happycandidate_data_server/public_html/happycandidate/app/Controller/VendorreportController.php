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
class VendorreportController extends AppController {

	public $components = array('Paginator');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = "admin";
	public $name = 'Vendorreport';
	
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
 
 public function sales()
	{
		echo 'in'; exit();
		//Configure::write('debug','2');
		$arrLoggedUser = $this->Auth->user();
		$this->loadModel('Resourceorderdetail');
		$this->loadModel('Vendors');
		$this->loadModel('Portal');
		$arrConditions = array();
		if($intVendorId)
		{
			$arrConditions['Resourceorderdetail.vendor_id'] = $intVendorId;
			$arrConditions['Resourceorderdetail.vendor_type'] = "vendor";
			$arrConditions['Resourceorderdetail.refund_status'] = "0";
		}
		
		$strStartDate = base64_decode($strStartD);
		$strEndDate = base64_decode($strEndD);
		if($this->request->is('Post'))
		{
			
			
			$strStartDate = $this->request->data['from_date_hid']." 00:00:00";
			$strEndDate = $this->request->data['to_date_hid']." 23:59:59";
		}
		if($strStartDate)
		{
			$arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
		}
		
		if($strEndDate)
		{
			$arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
		}
		
		//print("<pre>");
		//print_r($arrConditions);
		
		if(is_array($arrConditions) && (count($arrConditions)>0))
		{
			$arrNewOrders = $this->Resourceorderdetail->find('all',array(
			'joins' => array(
								array(
						'table' => 'resource_order',
						'alias' => 'Resourceorder',
						'type' => 'inner',				
						'conditions'=> array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
						)
					),
			'conditions'=>$arrConditions,
			'order'=>array('order_detail_id'=>'desc')
			
			));
			
			$arrTotalSumQ = $this->Resourceorderdetail->find('all',array(
			'fields'=>array('SUM(Resourceorderdetail.product_unit_cost) AS amount'),
			'joins' => array(
								array(
						'table' => 'resource_order',
						'alias' => 'Resourceorder',
						'type' => 'inner',				
						'conditions'=> array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
						)
					),
			'conditions'=>$arrConditions,
			'order'=>array('order_detail_id'=>'desc')
			));			
		}
		else
		{
			$arrNewOrders = $this->Resourceorderdetail->find('all',array(
			'joins' => array(
								array(
						'table' => 'resource_order',
						'alias' => 'Resourceorder',
						'type' => 'inner',				
						'conditions'=> array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
						)
					),
			'order'=>array('order_detail_id'=>'desc')
			
			));
			
			$arrTotalSumQ = $this->Resourceorderdetail->find('all',array(
			'fields'=>array('SUM(Resourceorderdetail.product_unit_cost) AS amount'),
			'joins' => array(
								array(
						'table' => 'resource_order',
						'alias' => 'Resourceorder',
						'type' => 'inner',				
						'conditions'=> array('Resourceorderdetail.order_id=Resourceorder.resource_order_id')
						)
					),
			'order'=>array('order_detail_id'=>'desc')
			
			));
			
			//print("<pre>");
			//print_r($arrTotalSumQ);
			
			
		}
		//$this->loadModel('Subvendororders');
		
		//print("<pre>");
		//print_r($arrTotalSumQ);
		
		//print("<pre>");
		//print_r($arrNewOrders);
		//exit;
		$intTotalAmount = 0;
		if(is_array($arrTotalSumQ) && (count($arrTotalSumQ)>0))
		{
			$intTotalAmount = $arrTotalSumQ['0']['0']['amount'];
		}
		$this->set("intTotalAmount",$intTotalAmount);
		
		if(is_array($arrNewOrders) && count($arrNewOrders)>0)
		{
			$this->loadModel('Resourceorder');
			$this->loadModel('Candidate');
			$this->loadModel('Resources');
			$intFrCnt = 0;
			foreach($arrNewOrders as $arrOrder)
			{
				$intOrderId = $arrOrder['Resourceorderdetail']['order_id'];
				$intVendorType = $arrOrder['Resourceorderdetail']['vendor_type'];
				$intVendorId = $arrOrder['Resourceorderdetail']['vendor_id'];
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
				
				
				if($intVendorType == "vendor")
				{
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
					'conditions'=>array('Vendors.vendor_id'=>$intVendorId)
					));
				}
				else
				{
					$arrSubVendorsFor = $this->Portal->find('all',array(
					'conditions'=>array('career_portal_id'=>$arrOrder['Resourceorderdetail']['vendor_id'])
					));
					
					$arrSubVendorsFor[0]['Vendors']['vendor_first_name'] = $arrSubVendorsFor[0]['Portal']['career_portal_name'];
				}
				
				
				
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
}
 ?>