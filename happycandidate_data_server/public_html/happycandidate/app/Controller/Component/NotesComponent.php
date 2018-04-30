<?php
App::uses('Component', 'Controller');
class NotesComponent extends Component 
{
    public $components = array('Session','TimeCalculation');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnGetAppointments($arrAppointMentDetail = array())
	{
		$modelJstAppointments = ClassRegistry::init('JstNotes');
		$arrADetail = $modelJstAppointments->find('all',array('conditions'=>$arrAppointMentDetail,'order'=>array('jstnotes_start_date_time'=>'asc')));
		
		return $arrADetail;
	}
	
	public function fnSaveAppointmentNote($arrAppointments = array())
	{
		$arrResponseArray = array();
		if(is_array($arrAppointments) && (count($arrAppointments)>0))
		{
			$modelJstAppointments = ClassRegistry::init('JstAppointmentsNotes');
			//print("<pre>");
			//print_r($arrAppointments);
			//exit;
			$arrAppointmentCreated = $modelJstAppointments->save($arrAppointments);
			if($arrAppointmentCreated)
			{
				$arrResponseArray['status'] = 'success';
				$arrResponseArray['message'] = 'You have successfully added the note';
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
			$isApointmentExists = $this->fnCheckAppointment($arrAppointments['JstAppointments']);
			if($isApointmentExists)
			{
				$arrResponseArray['status'] = 'fail';
				$arrResponseArray['message'] = 'This Notes is already Present';
				
				return $arrResponseArray;
			}
			else
			{
				$modelJstAppointments = ClassRegistry::init('JstNotes');
				$arrAppointmentCreated = $modelJstAppointments->save($arrAppointments);
				if($arrAppointmentCreated)
				{
					$arrResponseArray['status'] = 'success';
					$arrResponseArray['message'] = 'You have successfully added Note';
					$arrAppointmentCreated['JstNotes']['jstnotes_id'] = $arrAppointmentCreated['JstNotes']['id'];
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
	
	public function fnGetAppointmentsNotes($intApppointmentId = "",$strType = "appointment")
	{
		if($intApppointmentId)
		{
			$modelJstAppointments = ClassRegistry::init('JstAppointmentsNotes');
			$arrAppointmentNotes = $modelJstAppointments->find('all',array('conditions'=>array('appointment_id'=>$intApppointmentId,"notes_type"=>$strType)));
			
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
				
				$modelJstAppointments = ClassRegistry::init('JstNotes');				
				$boolUpdated = $modelJstAppointments->updateAll($arrAppointment,array("jstnotes_id"=>$intApppointmentId));
				if($boolUpdated)
				{
					$arrResponse['status'] = "success";
					$arrResponse['message'] = "You have successfully updated the Note";
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
			$modelJstAppointments = ClassRegistry::init('JstNotes');
			$intSeekerAppointments = $modelJstAppointments->find('count',array('conditions'=>array('jstnotes_seeker_id'=>$intSeekerId)));
			
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
			$modelJstAppointments = ClassRegistry::init('JstNotes');
			$intAppointmentDeleted = $modelJstAppointments->deleteAll(array('jstnotes_id' => $intAppointmentId),false);
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
	
	public function fnCheckAppointment($arrAppointDetail = array())
	{
		if(is_array($arrAppointDetail) && (count($arrAppointDetail)>0))
		{
			$modelJstAppointments = ClassRegistry::init('JstNotes');
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