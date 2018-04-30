<?php
	require_once('olsalib.php');

	$userName = 'akash4207@gmail.com';
	$firstName = 'akash';
	$lastName = 'adsul';
	$actionType = 'catalog';
	$assetId = '';
	$catalogPath = '/DIALOGUE/EC/Microsoft_Office_2007:_Beginning_Excel,/DIALOGUE/EC/Microsoft_Office_2007:_Beginning_Word'; //Word 2007 Basic & Excel 2007 Basic

    //Get the sign on url first so if the student is not setup, it will automatically create the student.
	$response1 = SO_GetMultiActionSignOnUrl($userName, $actionType, $assetId, $firstName, $lastName); //First and Last Names are optional after initial setup.

	if($response1->success)
	{
		echo "<a target='_blank' href='" . $response1->result->olsaURL . "' > Launch </a>";
	}
	else
	{
		echo $response1->errormessage;
	}

	//get all courses taken by userName
	$olsasoapresponse = UD_GetAssetResults($userName,$assetId,true);
print_R( $olsasoapresponse->result);
exit();

	//Assign courseware to the student's catalog for them to choose.
	$response2 = AS_SetCatalogAssignmentByUser($catalogPath, $userName);

	if(!$response2->success)
	{
		echo $response2->errormessage;
	}
	