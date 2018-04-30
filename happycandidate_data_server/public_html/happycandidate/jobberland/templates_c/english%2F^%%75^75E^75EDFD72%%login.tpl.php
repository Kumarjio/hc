<?php /* Smarty version 2.6.26, created on 2017-09-29 16:06:16
         compiled from admin/login.tpl */ ?>

      

<form action="" method="post" >
<div class="widget-box"><div class="widget-main"><h4 class="header">Admin Login</h4>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<input type="text" name="txt_user" value="" placeholder="User Name" /><input type="password" name="txt_pass" value="" placeholder="Password"/>

<input type="submit" name="bt_login" value="Login" />

</div></div>
   </form>