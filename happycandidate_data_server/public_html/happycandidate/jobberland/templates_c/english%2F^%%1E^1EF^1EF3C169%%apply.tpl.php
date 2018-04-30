<?php /* Smarty version 2.6.26, created on 2016-01-29 17:10:39
         compiled from apply.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'apply.tpl', 12, false),array('function', 'html_options', 'apply.tpl', 48, false),)), $this); ?>
<?php if ($this->_tpl_vars['jobs']): ?> 
<div class="header">&nbsp;</div>

<div  class="border_around" >
    <div id="job_title"><?php echo $this->_tpl_vars['job_title']; ?>
</div>
    
    <div class="clear">&nbsp;</div>
    
    <div><?php echo $this->_tpl_vars['job_description']; ?>
</div>
    
    <br />
    <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
</strong> <?php echo $this->_tpl_vars['location']; ?>

        <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_name'), $this);?>
 </strong><?php echo $this->_tpl_vars['company_name']; ?>

    <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_contact_name'), $this);?>
</strong><?php echo $this->_tpl_vars['contact_name']; ?>

    <?php if ($this->_tpl_vars['start_date'] != ''): ?><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'start_date'), $this);?>
 </strong><?php echo $this->_tpl_vars['start_date']; ?>
 <?php endif; ?>
    <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'created_at'), $this);?>
 </strong><?php echo $this->_tpl_vars['created_at']; ?>

</div>
<br /><br />

  	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
    
    <h3><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'apply_question'), $this);?>
</h3>
    
    <?php echo smarty_function_lang(array('mkey' => 'required_info_indication'), $this);?>

  
<form action="" method="post" enctype="multipart/form-data" id="apply_form" >
   <table width="100%" >
    <colgroup>
      <col />
      <col width="30%" />
      <col />
    </colgroup>
    <tr>
      <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'email_address'), $this);?>
</label></td>
      <td><input type="text" name="txt_email1" class="text_fields" id="txt_email" 
            value="<?php echo $_SESSION['apply']['email']; ?>
" size="35" /></td>
    </tr>
    <tr>
      <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'working_status'), $this);?>
 </label></td>
      <td>
      
        <select name="txt_working_status" id="txt_working_status" class="text_fields" >
        	<option value=""></option>
      		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['working_status'],'selected' => $_SESSION['apply']['work_status']), $this);?>

      	</select>

      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cover_letter'), $this);?>
</td>
      <td>
        <?php if (is_array ( $this->_tpl_vars['my_letters'] ) && $this->_tpl_vars['my_letters'] != ""): ?>
          <?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'apply_cv'), $this);?>
<br />
          <select name="txt_which_letter" onchange="ajax_page( 'txt_letter', '<?php echo $this->_tpl_vars['BASE_URL']; ?>
cascade/covering_letter.php?id='+this.value );">
            <option value=""><?php echo smarty_function_lang(array('mkey' => 'new_cover_letter'), $this);?>
</option>
              <?php $_from = $this->_tpl_vars['my_letters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
                 <option <?php if ($this->_tpl_vars['i']['is_defult'] == 'Y'): ?>selected='selected'<?php endif; ?> value="<?php echo $this->_tpl_vars['i']['id']; ?>
" ><?php echo $this->_tpl_vars['i']['cl_title']; ?>
</option> 
              <?php endforeach; endif; unset($_from); ?>
              
          </select>
        <br />
        <?php endif; ?>    
        <textarea name="txt_letter" class="text_fields" id="txt_letter" cols="40" rows="5"><?php echo $_SESSION['apply']['cover_letter']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'upload_cv'), $this);?>
 </label></td>
      <td>
        <?php if (is_array ( $this->_tpl_vars['my_cv'] ) && $this->_tpl_vars['my_cv'] != ""): ?>
        	<select name="txt_existed_cv">
                <option value=""></option>
                <?php $_from = $this->_tpl_vars['my_cv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
                 <option <?php if ($this->_tpl_vars['i']['default_cv'] == 'Y'): ?>selected='selected'<?php endif; ?> value="<?php echo $this->_tpl_vars['i']['id']; ?>
" ><?php echo $this->_tpl_vars['i']['cv_title']; ?>
</option> 
              <?php endforeach; endif; unset($_from); ?>
            </select>
            <br />
        <?php endif; ?>
        
                <input type="file" name="txt_cv" class="text_fields" id="txt_cv" />
       
        <input type="hidden" name="MAX_CV_FILESIZE" value="<?php echo $this->_tpl_vars['MAX_CV_SIZE']; ?>
" />
        <br /><i><?php echo smarty_function_lang(array('mkey' => 'cv_max_size'), $this);?>
 <?php echo smarty_function_lang(array('mkey' => 'max'), $this);?>
 
        <?php echo $this->_tpl_vars['ALLOWED_FILETYPES_DOC']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'files_only'), $this);?>
</i>
      </td>
    </tr>

<?php if ($this->_tpl_vars['ENABLE_SPAM_APPLY_JOB'] && $this->_tpl_vars['ENABLE_SPAM_APPLY_JOB'] == 'Y' && $this->_tpl_vars['logged_user_id'] == ''): ?>
  <tr>
    <td colspan="3"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'security_code_txt'), $this);?>
</span></td>
  </tr>

  <tr valign="top">
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
    <td>
     <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/SecurityImage.php"  alt="Security Code" id="spam_code_img" name="spam_code_img" alt="" />&nbsp;&nbsp;
	<a href="javascript:reloadCaptcha();" >
      <img src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
captcha/images/arrow_refresh.png" alt="Refresh Code" border="0" alt="" /></a> 
    </td>
  </tr> 
  
<?php endif; ?>

    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'submite_application'), $this);?>
" class="button" /></td>
    </tr>
    
    <tr>
      <td colspan="3" class="optional_hd"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'apply_further_app'), $this);?>
</td>
    </tr>
    
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'firstname'), $this);?>
 </td>
      <td><input type="text" name="txt_fname" class="text_fields" id="txt_fname" value="<?php echo $_SESSION['apply']['fname']; ?>
" size="25" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'surname'), $this);?>
</td>
      <td><input type="text" name="txt_sname" class="text_fields" id="txt_sname" value="<?php echo $_SESSION['apply']['sname']; ?>
" size="25" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'address'), $this);?>
</td>
      <td>
          <textarea name="txt_address" id="txt_address" class="text_fields" cols="40" rows="5"><?php echo $_SESSION['apply']['address']; ?>
</textarea>
      </td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'home_tel'), $this);?>
</td>
      <td><input type="text" name="txt_tel" class="text_fields" id="txt_tel" value="<?php echo $_SESSION['apply']['home_tel']; ?>
" size="15" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'mobile_no'), $this);?>
</td>
      <td><input type="text" name="txt_mob" class="text_fields" id="txt_mob" value="<?php echo $_SESSION['apply']['mob_tel']; ?>
" size="15" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'availability_notice'), $this);?>
 </td>
      <td>
           
        <select name="txt_notice" id="txt_notice" class="text_fields" >
        	<option value=""></option>
      		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['notice'],'selected' => $_SESSION['apply']['notice']), $this);?>

      	</select>
     </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'hourly_rate'), $this);?>
</td>
      <td>
        <select name="txt_salary" id="txt_salary" class="text_fields" >
            <option value=""></option>
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['salary'],'selected' => $_SESSION['apply']['salary']), $this);?>

        </select>
      </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'approximately_far_travel'), $this);?>
</td>
      <td>
        <select name="txt_willing_to_travel" id="txt_willing_to_travel" class="text_fields" >
            <option value=""></option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['willing_to_travel'],'selected' => $_SESSION['apply']['willing_to_travel']), $this);?>

        </select>
      </td>
    </tr>
    
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'submite_application'), $this);?>
" class="button" /></td>
    </tr>
    
  </table>
</form>
</div>
<?php else: ?>
	<div class='error'><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'apply_not_found'), $this);?>
</div>
<?php endif; ?>