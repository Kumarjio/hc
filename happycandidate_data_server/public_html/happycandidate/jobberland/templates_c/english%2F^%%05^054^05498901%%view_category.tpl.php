<?php /* Smarty version 2.6.26, created on 2017-06-28 13:30:34
         compiled from admin/view_category.tpl */ ?>
<div class="header">Category</div>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<?php if (isset ( $this->_tpl_vars['action'] ) && $this->_tpl_vars['action'] == 'add'): ?>    

<form action="" method="post"> 
<br /><br />
<a href="view_category.php">Go Back</a>
<div class="page_header">Add new category</div>
<table>
    <tr>
      <td></td>
      <td><label class="label">Category Name: </label></td>
      <td><input type="text" name="txt_cat" size="35" /> <input type="submit" name="bt_add" value="Add Category" class="button" />
      </td>
    </tr>
</table>
<br /><br />
</form>

<?php elseif (isset ( $this->_tpl_vars['action'] ) && $this->_tpl_vars['action'] == 'edit' && isset ( $this->_tpl_vars['id'] )): ?>

<br /><br />
<a href="view_category.php">Go Back</a>
<div class="page_header">Update category</div>
   <form action="" method="get">
    <input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
    <label class="label">Category Name: </label>
    <input type="text" name="txt_cat_name" value="<?php echo $this->_tpl_vars['cat_name']; ?>
" size="45" />
    <input type="submit" name="bt_update" value="Update Category" class="button" />
   </form>
   <br /><br />

<?php else: ?>

<p><a href="?action=add">Add new Category</a></p>

<table width="100%" cellpadding="5" cellspacing="1" class="tb_1">

  <tr class="shade_tb">
    <td>ID</td>
    <td>Category Name</td>
    <td>Is Active</td>
    <td>Action</td>
  </tr>
<?php $_from = $this->_tpl_vars['manage_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

  <tr>
    <td>#<?php echo $this->_tpl_vars['i']['id']; ?>
</td>
    <td><?php echo $this->_tpl_vars['i']['cat_name']; ?>
</td>
    <td>Y</td>
    <td>
      <a name="<?php echo $this->_tpl_vars['i']['id']; ?>
" href="?action=edit&amp;id=<?php echo $this->_tpl_vars['i']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
edit.png" alt="Edit" /></a>
      <a href="?action=delete&amp;id=<?php echo $this->_tpl_vars['i']['id']; ?>
" onclick="if ( !confirm('Are you sure you want to delete this category') ) return false;">
        <img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
delete.png" alt="Delete" />
      </a>
    </td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>