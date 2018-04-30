<?php
	
	class VendorslmsController extends AppController 
	{
		var $helpers = array ('Html','Form');
		var $name = 'Vendorslms';
		
		//var $layout = 'register';
		
		public function beforeFilter()
		{
			//$this->Auth->autoRedirect = false;
			parent::beforeFilter();
			//$this->Auth->allow('index');
		}
		
		public function index() 
		{
			$arrLoggedUser = $this->Auth->user();
			if($arrLoggedUser['vendor_type'] == "Course")
			{
				$strLmsPath = Configure::read('Lms.loginafterpath')."?usert_type_request=2";
				$this->set('strLmsUrl',$strLmsPath);
			}
		}
	}
?>