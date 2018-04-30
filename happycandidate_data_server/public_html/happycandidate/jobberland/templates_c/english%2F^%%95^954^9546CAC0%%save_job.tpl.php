<?php /* Smarty version 2.6.26, created on 2013-10-30 07:48:39
         compiled from save_job.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'save_job.tpl', 3, false),)), $this); ?>

<?php if ($this->_tpl_vars['save_job'] && is_array ( $this->_tpl_vars['save_job'] )): ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'my_save_job'), $this);?>
</div>
<br />

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<br />
<?php $_from = $this->_tpl_vars['save_job']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'date_saved'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['date_saved']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_cn'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['contact_name']; ?>

        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'app_ce'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['poster_email']; ?>

        <br /><a href='?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;job_id=<?php echo $this->_tpl_vars['i']['job_id']; ?>
&amp;delete=true'><?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'delete'), $this);?>
</a>
    </div>
</div>

<hr />
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<div class='error'><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'no_save_job'), $this);?>
</div>
<?php endif; ?>