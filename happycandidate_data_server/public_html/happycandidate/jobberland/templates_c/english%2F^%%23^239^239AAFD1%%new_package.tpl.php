<?php /* Smarty version 2.6.26, created on 2013-11-09 06:46:35
         compiled from admin/new_package.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/new_package.tpl', 48, false),)), $this); ?>
<?php echo ' 
<script type="text/javascript">
function setSelectsToB(field) {
	var box = document.getElementById(\'add_package\');
	var control= document.getElementById(\'add_package\').elements;
	//alert(control);
	for (var i=0;i<control.length;i++) {
		if ( control[i].type.match(/select/i) && control[i].name != "txt_active" && control[i].value == "Y" ) {
			var name = control[i].name;
			if( name != field ) control[i].selectedIndex=0;
		}
	}
}
</script>
'; ?>
 
<div class="page_header">Add Package Plan</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<form action="" method="post" name="add_package" id="add_package" >
<table>
    <tr>
        <td><label class="label">Package Name: </label></td>
        <td><input type="text" name="txt_name" value="<?php echo $_SESSION['package']['name']; ?>
" class="text_field" size="30" /></td>
    </tr>
    
    <tr>
        <td><label class="label">Package Description: </label></td>
        <td>
            <textarea name="txt_desc" cols="35" rows="5" class="text_field" ><?php echo $_SESSION['package']['desc']; ?>
</textarea>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Package Price: </label></td>
        <td><input type="text" name="txt_price" value="<?php echo $_SESSION['package']['price']; ?>
" class="text_field" size="15" /></td>
    </tr>
    
    <tr>
        <td><label class="label">Listings Quantity:</label></td>
        <td><input type="text" name="txt_qty" value="<?php echo $_SESSION['package']['qty']; ?>
" class="text_field" size="10" /></td>
    </tr>

    <tr>
        <td><label class="label">Standard: </label></td>
        <td>
            <select name="txt_standard" class="text_field" >
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['NoYes'],'selected' => $_SESSION['package']['standard']), $this);?>

            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Spotlight: </label></td>
        <td>
            <select name="txt_spotlight" class="text_field" >
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['NoYes'],'selected' => $_SESSION['package']['spotlight']), $this);?>

            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">CV Views: </label></td>
        <td>
            <select name="txt_cv_views" class="text_field" >
              	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['NoYes'],'selected' => $_SESSION['package']['cv_views']), $this);?>

            </select>
        </td>
    </tr>
    
    <tr>
        <td><label class="label">Active: </label></td>
        <td>
            <select name="txt_active" class="text_field">
              <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['NoYes'],'selected' => $_SESSION['package']['active']), $this);?>

            </select>
        </td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="bt_add" value="Add" class="button" /></td>
    </tr>
    
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
</table>
</form>