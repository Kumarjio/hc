<?php
require_once('config.php');
require_once("$CFG->libdir/clilib.php");
$arrResponse = array();
$trace = new null_progress_trace();
/** @var auth_plugin_db $dbauth */
try
{
	$dbauth = get_auth_plugin('db');
	$result = $dbauth->sync_users($trace, $update);
	if($result)
	{
		$arrResponse['status'] = "failure";
	}
	else
	{
		$arrResponse['status'] = "success";
	}
}
catch (Exception $e)
{
	$arrResponse['status'] = "failure";
}
$fh = fopen("check.txt","w");
fwrite($fh,print_r($arrResponse,true));
fclose($fh);
echo json_encode($arrResponse);
exit;
?>