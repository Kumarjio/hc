<?php /* Smarty version 2.6.26, created on 2013-10-31 08:13:34
         compiled from home_recommendedJob.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'home_recommendedJob.tpl', 2, false),)), $this); ?>
<?php if ($this->_tpl_vars['recommendedJobs'] && is_array ( $this->_tpl_vars['recommendedJobs'] )): ?>
<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'recommendedJob'), $this);?>
</div>
<div style="border:1px solid #CCC; padding-left:3px;">
   
    <?php $_from = $this->_tpl_vars['recommendedJobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
		<div class="clear_it">
        <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/"><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a> 
        <br /><?php echo $this->_tpl_vars['i']['company_name']; ?>

        <br /><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'posted'), $this);?>
: <?php echo $this->_tpl_vars['i']['created_at']; ?>

        <br /><?php echo $this->_tpl_vars['i']['location']; ?>

        </div>
        <br />
    <?php endforeach; endif; unset($_from); ?>
  
 <div class="button" style="width:180px; padding:3px;">
   <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
search_result/?q=<?php echo $this->_tpl_vars['cvJob_title']; ?>
&amp;location=<?php echo $this->_tpl_vars['cvJob_city']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'viewAllReJob'), $this);?>
</a>
 </div>
</div>   

<?php else: ?>
   
<?php endif; ?>
 