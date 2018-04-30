<?php /* Smarty version 2.6.26, created on 2013-11-01 07:17:47
         compiled from employer/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/search.tpl', 1, false),array('function', 'html_options', 'employer/search.tpl', 42, false),array('function', 'html_select_date', 'employer/search.tpl', 81, false),array('modifier', 'strip_tags', 'employer/search.tpl', 26, false),array('modifier', 'default', 'employer/search.tpl', 81, false),array('modifier', 'count', 'employer/search.tpl', 113, false),)), $this); ?>
<h1 class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'SearchCV'), $this);?>
</h1>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br /><?php echo $this->_tpl_vars['message']; ?>
<br /> <?php endif; ?>

<form action="" method="get" >
 <table border="0" cellpadding="5" cellspacing="0" width="100%" >
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'keywords'), $this);?>
: </label></td>
      <td><input type="text" name="txt_keywords" id="" value="" size="35"  /></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'category'), $this);?>
: </label></td>
      <td>
      <div class="scroll_single">
            <?php $_from = $this->_tpl_vars['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>    
            <div class="scroll_single_item" >
                 <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
"  
                    <?php $_from = $this->_tpl_vars['category_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                onclick="return check_max_checkbox('txt_category[]', 10 );  " name="txt_category[]" />
                <a onclick="return check_box('<?php echo $this->_tpl_vars['k']; ?>
', 'txt_category[]', 10 );"><?php echo ((is_array($_tmp=$this->_tpl_vars['v'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <div class="clear"></div>
        </div>
        <strong><?php echo smarty_function_lang(array('mkey' => 'Max10'), $this);?>
.</strong>
      </td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'cv_1'), $this);?>
: </label></td>
      <td>      
        <select name="txt_experience">
            <option value=""><?php echo smarty_function_lang(array('mkey' => 'select_text'), $this);?>
</option>
        	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['experience'],'selected' => $this->_tpl_vars['experience_selected']), $this);?>

        </select>

      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'HighEd'), $this);?>
: </label></td>
      <td>
        <select name="txt_education">
            <option value=""><?php echo smarty_function_lang(array('mkey' => 'select_text'), $this);?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['education'],'selected' => $this->_tpl_vars['education_selected']), $this);?>

        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'search_type'), $this);?>
: </label></td>
      <td>
        <div class="scroll_single">
            <?php $_from = $this->_tpl_vars['job_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                <div class="scroll_single_item" >
                <input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
" 
                    <?php $_from = $this->_tpl_vars['type_selected']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
                      <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?> checked="checked" <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                name="txt_job_type[]" /> <?php echo $this->_tpl_vars['v']; ?>

                </div>
            <?php endforeach; endif; unset($_from); ?>
        </div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'AvStart'), $this);?>
: </label></td>
      <td>
      	<?php echo smarty_function_html_select_date(array('prefix' => 'txt_start_date_','start_year' => '-0','end_year' => "+5",'field_order' => 'DMY','month_format' => "%B",'day_value_format' => "%02d",'year_empty' => $this->_tpl_vars['select_text'],'month_empty' => $this->_tpl_vars['select_text'],'day_empty' => $this->_tpl_vars['select_text'],'time' => ((is_array($_tmp=@$this->_tpl_vars['defult_date'])) ? $this->_run_mod_handler('default', true, $_tmp, '0000-00-00') : smarty_modifier_default($_tmp, '0000-00-00'))), $this);?>
      
      </td>
      <td>&nbsp;</td>
    </tr>
       
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
: </label></td>
      <td>
<table width="100%">
<tr>
  <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'country'), $this);?>
:</td>
  <td>
    <select name="txt_country" id="txt_country" onchange="javascript: cascadeCountry(this.value,'txtstateprovince');" >
      <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

    </select>
  </td>
</tr>

<tr>
  <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'state'), $this);?>
: </label></td>
  <td><div id="stateprovince_auto">
        <?php if (count($this->_tpl_vars['lang']['states']) > 0): ?>
            <select class="select" name="txtstateprovince" onchange="javascript: cascadeState(this.value, this.form.txt_country.value,'txtcounty');" >
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['states'],'selected' => $_SESSION['loc']['stateprovince']), $this);?>

            </select>
        <?php else: ?>
            <input class="text_field required" name="txtstateprovince" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['stateprovince']; ?>
" />
       <?php endif; ?>                
    </div>
   </td>
</tr>

<tr>
  <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'county'), $this);?>
 : </label></td>
  <td>
      <div id="county_auto">
      <?php if (count($this->_tpl_vars['lang']['counties']) > 0): ?>
        <select class="select" name="txtcounty" onchange="javascript: cascadeCounty(this.value,this.form.txt_country.value, this.form.txtstateprovince.value,'txtcity');" >
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['counties'],'selected' => $_SESSION['loc']['countycode']), $this);?>

        </select>
      <?php else: ?>
        <input name="txtcounty" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['countycode']; ?>
" />
      <?php endif; ?>            
    </div>
  </td>
</tr>

<tr>
  <td><label><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'city'), $this);?>
: </label></td>
  <td>
     <div id="city_auto">
      <?php if (count($this->_tpl_vars['lang']['cities']) > 0): ?>
        <select class="select" name="txtcity" >
          <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['lang']['cities'],'selected' => $_SESSION['loc']['citycode']), $this);?>

        </select>
      <?php else: ?>
        <input name="txtcity" type="text" size="30" maxlength="100" value="<?php echo $_SESSION['loc']['citycode']; ?>
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
        <div class="clear">&nbsp;</div>
      </td>
      <td>&nbsp;</td>
    </tr>
    
    
    
    <tr>
      <td>&nbsp;</td>
      <td><label class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'DesiredSalary'), $this);?>
: </label></td>
      <td>
        <select name='txt_salary' class="select">
            <option value=""><?php echo smarty_function_lang(array('mkey' => 'select_text'), $this);?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['salary'],'selected' => $_SESSION['resume']['salary']), $this);?>

        </select>      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="bt_search" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'search'), $this);?>
 " class="button" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
 </table>   
</form>