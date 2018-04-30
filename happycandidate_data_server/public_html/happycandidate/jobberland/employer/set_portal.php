<?php
include_once("../initialise_file_location.php");
if(isset($_POST['form_param']))
{
	$intVarAdminId = $_POST['form_param'];
	$intPortalId = $_POST['form_por'];
	
	if($intVarAdminId)
	{
		if(isset($_SESSION['BackendUser']['user_id']))
		{
			if($_SESSION['BackendUser']['access_level'] == "Recuriter")
			{
				if(isset($_SESSION['BackendUser']['portal_id']) && ($_SESSION['BackendUser']['portal_id'] == $intPortalId))
				{
					$arrSessionSet = array();
					$arrSessionSet['status'] = "success";
					echo json_encode($arrSessionSet);
					exit;
				}
				else
				{
					$_SESSION['BackendUser']['portal_id'] = $intPortalId;
					$arrSessionSet = array();
					$arrSessionSet['status'] = "success";
					echo json_encode($arrSessionSet);
					exit;
				}				
			}
			else
			{
				$arrSessionSet = array();
				$arrSessionSet['status'] = "failure";
				echo json_encode($arrSessionSet);
				exit;
			}
		}
		else
		{
			$arrSessionSet = array();
			$arrSessionSet['status'] = "failure";
			echo json_encode($arrSessionSet);
			exit;
		}
	}
	else
	{
		$arrSessionSet = array();
		$arrSessionSet['status'] = "failure";
		echo json_encode($arrSessionSet);
		exit;
	}
}
?>