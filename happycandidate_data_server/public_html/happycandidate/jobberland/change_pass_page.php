<?php $_SESSION['direct_to'] = BASE_URL."account/change_password/"; 	
	 include_once('sessioninc.php');
	$intPortId = $intLoggPortalId;
	
	$userId = $session->get_jobseeker_hc_uid();
	$userJId = $session->get_jobseeker_id();

if( isset( $_POST['bt_submit'] ) ){		
	$error= array();		
	$old_pass     = $_POST['txt_old_pass'];
	$new_pass     = $_POST['txt_new_pass'];
	$new_pass_try = $_POST['txt_new_pass_retry'];
	$correct_user = Employee::authenticate( $userId,$userJId,$old_pass );
		
		/* check old password**/
		if ( !$correct_user ){
			$error[] = format_lang('errormsg',44);
		}
		/**new password*/
		if ( strlen($new_pass) != strlen($new_pass_try) ){
			$error[] = format_lang('errormsg',45);
		}
		if ( strlen($new_pass) < 6 ||  strlen($new_pass) > 20 ){
			$error[] = format_lang('errormsg',46);
		}
	
	if( sizeof($error) == 0 ){
		//if everything ok
		//$intHcUserId = $session->get_jobseeker_hc_uid();
		$pass_change = Employee::change_password( $userId, $new_pass );
		if( $pass_change ){
				$session->message ("<div class='success'>".format_lang('success', 'pass_chg_success')."</div>");
		}
		else{
			$session->message ("<div class='error'>".format_lang('errormsg',47)."</div>");
		}
	}else{
			$message = "<div class='error'> 
					".get_lang('following_errors')."
				<ul> <li />";
			$message .= join(" <li /> ", $error);
			
			$message .= " </ul> 
					   </div>";
		
		$session->message ( $message );
	}
	redirect_to( BASE_URL."account/change_password/" );
}

	$html_title = SITE_NAME . " - ".format_lang('page_title','change_password');
	$smarty->assign('lang', $lang);
	//$smarty->assign('leftmenu', $smarty->fetch('left_menu_account.tpl'));
	$smarty->assign( 'message', $message );	
	$smarty->assign('rendered_page', $smarty->fetch('change_pass.tpl') );
?>