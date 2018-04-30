<?php
App::uses('Component', 'Controller');
class SkillSoftComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) {
		$this->Controller = $controller;
	}
	
	public function fnskillsoftRegistration($arrUserInfo = array())
	{
		App::import('Vendor', 'skillsoft/olsalib');
		
		$userName = $arrUserInfo['userName'];
		$firstName = $arrUserInfo['firstName'];
		$lastName = $arrUserInfo['lastName'];
		$actionType = $arrUserInfo['actionType'];
		$assetId = $arrUserInfo['assetId'];
		$catalogPath = $arrUserInfo['catalogPath'];
		$response1 = SO_GetMultiActionSignOnUrl($userName, $actionType, $assetId, $firstName, $lastName); //First and Last Names are optional after initial setup.

		if($response1->success)
		{
			$olsasoapresponse = UD_GetAssetResults($userName,$assetId,true);
			$response2 = AS_SetCatalogAssignmentByUser($catalogPath, $userName);
			//echo "<a target='_blank' href='" . $response1->result->olsaURL . "' > Launch </a>";
			return  $response1->result->olsaURL;
			
		}
		else
		{
			return 0;
		}
	}
	public function GetuserLogin($userName)
	{
		App::import('Vendor', 'skillsoft/olsalib');
		$assetId="";
		$response1 = SO_GetMultiActionSignOnUrl($userName);
		$olsasoapresponse = UD_GetAssetResults($userName,$assetId,true);
		
		return  $response1->result->olsaURL;
	}	
	
	public function fnAddService($arrContentData = array()) {
            $modelResources = ClassRegistry::init('Resources');
            if (is_array($arrContentData) && (count($arrContentData) > 0)) {
                if ($_FILES['product_file']['name'] != "") {
                        $strOffersImgName = time() . "_" . $_FILES['product_file']['name'];
                        $strOfferImageTmpName = $_FILES['product_file']['tmp_name'];
                        move_uploaded_file($strOfferImageTmpName, WWW_ROOT . 'productfiles/' . $strOffersImgName);
                        $arrContentData['product_file'] = $strOffersImgName;
                }
                $arrOfferSaved = $modelResources->save($arrContentData);

                if ($arrOfferSaved) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
        
	public function fnUpdateService($arrContentData = array(),$intEditModeId) {
//            echo '<pre>';print_r($arrContentData);die;
            $modelResources = ClassRegistry::init('Resources');
            if (is_array($arrContentData) && (count($arrContentData) > 0)) {
                if ($_FILES['product_file']['name'] != "") {
                        $strOffersImgName = time() . "_" . $_FILES['product_file']['name'];
                        $strOfferImageTmpName = $_FILES['product_file']['tmp_name'];
                        move_uploaded_file($strOfferImageTmpName, WWW_ROOT . 'productfiles/' . $strOffersImgName);
                        $arrContentData['product_file'] = $strOffersImgName;
                }
                 if ($_FILES['product_file']['name'] != "") {
                    $boolContentUpdated = $modelResources->updateAll(
                            array('product_name' => "'" . addslashes($arrContentData['product_name']) . "'", 'product_publish_status' => "'" . $arrContentData['product_publish_status'] . "'", 'product_type' => "'" . $arrContentData['product_type'] . "'", 'product_cost' => "'" . $arrContentData['product_cost'] . "'", 'discount_cost' => "'" . $arrContentData['discount_cost'] . "'",'product_file'=>"'".$arrContentData['product_file']."'"), array('productd_id =' => $intEditModeId)
                    );
                 }else{
                    $boolContentUpdated = $modelResources->updateAll(
                            array('product_name' => "'" . addslashes($arrContentData['product_name']) . "'", 'product_publish_status' => "'" . $arrContentData['product_publish_status'] . "'", 'product_type' => "'" . $arrContentData['product_type'] . "'", 'product_cost' => "'" . $arrContentData['product_cost'] . "'", 'discount_cost' => "'" . $arrContentData['discount_cost'] . "'"), array('productd_id =' => $intEditModeId)
                    ); 
                 }
                if ($boolContentUpdated) {
                    return true;
                } else {
                    return false;
                }
            } 
        }

}
?>