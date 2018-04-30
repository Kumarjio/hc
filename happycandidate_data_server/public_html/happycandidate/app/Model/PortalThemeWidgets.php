<?php
	class PortalThemeWidgets extends AppModel 
	{
		public $name = 'PortalThemeWidgets';
		public $useTable = 'career_portal_theme_widgets';
		
		public function fnLoadPortalThemeWidgetDetail($intThemeId = "",$intPortalId = "")
		{
			if($intThemeId && $intPortalId)
			{
				//echo "--".$strQ = "SELECT PW.*,W.* FROM widgets W LEFT JOIN career_portal_theme_widgets PW ON W.widget_id = PW.widget_id AND PW.career_portal_theme_id = '".$intThemeId."' AND PW.career_portal_id = '".$intPortalId."' WHERE W.widget_active = '1' ORDER BY PW.widget_order ASC";
				//exit;
				$arrPortalThemeDetail = $this->query("SELECT PW.*,W.* FROM widgets W LEFT JOIN career_portal_theme_widgets PW ON W.widget_id = PW.widget_id AND PW.career_portal_theme_id = '".$intThemeId."' AND PW.career_portal_id = '".$intPortalId."' WHERE W.widget_active = '1' ORDER BY PW.widget_order ASC");
			}
			else
			{
				//echo "--".$strQ = "SELECT career_portal_theme_widgets.*,widgets.* FROM career_portal_theme_widgets LEFT JOIN widgets ON career_portal_theme_widgets.widget_id = widgets.widget_id";
				//exit;
				$arrPortalThemeDetail = $this->query("SELECT PW.*,W.* FROM widgets W LEFT JOIN career_portal_theme_widgets PW ON W.widget_id = PW.widget_id WHERE W.widget_active = '1' ORDER BY PW.widget_order ASC");
			}
			return $arrPortalThemeDetail;
		}
	}
?>