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
class ResourcesController extends AppController {
    public $components = array('Paginator');
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Resources';

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'registration', 'reset', 'jobsearch', 'forgotpassword', 'jobdetail', 'captcha', 'termsandprivacy','detail','checkout','addtocart');
    }

    public function index($intPortalId = "") {
//        Configure::write('debug',2);
//        echo $this->layout;die;
        $arrLoggedUser = $this->Auth->user();
        if ($arrLoggedUser['candidate_is_active'] == "0") {
            $this->Session->setFlash('Your account has been inactivated');
            $this->Auth->logout();
            $this->redirect(Router::url(array("controller" => "portal", "action" => "index", $intPortalId), true));
        }
        
        $this->loadModel('Categories');
        $productCategoryTop = $this->Categories->fnGetProductCat();

        $this->loadModel('Portal');
        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_id' => $intPortalId),
            
        ));

        $this->set('arrPortalDetail', "");
        $this->set('arrPortalPageDetail', "");
        $this->set('strPortalNotFoundMessage', "");
        $this->set("strKeywords", "");
        $this->set("strlocation", "");

        if ($intPortalExists) {
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $arrPortalDetail['0']['Portal']['career_portal_id']);

            $arrLoggedUser = $this->Auth->user();

            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            $this->set('arrPortalMenuDetail', $arrMenuDetail);

            $this->loadModel('Vendorservicefront');
            $this->Vendorservicefront->recursive = 0;
            $this->Paginator->settings = array(
                'conditions' => array('product_publish_status' => '1', 'status' => 'Active'),
                'limit' => 200
            );

            $arrResourcesDetail = $this->Paginator->paginate('Vendorservicefront');
            
            if (is_array($arrResourcesDetail) && (count($arrResourcesDetail) > 0)) {
                $this->loadModel('ResourcesImages');
                $this->loadModel('Vendors');
                $intProductCount = 0;
                foreach ($arrResourcesDetail as $arrResource) {
                    $intProductServiceType = $arrResource['Vendorservice']['vendor_service_type'];
                    $intProductVendorId = $arrResource['Vendorservice']['vendor_id'];
                    if ($intProductServiceType == "Product") {
                        if ($intProductVendorId == $intPortalId) {
                            $arrVendorDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResource['Vendorservice']['vendor_id'])));
                            $arrResourcesDetail[$intProductCount]['Vendor'] = $arrVendorDetail[0]['Vendors'];
                            $arrResourceImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $arrResource['Resources']['productd_id'])));
                            if (is_array($arrResourceImages) && (count($arrResourceImages) > 0)) {
                                $arrResourcesDetail[$intProductCount]['Resources']['images'] = $arrResourceImages;
                            }
                            $intProductCount++;
                        } else {
                            continue;
                        }
                    } else {
                        $arrVendorDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResource['Vendorservice']['vendor_id'])));
                        $arrResourcesDetail[$intProductCount]['Vendor'] = $arrVendorDetail[0]['Vendors'];
                        $arrResourceImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $arrResource['Resources']['productd_id'])));
                        if (is_array($arrResourceImages) && (count($arrResourceImages) > 0)) {
                            $arrResourcesDetail[$intProductCount]['Resources']['images'] = $arrResourceImages;
                        }
                        $intProductCount++;
                    }
                }
            }
           
            $arrProductsByCatId = array();
            foreach($productCategoryTop as $catMenu){
                $this->loadModel('CategoriesAssignment');
                $catId = $catMenu['content_category']['content_category_id'];
                    $this->loadModel('Vendorservicefront');
                    $this->Vendorservicefront->recursive = 0;
                    $this->Paginator->settings = array(
                    'conditions' => array('product_publish_status' => '1', 'status' => 'Active','category_id'=>$catId),
                    'limit' => 500
                    );

                $arrProductsByCatId[$catId] = $this->Paginator->paginate('Vendorservicefront');
            }
