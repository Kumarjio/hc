<?php
	class SystemFields extends AppModel 
	{
		var $name = 'SystemFields';
		var $useTable = 'fields_table';
		/* var $validate = array(
								'user_name' => array(
													'alphaNumeric' => array(
																			'rule' => 'notEmpty',
																			'message' => 'Alphabets and numbers only',
																		   )
												   ),
								'user_email' => array("email"=>array(
																'rule' => 'email',
																"message"=>"Email Address Not Formatted"
															   )
												),
								'user_password' => array(
												 'rule' => array('minLength', '5'),
												 'message' => 'Password Should be mimimum 8 characters long',
											   ),
							 ); */
							 
		public function beforeSave($options = array())
		{
		}
		
		public function fnLoadFieldsOfCategory($intFieldCategoryId = "")
		{
			if($intFieldCategoryId)
			{
				$arrGetAllFieldsQuery = $this->query("SELECT fields_table.* FROM field_to_category,fields_table WHERE field_to_category.field_category_id='".$intFieldCategoryId."' AND fields_table.field_id=field_to_category.field_id");
				return $arrGetAllFieldsQuery;
				
				/* print("<pre>");
				print_r($arrGetAllFieldsQuery); */
				
				/* $arrGetAllFieldsQuery = $this->query("SELECT fields_table.* FROM fields_table,field_to_category,field_category WHERE field_category.field_category_id = '".$intFieldCategoryId."' AND fields_table.field_id = field_to_category.field_id AND field_category.field_category_id = field_to_category.field_to_category_id");
				return $arrGetAllFieldsQuery; */
			}
		}
	}
?>