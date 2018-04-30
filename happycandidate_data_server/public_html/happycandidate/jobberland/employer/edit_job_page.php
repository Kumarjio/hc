<?php  $page = return_url();
	$action = $page[1];
	$job_id = $id = $page[2];
	$_SESSION['direct_to_emp'] = "edit/".$job_id."/";
	include_once('sessioninc.php');
	 
	if( empty($id) && !isset($id) || $id == '' ) {redirect_to(BASE_URL . 'employer/myjobs/');}
	
	$user_id = $session->get_user_id();
	$employer = Employer::find_by_id( $user_id );
	
	$jobs = new Job;
	
	$jobs->fk_employer_id=(int)$user_id;
	$job->fk_hc_employer_id=$_SESSION['hcuid'];
	$job->fk_hc_portal_id=$_SESSION['portal_id'];
	
	$jobs->id = $id;

	$job = $jobs->find_by_employer();
	$old_var_name = $job->var_name;
	
	if( !$job ) {redirect_to(BASE_URL . 'employer/myjobs/');}
	
#######################/** list of information */ #################

	$job_types	= JobType::find_all();
	$job_status = JobStatus::find_all();
	
	$jobcategory = new JobCategory;
	######## GET CAT ID ###############
	$jobcategory->job_id = (int)$job_id;
	$cats = $jobcategory->get_cat_by_job_id();	
	$cat_id=array();
	foreach( $cats as $t ){
		$cat_id[]=$t->category_id;
	}
	$smarty->assign( 'category_selected', $cat_id );
	################# JOB TYPE ##################
	$job_type_ns = Job2Type::find_all_type_by_jobid( $job_id );
		$job_type_id=array();
		foreach( $job_type_ns as $job_type ):
			$job_type_id[]=$job_type->fk_job_type_id;
		endforeach;
		$smarty->assign( 'type_selected', $job_type_id );
	########## job_statu_id #######################
	$job_statu_id=array();
	$job_statu_ns = Job2Status::find_by_job_id($job_id);
		foreach( $job_statu_ns as $job_statuss ):
			$job_statu_id[]= $job_statuss->fk_job_status_id;
		endforeach;		
		$smarty->assign( 'status_selected', $job_statu_id );
########################################################

	$job_types	= JobType::find_all();
	if ( is_array($job_types) and !empty($job_types) ) {
		$job_t = array();
		foreach( $job_types as $job_type ):
			$job_t[ $job_type->id ] = $job_type->type_name;
		endforeach; 
		$smarty->assign( 'job_type', $job_t );
	}
	
	$job_status = JobStatus::find_all();
	if ( is_array($job_status) and !empty($job_status) ) {
		$statu_t = array();
		foreach( $job_status as $job_statu ):
			$statu_t[ $job_statu->id ] = $job_statu->status_name;
		endforeach; 
		$smarty->assign( 'job_status', $statu_t );
	}

//list of jobs
		
		$_SESSION['add_job']['job_ref'] 	=  $job->job_ref;
		//$job->var_name 			= $job->mod_write_check ( $_POST['txt_job_title'] );
		$_SESSION['add_job']['job_title'] 	= $job_title = $job->job_title;
		
		$_SESSION['add_job']['job_desc'] 	= $job->job_description;
		$_SESSION['add_job']['job_req'] 	= $job->job_requirenment;
		$_SESSION['add_job']['job_postion'] = $job->job_postion;

		$_SESSION['add_job']['salary'] 		= $job->job_salary;
		$salaryfreq = get_lang('select', 'salaryfreq');
		$smarty->assign( 'salaryfreq', $salaryfreq );
		$_SESSION['add_job']['freq'] 		= $job->salaryfreq;

		$smarty->assign( 'career_selected', $job->fk_career_id );
		$smarty->assign( 'education_selected', $job->fk_education_id );
		$smarty->assign( 'experience_selected', $job->fk_experience_id );


		$_SESSION['add_job']['cname'] 		= $job->contact_name;
		$_SESSION['add_job']['compname'] 	= $job->company_name;
		$_SESSION['add_job']['tn'] 			= $job->contact_telephone;
		$_SESSION['add_job']['sl'] 			= $job->site_link;
		$_SESSION['add_job']['email'] 		= $job->poster_email;
		$_SESSION['add_job']['jsd'] 		= $job->start_date;

		$_SESSION['loc']['pcode']			= $job->post_code;
		$_SESSION['loc']['citycode']		= $job->city;
		$_SESSION['loc']['countycode'] 		= $job->county;
		$_SESSION['loc']['stateprovince']	= $job->state_province;
		$_SESSION['loc']['country'] 		= $job->country;

