<?php /* Smarty version 2.6.26, created on 2013-10-30 07:55:50
         compiled from category.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'category.tpl', 3, false),array('modifier', 'strip_tags', 'category.tpl', 7, false),)), $this); ?>

<?php if (is_array ( $this->_tpl_vars['cat'] ) && $this->_tpl_vars['cat'] != ""): ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'browse_by_3'), $this);?>
</div>

    <ul class="browse">    
        <?php $_from = $this->_tpl_vars['cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
            <li> <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
category/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['cat_name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
 ( <?php echo $this->_tpl_vars['i']['total']; ?>
 )</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
<?php else: ?>
		not found
<?php endif; ?>