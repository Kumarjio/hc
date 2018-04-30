<?php /* Smarty version 2.6.26, created on 2013-10-31 08:13:34
         compiled from home_application.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'home_application.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['application']): ?>

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'jobAppHis'), $this);?>
</div>

<div style="border:1px solid #CCC; clear:both; padding-left:3px;">

    <?php $_from = $this->_tpl_vars['application']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
      <div>
       <a href='<?php echo $this->_tpl_vars['BASE_URL']; ?>
<?php echo $this->_tpl_vars['i']['job_url']; ?>
'><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a>
       <br /><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'datePosted'), $this);?>
: <?php echo $this->_tpl_vars['i']['created_at']; ?>

       <br /><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'appliedOn'), $this);?>
: <?php echo $this->_tpl_vars['i']['date_apply']; ?>

      </div>
      <br />
    <?php endforeach; endif; unset($_from); ?>

 <div class="button" style="width:180px; padding:3px;">
  <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
applications/"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'viewAllAppHis'), $this);?>
</a>
 </div>


</div>
<?php else: ?>
  <?php endif; ?>