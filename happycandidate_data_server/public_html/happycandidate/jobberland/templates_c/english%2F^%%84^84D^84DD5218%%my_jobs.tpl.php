<?php /* Smarty version 2.6.26, created on 2015-10-22 18:46:01
         compiled from employer/my_jobs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'employer/my_jobs.tpl', 16, false),)), $this); ?>
<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<?php if ($this->_tpl_vars['manage_list'] != ''): ?>
<div class="page_header">Portal Jobs Details </div><br></br>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" id="myjob">
    <colgroup>
        <col width="10%" />
        <col width="40%" />
        <col width="15%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
    </colgroup>
    
   <tr class="myjob_header">
    <th class="left_black"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'JobId'), $this);?>
:</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'job_title'), $this);?>
: </th>
	<th>Listing Type</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'posted_on'), $this);?>
:</th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'NoofViews'), $this);?>
: </th>
    <th><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'NoofApp'), $this);?>
:</th>
    <th class="right_black"><?php echo smarty_function_lang(array('mkey' => 'label','skey' => 'ApprovalStatus'), $this);?>
:</th>
  </tr>

<?php $_from = $this->_tpl_vars['manage_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
    <tr>
        <td ><strong> #<?php echo $this->_tpl_vars['i']['id']; ?>
</strong></td>
        <td>
            <a target="_blank" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['var_name']; ?>
/"><?php echo $this->_tpl_vars['i']['job_title']; ?>
</a>
            <br />            <br />
                <a class="tb_link" target="_blank" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
job/<?php echo $this->_tpl_vars['i']['id']; ?>
/"><?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'view_details'), $this);?>
</a> | 
                <a class="tb_link" href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
employer/editjob/<?php echo $this->_tpl_vars['i']['id']; ?>
"><?php echo smarty_function_lang(array('mkey' => 'edit'), $this);?>
</a> | 
                <a class="tb_link" onclick="if ( !confirm('Are you sure you went to clone this job?\n\n'
                			 +' You currently have <?php if ($this->_tpl_vars['i']['spotlight'] == 'Y'): ?> <?php echo $this->_tpl_vars['spotlight_credit']; ?>
 spotlight post <?php else: ?> <?php echo $this->_tpl_vars['standard_credit']; ?>
 post <?php endif; ?> credit(s)\n '
                			+'1 <?php if ($this->_tpl_vars['i']['spotlight'] == 'Y'): ?> spotlight post <?php else: ?> standard post <?php endif; ?>credit will be used' ) ) return false;" 
                	href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=clone"><?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'clone'), $this);?>
</a> | 
                <?php if ($this->_tpl_vars['i']['is_active'] == 'Y'): ?>
                <a class="tb_link" href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=deactivate"><?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'deactivate'), $this);?>
</a> | 
                <?php else: ?>
                 <a class="tb_link" href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=activate"><?php echo smarty_function_lang(array('mkey' => 'e_link','skey' => 'activate'), $this);?>
</a> |   
         		<?php endif; ?>
                <a class="tb_link" onclick="if ( !confirm('Are you sure you went to delete this job?') ) return false;"
                    href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=delete"><?php echo smarty_function_lang(array('mkey' => 'button','skey' => 'delete'), $this);?>
</a> 
            <br />            <br />
        </td>
		<td>
			<?php if ($this->_tpl_vars['i']['spotlight'] == 'Y'): ?>
				Spotlight Job
			<?php else: ?>
				Standard Job
			<?php endif; ?>
		</td>
        <td><?php echo $this->_tpl_vars['i']['created_at']; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']['views_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']['apply_count']; ?>
</td>
        <td><?php echo $this->_tpl_vars['i']['job_status']; ?>

        	<br /><?php echo $this->_tpl_vars['i']['reason']; ?>

            <?php echo $this->_tpl_vars['i']['admin_comments']; ?>

        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php else: ?>
<div> <?php echo smarty_function_lang(array('mkey' => 'errormsg','skey' => 66), $this);?>
 </div>
<?php endif; ?>