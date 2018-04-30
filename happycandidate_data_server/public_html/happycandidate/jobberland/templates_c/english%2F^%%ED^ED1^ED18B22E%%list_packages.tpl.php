<?php /* Smarty version 2.6.26, created on 2013-11-09 07:01:30
         compiled from admin/list_packages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'admin/list_packages.tpl', 32, false),)), $this); ?>
<div class="page_header">Packages Plan</div>
<br />

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<?php if ($this->_tpl_vars['packages'] != ''): ?>
  <table width="100%" cellpadding="5" cellspacing="1" class="tb_table" >
    <colgroup>
      <col width="20%" />
      <col width="35%" />
      <col width="10%" />
      <col width="10%" />
      <col width="10%" />
      <col width="10%" />
      <col width="5%" />
    </colgroup>
   <tr>
        <td class="tb_col_head"><label class='label'>Name </label></td>
        <td class="tb_col_head"><label class='label'>Description </label></td>
        <td class="tb_col_head"><label class='label'>Qty </label></td>
        <td class="tb_col_head"><label class='label'>Price </label></td>
        <td class="tb_col_head"><label class='label'>Spotlight </label></td>
        <td class="tb_col_head"><label class='label'>CV Views </label></td>
        <td class="tb_col_head"><label class='label'>Is Active </label></td>
        <td colspan="2"  class="tb_col_head"><label class='label'>Action </label></td>
   </tr>
        <?php $_from = $this->_tpl_vars['packages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
   <tr class="list_shade">
        <td><?php echo $this->_tpl_vars['i']->package_name; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']->package_desc; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']->package_job_qty; ?>
</td>
        <td><?php echo smarty_function_lang(array('skey' => 'currency_symbol','mkey' => 'select','ckey' => $this->_tpl_vars['CURRENCY_NAME']), $this);?>
 <?php echo $this->_tpl_vars['i']->package_price; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']->spotlight; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']->cv_views; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']->is_active; ?>
</td>
        <td>
            <a href="edit_package.php?id=<?php echo $this->_tpl_vars['i']->id; ?>
"><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
edit.png" alt="Edit" /></a>
        </td>
        <td>
            <a href="?action=delete&amp;id=<?php echo $this->_tpl_vars['i']->id; ?>
"><img src="<?php echo $this->_tpl_vars['skin_images_path']; ?>
delete.png" alt="Delete" /></a>
        </td>
   </tr>

<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>