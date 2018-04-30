<?php
	class CategoriesAssignment extends AppModel 
	{
		public $name = 'CategoriesAssignment';
		public $useTable = 'content_category_assignment';
		
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
							 
		public function fnGetCatAssignedProducts($intCatId="")
		{
			if($intCatId)
			{
				$strQuery = "SELECT Content.content_id,Content.content_title,Content.content_name,Content.content_intro_text,content_category.content_category_id,content_category.content_category_name FROM content AS Content,content_category_assignment,content_category WHERE content_category_assignment.content_id = Content.content_id AND content_category_assignment.category_id = '".$intCatId."' AND content_category_assignment.category_id = content_category.content_category_id ORDER BY Content.content_title";
				$arrContentArray = $this->query($strQuery);
				return $arrContentArray;
			}
		}
	}
?>