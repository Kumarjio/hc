<?php /* Smarty version 2.6.26, created on 2015-10-22 20:35:21
         compiled from admin/view_career_degree.tpl */ ?>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>
<?php if (isset ( $this->_tpl_vars['action'] ) && $this->_tpl_vars['action'] == 'add'): ?>

<div class="page_header">Add new Career Level</div>
<form action="" method="post"> 
<table>
    
    <tr>
      <td></td>
      <td><label class="label">Career Level Name: </label></td>
      <td><input type="text" name="txt_career_name" size="35" /></td>
    </tr>
    
    <tr>
      <td></td>
      <td><label class="label">Is Active: </label></td>
      <td>
        <select name="txt_is_active" >
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
    </tr>
    
    <tr>
      <td></td>
      <td></td>
      <td><input type="submit" name="bt_add" value="Add Career Level" class="button" /></td>
    </tr>
    
</table>
</form>

<?php elseif (isset ( $this->_tpl_vars['action'] ) && $this->_tpl_vars['action'] == 'edit' && isset ( $this->_tpl_vars['id'] )): ?>

<br /><br />
<div class="header">Update Career Level</div>
<form action="" method="get">
<input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<label class="label">Career Level Name: </label>
<input type="text" name="txt_name" value="<?php echo $this->_tpl_vars['jt_name2']; ?>
" size="45" />

<select name="txt_active">
    <option <?php if ($this->_tpl_vars['is_active'] == 'Y'): ?> selected="selected" <?php endif; ?> >Y</option>
    <option <?php if ($this->_tpl_vars['is_active'] == 'N'): ?> selected="selected" <?php endif; ?> >N</option>
</select>

<input type="submit" name="bt_update" value="Update" class="button" />
</form>
   <br /><br />

<?php else: ?>

<div class="header">Career Level</div>        
<a href="?action=add">Add new Career Level</a>

<table width="100%" cellpadding="5" cellspacing="1" class="tb_1">
  <tr class="shade_tb">
    <td>ID</td>
    <td>Career Level Name</td>
    <td>Is Active</td>
    <td>Action</td>
  </tr>
<?php $_from = $this->_tpl_vars['manage_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>  
 <?php ob_start(); ?><?php echo $this->_tpl_vars['comptcounter']+1; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('comptcounter', ob_get_contents());ob_end_clean(); ?>
  <tr>
    <td>#<?php echo $this->_tpl_vars['comptcounter']; ?>
</td>
    <td><?php echo $this->_tpl_vars['i']['career_name']; ?>
</td>
    <td><?php echo $this->_tpl_vars['i']['is_active']; ?>
</td>
    <td>
      <a name="<?php echo $this->_tpl_vars['i']['id']; ?>
" href="?action=edit&amp;id=<?php echo $this->_tpl_vars['i']['id']; ?>
">
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
edit.png" alt="Edit" /></a>
      <a href="?action=delete&amp;id=<?php echo $this->_tpl_vars['i']['id']; ?>
"  onclick="if ( !confirm('Are you sure you wont to delete this Job Status') ) return false;" >
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
delete.png" alt="Delete" />
      </a>
    </td>
  </tr>
 <?php endforeach; endif; unset($_from); ?>  
</table>
<?php endif; ?>