////location

	$default_county = empty($_SESSION['loc']['country']) ? DEFAULT_COUNTRY : $_SESSION['loc']['country'];
	$_SESSION['loc']['country'] = $countrycode = $default_county = $default_county;
	$smarty->assign( 'countrycode', $countrycode );
	
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
	
	$lang['states'] = $state->get_stateOptions( $countrycode, 'N' );
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
	
	$educations	= Education::find_all();
	if ( is_array($educations) and !empty($educations) ) {
		$education_t = array();
		foreach( $educations as $education ):
			$education_t[ $education->id ] = $education->education_name;
		endforeach; 
		$smarty->assign( 'education', $education_t );
	}
	
	$careers	= CareerDegree::find_all();
	if ( is_array($careers) and !empty($careers) ) {
		$career_t = array();
		foreach( $careers as $career ):
			$career_t[ $career->id ] = $career->career_name;
		endforeach; 
		$smarty->assign( 'career', $career_t );		
	}
	
	$experiences = Experience::find_all();
	if ( is_array($experiences) and !empty($experiences) ) {
		$experience_t = array();
		foreach( $experiences as $experience ):
			$experience_t[ $experience->id ] = $experience->experience_name;
		endforeach; 
		$smarty->assign( 'experience', $experience_t );

	}
	
	$categories	= Category::find_all();
	if ( is_array($categories) and !empty($categories) ) {
		$category_t = array();
		foreach( $categories as $category ):
			$category_t[ $category->id ] = $category->cat_name;
		endforeach; 
		$smarty->assign( 'category', $category_t );
	}
	
	///when button is press run this 
	if ( isset($_POST['bt_add']) ){
		
		$_SESSION['add_job']['job_ref'] 	=  $job->job_ref 	= $_POST['txt_ref_code'];
		$job->var_name 			= $job->mod_write_check ( $_POST['txt_job_title'], $old_var_name );
		
		$_SESSION['add_job']['job_title'] 	= $job->job_title 		= strip_html( stripHTMLTags($_POST['txt_job_title']) );
		$_SESSION['add_job']['job_desc'] 	= $job->job_description = allowedTags($_POST['txt_job_desc']);
		$_SESSION['add_job']['job_req'] 	= $job->job_requirenment = allowedTags($_POST['txt_job_req']);
		$_SESSION['add_job']['job_postion'] = $job->job_postion 	= $_POST['txt_position'];

		$_SESSION['add_job']['salary'] 		= $job->job_salary		= $_POST['txt_salary'];
		$_SESSION['add_job']['freq'] 		= $job->salaryfreq 		= $_POST['txt_salaryfreq'];

		$_SESSION['add_job']['cname'] 		= $job->contact_name 		= $_POST['txt_contact_name'];
		$_SESSION['add_job']['compname'] 	= $job->company_name 		= $_POST['txt_cname'];
		$_SESSION['add_job']['tn'] 			= $job->contact_telephone = $_POST['txt_telephone'];
		$_SESSION['add_job']['sl'] 			= $job->site_link 		= $_POST['txt_site_link'];
		$_SESSION['add_job']['email'] 		= $job->poster_email 		= $_POST['txt_email'];
		$_SESSION['add_job']['jsd'] 		= $job->start_date 		= $_POST['txt_start_date'];
	
		
		if ( is_array($_POST['txt_job_type']) && !empty($_POST['txt_job_type']) ) {
			$type_selected =array();
			foreach ( $_POST['txt_job_type'] as $key => $value ):
				$type_selected[] = $value;
			endforeach;
		}
		$job->job_type=sizeof($_POST['txt_job_type']);
		$smarty->assign( 'type_selected', $type_selected );

		if ( is_array($_POST['txt_job_status']) && !empty($_POST['txt_job_status']) ) {
			$selected =array();
			foreach ( $_POST['txt_job_status'] as $key => $value ):
				$_SESSION['add_job']['job_status'] = $selected[] = $value;
			endforeach;
		}
		$job->j_status=sizeof($_POST['txt_job_status']);
		$smarty->assign( 'status_selected', $selected );
		
		$job->fk_education_id='none';
		if ( is_array($_POST['txt_education']) && !empty($_POST['txt_education']) ) {
			$education_selected =array();
			foreach ( $_POST['txt_education'] as $key => $value ):
				$education_selected[] = $value;
				$job->fk_education_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'education_selected', $education_selected );
		
		$job->fk_career_id='none';
		if ( is_array($_POST['txt_career']) && !empty($_POST['txt_career']) ) {
			$career_selected =array();
			foreach ( $_POST['txt_career'] as $key => $value ):
				$career_selected[] = $value;
				$job->fk_career_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'career_selected', $career_selected );

		$job->fk_experience_id='none';
		if ( is_array($_POST['txt_experience']) && !empty($_POST['txt_experience']) ) {
			$experience_selected =array();
			foreach ( $_POST['txt_experience'] as $key => $value ):
				$experience_selected[] = $value;
			    $job->fk_experience_id 	= (int)$value;
			endforeach;
		}
		$smarty->assign( 'experience_selected', $experience_selected );


###############localtion

		$_SESSION['loc']['pcode']	= $job->post_code 			= $_POST['txt_pcode'];
		$_SESSION['loc']['citycode']	= $job->city 			= $_POST['localityval'];
		$_SESSION['loc']['countycode'] 	= $job->county 		= $_POST['txtcounty'];
		$_SESSION['loc']['stateprovince']= $job->state_province = $_POST['txtstateprovince'];
		$_SESSION['loc']['country'] 	= $job->country 		= $_POST['txt_country'];
		
		if ( is_array($_POST['txt_category']) && !empty($_POST['txt_category']) ) {
			$category_selected =array();
			foreach ( $_POST['txt_category'] as $key => $value ):
				$category_selected[] = $value;
			endforeach;
		}
		
		$job->category 	= (int)sizeof($_POST['txt_category']);
		$smarty->assign( 'category_selected', $category_selected );	
		
		////save data 
		if( $job->save() ){
			/** deleteing job types from job types table */
			$job_t = new Job2Type();
			$job_t->fk_job_id = $job_id;
			$job_t->delete_all_on_update();
			
			//add new job type
			if ( is_array($_POST['txt_job_type']) && !empty($_POST['txt_job_type']) ) {
				foreach ( $_POST['txt_job_type'] as $key => $value ):
					$type_added = new Job2Type;
					$type_added->fk_job_id 		= (int)$job_id;
					$type_added->fk_job_type_id = (int)$value;
					//$type_added = Job2Type::make(  $job_id, $value );
					$type_added->save();
				endforeach;
			}
			
			/** deleting job status **/
			$job_s = new Job2Status();
			$job_s->fk_job_id = $job_id;
			$job_s->delete_all_on_update();
			
			if ( is_array($_POST['txt_job_status']) && !empty($_POST['txt_job_status']) ) {
				foreach ( $_POST['txt_job_status'] as $key => $value ):
					$status_added = Job2Status::make(  $job_id, $value );
					$status_added->save();
				endforeach;
			}
			
			/** deleting job status **/
			$job_c = new JobCategory();
			$job_c->job_id = $job_id;
			$job_c->delete_all_on_update();
			
			/**adding cat */
			foreach ( $_POST['txt_category'] as $key => $value ):
				$cat_added = JobCategory::make( $value, $job_id );
				$cat_added->save();
			endforeach;
			
			
			if($status_added && $cat_added && $type_added )
			{
				if ( FREE_SITE == "N" ){	
					if( $spotlight == "spotlight" ) {
						$employer->update_spotlight_job_post();
					}else{
						$employer->update_job_post();
					}
				}
			
				unset($_SESSION['add_job']);
				$message ="<div class='success'>".format_lang('success','updateJob')."</div>";
				destroy_my_session();
			}else{
				$message = "<div class='error'>".format_lang('error','updateJob')."</div>";
			}
			$session->message ($message);
		}
		else
		{
			$message = "<div class='error'> 
							".format_lang('following_errors')."
						<ul> <li />";
			$message .= join(" <li /> ", $job->errors);
			$message .= " </ul> 
						</div>";
		}
	$session->message ($message);
	redirect_to ( BASE_URL. "employer/editjob/".$job_id );
}
//end of button
	
	$html_title 		= SITE_NAME . " - ".format_lang('page_title','editJob').chr(10).$job_title;
	
	$smarty->assign('lang', $lang);
	$smarty->assign( 'message', $message );
	$smarty->assign('rendered_page', $smarty->fetch('employer/editjob.tpl') );
?>