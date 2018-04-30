<?php
	class ContentMedia extends AppModel 
	{
		public $name = 'ContentMedia';
		public $useTable = 'content_media';
		
		public $validate = array(
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
												)
							 );
							 
							 
		public function fnFormatArray($arrToFormat = array(), $arrTobeFormattedFrom = array())
		{
			if(is_array($arrTobeFormattedFrom) && (count($arrTobeFormattedFrom)>0))
			{
				foreach($arrTobeFormattedFrom as $key=>$val)
				{
					$arrToFormat[0][$key] = $val;
				}
				
				return $arrToFormat;
			}
			else
			{
				return false;
			}
		
		}
							 
		public function fnGetContents()
		{
			$arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Content'");
			return $arrContentArray;
		}
		
		public function fnGetPages()
		{
			$arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Pages'");
			return $arrContentArray;
		}
	}
?>