

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
class ManagecpaoffersController extends AppController {

    public $components = array('Paginator');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    public $layout = "admin";
    public $name = 'Managecpaoffers';

    /**

     * Controller name

     *

     * @var string

     */

    /**

     * This controller does not use a model

     *

     * @var array

     */
    public function beforeFilter() {

        //$this->Auth->autoRedirect = false;
//        Configure::write('debug',2);
        parent::beforeFilter();
        $this->Auth->allow('index','offersdividation','offers');
    }

    public function index() {
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));

        $this->loadModel('Cpaoffers');
        $this->Cpaoffers->recursive = 0;
        $this->Paginator->settings = array(
            'Cpaoffers' => array(
                'limit' => 20,
            )
        );
        $arrCpaOfferList = $this->Paginator->paginate('Cpaoffers');
        $this->set('arrCpaOfferList', $arrCpaOfferList);
    }

    public function add() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
    }

    public function addAction() {
        $this->autoRender = false;
        if ($this->request->is('Post')) {
            $arrOffersData = array();
            $arrOffersData['pf_offer_id'] = htmlspecialchars(addslashes($this->request->data['pf_offer_id']));
            $arrOffersData['offer_name'] = htmlspecialchars(addslashes($this->request->data['offer_name']));
            $arrOffersData['offer_url'] = htmlspecialchars(addslashes($this->request->data['offer_url']));
            $arrOffersData['offer_description'] = htmlspecialchars(addslashes($this->request->data['offer_description']));
            $arrOffersData['hc_cost'] = htmlspecialchars(addslashes($this->request->data['hc_cost']));
            $arrOffersData['portal_cost'] = htmlspecialchars(addslashes($this->request->data['portal_cost']));

            $compOffers = $this->Components->load('CpaOffers');
            $arrResult = $compOffers->fnAddOffers($arrOffersData);
            $arrResponse = array();

            if ($arrResult) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Offer Successfully Added.', 'success');
                $arrResponse['status'] = "success";
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function edit($offer_id) {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);      

        $this->loadModel('Cpaoffers');
        $arrOfferDetails = $this->Cpaoffers->find('all', array('conditions' => array('offer_id' => $offer_id)));
        $this->set('offer_id', $offer_id);
        $this->set('arrOfferDetails', $arrOfferDetails[0]['Cpaoffers']);
    }

    public function editAction() {
        $this->autoRender = false;
        if ($this->request->is('Post')) {

            $arrOffersData = array();
            
            $arrOffersData['pf_offer_id'] = htmlspecialchars(addslashes($this->request->data['pf_offer_id']));
            $arrOffersData['offer_id'] = htmlspecialchars(addslashes($this->request->data['offer_id']));
            $arrOffersData['offer_name'] = htmlspecialchars(addslashes($this->request->data['offer_name']));
            $arrOffersData['offer_url'] = htmlspecialchars(addslashes($this->request->data['offer_url']));
            $arrOffersData['offer_description'] = htmlspecialchars(addslashes($this->request->data['offer_description']));
            $arrOffersData['hc_cost'] = htmlspecialchars(addslashes($this->request->data['hc_cost']));
            $arrOffersData['portal_cost'] = htmlspecialchars(addslashes($this->request->data['portal_cost']));

            $compOffers = $this->Components->load('CpaOffers');
            $arrResult = $compOffers->fnUpdateOffers($arrOffersData);

            $arrResponse = array();

            if ($arrResult) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Offer Successfully Updated.', 'success');
                $arrResponse['status'] = "success";
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function offerdelete($intOfferId) {
        $arrResponseData = array();
        if ($intOfferId) {
            $this->loadModel('CpaOffers');
            $isOfferDetailPresent = $this->CpaOffers->find('count', array('conditions' => array('offer_id' => $intOfferId)));
            if ($isOfferDetailPresent) {
                $intOfferDeleted = $this->CpaOffers->deleteAll(array('offer_id' => $intOfferId), false);
                if ($intOfferDeleted) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Offer deleted Successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again, Please', 'warning');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Location Missing, Please', 'error');
            $arrResponseData ['status'] = "fail";
            $arrResponseData ['message'] = $strMessage;
        }
        echo json_encode($arrResponseData);
        exit;
    }
    
    public function offerscommissions() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('CpaoffersCommissions');
        $this->CpaoffersCommissions->recursive = 0;
        $this->Paginator->settings = array(
            'CpaoffersCommissions' => array(
                'limit' => 20,
            )
        );
        $arrCpaOfferCommissionsList = $this->Paginator->paginate('CpaoffersCommissions');
        
        foreach ($arrCpaOfferCommissionsList as $k=>$offers){
            
            $intOfferId = $offers['cpa_offers_commissions']['offer_id'];
            $intPortalOwnerId = $offers['cpa_offers_commissions']['portal_owner_id'];
            $this->loadModel('Cpaoffers');
            $arrCpaOfferCommissionsList[$k]['offers'] = $this->Cpaoffers->find('all',array('conditions'=>array('pf_offer_id'=>$intOfferId)));
            
            $this->loadModel('Portal');
            $arrCpaOfferCommissionsList[$k]['portal'] = $this->Portal->find('all',array('conditions'=>array('career_portal_provider_id'=>$intPortalOwnerId)));
        }
        
        $this->set('arrCpaOfferList', $arrCpaOfferCommissionsList);
    }
    
    public function offers() {
        $this->autoRender = false;
        $this->layout = NULL;
//        http://www.rothrsolutions.com/happycandidate/managecpaoffers/offers?offerId=%offer%&portal=%subid1%&commission=%commission%
//        http://www.rothrsolutions.com/happycandidate/managecpaoffers/offers?offerId=29457&portal=monster%&commission=1000
        
        if ($_GET['offerId'] !='' && $_GET['commission'] !='') {
            $intOfferId = $_GET['offerId'];
            $portalName = $_GET['portal'];
            
            $this->loadModel('Portal');
            $arrPortalOwnerDetails = $this->Portal->find('all',array('fields'=>array('career_portal_provider_id'),'conditions'=>array('career_portal_name'=>$portalName)));
            
            $this->loadModel('Cpaoffers');
            $arrOffers = $this->Cpaoffers->find('all',array('fields'=>array('hc_cost','portal_cost'),'conditions'=>array('pf_offer_id'=>$intOfferId)));
            
            $hc_commission = (($_GET['commission']) * ($arrOffers[0]['Cpaoffers']['hc_cost']) / 100);
            $portal_cost = (($_GET['commission']) * ($arrOffers[0]['Cpaoffers']['portal_cost']) / 100);

            $arrOffersData = array();
            $arrOffersData['offer_id'] = $_GET['offerId'];
            $arrOffersData['portal_owner_id'] = $arrPortalOwnerDetails[0]['Portal']['career_portal_provider_id'];
            $arrOffersData['total_amount'] = $_GET['commission'];
            $arrOffersData['hc_cost'] = $hc_commission;
            $arrOffersData['portal_cost'] = $portal_cost;
            
            if(count($arrOffers) > 0){
                $compOffers = $this->Components->load('CpaOffers');
                $arrResult = $compOffers->fnAddOffersCommission($arrOffersData);
            }
            
            $arrOffersData['offer_date'] = date('Y-m-d h:i:s');
            $strJsonString = json_encode($arrOffersData);
            $fh = fopen("offersdetails.json", "a");
            fwrite($fh, $strJsonString);
            fclose($fh);
            exit;

            $this->redirect(array("controller" => "managecpaoffers","action" => "offerscommissions",));
        }
    }

    public function changeOfferStatus($intOfferId)
    {
            $arrResponse = array();
            if($intOfferId)
            {
                    $this->loadModel('Cpaoffers');
                    $arrCorrectOffersId = $this->Cpaoffers->find('all',array('conditions'=>array('offer_id'=>$intOfferId)));
                    if(is_array($arrCorrectOffersId) && (count($arrCorrectOffersId)>0))
                    {
                            $strCurrentStatus = $arrCorrectOffersId[0]['Cpaoffers']['offer_status'];
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

                            $isUpdated = $this->Cpaoffers->updateAll(
                                    array('offer_status'=>"'".$strNewStatus."'"),
                                    array('offer_id =' => $intOfferId)
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
    
    public function offercomissiondelete($intOfferCommissionId) {
        $arrResponseData = array();
        if ($intOfferCommissionId) {
            $this->loadModel('CpaoffersCommissions');
            $isOfferDetailPresent = $this->CpaoffersCommissions->find('count', array('conditions' => array('offer_commission_id' => $intOfferCommissionId)));
            if ($isOfferDetailPresent) {
                $intOfferDeleted = $this->CpaoffersCommissions->deleteAll(array('offer_commission_id' => $intOfferCommissionId), false);
                if ($intOfferDeleted) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Offer comission deleted Successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again, Please', 'warning');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Location Missing, Please', 'error');
            $arrResponseData ['status'] = "fail";
            $arrResponseData ['message'] = $strMessage;
        }
        echo json_encode($arrResponseData);
        exit;
    }
        
    public function editcomissionAction() {
        $this->autoRender = false;
        if ($this->request->is('Post')) {

            $arrOffersData = array();
            
            $arrOffersData['offer_commission_id'] = htmlspecialchars(addslashes($this->request->data['offer_comission_id']));
            $arrOffersData['hc_cost'] = htmlspecialchars(addslashes($this->request->data['hc_cost']));
            $arrOffersData['portal_cost'] = htmlspecialchars(addslashes($this->request->data['portal_cost']));

            $compOffers = $this->Components->load('CpaOffers');
            $arrResult = $compOffers->fnUpdateOffersComission($arrOffersData);

            $arrResponse = array();

            if ($arrResult) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Offer Comission Successfully Updated.', 'success');
                $arrResponse['status'] = "success";
                $arrResponse['message'] = $strMessage;
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There is some error, please try again', 'error');
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

}
