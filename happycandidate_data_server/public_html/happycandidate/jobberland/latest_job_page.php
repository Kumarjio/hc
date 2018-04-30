<?php 
include_once('sessioninc.php');
$intPortId = $_GET['portid'];
$user_id = $session->get_jobseeker_id($intPortId);
include_once("layout/latest_job_inc.php");
?>