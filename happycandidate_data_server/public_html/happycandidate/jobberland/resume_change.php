<?php $_SESSION['direct_to'] = BASE_URL."curriculum_vitae/?portid=".$intPortId; 	
	 include_once('sessioninc.php');
	 
	$username = $session->get_seeker_username($intPortId);
	$user_id = $session->get_jobseeker_id($intPortId);
	$country_code = DEFAULT_COUNTRY;
	
	$cv_setting = new CVSetting();
	$_SESSION['resume']['id'] = $cv_setting->id  = $cv_id = $id;
	$cv_setting->fk_employee_id = $user_id;
	$cv_personal_setting 	= new CVPersonalSetting();
	$cv_summary_setting 	= new CVSummarySetting();
	$cv_education_setting 	= new CVEducationSetting();
	$cv_eexperience_setting 	= new CVExperienceSetting();
	$cv_contratc_setting 	= new CVContractsSetting();
	$cv_awards_setting 	= new CVAwardsSetting();
	$cv_cpmpetancies_setting 	= new CVCompetanciesSetting();
	
	$experiences = Experience::find_all();
	if ( is_array($experiences) and !empty($experiences) ) {
		$experience_t = array();
		foreach( $experiences as $experience ):
			$experience_t[ $experience->id ] = $experience->experience_name;
		endforeach; 
		$smarty->assign( 'experience', $experience_t );

	}
	
	$educations	= Education::find_all();
	if ( is_array($educations) and !empty($educations) ) {
		$education_t = array();
		foreach( $educations as $education ):
			$education_t[ $education->id ] = $education->education_name;
		endforeach; 
		$smarty->assign( 'education', $education_t );
	}

	$categories	= Category::find_all();
	if ( is_array($categories) and !empty($categories) ) {
		$category_t = array();
		foreach( $categories as $category ):
			$category_t[ $category->id ] = $category->cat_name;
		endforeach; 
		$smarty->assign( 'category', $category_t );
	}
	
	$careers	= CareerDegree::find_all();
	if ( is_array($careers) and !empty($careers) ) {
		$career_t = array();
		foreach( $careers as $career ):
			$career_t[ $career->id ] = $career->career_name;
		endforeach; 
		$smarty->assign( 'career', $career_t );		
	}

	
	$job_status = JobStatus::find_all();
	if ( is_array($job_status) and !empty($job_status) ) {
		$statu_t = array();
		foreach( $job_status as $job_statu ):
			$statu_t[ $job_statu->id ] = $job_statu->status_name;
		endforeach; 
		$smarty->assign( 'job_status', $statu_t );
	}

	$job_types	= JobType::find_all();
	if ( is_array($job_types) and !empty($job_types) ) {
		$job_t = array();
		foreach( $job_types as $job_type ):
			$job_t[ $job_type->id ] = $job_type->type_name;
		endforeach; 
		$smarty->assign( 'job_type', $job_t );
	}
	
	$arrEducationContinueArray = array("No"=>"No","Yes"=>"Yes");
	$smarty->assign( 'educationcontinue', $arrEducationContinueArray );
	$smarty->assign( 'educationcontinueselected', "No" );
	
	$arrExperienceArray = array("0"=>"--Select Value--", "Current Organization"=>"Current Organization","Previous Organization"=>"Previous Organization");
	$smarty->assign( 'expoptions', $arrExperienceArray );
	$smarty->assign( 'expselected', "0" );
	
	$arrExperience = array(""=>"Select Year","0"=>"0","1"=>"1","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8",
							"9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16",
							"17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24",
							"25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30");
	$smarty->assign('yearsoptions',$arrExperience);
	$smarty->assign( 'yearselected',"");
							
	$arrMonth = array(""=>"Select Month","0"=>"0","1"=>"1","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8",
							"9"=>"9","10"=>"10","11"=>"11");
							
	$smarty->assign('monthsoptions',$arrMonth);
	$smarty->assign( 'monthsselected',"");

