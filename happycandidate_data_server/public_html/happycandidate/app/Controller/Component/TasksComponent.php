<?php
App::uses('Component', 'Controller');
class TasksComponent extends Component 
{
    public $components = array('Session','TimeCalculation');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnCompeleteTasks($intTaskId = "",$strAction = "")
	{
		if($intTaskId && $strAction)
		{
			$modelJstAppointments = ClassRegistry::init('JstTasks');
			$arrAppointment['jsttasks_status'] = "'".$strAction."'";
			$intUpdated = $modelJstAppointments->updateAll($arrAppointment,array("jsttasks_id"=>$intTaskId));
			if($intUpdated)
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
	
	public function fnGetAppointments($today = null)
	{
		/*print("<pre>");
		print_r($arrAppointMentDetail);
		exit;*/
		if($today>0)		{			$condition = array('DATE(jsttasks_start_date)' => date('Y-m-d')); 		}		else		{			$condition = "";		}
		$modelJstAppointments = ClassRegistry::init('JstTasks');
		$arrADetail = $modelJstAppointments->find('all',array('conditions' =>$condition ,'order'=>array('jsttasks_start_date_time'=>'asc')));
		
		return $arrADetail;
	}
	
	public function fnSaveAppointmentNote($arrAppointments = array())
	{
		$arrResponseArray = array();
		if(is_array($arrAppointments) && (count($arrAppointments)>0))
		{
			$modelJstAppointments = ClassRegistry::init('JstAppointmentsNotes');
			$arrAppointmentCreated = $modelJstAppointments->save($arrAppointments);
			if($arrAppointmentCreated)
			{
				$arrResponseArray['status'] = 'success';
				$arrResponseArray['message'] = 'You have successfully added the appointment';
				$arrAppointmentCreated['JstAppointmentsNotes']['appointment_notes_id'] = $arrAppointmentCreated['JstAppointmentsNotes']['id'];
				$arrAppointmentCreated['JstAppointmentsNotes']['appointment_notes_creation_date'] = date('Y-m-d H:i:s');
				$arrResponseArray['createdappoint'] = $arrAppointmentCreated;
				
				return $arrResponseArray;
			}
			else
			{
				$arrResponseArray['status'] = 'fail';
				$arrResponseArray['message'] = 'Some issue, Please try again';
				
				return $arrResponseArray;
			}
			
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetReminderTimeInMinutes($strTimeDetail = "")
	{
		if($strTimeDetail)
		{
			$arrTimeDetail = explode(" ",$strTimeDetail);
			//echo "---".$arrTimeDetail[0];
			switch($arrTimeDetail[1])
			{
				case"Minutes":	return $arrTimeDetail[0];
								break;
				case"Hour":		return ($arrTimeDetail[0] * 60);
								break;
				case"Day":		return (($arrTimeDetail[0]*24)*60);
								break;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function fnSaveAppointments($arrAppointments = array())
	{
		$arrResponseArray = array();
		if(is_array($arrAppointments) && (count($arrAppointments)>0))
		{
			$isApointmentExists = $this->fnCheckAppointment($arrAppointments['JstTasks']);
			if($isApointmentExists)
			{
				$arrResponseArray['status'] = 'fail';
				$arrResponseArray['message'] = 'This Task already exists';
				
				return $arrResponseArray;
			}
			else
			{
				$modelJstAppointments = ClassRegistry::init('JstTasks');
				$arrAppointmentCreated = $modelJstAppointments->save($arrAppointments);
				if($arrAppointmentCreated)
				{
					if($arrAppointments['JstAppointments']['jstappointments_reminder_set'])
					{
						$arrReminderArray = array();
						$modelReminders = ClassRegistry::init('Reminder');
						$arrReminderArray['Reminder']['reminder_type'] = 'Appointment';
						$arrReminderArray['Reminder']['reminder_type_id'] = $modelJstAppointments->getLastInsertID();
						$arrReminderArray['Reminder']['reminder_text'] = 'Your Appointment with '.$arrAppointments['JstAppointments']['jstappointments_contact_fname']." scheduled on ".$arrAppointments['JstAppointments']['jstappointments_start_date_time'];
						$arrReminderArray['Reminder']['reminder_status'] = "active";
						$arrReminderArray['Reminder']['reminder_frequency'] = $this->fnGetReminderTimeInMinutes($arrAppointments['JstAppointments']['jstappointments_reminder_set']);
						$arrReminderArray['Reminder']['reminder_time'] = $this->TimeCalculation->fnGetBeforeTime($arrReminderArray['Reminder']['reminder_frequency'],$arrAppointments['JstAppointments']['jstappointments_start_date_time']);
						//print("<pre>");
						//print_r($arrReminderArray);
						//exit;
						$modelReminders->save($arrReminderArray);
						
					}
					$arrResponseArray['status'] = 'success';
					$arrResponseArray['message'] = 'You have successfully added the task';
					$arrAppointmentCreated['JstTasks']['jsttasks_id'] = $arrAppointmentCreated['JstTasks']['id'];
					$arrResponseArray['createdappoint'] = $arrAppointmentCreated;
					
					return $arrResponseArray;
				}
				else
				{
					$arrResponseArray['status'] = 'fail';
					$arrResponseArray['message'] = 'Some issue, Please try again';
					
					return $arrResponseArray;
				}
			}
			
		}
		else
		{
			return false;
		}
	}
	
	public function fnDeleteAppointmentsNotes($intNoteId = "")
	{
		if($intNoteId)
		{
			$modelJstAppointments = ClassRegistry::init('JstAppointmentsNotes');
			$intAppointmentDeleted = $modelJstAppointments->deleteAll(array('appointment_notes_id' => $intNoteId),false);
			
			if($intAppointmentDeleted)
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
	
	public function fnGetAppointmentsNotes($intApppointmentId = "")
	{
		if($intApppointmentId)
		{
			$modelJstAppointments = ClassRegistry::init('JstAppointmentsNotes');
			$arrAppointmentNotes = $modelJstAppointments->find('all',array('conditions'=>array('appointment_id'=>$intApppointmentId)));
			
			return $arrAppointmentNotes;
		}
		else
		{
			return false;
		}
	}
	
	public function fnUpdateAppointment($arrAppointment = array(),$intApppointmentId = "")
	{
		//print("<pre>");
		//print_r($arrAppointment);
		//exit;
		
		$arrResponse = array();
		if($intApppointmentId)
		{
			if(is_array($arrAppointment) && (count($arrAppointment)>0))
			{
				foreach($arrAppointment as $arrAppointKey => $arrAppointKeyVal)
				{
					$arrAppointment[$arrAppointKey] = "'".$arrAppointKeyVal."'";
				}
				
				//print("<pre>");
				//print_r($arrAppointment);
				//exit;
				$modelJstAppointments = ClassRegistry::init('JstTasks');				
				$boolUpdated = $modelJstAppointments->updateAll($arrAppointment,array("jsttasks_id"=>$intApppointmentId));
				if($boolUpdated)
				{
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "You have successfully updated the task";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "No data to update";
				}
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "No data to update";
			}
		}
		else
		{
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "No data to update";
		}
		
		return $arrResponse;
	}
	
	public function fnCheckAppointmentsForSeeker($intSeekerId = "")
	{
		if($intSeekerId)
		{
			$modelJstAppointments = ClassRegistry::init('JstTasks');
			$intSeekerAppointments = $modelJstAppointments->find('count',array('conditions'=>array('jsttasks_seeker_id'=>$intSeekerId)));
			
			if($intSeekerAppointments)
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
	
	public function fnDeleteAppointments($intAppointmentId = "")
	{
		if($intAppointmentId)
		{
			$modelJstAppointments = ClassRegistry::init('JstTasks');
			$intAppointmentDeleted = $modelJstAppointments->deleteAll(array('jsttasks_id' => $intAppointmentId),false);
			if($intAppointmentDeleted)
			{
				$modelJstNotes = ClassRegistry::init('JstAppointmentsNotes');
				$intNotesDeleted = $modelJstNotes->deleteAll(array('appointment_id' => $intAppointmentId),false);
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
	
	public function fnCheckAppointment($arrAppointDetail = array())
	{
		if(is_array($arrAppointDetail) && (count($arrAppointDetail)>0))
		{
			$modelJstAppointments = ClassRegistry::init('JstTasks');
			$isAppointmentExist = $modelJstAppointments->find('count',array('conditions'=>$arrAppointDetail));
			if($isAppointmentExist)
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

	public function fnGenerateMessageBlock($strMessage = "", $strMessageType = "")
	{
		$strMessageTy = "";
		$strMessg = "";
		$strMessageIntroT = "";
		
		if($strMessageType == "success")
		{
			$strMessageTy = "alert-success";
			$strMessageIntroT = "Done!";
		}
		
		if($strMessageType == "error")
		{
			$strMessageTy = "alert-danger";
			$strMessageIntroT = "Failed!";
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
		
		$strMessageBlock = '<div role="alert" class="alert '.$strMessageTy.'"><strong>'.$strMessageIntroT.'</strong> '.$strMessg.'</div>';
		return $strMessageBlock;
	}
}
?>