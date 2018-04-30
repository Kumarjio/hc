<?php
	
	class EmployerslmsController extends AppController 
	{
		var $helpers = array ('Html','Form');
		var $name = 'Employerslms';
		
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
			$strLmsPath = Configure::read('Lms.loginafterpath')."?usert_type_request=".$arrLoggedUser['user_type'];
			$this->set('strLmsUrl',$strLmsPath);
		}
	}
?>