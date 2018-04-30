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

class PrivatelabelsiteanalyticsController extends AppController 

{



	var $helpers = array ('Html','Form');

	public $components = array('Paginator');





/**

 * Controller name

 *

 * @var string

 */

	public $name = 'Privatelabelsiteanalytics';



/**

 * This controller does not use a model

 *

 * @var array

 */

	public $uses = array();

	

	public function beforeFilter()

	{

		parent::beforeFilter();

	}

	

	public function userstatistics($intPortalId = "")

	{

		//$this->autoRender = false;

		$arrResponse = array();

		//$strStatRequestId = "6";

		//$intPortalId = "all";

		

		if($this->request->is('Post'))

		{

			$strStatRequestId = $this->request->data['requestid'];

			//$strStatRequestId = "1";

			if($strStatRequestId)

			{

				if($strStatRequestId == "1")

				{

					$arrResponse['chartTitle'] = "Job Seekers Statistics";

					$this->loadModel('PortalJUser');

					if($intPortalId == "all")

					{

						$arrPortalUserList = $this->PortalUser->find('all');

						$arrResponse['graphsearies'] = "Registered Job Seekers";

						$arrResponse['graphsearieslabel'] = "All Registered Job Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

						//$arrActiveSeekers = $this->PortalUser->find('count',array('conditions'=>array('candidate_is_active'=>'1')));

						//$arrInActiveSeekers = $this->PortalUser->find('count',array('conditions'=>array('candidate_is_active'=>'0')));

					

						$this->Paginator->settings = array(

							'order' => array('career_portal_id' => 'DESC'),

							'limit' => 30

						);

					}

					else

					{

						$arrPortalUserList = $this->PortalJUser->find('all',array('conditions'=>array('hc_portal_id'=>$intPortalId)));

						$this->loadModel('Portal');

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearies'] = "Registered Seekers";

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Registered Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

						

						/*$this->Paginator->settings = array(

							'conditions' => array('career_portal_id'=>$intPortalId),

							'order' => array('candidate_creation_date' => 'DESC'),

							'limit' => 30

						);*/

					}

					

					//$arrPortalUserList = $this->Paginator->paginate('PortalJUser');

					

					if(is_array($arrPortalUserList) && (count($arrPortalUserList)>0))

					{

						$this->loadModel('Candidatedefaultcv');

						$intPortalDetailCount = 0;

						//print("<pre>");

						//print_r($arrPortalUserList);

						foreach($arrPortalUserList as $arrPortalDetail)

						{

							

							$arrPortalDetailNew = $this->Candidatedefaultcv->find('all',array('conditions'=>array('fk_employee_id'=>$arrPortalDetail['PortalJUser']['id'],'default_cv'=>'Y')));

							//print("<pre>");

							//print_r($arrPortalDetailNew);

							$arrPortalUserList[$intPortalDetailCount]['PortalJUser']['cvname'] = $arrPortalDetailNew[0]['Candidatedefaultcv']['cv_title'];

							$arrPortalUserList[$intPortalDetailCount]['PortalJUser']['cvid'] = $arrPortalDetailNew[0]['Candidatedefaultcv']['id'];

							$arrPortalUserList[$intPortalDetailCount]['PortalJUser']['updateddate'] = $arrPortalDetailNew[0]['Candidatedefaultcv']['modified_at'];

							$compTime = $this->Components->load('TimeCalculation');

							$strLastYearDate = $compTime->fnGetLastYearDate();

							//$strLastYearDate = "2014-07-01 00:00:00";

							

							if((strtotime($arrPortalDetailNew[0]['Candidatedefaultcv']['modified_at']) >= strtotime($strLastYearDate)) && (strtotime($arrPortalDetailNew[0]['Candidatedefaultcv']['modified_at']) <= strtotime(date('Y-m-d H:i:s'))))

							{

								$arrPortalUserList[$intPortalDetailCount]['PortalJUser']['cvupdateone'] = "1";

							}

							else

							{

								$arrPortalUserList[$intPortalDetailCount]['PortalJUser']['cvupdateone'] = "0";

							}

							

							$intPortalDetailCount++;

						}

						

						$view = new View($this, false);

						$view->set('arrPortalUserList', $arrPortalUserList);

						$view->set('title', "View Job Seekers");

						$strElementHtml = $view->element('employerregistereduserstatistics');

						if($strElementHtml)

						{

							$arrResponse['status'] = "success";

							$arrResponse['content'] = $strElementHtml;

							echo json_encode($arrResponse);exit;

						}

						

					}

					else

					{

						// error message no data exists

						$strErrorMessage = "There are no registered seesker(s)";

						$arrResponse['status'] = "fail";

						$arrResponse['message'] = $strErrorMessage;

						echo json_encode($arrResponse);exit;

					}

				}

				

				if($strStatRequestId == "2")

				{

					$arrResponse['chartTitle'] = "Portal Owners Statistics";

					$this->loadModel('User');

					$this->loadModel('Portal');

					//$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

					$arrPortalOwnerList = $this->User->fnGetUserDetailForPortal($intPortalId);

					$arrResponse['graphsearies'] = "Registered Portal Owners";

					if($intPortalId)

					{

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Registered Portal Owners";

					}

					else

					{

						$arrResponse['graphsearieslabel'] = "All Portal Owners";

					}

					$arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

					

					if(is_array($arrPortalOwnerList) && (count($arrPortalOwnerList)>0))

					{

						$view = new View($this, false);

						$view->set('arrPortalOwnerList', $arrPortalOwnerList);

						$strElementHtml = $view->element('ownerstatistics');

						if($strElementHtml)

						{

							$arrResponse['status'] = "success";

							$arrResponse['content'] = $strElementHtml;

							echo json_encode($arrResponse);exit;

						}

					}

					{

						// error message no data exists

						$strErrorMessage = "There are no Owner(s)";

						$arrResponse['status'] = "fail";

						$arrResponse['message'] = $strErrorMessage;

						echo json_encode($arrResponse);exit;

					}

				}

				

				if($strStatRequestId == "3")

				{

					$arrResponse['chartTitle'] = "Portal Owners Statistics";

					$this->loadModel('User');

					$this->loadModel('Portal');

					//$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

					$arrPortalOwnerList = $this->User->fnGetUserActiveDetailForPortal($intPortalId);

					$arrResponse['graphsearies'] = "Active Portal Owners";

					if($intPortalId)

					{

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Active Portal Owners";

					}

					else

					{

						$arrResponse['graphsearieslabel'] = "All Active Portal Owners";

					}

					$arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

					if(is_array($arrPortalOwnerList) && (count($arrPortalOwnerList)>0))

					{

						$view = new View($this, false);

						$view->set('arrPortalOwnerList', $arrPortalOwnerList);

						$strElementHtml = $view->element('activeownerstatistics');

						if($strElementHtml)

						{

							$arrResponse['status'] = "success";

							$arrResponse['content'] = $strElementHtml;

							echo json_encode($arrResponse);exit;

						}

					}

					{

						// error message no data exists

						$strErrorMessage = "There are no Owner(s)";

						$arrResponse['status'] = "fail";

						$arrResponse['message'] = $strErrorMessage;

						echo json_encode($arrResponse);exit;

					}

				}

				

				if($strStatRequestId == "4")

				{

					$arrResponse['chartTitle'] = "Portal Owners Statistics";

					$this->loadModel('User');

					$this->loadModel('Portal');

					//$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

					$arrPortalOwnerList = $this->User->fnGetUserInactiveDetailForPortal($intPortalId);

					$arrResponse['graphsearies'] = "Inactive Portal Owners";

					if($intPortalId)

					{

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Inactive Portal Owners";

					}

					else

					{

						$arrResponse['graphsearieslabel'] = "All Inactive Portal Owners";

					}

					$arrResponse['graphseariesvalue'] = count($arrPortalOwnerList);

					$view = new View($this, false);

					$view->set('arrPortalOwnerList', $arrPortalOwnerList);

					$strElementHtml = $view->element('inactiveownerstatistics');

					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}

				}

				

				if($strStatRequestId == "5")

				{

					$arrResponse['chartTitle'] = "Job Seekers Statistics";

					$this->loadModel('PortalUser');

					$this->loadModel('Portal');

					if($intPortalId == "all")

					{

						$arrPortalUserList = $this->PortalUser->find('all',array('conditions'=>array('candidate_confirmed'=>'1','candidate_is_active'=>'1')));

						$arrResponse['graphsearies'] = "Active Job Seekers";

						$arrResponse['graphsearieslabel'] = "All Active Job Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

					

						$this->Paginator->settings = array(

							'conditions' => array('candidate_confirmed'=>'1','candidate_is_active'=>'1'),

							'order' => array('career_portal_id' => 'DESC'),

							'limit' => 30

						);

					}

					else

					{

						$arrPortalUserList = $this->PortalUser->find('all',array('conditions'=>array('candidate_confirmed'=>'1','candidate_is_active'=>'1','career_portal_id'=>$intPortalId)));

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearies'] = "Active Job Seekers";

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Active Job Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

					

						$this->Paginator->settings = array(

							'conditions' => array('career_portal_id'=>$intPortalId,'candidate_confirmed'=>'1','candidate_is_active'=>'1'),

							'order' => array('career_portal_id' => 'DESC'),

							'limit' => 30

						);

					}

					

					$arrPortalUserList = $this->Paginator->paginate('PortalUser');

					

					if(is_array($arrPortalUserList) && (count($arrPortalUserList)>0))

					{

						$this->loadModel('Portal');

						$intPortalDetailCount = 0;

						foreach($arrPortalUserList as $arrPortalDetail)

						{

							

							$arrPortalDetailNew = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$arrPortalDetail['PortalUser']['career_portal_id'])));

							$arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);

							$intPortalDetailCount++;

						}

						

