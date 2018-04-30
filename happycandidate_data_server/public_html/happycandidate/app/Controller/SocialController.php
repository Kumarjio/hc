<?php
	
class SocialController extends AppController 
{
	var $helpers = array ('Html','Form');
	var $name = 'Social';
	
	//var $layout = NULL;
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		$this->Auth->allow('social','index');
                parent::beforeFilter();
	}
	
	public function social($strPlugin = "", $strSocialMedia = "", $intPortalId = "")
	{

		$this->layout = NULL;
		if($strPlugin && $strSocialMedia)
		{
			if($strPlugin == "register")
			{
				switch($strSocialMedia)
				{
					case "facebook": $this->SocialRegister = $this->Components->load('FbRegister'); 
									 $this->SocialRegister->fnGetFbUserDetails($intPortalId,"",$strPlugin);
									 break;
									 
					case "twitter":  $this->SocialRegister = $this->Components->load('FbRegister'); 
									 $this->SocialRegister->fnGetTwitterUserDetails($intPortalId);
									 break;
									 
					case "linkedin":  $this->SocialRegister = $this->Components->load('FbRegister'); 
									 $this->SocialRegister->fnGetLinkedInUserDetails($intPortalId);
									 break;
				}				
			}
			
			if($strPlugin == "login")
			{
				switch($strSocialMedia)
				{
                                    
					case "facebook": //echo "dsaf";die;
                                                           $this->SocialRegister = $this->Components->load('FbRegister'); 
									 $this->SocialRegister->fnGetFbUserDetails($intPortalId,"1",$strPlugin);
									 break;
					/*case "twitter":  $this->SocialRegister = $this->Components->load('FbRegister'); 
									 $this->SocialRegister->fnGetTwitterUserDetails($intPortalId,"1");
									 break;*/
				}				
			}
			
			if($strPlugin == "resetregister")
			{
				switch($strSocialMedia)
				{
					case "facebook": $this->Session->delete('SOCIALREGISTRATIONDETAILS');
									 $this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_code');
									 $this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_access_token');
									 $this->Session->delete('fb_'.Configure::read('Social.FbApkey').'_user_id');
									 $this->redirect(array('controller'=>'portal','action'=>'registration',$intPortalId));
									 break;
				}
			}
		}
	}
}
?>