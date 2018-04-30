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
class ResourceController extends AppController {

    public $components = array('Paginator');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    public $layout = "admin";
    public $name = 'Resource';

    public function beforeFilter() {
        //$this->Auth->autoRedirect = false;
        parent::beforeFilter();
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     * 	or MissingViewException in debug mode.
     */
    public function preview($intPortalId = "", $intProductId = "") {
        $this->layout = "portalpreview";
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
            // load portal theme and its details
            $this->loadModel('PortalTheme');
            $arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPortalId);
            if (is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail) > 0)) {
                $this->set('arrPortalThemeDetail', $arrPortalThemeDetail);
            }
            $this->set('arrPortalMenuDetail', $arrMenuDetail);
            if ($intProductId) {
                $this->loadModel('Resources');
                $arrContentDetail = $this->Resources->find('all', array('conditions' => array('productd_id' => $intProductId)));
                if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {
                    if ($arrContentDetail[0]['Resources']['content_added']) {
                        $this->loadModel('Content');
                        $arrRContentDetail = $this->Content->find('all', array('conditions' => array('resource_id' => $intProductId)));

                        $this->loadModel('ResourcesImages');
                        $arrContentDetailImages = $this->ResourcesImages->find('all', array('conditions' => array('product_id' => $intProductId), 'limit' => '1'));

                        if (is_array($arrRContentDetail) && (count($arrRContentDetail) > 0)) {
                            $arrContentDetail[0]['Content'] = $arrRContentDetail[0]['Content'];
                            $arrContentDetail[0]['Resourceimages'] = $arrContentDetailImages[0]['ResourcesImages'];
                        }
                    }
                }
                $this->set('arrContentDetail', $arrContentDetail);
            }
        }
    }

    public function serviceimagedelete($intProductId) {
       
        $arrResponse = array();
        if ($intProductId) {

            $this->loadModel('ResourcesImages');
            $intCorrectProductId = $this->ResourcesImages->find('count', array('conditions' => array('product_images_id' => $intProductId)));
            if ($intCorrectProductId) {
                $intContentDeleted = $this->ResourcesImages->deleteAll(array('product_images_id' => $intProductId), false);
                if ($intContentDeleted) {

                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Service image has been deleted successfully', 'success');
                    $this->set('strMessage', $strMessage);

                    $arrResponse['status'] = "success";
                    $arrResponse['message'] = $strMessage;

                    echo json_encode($arrResponse);
                    exit;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again', 'error');
                    $this->set('strMessage', $strMessage);

                    $arrResponse['status'] = "fail";
                    $arrResponse['message'] = $strMessage;

                    echo json_encode($arrResponse);
                    exit;
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Service image does not exists', 'info');
                $this->set('strMessage', $strMessage);

                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;

                echo json_encode($arrResponse);
                exit;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Something is missing, Please try again', 'error');
            $this->set('strMessage', $strMessage);

            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;

            echo json_encode($arrResponse);
            exit;
        }
    }

    public function productdelete($intProductId) {
        $arrResponse = array();
        if ($intProductId) {

            $this->loadModel('Resources');
            $arrCorrectProductId = $this->Resources->find('all', array('conditions' => array('productd_id' => $intProductId)));
            if (is_array($arrCorrectProductId) && (count($arrCorrectProductId) > 0)) {
                $strResourceType = $arrCorrectProductId[0]['Resources']['product_type'];
                if ($strResourceType == "Course") {
                    $intLmsCourseId = $arrCorrectProductId[0]['Resources']['external_content_id'];
                    $compLms = $this->Components->load('LmsBridge');
                    $arrCourseCreated = $compLms->fnDeleteLmsCourse($intLmsCourseId);
                    if ($arrCourseCreated['status'] == "success") {
                        $intContentDeleted = $this->Resources->deleteAll(array('productd_id' => $intProductId), false);
                        if ($intContentDeleted) {
                            $this->loadModel('Content');
                            $boolCatAssigned = $this->Content->deleteAll(array('resource_id' => $intProductId), false);

                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Entry has been deleted successfully', 'success');
                            $this->set('strMessage', $strMessage);

                            $arrResponse['status'] = "success";
                            $arrResponse['message'] = $strMessage;

                            echo json_encode($arrResponse);
                            exit;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again', 'error');
                            $this->set('strMessage', $strMessage);

                            $arrResponse['status'] = "fail";
                            $arrResponse['message'] = $strMessage;

                            echo json_encode($arrResponse);
                            exit;
                        }
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again', 'error');
                        $this->set('strMessage', $strMessage);

                        $arrResponse['status'] = "fail";
                        $arrResponse['message'] = $strMessage;

                        echo json_encode($arrResponse);
                        exit;
                    }
                } else {
                    $intContentDeleted = $this->Resources->deleteAll(array('productd_id' => $intProductId), false);
                    if ($intContentDeleted) {
                        $this->loadModel('Content');
                        $boolCatAssigned = $this->Content->deleteAll(array('resource_id' => $intProductId), false);

                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Entry has been deleted successfully', 'success');
                        $this->set('strMessage', $strMessage);

                        $arrResponse['status'] = "success";
                        $arrResponse['message'] = $strMessage;

                        echo json_encode($arrResponse);
                        exit;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, Please try again', 'error');
                        $this->set('strMessage', $strMessage);

                        $arrResponse['status'] = "fail";
                        $arrResponse['message'] = $strMessage;

                        echo json_encode($arrResponse);
                        exit;
                    }
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Entry does not exists', 'info');
                $this->set('strMessage', $strMessage);

                $arrResponse['status'] = "fail";
                $arrResponse['message'] = $strMessage;

                echo json_encode($arrResponse);
                exit;
            }
        } else {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('Something is missing, Please try again', 'error');
            $this->set('strMessage', $strMessage);

            $arrResponse['status'] = "fail";
            $arrResponse['message'] = $strMessage;

            echo json_encode($arrResponse);
            exit;
        }
    }

    public function search($strKeywordSearch) {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/resource_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.widgets.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'resource', 'action' => 'index'), true));
        
        if($this->request->data['columnName'] == '' && $this->request->data['sort'] == ''){
            $url = $_SERVER['QUERY_STRING'];
            $Column_url = explode("Column=", $url);
            $ColumnName = explode("/", $Column_url[1]);
            $Sort_url = explode("Sort=", $url);
            $Sort = explode("&", $Sort_url[1]);
        }else{       
            $columnName = $this->request->data['columnName'];
            $sort = $this->request->data['sort'];
            $this->Session->write('productsearchcolumn',$columnName);
            $this->Session->write('productsearchsort',$sort);
            $this->Session->write('producttype','search');
        }
        
        if ($columnName !='' && $sort !='') {
            $arrResponse = array();
            $this->autoRender = false;
            // code to get the html content
            $view = new View($this, false); 
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'conditions' => array('product_name' => $strKeywordSearch,'product_type' => 'Services','column_name'=>$columnName,'order'=>$sort),
                'limit' => 20
            );

            $arrProductContentList = $this->Paginator->paginate('Resources');
            $view->set('arrProductList', $arrProductContentList);
            $strContactLocationHtml = $view->element('sort_services_list',array('column_name'=>$columnName,'sort'=>$sort,'strKeywordSearch'=>$strKeywordSearch));
            $strPaginationHtml = $view->element('sort_product_pagination',array('column_name'=>$columnName,'sort'=>$sort,'strKeywordSearch'=>$strKeywordSearch));
            if ($arrProductContentList) {
                $arrResponse['status'] = "success";
                $arrResponse['content'] = $strContactLocationHtml;
                $arrResponse['pagidiv'] = $strPaginationHtml;
                echo json_encode($arrResponse);
                exit;
            } else {
                $arrResponse['status'] = "fail";
                echo json_encode($arrResponse);
                exit;
            }
        }else{
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'Resources' => array(
                    'conditions' => array('product_name' => $strKeywordSearch, "product_type" => "Services",'column_name'=>$ColumnName[0],'order'=>$Sort[0]),
                    'limit' => 20,
                )
            );
            $arrProductContentList = $this->Paginator->paginate('Resources');
            $this->set('arrProductList', $arrProductContentList);
            $this->set('strKeywordSearch', $strKeywordSearch);
        }

        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no products with provided title', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function serviceimagessearch($strKeywordSearch) {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/serviceimage_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'resource', 'action' => 'index'), true));

        $this->loadModel('ResourcesImages');
        $this->ResourcesImages->recursive = 0;
        $this->Paginator->settings = array(
            'ResourcesImages' => array(
                'conditions' => array('product_image' => $strKeywordSearch),
                'limit' => 20,
            )
        );

        $arrProductContentList = $this->Paginator->paginate('ResourcesImages');
        /* print("<pre>");
          print_r($arrProductContentList);exit; */
        if (is_array($arrProductContentList) && (count($arrProductContentList) > 0)) {
            $intProductCount = 0;
            $this->loadModel('Resources');
            foreach ($arrProductContentList as $arrProductContent) {
                $isContentParent = $this->Resources->find('all', array('conditions' => array('productd_id' => $arrProductContent['product_images']['product_id'])));
                if (is_array($isContentParent) && (count($isContentParent) > 0)) {
                    $arrProductContentList[$intProductCount]['product_images']['service'] = $isContentParent[0]['Resources']['product_name'];
                }
                $intProductCount++;
            }
        }
        $this->set('arrProductList', $arrProductContentList);
        $this->set('strKeywordSearch', $strKeywordSearch);

        //$arrProductContentList = $this->Content->fnGetProductList();

        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no products with provided title', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function subcontentlist($intProductId = "") {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/product_index.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);

        $this->loadModel('Content');
        $arrProductSubpages = $this->Content->find('all', array('conditions' => array('content_parent_id' => $intProductId), 'order' => array('content_id' => 'ASC'),));

        $this->set('arrProductList', $arrProductSubpages);

        /* print("<pre>");
          print_r($arrProductSubpages);
          exit; */
    }

    public function serviceimages() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/serviceimage_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post') && ($this->request->data['filter_on'])) {
            $strProductFilterKeyword = $this->request->data['product_keyword'];

            $this->redirect(array('controller' => 'resource', 'action' => 'serviceimagessearch', $strProductFilterKeyword));
        }


        $this->loadModel('ResourcesImages');
        $this->ResourcesImages->recursive = 0;
        $this->Paginator->settings = array(
            'ResourcesImages' => array(
                'limit' => 20
            )
        );

        $arrProductContentList = $this->Paginator->paginate('ResourcesImages');
        //print("<pre>");
        //print_r($arrProductContentList);
        if (is_array($arrProductContentList) && (count($arrProductContentList) > 0)) {
            $intProductCount = 0;
            $this->loadModel('Resources');
            foreach ($arrProductContentList as $arrProductContent) {
                $isContentParent = $this->Resources->find('all', array('conditions' => array('productd_id' => $arrProductContent['product_images']['product_id'])));
                if (is_array($isContentParent) && (count($isContentParent) > 0)) {
                    $arrProductContentList[$intProductCount]['product_images']['service'] = $isContentParent[0]['Resources']['product_name'];
                }
                $intProductCount++;
            }
        }

        $this->set('arrProductList', $arrProductContentList);

        //$arrProductContentList = $this->Content->fnGetProductList();

        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no images present, Please upload one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function index() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/resource_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post') && ($this->request->data['filter_on'])) {
            $strProductFilterKeyword = $this->request->data['product_keyword'];
            $this->redirect(array('controller' => 'resource', 'action' => 'search', $strProductFilterKeyword));
        }
        
         if($this->request->data['columnName'] == '' && $this->request->data['sort'] == ''){
            $url = $_SERVER['QUERY_STRING'];
            $Column_url = explode("Column=", $url);
            $ColumnName = explode("/", $Column_url[1]);
            $Sort_url = explode("Sort=", $url);
            $Sort = explode("&", $Sort_url[1]);
        }else{       
            $columnName = $this->request->data['columnName'];
            $sort = $this->request->data['sort'];
            $this->Session->write('productcolumn',$columnName);
            $this->Session->write('productsort',$sort);
            $this->Session->write('type','index');
        }
    
        if ($columnName !='' && $sort !='') {
            $arrResponse = array();
            $this->autoRender = false;
            // code to get the html content
            $view = new View($this, false); 
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'conditions' => array('product_type' => 'Services','column_name'=>$columnName,'order'=>$sort),
                'limit' => 20
            );
            $arrProductContentList = $this->Paginator->paginate('Resources');
            $view->set('arrProductList', $arrProductContentList);
            $strContactLocationHtml = $view->element('sort_services_list',array('column_name'=>$columnName,'sort'=>$sort));
            $strPaginationHtml = $view->element('sort_product_pagination',array('column_name'=>$columnName,'sort'=>$sort));
            if ($arrProductContentList) {
                $arrResponse['status'] = "success";
                $arrResponse['content'] = $strContactLocationHtml;
                $arrResponse['pagidiv'] = $strPaginationHtml;
                $arrResponse['count'] = count($arrProductContentList);
                echo json_encode($arrResponse);
                exit;
            } else {
                $arrResponse['status'] = "fail";
                echo json_encode($arrResponse);
                exit;
            }
        }else{
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'Resources' => array(
                    'conditions' => array('product_type' => 'Services','column_name'=>$ColumnName[0],'order'=>$Sort[0]),
                    'limit' => 20,
                )
            );
            $arrProductContentList = $this->Paginator->paginate('Resources');
            $this->set('arrProductList', $arrProductContentList);
        }
        
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no resources present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }

    public function edit($intProductId = "") {
        if ($intProductId) {
            $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js') . '"></script>';

            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tmpl.min.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/load-image.all.min.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/canvas-to-blob.min.js') . '"></script>';
            //$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.iframe-transport.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-process.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-image.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-video.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js') . '"></script>';
            $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js') . '"></script>';
            //$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
            //$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
            $this->set('strActionScript', $strActionScript);
            $this->set('strDateFormat', Configure::read('Productdate.format'));


            $this->loadModel('Resources');
            //$arrProductContent = $this->Content->fnGetProduct($intProductId);
            $arrProductContent = $this->Resources->find('all', array('conditions' => array('productd_id' => $intProductId)));

            if (is_array($arrProductContent) && (count($arrProductContent) > 0)) {

                if ($arrProductContent[0]['Resources']['content_added']) {
                    $this->loadModel('Content');
                    $arrContentDetail = $this->Content->find('all', array('conditions' => array('resource_id' => $intProductId)));

                    if (is_array($arrContentDetail) && (count($arrContentDetail) > 0)) {
                        $arrProductContent[0]['Content'] = $arrContentDetail[0]['Content'];
                    }
                }
            }
            
            $this->loadModel('Resources');
            $arrResourcesDetails = $this->Resources->find('all', array('conditions' => array('product_type' => array('Services'), 'product_publish_status' => '1','product_parent'=>'')));
            
            $this->set('arrServicesDetails', $arrResourcesDetails);

            $this->set('arrProductContent', $arrProductContent);
            $this->set('intProductId', $intProductId);
        }
    }

    public function relatedproductlist($intEditContId = "", $intRelatedCategory = "") {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);
        $this->autoRender = false;

        $arrResponse = array();
        //$this->autoRender = false;
        $this->loadModel('Content');
        $arrConditions = array();
        $arrConditions['content_default_category'] = '4';
        if ($intRelatedCategory) {
            if ($intRelatedCategory == "99") {
                $arrConditions['content_default_category'] = array('99', '2', '1');
            } else {
                $arrConditions['content_default_category'] = $intRelatedCategory;
            }
        }
        if ($intEditContId) {
            $arrConditions['content_id !='] = $intEditContId;
        }

        $arrRelatedProductList = $this->Content->find('all', array('conditions' => $arrConditions));

        /* if($intEditContId)
          {
          //$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null,'content_id !='=>$intEditContId)));

          $arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_default_category'=>'4','content_id !='=>$intEditContId)));
          }
          else
          {
          //$arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
          $arrRelatedProductList = $this->Content->find('all',array('conditions'=>array('content_default_category'=>'4')));
          } */
        $view = new View($this, false);
        $view->set('arrRelatedProductList', $arrRelatedProductList);
        if (is_array($arrRelatedProductList) && (count($arrRelatedProductList) <= 0)) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no records for assignments', 'info');
            $view->set('strInfoMessage', $strMessage);
        }
        if ($strWidgetAssigned) {
            $strWidgetAssigned = rtrim($strWidgetAssigned, ",");
            $arrAssignedWidgets = explode(",", $strWidgetAssigned);
            $view->set('arrWidgetAssigned', $arrAssignedWidgets);
        } else {
            $view->set('arrWidgetAssigned', '');
        }
        $view->set('strMessage', '');
        $strWidgetListerHtml = $view->element('related_product_list');
        if ($strWidgetListerHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strWidgetListerHtml;
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Missing parameter";
            echo json_encode($arrResponse);
            exit;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function assignwidgetlist($strCategory = "", $strWidgetAssigned = "") {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);
        $this->autoRender = false;

        $arrResponse = array();
        //$this->autoRender = false;
        $this->loadModel('Widgets');
        if ($strCategory) {
            $arrWidgetList = $this->Widgets->find('all', array('conditions' => array('widget_category' => $strCategory)));
        } else {
            $arrWidgetList = $this->Widgets->find('all');
        }
        $view = new View($this, false);
        $view->set('arrWidgetList', $arrWidgetList);
        if ($strWidgetAssigned) {
            $strWidgetAssigned = rtrim($strWidgetAssigned, ",");
            $arrAssignedWidgets = explode(",", $strWidgetAssigned);
            $view->set('arrWidgetAssigned', $arrAssignedWidgets);
        } else {
            $view->set('arrWidgetAssigned', '');
        }
        $view->set('strMessage', '');
        $strWidgetListerHtml = $view->element('assign_widget_lister');
        if ($strWidgetListerHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strWidgetListerHtml;
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Missing parameter";
            echo json_encode($arrResponse);
            exit;
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function getcategories($intParentCatId = "", $strParentElementId = "", $intCurrentContId = "") {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);
        $arrResponse = array();
        $this->autoRender = false;
        if ($intParentCatId) {
            $this->loadModel('Categories');
            $arrSubCatList = $this->Categories->find('all', array('conditions' => array('content_category_parent_id' => $intParentCatId)));
            // code to get the html content
            $view = new View($this, false);

            $this->loadModel('CategoriesAssignment');
            $arrContentCatAssigned = $this->CategoriesAssignment->find('list', array('fields' => array('content_category_assig_id', 'category_id'), 'conditions' => array('content_id' => $intCurrentContId)));
            $view->set('arrCatAssigned', $arrContentCatAssigned);
            $view->set('arrSubCatList', $arrSubCatList);
            $view->set('strParentElementId', $strParentElementId);
            $strSubCatHtml = $view->element('content_subcat');
            if ($strSubCatHtml) {
                $arrResponse['status'] = "success";
                $arrResponse['content'] = $strSubCatHtml;
            } else {
                $arrResponse['status'] = "fail";
            }
            echo json_encode($arrResponse);
            exit;
        } else {
            $arrResponse['status'] = "fail";
            $arrResponse['message'] = "Missing parameter";
            echo json_encode($arrResponse);
            exit;
        }
    }

    public function filescontentlister() {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);

        $arrResponse = array();
        $this->autoRender = false;

        $this->loadModel('ContentMedia');
        $arrFilesList = $this->ContentMedia->find('all', array('conditions' => array('content_media_type ' => 'text/html')));
        // code to get the html content
        $view = new View($this, false);
        $view->set('arrFilesList', $arrFilesList);
        $strFilesListerHtml = $view->element('filescontentlister', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strFilesListerHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strFilesListerHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function fileslister() {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);

        $arrResponse = array();
        $this->autoRender = false;

        $this->loadModel('ContentMedia');
        $arrFilesList = $this->ContentMedia->find('all', array('conditions' => array('content_media_type ' => 'application/pdf')));
        // code to get the html content
        $view = new View($this, false);
        $view->set('arrFilesList', $arrFilesList);
        $strFilesListerHtml = $view->element('fileslister', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strFilesListerHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strFilesListerHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function medialister() {
        $strActionScript = '';
        $this->set('strActionScript', $strActionScript);

        $arrResponse = array();
        $this->autoRender = false;

        $this->loadModel('ContentMedia');
        $arrMediaList = $this->ContentMedia->find('all', array('conditions' => array('OR' => array(array('content_media_type' => 'image/png'), array('content_media_type' => 'image/jpeg'), array('content_media_type' => 'image/jpg'), array('content_media_type' => 'image/gif'), array('content_media_type' => 'audio/mpeg'), array('content_media_type' => 'application/pdf'))), 'ORDER' => array('content_media_id' => 'ASC')));
        /* print("<pre>");
          print_r($arrMediaList);
          exit; */
        // code to get the html content
        $view = new View($this, false);
        $view->set('arrMediaList', $arrMediaList);
        $strMediaListerHtml = $view->element('medialister', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strMediaListerHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strMediaListerHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function updatecontactlocationinfo() {
        $arrResponseData = array();
        if ($this->request->is('Post')) {


            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['ContentLocation']['content_product_contact_form_location'] = $this->request->data['contact_location_name'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_address'] = htmlspecialchars(addslashes($this->request->data['contact_location_address']));
            $arrContentData['ContentLocation']['content_product_contact_form_title'] = $this->request->data['contact_location_form_title'];
            $arrContentData['ContentLocation']['content_product_contact_form_name'] = $this->request->data['contact_location_form_url'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'] = $this->request->data['contact_lcoation_to'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'] = $this->request->data['location_contact_cc'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc'] = $this->request->data['location_contact_bcc'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'] = $this->request->data['contact_location_subject'];
            $arrContentData['ContentLocation']['content_id'] = $intContentId = $this->request->data['content_id'];
            $intLocationId = $this->request->data['update_location_id'];
            //print('<pre>');
            //print_r($arrContentData);
            //exit;
            if ($intLocationId) {
                $this->loadModel('ContentLocation');
                /* $this->Content->set($arrContentData);
                  if($this->Content->validates())
                  { */
                $isLocationDetailPresent = $this->ContentLocation->find('count', array('conditions' => array('content_product_contact_form_id' => $intLocationId)));
                if ($isLocationDetailPresent) {
                    $boolContentLocationUpdated = $this->ContentLocation->updateAll(
                            array('content_product_contact_form_title' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_title'] . "'", 'content_product_contact_form_name' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_name'] . "'", 'content_product_contact_form_location' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location'] . "'", 'content_product_contact_form_location_address' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location_address'] . "'", 'content_product_contact_form_location_mail_to' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'] . "'", 'content_product_contact_form_location_mail_cc' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'] . "'", 'content_product_contact_form_location_mail_bcc' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc'] . "'", 'content_product_contact_form_location_mail_subject' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'] . "'"), array('content_product_contact_form_id =' => $intLocationId)
                    );
                    if ($boolContentLocationUpdated) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                } else {
                    $boolContentLocationSaved = $this->ContentLocation->save($arrContentData);
                    if ($boolContentLocationSaved) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                        $arrResponseData ['createdid'] = $this->ContentLocation->getLastInsertID();
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                }
                /* }
                  else
                  {
                  $strContentCreationErrorMessage = "<br>";
                  $arrContentCreationErrors = $this->Content->invalidFields();
                  if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
                  {
                  $intForIterateCount = 0;
                  foreach($arrContentCreationErrors as $errorVal)
                  {
                  $intForIterateCount++;
                  if($intForIterateCount == 1)
                  {
                  $strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
                  }
                  else
                  {
                  $strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
                  }
                  }
                  }
                  if($strContentCreationErrorMessage)
                  {
                  $compMessage = $this->Components->load('Message');
                  $strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
                  }
                  $arrResponseData['status'] = "fail";
                  $arrResponseData['message'] = $strMessage;
                  } */
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
        echo json_encode($arrResponseData);
        exit;
    }

    public function deletecontactlocation($intLocationId) {
        $arrResponseData = array();
        if ($intLocationId) {
            $this->loadModel('ContentLocation');
            $isLocationDetailPresent = $this->ContentLocation->find('count', array('conditions' => array('content_product_contact_form_id' => $intLocationId)));
            if ($isLocationDetailPresent) {
                $intLocationDeleted = $this->ContentLocation->deleteAll(array('content_product_contact_form_id' => $intLocationId), false);
                if ($intLocationDeleted) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Location deleted Successfully', 'success');
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

    public function setcontactlocationinfo() {
        if ($this->request->is('Post')) {


            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['ContentLocation']['content_product_contact_form_title'] = $this->request->data['contact_location_form_title'];
            $arrContentData['ContentLocation']['content_product_contact_form_name'] = $this->request->data['contact_location_form_url'];
            $arrContentData['ContentLocation']['content_product_contact_form_location'] = $this->request->data['contact_location_name'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_address'] = htmlspecialchars(addslashes($this->request->data['contact_location_address']));

            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'] = $this->request->data['contact_lcoation_to'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'] = $this->request->data['location_contact_cc'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_bcc'] = $this->request->data['location_contact_bcc'];
            $arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'] = $this->request->data['contact_location_subject'];
            $arrContentData['ContentLocation']['content_id'] = $intContentId = $this->request->data['content_id'];
            /* print('<pre>');
              print_r($arrContentData);
              exit; */
            if ($intContentId) {
                $this->loadModel('ContentLocation');
                /* $this->Content->set($arrContentData);
                  if($this->Content->validates())
                  { */
                $isLocationDetailPresent = $this->ContentLocation->find('count', array('conditions' => array('content_id' => $intContentId, 'content_product_contact_form_location_mail_to' => $arrContentData['ContentLocation']['content_product_contact_form_location'], 'content_product_contact_form_location_mail_to' => $arrContentData['ContentLocation']['content_product_contact_form_location_mail_to'], 'content_product_contact_form_location_mail_cc' => $arrContentData['ContentLocation']['content_product_contact_form_location_mail_cc'], 'content_product_contact_form_location_mail_subject' => $arrContentData['ContentLocation']['content_product_contact_form_location_mail_subject'])));
                if ($isLocationDetailPresent) {
                    $boolContentLocationUpdated = $this->ContentLocation->updateAll(
                            array('content_product_contact_form_title' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_title'] . "'", 'content_product_contact_form_name' => "'" . $arrContentData['ContentLocation']['content_product_contact_form_name'] . "'", 'cont_contact_to' => "'" . $arrContentData['ContentLocation']['cont_contact_to'] . "'", 'cont_contact_cc' => "'" . $arrContentData['ContentLocation']['cont_contact_cc'] . "'", 'cont_contact_subject' => "'" . $arrContentData['ContentLocation']['cont_contact_subject'] . "'"), array('content_id =' => $intContentId)
                    );
                    if ($boolContentLocationUpdated) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                } else {
                    $boolContentLocationSaved = $this->ContentLocation->save($arrContentData);
                    if ($boolContentLocationSaved) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Contact location saved successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                        $arrResponseData ['createdid'] = $this->ContentLocation->getLastInsertID();
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                }
                /* }
                  else
                  {
                  $strContentCreationErrorMessage = "<br>";
                  $arrContentCreationErrors = $this->Content->invalidFields();
                  if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
                  {
                  $intForIterateCount = 0;
                  foreach($arrContentCreationErrors as $errorVal)
                  {
                  $intForIterateCount++;
                  if($intForIterateCount == 1)
                  {
                  $strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
                  }
                  else
                  {
                  $strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
                  }
                  }
                  }
                  if($strContentCreationErrorMessage)
                  {
                  $compMessage = $this->Components->load('Message');
                  $strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
                  }
                  $arrResponseData['status'] = "fail";
                  $arrResponseData['message'] = $strMessage;
                  } */
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function setcontactinfo() {
        if ($this->request->is('Post')) {
            /* print('<pre>');
              print_r($this->request->data);
              exit; */

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['Content']['content_contact_form_title'] = $this->request->data['contact_form_title'];
            $arrContentData['Content']['content_contact_form_name'] = $this->request->data['contact_form_url'];
            $arrContentData['Content']['cont_contact_to'] = $this->request->data['contact_to'];
            $arrContentData['Content']['cont_contact_cc'] = $this->request->data['contact_cc'];
            $arrContentData['Content']['cont_contact_bcc'] = $this->request->data['contact_bcc'];
            $arrContentData['Content']['cont_contact_subject'] = $this->request->data['contact_subject'];
            $arrContentData['Content']['contact_address'] = $this->request->data['contact_address'];
            $intContentId = $this->request->data['content_id'];

            if ($intContentId) {
                $this->loadModel('Content');
                /* $this->Content->set($arrContentData);
                  if($this->Content->validates())
                  { */
                $boolContentUpdated = $this->Content->updateAll(
                        array('content_contact_form_title' => "'" . $arrContentData['Content']['content_contact_form_title'] . "'", 'content_contact_form_name' => "'" . $arrContentData['Content']['content_contact_form_name'] . "'", 'cont_contact_to' => "'" . $arrContentData['Content']['cont_contact_to'] . "'", 'cont_contact_cc' => "'" . $arrContentData['Content']['cont_contact_cc'] . "'", 'cont_contact_bcc' => "'" . $arrContentData['Content']['cont_contact_bcc'] . "'", 'cont_contact_subject' => "'" . $arrContentData['Content']['cont_contact_subject'] . "'", 'contact_address' => "'" . $arrContentData['Content']['contact_address'] . "'"), array('content_id =' => $intContentId)
                );

                if ($boolContentUpdated) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Content location saved successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
                /* }
                  else
                  {
                  $strContentCreationErrorMessage = "<br>";
                  $arrContentCreationErrors = $this->Content->invalidFields();
                  if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
                  {
                  $intForIterateCount = 0;
                  foreach($arrContentCreationErrors as $errorVal)
                  {
                  $intForIterateCount++;
                  if($intForIterateCount == 1)
                  {
                  $strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
                  }
                  else
                  {
                  $strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
                  }
                  }
                  }
                  if($strContentCreationErrorMessage)
                  {
                  $compMessage = $this->Components->load('Message');
                  $strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
                  }
                  $arrResponseData['status'] = "fail";
                  $arrResponseData['message'] = $strMessage;
                  } */
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function setcategory() {
        if ($this->request->is('Post')) {
            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $strCategories = rtrim($this->request->data['maincategoryselected'], ",");
            $strDefaultCategory = $this->request->data['defaultcategory'];
            $strCategory_for = $this->request->data['category_for'];
            $intProductId = $this->request->data['product_id'];
            
            if ($intProductId != '') {
                $this->loadModel('CategoriesAssignment');
                if ($strCategories) {
                    $arrCategories = explode(",", $strCategories);
                    //$arrCategories[] = $strDefaultCategory;
                    $arrCategories = array_unique($arrCategories);
                    /* print("<pre>");
                      print_r($arrCategories);
                      exit; */

                    $boolSaveFlag = "0";
                    if (is_array($arrCategories) && (count($arrCategories) > 0)) {
                        //$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>'4'),false);
                        $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('product_id' => $intProductId), false);

                        foreach ($arrCategories as $arrCat) {
                            $isCatPresentForContent = $this->CategoriesAssignment->find('count', array('conditions' => array('product_id' => $intProductId, 'category_id' => $arrCat)));
                            if ($isCatPresentForContent) {
                                continue;
                            } else {
                                $arrCategoryData = array();
                                $arrCategoryData['CategoriesAssignment']['category_id'] = $arrCat;
                                $arrCategoryData['CategoriesAssignment']['product_id'] = $intProductId;
                                $arrCategoryData['CategoriesAssignment']['category_for'] = '1';

                                $this->CategoriesAssignment->create(false);
                                $boolCatAssigned = $this->CategoriesAssignment->save($arrCategoryData);
                                if ($boolCatAssigned) {
                                    $boolSaveFlag = "1";
                                }
                            }
                        }
                        if ($boolSaveFlag == "1") {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Categories assigned successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    } else {
                        $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('product_id' => $intProductId), false);
                        if ($intAssignedCategoryDeleted) {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    }
                } else {
                    //echo $strDefaultCategory;exit;
                    //$intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('content_id' => $intContentId,'category_id !='=>"'".$strDefaultCategory."'"),false);
                    //$intAssignedCategoryDeleted = $this->CategoriesAssignment->fnClearCategories($intContentId,$strDefaultCategory);
                    $intAssignedCategoryDeleted = $this->CategoriesAssignment->deleteAll(array('product_id' => $intProductId), false);
                    if ($intAssignedCategoryDeleted) {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Categories recorded successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function subcatcontent() {
        if ($this->request->is('Post')) {
            //print('<pre>');
            //print_r($this->request->data);
            //exit;

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['Categories']['content_category_parent_id'] = $this->request->data['content_parent_cat'];
            $intCurrentParentId = $this->request->data['current_parent_cat_id'];
            $intContentId = $this->request->data['content_id'];

            if ($intContentId) {
                $this->loadModel('Categories');
                /* $isParent = $this->Categories->find('count',array('conditions'=>array('content_category_id'=>$intContentId,'content_category_parent_id'=>'0')));
                  echo "--".$isParent;
                  exit;
                  if($isParent)
                  {
                  $compMessage = $this->Components->load('Message');
                  $strMessage = $compMessage->fnGenerateMessageBlock('Main Category cannot be assigned as subcategory','info');
                  $arrResponseData ['status'] = "fail";
                  $arrResponseData ['message'] = $strMessage;
                  }
                  else
                  { */
                if ($arrContentData['Categories']['content_category_parent_id']) {
                    /* $this->Content->set($arrContentData);
                      if($this->Content->validates())
                      { */
                    $boolContentUpdated = $this->Categories->updateAll(
                            array('content_category_parent_id' => "'" . $arrContentData['Categories']['content_category_parent_id'] . "'"), array('content_category_id =' => $intContentId)
                    );

                    if ($boolContentUpdated) {
                        $intSubChildCount = $this->Categories->find('count', array('conditions' => array('content_category_parent_id' => $arrContentData['Categories']['content_category_parent_id'])));

                        $isParentUpdate = $this->Categories->updateAll(
                                array('content_category_has_child' => "'1'", "no_of_childs" => $intSubChildCount), array('content_category_id =' => $arrContentData['Categories']['content_category_parent_id'])
                        );




                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Category set as sub category successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                        $arrResponseData ['status'] = "fail";
                        $arrResponseData ['message'] = $strMessage;
                    }
                    /* }
                      else
                      {
                      $strContentCreationErrorMessage = "<br>";
                      $arrContentCreationErrors = $this->Content->invalidFields();
                      if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
                      {
                      $intForIterateCount = 0;
                      foreach($arrContentCreationErrors as $errorVal)
                      {
                      $intForIterateCount++;
                      if($intForIterateCount == 1)
                      {
                      $strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
                      }
                      else
                      {
                      $strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
                      }
                      }
                      }
                      if($strContentCreationErrorMessage)
                      {
                      $compMessage = $this->Components->load('Message');
                      $strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
                      }
                      $arrResponseData['status'] = "fail";
                      $arrResponseData['message'] = $strMessage;
                      } */
                } else {
                    if ($intCurrentParentId) {
                        $boolContentUpdated = $this->Categories->updateAll(
                                array('content_category_parent_id' => '0'), array('content_category_id =' => $intContentId)
                        );

                        if ($boolContentUpdated) {
                            $intParentCount = $this->Categories->find('count', array('conditions' => array('content_category_parent_id' => $intCurrentParentId)));
                            if (!$intParentCount) {
                                $boolContentParentUpdated = $this->Categories->updateAll(
                                        array('content_category_has_child' => '0'), array('content_category_id =' => $intCurrentParentId)
                                );
                            }
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Sub category set successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Something is missing before saving', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Sub category set successfully', 'success');
                        $arrResponseData ['status'] = "success";
                        $arrResponseData ['message'] = $strMessage;
                    }
                }
                //}
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Category missing, please add category first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function subcontent() {
        if ($this->request->is('Post')) {
            /* print('<pre>');
              print_r($this->request->data);
              exit; */

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['Content']['content_parent_id'] = $this->request->data['content_parent'];
            $intCurrentParentId = $this->request->data['current_parent_id'];
            $intContentId = $this->request->data['content_id'];

            if ($intContentId) {
                $this->loadModel('Content');
                $isParent = $this->Content->find('count', array('conditions' => array('content_parent_id' => $intContentId)));
                if ($isParent) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Main product cannot be assigned as subcontent', 'info');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    if ($arrContentData['Content']['content_parent_id']) {
                        /* $this->Content->set($arrContentData);
                          if($this->Content->validates())
                          { */
                        $boolContentUpdated = $this->Content->updateAll(
                                array('content_parent_id' => "'" . $arrContentData['Content']['content_parent_id'] . "'"), array('content_id =' => $intContentId)
                        );

                        if ($boolContentUpdated) {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Content set as sub content successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                            $arrResponseData ['status'] = "fail";
                            $arrResponseData ['message'] = $strMessage;
                        }
                        /* }
                          else
                          {
                          $strContentCreationErrorMessage = "<br>";
                          $arrContentCreationErrors = $this->Content->invalidFields();
                          if(is_array($arrContentCreationErrors) && (count($arrContentCreationErrors)>0))
                          {
                          $intForIterateCount = 0;
                          foreach($arrContentCreationErrors as $errorVal)
                          {
                          $intForIterateCount++;
                          if($intForIterateCount == 1)
                          {
                          $strContentCreationErrorMessage .= "Error: ".$errorVal['0'];
                          }
                          else
                          {
                          $strContentCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
                          }
                          }
                          }
                          if($strContentCreationErrorMessage)
                          {
                          $compMessage = $this->Components->load('Message');
                          $strMessage = $compMessage->fnGenerateMessageBlock($strContentCreationErrorMessage,'error');
                          }
                          $arrResponseData['status'] = "fail";
                          $arrResponseData['message'] = $strMessage;
                          } */
                    } else {
                        if ($intCurrentParentId) {
                            $boolContentUpdated = $this->Content->updateAll(
                                    array('content_parent_id' => NULL), array('content_id =' => $intContentId)
                            );

                            if ($boolContentUpdated) {
                                $compMessage = $this->Components->load('Message');
                                $strMessage = $compMessage->fnGenerateMessageBlock('Sub content set successfully', 'success');
                                $arrResponseData ['status'] = "success";
                                $arrResponseData ['message'] = $strMessage;
                            } else {
                                $compMessage = $this->Components->load('Message');
                                $strMessage = $compMessage->fnGenerateMessageBlock('Something is missing before saving', 'error');
                                $arrResponseData ['status'] = "fail";
                                $arrResponseData ['message'] = $strMessage;
                            }
                        } else {
                            $compMessage = $this->Components->load('Message');
                            $strMessage = $compMessage->fnGenerateMessageBlock('Sub content set successfully', 'success');
                            $arrResponseData ['status'] = "success";
                            $arrResponseData ['message'] = $strMessage;
                        }
                    }
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function featured() {
        if ($this->request->is('Post')) {

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();


            $arrContentData['Content']['content_is_featured'] = "0";


            if ($this->request->data['is_featured']) {
                $arrContentData['Content']['content_is_featured'] = "1";
            }
            $intContentId = $this->request->data['content_id'];
            $arrContentOtherData['ContentOther']['content_featured_image'] = $this->request->data['featured_image_id'];

            if ($intContentId) {
                $this->loadModel('Content');
                $boolContentUpdated = $this->Content->updateAll(
                        array('content_is_featured' => "'" . $arrContentData['Content']['content_is_featured'] . "'", 'content_featured_image' => "'" . $arrContentOtherData['ContentOther']['content_featured_image'] . "'"), array('content_id =' => $intContentId)
                );

                if ($boolContentUpdated) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Content set as featured successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function other() {
        if ($this->request->is('Post')) {
            /* print('<pre>');
              print_r($this->request->data);
              exit; */

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['Content']['content_is_branded'] = $this->request->data['is_branded'];
            $arrContentData['ContentOther']['content_brand_title'] = $this->request->data['brand_title'];
            $arrContentData['ContentOther']['content_brand_description'] = $this->request->data['brand_description'];
            $arrContentOtherData['ContentOther']['content_website'] = $this->request->data['content_website'];
            $intContentId = $this->request->data['content_id'];
            $arrContentOtherData['ContentOther']['content_product_highlight_text'] = htmlspecialchars(addslashes($this->request->data['content_highlight']));
            $arrContentOtherData['ContentOther']['content_product_download_text'] = htmlspecialchars(addslashes($this->request->data['content_download']));
            $arrContentOtherData['ContentOther']['content_id'] = $intContentId;
            $arrContentOtherData['ContentOther']['content_product_other_details_id'] = $intContentOtherId = $this->request->data['content_other_id'];

            if ($intContentId) {
                $this->loadModel('Content');
                if ($arrContentData['Content']['content_is_branded']) {
                    $boolContentUpdated = $this->Content->updateAll(
                            array('content_is_branded' => "'1'"), array('content_id =' => $intContentId)
                    );
                } else {
                    $boolContentUpdated = $this->Content->updateAll(
                            array('content_is_branded' => "'0'"), array('content_id =' => $intContentId)
                    );
                }

                $this->loadModel('ContentOther');
                if ($intContentOtherId) {
                    // update
                    $boolContentOther = $this->ContentOther->updateAll(
                            array('content_id' => $intContentId, 'content_brand_description' => "'" . $arrContentData['ContentOther']['content_brand_description'] . "'", 'content_brand_title' => "'" . $arrContentData['ContentOther']['content_brand_title'] . "'", 'content_product_highlight_text' => "'" . $arrContentOtherData['ContentOther']['content_product_highlight_text'] . "'", 'content_website' => "'" . $arrContentOtherData['ContentOther']['content_website'] . "'", 'content_product_download_text' => "'" . $arrContentOtherData['ContentOther']['content_product_download_text'] . "'"), array('content_product_other_details_id =' => $intContentOtherId)
                    );
                } else {
                    // insert
                    $intOtherExists = $this->ContentOther->find('count', array('conditions' => array('content_id' => $intContentId)));
                    if ($intOtherExists) {
                        $boolContentOther = $this->ContentOther->updateAll(
                                array('content_brand_description' => "'" . $arrContentData['ContentOther']['content_brand_description'] . "'", 'content_brand_title' => "'" . $arrContentData['ContentOther']['content_brand_title'] . "'", 'content_product_highlight_text' => "'" . $arrContentOtherData['ContentOther']['content_product_highlight_text'] . "'", 'content_product_download_text' => "'" . $arrContentOtherData['ContentOther']['content_product_download_text'] . "'", 'content_website' => "'" . $arrContentOtherData['ContentOther']['content_website'] . "'"), array('content_id =' => $intContentId)
                        );
                    } else {
                        $boolContentOther = $this->ContentOther->save($arrContentOtherData);
                    }
                }
                if ($boolContentOther) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Other Detail recorded successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function otheraff() {
        if ($this->request->is('Post')) {
            /* print('<pre>');
              print_r($this->request->data);
              exit; */

            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();

            $arrContentData['Content']['content_featured_image'] = $this->request->data['featured_image_id'];
            $intContentId = $this->request->data['content_id'];
            $arrContentOtherData['ContentOther']['content_phone_no'] = addslashes($this->request->data['content_phone_no']);
            $arrContentOtherData['ContentOther']['content_fax_no'] = addslashes($this->request->data['content_fax_no']);
            $arrContentOtherData['ContentOther']['content_website'] = addslashes($this->request->data['content_website']);
            $arrContentOtherData['ContentOther']['content_address'] = htmlspecialchars(addslashes($this->request->data['content_address']));
            $arrContentOtherData['ContentOther']['content_id'] = $intContentId;
            $arrContentOtherData['ContentOther']['content_product_other_details_id'] = $intContentOtherId = $this->request->data['content_other_id'];

            if ($intContentId) {
                $this->loadModel('Content');
                if ($arrContentData['Content']['content_featured_image']) {
                    $boolContentUpdated = $this->Content->updateAll(
                            array('content_featured_image' => "'" . $arrContentData['Content']['content_featured_image'] . "'"), array('content_id =' => $intContentId)
                    );
                } else {
                    $boolContentUpdated = $this->Content->updateAll(
                            array('content_featured_image' => NULL), array('content_id =' => $intContentId)
                    );
                }

                $this->loadModel('ContentOther');
                if ($intContentOtherId) {
                    // update
                    $boolContentOther = $this->ContentOther->updateAll(
                            array('content_id' => $intContentId, 'content_phone_no' => "'" . $arrContentOtherData['ContentOther']['content_phone_no'] . "'", 'content_fax_no' => "'" . $arrContentOtherData['ContentOther']['content_fax_no'] . "'", 'content_website' => "'" . $arrContentOtherData['ContentOther']['content_website'] . "'", 'content_address' => "'" . $arrContentOtherData['ContentOther']['content_address'] . "'"), array('content_product_other_details_id =' => $intContentOtherId)
                    );
                } else {
                    // insert
                    $intOtherExists = $this->ContentOther->find('count', array('conditions' => array('content_id' => $intContentId)));
                    if ($intOtherExists) {
                        $boolContentOther = $this->ContentOther->updateAll(
                                array('content_phone_no' => "'" . $arrContentOtherData['ContentOther']['content_phone_no'] . "'", 'content_fax_no' => "'" . $arrContentOtherData['ContentOther']['content_fax_no'] . "'", 'content_website' => "'" . $arrContentOtherData['ContentOther']['content_website'] . "'", 'content_address' => "'" . $arrContentOtherData['ContentOther']['content_address'] . "'"), array('content_id =' => $intContentId)
                        );
                    } else {
                        $boolContentOther = $this->ContentOther->save($arrContentOtherData);
                    }
                }
                if ($boolContentOther) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Other Detail recorded successfully', 'success');
                    $arrResponseData ['status'] = "success";
                    $arrResponseData ['message'] = $strMessage;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some error, please try again', 'error');
                    $arrResponseData ['status'] = "fail";
                    $arrResponseData ['message'] = $strMessage;
                }
            } else {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('Content missing, please add content first before saving this', 'error');
                $arrResponseData ['status'] = "fail";
                $arrResponseData ['message'] = $strMessage;
            }
            echo json_encode($arrResponseData);
            exit;
        }
    }

    public function addimagemore() {
        $this->autoRender = false;
        $this->layout = NULL;
        $arrLoggedUser = $this->Auth->user();
        $arrResponse = array();
        $compMessage = $this->Components->load('Message');
        if ($this->request->is('Post')) {
            $this->loadModel('ResourcesImages');
            $arrContentOtherData = array();
            $arrContentData = array();
            $arrResponseData = array();
            $intImageId = $this->request->data['featured_image_id'];
            $arrContentData['ResourcesImages']['product_image_status'] = "active";
            $intEImageId = $this->request->data['image_id'];
            if ($intEImageId) {
                $this->ResourcesImages->deleteAll(array('product_images_id' => $intEImageId), false);
            }

            $boolContentOther = $this->ResourcesImages->updateAll(
                    array('product_image_status' => "'" . $arrContentData['ResourcesImages']['product_image_status'] . "'"), array('product_images_id =' => $intImageId)
            );

            if ($boolContentOther) {

                $strMessage = $compMessage->fnGenerateMessageBlock('Your image has been saved successfully.', 'success');

                $arrResponse['status'] = 'success';
                $arrResponse['message'] = $strMessage;
            } else {

                $strMessage = $compMessage->fnGenerateMessageBlock('Some Error, Please try again', 'error');
                $arrResponse['status'] = 'fail';
                $arrResponse['message'] = $strMessage;
            }
        } else {
            $strMessage = $compMessage->fnGenerateMessageBlock('Some Error, Please try again', 'error');
            $arrResponse['status'] = 'fail';
            $arrResponse['message'] = $strMessage;
        }

        echo json_encode($arrResponse);
        exit;
    }

    public function editimage($intImageId = "") {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js') . '"></script>';

        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tmpl.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/load-image.all.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/canvas-to-blob.min.js') . '"></script>';
        //$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.iframe-transport.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-process.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-image.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-video.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js') . '"></script>';
        //$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
        //$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('Resources');
        $arrResourceList = $this->Resources->find('all', array('conditions' => array('product_publish_status' => "1"),'order'=>array('product_name'=>'ASC')));
        $this->set('arrResourceList', $arrResourceList);

        $this->loadModel('ResourcesImages');
        $arrResourceImageList = $this->ResourcesImages->find('all', array('conditions' => array('product_images_id' => $intImageId)));
        $this->set('arrResourceImageList', $arrResourceImageList);

        $this->set('strDateFormat', Configure::read('Productdate.format'));
        $this->set('intImageId', $intImageId);
        //print("<pre>");
        //print_r($arrResourceImageList);
        //exit;
    }

    public function addimage() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js') . '"></script>';

        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tmpl.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/load-image.all.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/canvas-to-blob.min.js') . '"></script>';
        //$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.iframe-transport.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-process.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-image.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-video.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js') . '"></script>';
        //$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
        //$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
        $this->set('strActionScript', $strActionScript);
        $this->loadModel('Resources');
        $arrResourceList = $this->Resources->find('all', array('conditions' => array('product_publish_status' => "1"),'order'=>array('product_name'=>'ASC')));
        $this->set('arrResourceList', $arrResourceList);

        $this->set('strDateFormat', Configure::read('Productdate.format'));

        if ($this->request->is('Post')) {
            /* print('<pre>');
              print_r($this->request->data);
              exit; */

            //echo "HI";exit;

            $arrResponseData = array();
            $intEditModeId = "";
            $arrContentData = array();
            $strRequestFor = $this->request->data['content_request_for'];
            $strDefaultCate = '0';
            if ($this->request->data['content_request_for_id']) {
                $strDefaultCate = $this->request->data['content_request_for_id'];
            }
            $arrContentData['Content']['content_title'] = htmlspecialchars(addslashes($this->request->data['content_title']));
            $arrContentData['Content']['content_title_alias'] = htmlspecialchars(addslashes($this->request->data['content_title_alias']));
            $arrContentData['Content']['content_name'] = addslashes($this->request->data['content_name']);
            $arrContentData['Content']['content_default_category'] = $strDefaultCate;
            $arrContentData['Content']['content_intro_text'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
            $arrContentData['Content']['content'] = htmlspecialchars(addslashes($this->request->data['main_content']));
            $arrContentData['Content']['content_type'] = "1";
            $arrContentData['Content']['content_for_user'] = "4";
            $arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s', strtotime($this->request->data['content_pub_date']));
            $intEditModeId = $this->request->data['content_edit_id'];

            $arrContentData['Resources']['product_name'] = $this->request->data['service_name'];
            $arrContentData['Resources']['product_cost'] = $this->request->data['service_cost'];
            $arrContentData['Resources']['product_type'] = "Services";
            if ($this->request->data['to_publish']) {
                $arrContentData['Resources']['product_publish_status'] = "1";
                $arrContentData['Content']['content_status'] = "published";
            } else {
                $arrContentData['Resources']['product_publish_status'] = null;
                $arrContentData['Content']['content_status'] = null;
            }

            $this->loadModel('Resources');
            if ($intEditModeId) {
                $boolContentUpdated = $this->Resources->updateAll(
                        array('product_name' => "'" . $arrContentData['Resources']['product_name'] . "'", 'product_publish_status' => "'" . $arrContentData['Resources']['product_publish_status'] . "'", 'product_type' => "'" . $arrContentData['Resources']['product_type'] . "'", 'product_cost' => "'" . $arrContentData['Resources']['product_cost'] . "'"), array('productd_id =' => $intEditModeId)
                );
                if ($boolContentUpdated) {
                    $compMessage = $this->Components->load('Message');
                    $strForMessage = "Updation was successfull.";
                    $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                    $arrResponseData['status'] = 'success';
                    $arrResponseData['message'] = $strMessage;
                    $isContentAdded = "0";
                    if ($arrContentData['Content']['content'] || $arrContentData['Content']['content_intro_text']) {
                        $this->loadModel('Content');
                        $boolContentUpdated = $this->Content->updateAll(
                                array('content_default_category' => "'" . $arrContentData['Content']['content_default_category'] . "'", 'content_title_alias' => "'" . $arrContentData['Content']['content_title_alias'] . "'", 'content_title' => "'" . $arrContentData['Content']['content_title'] . "'", 'content_name' => "'" . $arrContentData['Content']['content_name'] . "'", 'content_intro_text' => "'" . $arrContentData['Content']['content_intro_text'] . "'", 'content' => "'" . $arrContentData['Content']['content'] . "'", 'content_status' => "'" . $arrContentData['Content']['content_status'] . "'", 'content_type' => "'" . $arrContentData['Content']['content_type'] . "'"), array('resource_id =' => $intEditModeId)
                        );

                        if ($boolContentUpdated) {
                            $isContentAdded = "1";
                        }
                    } else {
                        $this->loadModel('Content');
                        $isDeleted = $this->Content->deleteAll(array('resource_id' => $intEditModeId), false);
                        if ($isDeleted) {
                            $isContentAdded = "0";
                        }
                    }
                    $boolContentUpdated = $this->Resources->updateAll(
                            array('content_added' => "'" . $isContentAdded . "'"), array('productd_id =' => $intEditModeId)
                    );
                    echo json_encode($arrResponseData);
                    exit;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some Error, Please try again', 'error');
                    $arrResponseData['status'] = 'fail';
                    $arrResponseData['message'] = $strMessage;
                    echo json_encode($arrResponseData);
                    exit;
                }
            } else {
                $intContentExists = $this->Resources->find('count', array(
                    'conditions' => array('product_name' => $arrContentData['Resources']['product_name'])
                ));
                if ($intContentExists) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('This Service is already present', 'info');
                    $arrResponseData['status'] = 'fail';
                    $arrResponseData['message'] = $strMessage;
                    echo json_encode($arrResponseData);
                    exit;
                } else {
                    $boolContentCreated = $this->Resources->save($arrContentData);
                    if ($boolContentCreated) {
                        $intCreatedContentId = $this->Resources->getLastInsertID();
                        $arrResponseData['createdid'] = $intCreatedContentId;
                        $arrResponseData['status'] = 'success';

                        $this->loadModel('Content');
                        $arrContentData['Content']['resource_id'] = $intCreatedContentId;

                        $arrContentAdded = $this->Content->save($arrContentData);
                        if (is_array($arrContentAdded) && (count($arrContentAdded) > 0)) {
                            $boolContentUpdated = $this->Resources->updateAll(
                                    array('content_added' => "'1'"), array('productd_id =' => $intCreatedContentId)
                            );
                        }
                    }
                    $compMessage = $this->Components->load('Message');
                    $strForMessage = "You have successfully created Service.";
                    $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                    $arrResponseData['message'] = $strMessage;
                    echo json_encode($arrResponseData);
                    exit;
                }
            }
        }
    }

    public function add() {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.form.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/add_product.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tinymce/tiny_mce.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/tmpl.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/load-image.all.min.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/canvas-to-blob.min.js') . '"></script>';
        //$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.iframe-transport.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-process.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-image.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-video.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js') . '"></script>';
        //$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
        //$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
        $this->set('strActionScript', $strActionScript);

        $this->set('strDateFormat', Configure::read('Productdate.format'));
        $this->loadModel('Contenttype');
        $arrContentTypeList = $this->Contenttype->find('list', array('fields' => array('content_type_id', 'content_type_name')));
        $this->set('arrContentTypeList', $arrContentTypeList);
        
        $this->loadModel('Resources');
        $arrResourcesDetails = $this->Resources->find('all', array('conditions' => array('product_type' => array('Services'), 'product_publish_status' => '1','product_parent'=>'')));
        $this->set('arrServicesDetails', $arrResourcesDetails);
        
        $this->loadModel('Content');
        
        if ($this->request->is('Post')) {
            
            $arrResponseData = array();
            $intEditModeId = "";
            $arrContentData = array();
            $strRequestFor = $this->request->data['content_request_for'];
            $strDefaultCate = '0';
            if ($this->request->data['content_request_for_id']) {
                $strDefaultCate = $this->request->data['content_request_for_id'];
            }
            $arrContentData['Content']['content_title'] = htmlspecialchars(addslashes($this->request->data['content_title']));
            $arrContentData['Content']['content_title_alias'] = htmlspecialchars(addslashes($this->request->data['content_title_alias']));
            $arrContentData['Content']['content_name'] = addslashes($this->request->data['content_name']);
            $arrContentData['Content']['content_default_category'] = $strDefaultCate;
            $arrContentData['Content']['content_intro_text'] = htmlspecialchars(addslashes($this->request->data['intro_content']));
            $arrContentData['Content']['content'] = htmlspecialchars(addslashes($this->request->data['main_content']));
            $arrContentData['Content']['content_type'] = "1";
            $arrContentData['Content']['content_for_user'] = "4";
            $arrContentData['Content']['content_published_date'] = date('Y-m-d H:i:s', strtotime($this->request->data['content_pub_date']));
            $intEditModeId = $this->request->data['content_edit_id'];

            $arrContentData['product_name'] = $this->request->data['service_name'];
            $arrContentData['product_parent'] = $this->request->data['service'];
            $arrContentData['product_access_link'] = $this->request->data['service_access_link'];
            $arrContentData['product_cost'] = $this->request->data['service_cost'];
            $arrContentData['discount_cost'] = !empty($this->request->data['discount_cost']) ? $this->request->data['discount_cost'] : NULL;
            
            //$arrContentData['Resources']['product_type'] = "Services";
            $arrContentData['product_type'] = $this->request->data['service_type'];
            if ($this->request->data['to_publish']) {
                $arrContentData['product_publish_status'] = "1";
                $arrContentData['Content']['content_status'] = "published";
            } else {
                $arrContentData['product_publish_status'] = null;
                $arrContentData['Content']['content_status'] = null;
            }

            if (!$arrContentData['Content']['content_title']) {
                $arrContentData['Content']['content_title'] = addslashes($this->request->data['service_name']);
            }
            

            $this->loadModel('Resources');
            if ($intEditModeId) {
//                $boolContentUpdated = $this->Resources->updateAll(
//                        array('product_name' => "'" . addslashes($arrContentData['product_name']) . "'", 'product_publish_status' => "'" . $arrContentData['product_publish_status'] . "'", 'product_type' => "'" . $arrContentData['product_type'] . "'", 'product_cost' => "'" . $arrContentData['product_cost'] . "'", 'discount_cost' => "'" . $arrContentData['discount_cost'] . "'"), array('productd_id =' => $intEditModeId)
//                );
                
                $compSkillSoft = $this->Components->load('SkillSoft');
                $boolContentUpdated = $compSkillSoft->fnUpdateService($arrContentData,$intEditModeId);
                
                if ($boolContentUpdated) {
                    $compMessage = $this->Components->load('Message');
                    $strForMessage = "Updation was successfull.";
                    $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                    $arrResponseData['status'] = 'success';
                    $arrResponseData['message'] = $strMessage;
                    $isContentAdded = "0";
                    if ($arrContentData['Content']['content'] || $arrContentData['Content']['content_intro_text']) {
                        $this->loadModel('Content');
                        $intContentCount = $this->Content->find('count', array('conditions' => array('resource_id' => $intEditModeId)));
                        
                        if ($intContentCount) {
                            $boolContentUpdated = $this->Content->updateAll(
                                    array('content_default_category' => "'" . $arrContentData['Content']['content_default_category'] . "'", 'content_title_alias' => "'" . $arrContentData['Content']['content_title_alias'] . "'", 'content_title' => "'" . $arrContentData['Content']['content_title'] . "'", 'content_name' => "'" . $arrContentData['Content']['content_name'] . "'", 'content_intro_text' => "'" . $arrContentData['Content']['content_intro_text'] . "'", 'content' => "'" . $arrContentData['Content']['content'] . "'", 'content_status' => "'" . $arrContentData['Content']['content_status'] . "'", 'content_type' => "'" . $arrContentData['Content']['content_type'] . "'"), array('resource_id =' => $intEditModeId)
                            );
                            
                            if ($boolContentUpdated) {
                                $isContentAdded = "1";
                            }
                        } else {
                            $arrContentData['Content']['resource_id'] = $intEditModeId;
                            $arrCD['Content'] = $arrContentData['Content'];
                            ////print("<pre>");
                            //print_r($arrCD);

                            $arrContentAdded = $this->Content->save($arrContentData);
                            ///print("<pre>");
                            //print_r($arrContentAdded);
                            //exit;
                            if (is_array($arrContentAdded) && (count($arrContentAdded) > 0)) {
                                $boolContentUpdated = $this->Resources->updateAll(
                                        array('content_added' => "'1'"), array('productd_id =' => $intEditModeId)
                                );
                                if ($boolContentUpdated) {
                                    $isContentAdded = "1";
                                }
                            }
                        }
                    } else {

                        $isDeleted = $this->Content->deleteAll(array('resource_id' => $intEditModeId), false);
                        if ($isDeleted) {
                            $isContentAdded = "0";
                        }
                    }
                    $boolContentUpdated = $this->Resources->updateAll(
                            array('content_added' => "'" . $isContentAdded . "'"), array('productd_id =' => $intEditModeId)
                    );
                    echo json_encode($arrResponseData);
                    exit;
                } else {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('Some Error, Please try again', 'error');
                    $arrResponseData['status'] = 'fail';
                    $arrResponseData['message'] = $strMessage;
                    echo json_encode($arrResponseData);
                    exit;
                }
            } else {
                //print("<pre>");
                //print_r($arrContentData);
                //exit;

                $intContentExists = $this->Resources->find('count', array(
                    'conditions' => array('product_name' => $arrContentData['product_name'], "product_type" => $arrContentData['product_type'])
                ));
                if ($intContentExists) {
                    $compMessage = $this->Components->load('Message');
                    $strMessage = $compMessage->fnGenerateMessageBlock('This Service is already present', 'info');
                    $arrResponseData['status'] = 'fail';
                    $arrResponseData['message'] = $strMessage;
                    echo json_encode($arrResponseData);
                    exit;
                } else {
                    $compMessage = $this->Components->load('SkillSoft');
                    $boolContentCreated = $compMessage->fnAddService($arrContentData);
                    if ($boolContentCreated) {
                        $intCreatedContentId = $this->Resources->getLastInsertID();
                        $arrResponseData['createdid'] = $intCreatedContentId;
                        $arrResponseData['status'] = 'success';

                        $this->loadModel('Content');
                        $arrContentData['Content']['resource_id'] = $intCreatedContentId;

                        $arrContentAdded = $this->Content->save($arrContentData);
                        if (is_array($arrContentAdded) && (count($arrContentAdded) > 0)) {
                            $boolContentUpdated = $this->Resources->updateAll(
                                    array('content_added' => "'1'"), array('productd_id =' => $intCreatedContentId)
                            );
                        }
                        $compMessage = $this->Components->load('Message');
                        $strForMessage = "You have successfully created Service.";
                        $strMessage = $compMessage->fnGenerateMessageBlock($strForMessage, 'success');
                        $arrResponseData['message'] = $strMessage;
                        echo json_encode($arrResponseData);
                        exit;
                    } else {
                        $compMessage = $this->Components->load('Message');
                        $strMessage = $compMessage->fnGenerateMessageBlock('Some Issue, Please try again', 'error');
                        $arrResponseData['status'] = 'fail';
                        $arrResponseData['message'] = $strMessage;
                        echo json_encode($arrResponseData);
                        exit;
                    }
                }
            }
        }
    }

    public function htmlfileuploader($strUploaderFor = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($strUploaderFor) {
            $view->set('uploaderfor', $strUploaderFor);
        }
        $strFileUploaderHtml = $view->element('contentfileuploader', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strFileUploaderHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strFileUploaderHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function fileuploader($strUploaderFor = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($strUploaderFor) {
            $view->set('uploaderfor', $strUploaderFor);
        }
        $strFileUploaderHtml = $view->element('fileuploader', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strFileUploaderHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strFileUploaderHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function mediauploader() {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $strMediaUploaderHtml = $view->element('mediaselector', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strMediaUploaderHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strMediaUploaderHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contentaffotherform($intContentId, $intCatId = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($intContentId) {
            $this->loadModel('Content');
            $arrFeaturedDetails = $this->Content->fnGetProductsFeaturedDetails($intContentId);
            /* print("<pre>");
              print_r($arrFeaturedDetails);
              exit; */
            $view->set('arrFeaturedDetails', $arrFeaturedDetails);

            $this->loadModel('ContentOther');
            $arrContentOtherDetail = $this->ContentOther->find('all', array('conditions' => array('content_id' => $intContentId)));
            /* print("<pre>");
              print_r($arrContentOtherDetail);exit; */
            $view->set('arrContentOtherDetail', $arrContentOtherDetail);
            $view->set('strContentId', $intContentId);
            $view->set('strCatId', $intCatId);
        }
        $strContentOtherHtml = $view->element('content_other_aff', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContentOtherHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContentOtherHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contentotherform($intContentId) {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($intContentId) {
            $this->loadModel('Content');
            $arrContentBranded = $this->Content->fnGetBrandedProductDetails($intContentId);
            $view->set('arrContentBranded', $arrContentBranded);

            $this->loadModel('ContentOther');
            $arrContentOtherDetail = $this->ContentOther->find('all', array('conditions' => array('content_id' => $intContentId)));
            /* print("<pre>");
              print_r($arrContentOtherDetail);exit; */
            $view->set('arrContentOtherDetail', $arrContentOtherDetail);
            $view->set('strContentId', $intContentId);
        }
        $strContentOtherHtml = $view->element('content_other', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContentOtherHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContentOtherHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function parentcontentform($intContentId, $intCatForUser = "3", $intContentType = "1") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $this->loadModel('Content');
        $arrContentAllocatedParent = $this->Content->fnGetContentParentData($intContentId, $intCatForUser);
        $view->set('arrContentAllocatedParent', $arrContentAllocatedParent);
        $view->set('strContentId', $intContentId);
        $arrParentProductList = $this->Content->find('all', array('conditions' => array('content_parent_id' => null, 'content_id !=' => $intContentId, 'content_for_user' => $intCatForUser)));
        //$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
        $view->set('arrProductParentList', $arrParentProductList);
        /* print("<pre>");
          print_r($arrParentProductList);
          exit; */
        $strContentParentHtml = $view->element('content_parent');
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContentParentHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContentParentHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function parentcatcontentform($intContentId = "0", $intCatForUser = "3", $strParenCatType = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $this->loadModel('Categories');
        $arrContentAllocatedParent = $this->Categories->fnGetCatContentParentData($intContentId, $intCatForUser);
        $view->set('arrContentAllocatedParent', $arrContentAllocatedParent);
        $view->set('strContentId', $intContentId);
        $arrParentProductList = $this->Categories->find('all', array('conditions' => array('content_category_id !=' => $intContentId, 'content_cat_for_user' => $intCatForUser, 'content_category_parent_id !=' => $intContentId, "job_process_type" => $strParenCatType)));

        //$arrParentProductList = $this->Content->find('all',array('conditions'=>array('content_parent_id'=>null)));
        $view->set('arrProductParentList', $arrParentProductList);
        /* print("<pre>");
          print_r($arrParentProductList);
          exit; */
        $strContentParentHtml = $view->element('content_cat_parent');
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContentParentHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContentParentHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function resourcecategoryassform($intProductId = "0", $intCatUser = "3", $strCatType = "1") {
//        Configure::write('debug',2);
        $arrResponse = array();
        $this->autoRender = false;

        $this->loadModel('Categories');
        
        $arrCatList = $this->Categories->fnGetProductAllCat();

        // code to get the html content
        $view = new View($this, false);
        $this->loadModel('CategoriesAssignment');
        $arrContentCatAssigned = $this->CategoriesAssignment->find('list', array('fields' => array('content_category_assig_id', 'category_id'), 'conditions' => array('product_id' => $intProductId)));
        $view->set('arrCatAssigned', $arrContentCatAssigned);
        $view->set('arrCatList', $arrCatList);
        if (!$intProductId) {
            $intProductId = "";
        }
        $view->set('intProductId', $intProductId);
        $strContentCategoryHtml = $view->element('resources_cat_assignment',$params);
        //$view->render('testlogin');
//        echo $strContentCategoryHtml;exit;
        if ($strContentCategoryHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContentCategoryHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function featuredform($intContentId = "") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $this->loadModel('Content');
        $arrFeaturedDetails = $this->Content->fnGetProductsFeaturedDetails($intContentId);
        /* print("<pre>");
          print_r($arrFeaturedDetails);
          exit; */
        $view->set('arrFeaturedDetails', $arrFeaturedDetails);
        $view->set('strContentId', $intContentId);
        $strFeaturedHtml = $view->element('content_featured');
        if ($strFeaturedHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strFeaturedHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contact($intContentId) {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $this->loadModel('Content');
        $arrContactDetails = $this->Content->fnGetBasicContactDetails($intContentId);
        $view->set('arrContactDetails', $arrContactDetails);
        $view->set('strContentId', $intContentId);
        $strContactHtml = $view->element('contact_details');
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContactHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContactHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contactdetail() {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        $strContactHtml = $view->element('contact_details', $params);
        //$view->render('testlogin');
        //echo $strLoginHtml;exit;
        if ($strContactHtml) {
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContactHtml;
        } else {
            $arrResponse['status'] = "fail";
        }
        echo json_encode($arrResponse);
        exit;
    }

    public function contactlocation($intContentId = "1") {
        $arrResponse = array();
        $this->autoRender = false;
        // code to get the html content
        $view = new View($this, false);
        if ($intContentId) {
            $this->loadModel('ContentLocation');
            $arrContactLocationDetailList = $this->ContentLocation->find('all', array('conditions' => array('content_id' => $intContentId)));
            $view->set('arrContactLocationDetailList', $arrContactLocationDetailList);

            if (is_array($arrContactLocationDetailList) && (count($arrContactLocationDetailList) == 0)) {
                $compMessage = $this->Components->load('Message');
                $strMessage = $compMessage->fnGenerateMessageBlock('There are no contact location created, you need to create one', 'info');
                $view->set('strMessage', $strMessage);
            }
        }
        $strContactLocationHtml = $view->element('contact_locations');
        //$view->render('testlogin');
        //echo $strContactLocationHtml;exit;
        if ($strContactLocationHtml) {
            //echo "HI";exit;
            $arrResponse['status'] = "success";
            $arrResponse['content'] = $strContactLocationHtml;
            //$arrResponse['content'] = 'Rajendra';
            echo json_encode($arrResponse);
            exit;
            /* print("<pre>");
              print_r($arrResponse);
              exit; */
        } else {
            $arrResponse['status'] = "fail";
            //$arrResponse['status'] = "fail";
            echo json_encode($arrResponse);
            exit;
        }
    }
    
    public function managesubproduct($productPareId="") {
        $strActionScript = '<script type="text/javascript" src="' . Router::url('/js/resource_index.js') . '"></script>';
        $strActionScript .= '<script type="text/javascript" src="' . Router::url('/js/jquery/jquery.tablesorter.js') . '"></script>';
        
        $this->set('strActionScript', $strActionScript);
        $this->Session->write('strCancelUrl', Router::url(array('controller' => 'content', 'action' => 'index'), true));
        if ($this->request->is('Post') && ($this->request->data['filter_on'])) {
            $strProductFilterKeyword = $this->request->data['product_keyword'];
            $this->redirect(array('controller' => 'resource', 'action' => 'search', $strProductFilterKeyword));
        }
        
         if($this->request->data['columnName'] == '' && $this->request->data['sort'] == ''){
            $url = $_SERVER['QUERY_STRING'];
            $Column_url = explode("Column=", $url);
            $ColumnName = explode("/", $Column_url[1]);
            $Sort_url = explode("Sort=", $url);
            $Sort = explode("&", $Sort_url[1]);
        }else{       
            $columnName = $this->request->data['columnName'];
            $sort = $this->request->data['sort'];
            $this->Session->write('productcolumn',$columnName);
            $this->Session->write('productsort',$sort);
            $this->Session->write('type','index');
        }
    
        if ($columnName !='' && $sort !='') {
            $arrResponse = array();
            $this->autoRender = false;
            // code to get the html content
            $view = new View($this, false); 
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'conditions' => array('product_type' => 'Services','parent_id'=> $productPareId,'column_name'=>$columnName,'order'=>$sort),
                'limit' => 20
            );
            $arrProductContentList = $this->Paginator->paginate('Resources');
            echo '<pre>';print_r($arrProductContentList);die;
            $view->set('arrProductList', $arrProductContentList);
            $strContactLocationHtml = $view->element('sort_services_list',array('column_name'=>$columnName,'sort'=>$sort));
            $strPaginationHtml = $view->element('sort_product_pagination',array('column_name'=>$columnName,'sort'=>$sort));
            if ($arrProductContentList) {
                $arrResponse['status'] = "success";
                $arrResponse['content'] = $strContactLocationHtml;
                $arrResponse['pagidiv'] = $strPaginationHtml;
                $arrResponse['count'] = count($arrProductContentList);
                echo json_encode($arrResponse);
                exit;
            } else {
                $arrResponse['status'] = "fail";
                echo json_encode($arrResponse);
                exit;
            }
        }else{
            $this->loadModel('Resources');
            $this->Resources->recursive = 0;
            $this->Paginator->settings = array(
                'Resources' => array(
                    'conditions' => array('product_type' => 'Services','parent_id'=> $productPareId,'column_name'=>$ColumnName[0],'order'=>$Sort[0]),
                    'limit' => 20,
                )
            );
            $arrProductContentList = $this->Paginator->paginate('Resources');
            $this->set('arrProductList', $arrProductContentList);
        }
        
        if (count($arrProductContentList) == 0) {
            $compMessage = $this->Components->load('Message');
            $strMessage = $compMessage->fnGenerateMessageBlock('There are no resources present, Please add one', 'info');
            $this->set('strMessage', $strMessage);
        }
    }
    
}
