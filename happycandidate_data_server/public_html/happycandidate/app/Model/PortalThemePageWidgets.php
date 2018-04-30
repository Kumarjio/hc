<?php
	class PortalThemePageWidgets extends AppModel 
	{
		public $name = 'PortalThemePageWidgets';
		public $useTable = 'career_portal_page_widgets';
		
		public function fnLoadPortalThemePageWidgetDetail($intPageId = "",$intPortalId = "")
		{
			if($intPageId && $intPortalId)
			{
				/* echo "--".$strQ = "SELECT PW.*,W.* FROM widgets W LEFT JOIN  career_portal_page_widgets PW ON W.widget_id = PW.widget_id AND PW.career_portal_page_id = '".$intPageId."' AND PW.career_portal_id = '".$intPortalId."' WHERE W.widget_active = '1' ORDER BY PW.widget_order ASC";
				exit; */
				$arrPortalThemeDetail = $this->query("SELECT PW.*,W.* FROM widgets W LEFT JOIN  career_portal_page_widgets PW ON W.widget_id = PW.widget_id AND PW.career_portal_page_id = '".$intPageId."' AND PW.career_portal_id = '".$intPortalId."' WHERE W.widget_active = '1' AND  W.widget_id = 3 ORDER BY PW.widget_order ASC");
			}
			else
			{
				//echo "--".$strQ = "SELECT PW.*,W.* FROM widgets W LEFT JOIN  career_portal_page_widgets PW ON W.widget_id = PW.widget_id WHERE W.widget_active = '1'  ORDER BY PW.widget_order ASC";
				//exit;
				$arrPortalThemeDetail = $this->query("SELECT PW.*,W.* FROM widgets W LEFT JOIN  career_portal_page_widgets PW ON W.widget_id = PW.widget_id WHERE W.widget_active = '1' AND  W.widget_id = 3 ORDER BY PW.widget_order ASC");
			}
			return $arrPortalThemeDetail;
		}
	}
?>