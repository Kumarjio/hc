<?php
	class PortalPages extends AppModel 
	{
		public $name = 'PortalPages';
		public $useTable = 'career_portal_pages';
		
		public $validate = array(
								'career_portal_page_tittle' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not provided Page Title',
																		)
													/* 'Alphanumeric' => array(
																			'rule' => 'alphaNumeric',
																			'message' => 'Portal name cannot contain Alphanumeric Characters',
																			   ) */
												   ),
								'career_portal_page_content' => array(
													'Not Empty'	=>	array(
																			'rule' => 'notEmpty',
																			"message"=>"You have not provided Page Content"
																		)
													/* 'Extension'	=>	array(
																			'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
																			"message"=>"Provided Logo is not valid, Please provide valid image file"
																		) */
												)
							 );
		
		public function fnSavePortalPages($arrPageDetail = array())
		{
			/* print("<pre>");
			print_r($arrPageDetail);
			exit; */
			$strQuery = "INSERT INTO career_portal_pages(career_portal_page_tittle,career_portal_page_content,career_portal_id,is_career_portal_home_page,career_portal_page_createdby)VALUES('".$arrPageDetail['PortalPages']['career_portal_page_tittle']."','".$arrPageDetail['PortalPages']['career_portal_page_content']."','".$arrPageDetail['PortalPages']['career_portal_id']."','".$arrPageDetail['PortalPages']['is_career_portal_home_page']."','".$arrPageDetail['PortalPages']['career_portal_page_createdby']."')";
			$arrPortalInsert = $this->query($strQuery);
			
			$arrLastInsertedRecord = $this->find('first',array('conditions'=>array('career_portal_page_tittle'=>$arrPageDetail['PortalPages']['career_portal_page_tittle'],'career_portal_id'=>$arrPageDetail['PortalPages']['career_portal_id'])));
			if(is_array($arrLastInsertedRecord) && (count($arrLastInsertedRecord)>0))
			{
				return $arrLastInsertedRecord;
			}
			else
			{
				return false;
			}			
		}
	}
?>