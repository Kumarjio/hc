<?php
	class TopMenu extends AppModel 
	{
		public $name = 'TopMenu';
		public $useTable = 'career_portal_top_menu';
		
		public $validate = array(
								'career_portal_menu_page_id' => array(
													'Required' => array(
																			'rule' => 'notEmpty',
																			'message' => 'You have not Selected Page',
																		)
												  )
							 );
							 
		public function beforeSave($options = array()) {
			/* if (isset($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}
			return true; */
		}
		
		public function fnSavePortalMenus($arrPortalMenu = array())
		{
			$strQuery = "INSERT INTO career_portal_top_menu SET 
					   career_portal_menu_page_id = '".$arrPortalMenu['TopMenu']['career_portal_menu_page_id']."',
					   career_portal_id = '".$arrPortalMenu['TopMenu']['career_portal_id']."',
					   career_portal_menu_name = '".$arrPortalMenu['TopMenu']['career_portal_menu_name']."',
					   career_portal_menu_order = '".$arrPortalMenu['TopMenu']['career_portal_menu_order']."'";
					   
			$arrPortalMenuInsert = $this->query($strQuery);
			   
			 return $arrPortalMenuInsert;
		}
		
		
	}
?>