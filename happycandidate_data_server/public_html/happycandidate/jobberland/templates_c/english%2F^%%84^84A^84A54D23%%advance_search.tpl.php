<?php /* Smarty version 2.6.26, created on 2015-10-27 11:35:35
         compiled from advance_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'advance_search.tpl', 12, false),array('function', 'html_options', 'advance_search.tpl', 29, false),array('function', 'html_checkboxes', 'advance_search.tpl', 43, false),)), $this); ?>
<fieldset class="fieldset round">
<form action="<?php echo $this->_tpl_vars['BASE_URL']; ?>
search/" method="get" name="search_form" id="search_form">
<table border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td> <span class="label"> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'enter_keyword'), $this);?>
 </span> </td>
    <td>
      <input type="text" size="40" name="q" id="q" class="search_text_bx" value="<?php echo $this->_tpl_vars['q']; ?>
" />
      <br />
      <input type="radio" name="search_in" value="1" <?php if ($this->_tpl_vars['search_in'] == 1): ?> checked="checked" <?php endif; ?> />  <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'title_desc'), $this);?>
 
      <input type="radio" name="search_in" value="2" <?php if ($this->_tpl_vars['search_in'] == 2): ?> checked="checked" <?php endif; ?> /> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'titleonly'), $this);?>
 
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'search_loc'), $this);?>
</span> </td>
    <td colspan="4">
      <input type="text" name="location" size="40" value="<?php echo $this->_tpl_vars['city_id']; ?>
" />
       &nbsp; &nbsp; &nbsp;
       <select name="txt_country" id="txt_country">
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

        </select>
        
    </td>
    </tr>
  
  <tr valign="top">
    <td> <span class="label"> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'search_cat'), $this);?>
 </span> </td>
    <td>
        <a href="#" id="jquery_select_category"><?php echo smarty_function_lang(array('mkey' => 'link','skey' => 'select_cat'), $this);?>
</a>
        
        <div id="jquery_search_cat">
            <div id="jquery_selecting_cat">&nbsp;<br />&nbsp;</div>
            <div style='overflow:auto; height:100px; width:100%; border:1px solid #404040; display:block;'>
                <?php echo smarty_function_html_checkboxes(array('id' => 'category','name' => 'category','options' => $this->_tpl_vars['category'],'selected' => $this->_tpl_vars['category_selected'],'separator' => '<br />'), $this);?>

            </div>
        </div>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <span class="label"> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'search_type'), $this);?>
 </span> </td>
    <td colspan="3">
    	<select name="job_type" class="search_text_bx">
        	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['job_type'],'selected' => $this->_tpl_vars['job_type_selected']), $this);?>

        </select>
        
    	<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'home_within'), $this);?>
 
        <select name="within" class="search_text_bx" >
        	<option></option>
            <option>7</option>
            <option>6</option>
            <option>5</option>
            <option>4</option>
            <option>3</option>
            <option>2</option>
            <option>1</option>
            <option>0</option>
        </select>
	<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'home_days'), $this);?>

    	<select name="order_by" class="search_text_bx" >
        	<option value="1">Best Match</option>
            <option value="0">Date</option>
        </select>
    </td>
    <td><input type="submit" name="search_bt" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'search'), $this);?>
 " class="button" /></td>
  </tr>
  
  <tr>
    <td><span class="label"></span> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

</fieldset>

<?php if ($this->_tpl_vars['did_you_mean_name'] != ''): ?>
 <?php echo smarty_function_lang(array('mkey' => 'do_you_mean'), $this);?>
 <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;location=<?php echo $this->_tpl_vars['did_you_mean_name']; ?>
<?php else: ?>location=<?php echo $this->_tpl_vars['did_you_mean_name']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['did_you_mean_name']; ?>
</a>
<?php endif; ?>