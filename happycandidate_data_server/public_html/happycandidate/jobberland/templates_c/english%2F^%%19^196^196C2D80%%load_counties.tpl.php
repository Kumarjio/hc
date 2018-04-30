<?php /* Smarty version 2.6.26, created on 2013-11-09 06:59:03
         compiled from admin/load_counties.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/load_counties.tpl', 20, false),)), $this); ?>
<div class="header">Process States File</div>
<div>
    <p>Please load county/district codes file to the directory /counties before processing.</p>
    <p>The file should contain COUNTYCODE, COUNTYNAME and STATECODE separated by commas. (in same order, no header)</p>
    <p>To delete county/district codes for a country, select the country and press "Delete county codes".</p>
</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<div>
<form action="" method="post" >
<table border="0" width="100%">
  <colgroup>
    <col width="150" />
  </colgroup>
  <tr>
    <td><span class="label">Country: </span></td>
	<td>
	  <select name="txt_country" >
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['country'],'selected' => $_SESSION['loc']['country']), $this);?>

	  </select>
	</td>
  </tr>
  <tr>
   	<td><span class="label">County codes file: </span></td>
 	<td>
	  <select name="filename">
		<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['files'],'output' => $this->_tpl_vars['files'],'selected' => $this->_tpl_vars['filename']), $this);?>

	  </select>
	</td>
  </tr>
  
  <tr>
   	<td>&nbsp;</td>
 	<td>&nbsp;</td>
  </tr>
  
  <tr>
  	<td>&nbsp;</td>
	<td>
        <input type="submit"  class="button" name="loadcounty" value=" Process counties file" />&nbsp;&nbsp;
        <input type="submit"  class="button" name="deletecounty" value="Delete counties codes" onclick="if ( !confirm('All county/district codes for this country will be deleted') ) return false;" />&nbsp;&nbsp;
	</td>
   </tr>
</table>
</form>
</div>