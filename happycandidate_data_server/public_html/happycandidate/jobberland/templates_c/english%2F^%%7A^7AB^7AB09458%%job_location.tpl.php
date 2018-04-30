<?php /* Smarty version 2.6.26, created on 2013-10-30 07:56:21
         compiled from job_location.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'job_location.tpl', 2, false),array('modifier', 'strip_tags', 'job_location.tpl', 2, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['location'] ) && $this->_tpl_vars['location'] != ""): ?>
	<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'browse_by_1_sub'), $this);?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['location_name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</div>
    <ul class="browse">
    <?php $_from = $this->_tpl_vars['location']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
        <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['job_name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
<?php else: ?>
	<div class="error"><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'browse_not_found_1'), $this);?>
</div>
<?php endif; ?>