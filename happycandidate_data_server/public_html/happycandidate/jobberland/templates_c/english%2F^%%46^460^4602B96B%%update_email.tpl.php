<?php /* Smarty version 2.6.26, created on 2013-11-12 09:47:06
         compiled from employer/update_email.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/update_email.tpl', 2, false),)), $this); ?>
<form action="" method="post">
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'change_email_add'), $this);?>
</div>

<p><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ce_1'), $this);?>
</p>


<p>
	<?php echo $this->_tpl_vars['current_email']; ?>

    <br />
    <?php if ($this->_tpl_vars['is_validated'] == 'Y'): ?>
    	<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'email_vaild'), $this);?>
   
    <?php else: ?>
    	<?php echo smarty_function_lang(array('mey' => 'label','skey' => 'pending_valid'), $this);?>
 <br />
        <a href=""><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employee_resendemail'), $this);?>
</a>
    <?php endif; ?>
</p>

<p>
	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
</p>

<table width="100%">
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /> <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'new_email_add'), $this);?>
</span></td>
    <td><input name="txt_email_address" type="text" class="text_field" size="35" value="" /></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /> <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'new_email_add2'), $this);?>
</span></td>
    <td><input name="txt_confirm_email_address" type="text" class="text_field" size="35" value="" /></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_email" id="bt_email" class="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'update_email'), $this);?>
" /></td>
  </tr>

</table>

</form>