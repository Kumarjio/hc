<?php

class AppController extends Controller {

    public $components = array(
		'FbRegister',
		'Email',
		'Session',
		'Auth',
		'Authorize'
        /*'Auth' => array(
							"authenticate" => array(
														'Form' => array(
															'userModel' => 'User',
															'fields' => array('username'=>'email','password'=>'pass')
														)
													),
							"loginRedirect" => array('controller' => 'employers', 'action' => 'dashboard'),
							"logoutRedirect" => array('controller' => 'home', 'action' => 'index'),
							"authError" => "You cant access that page",
							"authorize" => array('Controller')
							)*/
    );
	
	public $helpers = array('cart');
	protected $strCandidateDefaultCV = "";
	protected $strCandidateDefaultId = "";
	
    
    public function isAuthorized($user) 
	{
        return true;
    }
    
    public function beforeFilter() 
	{
        //echo "hi";exit;
		$this->set('productdateformat',Configure::read('Productdate.format'));
		$this->set('productdateformatnew',Configure::read('HC.dateformat'));
		$this->set('productdateformatjs',Configure::read('HC.dateformatJs'));
		//echo "---".$this->params['controller'];exit;
		Security::setHash('md5',true);
		$this->set('strLmsLoginUrl',Configure::read('Lms.loginurl'));
		$this->set('strLmsLogOutUrl',Configure::read('Lms.logouturl'));
		$this->set('strLmsSessionUrl',Configure::read('Lms.session'));
		//echo "---".Configure::read('Jobber.employerloginurl');
		$this->set('strJobberBaseUrl',Configure::read('Jobber.baseurl'));
		$this->set('strJobberEmployerLoginUrl',Configure::read('Jobber.employerloginurl'));
		$this->set('strJobberEmployerLogoutUrl',Configure::read('Jobber.employerlogouturl'));
		$this->set('strJobberEmployerSetPortalUrl',Configure::read('Jobber.employersetportalurl'));
		
		$this->set('strJobberAdminLoginUrl',Configure::read('Jobber.adminloginurl'));
		$this->set('strJobberAdminLogOutUrl',Configure::read('Jobber.adminlogouturl'));
		
		$this->set('strJobberSeekerLoginUrl',Configure::read('Jobber.seekerloginurl'));
		$this->set('strJobberSeekerLogOutUrl',Configure::read('Jobber.seekerlogouturl'));
		
		$this->set('strJobberSeekerHomeUrl',Configure::read('Jobber.seekerhomeurl'));
		
		/*$strSystemRequest = Configure::read('BackendSystem.key');
		$strPortalRequest = Configure::read('PrivatePortal.key');
		
		//echo "--".Configure::read('BackendSystem.key');
		
		
		if(isset($strSystemRequest))
		{
			$this->Auth->authenticate = array('Form'=>array('userModel'=>'User','fields'=>array('username'=>'email','password'=>'pass')));
			AuthComponent::$sessionKey = 'Auth.'.Configure::read('BackendSystem.key');
			$this->Auth->loginRedirect = array('controller' => 'employers', 'action' => 'dashboard');
			$this->Auth->logoutRedirect = array('controller'=>'home','action'=>'index');
			$this->Auth->authError = "You cant access that page";
			$this->Auth->authorize = array('Controller');
			$this->Auth->allow('login','register','social');
		}
		else
		{
			if(isset($strPortalRequest))
			{
				$this->Auth->authenticate = array('Form'=>array('userModel'=>'Candidate','fields'=>array('username'=>'candidate_email','password'=>'candidate_password'),'scope'=>array('career_portal_id'=>Configure::read('PrivatePortal.id'))));
				AuthComponent::$sessionKey = 'Auth.'.Configure::read('PrivatePortal.key');
				$this->Auth->loginRedirect = array('controller' => 'portal', 'action' => 'login',Configure::read('PrivatePortal.id'));
				$this->Auth->logoutRedirect = array('controller'=>'portal','action'=>'login',Configure::read('PrivatePortal.id'));
				$this->Auth->authError = "You cant access that page";
				$this->Auth->authorize = array('Controller');
				$this->Auth->allow('login','register','social');
			}
		 }*/
		
		
		
		if($this->params['controller'] != "settings" && $this->params['controller'] != "portal" && $this->params['controller'] != "candidates" && $this->params['controller'] != "profileperformance" && $this->params['controller'] != "notification" && $this->params['controller'] != "references" && $this->params['controller'] != "Tletters" && $this->params['controller'] != "jsprocess" && $this->params['controller'] != "jstracker" && $this->params['controller'] != "jstcontacts" && $this->params['controller'] != "jstappointments" && $this->params['controller'] != "jsttasks" && $this->params['controller'] != "jstnote" && $this->params['controller'] != "resources" && $this->params['controller'] != "addtocart" && $this->params['controller'] != "showcart" && $this->params['controller'] != "vendoraccount" && $this->params['controller'] != "vendororders" && $this->params['controller'] != "vendorservicehoster" && $this->params['controller'] != "vendorslms" && $this->params['controller'] != "vendorcourse" && $this->params['controller'] != "myorders" && $this->params['controller'] != "faq")
		{
			
			$this->Auth->authenticate = array('Form'=>array('userModel'=>'User','fields'=>array('username'=>'email','password'=>'pass')));
			AuthComponent::$sessionKey = 'Auth.BackendUser';
			$this->Auth->loginAction = array('controller' => 'home', 'action' => 'index');
			$this->Auth->loginRedirect = array('controller' => 'employers', 'action' => 'dashboard');
			$this->Auth->logoutRedirect = array('controller'=>'home','action'=>'index');
			$this->Auth->authError = "You cant access that page";
			$this->Auth->authorize = array('Controller');
			$this->Auth->allow('newjobreminders','login','register','social','updateevent','updatenewjobnotificationevent','getlocation','states','cities');
		}
		else
		{
			if($this->params['controller'] == "vendoraccount" || $this->params['controller'] == "vendororders" || $this->params['controller'] == "vendorslms" || $this->params['controller'] == "vendorcourse")
			{
				$this->Auth->authenticate = array('Form'=>array('userModel'=>'Vendors','fields'=>array('username'=>'vendor_email','password'=>'vendor_password_encrypted')));
				AuthComponent::$sessionKey = 'Auth.VendorUser';
				$this->Auth->loginAction = array('controller' => 'vendoraccount', 'action' => 'index');
				$this->Auth->loginRedirect = array('controller' => 'vendoraccount', 'action' => 'dashboard');
				$this->Auth->logoutRedirect = array('controller'=>'vendoraccount','action'=>'index');
				$this->Auth->authError = "You cant access that page";
				$this->Auth->authorize = array('Controller');
				$this->Auth->allow('index');
				$this->loadModel('Notification');
				$arrLoggedUser = $this->Auth->user();
				
				//echo "asdsad assad as";exit;
				
				$intNotifyCount = $this->Notification->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['vendor_id'],'notification_read'=>'0','foruser'=>'owner')));
				$this->set('notifyCount',$intNotifyCount);
			}
			else
			{
				if(isset($this->params['pass']['0']))
				{
					$intPassesPortalId = $this->params['pass']['0'];
				}
				else
				{
					if(isset($this->request->data['PortalUser']['portal_id']))
					{
						$intPassesPortalId = $this->request->data['PortalUser']['portal_id'];
					}
				}
				
				
				
				if(is_numeric($intPassesPortalId))
				{
					// load portal details
					$this->loadModel('Portal');
					$arrPortalDetail = $this->Portal->find('all', array(
										'conditions' => array('career_portal_id' => $intPassesPortalId)
									));
					$this->set('arrPortalDetail',$arrPortalDetail);
					$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
					$this->set('intPortalId',$intPassesPortalId);
					$strPortalName = $arrPortalDetail[0]['Portal']['career_portal_name'];
					
					// load portal theme and its details
					$this->loadModel('PortalTheme');
					$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPassesPortalId);
					if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
					{
						$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
					}
					
					// load portal theme widgets
					$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
					$this->loadModel('PortalThemeWidgets');
					$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId,$intPassesPortalId);
					
					if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
					{
						$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
					}
					
					$this->Auth->authenticate = array('Form'=>array('userModel'=>'Candidate','fields'=>array('username'=>'candidate_email','password'=>'candidate_password'),'scope'=>array('career_portal_id'=>$intPassesPortalId)));
					AuthComponent::$sessionKey = 'Auth.FrontendUser_'.$intPassesPortalId;
					$this->Auth->loginAction = array('controller' => 'portal', 'action' => 'login',$intPassesPortalId);
					$this->Auth->loginRedirect = array('controller' => 'portal', 'action' => 'index',$arrPortalDetail[0]['Portal']['career_portal_name'],"1");
					$this->Auth->logoutRedirect = array('controller'=>'portal','action'=>'login',$intPassesPortalId);
					$this->Auth->authError = "You need to login to access that page";
					$this->Auth->authorize = array('Controller');
					$this->Auth->allow('newjobreminders','login','register','social','updateevent','contactus','page','updatenewjobnotificationevent','getlocation','states','cities');
				}
				else
				{
					$this->loadModel('Portal');
					$arrPortalDetail = $this->Portal->find('all', array(
										'conditions' => array('career_portal_name' => $intPassesPortalId)
									));
					$intPassesPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
					$this->set('arrPortalDetail',$arrPortalDetail);
					$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
					$this->set('intPortalId',$intPassesPortalId);
					$strPortalName = $arrPortalDetail[0]['Portal']['career_portal_name'];
					
					// load portal theme and its details
					$this->loadModel('PortalTheme');
					$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPassesPortalId);
					if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
					{
						$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
					}
					
					// load portal theme widgets
					$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
					$this->loadModel('PortalThemeWidgets');
					//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
					$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId,$intPassesPortalId);
					/* print("<pre>");
					print_r($arrPortalThemeWidgets); */
					if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
					{
						$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
					}
					
					$this->Auth->authenticate = array('Form'=>array('userModel'=>'Candidate','fields'=>array('username'=>'candidate_email','password'=>'candidate_password'),'scope'=>array('career_portal_id'=>$arrPortalDetail[0]['Portal']['career_portal_id'])));
					AuthComponent::$sessionKey = 'Auth.FrontendUser_'.$arrPortalDetail[0]['Portal']['career_portal_id'];
					$this->Auth->loginAction = array('controller' => 'portal', 'action' => 'login',$arrPortalDetail[0]['Portal']['career_portal_id']);
					$this->Auth->loginRedirect = array('controller' => 'portal', 'action' => 'index',$arrPortalDetail[0]['Portal']['career_portal_name'],"1");
					$this->Auth->logoutRedirect = array('controller'=>'portal','action'=>'login',$arrPortalDetail[0]['Portal']['career_portal_id']);
					$this->Auth->authError = "You need to login to access that page";
					$this->Auth->authorize = array('Controller');
					$this->Auth->allow('newjobreminders','login','register','social','updateevent','contactus','page','updatenewjobnotificationevent','getlocation','states','cities');
				}
				$arrLoggedUser = $this->Auth->user();
				
				// check candidates default cv created or not
				$this->loadModel('Candidatedefaultcv');
				$arrCandidateDefaultCv = $this->Candidatedefaultcv->fnGetCandidateDefaultCv($arrLoggedUser['candidate_id']);
				if(is_array($arrCandidateDefaultCv) && (count($arrCandidateDefaultCv)>0))
				{
					$this->strCandidateDefaultCV = count($arrCandidateDefaultCv);
					$this->strCandidateDefaultId = $arrCandidateDefaultCv[0]['jobberland_cv_detail']['id'];
					
					$this->set('strCandidateDefaultCV',count($arrCandidateDefaultCv));
					$this->set('strCandidateDefaultId',$arrCandidateDefaultCv[0]['jobberland_cv_detail']['id']);
				}
				
				
				// loading notification only in presence of parameter
				if(isset($this->params['pass']['1']))
				{
					$strCheckNewSessLoggedInVar = $this->Session->read("current_user_".$arrLoggedUser['candidate_id']."_loggedin_cout");
					$strCheckNewSessLoggedInVar = '1';
					if($strCheckNewSessLoggedInVar == "1")
					{
						$strCheckNewSessLoggedInVar++;
						$this->Session->write("current_user_".$arrLoggedUser['candidate_id']."_loggedin_cout",$strCheckNewSessLoggedInVar);
						
						
						$this->loadModel('Notification');
						//$arrLoadNotification = $this->Notification->find('all',array('limit'=>'5','conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
						$arrNotificationDetail = $this->Notification->fnGetNotificationDetails($arrLoggedUser['candidate_id'],'3');
						//print("<pre>");
						//print_r($arrNotificationDetail);
						//exit;
						
						$this->set('notificationDetailnew',$arrNotificationDetail);
						
						
						$intNotifyCount = $this->Notification->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'notification_read'=>'0','foruser'=>'candidate')));
						$this->set('notifyCount',$intNotifyCount);
						$this->set('isCandidateLoggedIn',$arrLoggedUser['candidate_id']);
						$this->set('strCandidateLoggedInUserName',$arrLoggedUser['candidate_username']);
						$this->set('strCandidateLoggedInUserEmail',$arrLoggedUser['candidate_email']);
					}
					
					/*$this->loadModel('Candidate');
					$intCountJbLoginToken = $this->Candidate->find('count',array('conditions'=>array('jb_auth_token'=>$this->params['pass']['1'],'candidate_id'=>$arrLoggedUser['candidate_id'])));
					if($intCountJbLoginToken)
					{
						$this->loadModel('Notification');
						//$arrLoadNotification = $this->Notification->find('all',array('limit'=>'5','conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'])));
						$arrNotificationDetail = $this->Notification->fnGetNotificationDetails($arrLoggedUser['candidate_id'],'3');
						$this->set('notificationDetail',$arrNotificationDetail);
						$intNotifyCount = $this->Notification->find('count',array('conditions'=>array('candidate_id'=>$arrLoggedUser['candidate_id'],'notification_read'=>'0')));
						$this->set('notifyCount',$intNotifyCount);	
					}*/
				}
				$intJloggedInToken = "";
				if($this->Auth->loggedIn())
				{
					if($this->Session->check("current_user_".$arrLoggedUser['candidate_id']))
					{
						$intJloggedInToken = $this->Session->read("current_user_".$arrLoggedUser['candidate_id']);
					}
					
					/*if(is_array($arrLoggedUser) && (count($arrLoggedUser)>0) && (isset($arrLoggedUser['candidate_id'])))
					{
						$compCandidates = $this->Components->load('Candidates');
						$intJloggedInToken = $compCandidates->fnGetCandidateJobberToken($arrLoggedUser['candidate_id']);
					}*/
				}
			}
		 }
		
		// login redirection logic		
		if($this->params['action'] == "login")
		{
			if($this->request->is('post'))
			{
				if(isset($this->request->data['User']['u_type']) && ($this->request->data['User']['u_type'] == "1"))
				{
					$this->Auth->loginRedirect = array('controller'=>'admins','action'=>'dashboard');
				}
			}
		}
		
		// logout redirection logic
		if($this->params['action'] == "logout" && $this->params['controller'] == "admins")
		{
			if($this->Auth->loggedIn())
			{
				$this->Auth->logoutRedirect = array('controller'=>'admins','action'=>'index');
			}
		}
		$arrLoggedInUser = $this->Auth->user();
		$arrSelectedMenu = array();
		$this->set('current_controller',$this->params['controller']);
		$this->set('current_action',$this->params['action']);
		// layout logic
		switch($this->params['controller'])
		{
			case "vendoraccount" : 		$this->layout = "vendors";
										break;
			case "vendororders" : 		$this->layout = "vendors";
										break;
			case "vendorslms" : 		$this->layout = "vendors";
										break;
			case "vendorcourse" : 		$this->layout = "vendors";
										break;
			case "admins" : 			$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "dashboard")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeHomeHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "adminanalytics" : 	$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeHomeHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
										}
										break;
			case "jobboards" : 			$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "managejobs" : 		$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeJoblistingHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "manageusers" : 		$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeManageUsersHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "manageseekers" : 		$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeManageUsersHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "manageowners" : 		$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeManageUsersHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "managejobinputs" : 	$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin','');
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "mylms" : 				$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										// top horizontal menu active logic for admin
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeLMSHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeProfileHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "adminsprofile" :		$this->layout = "admin";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "2")
										{
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeHomeHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "edit")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "changepassword")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobInputsHoriNavigationStyleAdmin',"");
											$this->set('activeManageUsersHoriNavigationStyleAdmin',"");
											$this->set('activeJoblistingHoriNavigationStyleAdmin',"");
											$this->set('activeManageJobBoardsHoriNavigationStyleAdmin',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeAnalyticsHoriNavigationStyleAdmin',"");
										}
										break;
			case "employers" : 			//echo "HI";exit;
										$this->layout = "employers";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "1")
										{
											$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
										}
										
										// top horizontal menu active logic for employer
										if($this->params['action'] == "dashboard")
										{											
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeHomeHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeProfileHoriNavigationStyle',"");
											$this->set('activePrivatelabelsitesHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
										}
										$strCurrentUser = $this->Auth->user();
										$this->set('strCurrentUser',$strCurrentUser);
										break;
			case "employersprofile" :	$this->layout = "newemployers";
										//$this->layout = "employers";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "1")
										{
											$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
										}

										// top horizontal menu active logic for employer
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activePrivatelabelsitesHoriNavigationStyle',"");
										}
										if($this->params['action'] == "edit")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activePrivatelabelsitesHoriNavigationStyle',"");
										}
										if($this->params['action'] == "changepassword")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activeProfileHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activePrivatelabelsitesHoriNavigationStyle',"");
										}
										break;
			case "privatelabelsites" :	$this->layout = "newemployers";
										//$this->layout = "employers";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "1")
										{
											$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
										}
										// top horizontal menu active logic for employer
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyle',"");
										}
										if($this->params['action'] == "create")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeProfileHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "edit")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeProfileHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "editor")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyle',"");
										}
										if($this->params['action'] == "view")
										{
											$this->layout = "portal";
										}
										if($this->params['action'] == "viewpage")
										{
											$this->layout = "viewportalpage";
										}
										break;
			case "privatelabelsiteanalytics" :
										//$this->layout = "employers";
										$this->layout = "newemployers";
										// check for valid login type if not redirect that thing to page from where it came
										if($arrLoggedInUser['user_type'] == "1")
										{
											$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
										}
										// top horizontal menu active logic for employer
										if($this->params['action'] == "index")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyle',"");
										}
										if($this->params['action'] == "create")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeProfileHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "edit")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeProfileHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
										}
										if($this->params['action'] == "editor")
										{
											$strActiveHorizontalNavigationStyle = "text-decoration:none;";
											$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
											$this->set('activeHomeHoriNavigationStyle',"");
											$this->set('activeLMSHoriNavigationStyleAdmin',"");
											$this->set('activeProfileHoriNavigationStyle',"");
										}
										if($this->params['action'] == "view")
										{
											$this->layout = "portal";
										}
										if($this->params['action'] == "viewpage")
										{
											$this->layout = "viewportalpage";
										}
										break;
			case "privatelabelsitespages" :	$this->layout = "employers";
											// check for valid login type if not redirect that thing to page from where it came
											if($arrLoggedInUser['user_type'] == "1")
											{
												$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
											}
											// top horizontal menu active logic for employer
											if($this->params['action'] == "index")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "add")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "edit")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "preview")
											{
												$this->layout = "employerpreview";
											}
											break;
			case "privatelabelsitesmenu" :	$this->layout = "employers";
											// check for valid login type if not redirect that thing to page from where it came
											if($arrLoggedInUser['user_type'] == "1")
											{
												$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
											}
											// top horizontal menu active logic for employer
											if($this->params['action'] == "index")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "add")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "edit")
											{
												$strActiveHorizontalNavigationStyle = "text-decoration:none;";
												$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
												$this->set('activeHomeHoriNavigationStyle',"");
												$this->set('activeProfileHoriNavigationStyle',"");
												$this->set('activeLMSHoriNavigationStyleAdmin',"");
											}
											if($this->params['action'] == "preview")
											{
												$this->layout = "portal";
											}
											break;
			case "privatelabelsitesregistration" :	$this->layout = "employers";
													// check for valid login type if not redirect that thing to page from where it came
													if($arrLoggedInUser['user_type'] == "1")
													{
														$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
													}
													// top horizontal menu active logic for employer
													if($this->params['action'] == "index")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "add")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "edit")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "viewfields")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "previewform")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "preview")
													{
														$this->layout = "portal";
													}
													break;
			case "privatelabelsitejobboard" :		//$this->layout = "employers";
													$this->layout = "newemployers";
													// check for valid login type if not redirect that thing to page from where it came
													if($arrLoggedInUser['user_type'] == "1")
													{
														$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
													}
													if($this->params['action'] == "add")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													if($this->params['action'] == "index")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',"");
													}
													break;
			case "employerslms" :					$this->layout = "employers";
													// check for valid login type if not redirect that thing to page from where it came
													if($arrLoggedInUser['user_type'] == "1")
													{
														$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
													}
													if($this->params['action'] == "index")
													{
														$strActiveHorizontalNavigationStyle = "text-decoration:none;";
														$this->set('activePrivatelabelsitesHoriNavigationStyle','');
														$this->set('activeHomeHoriNavigationStyle',"");
														$this->set('activeProfileHoriNavigationStyle',"");
														$this->set('activeLMSHoriNavigationStyleAdmin',$strActiveHorizontalNavigationStyle);
													}
													break;
			case "vendorservicehoster" :		$this->layout = "previewportal";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "portal" :                                                         $this->layout = "previewportalnew";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
									
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index4"||$this->params['action'] == "index5")
												{
													$this->layout = "portalindexdemo";
												}
												if($this->params['action'] == "registration")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",$arrSelectedMenu);
													
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "login")
												{
													//$this->layout = "portaldefault";
													$this->layout = "portaldefaultnew";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuLoginSelectedText",$arrSelectedMenu);
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "forgotpassword")
												{
													$this->layout = "portaldefaultnew";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuLoginSelectedText",$arrSelectedMenu);
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "jobdetail")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "jobsearch")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "index")
												{
													$this->layout = "portalhomepage";
													$this->set('arrLoggedUser',$arrLoggedUser);
													$this->set('strLoggedUserSessKey',$strLoggedUserSessKey);
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "page")
												{
													$this->layout = "previewpageportal";
													$arrSelectedMenu = array('class'=>'active');
													if($this->params['pass']['1'] == "18")
													{
														$this->set("strMenuContactUsSelectedText",$arrSelectedMenu);
													}
													else
													{
														$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													}
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
													
													
													// load portal theme page widgets
													$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
													$this->loadModel('PortalThemePageWidgets');
													//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
													$arrPortalThemePageWidgets = $this->PortalThemePageWidgets->fnLoadPortalThemePageWidgetDetail($this->params['pass']['1'],$intPassesPortalId);
													/* print("<pre>");
													print_r($arrPortalThemePageWidgets); */
													
													if(is_array($arrPortalThemePageWidgets) && (count($arrPortalThemePageWidgets)>0))
													{
														$this->set('arrPortalWidgets',$arrPortalThemePageWidgets);
													}
												}
												
												if($this->params['action'] == "shop")
												{
													//$this->layout = "portaldefault";
													$this->layout = "defaultnewtheme";
													$arrSelectedMenu = array('class'=>'selected');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "notification" :				$this->layout = "portaldefault";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",$arrSelectedMenu);
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "settings" :					$this->layout = "portaldefault";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "notifications")
												{
													$this->layout = "defaultnewtheme";
													$arrSelectedMenu = array('class'=>'active');
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",$arrSelectedMenu);
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
										
			case "candidates" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "dashboard")
												{
													$this->layout = "portaldefault";
													/*$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeProfilePerformanceHoriNavigationStyle',"");
													$this->set('activeHomeHoriNavigationStyle',"");*/
												}
												
												if($this->params['action'] == "savesearch")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",$arrSelectedMenu);
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "savejobs")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												
												if($this->params['action'] == "jobs")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",$arrSelectedMenu);
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "latestjobs")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'selected');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",$arrSelectedMenu);
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "elearning")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "webinars")
												{
													$this->layout = "webinardefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "webinardetail")
												{
													$this->layout = "webinardefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",$arrSelectedMenu);
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "library")
												{
													//$this->layout = "portaldefault";
													$this->layout = "webinardefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "libcatdetail")
												{
													//$this->layout = "portaldefault";
													$this->layout = "defaultnewtheme";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												
												
												if($this->params['action'] == "articledetail")
												{
													//$this->layout = "portaldefault";
													$this->layout = "defaultnewtheme";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "badges")
												{
													$this->layout = "portaldefault";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "profileperformance")
												{
												}
												
												if($this->params['action'] == "cletter")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "cv")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "defaultcv")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "search")
												{
													$this->layout = "previewpageportal";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "advancesearch")
												{
													$this->layout = "previewpageportal";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "logindetail")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuSettingSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "profile")
												{
													$this->layout = "defaultnewthemeprofile";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "course")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
                                                                                                
                                                                                                
												if($this->params['action'] == "contactus")
												{
													//$this->layout = "portaldefault";
													$this->layout = "defaultnewtheme";
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",$arrSelectedMenu);
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
                                                                                                
												break;
			case "references" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "candidatefunctionalpages";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jsprocess" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												$strWizardClass = "wizard-step-v3";
												$this->set('strWizardClass',$strWizardClass);
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "defaultnewtheme";
													//$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "phase")
												{
													$this->layout = "defaultnewthemephase";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "step")
												{
													$this->layout = "defaultnewthemephase";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "substep")
												{
													$this->layout = "defaultnewthemephase";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jstracker" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												$arrSelectedMenu = array('class'=>'active');
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													//$this->layout = "jstracker";
													$this->layout = "defaultnewjstrackertheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jstcontacts" :				$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "jstracker";
													//$this->layout = "defaultnewjstrackertheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "contactdetail")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "myorders" :					$this->layout = "defaultnewtheme";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "portaldefault";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													/*$arrSelectedMenu = array('class'=>'selected');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());*/
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jstappointments" :			$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index" || $this->params['action'] == "calendar")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "add" || $this->params['action'] == "edit" || $this->params['action'] == "detail" || $this->params['action'] == "appointmentsnotes")
												{
													//$this->layout = "jstracker";
													$this->layout = "defaultnewjstrackertheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "contactdetail")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jstnote" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index" || $this->params['action'] == "calendar")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "add" || $this->params['action'] == "edit" || $this->params['action'] == "detail" || $this->params['action'] == "appointmentsnotes")
												{
													//$this->layout = "jstracker";
													$this->layout = "defaultnewjstrackertheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "contactdetail")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "jsttasks" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "add" || $this->params['action'] == "edit" || $this->params['action'] == "detail" || $this->params['action'] == "appointmentsnotes" || $this->params['action'] == "alltasks" || $this->params['action'] == "completedtasks")
												{
													//$this->layout = "jstracker";
													$this->layout = "defaultnewjstrackertheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												
												if($this->params['action'] == "contactdetail")
												{
													$this->layout = "jstracker";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "resources" :					$this->layout = "defaultnewtheme";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													//$this->layout = "portaldefault";
													$this->layout = "defaultnewtheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",$arrSelectedMenu);
													
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "detail")
												{
													$this->layout = "defaultnewtheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",$arrSelectedMenu);
													
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "orders")
												{
													$this->layout = "defaultnewtheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",$arrSelectedMenu);
													
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "ordersuccess")
												{
													$this->layout = "defaultnewtheme";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													$arrSelectedMenu = array('class'=>'active',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuResourcesSelectedText",$arrSelectedMenu);
													
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "Tletters" :					$this->layout = "candidates";
												$arrLoggedUser = $this->Auth->user();
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												
												
												
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												
												if($this->params['action'] == "index")
												{
													$this->layout = "candidatefunctionalpages";
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuCourseSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												break;
			case "profileperformance" :			$this->layout = "portaldefault";
												$strLoggedUserSessKey = $this->Session->read("0_".$arrLoggedUser['candidate_id']."_sesskey");
												$strLoggedUserEmail = $arrLoggedUser['candidate_email'];
												$strJobUrl = Router::url(array('controller'=>'candidates','action'=>'jobs',$intPassesPortalId),true);
												$this->set('strJobUrl',$strJobUrl);
												$strLatestJobUrl = Router::url(array('controller'=>'candidates','action'=>'latestjobs',$intPassesPortalId),true);
												$this->set('strlatestJobUrl',$strLatestJobUrl);
												$strSaveJobUrl = Router::url(array('controller'=>'candidates','action'=>'savejobs',$intPassesPortalId),true);
												$this->set('strSaveJobUrl',$strSaveJobUrl);
												$strSaveSearchJobUrl = Router::url(array('controller'=>'candidates','action'=>'savesearch',$intPassesPortalId),true);
												$this->set('strSaveSearchJobUrl',$strSaveSearchJobUrl);
												$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
												$this->set('strProfileDetailUrl',$strProfileUrl);
												$strProfileLoginDetailUrl = Router::url(array('controller'=>'candidates','action'=>'logindetail',$intPassesPortalId),true);
												$this->set('strLoginDetailUrl',$strProfileLoginDetailUrl);
												$strProfileCvUrl = Router::url(array('controller'=>'candidates','action'=>'cv',$intPassesPortalId),true);
												$this->set('strProfileCvUrl',$strProfileCvUrl);
												$strProfileCoveringLetterUrl = Router::url(array('controller'=>'candidates','action'=>'cletter',$intPassesPortalId),true);
												$this->set('strProfileCLetterUrl',$strProfileCoveringLetterUrl);
												if($this->params['action'] == "index")
												{
													$strProfileUrl = Router::url(array('controller'=>'candidates','action'=>'profile',$intPassesPortalId),true);
													//$arrSelectedMenu = array('class'=>'selected',"onclick"=>"fnGetPortalUserProfile('".$strProfileUrl."','".$intPassesPortalId."')");
													$arrSelectedMenu = array('class'=>'active');
													
													$this->set("strMenuHomeSelectedText",array());
													$this->set("strMenuRegisterSelectedText",array());
													$this->set("strMenuMyJobSelectedText",array());
													$this->set("strMenuProfileSelectedText",$arrSelectedMenu);
													$this->set("strMenuSettingSelectedText",array());
													$this->set("strMenuJsTrackerSelectedText",array());
													$this->set("strMenuContactUsSelectedText",array());
													$this->set("strMenuLoginSelectedText",array());
													$this->set("strMenuResourcesSelectedText",array());
													$this->set("strMenuWebinarSelectedText",array());
													$this->set("strMenuJsProcessSelectedText",array());
													$strLogoutUrl = Router::url(array('controller'=>'portal','action'=>'logout',$this->params['pass']['0']),true);
													$this->set("strMenuLogoutSelectedText",array('onclick'=>"fnLogoutSeeker('".$strLogoutUrl."','".$intPassesPortalId."','".$strLoggedUserSessKey."','".$strLoggedUserEmail."','".$strPortalName."')"));
												}
												if($this->params['action'] == "matchedjobs")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',"");
													$this->set('activeProfilePerformanceHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												if($this->params['action'] == "appliedjobs")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',"");
													$this->set('activeProfilePerformanceHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												if($this->params['action'] == "jobstoapply")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',"");
													$this->set('activeProfilePerformanceHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												if($this->params['action'] == "scheduledjobsinterview")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',"");
													$this->set('activeProfilePerformanceHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												break;
			case "joblisting" :					$this->layout = "admin";
												if($this->params['action'] == "jobdetail")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeProfilePerformanceHoriNavigationStyle',"");
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												break;
			case "Joblisting" :					$this->layout = "admin";
												if($this->params['action'] == "jobdetail")
												{
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeProfilePerformanceHoriNavigationStyle',"");
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												break;
			case "email" :						$this->layout = "admin";
												if($this->params['action'] == "add")
												{
													
													$strActiveHorizontalNavigationStyle = "text-decoration:none;";
													$this->set('activeDashboardHoriNavigationStyle',$strActiveHorizontalNavigationStyle);
													$this->set('activeProfilePerformanceHoriNavigationStyle',"");
													$this->set('activeHomeHoriNavigationStyle',"");
												}
												break;
		}
		
		
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
    }
	
	public function fnGetCountryDetail($strCountryName="")
	{
		// logic to load countries
		$arrCountryList = array();
		$this->loadModel('Country');
		if($strCountryName)
		{
			$arrCountryList = $this->Country->find('list',array('fields'=>array('Country.country_name','Country.country_id'),'conditions'=>array('country_name'=>$strCountryName)));
		}
			
		ksort($arrCountryList);
		
		return $arrCountryList;
	}
	
	public function fnGetStateDetail($strStateName="")
	{
		//logic to load state's
		$this->loadModel('State');
		$arrListOfStatesForCountry = $this->State->find('list',array('fields'=>array('State.state_name','State.state_id'),"conditions"=>array("state_name LIKE "=>$strStateName."%")));
		
		return $arrListOfStatesForCountry;
	}
	
	public function fnGetCityDetail($strCityName="")
	{
		//logic to load city
		$this->loadModel('City');
		$arrListOfCities = array();
		$arrListOfCities = $this->City->find('list',array('fields'=>array('City.city_name','City.city_id'),"conditions"=>array("City.city_name LIKE "=>$strCityName."%")));
		ksort($arrListOfCities);
		
		/* print("<pre>");
		print_r($arrListOfCities); */
		
		return $arrListOfCities;
	}
	
	public function fnLoadCountryListToPrint($strCountryName = "")
	{
		// logic to load countries
		$arrCountryList = array();
		$this->loadModel('Country');
		if($strCountryName)
		{
			$arrCountryList = $this->Country->find('list',array('fields'=>array('Country.country_name','Country.country_id'),'conditions'=>array('country_name'=>$strCountryName)));
		}
		else
		{
			$arrCountryList = $this->Country->find('list',array('fields'=>array('Country.country_id', 'Country.country_name')));
			$arrCountryList[""] = "Select Your Country";
		}
		
		ksort($arrCountryList);
		
		return $arrCountryList;
	}
	
	public function fnLoadStatesListForCountryToPrint($intCountryId = "")
	{
		//logic to load state's
		$this->loadModel('State');
		$arrListOfStatesForCountry = $this->State->find('list',array('fields'=>array('State.state_id', 'State.state_name'),"conditions"=>array("State.country_id"=>$intCountryId)));
		/* print("<pre>");
		print_r($arrListOfStatesForCountry); */
		$arrListOfStatesForCountry[""] = "Select Your State";
		ksort($arrListOfStatesForCountry);
		
		return $arrListOfStatesForCountry;
	}
	
	public function fnLoadCityListForStateToPrint($intStateId = "")
	{
		//logic to load city
		$this->loadModel('City');
		$arrListOfCities = array();
		$arrListOfCities = $this->City->find('list',array('fields'=>array('City.city_id', 'City.city_name'),"conditions"=>array("City.state_id"=>$intStateId)));
		$arrListOfCities[""] = "Select Your City";
		ksort($arrListOfCities);
		
		/* print("<pre>");
		print_r($arrListOfCities); */
		
		return $arrListOfCities;
	}
	
	public function fnLoadIndustryTypesToPrint()
	{
		$this->loadModel('Industry');
		$arrIndustryList = $this->Industry->find('list',array('fields'=>array('Industry.industry_id', 'Industry.industry_name')));
		$arrIndustryList[""] = "Select Your Industry Type";
		ksort($arrIndustryList);
		return $arrIndustryList;
	}
	
	public function check($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		echo json_encode("abhsdkaj");
		
	}
	
	public function widgetpositionupdate($strMenuOrder = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$strWidgetHolderType = $_REQUEST['widgetholder'];
		
		$arrLoggedUserDetails = $this->Auth->user();
		
		
		$arrMenuOrder = explode(",",$strMenuOrder);
		$intMenuOrderCnt = 0;
		$intWidgetOrderCnt = 0;
		$boolUpdated = "";
		$arr = array();
		foreach($arrMenuOrder as $arrMenuOrderValue)
		{
			$intMenuOrderCnt++;
			if($intMenuOrderCnt == "1")
			{
				continue;
			}
			else
			{
				$intWidgetOrderCnt++;
				
				$arrMenuId = explode("-",$arrMenuOrderValue);
				$arrWidgetDetail = explode("_",$arrMenuId[1]);
				
				if($strWidgetHolderType == "theme")
				{
					$this->loadModel('PortalThemeWidgets');
					$boolUpdated = $this->PortalThemeWidgets->updateAll(
						array('PortalThemeWidgets.widget_order' => "'".$intWidgetOrderCnt."'"),
						array('PortalThemeWidgets.widget_id =' => $arrWidgetDetail[1],'PortalThemeWidgets.career_portal_theme_id =' => $arrWidgetDetail[2],'PortalThemeWidgets.career_portal_id =' => $arrWidgetDetail[0])
					);
				}
				else
				{
					if($strWidgetHolderType == "page")
					{
						$this->loadModel('PortalThemePageWidgets');
						$boolUpdated = $this->PortalThemePageWidgets->updateAll(
							array('PortalThemePageWidgets.widget_order' => "'".$intWidgetOrderCnt."'"),
							array('PortalThemePageWidgets.widget_id =' => $arrWidgetDetail[1],'PortalThemePageWidgets.career_portal_page_id =' => $arrWidgetDetail[2],'PortalThemePageWidgets.career_portal_id =' => $arrWidgetDetail[0])
						);
					}
				}
				/* $log = $this->PortalThemeWidgets->getDataSource()->getLog(false, false);
				$arr[] =  $log; */
			}
			
		}
		if($boolUpdated)
		{
			$arrMenuResult = array();
			$arrMenuResult['status'] = "success";
			$arrMenuResult['message'] = "Widget Order Changed Successfully";
			
			//echo json_encode($arr);
			echo json_encode($arrMenuResult);
			exit;
		}
	}
	
	public function menupositionupdate($strMenuOrder = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		$arrMenuOrder = explode(",",$strMenuOrder);
		$this->loadModel('TopMenu');
		$intMenuOrderCnt = 0;
		$boolUpdated = "";
		foreach($arrMenuOrder as $arrMenuOrderValue)
		{
			$intMenuOrderCnt++;
			$arrMenuId = explode("_",$arrMenuOrderValue);
			$boolUpdated = $this->TopMenu->updateAll(
								array('TopMenu.career_portal_menu_order' => "'".$intMenuOrderCnt."'"),
								array('TopMenu.career_portal_menu_alloc_id =' => $arrMenuId[2])
							);
		}
		if($boolUpdated)
		{
			$arrMenuResult = array();
			$arrMenuResult['status'] = "success";
			$arrMenuResult['message'] = "Menu Order Changed Successfully";
			
			echo json_encode($arrMenuResult);
		}
	}
	
	public function updatesession($intPortalId = "",$strSessKey = "",$intUType = "",$intLmsT = "",$intJobberT = "")
	{
		//echo "HI";exit;
		if($strSessKey)
		{
			$strSessionKey = $strSessKey;
		}
		else
		{
			$strSessionKey = $this->request->data['sesskey'];
		}
		
		if($strSessionKey)
		{
			$this->layout = NULL;
			$this->autoRender = false;
			$arrLoggedUserDetails = $this->Auth->user();
			if($intPortalId)
			{
				$intPortId = $intPortalId;
			}
			else
			{
				$intPortId = $this->request->data['portid'];
			}
			
			if($intUType)
			{
				$intUserType = $intUType;
			}
			else
			{
				$intUserType = $this->request->data['utype'];
			}
			
			if($intLmsT)
			{
				$intLmsToken = $intLmsT;
			}
			else
			{
				$intLmsToken = $this->request->data['lmst'];
			}
			
			if($intJobberT)
			{
				$intJobberToken = $intJobberT;
			}
			else
			{
				$intJobberToken = $this->request->data['jbt'];
			}
			
			
			
			if($intPortId)
			{
				if($intLmsToken)
				{
					/*$this->loadModel('Candidate');
					$boolUpdated = $this->Candidate->updateAll(
						array('Candidate.lms_auth_token' => "'".$strSessionKey."'"),
						array('Candidate.candidate_id =' => $arrLoggedUserDetails['candidate_id'])
					);*/
					$this->Session->write("0_".$arrLoggedUserDetails['candidate_id']."_sesskey", $strSessionKey);
				}
				
				if($intJobberToken)
				{
					/*$this->loadModel('Candidate');
					$boolJobberUpdated = $this->Candidate->updateAll(
						array('Candidate.jb_auth_token' => "'".$intJobberToken."'"),
						array('Candidate.candidate_id =' => $arrLoggedUserDetails['candidate_id'])
					);*/
					
					$strNewSessVar = "current_user_".$arrLoggedUserDetails['candidate_id'];
					$strNewSessLoggedInVar = "current_user_".$arrLoggedUserDetails['candidate_id']."_loggedin_cout";
					
					$this->Session->write($strNewSessVar,$intJobberToken);
					$this->Session->write($strNewSessLoggedInVar,"1");
					
				}
			}
			else
			{
				$this->Session->write($intUserType."_".$arrLoggedUserDetails['id']."_sesskey", $strSessionKey);
			}
			
			
			$arrMenuResult['status'] = "success";
			$arrMenuResult['message'] = $strSessionKey;
			
			if($strSessKey)
			{
				return $arrMenuResult;
			}
			else
			{
				echo json_encode($arrMenuResult);
				exit;
			}
		}
		else
		{
			$this->layout = NULL;
			$this->autoRender = false;
			$arrMenuResult = array();
			$arrMenuResult['status'] = "failure";
			$arrMenuResult['message'] = "Bad Request";
			if($strSessKey)
			{
				return $arrMenuResult;
			}
			else
			{
				echo json_encode($arrMenuResult);
				exit;
			}
		}
	}
	
	public function menudelete($intMenuId)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intMenuId)
		{
			$this->loadModel('TopMenu');
			$intPortalMenuDeleted = $this->TopMenu->deleteAll(array('TopMenu.career_portal_menu_alloc_id' => $intMenuId),false);
			if($intPortalMenuDeleted)
			{
				$arrMenuResult = array();
				$arrMenuResult['status'] = "success";
				$arrMenuResult['message'] = "Menu Deleted successfully";
				
				echo json_encode($arrMenuResult);
			}
		}
	}
	
	public function registereditfield($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();

		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					//echo "--".$_POST['portal_register_fielde'];exit;
					$this->loadModel('RegistrationFormFields');
					$boolUpdated = $this->RegistrationFormFields->updateAll(
						array('RegistrationFormFields.career_portal_registration_form_field_label' => "'".$_POST['portal_register_field_edit_label']."'",'RegistrationFormFields.career_portal_registration_form_field_enabled' => "'".$_POST['portal_register_fielde']."'"),
						array('RegistrationFormFields.career_portal_registration_form_field_id =' => $_POST['portal_register_field_id'],'RegistrationFormFields.career_portal_registration_form_id =' => $_POST['portal_register_form_identifier'])
					);
					if($boolUpdated)
					{
						$this->loadModel('FieldValidation');
						if(isset($_POST['portal_register_fieldmandatory']))
						{
							// inset validation for field
							if($_POST['portal_register_fieldmandatory'] != "0")
							{
								$isValidationPresent = $this->FieldValidation->find('count',array('conditions'=>array('field_id'=>$_POST['portal_register_field_id'],'validation_id'=>'1')));
								if(!$isValidationPresent)
								{
									$arrValidationData = array();
									$arrValidationData['FieldValidation']['field_id'] = $_POST['portal_register_field_id'];
									$arrValidationData['FieldValidation']['validation_id'] = '1';
									$this->FieldValidation->set($arrValidationData);
									$isFieldValidationApplied = $this->FieldValidation->save($arrValidationData);
								}
							}
							else
							{
								if($_POST['portal_register_fieldmandatory'] == "0")
								{
									$intContactFormFieldValidationDeleted = $this->FieldValidation->deleteAll(array('FieldValidation.field_id' => $_POST['portal_register_field_id'],'FieldValidation.validation_id' => '1'),false);
								}
							}
						}
						
						/* $boolUpdated = $this->FieldValidation->updateAll(
								array('FieldValidation.validation_id' => "'".$_POST['validations']."'"),
								array('FieldValidation.field_id =' => $_POST['field_id'])
							); */
						
						$arrResponse = array();
						$arrResponse['status'] = "success";
						$arrResponse['ismandatory'] = $_POST['portal_register_fieldmandatory'];
						$arrResponse['enabeled'] = $_POST['portal_register_fielde'];
						if($_POST['portal_register_fieldmandatory'])
						{
							$arrResponse['manadatorytext'] = "<span id='madatsym_".$_POST['portal_register_field_id']."' class='madatsym'>*</span>";
							$arrResponse['manadatoryclass'] = "validate[required]";
						}
						else
						{
							$arrResponse['manadatorytext'] = "";
							$arrResponse['manadatoryclass'] = "";
						}
						$arrResponse['message'] = "Field Updated Successfully";
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse = array();
						$arrResponse['status'] = "failure";
						$arrResponse['message'] = "Please Try Again";
						//$arrResponse['newimage'] = $strBannerImageName;
						
						echo json_encode($arrResponse);
						exit;
					}
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Bad Request";
					
					echo json_encode($arrResponse);
					exit;
				}
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function editfield($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		// print("<pre>");
		// print_r($this->request->data);
		// exit;
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$this->loadModel('ContactFormFields');
					$boolUpdated = $this->ContactFormFields->updateAll(
						array('ContactFormFields.career_portal_contact_us_form_field_label' => "'".$_POST['field_edit_label']."'",'ContactFormFields.is_contacter_email_field' => "'".$_POST['fieldemail']."'",'ContactFormFields.is_contacter_field_greet_name' => "'".$_POST['greetname']."'",'ContactFormFields.is_contacter_field_message' => "'".$_POST['fieldmessage']."'"),
						array('ContactFormFields.career_portal_contact_us_form_field_id =' => $_POST['field_id'],'ContactFormFields.career_portal_contact_us_form_id =' => $_POST['contact_form_identifier'])
					);
					if($boolUpdated)
					{
						$this->loadModel('FieldValidation');
						if(isset($_POST['fieldmandatory']))
						{
							// inset validation for field
							if($_POST['fieldmandatory'] != "0")
							{
								$isValidationPresent = $this->FieldValidation->find('count',array('conditions'=>array('field_id'=>$_POST['field_id'],'validation_id'=>'1')));
								if(!$isValidationPresent)
								{
									$arrValidationData = array();
									$arrValidationData['FieldValidation']['field_id'] = $_POST['field_id'];
									$arrValidationData['FieldValidation']['validation_id'] = '1';
									$this->FieldValidation->set($arrValidationData);
									$isFieldValidationApplied = $this->FieldValidation->save($arrValidationData);
								}
							}
							else
							{
								if($_POST['fieldmandatory'] == "0")
								{
									$intContactFormFieldValidationDeleted = $this->FieldValidation->deleteAll(array('FieldValidation.field_id' => $_POST['field_id'],'FieldValidation.validation_id' => '1'),false);
								}
							}
						}
						
						/* $boolUpdated = $this->FieldValidation->updateAll(
								array('FieldValidation.validation_id' => "'".$_POST['validations']."'"),
								array('FieldValidation.field_id =' => $_POST['field_id'])
							); */
						
						$arrResponse = array();
						$arrResponse['status'] = "success";
						$arrResponse['greetname'] = $_POST['greetname'];
						$arrResponse['fieldemail'] = $_POST['fieldemail'];
						$arrResponse['messagefield'] = $_POST['fieldmessage'];
						$arrResponse['ismandatory'] = $_POST['fieldmandatory'];
						if($_POST['fieldmandatory'])
						{
							$arrResponse['manadatorytext'] = "<span id='madatsym_".$_POST['field_id']."' class='madatsym'>*</span>";
						}
						else
						{
							$arrResponse['manadatorytext'] = "";
						}
						$arrResponse['message'] = "Field Updated Successfully";
						
						echo json_encode($arrResponse);
						exit;
					}
					else
					{
						$arrResponse = array();
						$arrResponse['status'] = "failure";
						$arrResponse['message'] = "Please Try Again";
						//$arrResponse['newimage'] = $strBannerImageName;
						
						echo json_encode($arrResponse);
						exit;
					}
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Bad Request";
					
					echo json_encode($arrResponse);
					exit;
				}
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function managemenu($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					/* print("<pre>");
					print_r($_POST); */
					
					$this->loadModel('TopMenu');
					$intMenuId = addslashes(trim($_POST['menu_id']));
					$this->request->data['TopMenu']['career_portal_menu_page_id'] = addslashes(trim($_POST['menu_page']));
					$this->request->data['TopMenu']['career_portal_menu_name'] = addslashes(trim($_POST['menu_name']));
					$this->request->data['TopMenu']['career_portal_id'] = $intPortalId;
					$strMenuUrl = Router::url(array('controller' => 'privatelabelsites','action' => 'viewpage',base64_encode($this->request->data['TopMenu']['career_portal_menu_page_id']."_".$intPortalId)),true);
					$this->request->data['TopMenu']['career_portal_menu_link'] = base64_encode($strMenuUrl);
					$this->request->data['TopMenu']['career_portal_menu_createdby'] = $arrLoggedUserDetails['id'];
					
					if($intMenuId)
					{
						// update
						$intMenuAlreadyExists = $this->TopMenu->find('count',array('conditions'=>array('NOT'=>array('career_portal_menu_alloc_id'=>$intMenuId),'career_portal_id'=>$intPortalId,'career_portal_menu_name'=>$this->request->data['TopMenu']['career_portal_menu_name'])));
						if($intMenuAlreadyExists)
						{
							$arrMenuResult = array();
							$arrMenuResult['status'] = "failure";
							$arrMenuResult['message'] = "Menu with this name already exists";
							echo json_encode($arrMenuResult);
						}
						else
						{
							$this->TopMenu->set($this->request->data);
							if($this->TopMenu->validates())
							{
								$boolUpdated = $this->TopMenu->updateAll(
									array('TopMenu.career_portal_menu_page_id' => "'".$this->request->data['TopMenu']['career_portal_menu_page_id']."'",'TopMenu.career_portal_menu_name'=>"'".$this->request->data['TopMenu']['career_portal_menu_name']."'",'TopMenu.career_portal_menu_link'=>"'".$this->request->data['TopMenu']['career_portal_menu_link']."'"),
									array('TopMenu.career_portal_menu_alloc_id =' => $intMenuId)
								);
								if($boolUpdated)
								{
									$arrMenuResult = array();
									$arrMenuResult['status'] = "success";
									$arrMenuResult['message'] = "Menu Updated successfully";
									$arrMenuResult['menulink'] = $strMenuUrl;
									echo json_encode($arrMenuResult);
								}
							}
							else
							{
								$strMenuUpdationErrorMessage = "";
								$arrMenuUpdationErrors = $this->TopMenu->invalidFields();
								if(is_array($arrMenuUpdationErrors) && (count($arrMenuUpdationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrMenuUpdationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strMenuUpdationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strMenuUpdationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrMenuResult = array();
								$arrMenuResult['status'] = "failure";
								$arrMenuResult['message'] = $strMenuUpdationErrorMessage;
								echo json_encode($arrMenuResult);
							}
						}
						
					}
					else
					{
						// insert
						$intMenuAlreadyExists = $this->TopMenu->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId,'career_portal_menu_name'=>$this->request->data['TopMenu']['career_portal_menu_name'])));
						if($intMenuAlreadyExists)
						{
							$arrMenuResult = array();
							$arrMenuResult['status'] = "failure";
							$arrMenuResult['message'] = "Menu with this name already exists";
							echo json_encode($arrMenuResult);
						}
						else
						{
							$this->TopMenu->set($this->request->data);
							if($this->TopMenu->validates())
							{
								$boolPortalMenuCreated = $this->TopMenu->save($this->request->data);
								if($boolPortalMenuCreated)
								{
									$arrMenuResult = array();
									$arrMenuResult['status'] = "success";
									$arrMenuResult['message'] = "Menu created successfully";
									$arrMenuResult['menu_id'] = $this->TopMenu->getLastInsertID();
									$arrMenuResult['menu_link'] = $strMenuUrl;
									echo json_encode($arrMenuResult);
								}
							}
							else
							{
								$strMenuCreationErrorMessage = "";
								$arrMenuCreationErrors = $this->TopMenu->invalidFields();
								if(is_array($arrMenuCreationErrors) && (count($arrMenuCreationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrMenuCreationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strMenuCreationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strMenuCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrMenuResult = array();
								$arrMenuResult['status'] = "failure";
								$arrMenuResult['message'] = $strMenuCreationErrorMessage;
								echo json_encode($arrMenuResult);
							}
						}						
					}
				}
			}
		}
	}

	
	public function copyrighttext($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$this->request->data['Portal']['career_portal_footer_text'] = addslashes(trim($_POST['footer_text']));
					if($this->request->data['Portal']['career_portal_footer_text'] == "")
					{
						$arrResult = array();
						$arrResult['status'] = "failure";
						$arrResult['message'] = "Please Provide Copyright Text";
						
						echo json_encode($arrResult);
					}
					else
					{
						$boolUpdated = $this->Portal->updateAll(
								array('Portal.career_portal_footer_text' => "'".$this->request->data['Portal']['career_portal_footer_text']."'"),
								array('Portal.career_portal_id =' => $intPortalId)
							);
						if($boolUpdated)
						{
							$arrResult = array();
							$arrResult['status'] = "success";
							$arrResult['message'] = "Copyright Text Updated Successfully";
							
							echo json_encode($arrResult);
						}
					}
				}
			}
		}
	}
	
	public function addnewpage($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$arrPortPageDetail = explode("_",base64_decode($intPortalId));
				
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$arrPortPageDetail[1])));
				if($intPortlExists)
				{
					
					$this->loadModel('PortalPages');
					//$intPortlPagesExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					//$strId = base64_decode($_POST['pagedetail']);
					$intPortalId = base64_decode($_POST['portid']);
					$this->request->data['PortalPages']['career_portal_page_tittle'] = addslashes(trim($_POST['add_page_name']));
					$this->request->data['PortalPages']['career_portal_page_content'] = htmlspecialchars($_POST['add_new_page_data']);
					$this->request->data['PortalPages']['career_portal_id'] = $intPortalId;
					$this->request->data['PortalPages']['career_portal_page_template'] = $_POST['page_template'];
					$this->request->data['PortalPages']['career_portal_page_createdby'] = $arrLoggedUserDetails['id'];

					// insert
					/*$intPortlPagesWithExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_page_tittle'=>$this->request->data['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$intPortalId)));
					if($intPortlPagesWithExists)
					{
						$arrResult = array();
						$arrResult['status'] = "failure";
						$arrResult['message'] = "Page with this title already exists";
						
						echo json_encode($arrResult);
						exit;
					}
					else
					{*/
						$this->PortalPages->set($this->request->data);
						if($this->PortalPages->validates())
						{
							$boolPortalPageCreated = $this->PortalPages->save($this->request->data);
							$intPageId = $this->PortalPages->getLastInsertID();
							if($boolPortalPageCreated)
							{
								$arrResult = array();
								$arrResult['status'] = "success";
								$arrResult['message'] = "Page created successfully";
								$arrResult['createdPageId'] = $intPageId;
								$arrResult['createdpageName'] = $this->request->data['PortalPages']['career_portal_page_tittle'];
								
								echo json_encode($arrResult);
								exit;
							}
						}
						else
						{
							$strPageCreationErrorMessage = "";
							$arrPageCreationErrors = $this->PortalPages->invalidFields();
							if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
							{
								$intForIterateCount = 0;
								foreach($arrPageCreationErrors as $errorVal)
								{
									$intForIterateCount++;
									if($intForIterateCount == 1)
									{
										$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
									}
									else
									{
										$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
									}
								}
							}
							$arrResult = array();
							$arrResult['status'] = "failure";
							$arrResult['message'] = $strPageCreationErrorMessage;
							
							echo json_encode($arrResult);
							exit;
						}
					//}
				}
			}
		}
	}
	
	public function removeportalpage($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					
					$this->loadModel('PortalPages');
					//$intPortlPagesExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					$strId = base64_decode($_POST['pagedetail']);
					$arrPageDetail = explode("_",$strId);
					
					if($arrPageDetail['0'])
					{
						$intPortalPageDeleted = $this->PortalPages->deleteAll(array('career_portal_page_id' => $arrPageDetail['0']),false);
						if($intPortalPageDeleted)
						{
							$arrResult = array();
							$arrResult['status'] = "success";
							$arrResult['message'] = "Page Updated successfully";
							
							echo json_encode($arrResult);
						}
					}
					else
					{
						$arrResult = array();
						$arrResult['status'] = "fail";
						$arrResult['message'] = "Parameter Missing";
						
						echo json_encode($arrResult);
					}
				}
			}
		}
		exit;
	}
	
	public function updatepagedata($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					
					$this->loadModel('PortalPages');
					//$intPortlPagesExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					$strId = base64_decode($_POST['pagedetail']);
					$arrPageDetail = explode("_",$strId);
					$this->request->data['PortalPages']['career_portal_page_tittle'] = addslashes(trim($_POST['page_name']));
					$this->request->data['PortalPages']['career_portal_page_content'] = htmlspecialchars($_POST['page_data']);
					$this->request->data['PortalPages']['career_portal_id'] = $intPortalId;
					$this->request->data['PortalPages']['career_portal_page_createdby'] = $arrLoggedUserDetails['id'];
					$this->request->data['PortalPages']['is_career_portal_home_page'] = addslashes(trim($_POST['homepage']));
					$this->request->data['PortalPages']['career_portal_page_template'] = $_POST['page_edit_template'];
					
					if($arrPageDetail['0'])
					{
						// update
						/*$intPortlPagesWithExists = $this->PortalPages->find('count',array('conditions'=>array('NOT'=>array('career_portal_page_id'=>$arrPageDetail['0']),'career_portal_page_tittle'=>$this->request->data['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$intPortalId)));
						if($intPortlPagesWithExists)
						{
							$arrResult = array();
							$arrResult['status'] = "failure";
							$arrResult['message'] = "Page with this title already exists";
							
							echo json_encode($arrResult);
						}
						else
						{*/
							$this->PortalPages->set($this->request->data);
							if($this->PortalPages->validates())
							{
								$boolUpdated = $this->PortalPages->updateAll(
									array('PortalPages.career_portal_page_tittle' => "'".$this->request->data['PortalPages']['career_portal_page_tittle']."'",'PortalPages.career_portal_page_content'=>"'".$this->request->data['PortalPages']['career_portal_page_content']."'",'PortalPages.career_portal_page_template'=>"'".$this->request->data['PortalPages']['career_portal_page_template']."'"),
									array('PortalPages.career_portal_page_id =' => $arrPageDetail['0'])
								);
								
								if($boolUpdated)
								{
									$arrResult = array();
									$arrResult['status'] = "success";
									$arrResult['message'] = "Page Updated successfully";
									
									echo json_encode($arrResult);
								}
							}
							else
							{
								$strPageCreationErrorMessage = "";
								$arrPageCreationErrors = $this->PortalPages->invalidFields();
								if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrPageCreationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrResult = array();
								$arrResult['status'] = "failure";
								$arrResult['message'] = $strPageCreationErrorMessage;
								
								echo json_encode($arrResult);
							}
						//}
					}
					else
					{
						// insert
						/*$intPortlPagesWithExists = $this->PortalPages->find('count',array('conditions'=>array('career_portal_page_tittle'=>$this->request->data['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$intPortalId)));
						if($intPortlPagesWithExists)
						{
							$arrResult = array();
							$arrResult['status'] = "failure";
							$arrResult['message'] = "Page with this title already exists";
							
							echo json_encode($arrResult);
						}
						else
						{*/
							$this->PortalPages->set($this->request->data);
							if($this->PortalPages->validates())
							{
								$boolPortalPageCreated = $this->PortalPages->save($this->request->data);
								$intPageId = $this->PortalPages->getLastInsertID();
								if($boolPortalPageCreated)
								{
									$arrResult = array();
									$arrResult['status'] = "success";
									$arrResult['message'] = "Page created successfully";
									$arrResult['pagedetail'] = base64_encode($intPageId."_".$intPortalId);
									
									echo json_encode($arrResult);
								}
							}
							else
							{
								$strPageCreationErrorMessage = "";
								$arrPageCreationErrors = $this->PortalPages->invalidFields();
								if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
								{
									$intForIterateCount = 0;
									foreach($arrPageCreationErrors as $errorVal)
									{
										$intForIterateCount++;
										if($intForIterateCount == 1)
										{
											$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
										}
										else
										{
											$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
										}
									}
								}
								$arrResult = array();
								$arrResult['status'] = "failure";
								$arrResult['message'] = $strPageCreationErrorMessage;
								
								echo json_encode($arrResult);
							}
						//}
					}
				}
			}
		}
	}
	
	public function addsocialmediabutton($intPortalId = "")
	{
		$intRegisterFormId = $_REQUEST['registerformid'];
		$intRegisterSocialButtonId = $_REQUEST['registersocialmediabuttonid'];
		
		if($intPortalId && $intRegisterFormId && $intRegisterSocialButtonId)
		{
			$this->loadModel('RegistrationSocialMedialField');
			$intSocialMediaExists = $this->RegistrationSocialMedialField->find('count',array('conditions'=>array('career_portal_registration_form_id'=>$intRegisterFormId,'career_portal_registration_social_plugin_id'=>$intRegisterSocialButtonId)));
			if($intSocialMediaExists)
			{
				$arrResponse = array();
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Social Media Button Already Exists!";
				//$arrResponse['newimage'] = $strBannerImageName;
				
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrRegisterSocialMedialData = array();
				$arrRegisterSocialMedialData['RegistrationSocialMedialField']['career_portal_registration_form_id'] = $intRegisterFormId;
				$arrRegisterSocialMedialData['RegistrationSocialMedialField']['career_portal_registration_social_plugin_id'] = $intRegisterSocialButtonId;
				$intSaved = $this->RegistrationSocialMedialField->save($arrRegisterSocialMedialData);
				if($intSaved)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Social Media Button Added Successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			//$arrResponse['newimage'] = $strBannerImageName;
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function hidesocialmediabutton($intPortalId = "")
	{
		$intRegisterFormId = $_REQUEST['registerformid'];
		$intRegisterSocialButtonId = $_REQUEST['registersocialmediabuttonid'];
		
		if($intPortalId && $intRegisterFormId && $intRegisterSocialButtonId)
		{
			$this->loadModel('RegistrationSocialMedialField');
			$intSocialMediaExists = $this->RegistrationSocialMedialField->find('count',array('conditions'=>array('career_portal_registration_form_id'=>$intRegisterFormId,'career_portal_registration_social_plugin_id'=>$intRegisterSocialButtonId)));
			if($intSocialMediaExists)
			{
				$intRegistrationSocialButtonDeleted = $this->RegistrationSocialMedialField->deleteAll(array('RegistrationSocialMedialField.career_portal_registration_form_id' => $intRegisterFormId,'RegistrationSocialMedialField.career_portal_registration_social_plugin_id' => $intRegisterSocialButtonId),false);
				if($intRegistrationSocialButtonDeleted)
				{
					$intSocialMediaPluginCount = $this->RegistrationSocialMedialField->find('count',array('conditions'=>array('career_portal_registration_form_id'=>$intRegisterFormId,'career_portal_registration_social_plugin_id'=>$intRegisterSocialButtonId)));
					if(!$intSocialMediaPluginCount)
					{
						$this->loadModel('RegistrationFormFields');
						$boolUpdated = $this->RegistrationFormFields->updateAll(
							array('RegistrationFormFields.career_registration_form_is_social_media'=>"'0'"),
							array('RegistrationFormFields.career_registration_form_id =' => $intRegisterFormId,'RegistrationFormFields.career_portal_id'=>$intPortalId)
						);
					}
					
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Social Media Button Removed Successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
			else
			{
				$arrResponse = array();
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "Social Media has already been Removed!";
				//$arrResponse['newimage'] = $strBannerImageName;
				
				echo json_encode($arrResponse);
				exit;
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			//$arrResponse['newimage'] = $strBannerImageName;
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function disablewidget($intPortalId = "")
	{
		$intWidgetId = $_REQUEST['widgetid'];
		$intHolderId = $_REQUEST['widgetholderid'];
		$strWidgetHolder = $_REQUEST['widgetholder'];
		
		if($intPortalId && $intWidgetId && $intHolderId)
		{
			if($strWidgetHolder == "page")
			{
				$this->loadModel('PortalThemePageWidgets');
				$intPortalPageWidgetDeleted = $this->PortalThemePageWidgets->deleteAll(array('PortalThemePageWidgets.career_portal_id' => $intPortalId,'PortalThemePageWidgets.career_portal_page_id' => $intHolderId,'PortalThemePageWidgets.widget_id' => $intWidgetId),false);
				if($intPortalPageWidgetDeleted)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Disabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
			else
			{
				$this->loadModel('PortalThemeWidgets');
				$intPortalThemeWidgetDeleted = $this->PortalThemeWidgets->deleteAll(array('PortalThemeWidgets.career_portal_id' => $intPortalId,'PortalThemeWidgets.career_portal_theme_id' => $intHolderId,'PortalThemeWidgets.widget_id' => $intWidgetId),false);
				if($intPortalThemeWidgetDeleted)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Disabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			//$arrResponse['newimage'] = $strBannerImageName;
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function enablewidget($intPortalId = "")
	{
		$intWidgetId = $_REQUEST['widgetid'];
		$intHolderId = $_REQUEST['widgetholderid'];
		$strWidgetHolder = $_REQUEST['widgetholder'];
		
		if($intPortalId && $intWidgetId && $intHolderId)
		{
			if($strWidgetHolder == "page")
			{
				$arrPageWidget = array();
				$this->loadModel('PortalThemePageWidgets');
				$arrPageWidget['PortalThemePageWidgets']['career_portal_page_id'] = $intHolderId;
				$arrPageWidget['PortalThemePageWidgets']['career_portal_id'] = $intPortalId;
				$arrPageWidget['PortalThemePageWidgets']['widget_id'] = $intWidgetId;
				$boolCreated = $this->PortalThemePageWidgets->save($arrPageWidget);
				if($boolCreated)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Enabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}
			else
			{	
				$arrThemeWidget = array();
				$this->loadModel('PortalThemeWidgets');
				$arrThemeWidget['PortalThemeWidgets']['career_portal_theme_id'] = $intHolderId;
				$arrThemeWidget['PortalThemeWidgets']['career_portal_id'] = $intPortalId;
				$arrThemeWidget['PortalThemeWidgets']['widget_id'] = $intWidgetId;
				$boolCreated = $this->PortalThemeWidgets->save($arrThemeWidget);
				if($boolCreated)
				{
					$arrResponse = array();
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "Widget Enabled successfully";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
				else
				{
					$arrResponse = array();
					$arrResponse['status'] = "failure";
					$arrResponse['message'] = "Please Try Again";
					//$arrResponse['newimage'] = $strBannerImageName;
					
					echo json_encode($arrResponse);
					exit;
				}
			}			
		}
		else
		{
			$arrResponse = array();
			$arrResponse['status'] = "failure";
			$arrResponse['message'] = "Bad Request";
			//$arrResponse['newimage'] = $strBannerImageName;
			
			echo json_encode($arrResponse);
			exit;
		}
	}
	
	public function updateportalbannerimage($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$arrPortalDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
					{
						if(is_array($_FILES) && (count($_FILES)>0))
						{
							$arrImageAllowedExtension = array('jpg','JPG','JPEG','jpeg','png','PNG','bmp','BMP','gif','GIF');
							
							if($_FILES['banner_image_name']['name'] != "")
							{
								$strFileExt = pathinfo($_FILES['banner_image_name']['name'], PATHINFO_EXTENSION);
								if(in_array($strFileExt,$arrImageAllowedExtension))
								{
									move_uploaded_file($_FILES['banner_image_name']['tmp_name'], WWW_ROOT . 'img/theme/default/img/' .$_FILES['banner_image_name']['name']);
									$strBannerImageName = $_FILES['banner_image_name']['name'];
									$this->loadModel('PortalTheme');
									$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($intPortalId);
									if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
									{
										$inThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
										$this->loadModel('Theme');
										$boolUpdated = $this->Theme->updateAll(
											array('Theme.theme_top_banner_image'=>"'".$strBannerImageName."'"),
											array('Theme.theme_id =' => $inThemeId)
										);
										if($boolUpdated)
										{
											$arrResponse = array();
											$arrResponse['status'] = "success";
											$arrResponse['message'] = "Banner Image updated successfully";
											$arrResponse['newimage'] = $strBannerImageName;
											
											echo json_encode($arrResponse);
											exit;
										}										
									}
								}
								else
								{
									$arrResponse = array();
									$arrResponse['status'] = "failure";
									$arrResponse['message'] = "Banner Image type not supported";
									
									echo json_encode($arrResponse);
									exit;
								}
							}
							else
							{
								$arrResponse = array();
								$arrResponse['status'] = "failure";
								$arrResponse['message'] = "Please Provide Banner Image.";
								
								echo json_encode($arrResponse);
								exit;
							}
						}
					}
				}
			}
		}
	}
	
	
	public function updateportallogo($intPortalId = "")
	{
		$this->layout = NULL;
		$this->autoRender = false;
		$arrLoggedUserDetails = $this->Auth->user();
		if($intPortalId)
		{
			if($this->Auth->loggedIn())
			{
				$this->loadModel('Portal');
				$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
				if($intPortlExists)
				{
					$arrPortalDetail = $this->Portal->find('all',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
					{
						if(is_array($_FILES) && (count($_FILES)>0))
						{
							$arrImageAllowedExtension = array('jpg','JPG','JPEG','jpeg','png','PNG','bmp','BMP','gif','GIF');
							
							if($_FILES['portal_logo']['name'] != "")
							{
								$strFileExt = pathinfo($_FILES['portal_logo']['name'], PATHINFO_EXTENSION);
								if(in_array($strFileExt,$arrImageAllowedExtension))
								{
									$strPortalName = addslashes(trim($_POST['portal_name']));
									
									$strPortalLogo = $arrPortalDetail[0]['Portal']['career_portal_logo'];
									$strPortalThumbLogo = $arrPortalDetail[0]['Portal']['career_portal_thumb_logo'];
									$strPortalNewLogoName = $this->fnGeneratePortalName($_FILES['portal_logo']['name'],$strPortalName,$arrLoggedUserDetails['id']);
									$strPortalNewThumbLogoName = $this->fnGeneratePortalThumbLogo($_FILES['portal_logo']['name'],$strPortalName,$arrLoggedUserDetails['id']);
									unlink(WWW_ROOT.'/userdata/portal/'.$strPortalLogo);
									unlink(WWW_ROOT.'/userdata/portal/'.$strPortalThumbLogo);
									move_uploaded_file($_FILES['portal_logo']['tmp_name'], WWW_ROOT . 'userdata/portal/' .$strPortalNewLogoName);
									$input_file =  WWW_ROOT . 'userdata/portal/' . $strPortalNewLogoName;
									$output_file = WWW_ROOT . 'userdata/portal/' . $strPortalNewThumbLogoName;
									$this->resizeImage($input_file, $output_file, '100', '40');
									$boolUpdated = $this->Portal->updateAll(
											array('Portal.career_portal_name'=>"'".$strPortalName."'",'Portal.career_portal_thumb_logo'=>"'".$strPortalNewThumbLogoName."'",'Portal.career_portal_logo'=>"'".$strPortalNewLogoName."'"),
											array('Portal.career_portal_id =' => $intPortalId)
										);
									if($boolUpdated)
									{
										$arrResponse = array();
										$arrResponse['status'] = "success";
										$arrResponse['message'] = "Logo updated successfully";
										$arrResponse['newimage'] = $strPortalNewLogoName;
										
										echo json_encode($arrResponse);
									}
								}
								else
								{
									$arrResponse = array();
									$arrResponse['status'] = "failure";
									$arrResponse['message'] = "Logo type not supported";
									
									echo json_encode($arrResponse);
								}
							}
							else
							{
								$arrResponse = array();
								$arrResponse['status'] = "failure";
								$arrResponse['message'] = "Please Provide the Logo.";
								
								echo json_encode($arrResponse);
							}
						}
					}
				}
			}
		}
	}
	
	public function updatenewjobnotificationevent($arrNewJobForNotification = array())
	{
		$arrResponse = array();
		if(is_array($arrNewJobForNotification['latestjobcandidates']) && (count($arrNewJobForNotification['latestjobcandidates'])>0))
		{	
			$isNotifiedThroughEmail = "";
			$isSystemNotified = "";
			foreach($arrNewJobForNotification['latestjobcandidates'] as $arrNewJobNotification)
			{
				$arrCandidatesToNotified = $arrNewJobNotification['candidates'];
				$arrNewJobEvent = $arrNewJobNotification['job'];
				
				if(is_array($arrCandidatesToNotified) && (count($arrCandidatesToNotified)>0))
				{
					//$arrResponse['candidates'] = $arrCandidatesToNotified;
					//$arrResponse['newjobs'] = $arrNewJobEvent;
					
					foreach($arrCandidatesToNotified as $arrCandidates)
					{
						// add new job event for candidates
						// add a system notification
						// add a email notification
						
						$arrEventData = array();
						$strNotificationSubject = $arrEventData['Event']['event_name'] = "New Job Match";
						$arrEventData['Event']['event_description'] = "New Job ".$arrNewJobEvent['job_title']." Matching to your CV was added recently";
						$arrEventData['Event']['event_date_time'] = $arrNewJobEvent['created_at'];
						$arrEventData['Event']['event_venue'] = "Url for the job";
						$arrEventData['Event']['event_type'] = "New Job";
						$arrEventData['Event']['event_created_by'] = $arrNewJobEvent['fk_hc_employer_id'];
						
						$arrEventData['Eventparticipant']['event_participant_type'] = "Candidates";
						$arrEventData['Eventparticipant']['event_participant_id'] = $arrCandidates['hc_uid'];
						$arrEventData['Eventparticipant']['event_participant_reg_by'] = $arrCandidates['hc_uid'];
						
						$arrEventData['Eventorganizer']['event_organizer_type'] = "Portal";
						$arrEventData['Eventorganizer']['event_organizer_head_id'] = $arrNewJobEvent['fk_hc_portal_id'];
						$arrEventData['Eventorganizer']['event_organization_registered_by'] = $arrNewJobEvent['fk_hc_employer_id'];
						
						
						$arrEventData['Eventsubject']['event_subject_type'] = "Job";
						$arrEventData['Eventsubject']['event_subject_id'] = $arrNewJobEvent['id'];
						$arrEventData['Eventsubject']['event_subject_registered_by'] = $arrNewJobEvent['fk_hc_employer_id'];
						
						$this->loadModel('Event');
						$this->Event->create(false);
						$boolEventCreated = $this->Event->save($arrEventData);
						if($boolEventCreated)
						{
							$arrEventData['Eventsubject']['event_id'] = $arrEventData['Eventorganizer']['event_id'] = $arrEventData['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
							$this->loadModel('Eventparticipant');
							$this->Eventparticipant->create(false);
							$this->Eventparticipant->save($arrEventData);
							$this->loadModel('Eventorganizer');
							$this->Eventorganizer->create(false);
							$this->Eventorganizer->save($arrEventData);
							$this->loadModel('Eventsubject');
							$this->Eventsubject->create(false);
							$this->Eventsubject->save($arrEventData);
							
							// end of adding new event
							
							// start system notification
							$this->loadModel('Notification');
							$arrSystemNotification = array();
							$arrSystemNotification['Notification']['candidate_id'] = $arrCandidates['hc_uid'];
							$arrSystemNotification['Notification']['reminder_type'] = 'event';
							$arrSystemNotification['Notification']['reminder_id'] = $arrEventData['Eventsubject']['event_id'];
							$this->Notification->create(false);
							$isSystemNotified = $this->Notification->save($arrSystemNotification);
							// end of system notification
							
							// start of email notification
							$this->loadModel('Candidate');
							$arrCandidateDetail = $this->Candidate->find('all',array('conditions'=>array('candidate_id'=>$arrCandidates['hc_uid'])));
							$isNotifiedThroughEmail = $this->fnSendReminderMail($arrCandidateDetail[0]['Candidate']['candidate_username'],$arrCandidateDetail[0]['Candidate']['candidate_email'],$arrEventData['Event']['event_description'],$strNotificationSubject);
							// end of email notification
						}
					}
					
				}
				$this->loadModel('Job');
				//$boolUpdated = $this->Job->updateAll(array('Job.nw_job_notification' => "'1'"),array('Job.id =' =>$arrNewJobEvent['id']));
				$boolUpdated = $this->Job->fnUpdateJobAfterNotification($arrNewJobEvent['id']);
			}
			
			if($isNotifiedThroughEmail && $isSystemNotified)
			{
				return true;
				//$arrResponse['status'] = "Success";
				//$arrResponse['message'] = "No candidates for notification";
			}
			else
			{
				return false;
			}
		}
	}
	
	
	public function updateevent($intPortalId = "")
	{		
		//if($this->request->is('Post'))
		//{
			if($intPortalId)
			{
				/* if($this->Auth->loggedIn())
				{ */
					//$arrLoggedUserDetails = $this->Auth->user();
					$this->loadModel('Portal');
					$intPortlExists = $this->Portal->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId)));
					
					if($intPortlExists)
					{
						$arrEventDetail = array();
						$this->request->data['Event']['event_name'] = $arrEventDetail['eventname'] = $strEventName = addslashes(trim($_POST['event_name']));
						$this->request->data['Event']['event_description'] = $arrEventDetail['eventdesc'] = $strEventDescription = addslashes(trim($_POST['event_dsec']));
						$this->request->data['Event']['event_date_time'] = $arrEventDetail['eventdatetime'] = $strEventdatetime = addslashes(trim($_POST['event_date_time']));
						$this->request->data['Event']['event_venue'] = $arrEventDetail['eventvenu'] = $strEventVenue = addslashes(trim($_POST['event_venue']));
						$this->request->data['Event']['event_contact_person'] = $arrEventDetail['eventcontactperson'] = $strEventContactPerson = addslashes(trim($_POST['event_contact_name']));
						$this->request->data['Event']['event_reminder'] = $arrEventDetail['eventreminder'] = $strEventReminder = addslashes(trim($_POST['event_reminder']));
						$this->request->data['Reminder']['reminder_frequency'] = $arrEventDetail['eventreminderfrequency'] = $strEventReminderFrequency = "";
						if($strEventReminder)
						{
							$this->request->data['Reminder']['reminder_frequency'] = $arrEventDetail['eventreminderfrequency'] = $strEventReminderFrequency = addslashes(trim($_POST['event_reminder_frequency']));
						}
						$this->request->data['Event']['event_type'] = $arrEventDetail['eventtype'] = $strEventType = addslashes(trim($_POST['event_type']));
						
						$this->request->data['Eventparticipant']['event_participant_type'] = $arrEventDetail['eventparticipanttype'] = $strEventParticipantType = addslashes(trim($_POST['participant_type']));
						$this->request->data['Eventparticipant']['event_participant_id'] = $arrEventDetail['eventparticipantid'] = $strEventParticipantId = addslashes(trim($_POST['participant_id']));
						$this->request->data['Eventparticipant']['event_participant_reg_by'] = addslashes(trim($_POST['participant_id']));
						
						$this->request->data['Eventorganizer']['event_organizer_type'] = $arrEventDetail['eventorganizationtype'] = $strEventOrganizerType = addslashes(trim($_POST['organization_type']));
						$this->request->data['Eventorganizer']['event_organizer_head_id'] = $arrEventDetail['eventorganizerid'] = $strEventOrganizerId = addslashes(trim($_POST['organization_head_id']));
						$this->request->data['Eventorganizer']['event_organization_registered_by'] = addslashes(trim($_POST['participant_id']));
						
						$this->request->data['Eventsubject']['event_subject_type'] = $arrEventDetail['eventsubjecttype'] = $strEventSubjectType = addslashes(trim($_POST['event_subject_type']));
						$this->request->data['Eventsubject']['event_subject_id'] = $arrEventDetail['eventsubjectid'] = $strEventSubjectId = addslashes(trim($_POST['event_subject_id']));
						$this->request->data['Eventsubject']['event_subject_registered_by'] = addslashes(trim($_POST['participant_id']));
						
						$arrEventDetail['creadtedby'] = addslashes(trim($_POST['participant_id']));
						
						/*print("<pre>");
						print_r($this->request->data['Eventparticipant']);
						exit;*/
						
						$this->loadModel('Event');
						$boolEventExistis = $this->Event->fnCheckEventExists($arrEventDetail);
						if($boolEventExistis)
						{
							// update event
							
							/*$this->Event->fnDeleteExistingEvent($arrEventDetail);
							$boolEventCreated = $this->Event->save($this->request->data);
							if($boolEventCreated)
							{
								$this->request->data['Eventsubject']['event_id'] = $this->request->data['Eventorganizer']['event_id'] = $this->request->data['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
								$this->loadModel('Eventparticipant');
								$this->Eventparticipant->save($this->request->data);
								$this->loadModel('Eventorganizer');
								$this->Eventorganizer->save($this->request->data);
								$this->loadModel('Eventsubject');
								$this->Eventsubject->save($this->request->data);
								
								$arrReturn = array();
								$arrReturn['status'] = "success";
								$arrReturn['message'] = "Your Reminder was added successfully";
							}
							else
							{
								$arrReturn = array();
								$arrReturn['status'] = "failure";
								$arrReturn['message'] = "Please try again";
							}*/
							$arrReturn = array();
							$arrReturn['status'] = "failure";
							$arrReturn['message'] = "You have already set Reminder for this event";
						}
						else
						{
							//insert event
							//$boolEventCreated = $this->Event->fnSaveEvent($arrEventDetail);
							$boolEventCreated = $this->Event->save($this->request->data);
							/* print("<pre>");
							print_r($boolEventCreated);
							exit; */
							if($boolEventCreated)
							{
								$this->request->data['Reminder']['reminder_type_id'] = $this->request->data['Eventsubject']['event_id'] = $this->request->data['Eventorganizer']['event_id'] = $this->request->data['Eventparticipant']['event_id'] = $this->Event->getLastInsertID();
								$this->loadModel('Eventparticipant');
								$this->Eventparticipant->save($this->request->data);
								$this->loadModel('Eventorganizer');
								$this->Eventorganizer->save($this->request->data);
								$this->loadModel('Eventsubject');
								$this->Eventsubject->save($this->request->data);
								
								$this->loadModel('Reminder');
								$this->request->data['Reminder']['reminder_status'] = "active";
								$this->request->data['Reminder']['reminder_created_by'] = addslashes(trim($_POST['participant_id']));
								$objTimeComponent = $this->Components->load('TimeCalculation');
								
								$this->request->data['Reminder']['reminder_time'] = $objTimeComponent->fnGetBeforeTime($arrEventDetail['eventreminderfrequency'],$arrEventDetail['eventdatetime']);
								$this->request->data['Reminder']['reminder_text'] = $arrEventDetail['eventdesc'];
								$this->Reminder->fnInsertReminder($this->request->data['Reminder']);
								//$this->Reminder->save($this->request->data);
								
								$arrReturn = array();
								$arrReturn['status'] = "success";
								$arrReturn['message'] = "Your Reminder was added successfully";
							}
							else
							{
								$arrReturn = array();
								$arrReturn['status'] = "failure";
								$arrReturn['message'] = "Please try again";
							}
						}
					}
				/* }
				else
				{
					$arrReturn = array();
					$arrReturn['status'] = "failure";
					$arrReturn['message'] = "Not Logged In";
				} */
			}
			else
			{
				$arrReturn = array();
				$arrReturn['status'] = "failure";
				$arrReturn['message'] = "Organizer Missing";
			}
		/* }
		else
		{
			$arrReturn = array();
			$arrReturn['status'] = "failure";
			$arrReturn['message'] = "Bad Request";
		} */
		
		echo json_encode($arrReturn);
		exit;
	}
	
	public function getlocation()
	{
		$this->layout = NULL;
		$this->autoRender = false;
		
		$arrRsponse = array();
		if($this->request->is('Post'))
		{
			$strZipCode = $this->request->data['zip'];
			$compLocator = $this->Components->load('Locator');
			$arrLocationDetail = $compLocator->fnGetLocationDetail($strZipCode);
			if($arrLocationDetail['status'] == "OK")
			{
				$arrRsponse['status'] = "success";
				if(is_array($arrLocationDetail['results']['0']['address_components']) && (count($arrLocationDetail['results']['0']['address_components'])>0))
				{
					foreach($arrLocationDetail['results']['0']['address_components'] as $arrLocationDetails)
					{
						if($arrLocationDetails['types'][0] == "locality")
						{
							$arrRsponse['locality'] = $arrLocationDetails['long_name'];
						}
						
						if($arrLocationDetails['types'][0] == "administrative_area_level_2")
						{
							$arrRsponse['city'] = $arrLocationDetails['long_name'];
						}
						
						if($arrLocationDetails['types'][0] == "administrative_area_level_1")
						{
							$arrRsponse['state'] = $arrLocationDetails['long_name'];
							$arrRsponse['statecd'] = $arrLocationDetails['short_name'];
						}
						
						if($arrLocationDetails['types'][0] == "country")
						{
							$arrRsponse['country'] = $arrLocationDetails['long_name'];
							$arrRsponse['countrycd'] = $arrLocationDetails['short_name'];
						}
					}
				}
				if($arrRsponse['country'])
				{
					$arrCountryDetail = $this->fnGetCountryDetail($arrRsponse['country']);
					$arrRsponse['countrycdval'] = array_pop($arrCountryDetail);
				}
				
				if($arrRsponse['state'])
				{
					$arrStateDetail = $this->fnGetStateDetail($arrRsponse['state']);
					$arrRsponse['statecdval'] = array_pop($arrStateDetail);
				}
				
				if($arrRsponse['city'])
				{
					$arrCityDetail = $this->fnGetCityDetail($arrRsponse['city']);
					$arrRsponse['cityval'] = array_pop($arrCityDetail);
				}
				
				
				echo json_encode($arrRsponse);exit;
			}
			else
			{
				$arrRsponse['status'] = "fail";
				echo json_encode($arrRsponse);exit;
			}
			
		}
	}
	
	public function states($intCountryId = "",$intWithHtml = 0)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		
		if($intCountryId)
		{
			$arrStateList = $this->fnLoadStatesListForCountryToPrint($intCountryId);
			$this->set('arrStateList',$arrStateList);
			$this->set('intWithHtml',$intWithHtml);
			$arrCityList = $this->fnLoadCityListForStateToPrint("");
			$this->set('arrCityList',$arrCityList);
			$this->render('/Elements/states');
		}
		else
		{
			return false;
		}
		//exit;
	}
	
	public function cities($intStateId = "",$intWithHtml = 0)
	{
		$this->layout = NULL;
		$this->autoRender = false;
		
		if($intStateId)
		{
			$arrCityList = $this->fnLoadCityListForStateToPrint($intStateId);
			$this->set('intWithHtml',$intWithHtml);
			$this->set('arrCityList',$arrCityList);
			$this->render('/Elements/cities');
		}
		else
		{
			return false;
		}
		//exit;
	}
	
	public function fnResourceTransactionNotificationVendor($arrVendorDetail = array(),$strPortalName = "", $strServiceName = "")
	{
		if(is_array($arrVendorDetail) && (count($arrVendorDetail)>0))
		{
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config(array('transport' => 'Smtp','host' => 'ssl://smtp.gmail.com','port' => 465,'timeout' => '30','username' => 'rajendra.kandpal@redorangetechnologies.com','password' => 'rajendra12'));
			$Email->sender('admin@hc.com', 'HC');
			$Email->from(array('admin@hc.com' => 'HC'));
//			$Email->to(array('arjun.gunjal@redorangetechnologies.com'=>'Arjun Gunjal'));
			$Email->to(array($arrVendorDetail[0]['Vendors']['vendor_email']=>$arrVendorDetail[0]['Vendors']['vendor_name']));
			$Email->subject('New Order');
			$Email->emailFormat('html');
			$Email->template('new_vendor_order', 'default');
			$Email->viewVars(array('first_name' => $arrVendorDetail[0]['Vendors']['vendor_name']));
			$Email->viewVars(array('portal_name' => $strPortalName));
			$Email->viewVars(array('service_name' => $strServiceName));
			if($Email->send())
			{
				return true;
			}
			else
			{
				//echo "Mail Not Send";
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnSendEmail($strToAdd,$strSubject = "", $strMessage = "")
	{
		//echo "--".$strMessage;exit;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config(array('transport' => 'Smtp','host' => 'ssl://smtp.gmail.com','port' => 465,'timeout' => '30','username' => 'rajendra.kandpal@redorangetechnologies.com','password' => 'rajendra12'));
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to($strToAdd);
		$Email->subject($strSubject);
		//$Email->message($strMessage);
		$Email->emailFormat('html');
		if($Email->send($strMessage))
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnResourceTransactionNotificationOwner($arrOwnerDetail = array(),$strPortalName = "")
	{
		if(is_array($arrOwnerDetail) && (count($arrOwnerDetail)>0))
		{
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config(array('transport' => 'Smtp','host' => 'ssl://smtp.gmail.com','port' => 465,'timeout' => '30','username' => 'rajendra.kandpal@redorangetechnologies.com','password' => 'rajendra12'));
			$Email->sender('admin@hc.com', 'HC');
			$Email->from(array('admin@hc.com' => 'HC'));
			$Email->to(array($arrOwnerDetail[0]['User']['email']=>$arrOwnerDetail[0]['User']['username']));
			$Email->subject('New Order');
			$Email->emailFormat('html');
			$Email->template('transaction_notification_owner', 'default');
			$Email->viewVars(array('first_name' => $arrOwnerDetail[0]['User']['username']));
			$Email->viewVars(array('portal_name' => $strPortalName));
			if($Email->send())
			{
				return true;
			}
			else
			{
				//echo "Mail Not Send";
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnResourceTransactionNotificationSeeker($arrSeekerDetail = array(),$strPortalName = "",$emailContent=array())
	{
		
		if(is_array($arrSeekerDetail) && (count($arrSeekerDetail)>0))
		{
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config(array('transport' => 'Smtp','host' => 'ssl://smtp.gmail.com','port' => 465,'timeout' => '30','username' => 'rajendra.kandpal@redorangetechnologies.com','password' => 'rajendra12'));
			$Email->sender('admin@hc.com', 'HC');
			$Email->from(array($emailContent['from_email'] => $emailContent['from_name']));
			$Email->to(array($arrSeekerDetail['candidate_email']=>$arrSeekerDetail['candidate_first_name']." ".$arrSeekerDetail['candidate_last_name']));
			$Email->subject($emailContent['email_subject']);
			
			$Email->emailFormat('html');
			$Email->template('thanks_placing_order', 'default');
			$Email->viewVars(array('email_text' => htmlspecialchars_decode($emailContent['email_text'])));
			$Email->viewVars(array('first_name' => $arrSeekerDetail['candidate_first_name']));
			$Email->viewVars(array('portal_name' => $strPortalName));
			if($Email->send())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnSendPortalRegistrationConfirmationEmail($strUserName = "User",$strEmail = "",$intUserId = "",$strPortalName = "",$intPortalId = "",$emailContent=array())
	{
		//echo "Hello";exit;
		
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config(array('transport' => 'Smtp','host' => 'ssl://smtp.gmail.com','port' => 567,'timeout' => '30','username' => 'rajendra.kandpal@redorangetechnologies.com','password' => 'rajendra12'));
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array($emailContent['from_email'] => $emailContent['from_name']));
		$Email->to(array($strEmail=>$strUserName));
		$Email->subject($emailContent['email_subject']);
		$Email->emailFormat('html');
		$Email->template('new_portal_registration', 'default');
		$Email->viewVars(array('email_text' => htmlspecialchars_decode($emailContent['email_text'])));
		$Email->viewVars(array('first_name' => $strUserName));
		$Email->viewVars(array('portal_name' => $strPortalName));
		$Email->viewVars(array('portal_id' => $intPortalId));
		$Email->viewVars(array('user_id' => $intUserId));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendPortalRegistrationResendConfirmationEmail($strUserName = "User",$strEmail = "",$intUserId = "",$strPortalName = "",$intPortalId = "")
	{
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strEmail=>$strUserName));
		$Email->subject('Confirmation Email');
		$Email->emailFormat('html');
		$Email->template('new_portal_registration', 'default');
		$Email->viewVars(array('first_name' => $strUserName));
		$Email->viewVars(array('portal_name' => $strPortalName));
		$Email->viewVars(array('portal_id' => $intPortalId));
		$Email->viewVars(array('user_id' => $intUserId));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendVendorAccountDetails($strUsername = "",$strToEmail = "",$strNewPass = "",$strEditMode = "0")
	{
		$strUserGreetName = $strUsername;
		$strUserNewPass = $strNewPass;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Account Details');
		$Email->emailFormat('html');
		$Email->template('new_vendor_registration', 'default');
		$Email->viewVars(array('first_name' => $strUserGreetName));
		$Email->viewVars(array('email' => $strToEmail));
		$Email->viewVars(array('newpass' => $strUserNewPass));
		$Email->viewVars(array('editmode' => $strEditMode));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendVendorPassDetails($strUsername = "",$strToEmail = "",$strPass = "")
	{
		$strUserGreetName = $strUsername;
		$strUserNewPass = $strNewPass;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Account Details');
		$Email->emailFormat('html');
		$Email->template('vendor_pass_notification', 'default');
		$Email->viewVars(array('first_name' => $strUserGreetName));
		$Email->viewVars(array('email' => $strToEmail));
		$Email->viewVars(array('newpass' => $strUserNewPass));
		$Email->viewVars(array('editmode' => $strEditMode));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	//Password to sub vendors
	public function fnSendSubVendorPass($strUsername = "",$strToEmail = "",$strPass = "")
	{
		$strUserGreetName = $strUsername;
		$strUserNewPass = $strPass;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Account Details');
		$Email->emailFormat('html');
		$Email->template('vendor_pass_notification', 'default');
		$Email->viewVars(array('first_name' => $strUserGreetName));
		$Email->viewVars(array('email' => $strToEmail));
		$Email->viewVars(array('newpass' => $strUserNewPass));
		$Email->viewVars(array('editmode' => $strEditMode));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	
	public function fnSendRegistrationEmail($strUserName = "User",$strEmail = "",$intUserId = "",$strUserPass = "")
	{
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strEmail=>$strUserName));
		$Email->subject('Registration Confirmation');
		$Email->emailFormat('html');
		$Email->template('new_registration', 'default');
		$Email->viewVars(array('first_name' => $strUserName));
		$Email->viewVars(array('user_id' => $intUserId));
		if($strUserPass)
		{
			$Email->viewVars(array('userpassword' => $strUserPass));
		}
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	
	public function fnSendShareJobEmail($strToEmail,$link,$comments,$subject)
	{
		App::uses('CakeEmail', 'Network/Email');
	
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail=>"admin"));
		$Email->subject($subject);
		$Email->emailFormat('html');
		$Email->template('share_job', 'default');
		$Email->viewVars(array('link' => $link));
		$Email->viewVars(array('comments' => $comments));
		
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	
	
	public function fnRegeneratePassword($intUid = "")
	{
		$strNewPassword =$intUid.time();
		$strNewPassword = base64_encode($strNewPassword);
		return $strNewPassword;
	}
	
	public function fnSendPassowordRegenerationMail($strUsername = "",$strToEmail = "",$strNewPass = "",$emailContent=array())
	{
		$strUserGreetName = $strUsername;
		$strUserNewPass = $strNewPass;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		
		$Email->from(array($emailContent['from_email'] => $emailContent['from_name']));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject($emailContent['email_subject']);
		$Email->emailFormat('html');
		$Email->template('new_password', 'default');
		$Email->viewVars(array('email_text' => htmlspecialchars_decode($emailContent['email_text'])));
		$Email->viewVars(array('first_name' => $strUserGreetName));
		$Email->viewVars(array('newpass' => $strUserNewPass));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendReminderMail($strUsername = "",$strToEmail = "", $strReminderText = "",$strReminderSubject = "Reminder For Your Scheduled Event")
	{

		
		$strUserGreetName = $strUsername;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject($strReminderSubject);
		$Email->emailFormat('html');
		$Email->template('reminder_interview', 'default');
		$Email->viewVars(array('first_name' => $strUserGreetName));
		$Email->viewVars(array('reminder_text' => $strReminderText));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendAdminPortalContactusEmail($arrPortalOwner = array(),$strPortalName = "", $arrContacterDetail = array(),$arrPortalOwnerDetail = array())
	{
//            echo '<pre>';print_r($strPortalName);die;
		$strPortalOwnerName = ucfirst($arrPortalOwnerDetail[0]['employer_detail']['employer_user_fname'])." ".$arrPortalOwnerDetail[0]['employer_detail']['employer_user_lname'];
		$strToEmail = Configure::read('HC.SupportAddress');
		$strUserGreetName = "HC Support";
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Contact Us Form Request from Portal '.$strPortalName);
		$Email->emailFormat('html');
		$Email->template('superadmin_contactus_reminder', 'default');
		$Email->viewVars(array('portalowner_uname' => $strPortalOwnerName));
		$Email->viewVars(array('portalowner_email' => $arrPortalOwner[0]['User']['email']));
		$Email->viewVars(array('portal_name' => $strPortalName));
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('visitor_message' => $arrContacterDetail['message']));
		$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
                if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendPortalAdminContactusEmail($arrPortalOwner = array(),$strPortalName = "", $arrContacterDetail = array())
	{
		$strUserGreetName = ucfirst($arrPortalOwner[0]['User']['username']);
		$strToEmail = Configure::read('HC.SupportAddress');
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Request Through Contact Us Form');
		$Email->emailFormat('html');
		$Email->template('admin_contactus_reminder', 'default');
		$Email->viewVars(array('portalowner_uname' => $strUserGreetName));
		$Email->viewVars(array('portal_name' => $strPortalName));
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('visitor_message' => $arrContacterDetail['message']));
		$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendContactUsFormSubmissionEmailForContacter($strContacterEmail = "")
	{
		$strUserGreetName = "User";
		$strToEmail = $strContacterEmail;
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => $strUserGreetName));
		$Email->subject('Contacting Us');
		$Email->emailFormat('html');
		$Email->template('contacter_form_submission', 'default');
		$Email->viewVars(array('first_name' => $strUserGreetName));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendAdminEmployerContactusEmail($arrContacterDetail = array())
	{
		$strToEmail = Configure::read('HC.OwnerSupportAddress');
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => "Admin"));
		$Email->subject('Request Through Contact Us Form');
		$Email->emailFormat('html');
		$Email->template('employer_contact_form_submission', 'default');
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('visitor_message' => $arrContacterDetail['message']));
		$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
//                print("<pre>");
//            print_r($Email);die;
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendAdminVendorContactusEmail($arrContacterDetail = array())
	{
		$strToEmail = Configure::read('HC.VendorSupportAddress');
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => "Admin"));
		$Email->subject('Request Through Contact Us Form');
		$Email->emailFormat('html');
		$Email->template('employer_contact_form_submission', 'default');
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('visitor_message' => $arrContacterDetail['message']));
		$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
//                print("<pre>");
//            print_r($Email);die;
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendVendorUpdateEmail($arrContacterDetail = array())
	{
		$strToEmail = Configure::read('HC.VendorSupportAddress');
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => "Admin"));
		$Email->subject('HC-Vendor order update');
		$Email->emailFormat('html');
		$Email->template('vendor_update', 'default');
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('vendor_name' => $arrContacterDetail['vendorname']));
		$Email->viewVars(array('product_name' => $arrContacterDetail['product_name']));
		//$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnSendCandidateUpdateEmail($arrContacterDetail = array())
	{
		$strToEmail = $arrContacterDetail['email'];
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config('smtp');
		$Email->sender('admin@hc.com', 'HC');
		$Email->from(array('admin@hc.com' => 'HC'));
		$Email->to(array($strToEmail => "Admin"));
		$Email->subject('HC-Vendor order update');
		$Email->emailFormat('html');
		$Email->template('vendor_update_from_candidate', 'default');
		$Email->viewVars(array('visitor_name' => $arrContacterDetail['name']));
		$Email->viewVars(array('visitor_email' => $arrContacterDetail['email']));
		$Email->viewVars(array('vendor_name' => $arrContacterDetail['vendorname']));
		$Email->viewVars(array('product_name' => $arrContacterDetail['product_name']));
		//$Email->viewVars(array('visitor_subject' => $arrContacterDetail['subject']));
		if($Email->send())
		{
			return true;
		}
		else
		{
			//echo "Mail Not Send";
			return false;
		}
	}
	
	public function fnGeneratePortalName($strCurrentPortalLogoName = "",$strPortalName = "",$intProviderId = "")
	{
		$strNewPortalLogoName = $strCurrentPortalLogoName;
		$arrNewPortalLogoName = explode(".",$strNewPortalLogoName);
		$arrNewPortalLogoName[0] = $strPortalName."_".$intProviderId;
		$strNewPortalLogoName = implode(".",$arrNewPortalLogoName);
		
		return $strNewPortalLogoName;
	}
	
	public function fnGeneratePortalThumbLogo($strCurrentPortalLogoName = "",$strPortalName = "",$intProviderId = "")
	{
		$strNewPortalLogoName = $strCurrentPortalLogoName;
		$arrNewPortalLogoName = explode(".",$strNewPortalLogoName);
		$arrNewPortalLogoName[0] = $strPortalName."_".$intProviderId."_small";
		$strNewPortalLogoName = implode(".",$arrNewPortalLogoName);
		
		return $strNewPortalLogoName;
	}
}
?>