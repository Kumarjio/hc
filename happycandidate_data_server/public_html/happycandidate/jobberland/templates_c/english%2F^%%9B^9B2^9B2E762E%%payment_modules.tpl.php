<?php /* Smarty version 2.6.26, created on 2013-11-09 06:59:33
         compiled from admin/payment_modules.tpl */ ?>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?> 

<form action="" method="post" >
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<table width="100%" cellpadding="1" cellspacing="2">
  <colgroup>
    <col width="30%">
    
  </colgroup>
    <tr>
      <td>Module Name</td>
      <td>Action</td>
    </tr>

<?php $_from = $this->_tpl_vars['payment_modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
    <tr>
      <td class="bold"><?php echo $this->_tpl_vars['i']['name']; ?>
: </td>
      <td>
        <?php if ($this->_tpl_vars['i']['enabled'] == 'Y'): ?>
         <a href="payment_edit.php?payment=<?php echo $this->_tpl_vars['i']['module_key']; ?>
&amp;id=<?php echo $this->_tpl_vars['i']['id']; ?>
">Edit</a> | 
         <a href="?remove=<?php echo $this->_tpl_vars['i']['module_key']; ?>
">Uninstall</a>
        <?php else: ?>
          <a href="?install=<?php echo $this->_tpl_vars['i']['module_key']; ?>
">Install</a>
        <?php endif; ?>
      </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>

    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>

        