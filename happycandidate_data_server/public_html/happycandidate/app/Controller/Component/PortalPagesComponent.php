<?php
App::uses('Component', 'Controller');
class PortalPagesComponent extends Component 
{
    public $components = array('Session','Auth');
	 
	public function startup(Controller $controller) 
	{
		$this->Controller = $controller;
	}
	
	public function fnCreatePortalPages($arrNewPortalPage = array())
	{
		/* print("<pre>");
		print_r($arrNewPortalPage);
		exit; */
		
		$arrResponse = array();
		if(is_array($arrNewPortalPage) && (count($arrNewPortalPage)>0))
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$arrPageDetail = array();
			$modelPortalPages = ClassRegistry::init('PortalPages');
			
			$arrPageDetail['PortalPages']['career_portal_page_tittle'] = addslashes(trim($arrNewPortalPage['portal_page_title']));
			$arrPageDetail['PortalPages']['career_portal_page_content'] = htmlspecialchars($arrNewPortalPage['portal_page_content']);
			$arrPageDetail['PortalPages']['career_portal_id'] = addslashes(trim($arrNewPortalPage['portal_id']));
			$arrPageDetail['PortalPages']['career_portal_page_createdby'] =  $arrLoggedUserDetails['id'];
			
			$intPostedPortalId = addslashes(trim($arrNewPortalPage['portal_id']));
			
			/* print("<pre>");
			print_r($arrPageDetail);
			exit; */
			
			$intPortalPageExists = $modelPortalPages->find('count', array(
									'conditions' => array('career_portal_id' => $intPostedPortalId,'career_portal_page_tittle'=> $arrPageDetail['PortalPages']['career_portal_page_tittle'])
								));
			if($intPortalPageExists)
			{
				$arrResponse['status'] = 'failure';
				$arrResponse['message'] = 'This Page is already present';
				return $arrResponse;
			}
			else
			{
				$modelPortalPages->set($arrPageDetail);
				if($modelPortalPages->validates())
				{
					$boolPortalPageCreated = $modelPortalPages->save($arrPageDetail);
					if($boolPortalPageCreated)
					{
						$arrResponse['status'] = 'success';
						$arrResponse['message'] = 'Page created successfully';
						$arrResponse['redirect'] = "1";
						$arrResponse['redirecturl'] = Router::url(array('action'=>'index',$intPostedPortalId),true);
						return $arrResponse;
					}
				}
				else
				{
					$strPageCreationErrorMessage = "";
					$arrPageCreationErrors = $modelPortalPages->invalidFields();
					if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrPageCreationErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
					}
					$arrResponse['status'] = 'failure';
					$arrResponse['message'] = $strPageCreationErrorMessage;
					return $arrResponse;
				}
			}
		}
	}
	
	public function fnCreateDefaultPortalPages($intForPortalId = "")
	{
		$arrResponse = array();
		if($intForPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
			$arrPageDetail = array();
			
			$arrDefaultPortalPages = array();
			$arrDefaultPortalPages[0] = array(
	'career_portal_page_tittle'=>'Home',
	'career_portal_page_content'=>'<p>A powerful, effective and reliable platform of real world IT solutions, where imagination turns into tangible results and profits. Red Orange Technologies Pvt. Ltd, is a professionally managed firm, is engaged in rendering full fact of web and mobile application development services in India. With a unique fusion of experience, creativity and technology, the company has been providing innovative Online and Mobile solutions. The company believes in developing novel as well as engaging front-end and back-end development solutions that provide guaranteed return on investment to the clients.</p><p>&nbsp;</p><p>With a number of terms like trusted, leading, one stop solution and the list goes on, the company has been described by esteemed and satisfied clients. But the apt synonym for the firm is "responsible." Yes! The company is capable enough to take responsibilities of every single need of the clients pertaining to E commerce, Web Development, Software Development, SEO, Joomla, Mobile, iPhone, iPad, Android Applications Development, etc. Owing to an experienced team of designers, software developers, SEO experts and other allied workers, the company has been rendering fully integrated solutions, which are the combination of exceptional graphics, designing, dynamic programming as well as result oriented online marketing. The company adheres to the highest quality as well as ethical standards to maintain the integrity of the valued clients.</p>'
											 );
			$arrDefaultPortalPages[1] = array(
	'career_portal_page_tittle'=>'About Us',
	'career_portal_page_content'=>'<p>A powerful, effective and reliable platform of real world IT solutions, where imagination turns into tangible results and profits. Red Orange Technologies Pvt. Ltd, is a professionally managed firm, is engaged in rendering full fact of web and mobile application development services in India. With a unique fusion of experience, creativity and technology, the company has been providing innovative Online and Mobile solutions. The company believes in developing novel as well as engaging front-end and back-end development solutions that provide guaranteed return on investment to the clients.</p><p>&nbsp;</p><p>With a number of terms like trusted, leading, one stop solution and the list goes on, the company has been described by esteemed and satisfied clients. But the apt synonym for the firm is "responsible." Yes! The company is capable enough to take responsibilities of every single need of the clients pertaining to E commerce, Web Development, Software Development, SEO, Joomla, Mobile, iPhone, iPad, Android Applications Development, etc. Owing to an experienced team of designers, software developers, SEO experts and other allied workers, the company has been rendering fully integrated solutions, which are the combination of exceptional graphics, designing, dynamic programming as well as result oriented online marketing. The company adheres to the highest quality as well as ethical standards to maintain the integrity of the valued clients.</p>'
											 );
											 
			$arrDefaultPortalPages[2] = array(
	'career_portal_page_tittle'=>'Jobs',
	'career_portal_page_content'=>'<p align="justify">Here&rsquo;s an opportunity to collaborate with like-minded people in an environment that embraces individual differences and rewards your best work. Being the most prominent tech company, we hires the best possible people to support the brightest minds in the world. Expand your horizons by applying your background and expertise across different areas within ROT. In short, you&rsquo;ll be encouraged to reinvent yourself.</p>'
											 );
			
			$arrDefaultPortalPages[3] = array(
	'career_portal_page_tittle'=>'Contact Us',
	'career_portal_page_content'=>'<p align="justify">Emerged with the Vision of providing better options to customers worldwide who are looking for dedicated people to devote there best in what they do was the reason behind existence of Red Orange Technologies.Founded By Mr Sachin Tiple in Year 2009 and Nourished By Mr Prakash Kattoli and Mr Amit Sharma, Joining hands to contribute there expertise in the area, we can see this vision coming through very well in where we stand today.</p>'
											 );
											 
											 
			$modelPortalPages = ClassRegistry::init('PortalPages');			
			if(is_array($arrDefaultPortalPages) && (count($arrDefaultPortalPages)>0))
			{
				$intDefaultPageCount = 0;
				foreach($arrDefaultPortalPages as $arrPages)
				{
					
					$arrPageDetail['PortalPages']['career_portal_page_tittle'] = addslashes(trim($arrPages['career_portal_page_tittle']));
					$arrPageDetail['PortalPages']['career_portal_page_content'] = htmlspecialchars($arrPages['career_portal_page_content']);
					$arrPageDetail['PortalPages']['career_portal_id'] = $intForPortalId;
					$arrPageDetail['PortalPages']['career_portal_page_createdby'] =  $arrLoggedUserDetails['id'];
					$intPostedPortalId = $intForPortalId;
					
					$intPortalPageExists = $modelPortalPages->find('count', array(
								'conditions' => array('career_portal_id' => $intPostedPortalId,'career_portal_page_tittle'=> $arrPageDetail['PortalPages']['career_portal_page_tittle'])
							));
					if($intPortalPageExists)
					{
						$arrResponse[$intDefaultPageCount]['status'] = 'failure';
						$arrResponse[$intDefaultPageCount]['message'] = 'This Page is already present';
					}
					else
					{
						$modelPortalPages->set($arrPageDetail);
						if($modelPortalPages->validates())
						{
							$boolPortalPageCreated = $modelPortalPages->save($arrPageDetail);
							
							if($boolPortalPageCreated)
							{
								$arrResponse[$intDefaultPageCount]['status'] = 'success';
								$arrResponse[$intDefaultPageCount]['message'] = 'Page created successfully';
								$arrResponse[$intDefaultPageCount]['redirect'] = "1";
								$arrResponse[$intDefaultPageCount]['redirecturl'] = Router::url(array('action'=>'index',$intPostedPortalId),true);
							}
						}
						else
						{
							$strPageCreationErrorMessage = "";
							$arrPageCreationErrors = $modelPortalPages->invalidFields();
							if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
							{
								$intForIterateCount = 0;
								foreach($arrPageCreationErrors as $errorVal)
								{
									$intForIterateCount++;
									if($intForIterateCount == 1)
									{
										$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
									}
									else
									{
										$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
									}
								}
							}
							$arrResponse[$intDefaultPageCount]['status'] = 'failure';
							$arrResponse[$intDefaultPageCount]['message'] = $strPageCreationErrorMessage;
						}
					}
					$intDefaultPageCount++;
				}
			}
		}
		else
		{
			$arrResponse['status'] = 'failure';
			$arrResponse['message'] = 'Bad Request';
		}
		return $arrResponse;
	}
	
	public function fnCreateDefaultPortalPagesMenus($intForPortalId = "")
	{
		$arrResponse = array();
		if($intForPortalId)
		{
			$arrLoggedUserDetails = $this->Auth->user();
                        
			$arrPageDetail = array();
			
			$arrDefaultPortalPages = array();
			$arrDefaultPortalPages[0] = array(
                        'career_portal_page_tittle'=>'Home',
                        'career_portal_page_content'=>'<p>A powerful, effective and reliable platform of real world IT solutions, where imagination turns into tangible results and profits. Red Orange Technologies Pvt. Ltd, is a professionally managed firm, is engaged in rendering full fact of web and mobile application development services in India. With a unique fusion of experience, creativity and technology, the company has been providing innovative Online and Mobile solutions. The company believes in developing novel as well as engaging front-end and back-end development solutions that provide guaranteed return on investment to the clients.</p><p>&nbsp;</p><p>With a number of terms like trusted, leading, one stop solution and the list goes on, the company has been described by esteemed and satisfied clients. But the apt synonym for the firm is "responsible." Yes! The company is capable enough to take responsibilities of every single need of the clients pertaining to E commerce, Web Development, Software Development, SEO, Joomla, Mobile, iPhone, iPad, Android Applications Development, etc. Owing to an experienced team of designers, software developers, SEO experts and other allied workers, the company has been rendering fully integrated solutions, which are the combination of exceptional graphics, designing, dynamic programming as well as result oriented online marketing. The company adheres to the highest quality as well as ethical standards to maintain the integrity of the valued clients.</p>',
                        'is_career_portal_home_page'=>'1'
			);
			$arrDefaultPortalPages[1] = array(
                        'career_portal_page_tittle'=>'About Us',
                        'career_portal_page_content'=>'<p>A powerful, effective and reliable platform of real world IT solutions, where imagination turns into tangible results and profits. Red Orange Technologies Pvt. Ltd, is a professionally managed firm, is engaged in rendering full fact of web and mobile application development services in India. With a unique fusion of experience, creativity and technology, the company has been providing innovative Online and Mobile solutions. The company believes in developing novel as well as engaging front-end and back-end development solutions that provide guaranteed return on investment to the clients.</p><p>&nbsp;</p><p>With a number of terms like trusted, leading, one stop solution and the list goes on, the company has been described by esteemed and satisfied clients. But the apt synonym for the firm is "responsible." Yes! The company is capable enough to take responsibilities of every single need of the clients pertaining to E commerce, Web Development, Software Development, SEO, Joomla, Mobile, iPhone, iPad, Android Applications Development, etc. Owing to an experienced team of designers, software developers, SEO experts and other allied workers, the company has been rendering fully integrated solutions, which are the combination of exceptional graphics, designing, dynamic programming as well as result oriented online marketing. The company adheres to the highest quality as well as ethical standards to maintain the integrity of the valued clients.</p>',
                        'is_career_portal_home_page'=>'0'
			);
											 
	
			
			$arrDefaultPortalPages[3] = array(
                        'career_portal_page_tittle'=>'Contact Us',
                        'career_portal_page_content'=>'<p align="justify">Emerged with the Vision of providing better options to customers worldwide who are looking for dedicated people to devote there best in what they do was the reason behind existence of Red Orange Technologies.Founded By Mr Sachin Tiple in Year 2009 and Nourished By Mr Prakash Kattoli and Mr Amit Sharma, Joining hands to contribute there expertise in the area, we can see this vision coming through very well in where we stand today.</p>',
                        'is_career_portal_home_page'=>'0'
			);
											 
											 
			$modelPortalPages = ClassRegistry::init('PortalPages');			
			if(is_array($arrDefaultPortalPages) && (count($arrDefaultPortalPages)>0))
			{
				$intDefaultPageCount = 0;
				foreach($arrDefaultPortalPages as $arrPages)
				{
					
					$arrPageDetail['PortalPages']['career_portal_page_tittle'] = addslashes(trim($arrPages['career_portal_page_tittle']));
					$arrPageDetail['PortalPages']['career_portal_page_content'] = htmlspecialchars($arrPages['career_portal_page_content']);
					$arrPageDetail['PortalPages']['career_portal_id'] = $intForPortalId;
					$arrPageDetail['PortalPages']['is_career_portal_home_page'] =  $arrPages['is_career_portal_home_page'];
					$arrPageDetail['PortalPages']['career_portal_page_createdby'] =  $arrLoggedUserDetails['id'];
					$intPostedPortalId = $intForPortalId;
					
					$intPortalPageExists = $modelPortalPages->find('count', array(
								'conditions' => array('career_portal_id' => $intPostedPortalId,'career_portal_page_tittle'=> $arrPageDetail['PortalPages']['career_portal_page_tittle'])
							));
					if($intPortalPageExists)
					{
						$arrResponse[$intDefaultPageCount]['status'] = 'failure';
						$arrResponse[$intDefaultPageCount]['message'] = 'This Page is already present';
					}
					else
					{
						$modelPortalPages->set($arrPageDetail);
						if($modelPortalPages->validates())
						{
							$arrPortalPageCreated = $modelPortalPages->fnSavePortalPages($arrPageDetail);							
							if(is_array($arrPortalPageCreated) && (count($arrPortalPageCreated)>0))
							{
								$intPageId = $arrPortalPageCreated['PortalPages']['career_portal_page_id'];
								$arrPortalMenus = array();
								$modelPortalMenus = ClassRegistry::init('TopMenu');
			
								$arrPortalMenus['TopMenu']['career_portal_menu_page_id'] = $intPageId;
								$arrPortalMenus['TopMenu']['career_portal_id'] = $intForPortalId;
								$arrPortalMenus['TopMenu']['career_portal_menu_name'] = $arrPageDetail['PortalPages']['career_portal_page_tittle'];
								$strMenuUrl = Router::url(array('controller' => 'employers','action' => 'viewpage',base64_encode($intPageId."_".$intForPortalId)),true);
                                                                $arrPortalMenus['TopMenu']['career_portal_menu_link'] = base64_encode($strMenuUrl);
								$arrPortalMenus['TopMenu']['career_portal_menu_createdby'] = $arrLoggedUserDetails['id'];
								
								$arrPortalMenus['TopMenu']['career_portal_menu_order'] = ($intDefaultPageCount+1);
								
								$intPortalTopMenuExists = $modelPortalMenus->find('count', array(
									'conditions' => array('career_portal_id' => $intForPortalId,'career_portal_menu_page_id'=> $intPageId,'career_portal_menu_name'=>$arrPageDetail['PortalPages']['career_portal_page_tittle'])
								));
								if(!$intPortalTopMenuExists)
								{
									$modelPortalMenus->set($arrPortalMenus);
									$boolPortalMenuCreated = $modelPortalMenus->fnSavePortalMenus($arrPortalMenus);
								}
								
								$arrResponse[$intDefaultPageCount]['status'] = 'success';
								$arrResponse[$intDefaultPageCount]['message'] = 'Page created successfully';
								$arrResponse[$intDefaultPageCount]['redirect'] = "1";
								$arrResponse[$intDefaultPageCount]['redirecturl'] = Router::url(array('action'=>'index',$intPostedPortalId),true);
							}
						}
						else
						{
							$strPageCreationErrorMessage = "";
							$arrPageCreationErrors = $modelPortalPages->invalidFields();
							if(is_array($arrPageCreationErrors) && (count($arrPageCreationErrors)>0))
							{
								$intForIterateCount = 0;
								foreach($arrPageCreationErrors as $errorVal)
								{
									$intForIterateCount++;
									if($intForIterateCount == 1)
									{
										$strPageCreationErrorMessage .= "Error: ".$errorVal['0'];
									}
									else
									{
										$strPageCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
									}
								}
							}
							$arrResponse[$intDefaultPageCount]['status'] = 'failure';
							$arrResponse[$intDefaultPageCount]['message'] = $strPageCreationErrorMessage;
						}
					}
					$intDefaultPageCount++;
				}
			}
		}
		else
		{
			$arrResponse['status'] = 'failure';
			$arrResponse['message'] = 'Bad Request';
		}
		return $arrResponse;
	}
}
?>