//when button is press 	
	if( isset($_POST['bt_save']) ){
		
		//about your self
		$_SESSION['resume']['status'] 	= $cv_setting->cv_status			= $cv_status= $_POST['txt_status'];
		$_SESSION['resume']['key_skills'] 	= $cv_setting->key_skills			= $cv_status= $_POST['key_skills'];
		/*$_SESSION['resume']['exper'] 	= $cv_setting->year_experience 		= $exper 	= $_POST['txt_experience'];
		$_SESSION['resume']['educ'] 	= $cv_setting->highest_education 	= $educ 	= $_POST['txt_education'];
		$_SESSION['resume']['salary'] 	= $cv_setting->salary_range 		= $salary 	= $_POST['txt_salary'];
		$_SESSION['resume']['availabe'] = $cv_setting->availability 		= $availabe	= $_POST['txt_availabe'];*/
		
		/*if( !empty($_POST['txt_start_date_Month']) && !empty($_POST['txt_start_date_Day']) && !empty($_POST['txt_start_date_Year']) ){
			$str_date = mktime(0,0,0,
				$_SESSION['resume']['month']=$str_date_m=$_POST['txt_start_date_Month'],
				$_SESSION['resume']['day']=$str_date_d=$_POST['txt_start_date_Day'], 
				$_SESSION['resume']['year']=$str_date_y=$_POST['txt_start_date_Year']);
			//$_SESSION['resume']['start_date'] = $str_date_y."-".$str_date_m."-".$str_date_d;
			$smarty->assign( 'defult_date', $str_date_y."-".$str_date_m."-".$str_date_d );
			$cv_setting->start_date 			= date("Y-m-d H:i:s",$str_date); //$_POST['txt_start_date'];
		}*/
		
		/*$_SESSION['resume']['position'] =$cv_setting->positions 				= $position = $_POST['txt_position'];
		//recent job details
		$_SESSION['resume']['rjt']=$cv_setting->recent_job_title 		= $rjt 		= $_POST['txt_recent_job_title'];
		$_SESSION['resume']['re']=$cv_setting->recent_employer 		= $re		= $_POST['txt_recent_employer'];
		$_SESSION['resume']['riw']=$cv_setting->recent_industry_work 	= $riw		= $_POST['txt_recent_industry'];
		$_SESSION['resume']['rcl']=$cv_setting->recent_career_level 	= $rcl 		= $_POST['txt_recent_career'];
		//what are you looking for
		$_SESSION['resume']['ljt'] =$cv_setting->look_job_title 		= $ljt 		= $_POST['txt_look_job_title'];
		$_SESSION['resume']['ljt2'] =$cv_setting->look_job_title2 		= $ljt2 	= $_POST['txt_look_job_title2'];*/
		
		/*if( sizeof($_POST['category']) != 0 && isset($_POST['category'])){
			$cv_details->look_industries="not empty";
		}
		
		if( sizeof($_POST['category']) > 10 ){
			$cv_setting->errors[]=format_lang('errormsg', 43);
		}*/
		
		/*$_SESSION['resume']['ljs'] = $cv_setting->look_job_status 		= $ljs 	= $_POST['txt_job_statu'];
		$_SESSION['resume']['job_type'] = $cv_setting->look_job_type = $job_type = $_POST['txt_job_type'];*/
		
		//where do you wont to work
		/*$_SESSION['resume']['lw'] = $cv_setting->city = $_SESSION['loc']['citycode'] = $_POST['txtcity'];
		$cv_setting->county	 = $_SESSION['loc']['countycode'] = $_POST['txtcounty'];
		$cv_setting->state_province	= $_SESSION['loc']['stateprovince']	= $_POST['txtstateprovince'];
		$cv_setting->country = $_SESSION['loc']['country'] = $_POST['txt_country'];*/
		
		/*$_SESSION['resume']['aya'] =$cv_setting->are_you_auth			= $aya = $_POST['txt_authorised_to_work'];
		$_SESSION['resume']['wtr'] =$cv_setting->willing_to_relocate 	= $wtr = $_POST['txt_relocate'];
		$_SESSION['resume']['wtt'] =$cv_setting->willing_to_travel 		= $wtt = $_POST['txt_travel'];
		$_SESSION['resume']['notes'] = $cv_setting->additional_notes 		= $notes = $_POST['txt_notes'];*/
		
		//$cv_setting->fk_employee_id			= $user_id;
		
		if( $cv_setting->save() ){
			$sql = " DELETE FROM ".TBL_CV_CAT. " WHERE cv_id=".(int)$id;
			$db->query( $sql );

			if( sizeof($_POST['category']) != 0 && isset($_POST['category'])){
				foreach ( $_POST['category'] as $key => $value ):
					if( isset($value) && $value != "" ){
						$sql = " INSERT INTO ".TBL_CV_CAT. " ( cv_id, category_id ) VALUES ( ". (int)$cv_id . ", ".(int)$value.") ";
						$db->query( $sql );
					}
				endforeach;
			}
			destroy_my_session();
			
			
			
			// cv personal detail
			$cv_personal_setting->cv_personal_f_name = $_POST['cand_f_name'];
			$cv_personal_setting->cv_personal_l_name = $_POST['cand_l_name'];
			$cv_personal_setting->cv_personal_address = $_POST['cand_address'];
			$cv_personal_setting->cv_personal_address1 = $_POST['address1'];
			$cv_personal_setting->cv_personal_country = $_POST['cand_country'];
			$cv_personal_setting->cv_personal_state = $_POST['cand_state'];
			$cv_personal_setting->cv_personal_district = $_POST['cand_county'];
			$cv_personal_setting->cv_personal_city = $_POST['cand_city'];
			$cv_personal_setting->cv_personal_zip_code = $_POST['cand_post_code'];
			$cv_personal_setting->cv_personal_telenumber = $_POST['cand_phone_number'];
			$cv_personal_setting->cv_personal_mob_number = $_POST['cand_mob_phone_number'];
			$cv_personal_setting->cv_personal_email = $_POST['cand_email'];
			$cv_personal_setting->cv_id = $cv_id;
			if($_POST['cand_personal_update_mode'])
			{
				$cv_personal_setting->cv_personal_detail_id = $_POST['cand_personal_update_mode'];
			}
			$cv_personal_setting->save();
			
			// cv personal summary
			$cv_summary_setting->cv_summary_type = $_POST['summary_type'];
			$cv_summary_setting->cv_qualification_summary = $_POST['text_sum_qual'];
			$cv_summary_setting->cv_exe_summary = $_POST['text_exe_qual'];
			$cv_summary_setting->cv_id = $cv_id;
			if($_POST['summary_edit_mode_id'])
			{
				$cv_summary_setting->cv_summary_id = $_POST['summary_edit_mode_id'];
			}
			$cv_summary_setting->save();
			
			// cv core competancies
			// cv education
			/*$cv_education_setting->cv_education_highest = $_POST['cand_degree'];
			$cv_education_setting->cv_education_school_uni_name = $_POST['cand_school_uni_name'];
			$cv_education_setting->cv_education_location = $_POST['cand_education_location'];
			$cv_education_setting->cv_education_continue = $_POST['cand_edu_classes'];
			$cv_education_setting->cv_id = $cv_id;
			if($_POST['education_edit_mode_id'])
			{
				$cv_education_setting->cv_education_id = $_POST['education_edit_mode_id'];
			}
			$cv_education_setting->save();*/
			
			// cv experience
			/*$cv_eexperience_setting->cv_experience_current = $_POST['exp'];
			$cv_eexperience_setting->cv_experience_company_name = $_POST['company_name'];
			$cv_eexperience_setting->cv_experience_company_location = $_POST['company_location'];
			$cv_eexperience_setting->cv_experience_company_job_title = $_POST['company_job_title'];
			$cv_eexperience_setting->cv_experience_company_responsibilities = $_POST['company_duties_respponsibilities'];
			$cv_eexperience_setting->cv_experience_company_accomplishments_impact = $_POST['company_accomplishments'];
			$cv_eexperience_setting->cv_id = $cv_id;
			if($_POST['experience_edit_mode_id'])
			{
				$cv_eexperience_setting->cv_experience_id = $_POST['experience_edit_mode_id'];
			}
			$cv_eexperience_setting->save();*/
			
			// cv projects
			/*$cv_contratc_setting->cv_contracts_name = $_POST['t_contractor_name'];
			$cv_contratc_setting->cv_contracts_company_name = $_POST['t_company_name'];
			$cv_contratc_setting->cv_contracts_job_title = $_POST['t_company_job_title'];
			$cv_contratc_setting->cv_contracts_job_cv_contracts_job_duraton = $_POST['t_company_job_duration'];
			$cv_contratc_setting->cv_contracts_accomplishments = $_POST['t_company_job_accomplishments'];
			$cv_contratc_setting->cv_id = $cv_id;
			if($_POST['contractor_edit_mode_id'])
			{
				$cv_contratc_setting->cv_contracts_id = $_POST['contractor_edit_mode_id'];
			}
			$cv_contratc_setting->save();*/
			
			// cv Awards
			$cv_awards_setting->cv_awards = $_POST['cv_awards'];
			$cv_awards_setting->cv_id = $cv_id;
			if($_POST['award_edit_mode_id'])
			{
				$cv_awards_setting->cv_awards_id = $_POST['award_edit_mode_id'];
			}
			$cv_awards_setting->save();
			
			
			$message ="<div class='success'>";
			if($cv_status == 'private')	: $message .= format_lang('cv','cv_info_1');
			else : $message .= format_lang('cv','cv_info_2'); endif;
			$message .="</div>";
			
			$message2 ="<div class='success'>CV Visibility is set to public<br />
							  This CV is currently set to <strong>PUBLIC</strong> and is 
							  <strong>SEARCHABLE</strong> by employers.</div>";
					   
			$session->message( $message );
			redirect_to( BASE_URL."curriculum_vitae/?portid=".$intPortId);
		}else{
			$message = "<div class='error'> 
							".format_lang('following_errors')."
						<ul> <li />";
			$message .= join(" <li /> ", $cv_setting->errors );
			$message .= " </ul> 
						</div>";
		}
	
	//if button is not press	
	}else{
		$cv_details = $cv_setting->cv_review_by_employee();

		if( !$cv_details && !is_array($cv_details) ){
			$session->message("<div class='error'>".format_lang("error",'cv_not_found')."</div>");
			redirect_to(BASE_URL . 'curriculum_vitae/?portid='.$intPortId);
			exit;
		}
		
		$_SESSION['resume']['status'] 	= $cv_status	= strtolower($cv_details->cv_status);
		$_SESSION['resume']['key_skills'] 	= $cv_skills	= $cv_details->key_skills;
		$smarty->assign( 'cvformkeyskills', $cv_skills );
		
		// get cv personal details
		$objPersonalFormDetail = $cv_personal_setting->getCVPersonalDetails($cv_details->id);
		if($objPersonalFormDetail)
		{
			$strCVFname = $objPersonalFormDetail->cv_personal_f_name;
			$smarty->assign( 'cvformfname', $strCVFname );
			
			$strCVPersonalUpdateMode = $objPersonalFormDetail->cv_personal_detail_id;
			$smarty->assign( 'cvformperupdatemode', $strCVPersonalUpdateMode );
			
			$strCVLname = $objPersonalFormDetail->cv_personal_l_name;
			$smarty->assign( 'cvformlname', $strCVLname );
			
			$strCVAddress = $objPersonalFormDetail->cv_personal_address;
			$smarty->assign( 'cvformaddress', $strCVAddress );
			
			$strCVAddress1 = $objPersonalFormDetail->cv_personal_address1;
			$smarty->assign( 'cvformaddress1', $strCVAddress1 );
			
			$strCVZipCode = $objPersonalFormDetail->cv_personal_zip_code;
			$smarty->assign( 'cvformzipcode', $strCVZipCode );
			
			$strtelenumber = $objPersonalFormDetail->cv_personal_telenumber;
			$smarty->assign( 'cvformtelenumber', $strtelenumber );
			
			$strmobnumber = $objPersonalFormDetail->cv_personal_mob_number;
			$smarty->assign( 'cvformmobnumber', $strmobnumber );
			
			$stremail = $objPersonalFormDetail->cv_personal_email;
			$smarty->assign( 'cvformemail', $stremail );
		}
		// get cv summary
		$objSummaryFormDetail = $cv_summary_setting->getCVSummaryDetails($cv_setting->id);
		if($objSummaryFormDetail)
		{
			$strCVSummaryType = $objSummaryFormDetail->cv_summary_type;
			$smarty->assign( 'cvformsummarytype', $strCVSummaryType );
			
			$strCVSummaryEditModeId = $objSummaryFormDetail->cv_summary_id;
			$smarty->assign( 'cvformsummaryeditmodeid', $strCVSummaryEditModeId );
			
			if($strCVSummaryType == 'executive_summary')
			{
				$strCVExeSummary = $objSummaryFormDetail->cv_exe_summary;
				$smarty->assign( 'cvformsummarytxt', $strCVExeSummary );
			}
			else
			{
				$strCVQualSummary = $objSummaryFormDetail->cv_qualification_summary;
				$smarty->assign( 'cvformsummarytxt', $strCVQualSummary );
			}
		}
		// get cv competanciesget
		$objCompetanciesFormDetail = $cv_cpmpetancies_setting->getCVCompetanciesDetails($cv_setting->id);		
		if($objCompetanciesFormDetail)
		{
			//echo "HI";			
			/*print("<pre>");
			print_r($objCompetanciesFormDetail);
			exit;*/
			$smarty->assign('cvcompetanciesdata', $objCompetanciesFormDetail );
			
		}
		
		
		// get cv education
		$objEducationFormDetail = $cv_education_setting->getCVEducationDetails($cv_setting->id);
		if($objEducationFormDetail)
		{
			
			$smarty->assign('cveducationdata', $objEducationFormDetail );
			
		}
		
		// get cv experience
		$objExperienceFormDetail = $cv_eexperience_setting->getCVEExperienceDetails($cv_setting->id);
		if($objExperienceFormDetail)
		{
			
			
			$cv_eexperience_position_setting 	= new CVExperiencePositionsSetting();
			if(is_array($objExperienceFormDetail) && (count($objExperienceFormDetail)>0))
			{
				$intForCounter = 0;
				foreach($objExperienceFormDetail as $arrExp)
				{
					$objExperiencePositionFormDetail = $cv_eexperience_position_setting->getCVEExperienceDetails($arrExp['cv_experience_id']);
					if(is_array($objExperiencePositionFormDetail) && (count($objExperiencePositionFormDetail)>0))
					{
						$objExperienceFormDetail[$intForCounter]['exppositiondata'] = $objExperiencePositionFormDetail;
					}
					$intForCounter++;
				}
			}
			/*print("<pre>");
			print_r($objExperienceFormDetail);
			exit;*/
			$smarty->assign('cvexperiencedata', $objExperienceFormDetail );
		}
		
		// get cv projects / contracts
		$objContractsFormDetail = $cv_contratc_setting->getCVContractsDetails($cv_setting->id);
		if($objContractsFormDetail)
		{
			$smarty->assign('cvcontractdata', $objContractsFormDetail );
		}
		
		// get cv awards
		$objAwardsFormDetail = $cv_awards_setting->getCVAwardsDetails($cv_setting->id);
		if($objAwardsFormDetail)
		{
			$strAwardsId = $objAwardsFormDetail->cv_awards_id;
			$smarty->assign( 'cvformawardseditmodeid', $strAwardsId );
			
			$strAwardsText = $objAwardsFormDetail->cv_awards;
			$smarty->assign( 'cvformawards', $strAwardsText );
		}
		
		/*$_SESSION['resume']['exper'] 	= $exper 		= $cv_details->year_experience;
		$_SESSION['resume']['educ'] 	= $educ		= $cv_details->highest_education;
		$_SESSION['resume']['salary'] 	= $salary 	= trim($cv_details->salary_range);
		$_SESSION['resume']['availabe'] = $availabe 	= $cv_details->availability;
		$str_date 	= $cv_details->start_date;
		if( $cv_details->start_date != "0000-00-00 00:00:00" && $cv_details->start_date != NULL){
			$_SESSION['resume']['str_date_d'] =$str_date_d	= date("d",strtotime($str_date));
			$_SESSION['resume']['str_date_m'] =$str_date_m	= date("m",strtotime($str_date));
			$_SESSION['resume']['str_date_y'] =$str_date_y	= date("Y",strtotime($str_date));
			$smarty->assign( 'defult_date', $str_date_y."-".$str_date_m."-".$str_date_d );
		}
		$_SESSION['resume']['position'] = $position	= $cv_details->positions;
		//recent job details
		$_SESSION['resume']['rjt'] 		= $rjt 		= $cv_details->recent_job_title;
		$_SESSION['resume']['re'] 		= $re			= $cv_details->recent_employer;
		$_SESSION['resume']['riw'] 		= $riw		= $cv_details->recent_industry_work;
		$_SESSION['resume']['rcl'] 		= $rcl		= $cv_details->recent_career_level;
		
		//what are you looking for
		$_SESSION['resume']['ljt'] =$ljt		= $cv_details->look_job_title;
		$_SESSION['resume']['ljt2'] =$ljt2		= $cv_details->look_job_title2;
		
		$sql = " SELECT * FROM ".TBL_CV_CAT. " WHERE cv_id=".$id;
		$cv_cat = $db->query( $sql );
		$cv_cat_array = array();
		while ($row = $db->fetch_object( $cv_cat ) ) {
		  	$cv_cat_array[] = $row->category_id;
		}
		$_SESSION['resume']['cat'] = $cv_cat_array;
		$smarty->assign( 'category_selected', $cv_cat_array );
		
		
		$_SESSION['resume']['ljs'] =$ljs		= $cv_details->look_job_status;
		$_SESSION['resume']['job_type'] = $job_type = $cv_details->look_job_type;*/
		
		//where do you wont to work
		$_SESSION['loc']['citycode'] = $cv_details->city;
		$_SESSION['loc']['countycode'] = $cv_details->county;
		$_SESSION['loc']['stateprovince'] = $cv_details->state_province;
		$_SESSION['loc']['country'] = $cv_details->country;

	//location where he like to work in
	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = !empty( $default_county ) ? $default_county : "GB";
	
	$country 	= Country::find_all_order_by_name();
	if ( is_array($country) && !empty($country) ) {
		$country_t = array();
		$country_t['AA'] = 'All Countries';
		foreach( $country as $co ):
			if ($val['code'] != 'AA') {
				$country_t[ $co->code ] = $co->name;
			}
		endforeach; 
		$smarty->assign( 'country', $country_t );
	}
	
	$state = new StateProvince();
	$county 	= new County();
	$city = new City();
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'Y' );

	if (count($lang['states']) == 1) {
		foreach ($lang['states'] as $key => $val) {
			$_SESSION['loc']['stateprovince'] = $key;
		}
	} 

	//status 
	$_SESSION['loc']['stateprovince'] = ($_SESSION['loc']['stateprovince']!= '') ? $_SESSION['loc']['stateprovince'] : "";

	if ($_SESSION['loc']['stateprovince'] != '') {

	$lang['counties'] = $county->get_countyOptions( $countrycode, $_SESSION['loc']['stateprovince'], 'N' );

	if (count($lang['counties']) == 1) {
		foreach ($lang['counties'] as $key => $val) {
			$_SESSION['loc']['countycode'] = $key;
		}
	}
	//county
	$_SESSION['loc']['countycode'] = ($_SESSION['loc']['countycode']!= '') ? $_SESSION['loc']['countycode'] : "";

	if ( $_SESSION['loc']['countycode'] != '') {

	$lang['cities'] = $city->get_cityOptions($countrycode, $_SESSION['loc']['stateprovince'], $_SESSION['loc']['countycode'], 'N');
		
		if (count($lang['cities']) == 1) {
			foreach($lang['cities'] as $key => $val) {
				$_SESSION['loc']['citycode'] = $key;
			}
		}
		//city
		$_SESSION['loc']['citycode'] = ($_SESSION['loc']['citycode']!= '') ? $_SESSION['loc']['citycode'] : "" ;
	}
}


//end of location		
		
		/*$_SESSION['resume']['aya'] =$aya		= $cv_details->are_you_auth;
		$_SESSION['resume']['wtr'] =$wtr		= $cv_details->willing_to_relocate;
		$_SESSION['resume']['wtt'] =$wtt		= $cv_details->willing_to_travel;
		$_SESSION['resume']['notes'] =$notes		= $cv_details->additional_notes;*/
	}




$smarty->assign( 'authorised_to_work', format_lang("select","authorised_to_work") );
$smarty->assign( 'willing_to_travel', format_lang("select","willing_to_travel") );
$smarty->assign( 'salary', format_lang("select","salary") );
$smarty->assign( 'NoYes', format_lang('select', 'NoYes' ) );
$smarty->assign( 'month', format_lang("select","month") );
$smarty->assign( 'id', $id );
$smarty->assign( 'select_text', format_lang('select_text') );
	
$html_title 		= SITE_NAME . " - " .format_lang('page_title','cvfor').chr(10). $employee->full_name();
$smarty->assign( 'message', $message );	
$smarty->assign('lang', $lang);
$smarty->assign('rendered_page', $smarty->fetch('resume_change.tpl') );
?>