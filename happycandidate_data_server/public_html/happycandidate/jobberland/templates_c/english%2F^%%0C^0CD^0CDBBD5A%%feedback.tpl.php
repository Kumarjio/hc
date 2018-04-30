<?php /* Smarty version 2.6.26, created on 2013-10-30 07:56:38
         compiled from feedback.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'feedback.tpl', 1, false),array('function', 'html_options', 'feedback.tpl', 44, false),)), $this); ?>
<h1 class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'feedback'), $this);?>
</h1>
<div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br /> <?php echo $this->_tpl_vars['message']; ?>
 <br />  <?php endif; ?>

<form action="" method="post" name="feedback_form" id="feedback_form" >
<table width="100%" border="0">
  <tr>
    <td colspan="2"></td>
  </tr>
  
  <tr>
    <td colspan="2"><?php echo smarty_function_lang(array('mkey' => 'required_info_indication'), $this);?>
<br /><br /></td>
  </tr>
  
  <!-- fullname input text field -->
  <tr valign="top">
    <td width="31%" height="25"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'fullname'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
    <td width="66%">
      <input name="txt_first_name1" type="text" class="text_Field" size="35" maxlength="35" value="<?php echo $_SESSION['feedback']['name']; ?>
" /></td>
    <td width="3%"></td>
  </tr>

  <!-- email input text field-->
  <tr>
    <td height="25"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'email_address'), $this);?>

        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
    <td><input name="txt_email1" type="text" class="text_Field" size="45" maxlength="45" value="<?php echo $_SESSION['feedback']['email']; ?>
" /></td>
  </tr>

  <!-- subject input text field -->
  <tr>
    <td height="25"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'subject'), $this);?>
</span></td>
    <td><input name="txt_subject" type="text" class="text_Field" size="30" maxlength="30" value="<?php echo $_SESSION['feedback']['subject']; ?>
" /></td>
  </tr>
  
  <tr>
    <td height="25"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'about_question'), $this);?>

        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
    <td>

        <select name="cbo_query1" class="text_Field" id="cbo_query" >
            <option value=""><?php echo smarty_function_lang(array('mkey' => 'select_one_text'), $this);?>
</option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['question_comment'],'selected' => $_SESSION['feedback']['query']), $this);?>

        </select>

    </td>
  </tr>

  <!-- comment input text field -->
  <tr>
    <td height="108"><span class="label">
        <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'question_comment'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />
        <br /><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'feed_include'), $this);?>
</span></td>
    <td><textarea name="txt_comment1" class="text_Field" cols="40" rows="5" ><?php echo $_SESSION['feedback']['comment']; ?>
</textarea></td>
  </tr>

<?php if ($this->_tpl_vars['ENABLE_SPAM_FEEDBACK'] && $this->_tpl_vars['ENABLE_SPAM_FEEDBACK'] == 'Y' && $this->_tpl_vars['logged_user_id'] == ''): ?>
  <tr>
    <td colspan="2"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'security_code_txt'), $this);?>
</span></td>
  </tr>

  <tr>
    <td valign="top"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'security_code'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
  
<?php endif; ?>


  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <!-- command button -->
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="bt_send" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'send_feed'), $this);?>
" class="button" />
        </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>     
</div>