    <?php
		class State extends AppModel 
		{
			var $name = 'State';
			var $useTable = 'state';
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
			
			public function fnCheckUserAccountExists($strEmail = "")
			{
				if($strEmail)
				{
					$arrReturnArray = $this->query("SELECT id FROM users WHERE email='".$strEmail."'");
					return count($arrReturnArray);
				}
				else
				{
					return false;
				}
			}
		}
    ?>
