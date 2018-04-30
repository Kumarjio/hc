<?php
App::uses('Component', 'Controller');
class CvComponent extends Component 
{
    public $components = array('Session','TimeCalculation');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnGetAppointments($arrAppointMentDetail = array())
	{
		$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
		$arrADetail = $modelCandidateCvDetail->find('all',array('conditions'=>$arrAppointMentDetail,'order'=>array('jstnotes_start_date_time'=>'asc')));
		
		return $arrADetail;
	}
	
	public function fnSaveAppointmentNote($arrAppointments = array())
	{
		$arrResponseArray = array();
		if(is_array($arrAppointments) && (count($arrAppointments)>0))
		{
			$modelCandidateCvDetail = ClassRegistry::init('JstAppointmentsNotes');
			//print("<pre>");
			//print_r($arrAppointments);
			//exit;
			$arrAppointmentCreated = $modelCandidateCvDetail->save($arrAppointments);
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
				$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
				$arrAppointmentCreated = $modelCandidateCvDetail->save($arrAppointments);
				if($arrAppointmentCreated)
				{
					$arrResponseArray['status'] = 'success';
					$arrResponseArray['message'] = 'You have successfully added Note';
					$arrAppointmentCreated['CandidateCvDetail']['jstnotes_id'] = $arrAppointmentCreated['CandidateCvDetail']['id'];
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
			$modelCandidateCvDetail = ClassRegistry::init('JstAppointmentsNotes');
			$intAppointmentDeleted = $modelCandidateCvDetail->deleteAll(array('appointment_notes_id' => $intNoteId),false);
			
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
			$modelCandidateCvDetail = ClassRegistry::init('JstAppointmentsNotes');
			$arrAppointmentNotes = $modelCandidateCvDetail->find('all',array('conditions'=>array('appointment_id'=>$intApppointmentId,"notes_type"=>$strType)));
			
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
				
				$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');				
				$boolUpdated = $modelCandidateCvDetail->updateAll($arrAppointment,array("jstnotes_id"=>$intApppointmentId));
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
	
	public function fnCheckCVForSeeker($intSeekerId = "")
	{
		if($intSeekerId)
		{
			$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
			$intSeekerCVs = $modelCandidateCvDetail->find('count',array('conditions'=>array('fk_employee_id'=>$intSeekerId)));
		
			if($intSeekerCVs)
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
	
	public function fnDeleteCv($intCvId = "")
	{
		if($intCvId)
		{
			//$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
			$modelCandidateCvDetail = ClassRegistry::init('Candidate_Cv');
			/*$oldcv =  $modelCandidateCvDetail->field('cv_file_name', array('id' => $intCvId));
			
			
			if($oldcv!="")
			{
				 $cvpath = "assets/candidatecv/".$oldcv;
					if(file_exists($cvpath))
					{
						unlink($cvpath);
					}
			}*/
			//$intCandidateCvDeleted = $modelCandidateCvDetail->deleteAll(array('id' => $intCvId),false);
			$intCandidateCvDeleted = $modelCandidateCvDetail->deleteAll(array('candidatecv_id' => $intCvId),false);
			if($intCandidateCvDeleted)
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
	
	
	public function fnDownloadCv($intCvId = "")
	{
		
		if($intCvId)
		{
			$intCandidateCvDetail='';
			$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
			$intCandidateCvDetail = $modelCandidateCvDetail->find('first',array('id' => $intCvId),false);
			if($intCandidateCvDetail)
			{				
				$file_name 		= $intCandidateCvDetail['cv_file_name'];
				$orginal_name 	= $intCandidateCvDetail['original_name'];
				$file_type		= $intCandidateCvDetail['cv_file_type'];
				$file_size		= $intCandidateCvDetail['cv_file_size'];
				$file_path		= $intCandidateCvDetail['cv_file_path'];
				$location = $file_path.$file_name;
				
				
	
				
				
				return $intCandidateCvDetail ;
				
			}
			else
			{
				return $intCandidateCvDetail;
			}
		}
		else
		{
			return $intCandidateCvDetail;
		}
		
		
	}
	public function fnCheckAppointment($arrAppointDetail = array())
	{
		if(is_array($arrAppointDetail) && (count($arrAppointDetail)>0))
		{
			$modelCandidateCvDetail = ClassRegistry::init('CandidateCvDetail');
			$isCandidateCvExist = $modelCandidateCvDetail->find('count',array('conditions'=>$arrAppointDetail));
			if($isCandidateCvExist)
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