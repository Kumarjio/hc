<?php /* Smarty version 2.6.26, created on 2016-01-12 16:12:04
         compiled from cv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'cv.tpl', 12, false),array('modifier', 'upper', 'cv.tpl', 48, false),)), $this); ?>

<?php echo '<div class="tab-row-container"><div class="panel panel-default hidden-xs hidden-sm"><div class="panel-heading user-references"><table><tr><th>&nbsp;</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name'), $this);?><?php echo '</th><th >'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ac_status'), $this);?><?php echo '</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created'), $this);?><?php echo '</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'last_modified'), $this);?><?php echo '</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'total_views'), $this);?><?php echo '</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'default_cv'), $this);?><?php echo '</th><th>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'actions'), $this);?><?php echo '</th></tr></table></div><div class="panel-body user-references"><table>'; ?><?php $_from = $this->_tpl_vars['my_cvs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?><?php echo '<tr><td></td><td><div class="user-title"><a href="#reference1-options'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '" id="reference1" class="username-clickable">'; ?><?php echo $this->_tpl_vars['i']['cv_title']; ?><?php echo '</a></div><div id="reference1-options'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '" class="user-options"><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/rename/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_rename'), $this);?><?php echo '</a><!--	<a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/copy/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self"onclick="return confirm_message(\''; ?><?php echo smarty_function_lang(array('mkey' => 'copy_cv'), $this);?><?php echo '\');">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_copy'), $this);?><?php echo '</a> |-->'; ?><?php if ($this->_tpl_vars['i']['default_cv'] == 'N'): ?><?php echo '| <a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/default/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" >'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_default'), $this);?><?php echo '</a>'; ?><?php endif; ?><?php echo '<!-- <a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/resume/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/review/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_rv'), $this);?><?php echo '</a>--></div></td><td>'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['cv_status'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?><?php echo ''; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['created_at']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['modified_at']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['no_views']; ?><?php echo '</td><td>'; ?><?php if ($this->_tpl_vars['i']['default_cv'] == 'Y'): ?><?php echo '<img src="'; ?><?php echo $this->_tpl_vars['skin_images_path']; ?><?php echo 'tick.gif" alt="" />'; ?><?php endif; ?><?php echo '</td><td><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/download/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_download'), $this);?><?php echo '</a> | 					 <a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/delete/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '"onclick="return confirm_message(\''; ?><?php echo smarty_function_lang(array('mkey' => 'deletecv'), $this);?><?php echo '\');">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_delete'), $this);?><?php echo '</a> | <a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/resume/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/change/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_change_status'), $this);?><?php echo '</a></td></td><tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</table></div></div></div><!--<table width="100%" cellpadding="1" cellspacing="0" class="manage_cv" ><tr class="highlight_tr"><td>&nbsp;'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ac_status'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'last_modified'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'total_views'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'default_cv'), $this);?><?php echo '</td><td>'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'actions'), $this);?><?php echo '</td></tr>'; ?><?php $_from = $this->_tpl_vars['my_cvs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?><?php echo '<tr><td><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/rename/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['i']['cv_title']; ?><?php echo '</a></td><td>'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['cv_status'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?><?php echo ''; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['created_at']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['modified_at']; ?><?php echo '</td><td>'; ?><?php echo $this->_tpl_vars['i']['no_views']; ?><?php echo '</td><td>'; ?><?php if ($this->_tpl_vars['i']['default_cv'] == 'Y'): ?><?php echo '<img src="'; ?><?php echo $this->_tpl_vars['skin_images_path']; ?><?php echo 'tick.gif" alt="" />'; ?><?php endif; ?><?php echo '</td><td><div id="menu_nav"><ul><li><a href="#">'; ?><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'actions'), $this);?><?php echo '</a><ul><li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/rename/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_rename'), $this);?><?php echo '</a></li><li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/download/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_download'), $this);?><?php echo '</a></li><li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/copy/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" target="_self"onclick="return confirm_message(\''; ?><?php echo smarty_function_lang(array('mkey' => 'copy_cv'), $this);?><?php echo '\');">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_copy'), $this);?><?php echo '</a></li><li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/delete/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '"onclick="return confirm_message(\''; ?><?php echo smarty_function_lang(array('mkey' => 'deletecv'), $this);?><?php echo '\');">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_delete'), $this);?><?php echo '</a></li><li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/resume/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/change/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_change_status'), $this);?><?php echo '</a></li>'; ?><?php if ($this->_tpl_vars['i']['default_cv'] == 'N'): ?><?php echo '<li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/default/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '" >'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_default'), $this);?><?php echo '</a></li>'; ?><?php endif; ?><?php echo '<li><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/resume/'; ?><?php echo $this->_tpl_vars['i']['id']; ?><?php echo '/review/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_rv'), $this);?><?php echo '</a></li></ul></li></ul></div></td></tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</table>--><p><a href="'; ?><?php echo $this->_tpl_vars['BASE_URL']; ?><?php echo 'curriculum_vitae/add/?portid='; ?><?php echo $this->_tpl_vars['intPortId']; ?><?php echo '">'; ?><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_new_cv'), $this);?><?php echo '</a></p>'; ?>


<script language="JavaScript" type="text/javascript">
<?php echo '
$(".panel-body .user-title a").click(function(event) {
				$(this.getAttribute("href")).css(\'display\', \'inline-block\');
			});
'; ?>

</script>