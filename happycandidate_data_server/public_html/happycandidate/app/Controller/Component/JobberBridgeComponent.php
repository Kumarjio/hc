<?php
App::uses('Component', 'Controller');
class JobberBridgeComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}

	public function fnGetSeekerProfilePerformance($intPortalId = "")
	{
		$strProfilePerformanceUrl = Configure::read('Jobber.seekerprofileperformanceurl');
		$arrPostArray = array('portid'=>$intPortalId);
		$fields = $arrPostArray;
		$fields_string = "";
		//url-ify the data for the POST
		foreach($fields as $key=>$value) 
		{ 
			$fields_string .= $key.'='.$value.'&'; 
		}
		$fields_string = rtrim($fields_string, '&');
		$strCookie = 'HCJPORTAL'.$intPortalId.'=' . $_COOKIE['HCJPORTAL'.$intPortalId] . '; path=/';
		//$strCookie = session_name().'=' . $_COOKIE[session_name()] . '; path=/';
		//session_write_close();
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $strProfilePerformanceUrl);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ch, CURLOPT_COOKIE, $strCookie ); 

		//execute post
		$result = curl_exec($ch);
		$result = json_decode($result);
		/* print("<pre>");
		print_r($result);
		exit; */
		return $result;
	}
	
	public function fnGetNewJobNotificationCandidates($strStartDateTime = "",$strEndDateTime = "")
	{
		if($strStartDateTime && $strEndDateTime)
		{
			$strNewJobNotificationCandidatesUrl = Configure::read('Jobber.newjobnotificationseekersurl');
			
			$arrPostArray = array('strtime'=>$strStartDateTime,"strendtime"=>$strEndDateTime);
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
	
	public function fnLogSeekerIn($arrSeeker = array())
	{
		if(is_array($arrSeeker) && (count($arrSeeker)>0))
		{
			/*print("<pre>");
			print_r($arrSeeker);*/
			
			$strCandidatesLoginUrl = Configure::read('Jobber.seekerloginurl');
			$fields = $arrSeeker;
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//$strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';
			//session_write_close();
			
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCandidatesLoginUrl);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch,CURLOPT_COOKIE, $strCookie );
			//curl_setopt($ch,CURLOPT_COOKIEJAR,'cookie.txt');			

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
	
	public function fnLogSeekerOut($arrSeeker = array())
	{
		if(is_array($arrSeeker) && (count($arrSeeker)>0))
		{
			/*print("<pre>");
			print_r($arrSeeker);*/
			
			$strCandidatesLoginUrl = Configure::read('Jobber.seekerlogouturl');
			$fields = $arrSeeker;
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) 
			{ 
				$fields_string .= $key.'='.$value.'&'; 
			}
			$fields_string = rtrim($fields_string, '&');
			//$strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';
			//session_write_close();
			
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $strCandidatesLoginUrl);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch,CURLOPT_COOKIE, $strCookie );
			//curl_setopt($ch,CURLOPT_COOKIEJAR,'cookie.txt');			

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