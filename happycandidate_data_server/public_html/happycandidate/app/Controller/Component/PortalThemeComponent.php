<?php
App::uses('Component', 'Controller');
class PortalThemeComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnSetDefaultTheme($intPortalId = "")
	{
		$arrResponse = array();
		$intDefaultTheme = "1";
		if($intPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$arrPageDetail = array();
			$modelPortalTheme = ClassRegistry::init('PortalTheme');
			
			$intPortalDefaultThemeAllocated = $modelPortalTheme->find('count',array('conditions'=>array('career_portal_id'=>$intPortalId,'career_portal_theme_id'=>$intDefaultTheme)));

			if($intPortalDefaultThemeAllocated)
			{
				$arrResponse['status'] = 'failure';
				$arrResponse['message'] = 'Theme Already Allocated for Portal';
				return $arrResponse;
			}
			else
			{
				$arrPortalThemeDetail = array();
				$arrPortalThemeDetail['PortalTheme']['career_portal_id'] = $intPortalId;
				$arrPortalThemeDetail['PortalTheme']['career_portal_theme_id'] = $intDefaultTheme;
				$arrPortalThemeDetail['PortalTheme']['career_portal_theme_active'] = "1";
				$arrPortalThemeDetail['PortalTheme']['caree_portal_theme_allocatedby'] = $arrLoggedUserDetails['id'];
				
				$modelPortalTheme->set($arrPortalThemeDetail);
				$boolThemeAllocated = $modelPortalTheme->save($arrPortalThemeDetail);
				if($boolThemeAllocated)
				{
					$arrResponse['status'] = 'success';
					$arrResponse['message'] = 'Portal Theme Allocated successfully';
					$arrResponse['redirect'] = "1";
					$arrResponse['redirecturl'] = Router::url(array('action'=>'index',$intPortalId),true);
					return $arrResponse;
				}
				else
				{
					return $arrResponse;
				}
			}
		}
	}
}
?>