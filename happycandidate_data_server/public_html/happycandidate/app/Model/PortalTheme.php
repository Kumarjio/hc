<?php

class PortalTheme extends AppModel {
    public $name = 'PortalTheme';
    public $useTable = 'career_portal_theme';

    public function fnLoadPortalThemeDetail($intPortalId = "") {
        if ($intPortalId) {
            $arrPortalThemeDetail = $this->query("SELECT theme.*,career_portal_theme.* FROM career_portal_theme, theme WHERE theme.theme_id = career_portal_theme.career_portal_theme_id AND career_portal_theme.career_portal_id = '" . $intPortalId . "' AND career_portal_theme.career_portal_theme_active = '1'");
            return $arrPortalThemeDetail;
        } else {
            return false;
        }
    }
    
    public function fnGetPortalThemeDetail($intPortalId = "") {
        if ($intPortalId) {
            $arrPortalThemeDetail = $this->query("SELECT wizard_theme.theme_name,career_portal_theme.career_portal_theme_id FROM career_portal_theme, wizard_theme WHERE wizard_theme.theme_id = career_portal_theme.career_portal_theme_id AND career_portal_theme.career_portal_id = '" . $intPortalId . "' AND career_portal_theme.career_portal_theme_active = '1'");
//            $arrPortalThemeDetail = $this->query("SELECT theme.*,career_portal_theme.* FROM career_portal_theme, theme WHERE theme.theme_id = career_portal_theme.career_portal_theme_id AND career_portal_theme.career_portal_id = '" . $intPortalId . "' AND career_portal_theme.career_portal_theme_active = '1'");
            return $arrPortalThemeDetail;
        } else {
            return false;
        }
    }
}
?>