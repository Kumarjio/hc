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