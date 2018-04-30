<?php
defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);
$dir = preg_split ('%[/\\\]%', $dir);
//$blank = array_pop($dir);
$dir = implode('/', $dir);
defined('SITE_ROOT') 	? null : define('SITE_ROOT', $dir );
defined('PUBLIC_PATH') 	? null : define('PUBLIC_PATH', SITE_ROOT  );
defined('LIB_PATH')		? null : define('LIB_PATH', PUBLIC_PATH . DS . 'libs');
require_once (LIB_PATH.DS."class.databaseobject.php");
//require_once (LIB_PATH.DS."class.employee.php");
require_once (LIB_PATH.DS."class.cvexperience.php");
require_once (LIB_PATH.DS."class.cvexperiencepositions.php");

if(isset($_REQUEST))
{
	$arrResponse = array();
	$cv_experience_setting 	= new CVExperienceSetting();
	$cv_experience_setting->cv_experience_current = $strExpType = trim($_REQUEST['exptype']);
	$cv_experience_setting->cv_experience_company_name = $strExpCompName = trim($_REQUEST['expcname']);
	$cv_experience_setting->cv_experience_company_location = $strExpCompLocation = trim($_REQUEST['expclocation']);
	$cv_experience_setting->cv_experience_company_job_title = $strExpCompJtitle = trim($_REQUEST['expcompjtitle']);
	$cv_experience_setting->cv_experience_company_responsibilities = $strExpCompResp = trim($_REQUEST['expcompresp']);
	$cv_experience_setting->cv_experience_company_accomplishments_impact = $strExpCompAccmp = trim($_REQUEST['expcompaccomp']);
	$cv_experience_setting->cv_id = $intCvId = $_REQUEST['cvid'];
	$intPositionDataCounter = trim($_REQUEST['posdatacounter']);
	$intEditPositionIds = trim($_REQUEST['editpositionids']);
	$arrPositionIds = array();
	if($intEditPositionIds)
	{
		$arrPositionIds = explode("|",$intEditPositionIds);
	}
	
	$intExpEditId = "";
	if($_REQUEST['expeditmodeid'])
	{
		$cv_experience_setting->cv_experience_id = $intExpEditId = $_REQUEST['expeditmodeid'];
	}
	
	if($intExpEditId)
	{
		if($cv_experience_setting->find_by_id_for_update($intCvId,$strExpType,$intExpEditId,$strExpCompName))
		{
			$strPositionBlockHtml = '';
			$strPositionBlockFinalHtml = '';
			$intPositionIds = "";
			if($intPositionDataCounter)
			{
				$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
				for($inti = 1; $inti <=$intPositionDataCounter; $inti++)
				{
					$cv_eexperience_position_setting->position_title = $strPositionTitle = trim($_REQUEST['exppostit'.$inti]);
					$cv_eexperience_position_setting->date_of_promotion = $strPositionDate = trim($_REQUEST['exppospromodte'.$inti]);
					$cv_eexperience_position_setting->exp_id = $intExpEditId;
					
					if($arrPositionIds[$inti-2])
					{
						if($cv_eexperience_position_setting->find_by_id_for_update($arrPositionIds[$inti-2],$intExpEditId,$strPositionTitle,$strPositionDate))
						{
							//continue;
							$intPositionIds = $intPositionIds.$arrPositionIds[$inti-2]."|";
							$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
							$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
							$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="display:none;">'.$strPositionDate.'</span></div>';
						}
						else
						{
							$cv_eexperience_position_setting->experience_positions_details_id = $arrPositionIds[$inti-2];
							$boolPositionAdded = $cv_eexperience_position_setting->save();
							if($boolPositionAdded)
							{
								$intPositionIds = $intPositionIds.$arrPositionIds[$inti-2]."|";
								$cv_eexperience_position_setting->experience_positions_details_id = null;
								$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
								$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
								$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="display:none;">'.$strPositionDate.'</span></div>';
							}
						}
					}
					else
					{
						$boolPositionAdded = $cv_eexperience_position_setting->save();
						if($boolPositionAdded)
						{
							$intPositionIds = $intPositionIds.$boolPositionAdded."|";
							$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
							$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
							$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$boolPositionAdded.'" style="display:none;">'.$strPositionDate.'</span></div>';
						}
					}
				}
				
			}
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this Experience ";
			if($strPositionBlockHtml)
			{
				if($intPositionIds)
				{
					$strPositionBlockHtml .= '<div id="position_ids_'.$intExpEditId.'" style="display:none;">'.$intPositionIds.'</div>'; 
				}
				$arrResponse['positionhtml'] = $strPositionBlockHtml;
			}
			if($intPositionIds)
			{
				$arrResponse['positionids'] = $intPositionIds;
			}
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			$boolSkillAdded = $cv_experience_setting->save();
			if($boolSkillAdded)
			{
				$strPositionBlockHtml = '';
				$strPositionBlockFinalHtml = '';
				$intPositionIds = "";
				if($intPositionDataCounter)
				{
					$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
					for($inti = 1; $inti <=$intPositionDataCounter; $inti++)
					{
						$cv_eexperience_position_setting->position_title = $strPositionTitle = trim($_REQUEST['exppostit'.$inti]);
						$cv_eexperience_position_setting->date_of_promotion = $strPositionDate = trim($_REQUEST['exppospromodte'.$inti]);
						$cv_eexperience_position_setting->exp_id = $intExpEditId;
						
						if(isset($arrPositionIds[$inti-2]))
						{
							if($cv_eexperience_position_setting->find_by_id_for_update($arrPositionIds[$inti-2],$intExpEditId,$strPositionTitle,$strPositionDate))
							{
								//continue;
								$intPositionIds = $intPositionIds.$arrPositionIds[$inti-2]."|";
								$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
								$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
								$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="display:none;">'.$strPositionDate.'</span></div>';
							}
							else
							{
								//echo $arrPositionIds[$inti-2];exit;
								$cv_eexperience_position_setting->experience_positions_details_id = $arrPositionIds[$inti-2];
								$boolPositionAdded = $cv_eexperience_position_setting->save();
								if($boolPositionAdded)
								{
									$intPositionIds = $intPositionIds.$arrPositionIds[$inti-2]."|";
									$cv_eexperience_position_setting->experience_positions_details_id = null;
									$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
									$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
									$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$arrPositionIds[$inti-2].'" style="display:none;">'.$strPositionDate.'</span></div>';
								}
							}
						}
						else
						{
							$boolPositionAdded = $cv_eexperience_position_setting->save();
							if($boolPositionAdded)
							{
								$intPositionIds = $intPositionIds.$boolPositionAdded."|";
								$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
								$strPositionBlockHtml .= '<div id="exp_position_title_'.$intExpEditId.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
								$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$intExpEditId.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$intExpEditId.'_'.$boolPositionAdded.'" style="display:none;">'.$strPositionDate.'</span></div>';
							}
						}
					}
					
				}
				
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully updated your Experience";
				$arrResponse['createdid'] = $boolSkillAdded;
				$arrResponse['updatedaccomp'] = nl2br($strExpCompAccmp);
				if($strPositionBlockHtml)
				{
					if($intPositionIds)
					{
						$strPositionBlockHtml .= '<div id="position_ids_'.$intExpEditId.'" style="display:none;">'.$intPositionIds.'</div>'; 
					}
					$arrResponse['positionhtml'] = $strPositionBlockHtml;
				}
				if($intPositionIds)
				{
					$arrResponse['positionids'] = $intPositionIds;
				}
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try updating your Experience again";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
	else
	{
		if($cv_experience_setting->find_by_id($intCvId,$strExpType,$strExpCompName))
		{
			// send message skill already exists
			$arrResponse['status'] = "fail";
			$arrResponse['message'] = "You have already added this Experience ";
			echo json_encode($arrResponse);
			exit;
		}
		else
		{
			// create skill for the cv
			$boolSkillAdded = $cv_experience_setting->save();
			if($boolSkillAdded)
			{
				$arrResponse['status'] = "success";
				$arrResponse['message'] = "You have successfully added your Experience";
				$arrResponse['createdid'] = $boolSkillAdded;
				
				// insert Position data
				$intPositionIds = "";
				if($intPositionDataCounter)
				{
					$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
					$strPositionBlockHtml = '';
					$strPositionBlockFinalHtml = '';
					for($inti = 1; $inti <=$intPositionDataCounter; $inti++)
					{
						$cv_eexperience_position_setting->position_title = $strPositionTitle = trim($_REQUEST['exppostit'.$inti]);
						$cv_eexperience_position_setting->date_of_promotion = $strPositionDate = trim($_REQUEST['exppospromodte'.$inti]);
						$cv_eexperience_position_setting->exp_id = $boolSkillAdded;
						
						if($cv_eexperience_position_setting->find_by_id($boolSkillAdded,$strPositionTitle,$strPositionDate))
						{
							continue;
						}
						else
						{
							$boolPositionAdded = $cv_eexperience_position_setting->save();
							if($boolPositionAdded)
							{
								$intPositionIds = $intPositionIds.$boolPositionAdded."|";
								$strFormattedDate = date("M j, Y",strtotime($strPositionDate));
								$strPositionBlockHtml .= '<div id="exp_position_title_'.$boolSkillAdded.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strPositionTitle.'</div>';
								$strPositionBlockHtml .= '<div id="exp_position_promotiondate_'.$boolSkillAdded.'_'.$boolPositionAdded.'" style="float:left;width:48%;margin-right:2%;font-size:10px;">'.$strFormattedDate.'<span id="exp_position_mask_id_'.$boolSkillAdded.'_'.$boolPositionAdded.'" style="display:none;">'.$strPositionDate.'</span></div>';
							}
						}
						
					}
				}
				
				if($strPositionBlockHtml != '')
				{
					if($intPositionIds)
					{
						$strPositionBlockHtml .= '<div id="position_ids_'.$boolSkillAdded.'" style="display:none;">'.$intPositionIds.'</div>'; 
					}
					$strPositionBlockFinalIntroHtml = '<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Positions:</label>
						</div><div id="exp_company_position_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">';
					$strPositionBlockFinalHtml = $strPositionBlockFinalIntroHtml.$strPositionBlockHtml;
				}
				
				$arrResponse['printhtml'] = '<div id="experience_data_container_'.$boolSkillAdded.'" style="float:left;width:72%;margin-right:2%;margin-top:10px;">
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Experience:</label>
					</div>
					<div id="exp_type_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.$strExpType.'
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Company Name:</label>
					</div>
					<div id="exp_company_name_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.$strExpCompName.'
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Company Location:</label>
					</div>
					<div id="exp_company_location_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.$strExpCompLocation.'
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Job Title:</label>
					</div>
					<div id="exp_company_jtitle_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.$strExpCompJtitle.'
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Duties:</label>
					</div>
					<div id="exp_company_resp_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.$strExpCompResp.'
					</div>
					<div id="label" style="float:left;width:44%;margin-right:2%;">
						<label style="font-weight:bold;">Accomplishments:</label>
					</div>
					<div id="exp_company_accmp_data_'.$boolSkillAdded.'" style="float:left;width:52%;margin-right:2%;">
						'.nl2br($strExpCompAccmp).'
					</div>';
				if($strPositionBlockFinalHtml != "")
				{
					$arrResponse['printhtml'] .= $strPositionBlockFinalHtml.'</div>';
				}
				$arrResponse['printhtml'] .='</div>
				<div id="exp_action_'.$boolSkillAdded.'" style="float:left;width:18%;margin-right:2%;margin-top:10px;">
					<a href="javascript:void(0);" onclick="fnEditExperience(\''.$boolSkillAdded.'\')">Edit</a>&nbsp;<a href="javascript:void(0);" onclick="fnDeleteExperience(\''.$boolSkillAdded.'\')">Delete</a>
				</div>';
				echo json_encode($arrResponse);
				exit;
			}
			else
			{
				$arrResponse['status'] = "fail";
				$arrResponse['message'] = "Please try adding your skill again";
				echo json_encode($arrResponse);
				exit;
			}
		}
	}
}
else
{
	$arrResponse['status'] = "fail";
	$arrResponse['message'] = "Bad Request";
	echo json_encode($arrResponse);
	exit;
}
?>