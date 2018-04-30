<?php /* Smarty version 2.6.26, created on 2013-11-01 07:21:00
         compiled from employer/search_result.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/search_result.tpl', 4, false),)), $this); ?>
<?php if ($this->_tpl_vars['message'] != ""): ?> <br /><?php echo $this->_tpl_vars['message']; ?>
<br /> <?php endif; ?>

<?php if (is_array ( $this->_tpl_vars['list_cv'] ) && $this->_tpl_vars['list_cv'] != ""): ?>
  <div class="header"><?php echo smarty_function_lang(array('mkey' => 'header','skey' => 'CVSearchResults'), $this);?>
</div>
    <br /><br />
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <colgroup>
            <col />
            <col width="20%" />
            <col width="80%" />
            <col />
        </colgroup>
     <tr class="searchcv_nav">
        <td class="TableSRNav-L">&nbsp;</td>
        <td> &nbsp;&nbsp;<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Results'), $this);?>
: <?php echo $this->_tpl_vars['total_count']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'CV'), $this);?>
 </td>
        <td>
            <div class="sc_nav_">
                        </div>
        </td>
        <td class="TableSRNav-R">&nbsp;</td>
     </tr>
    </table>
    <br />

  <table width="100%" cellpadding="0" cellspacing="0" >
    <tr class="cv_search_tr">
     <td class="TableSC-L">&nbsp;</td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'name'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'CVTitle'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_title'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'JobStatus'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'RJobTitle'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'city'), $this);?>
: </td>
     <td><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'LastUpdated'), $this);?>
: </td>
     <td class="TableSC-R">&nbsp;</td>
    </tr>
    
<?php $_from = $this->_tpl_vars['list_cv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>

    <tr>
     <td colspan="2"><?php echo $this->_tpl_vars['i']['employee_name']; ?>
</td>
     <td><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/review_cv/?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;u=<?php echo $this->_tpl_vars['i']['employee_id']; ?>
"><?php echo $this->_tpl_vars['i']['cv_title']; ?>
</a></td>
     <td>
        <?php echo $this->_tpl_vars['i']['look_job_title']; ?>

        <br /><?php echo $this->_tpl_vars['i']['look_job_title2']; ?>

     </td>
     <td><?php echo $this->_tpl_vars['i']['look_job_status']; ?>
 </td>
     <td><?php echo $this->_tpl_vars['i']['recent_job_title']; ?>
 </td>
     <td><?php echo $this->_tpl_vars['i']['city']; ?>
</td>
     <td colspan="2"><?php echo $this->_tpl_vars['i']['modified_at']; ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>

  </table>
  
  <br />
  
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <colgroup>
            <col />
            <col width="20%" />
            <col width="80%" />
            <col />
        </colgroup>
     <tr class="searchcv_nav">
        <td class="TableSRNav-L">&nbsp;</td>
        <td> &nbsp;&nbsp;<?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'Results'), $this);?>
: <?php echo $this->_tpl_vars['total_count']; ?>
 <?php echo smarty_function_lang(array('mkey' => 'CV'), $this);?>
 </td>
        <td>
            <div class="sc_nav_">
                        </div>
        </td>
        <td class="TableSRNav-R">&nbsp;</td>
     </tr>
    </table>
  
<?php else: ?>
    <div class="error"><?php echo smarty_function_lang(array('mkey' => 'error','skey' => 'cvSearchNoResult'), $this);?>
</div>
<?php endif; ?>
    
  <a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/search/"><?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'backSearchP'), $this);?>
</a>  