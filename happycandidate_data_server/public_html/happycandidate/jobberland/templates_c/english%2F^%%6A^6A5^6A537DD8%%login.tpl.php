<?php /* Smarty version 2.6.26, created on 2013-10-30 07:43:49
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'login.tpl', 6, false),)), $this); ?>
<fieldset>
<table>
<tr>
  <td valign="top">  
  <fieldset class="round">
  <legend> <strong><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'login_already'), $this);?>
</strong> </legend>
  <!-- LOGIN TABLE -->
  <form action="" method="post">
  <table class="login_table">
   
   <tr>
    <td colspan="3">
	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
    </td>
   </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'username'), $this);?>
:</span></td>
    <td>
     <input type="text" id="useranme_txt" name="useranme_txt" size="30" class="text_field required" value="<?php echo $this->_tpl_vars['username']; ?>
"  /></td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'password'), $this);?>
:</span></td>
    <td><input type="password" id="pass_txt" name="pass_txt" size="15" class="text_field required" value="" /></td>
  </tr>
 
<?php if ($this->_tpl_vars['ENABLE_SPAM_LOGIN'] && $this->_tpl_vars['ENABLE_SPAM_LOGIN'] == 'Y'): ?>
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td valign="top"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'security_code'), $this);?>
:</span></td>
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
  
<?php endif; ?>




  <tr>
    <td></td>
    <td></td>
    <td><input type="submit" id="bt_login" name="bt_login" class="button login" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'login'), $this);?>
 &raquo;" />
    
    <?php if ($this->_tpl_vars['LINKEDIN'] == 'Y'): ?>
    	<a href="<?php echo $this->_tpl_vars['LINKEDIN_CALLBACKURL']; ?>
">
          <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
/plugins/linkedin/img/login.png" border="0" width="100" />
        </a>
          <?php endif; ?>
    
    </td>
  </tr>
  
</table>
</form>

<br />
    <strong><?php echo smarty_function_lang(array('mkey' => 'link_header','skey' => 'login_forgot'), $this);?>
</strong><br />
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
forgot_details/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employee_remindedup'), $this);?>
.</a>
<br /><br />

    <strong><?php echo smarty_function_lang(array('mkey' => 'link_header','skey' => 'login_lostconf'), $this);?>
</strong><br />
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
resend_conflink/"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'employee_resendemail'), $this);?>
</a>

</fieldset>
</td>

<td valign="top">
<fieldset class="round">
<legend> <strong> <?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'login_register'), $this);?>
 </strong> </legend>
<?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info'), $this);?>


 <!-- <p> Let jobs come to you with our arsenal of tools, including daily and instant job alerts.
  Upload and activate your CV and allow prospective employers to find you.</p> -->
  
 <input type="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'register'), $this);?>
" class="button" onclick="go_to('<?php echo $this->_tpl_vars['BASE_URL']; ?>
register/');"/>

  <br />
        <h3><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'why_register'), $this);?>
</h3>
        
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
easymoblog.png" alt="" style="float:left;" />
        <div style="float:left; width:79%;">
          <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header1'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info1'), $this);?>
<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
search.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
          <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header2'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info2'), $this);?>
<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
keditbookmarks.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header3'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info3'), $this);?>
<br />
        </div>
        
        <div class="clear">&nbsp;</div> 
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
knotes.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header4'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info4'), $this);?>
<br /> 
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
mouse.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header5'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info5'), $this);?>
<br />
        </div>
        
        <div class="clear">&nbsp;</div>
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
kate.png" alt="" style="float:left;" /> 
        <div style="float:left;width:79%;">
            <strong><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'header6'), $this);?>
</strong>
          <br /><?php echo smarty_function_lang(array('mkey' => 'login','skey' => 'info6'), $this);?>
<br />
        </div>

</fieldset>

</td>
</tr>
</table>
</fieldset>