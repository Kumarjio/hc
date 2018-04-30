<?php /* Smarty version 2.6.26, created on 2015-10-27 12:18:51
         compiled from save_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'save_search.tpl', 3, false),)), $this); ?>

<?php if ($this->_tpl_vars['save_search'] && is_array ( $this->_tpl_vars['save_search'] )): ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'save_search'), $this);?>
</div>
<br />

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<br />
<?php $_from = $this->_tpl_vars['save_search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

<div class="round">
	<div class="app_job_title"><a href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo $this->_tpl_vars['i']['job_url']; ?>
'><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a></div>
    <div class='my_application_details'>
        <strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'saved_search_ref'), $this);?>
</strong> 
                <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
search_result/?<?php echo $this->_tpl_vars['i']['reference']; ?>
">
        <?php echo $this->_tpl_vars['i']['reference_name']; ?>
</a>
        <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'date_saved'), $this);?>
</strong> <?php echo $this->_tpl_vars['i']['created_at']; ?>

    </div>
    <a href="?action=delete&search_id=<?php echo $this->_tpl_vars['i']['id']; ?>
&portid=<?php echo $this->_tpl_vars['port_id']; ?>
">Delete</a>
</div>
<hr />

<?php endforeach; endif; unset($_from); ?>

<?php else: ?>
	<div class='error'><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'no_save_search'), $this);?>
</div>
<?php endif; ?>