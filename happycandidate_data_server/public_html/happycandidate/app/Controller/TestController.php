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
class TestController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = "admin";
	
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		parent::beforeFilter();
		$this->Auth->allow('assignwidgetlist','medialister','uploadfile','mediaselector','contentlayoutform','content','index','testlogin','getlogin','featured','contact','contactlocation','arlen','testis');
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function index() 
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/test_index.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
	}
	
	public function arlen()
	{
		$this->layout = "sitetest";
	}
	
	public function assignwidgetlist($strCategory = "")
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
		$arrResponse = array();
		//$this->autoRender = false;
		$this->loadModel('Widgets');
		if($strCategory)
		{
			$arrWidgetList = $this->Widgets->find('all',array('conditions'=>array('widget_category'=>$strCategory)));
		}
		else
		{
			$arrWidgetList = $this->Widgets->find('all');
		}
		
		/*print("<pre>");
		print_r($arrWidgetList);
		exit;*/
		
		$this->set('arrWidgetList',$arrWidgetList);
	}
	
	public function uploadfile($strUploadFor = "")
	{
		$this->autoRender = false;
		$this->layout = NULL;
		
		$compFileUploader = $this->Components->load('Fileupload');
		$compFileUploader->bootup();
	}
	
	public function medialister()
	{
		$strActionScript = '';
		$this->set('strActionScript',$strActionScript);
	}
	
	
	public function mediaselector()
	{
		$this->layout = "portaldefault";
		
		
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
	}
	
	/*public function mediaselector()
	{
		$this->layout = "portaldefault";
		
		
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
	}*/
	
	public function contentlayoutform()
	{
		
	}
	
	public function testlogin()
	{
		
	}
	
	public function featured()
	{
		
	}
	
	public function contact()
	{
		
	}
	
	public function getlogin()
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		$strLoginHtml = $view->element('testlogin', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strLoginHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strLoginHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function contactlocation()
	{
		
	}
	
	public function content()
	{
	
	}
	
	public function testis()
	{
		//$strTestDate = "20150717T04:19:19";
		//$strTD = date("Y-m-d H:i:s",strtotime($strTestDate));
		//echo "--".$strOnM = date("Y-m-d H:i:s",strtotime("+1 months",strtotime($strTD)));
		//exit;
		
		$compInfusionSoft = $this->Components->load('Infusionsoft'); //load it
		//$arrOrderDetail = $compInfusionSoft->fnGetOrderDetail(394);
		//print("<pre>");
		//print_r($arrOrderDetail);
		//exit;
		
		
		//$compInfusionSoft->fnCheckSubscriptionStatus();
		//$arrOrderDetail = $compInfusionSoft->fnGetOrderItems(392);
		
		
		//$arrOrderDetail = $compInfusionSoft->fnGetSubscriptionDetails(12,174062);
		//print("<pre>");
		//print_r($arrOrderDetail);
		//exit;
		
		//echo "---".$strExpiryDate = $compInfusionSoft->fnGetSubscriptionExpiryInformation(392,183790);
		//exit;
		
	}
}
