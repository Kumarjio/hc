<?php  require_once( "../initialise_files.php" );  
	
		include_once("sessioninc.php");
		
	$employee 	= new Employee();
	$smarty->assign( 'employee_id', $_POST['employee_id'] );
	
###################### DELETE ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete" ){
		$employee->id = (int)$_GET['id'];
		$arrUserDetail = Employee::find_by_id($employee->id);
		$intJSeekerDeleted = $employee->delete();
		if($intJSeekerDeleted)
		{
			$intHcSeekerDeleted = $employee->deleteFromHC($arrUserDetail->hc_uid);
			if($intHcSeekerDeleted)
			{
				$intLMSekkerDeleted = $employee->deleteFromLm($arrUserDetail->email_address);
			}
		}
		
	}
	
	if(isset($_POST['delete_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
		//$employee->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['employee_id'] as $key => $value ){
			if($value != "" ) {
				$employee->id = (int)$value;
				$arrUserDetail = Employee::find_by_id($employee->id);
				if($employee->delete())
				{ 
					$success=true;
					$intHcSeekerDeleted = $employee->deleteFromHC($arrUserDetail->hc_uid);
					if($intHcSeekerDeleted)
					{
						$intLMSekkerDeleted = $employee->deleteFromLm($arrUserDetail->email_address);
					}
				}
			}
		}
		if($success){
			$session->message("<div class='success'>Job Seeker(s) has been deleted </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### activate ###################################	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "activate" ){
		$employee->id = $_GET['id'];
		if ( $employee->active_user() ){
			$empUser = Employee::find_by_id($employee->id);
			$employee->hc_uid = $empUser->hc_uid;
			$employee->active_hc_user();
			$session->message("<div class='success'>Job Seeker(s) has been activated </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}else{
			$session->message("<div class='error'>Error</div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	if(isset($_POST['activate_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
		//$employee->admin_comments = $_POST['reject_reason'];
		foreach( $_POST['employee_id'] as $key => $value ){
			if($value != "" ) {
				$employee->id = $value;
				if( $employee->active_user() )
				{ 
					$empUser = Employee::find_by_id($employee->id);
					$employee->hc_uid = $empUser->hc_uid;
					$employee->active_hc_user();
					$success=true;
				}
			}
		}
		if($success){
			$session->message("<div class='success'>Job Seeker(s) has been activated </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
###############################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = JOBS_PER_SEARCH;
		$total_count = Employee::count_all_deactive();

		$smarty->assign( 'total_count', $total_count );
		$smarty->assign( 'page', $page );
		
		$pagination = new Pagination( $page, $per_page, $total_count );
		
		$smarty->assign( 'previous_page', $pagination->previous_page() );
		$smarty->assign( 'has_previous_page', $pagination->has_previous_page() );
		$smarty->assign( 'total_pages', $pagination->total_pages() );
		
		$smarty->assign( 'has_next_page', $pagination->has_next_page() );
		$smarty->assign( 'next_page', $pagination->next_page());
		
		$offset = $pagination->offset();
		$sql=" SELECT * FROM ".TBL_EMPLOYEE;
		$sql .= " WHERE is_active ='N' ";
		$sql.=" LIMIT {$per_page} ";
		$sql.=" OFFSET {$offset} ";
		$lists = Employee::find_by_sql( $sql );

$manage_lists = array();
		if($lists && is_array($lists)){
			$i=1;
			foreach( $lists as $list ):
			  $manage_lists[$i]['id'] 		= $list->id;
			  $manage_lists[$i]['employee_id'] 		= $list->id;
			  $manage_lists[$i]['username'] 		= $list->username;
			  $manage_lists[$i]['fname']	 		= $list->fname;
			  $manage_lists[$i]['lname']	 		= $list->sname;
			  $manage_lists[$i]['email_address'] 	= $list->email_address;
			  $manage_lists[$i]['date_register'] 	= strftime( DATE_FORMAT, strtotime($list->date_register));
			  $manage_lists[$i]['last_login'] 		= strftime( DATE_FORMAT, strtotime($list->last_login));
			  $manage_lists[$i]['is_active'] 		= $list->is_active;
			  $manage_lists[$i]['job_status'] 		= $list->employee_status ;
			  if($list->hc_portal_id)
			  {
				$arrPortalName = Employee::find_portal_by_portal_id($list->hc_portal_id);
				if(is_array($arrPortalName) && (count($arrPortalName)>0))
				{
					$manage_lists[$i]['portal_name'] = $arrPortalName['career_portal_name'];
					$manage_lists[$i]['portal_url'] = PORTALBASEURL.strtolower($arrPortalName['career_portal_name']);
				}
				else
				{
					$manage_lists[$i]['portal_name'] = "";
				}
			  }
			  else
			  {
				$manage_lists[$i]['portal_name'] = "";
			  }
			  $i++;
			endforeach;
			$smarty->assign( 'manage_lists', $manage_lists );
		}
		
		$query = "";
		if( !empty($_GET) ) {
			foreach( $_GET as $key => $data){
				if( !empty($data) && $data != "" && $key != "page" && $key != "bt_search"){
					$query .= "&amp;".$key."=".$data;
				}
			}
			$smarty->assign( 'query', $query );
		}
		
$smarty->assign( 'titles', get_lang ('titles') );
$html_title = SITE_NAME . " Add New Employer ";
$smarty->assign('lang', $lang);
$smarty->assign('leftmenu', $smarty->fetch('admin/left_menu_users.tpl'));
//$smarty->assign('leftmenu', $smarty->fetch('admin/left_menu_admin.tpl'));
$smarty->assign( 'message', $message );
$smarty->assign('pagetitle', 'Manage Users');	
$smarty->assign('rendered_page', $smarty->fetch('admin/manage_employee_deactive.tpl') );
$smarty->display('admin/index.tpl');
?>