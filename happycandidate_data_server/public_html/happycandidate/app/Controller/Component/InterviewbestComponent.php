<?php
App::uses('Component', 'Controller');
class InterviewbestComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnInterviewbestGetUserStats()
	{
		$strCurlForRequest = "https://www.interviewbest.com/api/stats/";
		$request_headers = array();
		$request_headers[] = 'Connection: close';
		//$request_headers[] = 'Content-Length: $data_len';
		$request_headers[] = 'Token: 2dc5925e044bbaf0787ec36921429394';
			
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_setopt($ch, CURLOPT_CAINFO, '/path/to/cacert.pem')
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close','Token: 2dc5925e044bbaf0787ec36921429394')); 
		//curl_setopt($ch,CURLOPT_POST, count($fields));
		//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$result = curl_exec($ch);
		if (!$result) {
			echo "----".curl_errno($ch)."---".curl_error($ch);
			
			$info = curl_getinfo($ch);
			print("<pre>");
			print_r($info);
		}
		
		$arrResponse = json_decode($result,true);
		//close connection
		curl_close($ch);
		
		return $arrResponse;
		
		/*print("<pre>");
		print_r($arrResponse);
		exit;*/
	}
	
	public function fnRemoveInterviewBestAccount($intUserid = "")
	{
		if($intUserid)
		{
			$strCurlForRequest = "https://www.interviewbest.com/api/cancel";
			$arrData = array(
							'userid' => $intUserid
					);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($arrData as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			
			$request_headers = array();
			$request_headers[] = 'Connection: close';
			//$request_headers[] = 'Content-Length: $data_len';
			$request_headers[] = 'Token: 2dc5925e044bbaf0787ec36921429394';
				
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close','Token: 2dc5925e044bbaf0787ec36921429394')); 
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);
			if (!$result) {
				//echo "----".curl_errno($ch)."---".curl_error($ch);
				
				$info = curl_getinfo($ch);
				//print("<pre>");
				//print_r($info);
			}
			curl_close($ch);
			$arrResponse = json_decode($result,true);
			
			/*print("<pre>");
			print_r($arrResponse);
			
			print("<pre>");
			print_r($result);
			exit;*/
			
			return $arrResponse;
		}
		else
		{
			return false;
		}
	}
	
	public function fnCreateInterviewBestAccount($arrUserDetail = array())
	{
		$strCurlForRequest = "https://www.interviewbest.com/api/create";
		/*$arrData = array(
							'fname' => "Rajendra",
							'lname' => "Kandpal",
							'email' => "rajendra_kandpal@hc-test.com",
							'password' => "testit"
					);*/
		$arrData = $arrUserDetail;
		$fields_string = "";
		//url-ify the data for the POST
		foreach($arrData as $key=>$value) 
		{ 
			$fields_string .= $key.'='.$value.'&'; 
		}
		$fields_string = rtrim($fields_string, '&');
		
		$request_headers = array();
		$request_headers[] = 'Connection: close';
		//$request_headers[] = 'Content-Length: $data_len';
		$request_headers[] = 'Token: 2dc5925e044bbaf0787ec36921429394';
			
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $strCurlForRequest);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close','Token: 2dc5925e044bbaf0787ec36921429394')); 
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$result = curl_exec($ch);
		if (!$result) {
			//echo "----".curl_errno($ch)."---".curl_error($ch);
			
			$info = curl_getinfo($ch);
			//print("<pre>");
			//print_r($info);
		}
		curl_close($ch);
		$arrResponse = json_decode($result,true);
		
		/*print("<pre>");
		print_r($arrResponse);
		
		print("<pre>");
		print_r($result);
		exit;*/
		
		return $arrResponse;
	}
	
	
	public function fnTestCall()
	{
		//$strUrl = "https://www.interviewbest.com/api/create";
		//$strUrl = "https://www.interviewbest.com/api/cancel";
		$strUrl = "https://www.interviewbest.com/api/stats/974";
		/*$arrData = array(
							'fname' => "TestNew",
							'lname' => "Seeker",
							'email' => "testnew_seeker@hc-test.com",
							'password' => "test123"
					);*/
		
		$arrData = array(
							'userid' => "973"
					);
		$data_url = http_build_query ($arrData);
		$data_len = strlen ($data_url);
		$strStreamContext = stream_context_create (array ('http'=>array ('method'=>'GET'
            , 'header'=>"Connection: close\r\nContent-Length: $data_len\r\nToken: 2dc5925e044bbaf0787ec36921429394"
            , 'content'=>$data_url
            )));

		$arrResult = json_decode(file_get_contents($strUrl,false,$strStreamContext),true);

		print("<pre>");
		print_r($arrResult);
		exit;
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