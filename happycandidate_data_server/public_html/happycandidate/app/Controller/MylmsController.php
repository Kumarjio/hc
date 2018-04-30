<?php
	
	class MylmsController extends AppController 
	{
		var $helpers = array ('Html','Form');
		var $name = 'Mylms';
		
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
		
		public function moderatecourses()
		{
			//Configure::write('debug','2');
			$this->loadModel('Resources');
			$arrCourses = $this->Resources->find('all',array('conditions'=>array('product_moderation_status'=>'1','product_type'=>'Course')));
			
			
			$this->set('arrProductList',$arrCourses);
			//print("<pre>");
			//print_r($arrCourses);
			//exit;
			
		}
		
		public function manage($intCourseId = "") 
		{
			$arrLoggedUser = $this->Auth->user();
			if($intCourseId)
			{
				$this->loadModel('Resources');
				$arrCourseDetail = $this->Resources->find('all',array('conditions'=>array('productd_id'=>$intCourseId)));
				if(is_array($arrCourseDetail) && (count($arrCourseDetail)>0))
				{
					$strLmsPath = Configure::read('Lms.courseview')."?usert_type_request=".$arrLoggedUser['user_type']."&id=".$arrCourseDetail[0]['Resources']['external_content_id'];
					$this->set('strLmsUrl',$strLmsPath);
				}
				else
				{
					$this->Session->setFlash('There is no such course exists, please recheck and try again later');
				}
			}
			else
			{
				$this->Session->setFlash('Parameter is missing, please try again later');
			}
		}
	}
?>