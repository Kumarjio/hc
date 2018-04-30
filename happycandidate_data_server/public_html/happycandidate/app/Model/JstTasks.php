<?php
	class JstTasks extends AppModel 
	{
		public $name = 'JstTasks';
		public $useTable = 'jsttasks';
		
		/*public $validate = array(
								'user_name' => array(
													'alphaNumeric' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Alphabets and numbers only',
																		   )
												   ),
								'userpass' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please enter your password'
													),
													'min length' => array(
																				'rule' => array('minLength', '5'),
																				'message' => 'Password Should be minimum 8 characters long'
													)
													/* 'Match Password' => array(
																				'rule' => 'matchPasswords',
																				'message'=>'Your passwords do not match'
													) */
												/*)
							 );*/
		
		
		public function fnGetCatContentParentData($intProductId,$intCatuser)
		{
			if($intProductId)
			{
				$strProductListQuery = "SELECT content_category.content_category_id,content_category.content_category_parent_id FROM content_category WHERE content_category.content_category_id='".$intProductId."' AND content_cat_for_user='".$intCatuser."'";
				//echo $strProductListQuery;exit;
				$arrProductContentArray = $this->query($strProductListQuery);
				return $arrProductContentArray;
			}
		}
	}
?>