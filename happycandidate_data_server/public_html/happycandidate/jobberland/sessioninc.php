<?php
	/** if user already logged in take them to index page */
	/*print("<pre>");
	print_r($session);*/
	/*echo "Hello";
	exit;*/
	
	if(!$session->get_job_seeker()){
		//redirect_to(BASE_URL."login/?error=1");
		//echo "--".SEEKERLOGINURL;exit;
		redirect_to(SEEKERLOGINURL);
		die;
	}

/*if( !$_POST && empty($_POST) ) {destroy_my_session();}*/

?>