<?php
App::uses('Component', 'Controller');
class CpaOffersComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
        
        public function fnAddOffers($arrOffersInfo = array()) {
            $modelOffers = ClassRegistry::init('Cpaoffers');
            if (is_array($arrOffersInfo) && (count($arrOffersInfo) > 0)) {
                if ($_FILES['offer_image']['name'] != "") {
                        $strOffersImgName = time() . "_" . $_FILES['offer_image']['name'];
                        $strOfferImageTmpName = $_FILES['offer_image']['tmp_name'];
                        move_uploaded_file($strOfferImageTmpName, WWW_ROOT . 'offer-images/' . $strOffersImgName);
                        $arrOffersInfo['offer_image'] = $strOffersImgName;
                }
                $arrOfferSaved = $modelOffers->save($arrOffersInfo);

                if ($arrOfferSaved) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
        
        public function fnUpdateOffers($arrOffersInfo = array()) {
            
            $modelOffers = ClassRegistry::init('Cpaoffers');
            if (is_array($arrOffersInfo) && (count($arrOffersInfo) > 0)) {
                if ($_FILES['offer_image']['name'] != "") {
                        $strOffersImgName = time() . "_" . $_FILES['offer_image']['name'];
                        $strOfferImageTmpName = $_FILES['offer_image']['tmp_name'];
                        move_uploaded_file($strOfferImageTmpName, WWW_ROOT . 'offer-images/' . $strOffersImgName);
                        $arrOffersInfo['offer_image'] = $strOffersImgName;
                }
                
                $arrOffersData['hc_cost'] = htmlspecialchars(addslashes($this->request->data['hc_cost']));
            $arrOffersData['portal_cost'] = htmlspecialchars(addslashes($this->request->data['portal_cost']));
            
                if ($_FILES['offer_image']['name'] != "") {
                $arrOfferSaved = $modelOffers->updateAll(
                        array('offer_name'=>"'".$arrOffersInfo['offer_name']."'",'offer_url' => "'".$arrOffersInfo['offer_url']."'",'offer_description' => "'".$arrOffersInfo['offer_description']."'",'hc_cost' => "'".$arrOffersInfo['hc_cost']."'",'portal_cost' => "'".$arrOffersInfo['portal_cost']."'",'offer_image' => "'".$arrOffersInfo['offer_image']."'"),
                        array('offer_id =' => $arrOffersInfo['offer_id'])
                );
                }else{
                    $arrOfferSaved = $modelOffers->updateAll(
                        array('offer_name'=>"'".$arrOffersInfo['offer_name']."'",'offer_url' => "'".$arrOffersInfo['offer_url']."'",'offer_description' => "'".$arrOffersInfo['offer_description']."'",'hc_cost' => "'".$arrOffersInfo['hc_cost']."'",'portal_cost' => "'".$arrOffersInfo['portal_cost']."'"),
                        array('offer_id =' => $arrOffersInfo['offer_id'])
                    ); 
                }
                if ($arrOfferSaved) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
        
        public function fnAddOffersCommission($arrOffersInfo = array()) {
            
            $modelOffers = ClassRegistry::init('CpaoffersCommissions');
            if (is_array($arrOffersInfo) && (count($arrOffersInfo) > 0)) {
                $arrOfferSaved = $modelOffers->save($arrOffersInfo);

                if ($arrOfferSaved) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
        
        public function fnUpdateOffersComission($arrOffersInfo = array()) {
            
            $modelOffers = ClassRegistry::init('CpaoffersCommissions');
            if (is_array($arrOffersInfo) && (count($arrOffersInfo) > 0)) {
                
                    $arrOfferSaved = $modelOffers->updateAll(
                        array('hc_cost' => "'".$arrOffersInfo['hc_cost']."'",'portal_cost' => "'".$arrOffersInfo['portal_cost']."'"),
                        array('offer_commission_id =' => $arrOffersInfo['offer_commission_id'])
                    ); 
                
                if ($arrOfferSaved) {
                    return true;
                } else {
                    return false;
                }
            } 
        }
}
?>