//            echo '<pre>';print_r($arrProductsByCatId);die;
            $this->set('arrResourcesDetail', $arrResourcesDetail);
            $this->set('productCategoryTop', $productCategoryTop);
            $this->set('arrProductsByCatId', $arrProductsByCatId);
        } else {
            $this->set('strPortalNotFoundMessage', "URL Broken");
        }
    }
    
    public function sortresourceslist($intPortalId = "") {
        $this->loadModel('Categories');
        $productCategoryTop = $this->Categories->fnGetProductCat();
        $this->set('productCategoryTop', $productCategoryTop);
        $catId = $_GET['CatId'];
        $arrLoggedUser = $this->Auth->user();
        if ($arrLoggedUser['candidate_is_active'] == "0") {
            $this->Session->setFlash('Your account has been inactivated');
            $this->Auth->logout();
            $this->redirect(Router::url(array("controller" => "portal", "action" => "index", $intPortalId), true));
        }
        $this->loadModel('Portal');
        $intPortalExists = $this->Portal->find('count', array(
            'conditions' => array('career_portal_id' => $intPortalId)
        ));

        $this->set('arrPortalDetail', "");
        $this->set('arrPortalPageDetail', "");
        $this->set('strPortalNotFoundMessage', "");
        $this->set("strKeywords", "");
        $this->set("strlocation", "");

        if ($intPortalExists) {
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $arrPortalDetail['0']['Portal']['career_portal_id']);

            $arrLoggedUser = $this->Auth->user();

            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            $this->set('arrPortalMenuDetail', $arrMenuDetail);

//            $this->loadModel("Vendorservice");
//            $arrResourcesDetail = $this->Vendorservice->fnGetPublishedResourcesList('', $catId);
            
            $this->loadModel('Vendorservicefront');
            $this->Vendorservicefront->recursive = 0;
            $this->Paginator->settings = array(
            'conditions' => array('product_publish_status' => '1', 'status' => 'Active','category_id'=>$catId),
            'limit' => 20
            );

            $arrResourcesDetail = $this->Paginator->paginate('Vendorservicefront');
            if (is_array($arrResourcesDetail) && (count($arrResourcesDetail) > 0)) {
                $this->loadModel('ResourcesImages');
                $this->loadModel('Vendors');
                $intProductCount = 0;
                foreach ($arrResourcesDetail as $arrResource) {
                    $intProductServiceType = $arrResource['Vendorservice']['vendor_service_type'];
                    $intProductVendorId = $arrResource['Vendorservice']['vendor_id'];
                    if ($intProductServiceType == "Product") {
                        if ($intProductVendorId == $intPortalId) {
                            $arrVendorDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResource['Vendorservice']['vendor_id'])));
                            $arrResourcesDetail[$intProductCount]['Vendor'] = $arrVendorDetail[0]['Vendors'];
                            $arrResourceImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $arrResource['Resources']['productd_id'])));
                            if (is_array($arrResourceImages) && (count($arrResourceImages) > 0)) {
                                $arrResourcesDetail[$intProductCount]['Resources']['images'] = $arrResourceImages;
                            }
                            $intProductCount++;
                        } else {
                            continue;
                        }
                    } else {
                        $arrVendorDetail = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResource['Vendorservice']['vendor_id'])));
                        $arrResourcesDetail[$intProductCount]['Vendor'] = $arrVendorDetail[0]['Vendors'];
                        $arrResourceImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $arrResource['Resources']['productd_id'])));
                        if (is_array($arrResourceImages) && (count($arrResourceImages) > 0)) {
                            $arrResourcesDetail[$intProductCount]['Resources']['images'] = $arrResourceImages;
                        }
                        $intProductCount++;
                    }
                }
            }
            $this->set('arrResourcesDetail', $arrResourcesDetail);
        } else {
            $this->set('strPortalNotFoundMessage', "URL Broken");
        }
    }

    public function termsandprivacy() {
        $this->layout = NULL;
    }

    public function jobsearch($intPortalId = "") {
        if ($intPortalId) {
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);
            $this->set('strPortalNotFoundMessage', "");

            $arrSearchPostedValues = array();
            $this->set("strKeywords", "");
            $this->set("strlocation", "");
            $this->set("strCategory", "");



            if ($this->request->is('post')) {
                /* print("<pre>");
                  print_r($this->request->data);
                  exit */
                $arrSearchString = array();
                $arrSearchPostedValues['keywords'] = $strKeywords = addslashes(trim($this->request->data['keywords']));
                $arrSearchPostedValues['location'] = $strLocation = addslashes(trim($this->request->data['location']));
                $arrSearchPostedValues['country'] = $strLocation = addslashes(trim($this->request->data['txt_country']));
                $arrSearchPostedValues['category'] = $strCategory = $this->request->data['category'];
                $arrSearchPostedValues['experience'] = $strExperience = $this->request->data['experience'];
                $arrSearchPostedValues['jobtype'] = $strJobType = $this->request->data['job_type'];
                $arrSearchPostedValues['searchtype'] = $strJobType = $this->request->data['search_type'];
                $isAdvanceSearch = $this->request->data['adv_search'];


                if ($arrSearchPostedValues['keywords']) {
                    $arrSearchString[] = "q=" . urlencode($arrSearchPostedValues['keywords']);
                }

                if ($arrSearchPostedValues['location']) {
                    $arrSearchString[] = "location=" . urlencode($arrSearchPostedValues['location']);
                }

                if ($arrSearchPostedValues['country']) {
                    $arrSearchString[] = "txt_country=" . urlencode($arrSearchPostedValues['country']);
                }

                /* print("<pre>");
                  print_r($arrSearchPostedValues);
                  exit; */
                if (is_array($arrSearchPostedValues['category']) && (count($arrSearchPostedValues['category']) > 0)) {
                    foreach ($arrSearchPostedValues['category'] as $arrCat) {
                        if ($arrCat == "0") {
                            continue;
                        } else {
                            $arrSearchString[] = "category[]=" . urlencode($arrCat);
                        }
                    }
                } else {
                    if ($arrSearchPostedValues['category']) {
                        $arrSearchString[] = "category[]=" . urlencode($arrSearchPostedValues['category']);
                    }
                }

                if ($arrSearchPostedValues['experience']) {
                    $arrSearchString[] = "experience=" . urlencode($arrSearchPostedValues['experience']);
                }

                if ($arrSearchPostedValues['jobtype']) {
                    $arrSearchString[] = "job_type=" . urlencode($arrSearchPostedValues['jobtype']);
                }

                if ($arrSearchPostedValues['searchtype']) {
                    $arrSearchString[] = "search_type=" . urlencode($arrSearchPostedValues['searchtype']);
                }

                $arrSearchString[] = "portid=" . $intPortalId;
                $strSearchQueryString = implode("&", $arrSearchString);

                $strSearchQueryString = Configure::read('Jobber.seekerjobsearchurl') . "?" . $strSearchQueryString;

                //echo "--".$strSearchQueryString;
                $this->set("strJobSearchUrl", $strSearchQueryString);

                $this->set("strKeywords", $arrSearchPostedValues['keywords']);
                $this->set("strlocation", $arrSearchPostedValues['location']);
                $this->set("strCategory", $arrSearchPostedValues['category']);
                $this->set("strSearchMode", "Basic");
                if ($isAdvanceSearch) {
                    $this->set("strSearchMode", "Advance");
                }
            }
        }
    }

    public function fnAddCartGetMarkup($intPortalId = "") {
        $arrLoggedUser = $this->Auth->user();
        if (is_array($_SESSION['cartproducts_' . $intPortalId]) && (count($_SESSION['cartproducts_' . $intPortalId]) > 0)) {
            $arrProducts = $_SESSION['cartproducts_' . $intPortalId];
        } else {
            $this->loadModel('Resourcecart');
            $arrCartResources = $this->Resourcecart->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id']), 'order' => array('cart_creation_date DESC')));
            if (is_array($arrCartResources) && (count($arrCartResources) > 0)) {
                //$_SESSION['cartproducts_'.$intPortalId] = $arrCartResources;
                $arrProducts = $arrCartResources;
            }
        }
        if (is_array($arrProducts) && (count($arrProducts) > 0)) {
            $intTotalDefault = "0.00";
            $strCartProductStrngs = "<div class='cart-datas'><div class='cart-list-container'><table>
							<tr>
								<th>Action</th>
								<th>Name</th>
								<th>Unit Price</th>
								<th>Quantity</th>
								<th>Amount</th>
							</tr>
							";
            $intForCnt = 0;
            foreach ($arrProducts as $arrProduct) {
                $strCartProductStrngs .= "<tr id='" . $arrProduct['Resourcecart']['product_id'] . "_" . $arrProduct['Resourcecart']['cart_instance_id'] . "'><td><a href='javascript:void(0);' id='remove_" . $arrProduct['Resourcecart']['product_id'] . "_" . $arrProduct['Resourcecart']['cart_instance_id'] . "_" . $intPortalId . "' onclick='fnRemoveItem(this)' title='Remove'><img src='" . Router::url('/', true) . "/images/icon-delete-notification.png' alt='' /></a></td><td class='cart-item-description'>" . $arrProduct['Resourcecart']['product_name'] . "</td><td class='cart-item-price'>" . "$" .$arrProduct['Resourcecart']['product_cost'] . "</td><td>1</td><td>" . ("$".$arrProduct['Resourcecart']['product_cost']) . "</td></tr>";
                $intTotal += (($intTotalDefault) + ($arrProduct['Resourcecart']['product_cost']));
                $intForCnt++;
            }
            $strCartProductStrngs .= "</table></div>";
            $strCartProductStrngs .= "<div class='cart-list-options-container'>
						<!--<div class='cart-list-options'>
							<span>Discount:</span>
							<a href='#' class='link-primary'>Apply coupon</a>
						</div>-->
						<div class='cart-list-total'>
							<p>Total: <span> USD $" . number_format($intTotal,2). "</span></p>
                                                        <p style='font-size: 14px !important; margin-right: 193px;width:100%'>(Price listed in U.S. currency)</p>
						</div>
					</div>
					</div>";
            $strCartProductStrngs .= "<div class='cart-item-button-container'>
						<button type='button' id='checkout_" . $intPortalId . "' class='btn btn-primary btn-form' onclick='fnCheckOut(this);'>Checkout <span class='glyphicon glyphicon-chevron-right'></span></button>
				</div>";
            $strCartProductStrngs .= "";

            if ($strCartProductStrngs) {
                return $strCartProductStrngs;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function showcart($intPortalId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();

        if ($intPortalId) {
            $strProductString = $this->fnAddCartGetMarkup($intPortalId);
            if ($strProductString) {
                $arrResponse['status'] = "success";
                $arrResponse['carthtml'] = $strProductString;
            } else {
                $arrResponse['status'] = "fail";
            }
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function removefromcart($intPortalId = "", $intContactId = "", $intProductRowId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intPortalId) {
            if ($intContactId) {
                $this->loadModel('Resourcecart');
                $intExistCount = $this->Resourcecart->find('count', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id'], 'cart_instance_id' => $intProductRowId, 'product_id' => $intContactId)));
                if ($intExistCount) {
                    $this->Resourcecart->deleteAll(array('seeker_id' => $arrLoggedUser['candidate_id'], 'cart_instance_id' => $intProductRowId, 'product_id' => $intContactId), false);
                }
                $arrResponse['status'] = "success";
                $strProductString = $this->fnAddCartGetMarkup($intPortalId);
                if ($strProductString) {
                    $arrResponse['carthtml'] = $strProductString;
                } else {
                    $arrResponse['carthtml'] = "";
                }
            } else {
                $arrResponse['status'] = "fail";
            }
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function addtocart($intPortalId = "", $intContactId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intPortalId) {
            if ($intContactId) {
                $this->loadModel('Vendorservice');
                $arrResourceDetail = $this->Vendorservice->find('all', array('conditions' => array('vendor_service_id' => $intContactId)));

                if (is_array($arrResourceDetail) && (count($arrResourceDetail) > 0)) {
                    $this->loadModel('Resources');
                    $arrResourceDetai = $this->Resources->find('all', array('conditions' => array('productd_id' => $arrResourceDetail[0]['Vendorservice']['service_id'], 'product_publish_status' => '1')));
                    $arrResourceDetail[0]['Resources'] = $arrResourceDetai[0]['Resources'];

                    $this->loadModel('Vendors');
                    $arrVendorDetai = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResourceDetail[0]['Vendorservice']['vendor_id'])));

                    $arrResourceCart = array();
                    $arrResourceCart['Resourcecart']['product_name'] = $arrProducts['Resourcecart']['product_name'] = $arrResourceDetail[0]['Resources']['product_name'];
                    $arrResourceCart['Resourcecart']['product_id'] = $arrProducts['Resourcecart']['product_id'] = $arrResourceDetail[0]['Resources']['productd_id'];
                    if($arrResourceDetail[0]['Resources']['discount_cost'] == '' && $arrResourceDetail[0]['Resources']['discount_cost'] == '0.00'){
                        $arrResourceCart['Resourcecart']['product_cost'] = $arrProducts['Resourcecart']['product_cost'] = $arrResourceDetail[0]['Resources']['product_cost'];
                    }else{
                        $arrResourceCart['Resourcecart']['product_cost'] = $arrProducts['Resourcecart']['discount_cost'] = $arrResourceDetail[0]['Resources']['discount_cost'];
                    }
                    $arrResourceCart['Resourcecart']['product_qty'] = '1';
                    $arrResourceCart['Resourcecart']['seeker_id'] = $arrLoggedUser['candidate_id'];
                    $arrResourceCart['Resourcecart']['vendor_service_id'] = $arrResourceDetail[0]['Vendorservice']['vendor_service_id'];
                    $arrResourceCart['Resourcecart']['vendor_name'] = $arrVendorDetai[0]['Vendors']['vendor_name'];
                    $this->loadModel('Resourcecart');
                    //print("<pre>");
                    //print_r($arrResourceCart);
                    $this->Resourcecart->save($arrResourceCart);
                    //$_SESSION['cartproducts_'.$intPortalId][] = $arrProducts;
                    $strProductString = $this->fnAddCartGetMarkup($intPortalId);
                    if ($strProductString) {
                        $arrResponse['status'] = "success";
                        $arrResponse['carthtml'] = $strProductString;
                        $arrResponse['message'] = "<div class='alert alert-success'>
						  <img alt='image description' src='" . Router::url('/', true) . "images/icon-alert-success.png'>
						  <a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a>
						  Product was successfully added to cart.
						</div>";
                    } else {
                        $arrResponse['status'] = "fail";
                    }
                } else {
                    $arrResponse['status'] = "fail";
                }
            } else {
                $arrResponse['status'] = "fail";
            }
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function removefromorder($intPortalId = "", $intOrderDetailId = "", $intOrderId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intPortalId) {
            if ($intOrderDetailId) {
                $this->loadModel('Resourceorderdetail');
                $intDeleted = $this->Resourceorderdetail->deleteAll(array('order_detail_id' => $intOrderDetailId), false);
                if ($intDeleted) {
                    $arrResponse['status'] = 'success';
                    $this->loadModel('Resourceorder');
                    $arrContentDetail = $this->Resourceorder->find('all', array('conditions' => array('resource_order_id' => $intOrderId, 'order_status' => 'initiated')));
                    if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {
                        $arrRContentDetail = $this->Resourceorderdetail->fnGetOrderDetail($intOrderId);
                        if (is_array($arrRContentDetail) && (count($arrRContentDetail) > 0)) {
                            $intFrCnt = 0;
                            foreach ($arrContentDetail as $arrOrder) {
                                $arrRContentDetail = $this->Resourceorderdetail->fnGetOrderDetail($arrOrder['Resourceorder']['resource_order_id']);
                                $arrContentDetail[$intFrCnt]['order_detail'] = $arrRContentDetail;
                                $intFrCnt++;
                            }
                            $view = new View($this, false);
                            $view->set('arrContentDetail', $arrContentDetail);
                            $strWidgetListerHtml = $view->element('show_order');
                            $arrResponse['orderhtml'] = $strWidgetListerHtml;
                        } else {
                            $arrResponse['orderhtml'] = '';
                        }
                    } else {
                        $arrResponse['orderhtml'] = '';
                    }
                } else {
                    $arrResponse['status'] = 'fail';
                }
            } else {
                $arrResponse['status'] = 'fail';
            }
        } else {
            $arrResponse['status'] = 'fail';
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function confirmorders($intPortalId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intPortalId) {
            if ($this->request->is('Post')) {
                $this->loadModel('Portal');
                $arrPortalDetail = $this->Portal->find('all', array(
                    'conditions' => array('career_portal_id' => $intPortalId)
                ));
                $order_id = $this->request->data['order_id'];

                $this->loadModel('Resourceorderdetail');
                $this->loadModel('Email');
                $emailContent = $this->Email->find('first', array(
                    'conditions' => array('Email.template_key' => 'forgot')
                ));
                $this->loadModel('Resources');
                $this->loadModel('Vendorcandidateacc');
                $resourceDetails = $this->Resources->find('all', array(
                    'fields' => array('Resources.product_type'),
                    'joins' => array(
                        array(
                            'table' => 'resource_order_detail',
                            'alias' => 'Resourceorderdetail',
                            'type' => 'inner',
                            'recursive' => -1,
                            'conditions' => array('Resources.productd_id = Resourceorderdetail.product_id')
                        )), 'conditions' => array('Resourceorderdetail.order_id' => $order_id)));
                $registerinterview = 0;
                $registerSkillSoft = 0;
                if (count($resourceDetails) > 0) {
                    foreach ($resourceDetails as $resource) {
                        $productype = $resource['Resources']['product_type'];

                        if ($productype == "Course") {
                            $registerinterview = 1;
                            $dbvendor_id = $resource['Resources']['vendor_id'];
                        }
                    }
                } else {
                    $registerinterview = 0;
                    $registerSkillSoft = 0;
                }
                
//                echo '<pre>';print_r($resourceDetails); 
//                echo '<pre>';print_r($dbvendor_id);exit(); 
                
                
                
                $arrVendorAccountUser = $this->Vendorcandidateacc->find('all', array('conditions' => array('candidate_id' => $arrLoggedUser['candidate_id'], 'vendor_id' => $dbvendor_id, 'account_id !=' => NULL)));

                $arrTransactionInformation = array();
                $arrTransactionInformation['custoner_fname'] = $this->request->data['cust_fname'];
                $arrTransactionInformation['custoner_lname'] = $this->request->data['cust_lname'];
                $arrTransactionInformation['custoner_add'] = $this->request->data['cust_address'];
                $arrTransactionInformation['customer_postal_code'] = $this->request->data['post_code'];
                $arrTransactionInformation['customer_country'] = $this->request->data['txt_country'];
                $arrTransactionInformation['customer_state_province'] = $this->request->data['txtstateprovince'];
                $arrTransactionInformation['customer_city_county'] = $this->request->data['txtcounty'];
                $arrTransactionInformation['customer_email'] = $arrLoggedUser['candidate_email'];
                $arrTransactionInformation['orderid'] = $this->request->data['order_id'];
                $arrTransactionInformation['orderamount'] = $this->request->data['total_amount'];
                $arrTransactionInformation['cardtype'] = $this->request->data['card_type'];
                $arrTransactionInformation['cardnum'] = $this->request->data['card_number'];
                $arrTransactionInformation['exp_month'] = $this->request->data['exp_month'];
                $arrTransactionInformation['exp_year'] = $this->request->data['exp_year'];
                $arrTransactionInformation['cardsecurity'] = $this->request->data['security_code'];
                $arrTransactionInformation['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
                $arrTransactionInformation['portalid'] = $intPortalId;
                
                $this->loadModel('Vendors');
                $arrVendorAccount = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $this->request->data['vendor_id'])));
                
                $comAuthPaymentgateway = $this->Components->load('Authorize');
                $arrResponse = $comAuthPaymentgateway->fnSubmitCheckoutTransaction($arrTransactionInformation,$arrVendorAccount);
                
                if ($arrResponse) {
                    
                    if ($registerinterview > 0) {
                        if (is_array($arrVendorAccountUser) && (count($arrVendorAccountUser) > 0)) {
                            $linkacess = "https://www.interviewbest.com/login?user=" . $arrVendorAccountUser[0]['Vendorcandidateacc']['candidate_vendor_account_uname'] . "&pass=" . $arrVendorAccountUser[0]['Vendorcandidateacc']['candidate_vendor_account_pass'];
                            $this->Resourceorderdetail->updateAll(array('Resourceorderdetail.accessLink' => "'" . $linkacess . "'"), array('Resourceorderdetail.order_id' => $order_id));
                            $this->set('strVendServiceUrl', "https://www.interviewbest.com/login?user=" . $arrVendorAccountUser[0]['Vendorcandidateacc']['candidate_vendor_account_uname'] . "&pass=" . $arrVendorAccountUser[0]['Vendorcandidateacc']['candidate_vendor_account_pass']);
                        } else {
                            $arrVendorCandidateRegDetails = array();
                            $arrVendorCandidateRegDetails['fname'] = $this->request->data['cust_fname'];
                            $arrVendorCandidateRegDetails['lname'] = $this->request->data['cust_lname'];
                            $arrVendorCandidateRegDetails['email'] = $arrLoggedUser['candidate_email'];
                            $arrVendorCandidateRegDetails['password'] = "testuser";

                            $this->compTest = $this->Components->load('Interviewbest');
                            $arrUserDetail = $this->compTest->fnCreateInterviewBestAccount($arrVendorCandidateRegDetails);
                            if (is_array($arrUserDetail) && count($arrUserDetail) > 0) {
                                if ($arrUserDetail['result'] == "success") {
                                    $arrVendorCandidate = array();
                                    $arrVendorCandidate['Vendorcandidateacc']['candidate_id'] = $arrLoggedUser['candidate_id'];
                                    $arrVendorCandidate['Vendorcandidateacc']['vendor_id'] = $dbvendor_id;
                                    $arrVendorCandidate['Vendorcandidateacc']['account_id'] = $arrUserDetail['userid'];
                                    $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_fname'] = $arrVendorCandidateRegDetails['fname'];
                                    $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_lname'] = $arrVendorCandidateRegDetails['lname'];
                                    $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_uname'] = $arrVendorCandidateRegDetails['email'];
                                    $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_pass'] = $arrVendorCandidateRegDetails['password'];

                                    $arrVendorCandidateCreated = $this->Vendorcandidateacc->save($arrVendorCandidate);
                                    if ($arrVendorCandidateCreated) {
                                        $linkacess = "https://www.interviewbest.com/login?user=" . $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_uname'] . "&pass=" . $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_pass'];
                                        $this->Resourceorderdetail->updateAll(array('Resourceorderdetail.accessLink' => "'" . $linkacess . "'"), array('Resourceorderdetail.order_id' => $order_id));
                                        $this->set('strVendServiceUrl', "https://www.interviewbest.com/login?user=" . $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_uname'] . "&pass=" . $arrVendorCandidate['Vendorcandidateacc']['candidate_vendor_account_pass']);
                                    } else {
                                        $arrCandidateRemoved = $this->compTest->fnRemoveInterviewBestAccount($arrUserDetail['userid']);
                                        $this->Session->setFlash('There is some issue, please try agin later');
                                    }
                                } else {
                                    $this->Session->setFlash('There is some issue, please try agin later');
                                }
                            }
                        }
                    }
                    if ($registerSkillSoft > 0) {

                        $arrVendorCandidate = array();
                        $arrVendorCandidate['userName'] = $arrLoggedUser['candidate_email'];
                        $arrVendorCandidate['firstName'] = $this->request->data['cust_fname'];
                        $arrVendorCandidate['lastName'] = $this->request->data['cust_lname'];
                        $arrVendorCandidate['actionType'] = 'catalog';
                        $arrVendorCandidate['assetId'] = '';
                        $arrVendorCandidate['catalogPath'] = '/DIALOGUE/EC/Microsoft_Office_2007:_Beginning_Excel,/DIALOGUE/EC/Microsoft_Office_2007:_Beginning_Word';
                        $compskillSoft = $this->Components->load('SkillSoft');
                        $strVendServiceUrl = $compskillSoft->fnskillsoftRegistration($arrVendorCandidate);

                        $this->set('strVendServiceUrl', $strVendServiceUrl);
                        $this->Resourceorderdetail->updateAll(array('Resourceorderdetail.accessLink' => "'" . $strVendServiceUrl . "'"), array('Resourceorderdetail.order_id =' => $order_id));
                    }
                }
            } else {
                $arrResponse['status'] = 'fail';
            }
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function ordersuccess($intPortalId = "", $intTransactionId = "") {
        
        if ($intPortalId) {
            $arrLoggedUser = $this->Auth->user();

            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);

            $this->loadModel('PortalPages');
            $arrPortalContactUsPageDetail = $this->PortalPages->find('all', array(
                'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'], 'career_portal_page_tittle' => 'Contact Us')
            ));
            $intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
            $this->set('intContactUsPageId', $intContactUsPageDetail);

            $arrCustomerInformation = $this->Auth->user();
            $this->set('arrCustomerInformation', $arrCustomerInformation);

            $this->loadModel('Resourceorder');
            $arrContentDetail = $this->Resourceorder->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id'], 'order_status' => 'initiated')));

            $this->loadModel('Resourceorderdetail');
            if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {

                $intFrCnt = 0;
                foreach ($arrContentDetail as $arrOrder) {
                    $arrRContentDetail = $this->Resourceorderdetail->fnGetOrderDetail($arrOrder['Resourceorder']['resource_order_id']);
                    $arrContentDetail[$intFrCnt]['order_detail'] = $arrRContentDetail;
                    $intFrCnt++;
                }
            }

            $arrTransactionOrderDetail = $this->Resourceorder->find('all', array('conditions' => array('order_transaction_id' => $intTransactionId, 'order_from_portal' => $intPortalId)));
            $this->loadModel('Content');
//            
                    
            if (is_array($arrTransactionOrderDetail) && count($arrTransactionOrderDetail) > 0) {
                $arrRDContentDetail = $this->Resourceorderdetail->fnGetOwnerTotal($arrTransactionOrderDetail[0]['Resourceorder']['resource_order_id'], $intPortalId);
                
                $this->loadModel('Resources');
                $arrproductDetails = $this->Resources->find('all', array('conditions' => array('Resources.productd_id' => $arrRDContentDetail[0]['resource_order_detail']['product_id'])));
                
                if($arrproductDetails[0]['Resources']['product_type'] == 'Product'){
                    $portalownercost = (($arrRDContentDetail[0][0]['total_owner_cost']) + ($arrRDContentDetail[0][0]['total_vendor_cost']));
                }else{
                    $portalownercost = $arrRDContentDetail[0][0]['total_owner_cost'];
                }
                
                $this->set('portalpwnersale', $portalownercost);
            }

            $this->set('addcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'add', $intPortalId), true));
            $this->set('strListcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'index', $intPortalId), true));
            $this->set('arrContentDetail', $arrContentDetail);

        }
    }

    public function orders($intPortalId = "",$intvendorserviceId = "",$vendorId = "") {
        if ($intPortalId) {
            $arrLoggedUser = $this->Auth->user();

            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);

            $this->loadModel('PortalPages');
            $arrPortalContactUsPageDetail = $this->PortalPages->find('all', array(
                'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'], 'career_portal_page_tittle' => 'Contact Us')
            ));
            $intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
            $this->set('intContactUsPageId', $intContactUsPageDetail);

            $arrCustomerInformation = $this->Auth->user();
            $this->set('arrCustomerInformation', $arrCustomerInformation);

            $this->loadModel('Resourceorder');
            $arrContentDetail = $this->Resourceorder->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id'], 'order_status' => 'initiated')));
            
            if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {
                $this->loadModel('Resourceorderdetail');
                $intFrCnt = 0;
                foreach ($arrContentDetail as $arrOrder) {
                    $arrRContentDetail = $this->Resourceorderdetail->fnGetOrderDetail($arrOrder['Resourceorder']['resource_order_id']);
                    $arrContentDetail[$intFrCnt]['order_detail'] = $arrRContentDetail;
                    $intFrCnt++;
                }
            }
            
            $this->loadModel('Content');
            $arrRContentDetails = $this->Content->find('all', array('conditions' => array('resource_id' => $arrContentDetail[0]['order_detail'][0]['resource_order_detail']['product_id'])));
            
            $this->loadModel('JobberlandCounties');
            $countrylist = $this->JobberlandCounties->find('list', array('fields'=>array('code', 'name'),'conditions'=>array('enabled'=>'Y'),'order'=>array('name ASC')));
            
            $arrCartResources = array();
            $this->loadModel('Resourcecart');
            $arrCartResources = $this->Resourcecart->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id']), 'order' => array('cart_creation_date DESC')));
            
            if (is_array($arrCartResources) && (count($arrCartResources) > 0)) {
                $this->loadModel('Resourceorderdetail');
                $intFrCnt1 = 0;
                foreach ($arrCartResources as $arrCartOrder) {
                   
                    $this->loadModel('Content');
                    $arrRContentDetails1 = $this->Content->find('all', array('conditions' => array('resource_id' => $arrCartOrder['Resourcecart']['product_id'])));
                     
                    $this->loadModel('Resourceorder');
                    $arrContentDetail1 = $this->Resourceorder->find('all', array('conditions' => array('seeker_id' => $arrCartOrder['Resourcecart']['seeker_id'], 'order_status' => 'initiated')));
                    
                    $this->loadModel('Resources');
                    $resourcesDetails = $this->Resources->find('all', array('conditions'=>array('productd_id'=>$arrCartOrder['Resourcecart']['product_id'])));
                    
                    $arrCartResources[$intFrCnt1]['content'] = $arrRContentDetails1;
                    $arrCartResources[$intFrCnt1]['Resourceorder'] = $arrContentDetail1;
                    $arrCartResources[$intFrCnt1]['Product'] = $resourcesDetails;
                    $intFrCnt1++;
                }
            }
            
//            echo '<pre>ss';print_r($arrCartResources);die;
            $this->set('addcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'add', $intPortalId), true));
            $this->set('strListcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'index', $intPortalId), true));
            $this->set('arrContentDetail', $arrContentDetail);
            $this->set('arrRContentDetails', $arrRContentDetails);
            $this->set('vendorId', $vendorId);
            $this->set('countrylist',$countrylist);
            $this->set('intvendorserviceId',$intvendorserviceId);
            $this->set('arrCartResources',$arrCartResources);
        }
    }

    public function checkout($intPortalId = "", $strProductId = "", $intVendorId = "") {
        $this->layout = NULL;
        $this->autoRender = false;
        $arrResponse = array();
        $arrLoggedUser = $this->Auth->user();
        if ($intPortalId) {
            if ($strProductId) {
                $this->loadModel('Vendorservice');
                $arrResource = $this->Vendorservice->find('all', array('conditions' => array('vendor_service_id' => $strProductId)));
                
                if (is_array($arrResource) && (count($arrResource) > 0)) {
                    $this->loadModel('Resources');
                    $this->loadModel('Portal');
                    $intVendorType = "Vendor";

                    $strVendorServiceType = $arrResource[0]['Vendorservice']['vendor_service_type'];

                    $arrResourc = $this->Resources->find('all', array('conditions' => array('productd_id' => $arrResource[0]['Vendorservice']['service_id'])));
                    $arrResource[0]['Resources'] = $arrResourc[0]['Resources'];

                    if ($strVendorServiceType == "Product") {
                        $arrResourcVend = $this->Portal->find('all', array('conditions' => array('career_portal_id' => $arrResource[0]['Vendorservice']['vendor_id'])));
                        $arrResourcVend[0]['Vendors']['vendor_name'] = $arrResourcVend[0]['Portal']['career_portal_name'];
                        $intVendorType = "Portal Owner";
                    } else {
                        $this->loadModel('Vendors');
                        $arrResourcVend = $this->Vendors->find('all', array('conditions' => array('vendor_id' => $arrResource[0]['Vendorservice']['vendor_id'])));
                    }
                   
                    $arrResourceOrder = array();
                    if($arrResource[0]['Resources']['discount_cost'] !='' && $arrResource[0]['Resources']['discount_cost'] !='0.00'){
                       $arrResourceOrder['Resourceorder']['order_amount'] = $arrResource[0]['Resources']['discount_cost']; 
                    }else{
                        $arrResourceOrder['Resourceorder']['order_amount'] = $arrResource[0]['Resources']['product_cost'];
                    }
                    
                    $arrResourceOrder['Resourceorder']['order_name'] = "OD00" . time();
                    $arrResourceOrder['Resourceorder']['order_payment_required'] = "1";
                    $arrResourceOrder['Resourceorder']['order_payment_status'] = "incomplete";
                    $arrResourceOrder['Resourceorder']['order_status'] = "initiated";
                    $arrResourceOrder['Resourceorder']['seeker_id'] = $arrLoggedUser['candidate_id'];
                    
                    
                    $this->loadModel('Resourceorder');
                    $this->Resourceorder->deleteAll(array('seeker_id' => $arrLoggedUser['candidate_id'], 'order_status' => 'initiated'), false);
                    $isSave = $this->Resourceorder->save($arrResourceOrder);
                    if ($isSave) {
                        $intOrderId = $this->Resourceorder->getLastInsertID();
                        $this->loadModel('Resourceorderdetail');
                        $arrResourceOrderDetail['Resourceorderdetail']['product_id'] = $arrResource[0]['Resources']['productd_id'];
                        $arrResourceOrderDetail['Resourceorderdetail']['seeker_id'] = $arrLoggedUser['candidate_id'];
                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_id'] = $arrResource[0]['Vendorservice']['vendor_id'];
                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_cost'] = $arrResource[0]['Vendorservice']['vendor_cost'];
                        if ($arrResource[0]['Vendorservice']['merchant_cost_type'] == "per") {
                            $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost'] = (($arrResource[0]['Vendorservice']['service_cost'] * $arrResource[0]['Vendorservice']['merchant_cost']) / 100);
                        } else {
                            $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost'] = $arrResource[0]['Vendorservice']['merchant_cost'];
                        }
                        $arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] = ($arrResource[0]['Resources']['product_cost'] - ($arrResourceOrderDetail['Resourceorderdetail']['vendor_cost'] + $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost']));
                        if ($arrResource[0]['Vendorservice']['hc_cost_type'] == "per") {
                            $arrResourceOrderDetail['Resourceorderdetail']['hc_profit_cost'] = (($arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] * $arrResource[0]['Vendorservice']['hc_cost']) / 100);
                        } else {
                            $arrResourceOrderDetail['Resourceorderdetail']['hc_profit_cost'] = $arrResource[0]['Vendorservice']['hc_cost'];
                        }

                        if ($arrResource[0]['Vendorservice']['portal_cost_type'] == "per") {
                            $arrResourceOrderDetail['Resourceorderdetail']['portal_owner_cost'] = (($arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] * $arrResource[0]['Vendorservice']['portal_cost']) / 100);
                        } else {
                            $arrResourceOrderDetail['Resourceorderdetail']['portal_owner_cost'] = $arrResource[0]['Vendorservice']['portal_cost'];
                        }

                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_payment_status'] = 'pending';
                        $arrResourceOrderDetail['Resourceorderdetail']['hc_payment_status'] = 'pending';
                        $arrResourceOrderDetail['Resourceorderdetail']['portal_payment_status'] = 'pending';
                        $arrResourceOrderDetail['Resourceorderdetail']['merchant_payment_status'] = 'pending';

                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_service_id'] = $arrResource[0]['Vendorservice']['vendor_service_id'];
                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_name'] = $arrResourcVend[0]['Vendors']['vendor_name'];
                        $arrResourceOrderDetail['Resourceorderdetail']['product_name'] = $arrResource[0]['Resources']['product_name'];
                        if($arrResource[0]['Resources']['discount_cost'] !='' && $arrResource[0]['Resources']['discount_cost'] !='0.00'){
                           $arrResourceOrderDetail['Resourceorderdetail']['product_unit_cost'] = $arrResource[0]['Resources']['discount_cost']; 
                        }else{
                           $arrResourceOrderDetail['Resourceorderdetail']['product_unit_cost'] = $arrResource[0]['Resources']['product_cost']; 
                        }
                        
                        $arrResourceOrderDetail['Resourceorderdetail']['product_qty'] = "1";
                        $arrResourceOrderDetail['Resourceorderdetail']['order_id'] = $intOrderId;
                        $arrResourceOrderDetail['Resourceorderdetail']['payment_status'] = "incomplete";
                        $arrResourceOrderDetail['Resourceorderdetail']['order_detail_status'] = "initiated";
                        $arrResourceOrderDetail['Resourceorderdetail']['vendor_type'] = $intVendorType;
                        $this->Resourceorderdetail->save($arrResourceOrderDetail);

                        $this->loadModel('Subvendororders');
                        $arrVendorUserOrderDetial['Subvendororders']['order_id'] = $intOrderId;
                        $arrVendorUserOrderDetial['Subvendororders']['vendor_id'] = $arrResource[0]['Vendorservice']['vendor_id'];
                        $this->Subvendororders->create(false);
                        $details = $this->Subvendororders->save($arrVendorUserOrderDetial);
                        $arrResponse['status'] = "success";
                    }
                } else {
                    $arrResponse['status'] = "fail";
                }
            } else {
                $this->loadModel('Resourcecart');
                $arrProductRows = $this->Resourcecart->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id'])));
                if (is_array($arrProductRows) && (count($arrProductRows) > 0)) {
                    $intTotal = 0;
                    $arrResourceOrder = array();
                    $arrResourceOrderDetail = array();
                    foreach ($arrProductRows as $arrProduct) {
                        if($arrProduct['Resourcecart']['discount_cost'] !='' && $arrResourceDetail[0]['Resources']['discount_cost'] == '0.00'){
                            $intTotal = $intTotal + ($arrProduct['Resourcecart']['discount_cost'] * 1);
                        }else{
                           $intTotal = $intTotal + ($arrProduct['Resourcecart']['product_cost'] * 1); 
                        }
//                        $intTotal = $intTotal + ($arrProduct['Resourcecart']['product_cost'] * 1);
                    }
                    $arrResourceOrder['Resourceorder']['order_amount'] = $intTotal;
                    $arrResourceOrder['Resourceorder']['order_name'] = "OD00" . time();
                    $arrResourceOrder['Resourceorder']['order_payment_required'] = "1";
                    $arrResourceOrder['Resourceorder']['order_payment_status'] = "incomplete";
                    $arrResourceOrder['Resourceorder']['order_status'] = "initiated";
                    $arrResourceOrder['Resourceorder']['seeker_id'] = $arrLoggedUser['candidate_id'];
                    $this->loadModel('Resourceorder');
                    $this->Resourceorder->deleteAll(array('seeker_id' => $arrLoggedUser['candidate_id'], 'order_status' => 'initiated'), false);
                    $isSave = $this->Resourceorder->save($arrResourceOrder);
                    if ($isSave) {
                        $intOrderId = $this->Resourceorder->getLastInsertID();
                        $this->loadModel('Resourceorderdetail');
                        $this->loadModel('Vendorservice');
                        foreach ($arrProductRows as $arrProduct) {
                            $arrVendorDeta = $this->Vendorservice->find('all', array('conditions' => array('vendor_service_id' => $arrProduct['Resourcecart']['vendor_service_id'])));
                            $arrResourceOrderDetail['Resourceorderdetail']['product_id'] = $arrProduct['Resourcecart']['product_id'];
                            $arrResourceOrderDetail['Resourceorderdetail']['seeker_id'] = $arrLoggedUser['candidate_id'];
                            $arrResourceOrderDetail['Resourceorderdetail']['vendor_id'] = $arrVendorDeta[0]['Vendorservice']['vendor_id'];
                            $arrResourceOrderDetail['Resourceorderdetail']['vendor_cost'] = $arrVendorDeta[0]['Vendorservice']['vendor_cost'];
                            if ($arrVendorDeta[0]['Vendorservice']['merchant_cost_type'] == "per") {
                                $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost'] = (($arrVendorDeta[0]['Vendorservice']['service_cost'] * $arrVendorDeta[0]['Vendorservice']['merchant_cost']) / 100);
                            } else {
                                $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost'] = $arrVendorDeta[0]['Vendorservice']['merchant_cost'];
                            }
                            $arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] = ($arrProduct['Resourcecart']['product_cost'] - ($arrResourceOrderDetail['Resourceorderdetail']['vendor_cost'] + $arrResourceOrderDetail['Resourceorderdetail']['merchant_account_cost']));
                            if ($arrVendorDeta[0]['Vendorservice']['hc_cost_type'] == "per") {
                                $arrResourceOrderDetail['Resourceorderdetail']['hc_profit_cost'] = (($arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] * $arrVendorDeta[0]['Vendorservice']['hc_cost']) / 100);
                            } else {
                                $arrResourceOrderDetail['Resourceorderdetail']['hc_profit_cost'] = $arrVendorDeta[0]['Vendorservice']['hc_cost'];
                            }

                            if ($arrVendorDeta[0]['Vendorservice']['portal_cost_type'] == "per") {
                                $arrResourceOrderDetail['Resourceorderdetail']['portal_owner_cost'] = (($arrResourceOrderDetail['Resourceorderdetail']['revenue_generated'] * $arrVendorDeta[0]['Vendorservice']['portal_cost']) / 100);
                            } else {
                                $arrResourceOrderDetail['Resourceorderdetail']['portal_owner_cost'] = $arrVendorDeta[0]['Vendorservice']['portal_cost'];
                            }

                            $arrResourceOrderDetail['Resourceorderdetail']['vendor_payment_status'] = 'pending';
                            $arrResourceOrderDetail['Resourceorderdetail']['hc_payment_status'] = 'pending';
                            $arrResourceOrderDetail['Resourceorderdetail']['portal_payment_status'] = 'pending';
                            $arrResourceOrderDetail['Resourceorderdetail']['merchant_payment_status'] = 'pending';
                            $arrResourceOrderDetail['Resourceorderdetail']['vendor_service_id'] = $arrProduct['Resourcecart']['vendor_service_id'];
                            $arrResourceOrderDetail['Resourceorderdetail']['vendor_name'] = $arrProduct['Resourcecart']['vendor_name'];
                            $arrResourceOrderDetail['Resourceorderdetail']['product_name'] = $arrProduct['Resourcecart']['product_name'];
                            if($arrProduct['Resourcecart']['discount_cost'] !='' && $arrResourceDetail[0]['Resources']['discount_cost'] != '0.00'){
                                $arrResourceOrderDetail['Resourceorderdetail']['product_unit_cost'] = $arrProduct['Resourcecart']['discount_cost'];
                            }else{
                                $arrResourceOrderDetail['Resourceorderdetail']['product_unit_cost'] = $arrProduct['Resourcecart']['product_cost'];
                            }                      
                            $arrResourceOrderDetail['Resourceorderdetail']['product_qty'] = $arrProduct['Resourcecart']['product_qty'];
                            $arrResourceOrderDetail['Resourceorderdetail']['order_id'] = $intOrderId;
                            $arrResourceOrderDetail['Resourceorderdetail']['payment_status'] = "incomplete";
                            $arrResourceOrderDetail['Resourceorderdetail']['order_detail_status'] = "initiated";
                            $arrResourceOrderDetail['Resourceorderdetail']['cart_product_id'] = $arrProduct['Resourcecart']['cart_instance_id'];

                            $this->Resourceorderdetail->create(false);
                            $this->Resourceorderdetail->save($arrResourceOrderDetail);

                            $this->loadModel('Subvendororders');
                            $arrVendorUserOrderDetial['Subvendororders']['order_id'] = $intOrderId;
                            $arrVendorUserOrderDetial['Subvendororders']['vendor_id'] = $arrVendorDeta[0]['Vendorservice']['vendor_id'];
                            $this->Subvendororders->create(false);
                            $this->Subvendororders->save($arrVendorUserOrderDetial);
                        }
                        $arrResponse['status'] = "success";
                    } else {
                        $arrResponse['status'] = "fail";
                    }
                } else {
                    $arrResponse['status'] = "fail";
                }
            }
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function detail($intPortalId = "", $intContactId = "") {
//        echo $this->layout;die;
        if ($intPortalId) {
            $arrLoggedUser = $this->Auth->user();

            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);

            $this->loadModel('PortalPages');
            $arrPortalContactUsPageDetail = $this->PortalPages->find('all', array(
                'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'], 'career_portal_page_tittle' => 'Contact Us')
            ));
            $intContactUsPageDetail = $arrPortalContactUsPageDetail[0]['PortalPages']['career_portal_page_id'];
            $this->set('intContactUsPageId', $intContactUsPageDetail);

            $this->loadModel('Vendorservice');
            $arrContentDetail = $this->Vendorservice->find('all', array('conditions' => array('vendor_service_id' => $intContactId)));
//            print("<pre>");print_r($arrContentDetail);die;
            
            if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {
                $this->loadModel('Resources');
                $arrResourceContent = $this->Resources->find('all', array('conditions' => array('productd_id' => $arrContentDetail[0]['Vendorservice']['service_id'])));
//			print("<pre>");
//			print_r($arrResourceContent[0]['Resources']['productd_id']);
//exit();

                if (is_array($arrResourceContent) && (count($arrResourceContent) > 0)) {
                    $arrContentDetail[0]['Resources'] = $arrResourceContent[0]['Resources'];
                    $this->loadModel('Content');
                    $arrRContentDetail = $this->Content->find('all', array('conditions' => array('resource_id' => $arrResourceContent[0]['Resources']['productd_id'])));

                    /* print("<pre>");
                      print_r($arrRContentDetail);
                      exit(); */

                    $this->loadModel('ResourcesImages');
                    $arrContentDetailImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $arrResourceContent[0]['Resources']['productd_id']), 'limit' => '1'));

                    //print("<pre>");
                    //print_r($arrContentDetailImages);


                    if (is_array($arrRContentDetail) && (count($arrRContentDetail) > 0)) {
                        $arrContentDetail[0]['Content'] = $arrRContentDetail[0]['Content'];
                        $arrContentDetail[0]['Resourceimages'] = $arrContentDetailImages[0]['ResourcesImages'];
                    }

