<?php
App::uses('Component', 'Controller');
class CandidatesComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}

	public function fnGetCandidateJobberToken($intCandidateId = "")
	{
		if($intCandidateId)
		{
			$modelCandidate = ClassRegistry::init('Candidate');
			$arrCandidateDetail = $modelCandidate->find('first',array('conditions'=>array('candidate_id'=>$intCandidateId)));
			
			if(is_array($arrCandidateDetail) && (count($arrCandidateDetail)>0))
			{
				return $arrCandidateDetail['Candidate']['jb_auth_token'];
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
	
	public function fnUpdateCandidateJobberToken($intCandidateId = "")
	{
		if($intCandidateId)
		{
			$modelCandidate = ClassRegistry::init('Candidate');
			$boolUpdated = $modelCandidate->updateAll(
						array('Candidate.jb_auth_token' => "''"),
						array('Candidate.candidate_id =' => $intCandidateId)
					);
			if($boolUpdated)
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
	
	public function fnUpdateCandidateLmsToken($intCandidateId = "")
	{
		if($intCandidateId)
		{
			$modelCandidate = ClassRegistry::init('Candidate');
			$boolUpdated = $modelCandidate->updateAll(
						array('Candidate.lms_auth_token' => "''"),
						array('Candidate.candidate_id =' => $intCandidateId)
					);
			if($boolUpdated)
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
	
	public function fnGetCandidateLmsToken($intCandidateId = "",$intPortalId = "")
	{
		if($intCandidateId)
		{
			$modelCandidate = ClassRegistry::init('Candidate');
			$arrCandidateDetail = $modelCandidate->fnGetCandidateData($intCandidateId);

			
			if(is_array($arrCandidateDetail) && (count($arrCandidateDetail)>0))
			{
				//echo "HI";exit;
				return $arrCandidateDetail['0']['career_portal_candidate']['lms_auth_token'];
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