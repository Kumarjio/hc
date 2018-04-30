<?php
App::uses('Component', 'Controller');
class InfusionsoftComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	
	public function fnConfirmSubscription($intContactId = "",$intOrderId = "")
	{
		App::import('Vendor', 'infusionsoft/sdk/src/isdk');
		if($intContactId && $intOrderId)
		{
			$app = new iSDK;
			if($app->cfgCon("connectionName"))
			{
				$arrQry = array('JobId'=>$intOrderId);
				$returnFields = array('PayStatus');
				$arrOrderDetails = $app->dsQuery("Invoice", 99, 0, $arrQry, $returnFields);
				if($arrOrderDetails[0]['PayStatus'])
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetOrderDetail($intOrderId = "")
	{
		if($intOrderId)
		{
			App::import('Vendor', 'infusionsoft/sdk/src/isdk');
			$app = new iSDK;
			if ($app->cfgCon("connectionName"))
			{
				$arrQry = array('Id'=>$intOrderId);
				//$arrQry = array('ContactId'=>$intOrderId);
				$returnFields = array('JobRecurringId','ContactId','ProductId','StartDate','Id','DueDate');
				$arrOrderDetails = $app->dsQuery("Job", 99, 0, $arrQry, $returnFields);
				return $arrOrderDetails;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetSubscriptionExpiryInformation($intOrderId = "",$intContactId = "")
	{
		if($intOrderId && $intContactId)
		{
			App::import('Vendor', 'infusionsoft/sdk/src/isdk');
			$app = new iSDK;
			if ($app->cfgCon("connectionName"))
			{
				$arrQry = array('OrderId'=>$intOrderId);
				//$arrQry = array('ContactId'=>$intOrderId);
				$returnFields = array('ProductId','ItemName','ItemType','ItemDescription','SubscriptionPlanId');
				$arrOrderDetails = $app->dsQuery("OrderItem", 99, 0, $arrQry, $returnFields);
				$intSubscriptionPlanId = "";
				if(is_array($arrOrderDetails) && (count($arrOrderDetails)>0))
				{
					foreach($arrOrderDetails as $arrOrderD)
					{
						$intSubscriptionPlanId = $arrOrderD['SubscriptionPlanId'];
						break;
					}
					$arrQry = array('SubscriptionPlanId'=>$intSubscriptionPlanId,'ContactId'=>$intContactId);
					//$arrQry = array('ContactId'=>$intOrderId);
					$returnFields = array('NextBillDate','SubscriptionPlanId','ContactId','BillingCycle','AutoCharge');
					$arrSubscriptionDetails = $app->dsQuery("RecurringOrder", 99, 0, $arrQry, $returnFields);
					
					$strBillDate = $arrSubscriptionDetails[0]['NextBillDate'];
					if($strBillDate)
					{
						if(strpos($strBillDate,"T"))
						{
							$arrDate = explode("T",$strBillDate);
							return $arrDate[0];
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
				//return $arrOrderDetails;
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetOrderItems($intOrderId = "")
	{
		if($intOrderId)
		{
			App::import('Vendor', 'infusionsoft/sdk/src/isdk');
			$app = new iSDK;
			if ($app->cfgCon("connectionName"))
			{
				$arrQry = array('OrderId'=>$intOrderId);
				//$arrQry = array('ContactId'=>$intOrderId);
				$returnFields = array('ProductId','ItemName','ItemType','ItemDescription','SubscriptionPlanId');
				$arrOrderDetails = $app->dsQuery("OrderItem", 99, 0, $arrQry, $returnFields);
				return $arrOrderDetails;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetSubscriptionDetails($intOrderId = "",$intContactId = "")
	{
		if($intOrderId)
		{
			App::import('Vendor', 'infusionsoft/sdk/src/isdk');
			$app = new iSDK;
			if ($app->cfgCon("connectionName"))
			{
				$arrQry = array('SubscriptionPlanId'=>$intOrderId,'ContactId'=>$intContactId);
				//$arrQry = array('ContactId'=>$intOrderId);
				$returnFields = array('NextBillDate','SubscriptionPlanId','ContactId','BillingCycle','AutoCharge');
				$arrOrderDetails = $app->dsQuery("RecurringOrder", 99, 0, $arrQry, $returnFields);
				return $arrOrderDetails;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetSubscriptionExpiryDate($intOrderId = "")
	{
		App::import('Vendor', 'infusionsoft/sdk/src/isdk');
		if($intOrderId)
		{
			//echo "--".$intOrderId;
			//exit;
			
			$app = new iSDK;
			if ($app->cfgCon("connectionName"))
			{
				$arrQry = array('Id'=>$intOrderId);
				$returnFields = array('JobRecurringId','ContactId','ProductId','Id','DueDate','StartDate','OrderStatus','OrderType');
				$arrOrderDetails = $app->dsQuery("Job", 99, 0, $arrQry, $returnFields);
				$intContactId = $arrOrderDetails[0]['ContactId'];
				
				//print("<pre>");
				//print_r($arrOrderDetails);
				//exit;
				$intReccuringOrderId = $arrOrderDetails[0]['JobRecurringId'];
				
				if($intReccuringOrderId)
				{
					$arrQry = array('Id'=>$intReccuringOrderId);
					$returnFields = array('ProductId','ContactId','FirstName','Frequency','NextBillDate','LastBillDate');
					$arrSubscriptionDetails = $app->dsQuery("RecurringOrderWithContact", 99, 0, $arrQry, $returnFields);
					
					$strBillDate = $arrSubscriptionDetails[0]['NextBillDate'];
					if($strBillDate)
					{
						if(strpos($strBillDate,"T"))
						{
							$arrDate = explode("T",$strBillDate);
							return $arrDate[0];
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}
				else
				{
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	public function fnCheckSubscriptionStatus($intContactId = "", $intOrderId = "",$strCurrentDate = "")
	{
		App::import('Vendor', 'infusionsoft/sdk/src/isdk');
		
		$intOrderId = 198;
		$intCid = 183733;

		$app = new iSDK;
		//print("<pre>");
		//print_r($app);
		//exit;
		
		if ($app->cfgCon("connectionName")) 
		{
			$returnFields = array('Email', 'FirstName', 'LastName');
			//$conDat = $app->loadCon($intCid, $returnFields);
			
			$arrQry = array('Id'=>$intOrderId);
			$returnFields = array('JobRecurringId','ContactId','ProductId');
			$arrOrderDetails = $app->dsQuery("Job", 99, 0, $arrQry, $returnFields);
			$intReccuringOrderId = $arrOrderDetails[0]['JobRecurringId'];
			$intContactId = $arrOrderDetails[0]['ContactId'];
			
			echo "Order Detail";
			echo "<pre>";
			print_r($arrOrderDetails);
			
			$arrQry = array('Id'=>$intReccuringOrderId);
			$returnFields = array('ProductId','ContactId','FirstName','Frequency','NextBillDate','LastBillDate');
			$arrOrderDetails = $app->dsQuery("RecurringOrderWithContact", 99, 0, $arrQry, $returnFields);
			
			echo "Order Subscription Detail";
			echo "<pre>";
			print_r($arrOrderDetails);
			
			$intProductId = $arrOrderDetails[0]['ProductId'];
			$arrQry = array('Id'=>$intProductId);
			$returnFields = array('ProductName','ProductPrice','Description');
			$arrOrderDetails = $app->dsQuery("Product", 99, 0, $arrQry, $returnFields);
			
			echo "Product Detail";
			echo "<pre>";
			print_r($arrOrderDetails);
			
			$returnFields = array('Email', 'FirstName', 'LastName');
			$conDat = $app->loadCon($intContactId, $returnFields);
			
			echo "Contact Detail";
			echo "<pre>";
			print_r($conDat);
			
			
			
			$arrQry = array('JobId'=>$intOrderId);
			$returnFields = array('PayStatus');
			$arrOrderDetails = $app->dsQuery("Invoice", 99, 0, $arrQry, $returnFields);
			
			echo "Invoice Detail";
			echo "<pre>";
			print_r($arrOrderDetails);
			
			exit;
		}
		else
		{
			echo "Connection Failed";
		}
		//exit;
		
		//echo "</pre>";
		
		/*print("<pre>");
		print_r($infusionsoft);
		exit;*/
		//echo "--".$strForm = $infusionsoft->webForms->getHTML("75");
		
		/*$arrStatus = array();
		if($intContactId && $intOrderId)
		{
			
			
		}
		else
		{
			$arrStatus['status'] = "fail";
			$arrStatus['message'] = "parameters missing";
		}*/
		
		return $arrStatus;
	}
}
?>