<?php
App::uses('Component', 'Controller');
class TimeCalculationComponent extends Component 
{
    public $components = array('Session');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnGetBeforeDate($intPeriod = "",$strDate = "")
	{
            $current_date = $strDate;
		if($intPeriod && $strDate)
		{
			$arrReturnDate = array();
			switch($intPeriod)
			{
				case "1": $strDate = date('Y-m-d', strtotime($strDate .' -'.$intPeriod.' day'));
						  $arrReturnDate['start'] = $strDate." 00:00:00";
						  $arrReturnDate['end'] = $strDate." 23:59:59";
						  break;
				case "7": $previous_week = strtotime("-0 week +1 day");
						  $start_week = strtotime("last sunday midnight",$previous_week);
						  $end_week = strtotime("next saturday",$start_week);
						  $start_week = date("Y-m-d",$start_week);
						  $end_week = date("Y-m-d",$end_week); 
						  $arrReturnDate['start'] = $start_week." 00:00:00";
						  $arrReturnDate['end'] = $end_week." 23:59:59";
						  break;
//				case "30": $month_ini = new DateTime("first day of last month");
//						   $month_end = new DateTime("last day of last month");
//						   $arrReturnDate['start'] = $month_ini->format('Y-m-d')." 00:00:00";
//						   $arrReturnDate['end'] = $month_end->format('Y-m-d')." 23:59:59";
//						   break;
				case "30": $year = date('Y');
                                    $strDate = date('Y-m-d', strtotime($strDate));
						    $arrReturnDate['start'] = $year."-01-01 00:00:00";
						    $arrReturnDate['end'] = date("Y-m-d h:i:s");
						   break;
				case "365": $year = date('Y') - 1; 
						    $arrReturnDate['start'] = $year."-01-01 00:00:00";
						    $arrReturnDate['end'] = $year."-12-31 23:59:59";
						    break;
				case "zero": 	$strDate = date('Y-m-d', strtotime($strDate));
							$arrReturnDate['start'] = $strDate." 00:00:00";
							$arrReturnDate['end'] = $strDate." 23:59:59";
							break;
				case "curr_year": $year = date('Y'); 
                                    $strDate = date('Y-m-d', strtotime($strDate));
							$arrReturnDate['start'] = $year."-01-01 00:00:00";
						        $arrReturnDate['end'] = $strDate." 00:00:00";
						    break;
//				case "12": $strDate = date('Y-m-d', strtotime($strDate .' -'.$intPeriod.' months'));
//                                    $current_date = date('Y-m-d', strtotime($current_date .' -1 day'));
//                                                        $arrReturnDate['start'] = $strDate." 00:00:00";
//                                                        $arrReturnDate['end'] = $current_date." 00:00:00";
//                                                        break;
			}
                        
			return $arrReturnDate;
		}
		else
		{
			return false;
		}
	}

	public function fnGetBeforeTime($intMins = "",$strDateTime = "")
	{
		//echo "--".$intMins;
		//echo "--".$strDateTime;
		
		if($intMins && $strDateTime)
		{
			$strSecsOfActualDate = strtotime($strDateTime);
			$intSecsOfDiffTime = ($intMins * 60);
			
			$strBeforeTime = ($strSecsOfActualDate - $intSecsOfDiffTime);
			
			if($strBeforeTime)
			{
				$strActualBeforeTime = date('Y-m-d H:i:s',$strBeforeTime);
				
				return $strActualBeforeTime;
			}
			else
			{
				return false;
			}			
		}
		else
		{
			return false;
		}
	}
	
	public function fnAddMinsGetTime($intMins = "",$strDateTime = "")
	{
		if($intMins && $strDateTime)
		{
			$strSecsOfActualDate = strtotime($strDateTime);
			$intSecstoAddinTime = ($intMins * 60);
			
			$strAddTime = ($strSecsOfActualDate + $intSecstoAddinTime);
			
			if($strAddTime)
			{
				$strResultAddTime = date('Y-m-d H:i:s',$strAddTime);
				return $strResultAddTime;
			}
			else
			{
				return false;
			}			
		}
		else
		{
			return false;
		}
	}
	
	
	public function fnConvertMinsToSecs($intMins = "")
	{
		if($intMins)
		{
			$intSecs = ($intMins * 60);
			return $intSecs;
		}
		else
		{
			return false;
		}
	}
	
	public function fnGetDurationInDays($strFromDate = "",$strToDate = "")
	{
		if($strFromDate && $strToDate)
		{
			$str = (strtotime($strToDate)) - (strtotime($strFromDate));
			$strDateDiff =  floor($str/3600/24);
			return $strDateDiff;
		}
	}
	
	public function fnGetDurationInMonths($strFromDate = "",$strToDate = "")
	{
		if($strFromDate && $strToDate)
		{
			$str = (strtotime($strFromDate)) - (strtotime($strToDate));
			$strDateDiff =  floor($str/3600/720);
			return $strDateDiff;
		}
	}
        
        
	
	public function fnGetMonthsFromDays($intDays = "")
	{
		if($intDays)
		{
			$intMonthsCount = round(($intDays / 30));
			return $intMonthsCount;
		}
	}
	
	
	public function fnGetLastYearDate()
	{
		$strCurrentYear = date("Y");
		$strLastYear = ($strCurrentYear-1);
		
		$strMonth = date('m');
		$strDate = date('d');
		
		$strLastYearDate = $strLastYear."-".$strMonth."-".$strDate." 00:00:00";
		
		return $strLastYearDate;
	}
	
	public function fnFindCurrentMonth()
	{
		$strMonth = date("m");
		return $strMonth;
	}
	
	public function fnFindLastMonth()
	{
		
		$strMonth = date('m',strtotime('first day of last month'));

		return $strMonth;
	}
	
	public function fnFindCurrentYear()
	{
		$strYear = date("Y");
		return $strYear;
	}
	
	public function fnFindLastYear()
	{
		$strYear = (date("Y")-1);
		return $strYear;
	}
}
?>