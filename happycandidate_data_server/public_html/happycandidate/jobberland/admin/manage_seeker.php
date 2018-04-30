<?php  require_once( "../initialise_files.php" );  
	include_once("sessioninc.php");

	$employee 	= new Employee();
	
	$smarty->assign( 'employee_id', $_POST['employee_id'] );
		
###################### DELETE ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete" ){
		$employee->id = (int)$_GET['id'];
		$employee->delete();
	}
	
	if(isset($_POST['delete_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
		foreach( $_POST['employee_id'] as $key => $value ){
			if($value != "" ) {
				$employee->id = (int)$value;
				if($employee->delete()){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been deleted </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### deactivate ####################################		
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "deactivate" ){
		$employee->id = $_GET['id'];
		$employee->deactive_user();
	}
	if(isset($_POST['deactivate_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
		foreach( $_POST['employee_id'] as $key => $value ){
			if($value != "" ) {
				$employee->id = $value;
				if( $employee->deactive_user() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been deactivated </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
	
###################### activate ###################################	
	if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "activate" ){
		$employee->id = $_GET['id'];
		$employee->active_user();
	}
	if(isset($_POST['activate_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
		foreach( $_POST['employee_id'] as $key => $value ){
			if($value != "" ) {
				$employee->id = $value;
				if( $employee->active_user() ){ $success=true;}
			}
		}
		if($success){
			$session->message("<div class='success'>Employee(s) has been actived </div>");
			redirect_to( $_SERVER['PHP_SELF'] );
			die;
		}
	}
####################### APPROVE ############################################
if(isset($_POST['approved_all']) && $_POST['employee_id'] != "" && sizeof($_POST['employee_id']) != 0 ){
	foreach( $_POST['employee_id'] as $key => $value ){
		if($value != "" ) {
			$employee->id = $value;
			if( $employee->approved_account() ){ $success=true;}
		}
	}
	if($success){
		$session->message("<div class='success'>Job Seeker(s) has been approved </div>");
		redirect_to( $_SERVER['PHP_SELF'] );
		die;
	}
}

###############################################################################
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = JOBS_PER_SEARCH;
		$total_count = Employee::count_all();

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
		$sql.=" LIMIT {$per_page} ";
		$sql.=" OFFSET {$offset} ";
		$lists = Employee::find_by_sql( $sql );

		$manage_lists = array();
		if($lists && is_array($lists)){
			$i=1;
			foreach( $lists as $list ):
			  // retrieving portal name
			  if($list->hc_portal_id)
			  {
				$arrPortalDetail = Employer::find_portal_by_id($list->hc_portal_id);
							
				if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
				{
					$manage_lists[$i]['portalid'] = $list->hc_portal_id;
					if($arrPortalDetail['career_portal_name'])
					{
						$manage_lists[$i]['portalname'] = $arrPortalDetail['career_portal_name'];
					}
					else
					{
						$manage_lists[$i]['portalname'] = '';
					}
					
					
				}
			  }
			  $manage_lists[$i]['rowncount'] = $i;
			  $manage_lists[$i]['id'] 		= $list->id;
			  $manage_lists[$i]['employee_id'] 		= $list->id;
			  $manage_lists[$i]['username'] 		= $list->username;
			  $manage_lists[$i]['fname']	 		= $list->fname;
			  $manage_lists[$i]['lname']	 		= $list->sname;
			  $manage_lists[$i]['email_address'] 	= $list->email_address;
			  $manage_lists[$i]['date_register'] 	= strftime( DATE_FORMAT, strtotime($list->date_register));
			  $manage_lists[$i]['last_login'] 		= strftime( DATE_FORMAT, strtotime($list->last_login));
			  $manage_lists[$i]['is_active'] 		= $list->is_active;
			  $manage_lists[$i]['status'] 			= $list->employee_status ;
			  $i++;
			endforeach;
			
			/* print("<pre>");
			print_r($manage_lists); */
			
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
//$smarty->assign('leftmenu', $smarty->fetch('admin/left_menu_users.tpl'));
//$smarty->assign('leftmenu', $smarty->fetch('admin/left_menu_admin.tpl'));
$smarty->assign('pagetitle', 'Job Seekers');
$smarty->assign( 'message', $message );	
$smarty->assign('rendered_page', $smarty->fetch('admin/manage_seeker.tpl') );
$smarty->display('admin/index.tpl');
unset($_SESSION['message']);
?>