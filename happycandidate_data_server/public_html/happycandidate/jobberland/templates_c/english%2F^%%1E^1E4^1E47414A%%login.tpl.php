<?php /* Smarty version 2.6.26, created on 2016-04-11 19:00:56
         compiled from employer/login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/login.tpl', 4, false),)), $this); ?>
<table width="100%" >
  <tr>
   <td valign="top">
   <div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'Signin'), $this);?>
</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br /><?php echo $this->_tpl_vars['message']; ?>
<br /> <?php endif; ?>

<form action="" method="post">
<table width="100%" class="border">
 <tr>
  <td colspan="3">&nbsp;</td>
 </tr>
 <tr>
  <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
  <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'username'), $this);?>
 </span></td>
  <td><input type="text" id="useranme_txt" name="useranme_txt" size="30" class="text_field required" value=""  /></td>
 </tr>

 <tr>
  <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
  <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'password'), $this);?>
 </span></td>
  <td><input type="password" id="pass_txt" name="pass_txt" size="15" class="text_field required" value="" /></td>
 </tr>

<?php if ($this->_tpl_vars['ENABLE_SPAM_LOGIN'] && $this->_tpl_vars['ENABLE_SPAM_LOGIN'] == 'Y'): ?>
 
 <tr>
  <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
  <td valign="top"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'security_code'), $this);?>
</span></td>
  <td>
    <input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
  </td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
   <a href="javascript:reloadCaptcha();" >
     <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
   </td>
 </tr> 

<?php endif; ?>

 <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input type="submit" id="bt_login" name="bt_login" class="button login" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'login'), $this);?>
 &raquo; " /></td>
 </tr>
</table>
</form>

<br /><br />
<strong><?php echo smarty_function_lang(array('mkey' => 'link_header','skey' => 'login_forgot'), $this);?>
</strong><br />
 <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/forgot_details/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employee_remindedup'), $this);?>
.</a>
<br /><br />

<strong><?php echo smarty_function_lang(array('mkey' => 'link_header','skey' => 'login_lostconf'), $this);?>
</strong><br />
<a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/resend_conflink/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employee_resendemail'), $this);?>
</a>

  </td>
  <td valign="top">

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'Newto'), $this);?>
</div>
    <p><?php echo smarty_function_lang(array('mkey' => 'empreg','skey' => 'info1'), $this);?>
</p>  
    <p><label id="titlelogin"><?php echo smarty_function_lang(array('mkey' => 'empreg','skey' => 'info2'), $this);?>
</label><br />
    <?php echo smarty_function_lang(array('mkey' => 'empreg','skey' => 'info3'), $this);?>
</p>
    <p align="center">
        <input name="bt_register" type="button" class="button" id="bt_cmd" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'continue'), $this);?>
" onclick="javascript:window.location = '<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/register/'; " />
    </p>
  </td>
  
  </tr>
</table>