						$view = new View($this, false);

						$view->set('arrPortalUserList', $arrPortalUserList);

						$strElementHtml = $view->element('registeredactiveuserstatistics');

						if($strElementHtml)

						{

							$arrResponse['status'] = "success";

							$arrResponse['content'] = $strElementHtml;

							echo json_encode($arrResponse);exit;

						}

						

					}

					else

					{

						// error message no data exists

						$strErrorMessage = "There are no registered seesker(s)";

						$arrResponse['status'] = "fail";

						$arrResponse['message'] = $strErrorMessage;

						echo json_encode($arrResponse);exit;

					}

				}

				

				if($strStatRequestId == "6")

				{

					$arrResponse['chartTitle'] = "Job Seekers Statistics";

					$this->loadModel('PortalUser');

					$this->loadModel('Portal');

					if($intPortalId == "all")

					{

						$strActive = "0";

						$arrPortalUserList = $this->PortalUser->find('all',array('conditions'=>array('candidate_confirmed'=>'1','candidate_is_active'=>'0')));

						

						$arrResponse['graphsearies'] = "Inactive Job Seekers";

						$arrResponse['graphsearieslabel'] = "All Inactive Job Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

					

						$this->Paginator->settings = array(

							'conditions' => array('candidate_confirmed'=>'1','candidate_is_active'=>'0'),

							'order' => array('career_portal_id' => 'DESC'),

							'limit' => 30

						);

					}

					else

					{

						$arrPortalUserList = $this->PortalUser->find('all',array('conditions'=>array('candidate_confirmed'=>'1','candidate_is_active'=>'0','career_portal_id'=>$intPortalId)));

						$arrPortalDet = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$intPortalId)));

						$arrResponse['graphsearies'] = "Inactive Job Seekers";

						$arrResponse['graphsearieslabel'] = $arrPortalDet[$intPortalId]." Inactive Job Seekers";

						$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

					

						$this->Paginator->settings = array(

							'conditions' => array('career_portal_id'=>$intPortalId,'candidate_confirmed'=>'1','candidate_is_active'=>'0'),

							'order' => array('career_portal_id' => 'DESC'),

							'limit' => 30

						);

					}

					

					$arrPortalUserList = $this->Paginator->paginate('PortalUser');

					$this->loadModel('Portal');

					$intPortalDetailCount = 0;

					foreach($arrPortalUserList as $arrPortalDetail)

					{

						

						$arrPortalDetailNew = $this->Portal->find('list',array('fields'=>array('career_portal_id','career_portal_name'),'conditions'=>array('career_portal_id'=>$arrPortalDetail['PortalUser']['career_portal_id'])));

						$arrPortalUserList[$intPortalDetailCount]['PortalName']['pname'] = array_pop($arrPortalDetailNew);

						$intPortalDetailCount++;

					}

					

					$view = new View($this, false);

					$view->set('arrPortalUserList', $arrPortalUserList);

					$strElementHtml = $view->element('registeredinactiveuserstatistics');

					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}

				}
				if($strStatRequestId == "7") //Refunds that were provided

				{

					$arrResponse['chartTitle'] = "Refunded Order";

					$this->loadModel('Resourceorderdetail');
					$this->loadModel('Vendors');
					$this->loadModel('Portal');
					$arrConditions = array();

					$strStartDate = base64_decode($strStartD);
					$strEndDate = base64_decode($strEndD);
					if($this->request->is('Post'))
					{
						
						
						//$strStartDate = $this->request->data['from_date_hid']." 00:00:00";
						//$strEndDate = $this->request->data['to_date_hid']." 23:59:59";
					}
					if($strStartDate)
					{
						$arrConditions['Resourceorderdetail.order_detail_creation_date_time >='] = $strStartDate;
					}
					
					if($strEndDate)
					{
						$arrConditions['Resourceorderdetail.order_detail_creation_date_time <='] = $strEndDate;
					}

					$arrConditions['Resourceorderdetail.refund_status ='] = 1;

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
							
							
							
							
							
							$arrNewOrders[$intFrCnt]['vendorsuser'] = $arrSubVendorsFor[0];
							
							
							$intFrCnt++;
						}
					}



				

					


					

					$view = new View($this, false);

					//$view->set('arrPortalUserList', $arrPortalUserList);
					$view->set('arrProductList',$arrNewOrders);

					$strElementHtml = $view->element('orderrefund');

					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}

				}

				if($strStatRequestId == "8")

				{
					//Configure::write('debug','2');
					$arrResponse['chartTitle'] = "Job Seekeres 15 steps completed";

					$this->loadModel('User');

					$this->loadModel('Portal');

					//$arrPortalOwnerList = $this->User->find->('all',array('conditions'=>array('portal_id'=>$intPortalId,'is_active'=>'1')));

					$arrPortalUserList = $this->User->fnGetUserCompleted15Steps($intPortalId);

					//print_r($arrPortalUserList);die;

					$arrResponse['graphseariesvalue'] = count($arrPortalUserList);

					$view = new View($this, false);

					$view->set('arrPortalOwnerList', $arrPortalUserList);

					$strElementHtml = $view->element('registered15processcompleted');

					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}


				}
				if($strStatRequestId == "9")

				{
					//Configure::write('debug','2');
					$arrResponse['chartTitle'] = "Job Seekers Applied for jobs";
					
					$strCurrentUser = $arrLoggedUserDetails = $this->Auth->user();		
					$this->set('strCurrentUser',$strCurrentUser);
					$this->loadModel('JobsApplied');
					/*$arrApplications = $this->JobsApplied->find('all',array('conditions'=>array('job_portal_id'=>$strCurrentUser['portal_id'])));*/
					
					$this->Paginator->settings = array(
						'conditions' => array('job_portal_id'=>$strCurrentUser['portal_id']),
						'order' => array('job_application_id' => 'DESC'),
						'limit' => 20
					);
					
					$arrApplications = $this->Paginator->paginate('JobsApplied');
					
					//print("<pre>");print_r($arrApplications);
					
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

					//print_r($arrApplications);die;

					$arrResponse['graphseariesvalue'] = count($arrApplications);

					$view = new View($this, false);

					$view->set('arrApplications', $arrApplications);

					$strElementHtml = $view->element('jobseekersappliedforownerjob');

					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}


				}
				if($strStatRequestId == "10")

				{
					Configure::write('debug','2');
					$arrResponse['chartTitle'] = "Job Seekeres Purchased Orders";

					$this->loadModel('User');

					$arrJobSeekerPurchaseOrderList = $this->User->fnGetJobSeekerPurchasedOrder();

				//	echo '<pre>',print_r($arrJobSeekerPurchaseOrderList);die;
					$arrResponse['graphseariesvalue'] = count($arrJobSeekerPurchaseOrderList);

					$view = new View($this, false);

					$view->set('arrJobSeekerPurchaseOrderList', $arrJobSeekerPurchaseOrderList);

					$strElementHtml = $view->element('jobseekerspurchasedorder');
//print_r($strElementHtml);die;
					if($strElementHtml)

					{

						$arrResponse['status'] = "success";

						$arrResponse['content'] = $strElementHtml;

						echo json_encode($arrResponse);exit;

					}


				}

			}

		}

	}

	

	public function index($intPortalId = "")

	{

		//print("<pre>");

		//print_r($_SESSION);		

		$arrLoggedUserDetails = $this->Auth->user();

		$this->loadModel('Portal');

		$intPortalExists = $this->Portal->find('count', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

								

		if($intPortalExists)

		{

			$this->set('strPostJobIndexUrl',Configure::read('Jobber.employerjobindexurl'));

			$this->set('portal_id',$intPortalId);

			

			$arrPortalDetail = $this->Portal->find('all', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

			$strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];

			$arrEvents = array(

								$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",

								/*$arrPortalDetail[0]['Portal']['career_portal_name']." Logged In Users",

								$arrPortalDetail[0]['Portal']['career_portal_name']." Logged Out Users",

								$arrPortalDetail[0]['Portal']['career_portal_name']." Confirmed Users",

								$arrPortalDetail[0]['Portal']['career_portal_name']." Basic Search",

								$arrPortalDetail[0]['Portal']['career_portal_name']." Advance Search"*/

							);

			

			$compMixPanel = $this->Components->load('MixPanel');

			$objTrendsData = $compMixPanel->fnGetTrends($arrEvents);

			$arrCheckSeriesDataValues = (array) $objTrendsData->data->values;

			

			if(is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues)<=0))

			{

				$arrDfaultValueData = array();

				foreach($arrEvents as $strEvents)

				{

					$arrDefaultSeriesData = array();

					foreach($objTrendsData->data->series as $arrSeries)

					{

						$arrDefaultSeriesData[$arrSeries] = "0";

						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";

					}

					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;

				}

				/*print("<pre>");

				print_r($arrDfaultValueData);*/

				$arrCheckSeriesDataValues = $arrDfaultValueData;

			}

			

			$strSeriesData = "[]";

			$strSeriesDataValue = "[]";

			if(isset($objTrendsData->data->series) && isset($objTrendsData->data->values))

			{

				$strSeriesData = "[";

				foreach($objTrendsData->data->series as $arrSeries)

				{

					$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";

				}

				

				$strSeriesData .= "]";

				

				$strSeriesDataValue = "[";

				

				//$this->set('strSeriesLabels',rtrim($strSeriesData,","));

				

				//echo "----".$strSeriesData;

				//$strSeriesData = "[";

				$arrSeriesData = array();

				$arrSeriesDataValues = $arrCheckSeriesDataValues;

				

				foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)

				{

					$strSeriesDataValue .= "{name:'".$arrSeriesDataLabel."',";

					$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;

					$strSeriesDataValue .= "data:[";

					foreach($objTrendsData->data->series as $arrSeries)

					{

						//$strSeriesData .= "'".$arrSeries."',";

						$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."],";

					}

					$strSeriesDataValue = rtrim($strSeriesDataValue,",");

					

					/*foreach($arrSeriesDataValueList as $arrSeriesDataValueListLabel => $arrSeriesDataValueListLabelValue)

					{

						//$arrSeriesData[] = "'".$arrSeriesDataValueListLabel."'";

						$strSeriesDataValue .= "['".$arrSeriesDataValueListLabel."',".$arrSeriesDataValueListLabelValue."],";

					}*/

					$strSeriesDataValue .= "]},";

				}

				$strSeriesDataValue = rtrim($strSeriesDataValue,",");

				//$arrSeriesData = array_unique($arrSeriesData);

				//$strSeriesData = "[".implode(",",$arrSeriesData)."]";

				$strSeriesDataValue .= "]";

				//$this->set('strSeriesLabelsValues',$strSeriesDataValue);

				//$this->set('strSeriesLabels',rtrim($strSeriesData,","));

			}

			$this->set('strSeriesLabelsValues',$strSeriesDataValue);

			$this->set('strSeriesLabels',rtrim($strSeriesData,","));

			$this->set('arrEvents',$arrEvents);

			//print("<pre>");

			//print_r($arrSeriesDataValues);

		}

		else

		{

			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');

		}		

	}

	

	public function updatepropertygraph($intPortalId = "")

	{

		$this->layout = NULL;

		$this->autoRender = false;

		$arrResponse = array();

		$arrPropertyRequest = array();

		$arrLoggedUserDetails = $this->Auth->user();

		$this->loadModel('Portal');

		$intPortalExists = $this->Portal->find('count', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

								

		if($intPortalExists)

		{

			$arrPortalDetail = $this->Portal->find('all', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

			$strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];

			$strEventPartName = $this->request->data['eventrequest'];

			$strEventFromDate = $this->request->data['frmdate'];

			$strEventToDate = $this->request->data['todate'];

			$strEventProperty = $this->request->data['property'];

			if($strEventPartName == "All")

			{

				$arrEvents = array(

									$arrPortalDetail[0]['Portal']['career_portal_name']." Logged In Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Logged Out Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Confirmed Users"

								);

			}

			else

			{

				$strEventName = $strEventName." ".$strEventPartName;

				$arrEvents = array($strEventName);

			}

			$compMixPanel = $this->Components->load('MixPanel');

			$objPropertiesFilteredData = $compMixPanel->fnGetPropertyWiseData($arrEvents,$strEventFromDate,$strEventToDate,$strEventProperty);

			/*print("<pre>");

			print_r($objPropertiesFilteredData);

			exit;*/

			if($strEventFromDate && $strEventToDate)

			{

				$compTime = $this->Components->load('TimeCalculation');

				$strDateDiff = $compTime->fnGetDurationInDays($strEventFromDate,$strEventToDate);

				$arrResponse['monhtsdata'] = $compTime->fnGetMonthsFromDays($strDateDiff);

			}

			if( $objPropertiesFilteredData->legend_size)

			{

				$arrResponse['legendsize'] =  $objPropertiesFilteredData->legend_size;

			}

			

			$arrCheckSeriesDataValues = (array) $objPropertiesFilteredData->data->values;

			

			if(is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues)<=0))

			{

				$arrDfaultValueData = array();

				foreach($arrEvents as $strEvents)

				{

					$arrDefaultSeriesData = array();

					foreach($objPropertiesFilteredData->data->series as $arrSeries)

					{

						$arrDefaultSeriesData[$arrSeries] = "0";

						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";

					}

					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;

				}

				/*print("<pre>");

				print_r($arrDfaultValueData);*/

				$arrCheckSeriesDataValues = $arrDfaultValueData;

			}

			if(isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values))

			{

				

				$strSeriesData = "";

				$strSeriesDataValue = "";

				$arrPieData = array();

				foreach($objPropertiesFilteredData->data->series as $arrSeries)

				{

					$strSeriesData .= date("jS M y",strtotime($arrSeries)).",";

					$strSeriesDataValue .= "0,";

				}

				$arrResponse['chartdata'] = "null";

				$arrSeriesData = array();

				$arrSeriesDataValues = $arrCheckSeriesDataValues;

				if(is_array($arrSeriesDataValues) && (count($arrSeriesDataValues)>0))

				{

					$strSeriesDataValue = "";

					$arrResponse['PieData'] = "";

					foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)

					{

						$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;

						$strSeriesDataValue .= $arrSeriesDataLabel.":";

						$intTotalCount = 0;

						foreach($objPropertiesFilteredData->data->series as $arrSeries)

						{

							//$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";

							if($arrSeriesDataValueList[$arrSeries])

							{

								$arrResponse['chartdata'] = "notnull";

							}

							$strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries].",";

							$intTotalCount = $intTotalCount + $arrSeriesDataValueList[$arrSeries];

						}

						$arrResponse['PieData'] .= $arrSeriesDataLabel.",".$intTotalCount."~";

						$strSeriesDataValue = rtrim($strSeriesDataValue,",");

						$strSeriesDataValue .= "~";

					}

				}

				

				$arrSeriesData = array_unique($arrSeriesData);

				

				$arrResponse['status'] = "success";

				$arrResponse['xseries'] = rtrim($strSeriesData,",");

				$arrResponse['dataseries'] = rtrim($strSeriesDataValue,"~");

				$arrResponse['chartTitle'] = $strEventProperty." Wise";

				/*print("<pre>");

				print_r($arrResponse);

				exit;*/

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

	

	public function updategraph($intPortalId = "")

	{

		

		$this->layout = NULL;

		$this->autoRender = false;

		$arrResponse = array();

		$arrPropertyRequest = array();

		$arrLoggedUserDetails = $this->Auth->user();

		$this->loadModel('Portal');

		$intPortalExists = $this->Portal->find('count', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

								

		if($intPortalExists)

		{

			$arrPortalDetail = $this->Portal->find('all', array(

									'conditions' => array('career_portal_id'=> $intPortalId)

								));

			$strEventName = $arrPortalDetail[0]['Portal']['career_portal_name'];

			$strEventPartName = $this->request->data['eventrequest'];

			$strEventFromDate = $this->request->data['frmdate'];

			$strEventToDate = $this->request->data['todate'];

			if($strEventPartName == "All")

			{

				$arrEvents = array(

									$arrPortalDetail[0]['Portal']['career_portal_name']." Logged In Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Logged Out Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Registered Users",

									$arrPortalDetail[0]['Portal']['career_portal_name']." Confirmed Users"

								);

			}

			else

			{

				$strEventName = $strEventName." ".$strEventPartName;

				$arrEvents = array($strEventName);

			}

			$compMixPanel = $this->Components->load('MixPanel');

			$objPropertiesFilteredData = $compMixPanel->fnGetTrends($arrEvents,$strEventFromDate,$strEventToDate);

			if($strEventFromDate && $strEventToDate)

			{

				$compTime = $this->Components->load('TimeCalculation');

				$strDateDiff = $compTime->fnGetDurationInDays($strEventFromDate,$strEventToDate);

				$arrResponse['monhtsdata'] = $compTime->fnGetMonthsFromDays($strDateDiff);

			}

			

			$arrCheckSeriesDataValues = (array) $objPropertiesFilteredData->data->values;

			

			if(is_array($arrCheckSeriesDataValues) && (count($arrCheckSeriesDataValues)<=0))

			{

				$arrDfaultValueData = array();

				foreach($arrEvents as $strEvents)

				{

					$arrDefaultSeriesData = array();

					foreach($objPropertiesFilteredData->data->series as $arrSeries)

					{

						$arrDefaultSeriesData[$arrSeries] = "0";

						//$strSeriesData .= "'".date("jS M y",strtotime($arrSeries))."',";

					}

					$arrDfaultValueData[$strEvents] = $arrDefaultSeriesData;

				}

				/*print("<pre>");

				print_r($arrDfaultValueData);*/

				$arrCheckSeriesDataValues = $arrDfaultValueData;

			}

			

			if(isset($objPropertiesFilteredData->data->series) && isset($objPropertiesFilteredData->data->values))

			{

				$strSeriesData = "";

				$strSeriesDataValue = "";

				foreach($objPropertiesFilteredData->data->series as $arrSeries)

				{

					$strSeriesData .= date("jS M y",strtotime($arrSeries)).",";

					$strSeriesDataValue .= "0,";

				}

				$arrResponse['chartdata'] = "null";

				$arrSeriesData = array();

				$arrSeriesDataValues = $arrCheckSeriesDataValues;

				if(is_array($arrSeriesDataValues) && (count($arrSeriesDataValues)>0))

				{

					$strSeriesDataValue = "";

					foreach($arrSeriesDataValues as $arrSeriesDataLabel => $arrSeriesDataLabelValue)

					{

						$arrSeriesDataValueList = (array) $arrSeriesDataLabelValue;

						$strSeriesDataValue .= $arrSeriesDataLabel.":";

						foreach($objPropertiesFilteredData->data->series as $arrSeries)

						{

							//$strSeriesDataValue .= "['".date("jS M y",strtotime($arrSeries))."',".$arrSeriesDataValueList[$arrSeries]."]~";

							if($arrSeriesDataValueList[$arrSeries])

							{

								$arrResponse['chartdata'] = "notnull";

							}

							$strSeriesDataValue .= $arrSeriesDataValueList[$arrSeries].",";

						}

						$strSeriesDataValue = rtrim($strSeriesDataValue,",");

						$strSeriesDataValue .= "~";

					}

				}

				

				$arrSeriesData = array_unique($arrSeriesData);

				

				$arrResponse['status'] = "success";

				$arrResponse['xseries'] = rtrim($strSeriesData,",");

				$arrResponse['dataseries'] = rtrim($strSeriesDataValue,"~");

				$arrResponse['chartTitle'] = $arrPortalDetail[0]['Portal']['career_portal_name'];

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

}