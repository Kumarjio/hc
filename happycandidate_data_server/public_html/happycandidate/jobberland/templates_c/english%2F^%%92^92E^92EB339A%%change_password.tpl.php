<?php /* Smarty version 2.6.26, created on 2013-11-09 06:59:58
         compiled from admin/change_password.tpl */ ?>
<div class="header"> Change Password  </div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<form action="" method="post" >
<table>
    <tr>
      <td></td>
      <td> <label class="label">Old Password: </label></td>
      <td> <input type="password" name="txt_old_pass" size="30" /></td>
    </tr>
    <tr>
      <td></td>
      <td> <label class="label">New Password: </label></td>
      <td> <input type="password" name="txt_new_pass" size="30" /></td>
    </tr>
    
    <tr>
      <td></td>
      <td> <label class="label">Confirm Password: </label></td>
      <td> <input type="password" name="txt_confirm_pass" size="30" /></td>
    </tr>
    
    <tr>
      <td></td>
      <td></td>
      <td> <input type="submit" name="bt_change" value="Save Change"  /></td>
    </tr>
    
</table>
</form>