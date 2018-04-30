<?php /* Smarty version 2.6.26, created on 2015-11-24 13:30:53
         compiled from tell_a_friend.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'tell_a_friend.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['job'] == ''): ?>
<h1 class="header">&nbsp;</h1>
<br />

   <div class="error"><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'swf_1'), $this);?>
</div>
   
<?php else: ?>
<h1 class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'swf'), $this);?>
</h1>

 <div class="border_around">  
    <div id="job_title"><?php echo $this->_tpl_vars['job_title']; ?>
</div>
    <div class="clear">&nbsp;</div>
    <div><?php echo $this->_tpl_vars['job_description']; ?>
</div>
    <br />
    <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
</strong> <?php echo $this->_tpl_vars['location']; ?>

    <strong> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created_at'), $this);?>
 </strong><?php echo $this->_tpl_vars['created_at']; ?>

  </div>
  

<form action="" method="post" id="send_to_friend_form" name="send_to_friend_form" >
 <input name="id" type="hidden" value="<?php echo $this->_tpl_vars['id']; ?>
" />
 
  <table width="100%">
   <tr>
    <td>
      
      <?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
      
    </td>
   </tr>
   <tr>
     <td><br /><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /> <b>Required information</b></td>
   </tr>
   <tr>
     <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'send_this_job_to'), $this);?>
 <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_send_to1" type="text" class="text_field" size="50" value="<?php echo $_SESSION['share']['send_to']; ?>
" /><br />
          <?php echo smarty_function_lang(array('mkey' => 'swf','skey' => 'info_1'), $this);?>

     </td>
   </tr>
   
   <tr>
     <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'subject_of_email'), $this);?>
</span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_subject" type="text" class="text_field" size="30" maxlength="50" 
          value="<?php echo $_SESSION['share']['subject']; ?>
" /><br />
       <?php echo smarty_function_lang(array('mkey' => 'swf','skey' => 'info_2'), $this);?>

     </td>
   </tr>
   
   <tr>
     <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'additional_comments'), $this);?>
</span></td>
   </tr>
   <tr>
     <td>
       <textarea name="txt_comments" cols="50" rows="10" ><?php echo $_SESSION['share']['notes']; ?>
</textarea></td>
   </tr>
   <tr>
     <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'your_email_add'), $this);?>
<img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></span></td>
   </tr>
   <tr>
     <td>
       <input name="txt_email1" type="text" class="text_field" size="35" maxlength="50" value="<?php echo $_SESSION['share']['from_send']; ?>
" /><br />
       <?php echo smarty_function_lang(array('mkey' => 'swf','skey' => 'info_3'), $this);?>

     </td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   
   
<?php if ($this->_tpl_vars['ENABLE_SPAM_SHARE'] && $this->_tpl_vars['ENABLE_SPAM_SHARE'] == 'Y'): ?>
  <tr>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'security_code_txt'), $this);?>
</span></td>
  </tr>

  <tr>
    <td valign="top"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'security_code'), $this);?>
</span><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
  </tr>
  <tr>  
    <td>
    	<input type="text" name="spam_code" id="spam_code" value="" class="txt_field" size="10" />   
    </td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" ><img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a 
    ></td>
  </tr> 
  
<?php endif; ?>   
   
   
   <tr>
     <td>&nbsp;</td>
   </tr>
   
   <tr>
     <td>
       <input name="bt_send" type="submit" class="button" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'stf'), $this);?>
" />
     </td>
   </tr>
  </table>

</form>
<?php endif; ?>