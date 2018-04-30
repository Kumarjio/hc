<?php
App::uses('Component', 'Controller');
class AuthorizeComponent extends Component 
{
    public $components = array('Session','TimeCalculation','Auth');
	 
	public function startup(Controller $controller) {
		$this->Controller = $controller;
	}
	
	public function fnSubmitCheckoutTransaction($arrTransactionDetail = array(),$arrVendorAccount = array())
	{
//		echo '<pre>vendor';print_r($arrVendorAccount);exit();
		$arrResponse = array();
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrTransactionDetail) && count($arrTransactionDetail)>0)
		{
			App::import('Vendor', 'authorize/autoload');
			App::import('Vendor', 'authorize/lib/AuthorizeNetAIM');
			
			// API credentials only need to be defined once
			define("AUTHORIZENET_API_LOGIN_ID", "2qFdY5v74");
			define("AUTHORIZENET_TRANSACTION_KEY", "842z6pK8Rqg8r9LJ");
			define("AUTHORIZENET_SANDBOX", true);
			
			$sale = new AuthorizeNetAIM;
			  $sale->amount = $arrTransactionDetail['orderamount'];
			  $sale->card_num = $arrTransactionDetail['cardnum'];
			  $sale->exp_date = $arrTransactionDetail['exp_month'].$arrTransactionDetail['exp_year'];
			  $sale->email = $arrTransactionDetail['custoner_email'];
			  $sale->first_name = $arrTransactionDetail['custoner_fname'];
			  $sale->last_name = $arrTransactionDetail['custoner_lname'];
			  
			  $response = $sale->authorizeAndCapture();
			  if($response->approved) 
			  {
                            if($arrVendorAccount[0]['Vendors']['vendor_name'] == 'Donna Fedora' || $arrVendorAccount[0]['Vendors']['vendor_id'] == '84' && $arrVendorAccount[0]['Vendors']['vendor_type'] == 'Course' || $arrVendorAccount[0]['Vendors']['vendor_type'] == 'SkillSoftcourse'){
//                                echo '<pre>if';print_r($arrVendorAccount[0]['Vendors']['product_access_link']);exit(); 
                                $strOrderStatus = "initiated";
				$strPaymentStatus = "incomplete";
				$arrResponse['type'] = "othersite";
				$arrResponse['status'] = "success";
				$arrResponse['transactionid'] = $response->transaction_id;
				$arrResponse['redirect_link'] = $arrVendorAccount[0]['Vendors']['product_access_link'];
                            }else{
				$strOrderStatus = "initiated";
				$strPaymentStatus = "incomplete";
				$arrResponse['type'] = "normal";
				$arrResponse['status'] = "success";
				$arrResponse['transactionid'] = $response->transaction_id;		
                            }
				
				$modelResourceOrder = ClassRegistry::init('Resourceorder');
				if($response->approved)
				{
					$strOrderStatus = "approved";
					$strPaymentStatus = "captured";
				}
				
				$boolUpdated = $modelResourceOrder->updateAll(
						array('order_transaction_id' =>"'".$arrResponse['transactionid']."'","order_payment_status"=>"'".$strPaymentStatus."'","order_status"=>"'".$strOrderStatus."'","bill_cust_f_name"=>"'".$arrTransactionDetail['custoner_fname']."'","bill_cust_l_name"=>"'".$arrTransactionDetail['custoner_lname']."'","bill_cust_address"=>"'".$arrTransactionDetail['custoner_add']."'","bill_cust_email"=>"'".$arrTransactionDetail['custoner_email']."'","bill_cust_postal_code"=>"'".$arrTransactionDetail['customer_postal_code']."'","bill_cust_country"=>"'".$arrTransactionDetail['customer_country']."'","bill_cust_state_province"=>"'".$arrTransactionDetail['customer_state_province']."'","bill_cust_city_county"=>"'".$arrTransactionDetail['customer_city_county']."'"),
						array('resource_order_id =' => $arrTransactionDetail['orderid'])
					);
				
				if($boolUpdated)
				{
					// notify Vendor
					$modelResourceOrderDetail = ClassRegistry::init('Resourceorderdetail');
					$arrOrderDetail = $modelResourceOrderDetail->find('all',array('conditions'=>array('order_id'=>$arrTransactionDetail['orderid'])));
					if(is_array($arrOrderDetail) && (count($arrOrderDetail)>0))
					{
						$modelVendorDetail = ClassRegistry::init('Vendors');
						$modelServiceDetail = ClassRegistry::init('Resources');
						$modelVendorServiceDetail = ClassRegistry::init('Vendorservice');
						$modelCartDetail = ClassRegistry::init('Resourcecart');
						$modelNotification = ClassRegistry::init('Notification');
						
						foreach($arrOrderDetail as $arrOrder)
						{
							$intVendorId = $arrOrder['Resourceorderdetail']['vendor_id'];
							$strOrderDateTime = date("Y-m-d H:i:s");
							$boolOrderDetailUpdated = $modelResourceOrderDetail->updateAll(
								array('payment_status' => "'".$strPaymentStatus."'","order_detail_status"=>"'".$strOrderStatus."'",'vendor_notified'=>'1','vendor_order_state'=>"'New Order'",'order_confirmation_date_time'=>"'".$strOrderDateTime."'"),
								array('order_detail_id =' => $arrOrder['Resourceorderdetail']['order_detail_id'])
							);
							if($arrOrder['Resourceorderdetail']['cart_product_id'])
							{
								$modelCartDetail->deleteAll(array('cart_instance_id' => $arrOrder['Resourceorderdetail']['cart_product_id']),false);
							}
							$arrVendorDetails = $modelVendorDetail->find('all',array('conditions'=>array('vendor_id'=>$intVendorId)));
							if(is_array($arrVendorDetails) && count($arrVendorDetails)>0)
							{
								$arrSystemNotification['Notification']['candidate_id'] = $intVendorId;
								$arrSystemNotification['Notification']['reminder_type'] = 'orderupdate';
								$arrSystemNotification['Notification']['reminder_id'] = $arrOrder['Resourceorderdetail']['order_detail_id'];
								$arrSystemNotification['Notification']['notification_created_by'] = $arrLoggedUserDetails['candidate_id'];
								$arrSystemNotification['Notification']['foruser'] = "owner";
								$modelNotification->create(false);
								$isSystemNotified = $modelNotification->save($arrSystemNotification);
								//$this->Controller->fnResourceTransactionNotificationVendor($arrVendorDetails,$arrTransactionDetail['portalname'],$arrOrder['Resourceorderdetail']['product_name']);
							}
						}
						
					}
					
					
					// notify hc admin
					// notify seeker 
					$modelEmailDetail = ClassRegistry::init('Email');
					$emailContent = $modelEmailDetail->find('first', array('conditions' => array('Email.template_key' =>'order')));
					$isSeekerSent = $this->Controller->fnResourceTransactionNotificationSeeker($arrLoggedUserDetails,$arrTransactionDetail['portalname'],$emailContent['Email']);
					
					// notify vendor 
//					$emailContent = $modelEmailDetail->find('first', array('conditions' => array('Email.template_key' =>'order')));
					$isVendorSent = $this->Controller->fnResourceTransactionNotificationVendor($arrVendorAccount,$arrTransactionDetail['portalname'],$arrOrderDetail[0]['Resourceorderdetail']['product_name']);
					
					// notify owner
					$modelUserDetail = ClassRegistry::init('User');
					$arrPortalOwnerDetail = $modelUserDetail->find('all',array('conditions'=>array('portal_id'=>$arrTransactionDetail['portalid'])));
					//$this->Controller->fnResourceTransactionNotificationOwner($arrPortalOwnerDetail,$arrTransactionDetail['portalname']);
				}
				//echo "Success! Transaction ID:" . $response->transaction_id;
				//print("<pre>");
				//print_r($response);
				//exit();
			  } 
			  else 
			  {
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = $response->error_message;
				//echo "ERROR:" . $response->error_message;
			  }
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "Missing input parameters";
		}
		return $arrResponse;
	}
	
	public function fnRefundTransaction($arrOrderDetail = array())
	{
		$arrResponse = array();
		$arrLoggedUserDetails = $this->Auth->user();
		$arrPath = App::path('Vendor');
		require($arrPath[0]."authorizexml/config.inc.php");
		require($arrPath[0]."authorizexml/AuthnetXML.class.php");
		
		//echo "HI";
		//print("<pre>");
		//print_r($arrOrderDetail);
		//exit;
		
		if(is_array($arrOrderDetail) && (count($arrOrderDetail)>0))
		{
			$xml = new AuthnetXML(AUTHNET_LOGIN, AUTHNET_TRANSKEY, AuthnetXML::USE_DEVELOPMENT_SERVER);
			$arrResponse = $xml->createTransactionRequest(array(
				'refId' => rand(1000000, 100000000),
				'transactionRequest' => array(
					'transactionType' => 'refundTransaction',
					'amount' => $arrOrderDetail[0]['Resourceorderdetail']['product_unit_cost'],
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => '4111111111111111',
							'expirationDate' => '042018'
						)
					),
					'authCode' => $arrOrderDetail[0]['Resourceorder']['order_transaction_id']
				),
			));
			
			//echo "--".$xml->isSuccessful(); exit;
			//echo "--".$xml->isError(); exit;
			
			
			if($xml->isSuccessful())
			{
				$arrResponse['status'] = 'success';
				$arrResponse['message'] = 'Your order amount has been refunded successfully';
				$arrResponse['transid'] = $xml->transactionResponse->transId;
			}
			else
			{
				if($xml->isError())
				{
					$arrMssg = (array) $xml->transactionResponse->errors->error->errorText;
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = $arrMssg[0];
				}
				else
				{
					$arrResponse['status'] = 'fail';
					$arrResponse['message'] = 'There is some error please try again.';
				}
			}
			
			return $arrResponse;
			
			/*print("<pre>");
			print_r($arrResponse);
			
			print("<pre>");
			print_r($xml);
			exit;*/
		}
		else
		{
			
			/*print("<pre>");
			print_r($xml);
			exit;*/
			
			return false;
		}
	}
}
?>