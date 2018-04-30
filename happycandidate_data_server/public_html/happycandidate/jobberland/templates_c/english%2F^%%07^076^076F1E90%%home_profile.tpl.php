<?php /* Smarty version 2.6.26, created on 2013-10-31 08:13:34
         compiled from home_profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'home_profile.tpl', 1, false),)), $this); ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'myProfile'), $this);?>
</div>
  <div style="border:1px solid #CCC; clear:both; padding-left:3px;">
	<strong><?php echo $this->_tpl_vars['full_name']; ?>
</strong>
	
    <p>
      <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'address'), $this);?>
</strong>
      <br /><?php echo $this->_tpl_vars['address']; ?>

	</p>
    
    <br />
    
    <div class="button" style="width:70px; padding:3px;">
      <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
account/"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'editProfile'), $this);?>
</a>
    </div>    
</div>