//					print("<pre>");
//					print_r($arrContentDetail);
                    // check if user is enrolled to this course service
//                    if ($arrResourceContent[0]['Resources']['product_type'] == "Course" || $arrResourceContent[0]['Resources']['product_type'] == "SkillSoftcourse") {
                        //print("<pre>");
                        //print_r($arrResourceContent);
                        //echo "--".$arrContentDetail[0]['Vendorservice']['vendor_service_id'];
                        //echo "--".$arrLoggedUser['candidate_id'];
                        //echo "--".$arrResourceContent[0]['Resources']['productd_id'];

                        $this->loadModel('Resourceorderdetail');
                        $intIsUserEnrolled = $this->Resourceorderdetail->find('count', array('conditions' => array('product_id' => $arrResourceContent[0]['Resources']['productd_id'], 'seeker_id' => $arrLoggedUser['candidate_id'], 'payment_status' => 'captured', 'order_detail_status' => 'approved')));
//                        print("<pre>");
//                        print_r($intIsUserEnrolled);
                        if ($intIsUserEnrolled) {
                            $arrContentDetail[0]['EnrolledUser'] = "1";
                        } else {
                            $arrContentDetail[0]['EnrolledUser'] = "0";
                        }
//                    }
                }
            }

            $this->set('addcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'add', $intPortalId), true));
            $this->set('strListcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'index', $intPortalId), true));
            $this->set('arrContentDetail', $arrContentDetail);
//			print("<pre>");
//			print_r($arrContactDetail);
        }
    }

    public function logout($intPortalId = "", $strSwitchBack = "") {
        /* if(!$intPortalId) 
          {
          $intPortalId = Configure::read('PrivatePortal.id');
          } */

        $this->autoRender = false;
        if ($intPortalId) {
            $arrLoggedUser = $this->Auth->user();
            $this->loadModel('Portal');
            if (is_numeric($intPortalId)) {
                $arrPortalDetail = $this->Portal->find('all', array(
                    'conditions' => array('career_portal_id' => $intPortalId)
                ));
            } else {
                $arrPortalDetail = $this->Portal->find('all', array(
                    'conditions' => array('career_portal_name' => $intPortalId)
                ));
            }

            /* print("<pre>");
              print_r($arrPortalDetail); */
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);
            $strLogoutPath = $this->Auth->logout();

            /* $compCandidates = $this->Components->load('Candidates');
              $isJobebrTokenUpdated = $compCandidates->fnUpdateCandidateJobberToken($arrLoggedUser['candidate_id']);

              $isLmsTokenUpdated = $compCandidates->fnUpdateCandidateLmsToken($arrLoggedUser['candidate_id']); */
            if ($strSwitchBack) {
                $strUrlToGo = $_SESSION['switchurltogo'] . "/1";
                $this->redirect($strUrlToGo);
            } else {
                $this->redirect($strLogoutPath);
            }
        }
    }

    public function login($intPortalId = "") {
        /* if(!$intPortalId) 
          {
          $intPortalId = Configure::read('PrivatePortal.id');
          } */

        if (!$intPortalId) {
            if (isset($this->request->data['PortalUser']['portal_id'])) {
                $intPortalId = $this->request->data['PortalUser']['portal_id'];
            } else {
                $arrReturResult = array();
                $arrReturResult['status'] = "failure";
                $arrReturResult['message'] = "Bad Request";
                echo json_encode($arrReturResult);
                exit;
            }
        }

        if ($intPortalId) {
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);
            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            /* print("<pre>");
              print_r($arrMenuDetail); */
            $this->set('arrPortalMenuDetail', $arrMenuDetail);
            if ($this->request->is('post')) {
                /* print("<pre>");
                  print_r($this->request->data); */

                $this->loadModel('Candidate');
                $this->request->data['Candidate']['candidate_email'] = addslashes(trim($this->request->data['PortalUser']['email']));
                $this->request->data['Candidate']['candidate_password'] = addslashes(trim($this->request->data['PortalUser']['password']));

                $this->Candidate->validate['candidate_email']['Not Empty'] = array('rule' => 'notEmpty', 'message' => 'Cannot leave Email field empty');
                $this->Candidate->validate['candidate_email']['Email'] = array('rule' => 'email', 'message' => 'Provided email address was not correct');
                $this->Candidate->validate['candidate_password']['Not Empty'] = array('rule' => 'notEmpty', 'message' => 'Cannot leave Password field empty');

                /* print("<pre>");
                  print_r($this->request->data);
                  exit */;
                $this->Candidate->set($this->request->data);
                if ($this->Candidate->validates()) {
                    if ($this->Auth->login()) {
                        $arrLoggedInUser = $this->Auth->user();
                        $arrReturResult = array();
                        $arrReturResult['status'] = "success";
                        $arrReturResult['userid'] = $arrLoggedInUser['candidate_id'];
                        $arrReturResult['username'] = $arrLoggedInUser['candidate_username'];
                        $arrReturResult['useremail'] = $arrLoggedInUser['candidate_email'];
                        //$arrReturResult['redirecturl'] = Router::url($this->Auth->redirectUrl(),true);
                        $arrReturResult['redirecturl'] = Router::url(array('controller' => 'portal', 'action' => 'index', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']), "1"), true);
                        //$arrReturResult['redirecturl'] = Router::url(array('controller'=>'portal','action'=>'index',strtolower($arrPortalDetail[0]['Portal']['career_portal_name'])),true);
                        $arrReturResult['userportalid'] = $arrLoggedInUser['career_portal_id'];

                        echo json_encode($arrReturResult);
                        exit;
                        //$this->redirect($this->Auth->redirectUrl());					
                    } else {
                        $arrResultSet = array();
                        $arrResultSet['status'] = "failure";
                        $arrResultSet['message'] = "Your username and password combination was incorrect.";
                        $this->Session->setFlash('Your username and password combination was incorrect');
                        echo json_encode($arrResultSet);
                        exit;
                    }
                } else {
                    $errors = $this->Candidate->invalidFields();
                    $strCandidateLoginerrorMessage = "";
                    if (is_array($errors) && (count($errors) > 0)) {
                        $intErrorCnt = 0;
                        foreach ($errors as $errorVal) {
                            $intErrorCnt++;
                            if ($intErrorCnt == "1") {
                                $strCandidateLoginerrorMessage .= "Error: " . $errorVal['0'];
                            } else {
                                $strCandidateLoginerrorMessage .= "<br> Error: " . $errorVal['0'];
                            }
                        }
                        $arrResultSet = array();
                        $arrResultSet['status'] = "failure";
                        $arrResultSet['message'] = $strCandidateLoginerrorMessage;
                        $this->Session->setFlash($strCandidateLoginerrorMessage);
                        echo json_encode($arrResultSet);
                        exit;
                    }
                }
            } else {
                if (is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS')) > 0)) {
                    //echo "HI";exit;
                    /* print("<pre>");
                      print_r($this->Session->read('SOCIALREGISTRATIONDETAILS'));
                      exit; */

                    $this->loadModel('Candidate');
                    $arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');

                    $arrUserExists = $this->Candidate->find('first', array('conditions' => array('career_portal_id' => $intPortalId, 'candidate_email' => $arrRegistrationData['SOCIALUSEREMAIL'])));
                    /* print("<pre>");
                      print_r($arrUserExists);
                      exit; */
                    if (is_array($arrUserExists) && (count($arrUserExists) > 0)) {
                        $this->Auth->login($arrUserExists['Candidate']);

                        $arrSeekerData['form_param'] = '1';
                        $arrSeekerData['form_upor'] = $arrUserExists['Candidate']['candidate_id'];
                        $arrSeekerData['form_upormai'] = $arrRegistrationData['SOCIALUSEREMAIL'];
                        $arrSeekerData['form_uporna'] = '';
                        $arrSeekerData['form_uporie'] = $intPortalId;
                        $arrSeekerData['form_socio'] = "1";

                        //print("<pre>");
                        //print_r($arrSeekerData);	

                        $compJobberBridge = $this->Components->load('JobberBridge');
                        $arrResponse = $compJobberBridge->fnLogSeekerIn($arrSeekerData);
                        //echo "HI";
                        //print("<pre>");
                        //print_r($arrResponse);exit;
                        // id login success carry on otherwise remove the fb inserted record and ask for try again

                        if ($arrResponse['status'] != "success") {
                            $this->Auth->logout();
                            $this->Session->setFlash("There might be some issue, Please Try Again");
                        } else {
                            setcookie("HCJPORTAL" . $intPortalId, $arrResponse['sid'], 0, "/");
                            $compLmsBridge = $this->Components->load('LmsBridge');
                            $arrLmsResponse = $compLmsBridge->fnLogSeekerIn($intPortalId, $arrUserExists);
                            if ($arrLmsResponse['status'] == "success") {
                                setcookie("_FrontendUser_" . $intPortalId, $arrLmsResponse['sid'], 0, "/moodle/");
                                $arrSessionUpdatedResponse = $this->updatesession($intPortalId, $arrLmsResponse['sesskey'], "", $arrLmsResponse['sesskey'], $arrResponse['st']);
                                /* print("<pre>");
                                  print_r($arrSessionUpdatedResponse);
                                  exit; */
                                if ($arrSessionUpdatedResponse['status'] == "success") {
                                    //echo "--".$arrRegistrationData['logout_url'];

                                    $arrNextLoggInUrl = explode("next=", $arrRegistrationData['logout_url']);
                                    $strLoggInUrl = urldecode($arrNextLoggInUrl[1]);
                                    $arrLoginUrl = explode("&", $strLoggInUrl);
                                    if (is_array($arrLoginUrl) && (count($arrLoginUrl) > 0)) {
                                        $arrLoginUrl[0] = urlencode(Router::url(array('controller' => 'portal', 'action' => 'index', $arrPortalDetail[0]['Portal']['career_portal_name'], "1"), true));
                                    }
                                    $strLoggInUrl = implode("&", $arrLoginUrl);
                                    $arrNextLoggInUrl[1] = $strLoggInUrl;
                                    $arrRegistrationData['logout_url'] = implode("next=", $arrNextLoggInUrl);
                                } else {
                                    $arrLoggedFromLms = $compLmsBridge->fnLogSeekerOut($arrLmsResponse['sesskey']);
                                    if ($arrLoggedFromLms['status'] == "success") {
                                        $arrSeekerLogout = array('token' => $arrSeekerData['jb_auth_token']);
                                        $arrJobberLogutResponse = $compJobberBridge->fnLogSeekerOut($arrSeekerLogout);
                                        if ($arrJobberLogutResponse['status'] == "success") {
                                            $this->Auth->logout();
                                        }
                                    }
                                }
                            }
                        }
                        $this->Session->delete('SOCIALREGISTRATIONDETAILS');
                        $this->Session->delete('fb_' . Configure::read('Social.FbApkey') . '_access_token');
                        $this->redirect($arrRegistrationData['logout_url']);
                    } else {
                        $arrNewUserData = array();
                        $arrNewUserData['Candidate']['career_portal_id'] = $intPortalId;
                        $arrNewUserData['Candidate']['candidate_email'] = $arrRegistrationData['SOCIALUSEREMAIL'];
                        $arrNewUserData['Candidate']['candidate_password'] = AuthComponent::password(uniqid(mt_rand()));
                        $arrNewUserData['Candidate']['candidate_first_name'] = $arrRegistrationData['SOCIALUSERFNAME'];
                        $arrNewUserData['Candidate']['candidate_last_name'] = $arrRegistrationData['SOCIALUSERLNAME'];

                        $this->Candidate->create(false);
                        $boolCreadted = $this->Candidate->save($arrNewUserData);

                        if (is_array($boolCreadted) && (count($boolCreadted) > 0)) {
                            $arrSeekerData = array();
                            $arrSeekerData['form_param'] = '1';
                            $arrSeekerData['form_upor'] = $this->Candidate->getLastInsertID();
                            $arrSeekerData['form_upormai'] = $arrNewUserData['Candidate']['candidate_email'];
                            $arrSeekerData['form_uporna'] = '';
                            $arrSeekerData['form_uporie'] = $intPortalId;
                            $arrSeekerData['form_socio'] = "1";



                            $compJobberBridge = $this->Components->load('JobberBridge');
                            $arrResponse = $compJobberBridge->fnLogSeekerIn($arrSeekerData);

                            /* print("<pre>");
                              print_r($arrResponse);exit; */

                            if ($arrResponse['status'] != "success") {
                                $isCandidateDeleted = $this->Candidate->deleteAll(array('Candidate.candidate_id' => $this->Candidate->getLastInsertID()), false);
                                $this->Session->delete('SOCIALREGISTRATIONDETAILS');
                                $this->Session->delete('fb_' . Configure::read('Social.FbApkey') . '_access_token');
                                $this->redirect(array('controller' => 'candidates', 'action' => 'dashboard', $intPortalId));
                            }
                        } else {
                            //echo "Helo";exit;
                        }
                        $this->redirect(Router::url(null, true));
                    }
                }
            }
        }
    }

    public function contactus($intPortalId = "") {
        $this->autoRender = false;
        if ($intPortalId) {
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));

            if (is_array($arrPortalDetail) && (count($arrPortalDetail) > 0)) {
                $this->set('arrPortalDetail', $arrPortalDetail);
                $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
                $this->set('intPortalId', $intPortalId);
                $arrContactUs = array();

                if ($this->request->is('post')) {
                    /* print("<pre>");
                      print_r($this->request->data);
                      exit; */

                    $strContactusErrorMessage = "";
                    $intContactFormId = $this->request->data['contact_form_id'];
                    $this->request->data['Contactus']['portal_id'] = $intPortalId;
                    if ($intContactFormId) {
                        $this->loadModel('Contactus');
                        $this->loadModel('ContactFormFields');
                        $arrContactFormFields = $this->ContactFormFields->fnGetAllFields($intContactFormId);
                        /* print('<pre>');
                          print_r($arrContactFormFields); */

                        if (is_array($arrContactFormFields) && (count($arrContactFormFields) > 0)) {
                            foreach ($arrContactFormFields as $arrContactFieldDetail) {
                                // load validations for form
                                $arrContactValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFieldDetail['fields_table']['field_id']);
                                /* print('<pre>');
                                  print_r($arrContactValidations); */

                                $strContacUsColumnPrefixString = 'portal_contacter_';

                                if (is_array($arrContactValidations) && (count($arrContactValidations) > 0)) {

                                    foreach ($arrContactValidations as $arrCintactValidation) {
                                        switch ($arrCintactValidation['validation_rule_table']['validation_rule']) {
                                            case"notempty": //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Not Empty',array('rule' => 'notEmpty','message' => 'Cannot leave the field empty'));
                                                $this->Contactus->validate[$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']]['Not Empty'] = array('rule' => 'notEmpty', 'message' => 'Cannot leave Mandatory field empty');
                                                break;
                                            case"email":  //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
                                                $this->Contactus->validate[$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']]['Email'] = array('rule' => 'email', 'message' => 'Provided email address was not correct');
                                                break;
                                        }
                                    }
                                }

                                // Accepting Contact Us Posted Request(data from the form)
                                if ($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_email_field']) {
                                    $arrContactUs['email'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
                                } else {
                                    if ($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_field_greet_name']) {
                                        $arrContactUs['name'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
                                    } else {
                                        if ($arrContactFieldDetail['career_portal_contact_us_form_fields']['is_contacter_field_message']) {
                                            $arrContactUs['message'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
                                        } else {
                                            $arrContactUs['subject'] = $this->request->data['Contactus'][$strContacUsColumnPrefixString . $arrContactFieldDetail['fields_table']['field_name']] = addslashes(trim($this->request->data[$arrContactFieldDetail['fields_table']['field_name']]));
                                        }
                                    }
                                }
                            }
                        }
                    }
                    /* print('<pre>');
                      print_r($arrContactUs);
                      exit; */
                    $this->Contactus->set($this->request->data);
                    if ($this->Contactus->validates()) {
                        $boolContactUsDataSaved = $this->Contactus->save($this->request->data);
                        if ($boolContactUsDataSaved) {
                            // set success message
                            $this->Session->setFlash('Thanks For Contacting Us, Your Message has been sent, Soon You will be contacted!', 'default', array('class' => 'success'));

                            if (isset($arrContactUs['email'])) {

                                $this->loadModel('User');
                                $arrUserDetail = $this->User->find('all', array('conditions' => array('id' => $arrPortalDetail[0]['Portal']['career_portal_provider_id'])));

                                // shoot email to admin
                                $arrPortalOwn = $this->User->fnFindOwnerDetail($arrUserDetail[0]['User']['id']);
                                $this->fnSendAdminPortalContactusEmail($arrUserDetail, $arrPortalDetail[0]['Portal']['career_portal_name'], $arrContactUs, $arrPortalOwn);

                                // shoot email to portal owner
                                /* $intNotifiedPortalAdmin = $this->fnSendPortalAdminContactusEmail($arrUserDetail,$arrPortalDetail[0]['Portal']['career_portal_name'],$arrContactUs); */

                                // shoot an email to contacter
                                $intNotifyContacter = $this->fnSendContactUsFormSubmissionEmailForContacter($arrContactUs['email']);
                            }
                        } else {
                            // set error message
                            $this->Session->setFlash('Please Try Again Some Problem!');
                        }
                    } else {
                        $arrContactUsErrors = $this->Contactus->invalidFields();
                        if (is_array($arrContactUsErrors) && (count($arrContactUsErrors) > 0)) {
                            $intForIterateCount = 0;
                            foreach ($arrContactUsErrors as $errorVal) {
                                $intForIterateCount++;
                                if ($intForIterateCount == 1) {
                                    $strContactusErrorMessage .= "Error: " . $errorVal['0'];
                                } else {
                                    $strContactusErrorMessage .= "<br> Error: " . $errorVal['0'];
                                }
                            }
                        }
                        $this->Session->setFlash($strContactusErrorMessage);
                    }
                    $this->redirect($this->referer());
                }
            }
        }
    }

    public function page($intPortalId = "", $intPageId = "") {
        $this->set('strPortalNotFoundMessage', "");
        $this->set("strKeywords", "");
        $this->set("strlocation", "");
        //$strId = base64_decode($intPortalPageId);
        //$arrPageDetail = explode("_",$strId);
        $intPortalId = $intPortalId;
        $intPageId = $intPageId;
        if ($intPortalId) {
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            if (is_array($arrPortalDetail) && (count($arrPortalDetail) > 0)) {
                $this->set('arrPortalDetail', $arrPortalDetail);
                $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
                $this->set('intPortalId', $intPortalId);


                // load portal theme page widgets
                /* $intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
                  $this->loadModel('PortalThemePageWidgets');
                  //$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
                  $arrPortalThemePageWidgets = $this->PortalThemePageWidgets->fnLoadPortalThemePageWidgetDetail();
                  if(is_array($arrPortalThemePageWidgets) && (count($arrPortalThemePageWidgets)>0))
                  {
                  $this->set('arrPortalWidgets',$arrPortalThemePageWidgets);
                  } */


                // load menus data
                $this->loadModel('TopMenu');
                $arrMenuDetail = $this->TopMenu->find('all', array('conditions' => array('career_portal_id' => $intPortalId), 'order' => array('TopMenu.career_portal_menu_order' => 'ASC')));
                /* print("<pre>");
                  print_r($arrMenuDetail); */
                if (is_array($arrMenuDetail) && (count($arrMenuDetail) > 0)) {
                    $this->set('arrPortalMenuDetail', $arrMenuDetail);
                }

                // load page data
                $this->loadModel('PortalPages');
                $arrPortalPageDetail = $this->PortalPages->find('all', array(
                    'conditions' => array('career_portal_id' => $intPortalId, 'career_portal_page_id' => $intPageId)
                ));


                $this->set('arrPortalPageDetail', $arrPortalPageDetail);
                if ($arrPortalPageDetail[0]['PortalPages']['career_portal_page_tittle'] == "Contact Us") {
                    $this->loadModel('PortalContactForm');
                    $arrContactFormDetail = $this->PortalContactForm->find('all', array('conditions' => array('PortalContactForm.career_portal_id' => $intPortalId, 'PortalContactForm.career_portal_contact_us_form_is_active' => '1')));
                    /* print("<pre>");
                      print_r($arrContactFormDetail); */
                    if (is_array($arrContactFormDetail) && (count($arrContactFormDetail) > 0)) {
                        $this->loadModel('ContactFormFields');
                        //$arrContactFormFields = $this->ContactFormFields->find('all',array('conditions'=>array('career_portal_contact_us_form_id'=>$arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id'])));
                        $arrContactFormFields = $this->ContactFormFields->fnGetAllFields($arrContactFormDetail[0]['PortalContactForm']['career_portal_contact_us_form_id']);
                        if (is_array($arrContactFormFields) && (count($arrContactFormFields) > 0)) {
                            $intContactFormFieldCount = 0;
                            foreach ($arrContactFormFields as $arrContactFFields) {
                                $arrContactFormValidations = $this->ContactFormFields->fnGetAllFieldValidation($arrContactFFields['fields_table']['field_id']);
                                $arrContactFormFields[$intContactFormFieldCount]['contactfieldvalidations'] = $arrContactFormValidations;
                                $intContactFormFieldCount++;
                            }
                            $arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
                        }
                        $arrContactFormDetail[0]['PortalContactForm']['ContactFormFields'] = $arrContactFormFields;
                        /* print("<pre>");
                          print_r($arrContactFormDetail); */
                        $this->set('arrContactFormDetail', $arrContactFormDetail);
                    }
                }

                $this->loadModel('Job');
                $arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);

                $this->loadModel('Job');
                $arrLatesJobDetail = $this->Job->fnGetLatesJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);

                $this->set('arrPortalLatestJobDetail', $arrLatesJobDetail);
                /* print("<pre>");
                  print_r($arrLatesJobDetail); */

                $this->loadModel('Job');
                $arrHighJobDetail = $this->Job->fnGetHighlightedJobForPortal($arrPortalDetail[0]['Portal']['career_portal_id']);
                /* print("<pre>");
                  print_r($arrHighJobDetail); */
                $this->set('arrPortalHJobDetail', $arrHighJobDetail);

                $this->loadModel('JCountry');
                $arrJCountries = $this->JCountry->find('list', array('fields' => array('JCountry.code', 'JCountry.name')));
                asort($arrJCountries);
                $this->set('arrJcountry', $arrJCountries);


                $this->loadModel('JobCategory');
                $arrJCategories = $this->JobCategory->find('list', array('fields' => array('JobCategory.id', 'JobCategory.cat_name')));
                $arrJCategories["0"] = "Choose Category";
                ksort($arrJCategories);
                $this->set('arrJcategories', $arrJCategories);

                $this->loadModel('JobExperience');
                $arrJobExperience = $this->JobExperience->find('list', array('fields' => array('JobExperience.var_name', 'JobExperience.experience_name')));
                $arrJobInitialVal["0"] = "Choose Experience";
                //ksort($arrJobExperience);
                $arrNewMergedJobExp = array_merge($arrJobInitialVal, $arrJobExperience);
                $this->set('arrJobExperience', $arrNewMergedJobExp);

                // courses detail
                $compLmsBridge = $this->Components->load('LmsBridge');
                $arrCourseDetails = $compLmsBridge->fnGetPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);

                /* print("<pre>");
                  print_r($arrCourseDetails); */

                $this->set('arrCoursesDetails', $arrCourseDetails);
            }
        }
    }

    public function reset($intPortalId = "") {
        $arrExistSocialSession = $this->Session->read('SOCIALREGISTRATIONDETAILS');
        if (is_array($arrExistSocialSession) && (count($arrExistSocialSession) > 0)) {
            if (isset($arrExistSocialSession['SOCIALUSERTYPE'])) {
                if ($arrExistSocialSession['SOCIALUSERTYPE'] == "facebook") {
                    // run the facebook logout url in background
                    $this->Session->delete('fb_' . Configure::read('Social.FbApkey') . '_access_token');
                    $this->Session->delete('fb_' . Configure::read('Social.FbApkey') . '_code');
                    $this->Session->delete('fb_' . Configure::read('Social.FbApkey') . '_user_id');
                }
                if ($arrExistSocialSession['SOCIALUSERTYPE'] == "twitter") {
                    $this->Session->delete('twitter');
                    $this->Session->delete('SOCIALREGISTRATIONDETAILS');
                }
                if ($arrExistSocialSession['SOCIALUSERTYPE'] == "linkedin") {
                    $this->Session->delete('linkedin');
                    $this->Session->delete('SOCIALREGISTRATIONDETAILS');
                }
            }
        }
        $this->redirect(array('controller' => 'portal', 'action' => 'registration', $intPortalId));
    }

    function captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) { //if Component was not loaded throug $components array()
            $this->Captcha = $this->Components->load('Captcha', array(
                'width' => 150,
                'height' => 50,
                'theme' => 'default', //possible values : default, random ; No value means 'default'
            )); //load it
        }
        $this->Captcha->create();
    }

    public function registration($intPortalId = "") {
        /* if(!$intPortalId) 
          {
          $intPortalId = Configure::read('PrivatePortal.id');
          } */
        /* print("<pre>");
          print_r($_SESSION);
          exit; */

        if ($intPortalId) {
            $strRegistrationMethod = "Manual";
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            /* print("<pre>");
              print_r($arrMenuDetail); */
            $this->set('arrPortalMenuDetail', $arrMenuDetail);
            if (is_array($arrPortalDetail) && (count($arrPortalDetail) > 0)) {
                $this->loadModel('PortalRegistration');
                $arrPortalRegistration = $this->PortalRegistration->find('all', array(
                    'conditions' => array('career_portal_id' => $intPortalId, 'career_registration_form_is_active' => '1')
                ));
                $this->loadModel('RegistrationFormFields');
                $arrRegistrationFieldDetail = $this->RegistrationFormFields->fnGetAllFields($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
                if (is_array($arrRegistrationFieldDetail) && (count($arrRegistrationFieldDetail) > 0)) {
                    $intForEachCount = 0;
                    foreach ($arrRegistrationFieldDetail as $arrRegistrationField) {

                        $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table'] = $arrRegistrationField['fields_table'];
                        $arrCompleteRegistrationFieldDetail[$intForEachCount]['career_portal_registration_form_fields'] = $arrRegistrationField['career_portal_registration_form_fields'];
                        $arrFieldValidationDetail = $this->RegistrationFormFields->fnGetAllFieldValidation($arrRegistrationField['fields_table']['field_id']);
                        $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_validation'] = $arrFieldValidationDetail;
                        $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = "";
                        if (is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS')) > 0)) {
                            $arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');

                            //echo "---".$arrRegistrationField['fields_table']['field_name'];

                            if (isset($arrRegistrationData['SOCIALUSERFNAME'])) {

                                if ($arrRegistrationField['fields_table']['field_name'] == 'first_name') {
                                    $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERFNAME'];
                                }
                            }

                            if (isset($arrRegistrationData['SOCIALUSERLNAME'])) {
                                if ($arrRegistrationField['fields_table']['field_name'] == 'last_name') {
                                    $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLNAME'];
                                }
                            }


                            if (isset($arrRegistrationData['SOCIALUSEREMAIL'])) {
                                if ($arrRegistrationField['fields_table']['field_name'] == 'email') {
                                    $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSEREMAIL'];
                                }
                            }

                            if (isset($arrRegistrationData['SOCIALUSERLOCATION'])) {
                                if ($arrRegistrationField['fields_table']['field_name'] == 'address') {
                                    $arrCompleteRegistrationFieldDetail[$intForEachCount]['fields_table']['field_value'] = $arrRegistrationData['SOCIALUSERLOCATION'];
                                }
                            }
                        }

                        $intForEachCount++;
                    }
                }
                if ($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_is_social_media']) {
                    $this->loadModel('RegistrationSocialMedialField');
                    $arrSetRegistrationSocialFields = $this->RegistrationSocialMedialField->fnGetSocialMediaFieldDetail($arrPortalRegistration['0']['PortalRegistration']['career_registration_form_id']);
                    /* print("<pre>");
                      print_r($arrSetRegistrationSocialFields); */

                    $this->set('arrRegistrationSocialPluginData', $arrSetRegistrationSocialFields);
                }


                /* print("<pre>");
                  print_r($_SESSION); */
                if (is_array($this->Session->read('SOCIALREGISTRATIONDETAILS')) && (count($this->Session->read('SOCIALREGISTRATIONDETAILS')) > 0)) {
                    $arrRegistrationData = $this->Session->read('SOCIALREGISTRATIONDETAILS');
                    $this->set('strResetUrl', $arrRegistrationData['logout_url']);
                    $this->set('strSocialSetType', $arrRegistrationData['SOCIALUSERTYPE']);
                    $strRegistrationMethod = $arrRegistrationData['SOCIALUSERTYPE'];
                }


                $this->set('intPortalId', $intPortalId);
                $this->set('arrRegistrationForm', $arrPortalRegistration);
                $this->set('arrRegistrationFieldDetail', $arrCompleteRegistrationFieldDetail);
                $this->set('strRegistrationMethod', $strRegistrationMethod);
            }

            /* print("<pre>");
              print_r($arrCompleteRegistrationFieldDetail); */

            if ($this->request->is('post')) {
                /* print("<pre>");
                  print_r($this->request->data);
                  exit; */

                $arrUniqueFieldsConditions = array();
                $strShare = "";
                if (isset($this->request->data['share'])) {
                    $strShare = $this->request->data['share'];
                }
                if (isset($this->request->data['regmethod'])) {
                    $strCandidateRegMethod = $this->request->data['regmethod'];
                }
                $strFname = "";
                $strEmail = "";

                $this->loadModel('PortalUser');
                if (!isset($this->Captcha)) {
                    //if Component was not loaded throug $components array()
                    $this->Captcha = $this->Components->load('Captcha'); //load it
                }
                $this->PortalUser->setCaptcha($this->Captcha->getVerCode()); //getting from component and passing to model to make proper validation check
                /* $this->PortalUser->validate[] = array(
                  'captcha'=>array(
                  'rule' => array('matchCaptcha'),
                  'message'=>'Failed validating human check.'
                  )
                  ); */
                foreach ($arrCompleteRegistrationFieldDetail as $arrRegistrationFields) {
                    if (is_array($arrRegistrationFields['fields_validation']) && (count($arrRegistrationFields['fields_validation']) > 0)) {

                        foreach ($arrRegistrationFields['fields_validation'] as $arrValidationDetail) {
                            switch ($arrValidationDetail['validation_rule_table']['validation_rule']) {
                                case"notempty": //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Not Empty',array('rule' => 'notEmpty','message' => 'Cannot leave the field empty'));
                                    $this->PortalUser->validate['candidate_' . $arrRegistrationFields['fields_table']['field_name']]['Not Empty'] = array('rule' => 'notEmpty', 'message' => 'Cannot leave the field empty');
                                    break;
                                case"email":  //$this->PortalUser->fnAddValidationRule('candidate_'.$arrRegistrationFields['fields_table']['field_name'],'Email',array('rule' => 'email','message' => 'Provided email address was not correct'));
                                    $this->PortalUser->validate['candidate_' . $arrRegistrationFields['fields_table']['field_name']]['Email'] = array('rule' => 'email', 'message' => 'Provided email address was not correct');
                                    break;
                            }
                        }
                    }

                    switch ($arrRegistrationFields['fields_table']['field_type']) {
                        case 'password' : $this->request->data['PortalUser']['candidate_password_decrypted'] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                            $this->request->data['PortalUser']['candidate_' . $arrRegistrationFields['fields_table']['field_name']] = AuthComponent::password($this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']]);
                            break;
                        case 'text' : $this->request->data['PortalUser']['candidate_' . $arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                            break;
                    }


                    if ($arrRegistrationFields['fields_table']['field_is_unique']) {
                        $arrUniqueFieldsConditions['candidate_' . $arrRegistrationFields['fields_table']['field_name']] = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                    }
                    $strCurrentFieldName = 'candidate_' . $arrRegistrationFields['fields_table']['field_name'];
                    if ($strCurrentFieldName == "candidate_first_name") {
                        $strFname = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                    }

                    if ($strCurrentFieldName == "candidate_email") {
                        $strEmail = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                    }

                    if ($strCurrentFieldName == "candidate_username") {
                        $strCandidateUsername = $this->request->data['PortalUser'][$arrRegistrationFields['fields_table']['field_name']];
                    }
                }
                $arrUniqueFieldsConditions['career_portal_id'] = $intPortalId;

                /* print("<pre>");
                  print_r($arrUniqueFieldsConditions);
                  exit; */


                $intCountCandidateExists = $this->PortalUser->find('count', array('conditions' => $arrUniqueFieldsConditions));
                if ($intCountCandidateExists) {
                    $this->Session->setFlash('This account is already been registered, Please try again with other details');
                } else {
                    $this->request->data['PortalUser']['career_portal_id'] = $intPortalId;
                    $this->PortalUser->set($this->request->data);
                    /* print("<pre>");
                      print_r($this->PortalUser->validate);exit; */
                    if (is_array($this->PortalUser->validate) && (count($this->PortalUser->validate) > 0)) {
                        if ($this->PortalUser->validates()) {
                            $boolCandidateRegistered = $this->PortalUser->save($this->request->data);
                            if ($boolCandidateRegistered) {
                                $intLastCandidateInsertedId = $this->PortalUser->getInsertID();
                                $boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname, $strEmail, $intLastCandidateInsertedId, $arrPortalDetail[0]['Portal']['career_portal_name'], $intPortalId);
                                $arrMixPanelRegisteredData = array();
                                $arrMixPanelRegisteredData['username'] = $strFname;
                                $arrMixPanelRegisteredData['useremail'] = $strEmail;
                                $arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
                                $arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
                                $arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod;
                                // set default role for the portal in LMS
                                $compLms = $this->Components->load('LmsBridge');
                                $arrSeekerLmsSetup = $compLms->fnSetupSeeker($arrPortalDetail['0']['Portal']['career_portal_id'], $strEmail);
                                /* print("<pre>");
                                  print_r($arrSeekerLmsSetup);
                                  exit; */


                                // based on user request share on facebook
                                if ($strShare == "facebook") {
                                    $this->SocialRegister = $this->Components->load('FbRegister');
                                    $boolShared = $this->SocialRegister->fnShareUserRegistrationOnFacebook($arrPortalDetail);
                                }
                                // based on user request share on twitter
                                if ($strShare == "twitter") {
                                    $this->SocialRegister = $this->Components->load('FbRegister');
                                    $boolShared = $this->SocialRegister->fnShareUserRegistrationOnTwitter($arrPortalDetail);
                                }
                                // based on user request share on linkedin
                                if ($strShare == "linkedin") {
                                    $this->SocialRegister = $this->Components->load('FbRegister');
                                    $boolShared = $this->SocialRegister->fnShareUserRegistrationOnLinkedIn($arrPortalDetail);
                                }
                                $this->Session->setFlash('You are now registered, Please check your email for confirmation', 'default', array('class' => 'success'));
                                $this->set('isRegistrationDone', "1");
                                $this->set('arrMixPanelUserRegData', $arrMixPanelRegisteredData);
                            }
                        } else {
                            $errors = $this->PortalUser->invalidFields();
                            $strCandidateRegerrorMessage = "";
                            if (is_array($errors) && (count($errors) > 0)) {
                                $intErrorCnt = 0;
                                foreach ($errors as $errorVal) {
                                    $intErrorCnt++;
                                    if ($intErrorCnt == "1") {
                                        $strCandidateRegerrorMessage .= "Error: " . $errorVal['0'];
                                    } else {
                                        $strCandidateRegerrorMessage .= "<br> Error: " . $errorVal['0'];
                                    }
                                }

                                $this->Session->setFlash($strCandidateRegerrorMessage);
                            }
                        }
                    } else {
                        $boolCandidateRegistered = $this->PortalUser->save($this->request->data);
                        if ($boolCandidateRegistered) {
                            $intLastCandidateInsertedId = $this->PortalUser->getInsertID();
                            $boolRegistrationMail = $this->fnSendPortalRegistrationConfirmationEmail($strFname, $strEmail, $intLastUserInsertedId, $arrPortalDetail[0]['Portal']['career_portal_name'], $intPortalId);
                            $this->Session->setFlash('You are now registered, Please check your email for confirmation', 'default', array('class' => 'success'));
                            $arrMixPanelRegisteredData = array();
                            $arrMixPanelRegisteredData['username'] = $strFname;
                            $arrMixPanelRegisteredData['useremail'] = $strEmail;
                            $arrMixPanelRegisteredData['userid'] = $intLastCandidateInsertedId;
                            $arrMixPanelRegisteredData['portalname'] = $arrPortalDetail[0]['Portal']['career_portal_name'];
                            $arrMixPanelRegisteredData['registrationmethod'] = $strCandidateRegMethod;
                            $this->set('isRegistrationDone', "1");
                            $this->set('arrMixPanelUserRegData', $arrMixPanelRegisteredData);
                        }
                    }
                }
            }
        }
    }

    public function shop($intPortalId = "") {
        if ($intPortalId) {
            $arrShopDetails = array();
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);

            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            /* print("<pre>");
              print_r($arrMenuDetail); */
            $this->set('arrPortalMenuDetail', $arrMenuDetail);

            // courses detail
            $compLmsBridge = $this->Components->load('LmsBridge');
            $arrPaidCourseDetails = $compLmsBridge->fnGetPaypalEnrolledPortalCourses($arrPortalDetail['0']['Portal']['career_portal_id']);
            /* print("<pre>");
              print_r($arrPaidCourseDetails);
              exit; */
            if (isset($arrPaidCourseDetails) && (count($arrPaidCourseDetails) > 0)) {
                $arrShopDetails['E-learning'] = $arrPaidCourseDetails;
            }

            /* $compLmsBridge = $this->Components->load('LmsBridge');
              $arrWebinarsDetails = $compLmsBridge->fnGetPortalWebinars($arrPortalDetail['0']['Portal']['career_portal_id']);
              if(isset($arrPaidCourseDetails) && (count($arrPaidCourseDetails)>0))
              {
              $arrShopDetails['Webinars'] = $arrWebinarsDetails;
              } */
            /* print("<pre>");
              print_r($arrShopDetails); */

            $this->set('arrShopDetails', $arrShopDetails);
        }
    }

    public function forgotpassword($intPortalId = "") {

        if ($intPortalId) {
            $arrShopDetails = array();
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $this->set('arrPortalDetail', $arrPortalDetail);
            $this->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $this->set('intPortalId', $intPortalId);

            $this->loadModel('TopMenu');
            $arrMenuDetail = $this->TopMenu->find('all', array("order" => array('career_portal_menu_order' => 'ASC'), 'conditions' => array('career_portal_id' => $arrPortalDetail[0]['Portal']['career_portal_id'])));
            /* print("<pre>");
              print_r($arrMenuDetail); */
            $this->set('arrPortalMenuDetail', $arrMenuDetail);

            if ($this->request->is('post')) {
                $strCandidateEmail = addslashes(trim($this->request->data['User']['email']));
                $this->loadModel('Candidate');
                $arrCandidateExists = $this->Candidate->find('all', array('conditions' => array('candidate_email' => $strCandidateEmail, 'career_portal_id' => $intPortalId)));
                if (is_array($arrCandidateExists) && (count($arrCandidateExists) > 0)) {
                    $strNewPassword = $this->fnRegeneratePassword($arrCandidateExists[0]['Candidate']['candidate_id']);
                    $intMailSent = $this->fnSendPassowordRegenerationMail($arrCandidateExists[0]['Candidate']['candidate_username'], $strCandidateEmail, $strNewPassword);
                    if ($intMailSent) {
                        $boolUpdated = $this->Candidate->updateAll(
                                array('Candidate.candidate_password' => "'" . AuthComponent::password($strNewPassword) . "'"), array('Candidate.candidate_email =' => $strCandidateEmail, 'career_portal_id' => $intPortalId)
                        );
                        if ($boolUpdated) {
                            $this->Session->setFlash("Congratulation, your Password has been reset, Please check your Mail", 'default', array('class' => 'success'));
                        } else {
                            $this->Session->setFlash("Please try again.");
                        }
                    } else {
                        $this->Session->setFlash("Please try again.");
                    }
                } else {
                    $this->Session->setFlash("Sorry No Such Email id is registered with us.");
                }
            }
        }
    }

    public function getPayCardhtml($intPortalId) {
        if ($intPortalId) {

            $arrLoggedUser = $this->Auth->user();
            if ($this->request->is('Post')) {

                $arrTransactionInformation = array();
                $arrTransactionInformation['custoner_fname'] = $this->request->data['cust_fname'];
                $arrTransactionInformation['custoner_lname'] = $this->request->data['cust_lname'];
                $arrTransactionInformation['custoner_add'] = $this->request->data['cust_address'];
                $arrTransactionInformation['custoner_email'] = $arrLoggedUser['candidate_email'];
            }
            $this->loadModel('Portal');
            $arrPortalDetail = $this->Portal->find('all', array(
                'conditions' => array('career_portal_id' => $intPortalId)
            ));
            $view = new View($this, false);
            $view->set('arrPortalDetail', $arrPortalDetail);
            $view->set('strPortalName', strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
            $view->set('intPortalId', $intPortalId);
            $view->set('arrTransactionInformation', $arrTransactionInformation);




            $arrCustomerInformation = $this->Auth->user();

            $view->set('arrCustomerInformation', $arrCustomerInformation);

            $this->loadModel('Resourceorder');
            $arrContentDetail = $this->Resourceorder->find('all', array('conditions' => array('seeker_id' => $arrLoggedUser['candidate_id'], 'order_status' => 'initiated')));

            //print("<pre>");
            //print_r($arrContentDetail);

            $this->loadModel('Resourceorderdetail');
            if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {

                $intFrCnt = 0;
                foreach ($arrContentDetail as $arrOrder) {
                    $arrRContentDetail = $this->Resourceorderdetail->fnGetOrderDetail($arrOrder['Resourceorder']['resource_order_id']);
                    $arrContentDetail[$intFrCnt]['order_detail'] = $arrRContentDetail;
                    $intFrCnt++;
                }
            }

            //print("<pre>");
            //print_r($arrContentDetail);

            $view->set('arrContentDetail', $arrContentDetail);
            $view->set('addcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'add', $intPortalId), true));
            $view->set('strListcontactsurl', Router::url(array('controller' => 'jstcontacts', 'action' => 'index', $intPortalId), true));
            //$view->set('addcontactsurl',Router::url(array('controller'=>'jstcontacts','action'=>'add',$intPortalId),true));
            //$view->set('arrContactDetail',$arrContactDetail);
            $strWidgetListerHtml = $view->element('show_order_cust_card_info');
            $arrResponse['status'] = "success";
            $arrResponse['html'] = $strWidgetListerHtml;

            echo json_encode($arrResponse);
            exit;
        }
    }
    
    
}
