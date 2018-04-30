<?php

class Session{
	private 	$logged_in=false;
	public 		$user_id;
	public 		$job_seeker_id;
	private 	$access=false;
	private 	$job_seeker=false;
	private 	$recuriter=false;
	private 	$admin=false;
	private 	$username=false;
	private 	$job_seeker_username=false;
	public 		$message;
	public 		$page="";
	private 	$account_active="";
	private 	$page_title="";
	
	function __construct(){
		session_start();
		global $intLoggPortalId;

		$this->check_message();
		$this->check_access_level();
		$this->check_login();
		$this->check_page();
		$this->check_account_active();
		$this->check_page_title();
		
	}

	public function login ( $user, $access ){
		if( $user ){
			$this->logout();
			$this->user_id 			= $_SESSION['user_id'] 			= $user->id;
			$this->username 		= $_SESSION['username'] 		= $user->username;
			$this->access 			= $_SESSION['access_level'] 	= $access;
			$this->account_active 	= $_SESSION['account_active'] 	= $user->is_active;
			$this->logged_in 		= true;
		}
	}
/****/
	public function get_access_level(){
		return $this->access;
	}
	
	public function get_job_seeker(){
		return $this->job_seeker;
	}
	
	public function get_jobseeker_id($intPortalId = "")
	{
		global $intLoggPortalId;
		
		return $_SESSION['PortalUser_'.$intLoggPortalId]['user_id'];
	}
	
	public function get_jobseeker_hc_uid($intPortalId = "")
	{
		global $intLoggPortalId;
		
		return $_SESSION['PortalUser_'.$intLoggPortalId]['hcuid'];
	}
	
	public function get_recuriter(){
		return $this->recuriter;
	}
	
	public function get_employer()
	{
		global $intLoggPortalId;
		
		return $_SESSION['PortalUser_'.$intLoggPortalId]['user_id'];
	}

	public function get_admin(){
		return $this->admin;
	}
	
	public function get_account_active(){
		return $this->account_active;
	}
	
	public function get_username(){
		return $this->username;
	}
	
	public function get_seeker_username($intPortalId = ""){
		global $intLoggPortalId;
		return $_SESSION['PortalUser_'.$intLoggPortalId]['username'];
	}
	
	public function get_user_id(){
		return $this->user_id;
	}
	
	public function get_page_title(){
		return $this->page_title;
	}
	
	public function set_page_title( $page ){
		if( !empty($page)){
			//$this->remove_page();
			$_SESSION['page_title'] = $page;
		}else{
			return $this->page;
		}
	}

	private function check_access_level(){
		global $intLoggPortalId;
		$this->job_seeker = false;
		$this->recuriter = false;
		$this->admin	=false;
		
		if(isset($intLoggPortalId))
		{
			if(isset($_SESSION['PortalUser_'.$intLoggPortalId]['access_level']))
			{
				if($_SESSION['PortalUser_'.$intLoggPortalId]['access_level'] == "User")
				{
					$this->job_seeker = true;
					$this->job_seeker_username = $_SESSION['PortalUser_'.$intLoggPortalId]['username'];
				}
			}
		}
		
		if(isset($_SESSION['BackendUser']['access_level']))
		{
			if($_SESSION['BackendUser']['access_level'] == "Recuriter")
			{
				$this->recuriter = true;
				$this->username = $_SESSION['BackendUser']['username'];
			}
			else
			{
				$this->admin = true;
				$this->username = $_SESSION['BackendUser']['username'];
			}
		}
		
		
		
		/*if( isset($_SESSION['access_level']) ){
			
			if( $_SESSION['access_level'] == "User"){
				$this->job_seeker = true;
				$this->username = $_SESSION['username'];
			}else if( $_SESSION['access_level'] == "Recuriter" ){
				$this->recuriter = true;
				$this->username = $_SESSION['BackendUser']['username'];
			}else if( $_SESSION['access_level'] == "Admin" ){
				$this->admin = true;
				$this->username = $_SESSION['BackendUser']['username'];
			}else{
				$this->job_seeker = false;
				$this->recuriter = false;
				$this->admin	=false;
			}
			
			//$this->access = $_SESSION['access_level'];
		}else{
			$this->job_seeker = false;
			$this->recuriter = false;
		}*/
	}
	
	private function check_account_active(){
		if(isset($_SESSION['BackendUser']['access_level']))
		{
			if($_SESSION['BackendUser']['access_level'] == "Recuriter" || $_SESSION['BackendUser']['access_level'] == "Admin")
			{
				if( isset($_SESSION['BackendUser']['account_active']) && $_SESSION['BackendUser']['account_active'] == 'N' ){
					$this->account_active = $_SESSION['BackendUser']['account_active'];
				}else{
					$this->account_active = "";
				}
			}
			else
			{
				if( isset($_SESSION['BackendUser']['account_active']) && $_SESSION['BackendUser']['account_active'] == 'N' ){
					$this->account_active = $_SESSION['BackendUser']['account_active'];
				}else{
					$this->account_active = "";
				}
			}
		}
	}
	
	private function check_login(){
		global $intLoggPortalId;
		unset($this->user_id);
		$this->logged_in = false;
		
		if(isset($_SESSION['BackendUser']['access_level']))
		{
			if($_SESSION['BackendUser']['access_level'] == "Recuriter" || $_SESSION['BackendUser']['access_level'] == "Admin")
			{
				if( isset($_SESSION['BackendUser']['user_id']) ){
					$this->user_id = $_SESSION['BackendUser']['user_id'];
					$this->logged_in = true;
				}
			}
		}
		
		if(isset($intLoggPortalId))
		{
			if($_SESSION['PortalUser_'.$intLoggPortalId]['access_level'] == "User")
			{
				if(isset($_SESSION['PortalUser_'.$intLoggPortalId]['user_id']))
				{
					$this->job_seeker_id = $_SESSION['PortalUser_'.$intLoggPortalId]['user_id'];
					$this->logged_in = true;
				}
			}
		}
	}
	
	private function check_message(){
		if( isset($_SESSION['message']) ){
			$this->message = $_SESSION['message'];
			//unset( $_SESSION['message'] );
		}else{
			$this->message = "";
		}
	}
	
	private function check_page(){
		if( isset($_SESSION['page']) ){
			$this->page = $_SESSION['page'];
			//unset( $_SESSION['page'] );
		}else{
			$this->page = "";
		}
	}
	
	private function check_page_title(){
		if( isset($_SESSION['page_title']) ){
			$this->page_title = $_SESSION['page_title'];
		}else{
			$this->page_title = "";
		}
	}
	

	
/**/
	//public function is_logged_in(){
	//	return $this->logged_in;
	//}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($_SESSION['access_level']);
		unset($_SESSION['username']);
		unset($_SESSION['account_active']);
		unset($this->access);
		unset($this->user_id);
		unset($this->logged_in);
		unset($this->recuriter);
		unset($this->job_seeker);
		unset($this->admin);
	}

	public function message( $msg="" ){
		if( !empty($msg)){
			$_SESSION['message'] = $msg;
		}else{
			return $this->message;
		}
	}

	/**Page setting**/
	public function set_page( $page ){
		if( !empty($page)){
			//$this->remove_page();
			$_SESSION['page'] = $page;
		}else{
			return $this->page;
		}
	}
	
	public function remove_page(){
		unset( $_SESSION['page'] );
	}
	
	public function remove_page_title(){
		unset( $_SESSION['page_title'] );
	}
	
	
	public function get_page(){
		return $this->page;
	}
	
	/**end */
	
}

$session = new Session();
$message = $session->message();

?>
