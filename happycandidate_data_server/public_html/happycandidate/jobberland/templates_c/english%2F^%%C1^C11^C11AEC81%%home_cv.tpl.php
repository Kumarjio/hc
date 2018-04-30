<?php /* Smarty version 2.6.26, created on 2013-10-31 08:13:34
         compiled from home_cv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'home_cv.tpl', 3, false),array('modifier', 'upper', 'home_cv.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['mySingleCV']): ?>

<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'my_cv'), $this);?>
</div>

<table width="100%" style="border:1px solid #CCC;" cellpadding="5" cellspacing="2">

<tr>
  <td colspan="2"><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/resume/<?php echo $this->_tpl_vars['cvid']; ?>
/change/"><?php echo $this->_tpl_vars['cv_title']; ?>
</a></td>
</tr>

<tr>
  <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ac_status'), $this);?>
: </strong></td>
  <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cv_status'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</td>
</tr>

<tr>
  <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'employerViews'), $this);?>
: </strong></td>
  <td><?php echo $this->_tpl_vars['cvno_views']; ?>
</td>
</tr>

<tr>
  <td><strong><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'last_modified'), $this);?>
: </strong></td>
  <td><?php echo $this->_tpl_vars['cvmodified_at']; ?>
</td>
</tr>

</table>

<div style="float:right; padding-right:10px;">
  <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'manageCV'), $this);?>
</a>
</div>

<?php else: ?>
	
  <?php if ($this->_tpl_vars['my_cvs'] && is_array ( $this->_tpl_vars['my_cvs'] )): ?>
	<div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'my_cv'), $this);?>
</div>
  
    <div style="background:#999; padding-top:5px;">
    <?php $_from = $this->_tpl_vars['my_cvs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
	   
       <div style="border:5px solid #CCC; background:#FFF; padding:5px; width:90%; margin:0 auto; margin-bottom:5px;">
        
        <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/resume/<?php echo $this->_tpl_vars['i']['id']; ?>
/change/"><?php echo $this->_tpl_vars['i']['cv_title']; ?>
</a>
        <br /><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['cv_status'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

        
       </div>
    <?php endforeach; endif; unset($_from); ?>
    
     <div style=" padding:10px; clear:both;">
  	  <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'manageCV'), $this);?>
</a>
	 </div>
     
    </div>
    
   <?php else: ?>
   
   	 <p>
        <?php echo smarty_function_lang(array('mkey' => 'cv','skey' => 'cv_info_3'), $this);?>
 <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
curriculum_vitae/add/"><?php echo smarty_function_lang(array('mkey' => 'account','skey' => 'link_new_cv'), $this);?>
</a>
     </p>
   <?php endif; ?>
    
<?php endif; ?>