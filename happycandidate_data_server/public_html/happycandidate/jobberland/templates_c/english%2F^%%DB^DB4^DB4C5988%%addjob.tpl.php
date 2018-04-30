<?php /* Smarty version 2.6.26, created on 2016-04-12 18:58:31
         compiled from employer/addjob.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/addjob.tpl', 52, false),array('function', 'html_options', 'employer/addjob.tpl', 222, false),array('modifier', 'count', 'employer/addjob.tpl', 314, false),array('modifier', 'strip_tags', 'employer/addjob.tpl', 379, false),)), $this); ?>
<?php echo ' 
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_job_desc",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   +"justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : \'myFileBrowser\'
  });
  
   tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "txt_job_req",
	skin : "o2k7",
    theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,"
							   +"justifyfull,fontselect,fontsizeselect,forecolor,backcolor",
	
	theme_advanced_buttons2 : "bullist, numlist, outdent, indent, |, cut,copy,paste,pastetext,"
							+ "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	
	theme_advanced_buttons3 : "",
	
    height:"350px",
    width:"550px",
    file_browser_callback : \'myFileBrowser\'
  });

</script>
'; ?>
 

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<form action="" method="post" id="job_form" name="job_form">
<?php if ($this->_tpl_vars['credit_remaining'] != ''): ?>
	<p><?php echo $this->_tpl_vars['credit_remaining']; ?>
</p>
<?php endif; ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'contact_information'), $this);?>
</div>
<table width="100%" border="0" id="company_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_contact_name'), $this);?>
: </span></td>
    <td><input name="txt_contact_name" type="text" class="text_field required" id="txt_contact_name" size="35" value="<?php echo $_SESSION['add_job']['cname']; ?>
" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ContactTelNo'), $this);?>
: </span></td>
    <td>
     <input name="txt_telephone"  type="text" class="text_field" id="txt_telephone" size="15" maxlength="13" value="<?php echo $_SESSION['add_job']['tn']; ?>
" />
    </td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'email_address'), $this);?>
: </span></td>
    <td>
        <input name="txt_email"  type="text" class="text_field required" id="txt_email" size="35" value="<?php echo $_SESSION['add_job']['email']; ?>
" />
          <br /><i><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'jobemail'), $this);?>
</i>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'company_site_link'), $this);?>
:</span> </td>
    <td>
      http://<input name="txt_site_link" type="text" class="text_field" id="txt_site_link" size="50" value="<?php echo $_SESSION['add_job']['sl']; ?>
" />
    </td>
  </tr>
  
   <tr>
    <td>&nbsp;</td>
    <td><span class="label">Company Name</span> </td>
    <td>
     <input name="txt_cname" type="text" class="text_field" size="80" id="txt_cname" value="<?php echo $_SESSION['add_job']['compname']; ?>
" />
	 <br /><i>(Your Staffing or Recruiting Firm Name)</i>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  </table>

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'JobInfo'), $this);?>
</div>
<table width="100%" border="0" id="job_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ref_code'), $this);?>
: </span></td>
    <td>
      <input name="txt_ref_code" type="text" class="text_field" id="txt_ref_code" size="40" value="<?php echo $_SESSION['add_job']['job_ref']; ?>
" />
    </td>
  </tr>

  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_title'), $this);?>
:</span></td>
    <td>
      <input name="txt_job_title" type="text" class="text_field required" id="txt_job_title" size="40" maxlength="100" value="<?php echo $_SESSION['add_job']['job_title']; ?>
" />
         <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'job_titlehelp'), $this);?>

   </td>
  </tr>
  
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_desc'), $this);?>
:</span></td>
    <td>
      <textarea name="txt_job_desc" id="txt_job_desc" cols="5" rows="20" class="text_field required" ><?php echo $_SESSION['add_job']['job_desc']; ?>
</textarea>
       <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'job_desc_cha_all'), $this);?>
 
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Job Minimum Requirements:</span></td>
    <td>
      <textarea name="txt_job_req" id="txt_job_req" cols="5" rows="20" class="text_field required" ><?php echo $_SESSION['add_job']['job_req']; ?>
</textarea>
       <br /><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'job_desc_cha_all'), $this);?>
 
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <!--<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'position'), $this);?>
:</span></td>-->
    <td><span class="label">Number of Positions Available:</span></td>
    <td>
      <input name="txt_position" type="text" class="text_field" id="txt_position"  size="40" value="<?php echo $_SESSION['add_job']['job_postion']; ?>
" />
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <!--<td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'start_date'), $this);?>
:</span></td>-->
    <td><span class="label">Target Start Date:</span></td>
    <td>
      <input name="txt_start_date" type="text" class="text_field" id="txt_start_date" maxlength="50" size="40" value="<?php echo $_SESSION['add_job']['jsd']; ?>
" />
          <br /><i> <?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'job_str_info'), $this);?>
  </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td colspan="3">
    
     <div class="label1">
        <table width="100%">
          <tr valign="top">
            <td><div class="job_col">
                <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" />
                <span class="label job"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_type'), $this);?>
:</span></div></td>
            <td>
                <?php $_from = $this->_tpl_vars['job_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
" 
                    	<?php $_from = $this->_tpl_vars['type_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      	  <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    	<?php endforeach; endif; unset($_from); ?>
                     onclick="return check_max_checkbox('txt_job_type[]', 1 );" name="txt_job_type[]" /> <?php echo $this->_tpl_vars['v']; ?>

                    <br />
                <?php endforeach; endif; unset($_from); ?>

                            </td>
            <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /><span class="label job"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'JobStatus'), $this);?>
:</span></td>
            <td>
                <?php $_from = $this->_tpl_vars['job_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
"  
                        <?php $_from = $this->_tpl_vars['status_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      	  <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    	<?php endforeach; endif; unset($_from); ?>
                    onclick="return check_max_checkbox('txt_job_status[]', 1 ); " name="txt_job_status[]" /> <?php echo $this->_tpl_vars['v']; ?>

                    <br />
                <?php endforeach; endif; unset($_from); ?>

            
                     </td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'SalaryRange'), $this);?>
:</span></td>
    <td>
      <input name="txt_salary" type="text" class="text_field" id="txt_salary" size="25" value="<?php echo $_SESSION['add_job']['salary']; ?>
" />
      <select name="txt_salaryfreq" class="text_field">
        <option value=""></option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['salaryfreq'],'selected' => $_SESSION['add_job']['freq']), $this);?>

      </select>
    <br />
    <i><?php echo smarty_function_lang(array('mkey' => 'info','skey' => 'salary_help'), $this);?>
 </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'education'), $this);?>
:</span></td>
    <td>
       <div class="small_box box">	
                
        	<?php $_from = $this->_tpl_vars['education']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
            	<div class='new_job' >
                <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
"  
                    <?php $_from = $this->_tpl_vars['education_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                onclick="return check_max_checkbox('txt_education[]', 1 ); " name="txt_education[]" /> <?php echo $this->_tpl_vars['v']; ?>

                </div>
        	<?php endforeach; endif; unset($_from); ?>
        </div>   
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'career_level'), $this);?>
:</span></td>
    <td>
        <div class="small_box box">	
                     	<?php $_from = $this->_tpl_vars['career']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
            	<div class='new_job' >
                <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
"  
                    <?php $_from = $this->_tpl_vars['career_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                onclick="return check_max_checkbox('txt_career[]', 1 ); " name="txt_career[]" /> <?php echo $this->_tpl_vars['v']; ?>

                </div>
        	<?php endforeach; endif; unset($_from); ?>

        </div>
    
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'YearOfExperience'), $this);?>
: </span></td>
    <td>
      <div class="small_box box">	
                 	<?php $_from = $this->_tpl_vars['experience']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
            	<div class='new_job' >
                <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
" 
                    <?php $_from = $this->_tpl_vars['experience_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                onclick="return check_max_checkbox('txt_experience[]', 1 ); " name="txt_experience[]" /> <?php echo $this->_tpl_vars['v']; ?>

                </div>
        	<?php endforeach; endif; unset($_from); ?>

      </div>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_location'), $this);?>
: </span></td>
    <td>
      <table width="100%">
        <tr>
          <td>Postal Code:</td>
          <td>
           <input type="text" onchange="fnGetLocationDetailFromZip()" id="txt_pcode" name="txt_pcode" size="30" class="text_field"  value="<?php echo $_SESSION['loc']['pcode']; ?>
" /> &nbsp;  <img style="display:none;" id="loader" name="loader" src="<?php echo $this->_tpl_vars['BASE_URL']; ?>
images/loader.gif" />
          </td>
        </tr>
		
		<tr id="country">
          <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'country'), $this);?>
:</td>
          <td>
            <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

            </select>
          </td>
        </tr>
        
        <tr id="state">
          <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'state'), $this);?>
: </label></td>
          <td><div id="stateprovince_auto">
                <?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
                    <select class="select" id="txtstateprovince" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

                    </select>
                <?php else: ?>
                    <input class="text_field required" name="txtstateprovince" id="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
               <?php endif; ?>                
            </div>
           </td>
        </tr>
		
		<tr id="locality" style="display:none;">
          <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'city'), $this);?>
: </label></td>
          <td>
             <div id="city_auto">
              <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
                <select class="select" id="localityval" name="localityval" >
                  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['loc']['citycode']), $this);?>

                </select>
              <?php else: ?>
                <input name="localityval" id="localityval" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['citycode']; ?>
" />
              <?php endif; ?>
        
            </div>
           </td>
        </tr>
        
        <tr id="city" style="display:none;">
          <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'county'), $this);?>
 : </label></td>
          <td>
              <div id="county_auto">
              <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
                <select class="select" name="txtcounty" id="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['counties'],'selected' => $_SESSION['loc']['countycode']), $this);?>

                </select>
              <?php else: ?>
                <input name="txtcounty" id="txtcounty" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['countycode']; ?>
" />
              <?php endif; ?>            
            </div>
          </td>
        </tr>
        
        <tr>
          <td></td>
          <td></td>
        </tr>
        
      </table>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td valign="top"><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'SelectCategories'), $this);?>
:</span></td>
    <td>
        <div class="large_box box">	
    		    	
         	<?php $_from = $this->_tpl_vars['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
            	<div class='new_job' >
                <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
"  
                    <?php $_from = $this->_tpl_vars['category_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                onclick="return check_max_checkbox('txt_category[]', 10 ); " name="txt_category[]" />
                <a onclick="return check_box('<?php echo $this->_tpl_vars['k']; ?>
', 'txt_category[]', 10 );"><?php echo ((is_array($_tmp=$this->_tpl_vars['v'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a>
                </div>
        	<?php endforeach; endif; unset($_from); ?>

        </div>
                
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
<td>
  <input name="bt_add" id="bt_add" type="submit"  value="<?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'PostJob'), $this);?>
" class="button" />
  <input name="bt_reset" type="reset"  value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'Reset'), $this);?>
 "  class="button" />

</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</form>

<?php echo ' 
<script language="javascript" type="text/javascript">
	check_max_checkbox(\'txt_job_type[]\',1);
	check_max_checkbox(\'txt_job_status[]\',1);
	check_max_checkbox(\'txt_education[]\',1);
	check_max_checkbox(\'txt_career[]\',1);
	check_max_checkbox(\'txt_experience[]\',1);
	check_max_checkbox(\'txt_city[]\',1);
	check_max_checkbox(\'txt_category[]\', 10 );
</script>
'; ?>
 