<?php /* Smarty version 2.6.26, created on 2017-06-27 16:01:20
         compiled from basic_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'basic_search.tpl', 12, false),array('function', 'html_options', 'basic_search.tpl', 26, false),)), $this); ?>
<fieldset class="fieldset round">
<form action="<?php echo $this->_tpl_vars['BASE_URL']; ?>
search/" method="get" name="search_form" id="search_form">

<table border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
   <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr valign="top">
    <td><span class="label"> <?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'enter_keyword'), $this);?>
&nbsp;:&nbsp;</span></td>
    <td>
      <input type="text" size="40" name="q" id="q" value="<?php echo $this->_tpl_vars['q']; ?>
" />
      <input type="hidden" name="search_in" value="1" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="label"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'search_loc'), $this);?>
&nbsp;: </span> </td>
    <td>
    	<input type="text" name="location" size="40" value="<?php echo $this->_tpl_vars['city_id']; ?>
" /></td>
    <td>
       &nbsp; &nbsp; &nbsp;
       <select name="txt_country" id="txt_country">
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

        </select>
        
      &nbsp;
    </td>
  </tr>
  <tr valign="top">
   <td>&nbsp;</td>
    <td>
    
    <input type="submit" name="search_bt" value=" <?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'search'), $this);?>
 " class="button" />
    <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
advance_search/">Advanced Search</a>   
    </td>
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