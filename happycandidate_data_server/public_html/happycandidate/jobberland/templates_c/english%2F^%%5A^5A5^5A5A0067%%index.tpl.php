<?php /* Smarty version 2.6.26, created on 2017-06-27 16:01:19
         compiled from admin/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'admin/index.tpl', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/page_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '<body dir="'; ?><?php echo smarty_function_lang(array('mkey' => 'DIRECTION'), $this);?><?php echo '"><div id="main_table"><div id="page-title">	<h3>'; ?><?php echo $this->_tpl_vars['pagetitle']; ?><?php echo '</h3></div><table id="main_tb" width="100%"><colgroup><col width="20%;" /><col /></colgroup>'; ?><?php echo '<tr>'; ?><?php if (isset ( $this->_tpl_vars['leftmenu'] )): ?><?php echo '<td valign="top"> 	<div class="main_left_col">'; ?><?php echo $this->_tpl_vars['leftmenu']; ?><?php echo ''; ?><?php echo '</div></td>'; ?><?php endif; ?><?php echo '<td valign="top">'; ?><?php echo $this->_tpl_vars['rendered_page']; ?><?php echo '</td></tr>'; ?><?php echo '</table></div><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJQUERYPATH']; ?><?php echo 'jquery-1.7.2.min.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['HCJSPATH']; ?><?php echo 'common.js"></script><script language="javascript" type="text/javascript" src="'; ?><?php echo $this->_tpl_vars['DOC_ROOT']; ?><?php echo 'javascript/cascade.js"></script></body></html>'; ?>