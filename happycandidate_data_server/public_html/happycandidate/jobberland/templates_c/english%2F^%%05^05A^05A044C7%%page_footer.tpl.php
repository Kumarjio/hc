<?php /* Smarty version 2.6.26, created on 2013-10-30 07:42:26
         compiled from page_footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'page_footer.tpl', 5, false),array('modifier', 'date_format', 'page_footer.tpl', 21, false),)), $this); ?>
<div id="footer">&nbsp;</div>

<center>

    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'home'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
account/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'my_account'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
location/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'browse_by_loc'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
company/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'browse_by_company'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
category/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'browse_by_cat'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
page/faq/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'faq'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
feedback/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'feedback'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
page/searchhelp/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'search_help'), $this);?>
</a>
    </center>

<div>&nbsp;</div>
<div id="Poweredby" align="center"><a href="http://jobberland.com/" target="_blank" >Powered by Jobberland &copy; 
<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>

</a></div>
<div>&nbsp;</div>