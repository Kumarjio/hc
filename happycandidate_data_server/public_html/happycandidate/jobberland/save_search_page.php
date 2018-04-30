<?php
	$intPortId = $intLoggPortalId;
	$_SESSION['direct_to'] = BASE_URL."save_search/?portid=".$intPortId; 	
	include_once('sessioninc.php');
	
	$username = $session->get_seeker_username($intPortId);
	$employee_id = $user_id = $session->get_jobseeker_id($intPortId);

if( isset($_GET['action']) ) {
	//save the search query into database
	if( $_GET['action'] == "save" && isset($_GET['reference']) && !isset($_GET['set_default_search'])) {
		$reference = base64_decode($_GET['reference']);
		$reference_name = $_GET['name'];
				
		if( !SaveSearch::already_existed( $employee_id, $reference) ){			
			$save_search = new SaveSearch();
			$save_search->fk_employee_id	= $employee_id;
			$save_search->reference_name	= $reference_name;
			$save_search->reference 		= $reference;
			
			if( $save_search->save() ) {
				$message = "<div class='success'>".format_lang('success','save_search')."</div>";
			}else{
				$message = "<div class='error'>".format_lang('errormsg',62)."</div>";
			}
		}else{
			$message = "<div class='error'>".format_lang('errormsg',63)."</div>";
		}
	}
	
	if( $_GET['action'] == "save" && isset($_GET['reference']) && isset($_GET['set_default_search'])) {
		//echo base64_decode($_GET['reference']);exit;
		$arrReference = explode("&",base64_decode($_GET['reference']));
		$reference_name = $_GET['name'];
		
		//print("<pre>");
		//print_r($arrReference);
		
		if(is_array($arrReference) && (count($arrReference)>0))
		{
			$arrProfileUpdate = array();
			foreach($arrReference as $strSearchFactor)
			{
				$arrSearchFactor = explode("=",$strSearchFactor);
				if(is_array($arrSearchFactor) && (count($arrSearchFactor)>0))
				{
					if($arrSearchFactor[1])
					{
						if($arrSearchFactor[0] == "txt_country")
						{
							$arrProfileUpdate['country'] = $arrSearchFactor[1];
						}
						
						if($arrSearchFactor[0] == "q")
						{
							$arrProfileUpdate['look_job_title'] = $arrSearchFactor[1];
						}
						
						if($arrSearchFactor[0] == "experience")
						{
							$objExpDetails = Experience::find_by_var_name($arrSearchFactor[1]);
							$arrProfileUpdate['year_experience'] = $objExpDetails->id;
						}
						
						if($arrSearchFactor[0] == "job_type")
						{
							$arrProfileUpdate['look_job_type'] = $arrSearchFactor[1];
						}
						
						if($arrSearchFactor[0] == "category[]")
						{
							$arrProfileCatUpdate['category_id'] = $arrSearchFactor[1];
						}
						
						if($arrSearchFactor[0] == "location")
						{
							$arrProfileUpdate['city'] = $arrSearchFactor[1];
						}
					}
				}
			}
		}

		if(is_array($arrProfileUpdate) && (count($arrProfileUpdate)>0))
		{
			// update default CV
			//echo "--".$employee_id;
			
			//print("<pre>");
			//print_r($arrProfileUpdate);
			
			$boolCVUpdate = CVSetting::fnUpdateDefaultCV($arrProfileUpdate,$employee_id);
		}
		
		if(is_array($arrProfileCatUpdate) && (count($arrProfileCatUpdate)>0))
		{
			// update default CV category
			$objCVId = CVSetting::employee_find_default_cv($employee_id);
			//echo "--".$objCVId->id;
			//print("<pre>");
			//print_r($arrProfileCatUpdate);
			
			$boolCatUpdate = Category::fnUpdateDefaultCVCategory($arrProfileCatUpdate,$objCVId->id);
		}
		if($boolCVUpdate)
		{
			$message = "<div class='success'>Updated default seach criteria successfully.</div>";
		}
		else
		{
			$message = "<div class='error'>Please try again</div>";
		}
	}
	
	elseif( $_GET['action'] == 'search' && isset($_REQUEST['search_id']) ){
		$id = (int)$_REQUEST['search_id'];
		$found = SaveSearch::find_by_id( $id );
		if($found){
			$session->message ( $message );
			redirect_to( BASE_URL. "search/?portid=".$intPortId."&".urldecode(urldecode($found->reference)));
			die;
		}
			$session->message ( $message );
			redirect_to( BASE_URL. "save_search/?portid=".$intPortId);
			die;
	}

	
	/**deleting */
	elseif( $_GET['action'] == 'delete' && isset($_GET['search_id']) ){
		$id = (int)$_REQUEST['search_id'];	
		$save_search = new SaveSearch();
		$save_search->fk_employee_id = $employee_id;
		$save_search->id = $id;

		if( $save_search->delete_saveSearch()){
			$message = "<div class='success'>".format_lang('success','delete_success')."</div>";
		}else{
			$message = "<div class='error'>".format_lang('errormsg',64)."</div>";
		}		
	}
	else{
		$session->message ( $message );
		redirect_to( BASE_URL. "save_search/?portid=".$intPortId);
		die;
	}
	$session->message ( $message );
	redirect_to(BASE_URL. "save_search/?portid=".$intPortId);
}
	$save_search_arr = SaveSearch::find_by_user_id( $user_id );
	if ( !empty( $save_search_arr ) ){
		$search = array();
		$i=1;
		foreach( $save_search_arr as $save_search ):
			$search[$i]['id'] = $save_search->id;
			$search[$i]['reference_name'] = $save_search->reference_name;
			$search[$i]['reference'] = urldecode( $save_search->reference );
			$search[$i]['is_deleted'] = $save_search->is_deleted;
			$search[$i]['created_at'] = strftime(DATE_FORMAT, strtotime($save_search->date_save) );
		  $i++;
		endforeach;
		$smarty->assign( 'save_search', $search );
	}
	
$html_title 		= SITE_NAME . " -  ".format_lang('page_title','save_search'). chr(10).strip_html($employee->full_name() );
$smarty->assign( 'port_id', $intPortId );
$smarty->assign('lang', $lang);
//$smarty->assign('leftmenu', $smarty->fetch('left_menu_job.tpl'));
$smarty->assign( 'message', $message );		
$smarty->assign('rendered_page', $smarty->fetch('save_search.tpl') );
?>