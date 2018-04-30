<?php /* Smarty version 2.6.26, created on 2014-01-06 07:18:55
         compiled from latest_job_inc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'latest_job_inc.tpl', 4, false),)), $this); ?>
<?php if (is_array ( $this->_tpl_vars['latest_job'] ) && $this->_tpl_vars['latest_job'] != ""): ?>
    <div id="spotlight_jobs" >
      
      <p><?php echo smarty_function_lang(array('mkey' => 'latest_job'), $this);?>
</p>
        
    <?php $_from = $this->_tpl_vars['latest_job']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
	   <?php if ($this->_tpl_vars['i']['job_title'] != ''): ?>
        <div class='spotlight' style="width:<?php echo $this->_tpl_vars['size']; ?>
%;">
            <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['job_id']; ?>
/?portid=<?php echo $this->_tpl_vars['intPortId']; ?>
"><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a>    
            <br /><?php echo $this->_tpl_vars['i']['job_description']; ?>

            <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'location'), $this);?>
</strong><?php echo $this->_tpl_vars['i']['location']; ?>

            <br /><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'posted_on'), $this);?>
 </strong><?php echo $this->_tpl_vars['i']['created_at']; ?>

        </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['i']['new_line'] == 1): ?><div class='clearit'>&nbsp;</div><br /><?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
     <div class="clearit" />&nbsp;</div>
    </div>
<?php endif; ?>