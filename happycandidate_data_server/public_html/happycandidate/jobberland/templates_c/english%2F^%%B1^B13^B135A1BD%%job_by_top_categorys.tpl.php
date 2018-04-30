<?php /* Smarty version 2.6.26, created on 2017-06-27 16:01:20
         compiled from job_by_top_categorys.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'job_by_top_categorys.tpl', 3, false),array('modifier', 'strip_tags', 'job_by_top_categorys.tpl', 7, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['job_by_cats'] ) && $this->_tpl_vars['job_by_cats'] != ""): ?>
    <div class="left_item">
     <div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'jobs_by_category'), $this);?>
</div> 
      <ul id="left_list_of_category">
      <?php $_from = $this->_tpl_vars['job_by_cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
        <li> <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
category/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/" title="<?php echo $this->_tpl_vars['i']['f_category_name']; ?>
">
        	<?php echo ((is_array($_tmp=$this->_tpl_vars['i']['category_name'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
 <span class='total_job'>(<?php echo $this->_tpl_vars['i']['total_num']; ?>
)</span> </a></li>
      <?php endforeach; endif; unset($_from); ?>
	 </ul>
    </div>
    <br />
<?php endif; ?>