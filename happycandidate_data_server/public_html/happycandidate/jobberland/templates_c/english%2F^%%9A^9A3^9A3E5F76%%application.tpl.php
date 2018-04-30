<?php /* Smarty version 2.6.26, created on 2013-10-30 07:48:36
         compiled from application.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'application.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['application'] && is_array ( $this->_tpl_vars['application'] )): ?>

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'my_application'), $this);?>
</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <br />  <?php echo $this->_tpl_vars['message']; ?>
 <br /> <?php endif; ?>

<div class="my_application_info">
	<?php echo smarty_function_lang(array('mkey' => 'app','skey' => '1'), $this);?>

</div>

<br />

<?php $_from = $this->_tpl_vars['application']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

<div class="round">
	<div class="app_job_title"><a href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo $this->_tpl_vars['i']['job_url']; ?>
'><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a></div>
    <div class='my_application_details'>
        <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_post'), $this);?>
 </strong><?php echo $this->_tpl_vars['i']['created_at']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_app'), $this);?>
 </strong><?php echo $this->_tpl_vars['i']['date_apply']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_cv'), $this);?>
 </strong><?php echo $this->_tpl_vars['i']['cv_name']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_cl'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['cover_letter']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_cn'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['contact_name']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_ce'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['poster_email']; ?>

        <br /><a href='?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;job_id=<?php echo $this->_tpl_vars['i']['job_id']; ?>
&amp;delete=true'><?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'delete_app'), $this);?>
</a>
    </div>
</div>

<hr />
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['message'] != ""): ?> <br />  <?php echo $this->_tpl_vars['message']; ?>
 <br /> <?php endif; ?>
    
    <div class='error'><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'no_app_found'), $this);?>
</div>
    
<?php endif; ?>