<?php /* Smarty version 2.6.26, created on 2016-01-13 02:02:36
         compiled from admin/new_job.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'admin/new_job.tpl', 265, false),array('modifier', 'strip_tags', 'admin/new_job.tpl', 319, false),array('function', 'html_options', 'admin/new_job.tpl', 267, false),)), $this); ?>
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

</script>
'; ?>
 
	 
<div class="header">Post new job</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<form action="" method="post" id="job_form" name="job_form">
 <input type="hidden" name="employer_id" value="<?php echo $this->_tpl_vars['employer_id']; ?>
" />
 <input type="hidden" name="username" value="<?php echo $this->_tpl_vars['username']; ?>
" />
 
<div class="page_header">Contact Information</div>

<p><strong><?php echo $this->_tpl_vars['employer_fullname']; ?>
</strong></p>

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
    <td><span class="label">Contact Name: </span></td>
    <td><input name="txt_contact_name" type="text" class="text_field required" id="txt_contact_name" size="35" value="<?php echo $_SESSION['add_job']['cname']; ?>
" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">Contact Telephone No: </span></td>
    <td>
     <input name="txt_telephone"  type="text" class="text_field" id="txt_telephone" size="15" maxlength="13" value="<?php echo $_SESSION['add_job']['tn']; ?>
" />
    </td>
  </tr>
  
  <tr>
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Email Address: </span></td>
    <td>
        <input name="txt_email"  type="text" class="text_field required" id="txt_email" size="35" value="<?php echo $_SESSION['add_job']['email']; ?>
" />
          <br /><i>Email will not be shown, it is used to send Application </i>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><span class="label">Site Link:</span> </td>
    <td>
      http://<input name="txt_site_link" type="text" class="text_field" id="txt_site_link" size="50" value="<?php echo $_SESSION['add_job']['sl']; ?>
" />
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  </table>

<div class="page_header">Job Information</div>
<table width="100%" border="0" id="job_table" cellpadding="2" cellspacing="2" >
    <colgroup>
      <col />
      <col class="job_col" />
      <col class="job_co2" />
    </colgroup>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Reference code: </span></td>
    <td>
      <input name="txt_ref_code" type="text" class="text_field" id="txt_ref_code" size="40" value="<?php echo $_SESSION['add_job']['job_ref']; ?>
" />
    </td>
  </tr>

  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Job Title:</span></td>
    <td>
      <input name="txt_job_title" type="text" class="text_field required" id="txt_job_title" size="40" maxlength="100" value="<?php echo $_SESSION['add_job']['job_title']; ?>
" />
         <br />(e.g. "Web Developer", "Graphic Artist")
   </td>
  </tr>
  
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td><span class="label">Job Description:</span></td>
    <td>
      <textarea name="txt_job_desc" id="txt_job_desc" cols="5" rows="20" class="text_field required" ><?php echo $_SESSION['add_job']['job_desc']; ?>
</textarea>
       <br />1000 characters allowed. 
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Position:</span></td>
    <td>
      <input name="txt_position" type="text" class="text_field" id="txt_position"  size="40" value="<?php echo $_SESSION['add_job']['job_postion']; ?>
" />
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Start Date:</span></td>
    <td>
      <input name="txt_start_date" type="text" class="text_field" id="txt_start_date" maxlength="50" size="40" value="<?php echo $_SESSION['add_job']['jsd']; ?>
" />
          <br /><i> e.g. ASAP,  </i>
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
                <span class="label job">Job Type:</span></div></td>
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
required.gif" alt="" /><span class="label job">Job Status:</span></td>
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
    <td><span class="label">Salary range:</span></td>
    <td>
      <input name="txt_salary" type="text" class="text_field" id="txt_salary" size="25" value="<?php echo $_SESSION['add_job']['salary']; ?>
" />
      <select name="txt_salaryfreq" class="text_field">
        <option value=""></option>
        <option>Hour</option>
        <option>Daily</option>
        <option>Weekly</option>
        <option>Monthly</option>
        <option>Yearly</option>
      </select>
    <br />
    <i>(e.g. 25000-30000 , 10 , 8.5, 123, 300, 25k-45k ) </i>
    </td>
  </tr>
  
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="label">Education:</span></td>
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
    <td><span class="label">Career Level:</span></td>
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
    <td><span class="label">Year Of Experience: </span></td>
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
    <td><span class="label">Job Location: </span></td>
    <td><input type="hidden" name="txt_country" id="txt_country" value="<?php echo $this->_tpl_vars['countrycode']; ?>
" />
        
        <div style="float:left; min-width:178px; padding-right:10px;"><label>State: </label>
            <div id="stateprovince_auto">
                <?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
                    <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['add_job']['state']), $this);?>

                    </select>
                <?php else: ?>
                    <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['add_job']['state']; ?>
" />
               <?php endif; ?>                
            </div>
        </div>
        
        <div style="float:left; min-width:175px; padding-right:10px;"> <label>County : </label>
        <div id="county_auto">
          <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
            <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['counties'],'selected' => $_SESSION['add_job']['county']), $this);?>

            </select>
          <?php else: ?>
            <input name="txtcounty" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['add_job']['county']; ?>
" />
          <?php endif; ?>
        
        </div>
        </div>
        
        <div style="float:left; min-width:175px; padding-right:10px;">
            <label>City: </label>
            <div id="city_auto">
              <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
                <select class="select" name="txtcity" >
                  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['add_job']['city']), $this);?>

                </select>
              <?php else: ?>
                <input name="txtcity" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['add_job']['city']; ?>
" />
              <?php endif; ?>
        
            </div>
         </div>
        <div class="clear">&nbsp;</div>
    </td>
  </tr>
  
  <tr valign="top">
    <td><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
required.gif" alt="" /></td>
    <td valign="top"><span class="label">Select Categories:</span></td>
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
', 'txt_category[]', 10);"><?php echo ((is_array($_tmp=$this->_tpl_vars['v'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
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
  <input name="bt_add" id="bt_add" type="submit"  value="Post Job" class="button" />
  <input name="bt_reset" type="reset"  value=" Reset "  class="button" />

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
 