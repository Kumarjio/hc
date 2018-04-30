<?php
App::uses('Component', 'Controller');
class LmsBridgeComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnSyncUsersToLms()
	{
		$strCurlForRequest = Configure::read('Lms.syncuserspath');
			
			$fields = array(
								'check' => "1"
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			return $arrResponse;
	}
	
	public function fnSetVendorInMoodle($arrCategoryDetail = array())
	{
		if(is_array($arrCategoryDetail) && (count($arrCategoryDetail)>0))
		{
			
			$strCurlForRequest = Configure::read('Lms.setupvendorrole');
			
			$fields = array(
								'categoryname' => $arrCategoryDetail['categoryname'],
								'parent' => "1",
								'idnumber' => "",
								'description' => "This is simple category description",
								"decriptionformat" => "1",
								'id' => "0",
								'portal_id' => $arrCategoryDetail['portalid'],
								'username'=> $arrCategoryDetail['username']
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}

	public function fnSetEmployerInMoodle($arrCategoryDetail = array())
	{
		if(is_array($arrCategoryDetail) && (count($arrCategoryDetail)>0))
		{
			
			$strCurlForRequest = Configure::read('Lms.categoryrolepath');
			
			$fields = array(
								'categoryname' => $arrCategoryDetail['categoryname'],
								'parent' => "0",
								'idnumber' => "",
								'description' => "This is simple category description",
								"decriptionformat" => "1",
								'id' => "0",
								'portal_id' => $arrCategoryDetail['portalid'],
								'username'=> $arrCategoryDetail['username']
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnDeleteLmsCourse($intDelCourseId = "")
	{
		if($intDelCourseId)
		{
			$strCurlForRequest = Configure::read('Lms.coursedelete')."?usert_type_request=admin";
			
			$fields = array(
								'courseid'=>$intDelCourseId,
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//print("<pre>");
			//print_r($_COOKIE);
			//exit;
			
			$strCookie = '_BackendUser=' . $_COOKIE['_BackendUser'] . '; path=/';
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			session_write_close();
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_COOKIE, $strCookie );

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			//print("<pre>");
			//print_r($arrResponse);
			//exit;
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnUpdateLmsCourse($arrCourseData = array())
	{
           
		if(is_array($arrCourseData) && (count($arrCourseData)>0))
		{
		
			$strCurlForRequest = Configure::read('Lms.courseupdate')."?usert_type_request=admin";
			
			$fields = array(
                                'coursename'=>$arrCourseData['Resources']['product_name'],
                                'courseid'=>$arrCourseData['Resources']['external_content_id'],
                        );
			if($arrCourseData['Resources']['categoryid'])
			{
				$fields['categoryid'] = $arrCourseData['Resources']['categoryid'];
			}
//			print("lms<pre>");
//			print_r($fields);
//			exit;
			
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			
			$fields_string = rtrim($fields_string, '&');
			$strCookie = '_BackendUser=' . $_COOKIE['_BackendUser'] . '; path=/';
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			session_write_close();
			//open connection
			$ch = curl_init();
                        
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_COOKIE, $strCookie );

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnCreateLmsCourse($arrCourseData = array())
	{
		if(is_array($arrCourseData) && (count($arrCourseData)>0))
		{
			$strCurlForRequest = Configure::read('Lms.coursecreate');
			
			$fields = array(
								'coursename'=>$arrCourseData['Resources']['product_name'],
						);
			if($arrCourseData['Resources']['categoryid'])
			{
				$fields['categoryid'] = $arrCourseData['Resources']['categoryid'];
			}
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetPaypalEnrolledPortalCourses($intPortalId = "")
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.paypalenrolledcoursepath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array(
								'portid' => $intPortalId,
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetCandidatesBadges($intPortalId = "")
	{
		if($intPortalId)
		{
			$arrLoggedUser = $this->Auth->user();
			$strCurlForRequest = Configure::read('Lms.candidatebadgespath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array(
								'portid' => $intPortalId,
								'username'	=> $arrLoggedUser['candidate_email']
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result,true);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetAllMaterial($intPortalId = "")
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.categorygetallmaterialpath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array(
								'portid' => $intPortalId,
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetPortalWebinars($intPortalId = "")
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.categorygetwebinarspath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array(
								'portid' => $intPortalId,
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);

			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetPortalCourses($intPortalId = "")
	{
		if($intPortalId)
		{
			//echo "--".function_exists('curl_version');exit;
			$strCurlForRequest = Configure::read('Lms.categorygetcoursespath');
			//echo $intPortalId;exit;
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array(
								'portid' => $intPortalId,
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
//			echo "hello";exit;
			$result = curl_exec($ch);
			//echo "tello";exit;
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			/*if(curl_errno($ch))
			{
				    echo 'Curl error: ' . curl_error($ch);
			}*/
			//close connection
			curl_close($ch);
			/*echo "hi";exit;
			print("<pre>");
			print_r($arrResponse);exit;*/
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnSearchPortalWebinars($intPortalId = "",$arrSearchDetails = array())
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.searchwebinarpath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array('portid' => $intPortalId);
						
			if(is_array($arrSearchDetails) && (count($arrSearchDetails)>0))
			{
				if(isset($arrSearchDetails['webinar_name']))
				{
					$fields['webinar_name'] = $arrSearchDetails['webinar_name'];
				}
			}
			
			
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnSearchPortalCourses($intPortalId = "",$arrSearchDetails = array())
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.searchcoursepath');
			//$strCurlForRequest = "http://localhost/moodle/courses.php";
			
			$fields = array('portid' => $intPortalId);
						
			if(is_array($arrSearchDetails) && (count($arrSearchDetails)>0))
			{
				if(isset($arrSearchDetails['course_name']))
				{
					$fields['course_name'] = $arrSearchDetails['course_name'];
				}
			}
			
			
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnSetupSeeker($intPortalId = "",$intUserEmail = "")
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.setupseeker');
			//$strCurlForRequest = 'http://localhost/moodle/setupSeeker.php';
			$fields = array(
								'portid' => $intPortalId,
								'username' => $intUserEmail,
								
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnLogSeekerIn($intPortalId = "",$arrUserEmail = "")
	{
		if($intPortalId)
		{
			$strCurlForRequest = Configure::read('Lms.loginurl');
			//$strCurlForRequest = 'http://localhost/moodle/setupSeeker.php';
			$fields = array(
								'candidate_portal_request' => $intPortalId,
								'username' =>$arrUserEmail['Candidate']['candidate_email'],
								'hcuid' =>$arrUserEmail['Candidate']['candidate_id'],
								'usert_type_request' =>"3",
								'social_plugin' => "1"
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnLogSeekerOut($strSessKey = "")
	{
		if($strSessKey)
		{
			$strCurlForRequest = Configure::read('Lms.loginurl');
			//$strCurlForRequest = 'http://localhost/moodle/setupSeeker.php';
			$fields = array(
								'sesskey' => $strSessKey,
						);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$arrResponse = json_decode($result);
			$arrResponse = (array) $arrResponse;
			//close connection
			curl_close($ch);
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetNotificationCandidates($intPortalId = "")
	{
		if($intPortalId)
		{
			$strNewJobNotificationCandidatesUrl = Configure::read('Lms.newmaterialnotificationseekersurl');
			
			$arrPostArray = array('getcandidates'=>'1','portid'=>$intPortalId);
			$fields = $arrPostArray;
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strNewJobNotificationCandidatesUrl);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$result = json_decode($result,true);
			/* print("<pre>");
			print_r($result);
			exit; */
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetNewMaterialForNotification($strStartDateTime,$strEndDateTime)
	{
		if($strStartDateTime && $strEndDateTime)
		{
			$strNewMaterialNotificationUrl = Configure::read('Lms.newmaterialnotificationseekersurl');
			
			$arrPostArray = array('getmaterial'=>'1','strtime'=>$strStartDateTime,'strendtime'=>$strEndDateTime);
			/*print("<pre>");
			print_r($arrPostArray);*/
			
			$fields = $arrPostArray;
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strNewMaterialNotificationUrl);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			$result = json_decode($result,true);
			/* print("<pre>");
			print_r($result);
			exit; */
			return $result;
		}
		else
		{
			return false;
		}
	}
}
?>