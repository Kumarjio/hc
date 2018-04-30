<?php
App::uses('Component', 'Controller');
class RemindersComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}

	public function fnSendReminders($arrReminderDetail = array())
	{
		if(is_array($arrReminderDetail) && (count($arrReminderDetail)>0))
		{
			$EventparticipantModel = ClassRegistry::init('Eventparticipant');
			$arrParticpantDetail = $EventparticipantModel->fnGetEventParticipant($arrReminderDetail['reminder_type_id']);
		}
		else
		{
			return false;
		}
	}
}
?>