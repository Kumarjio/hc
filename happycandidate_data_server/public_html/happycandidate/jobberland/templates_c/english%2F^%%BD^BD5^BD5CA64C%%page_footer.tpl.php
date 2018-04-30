<?php /* Smarty version 2.6.26, created on 2013-11-01 06:51:38
         compiled from employer/page_footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/page_footer.tpl', 5, false),array('modifier', 'date_format', 'employer/page_footer.tpl', 15, false),)), $this); ?>
<div id="footer">&nbsp;</div>

<center>

    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'home'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/account/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'my_account'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/services/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'products'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/page/security/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'security'), $this);?>
</a> | 
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/page/faq/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'faq'), $this);?>
</a>
    <!-- <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/feedback/" target="_self"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'feedback'), $this);?>
</a> -->
</center>

<div>&nbsp;</div>
<div id="Poweredby" align="center"><a href="http://jobberland.com/" target="_blank" >Powered by Jobberland &copy; 
<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>

</a></div>
<div>&nbsp;</div>