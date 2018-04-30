<?php
App::uses('Component', 'Controller');
class AppointmentsComponent extends Component 
{
    public $components = array('Session','TimeCalculation');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnGetAppointments($arrAppointMentDetail = array())
	{
		$modelJstAppointments = ClassRegistry::init('JstAppointments');
		$arrADetail = $modelJstAppointments->find('all',array('conditions'=>$arrAppointMentDetail,'order'=>array('jstappointments_start_date_time'=>'asc')));
		
		return $arrADetail;
	}
	
	public function fnSaveAppointmentNote($arrAppointments = array())
	{
		$arrResponseArray = array();
		if(is_array($arrAppointments) && (count($arrAppointments)>0))
		{
			$modelJstAppointments = ClassRegistry::init('JstNotes');
			//print("<pre>");
			//print_r($arrAppointments);
			//exit;
			$arrAppointmentCreated = $modelJstAppointments->save($arrAppointments);
			if($arrAppointmentCreated)
			{
				$arrResponseArray['status'] = 'success';
				$arrResponseArray['message'] = 'You have successfully added the note';
				$arrAppointmentCreated['JstNotes']['jstnotes_id'] = $arrAppointmentCreated['JstNotes']['id'];
				$arrAppointmentCreated['JstNotes']['jstnotes_start_date_time'] = date('Y-m-d H:i:s');
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
			$isApointmentExists = $this->fnCheckAppointment($arrAppointments['JstAppointments']);
			if($isApointmentExists)
			{
				$arrResponseArray['status'] = 'fail';
				$arrResponseArray['message'] = 'This Appointment already exists';
				
				return $arrResponseArray;
			}
			else
			{
				$modelJstAppointments = ClassRegistry::init('JstAppointments');
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
						$arrReminderArray['Reminder']['reminder_user'] = $arrAppointments['JstAppointments']['jstappointments_seeker_id'];
						//print("<pre>");
						//print_r($arrReminderArray);
						//exit;
						$modelReminders->save($arrReminderArray);
						
					}
					$arrResponseArray['status'] = 'success';
					$arrResponseArray['message'] = 'You have successfully added the appointment';
					$arrAppointmentCreated['JstAppointments']['jstappointments_id'] = $arrAppointmentCreated['JstAppointments']['id'];
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
			$modelJstAppointments = ClassRegistry::init('JstNotes');
			$intAppointmentDeleted = $modelJstAppointments->deleteAll(array('jstnotes_id' => $intNoteId),false);
			
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
	
	public function fnGetAppointmentsNotes($intApppointmentId = "",$strType = "appointment")
	{
		if($intApppointmentId)
		{
			$modelJstAppointments = ClassRegistry::init('JstNotes');
			$arrAppointmentNotes = $modelJstAppointments->find('all',array('conditions'=>array('jstnotes_type_id'=>$intApppointmentId,"jstnotes_type"=>$strType)));
			return $arrAppointmentNotes;
		}
		else
		{
			return false;
		}
	}
	
	public function fnUpdateAppointment($arrAppointment = array(),$intApppointmentId = "")
	{
		
		$arrResponse = array();
		if($intApppointmentId)
		{
			if(is_array($arrAppointment) && (count($arrAppointment)>0))
			{
				foreach($arrAppointment as $arrAppointKey => $arrAppointKeyVal)
				{
					$arrAppointment[$arrAppointKey] = "'".$arrAppointKeyVal."'";
				}
				
				$modelJstAppointments = ClassRegistry::init('JstAppointments');				
				$boolUpdated = $modelJstAppointments->updateAll($arrAppointment,array("jstappointments_id"=>$intApppointmentId));
				if($boolUpdated)
				{
					
					$modelReminders = ClassRegistry::init('Reminder');
					$arrAppointment['jstappointments_reminder_set'] = str_replace("'","",$arrAppointment['jstappointments_reminder_set']);
					if($arrAppointment['jstappointments_reminder_set'])
					{
						
						//echo "---".$arrAppointment['jstappointments_reminder_set'];
						$arrAppointment['jstappointments_start_date_time'] = str_replace("'","",$arrAppointment['jstappointments_start_date_time']);
						$arrReminderArray = array();
						$arrReminderArray['Reminder']['reminder_type'] = 'Appointment';
						$arrReminderArray['Reminder']['reminder_type_id'] = $intApppointmentId;
						$arrReminderArray['Reminder']['reminder_text'] = 'Your Appointment with '.$arrAppointment['jstappointments_contact_fname']." scheduled on ".$arrAppointment['jstappointments_start_date_time'];
						$arrReminderArray['Reminder']['reminder_status'] = "active";
						$arrReminderArray['Reminder']['reminder_frequency'] = $this->fnGetReminderTimeInMinutes($arrAppointment['jstappointments_reminder_set']);
						$arrReminderArray['Reminder']['reminder_time'] = $this->TimeCalculation->fnGetBeforeTime($arrReminderArray['Reminder']['reminder_frequency'],$arrAppointment['jstappointments_start_date_time']);
						$arrReminderArray['Reminder']['reminder_user'] = str_replace("'","",$arrAppointment['jstappointments_seeker_id']);
						
						
						$intReminderCount = $modelReminders->find('count',array('conditions'=>array('reminder_type_id'=>$intApppointmentId,'reminder_type'=>'Appointment')));
						if($intReminderCount)
						{
							$intReminderCleared = $modelReminders->deleteAll(array('reminder_type_id' => $intApppointmentId,'reminder_type'=>'Appointment'),false);
							$modelReminders->save($arrReminderArray);
							//print("<pre>");
							//print_r($arrReminderArray);
						}
						else
						{
							$modelReminders->save($arrReminderArray);
							//print("<pre>");
							//print_r($arrReminderArray);
						}
					}
					else
					{
						$modelReminders->deleteAll(array('reminder_type_id' => $intApppointmentId,'reminder_type'=>'Appointment'),false);
					}
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "You have successfully updated the appointment";
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
			$modelJstAppointments = ClassRegistry::init('JstAppointments');
			$intSeekerAppointments = $modelJstAppointments->find('count',array('conditions'=>array('jstappointments_seeker_id'=>$intSeekerId)));
			
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
			$modelJstAppointments = ClassRegistry::init('JstAppointments');
			$intAppointmentDeleted = $modelJstAppointments->deleteAll(array('jstappointments_id' => $intAppointmentId),false);
			if($intAppointmentDeleted)
			{
				$modelJstNotes = ClassRegistry::init('JstNotes');
				$intNotesDeleted = $modelJstNotes->deleteAll(array('jstnotes_type_id' => $intAppointmentId,'jstnotes_type'=>'appointment'),false);
				$modelReminders = ClassRegistry::init('Reminder');
				$intReminderCleared = $modelReminders->deleteAll(array('reminder_type_id' => $intAppointmentId,'reminder_type'=>'Appointment'),false);
				
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
			$modelJstAppointments = ClassRegistry::init('JstAppointments');
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