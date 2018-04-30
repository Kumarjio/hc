<?php
	class Categories extends AppModel 
	{
		public $name = 'Categories';
		public $useTable = 'content_category';
		
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
				$strProductListQuery = "SELECT content_category.content_category_id,content_category.content_category_parent_id FROM content_category WHERE content_category.category_type='0' content_category.content_category_id='".$intProductId."' AND content_cat_for_user='".$intCatuser."'";
				//echo $strProductListQuery;exit;
				$arrProductContentArray = $this->query($strProductListQuery);
				return $arrProductContentArray;
			}
		}
                
		public function fnGetProductCat()
		{
                    $strProductListQuery = "SELECT content_category.content_category_id,content_category.content_category_name FROM content_category WHERE content_category.category_type='1' order by content_category.category_order ASC  LIMIT 5";
                    //echo $strProductListQuery;exit;
                    $arrProductContentArray = $this->query($strProductListQuery);
                    return $arrProductContentArray;
		}
                
		public function fnGetProductAllCat()
		{
                    $strProductListQuery = "SELECT Categories.content_category_id,Categories.content_category_name FROM content_category AS Categories WHERE Categories.category_type='1'";
                    //echo $strProductListQuery;exit;
                    $arrProductContentArray = $this->query($strProductListQuery);
                    return $arrProductContentArray;
		}
                
		public function fnGetProductwiseCat($category_id)
		{
                    $strProductListQuery = "SELECT * FROM products WHERE category_id='".$category_id."'";
                    $arrProductContentArray = $this->query($strProductListQuery);
                    return $arrProductContentArray;
		}
	}
?>