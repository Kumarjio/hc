<?php
App::uses('Component', 'Controller');
class MessageComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}

	public function fnGenerateMessageBlock($strMessage = "", $strMessageType = "")
	{
            
		$strMessageTy = "";
		$strMessg = "";
		$strMessageIntroT = "";
		
		if($strMessageType == "success")
		{
			$strMessageTy = "alert-success";
			$strMessageIntroT = "Done!";
			$strMessageIcon = "icon-alert-success.png";
		}
		
		if($strMessageType == "error")
		{
			$strMessageTy = "alert-danger";
			$strMessageIntroT = "Failed!";
                        $strMessageIcon = "icon-alert-error.png";
		}
		
		if($strMessageType == "warning")
		{
			$strMessageTy = "alert-warning";
			$strMessageIntroT = "Warning!";
		}
		
		if($strMessageType == "info")
		{
			$strMessageTy = "alert-info";
			$strMessageIntroT = "Information!";
		}
		
		$strMessg = $strMessage;
//		echo $strMessage;
            
		$strMessageBlock = '<div class="alert '.$strMessageTy.'"><img src="'.Router::url('/', true).'/images/'.$strMessageIcon.'" alt="image description"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>						  '.$strMessg.'</div>';
		return $strMessageBlock;
	}
}
?>