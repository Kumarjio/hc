<?php /* Smarty version 2.6.26, created on 2013-10-30 07:41:27
         compiled from admin/setting.tpl */ ?>

<div class="header">
    <?php echo $this->_tpl_vars['cat_name']; ?>

</div>

<form method="get" action="" name="frm1">
<table border=0>
 <tr>
  <td>Settings Group: </td>
  <td>
   <select name="id" onchange="javascript: document.frm1.submit();">
        <?php $_from = $this->_tpl_vars['cat_settings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
           <option value="<?php echo $this->_tpl_vars['i']['id']; ?>
" <?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['i']['id']): ?> selected="selected" <?php endif; ?> > <?php echo $this->_tpl_vars['i']['category_name']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
   </select>
        </td>
    </tr>
</table>
</form>

<p>
	<strong>Description: </strong>
	<?php echo $this->_tpl_vars['cat_description']; ?>

</p>
<br />
      
	<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?> 
    
		<form action="" method="post" >
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
        <table width="100%" id="setting">
        <?php $_from = $this->_tpl_vars['site_setting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
			<tr>
              <td class="bold"><?php echo $this->_tpl_vars['i']['title']; ?>
: </td>
              <td><?php echo $this->_tpl_vars['i']['input']; ?>

              <br /><?php echo $this->_tpl_vars['i']['description']; ?>
</td>
            </tr>
		<?php endforeach; endif; unset($_from); ?>
        
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
        	<tr>
            	<td>&nbsp;</td>
            	<td><input type="submit" name="add" value="Update" /></td>
            </tr>
        </table>
        
        </form>    