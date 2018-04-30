<?php /* Smarty version 2.6.26, created on 2013-11-01 07:05:29
         compiled from employer/change_pass.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/change_pass.tpl', 2, false),)), $this); ?>
<form action="" method="post">
     <div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'change_password'), $this);?>
</div>

	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<p><?php echo smarty_function_lang(array('mkey' => 'change_pass','skey' => 'info'), $this);?>
</p>

<table width="100%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />
    <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'v_old_pass'), $this);?>
:</span></td>
    <td><input name="txt_old_pass" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />
    <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'new_password'), $this);?>
: </span></td>
    <td><input name="txt_new_pass" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />
    <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 're_new_pass'), $this);?>
: </span></td>
    <td><input name="txt_new_pass_retry" type="password" class="text_field" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_submit" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'submit'), $this);?>
" class="button"></td>
  </tr>
  
</table>
<p>&nbsp;</p>
</form>