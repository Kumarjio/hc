<?php /* Smarty version 2.6.26, created on 2017-07-01 00:26:33
         compiled from admin/manage_employer_deactive.tpl */ ?>
<div class="page_header">Manage Owner(s) </div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<?php if ($this->_tpl_vars['manage_lists'] && is_array ( $this->_tpl_vars['manage_lists'] )): ?>

<form action="" method="post" name="frm_manage_employers" id="frm_manage_employers" >
<p>
    Actions with Selected:<br>
    <input value="Activate" class="button" name="activate_all" type="submit">
    <input value="Delete" class="delete-button"  name="delete_all"
        onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;" type="submit">
    <input value="Add Credits" class="button" name="credits_all" type="submit">
</p>

<?php if (isset ( $_POST['reject_all'] )): ?>
    <strong>Reject Reason: </strong><br /><textarea name="reject_reason"></textarea>
    <input type="submit" name="reject_reason_btn" value="Submit Reject" />
<?php endif; ?>

<?php if (isset ( $_POST['repost_btn'] )): ?>
    Enter New date:
    <input type="text" name="txt_repost_date" value="" /> Leave it blank if posted from current time
    <br /><br />
<?php endif; ?>

<?php if (isset ( $_POST['credits_all'] )): ?>
    # Credits to add: <input type="text" name="txt_credits" value="" size="30" /><br />
    <input value="Add CV Credits" class="button" name="cv_credit_all" type="submit">
    <input value="Add Spotlight Credits" class="button" name="spotlight_credit_all" type="submit">
    <input value="Add Job Credits" class="button" name="job_credit_all" type="submit">
    <br /><br />
<?php endif; ?>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
<colgroup>
    <col />
    <col width="20%" />
    <col width="80%" />
    <col />
</colgroup>
<tr class="searchcv_nav">
<td class="TableSRNav-L">&nbsp;</td>
<td> &nbsp;&nbsp;Results: <?php echo $this->_tpl_vars['total_count']; ?>
 Owner(s) </td>
<td>
    <div class="nav">
     <?php if ($this->_tpl_vars['total_pages'] > 1): ?>
        <?php if ($this->_tpl_vars['has_previous_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['previous_page']; ?>
">&laquo; Previous</a> 
        <?php else: ?>
        	    &laquo; Previous
        <?php endif; ?>
		
        <?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['start'] = (int)1;
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['total_pages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
if ($this->_sections['page']['start'] < 0)
    $this->_sections['page']['start'] = max($this->_sections['page']['step'] > 0 ? 0 : -1, $this->_sections['page']['loop'] + $this->_sections['page']['start']);
else
    $this->_sections['page']['start'] = min($this->_sections['page']['start'], $this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] : $this->_sections['page']['loop']-1);
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = min(ceil(($this->_sections['page']['step'] > 0 ? $this->_sections['page']['loop'] - $this->_sections['page']['start'] : $this->_sections['page']['start']+1)/abs($this->_sections['page']['step'])), $this->_sections['page']['max']);
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>
            <?php if ($this->_sections['page']['index'] == $this->_tpl_vars['page']): ?>
                <span class="selected"><?php echo $this->_sections['page']['index']; ?>
</span>
            <?php else: ?>
                <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_sections['page']['index']; ?>
"><?php echo $this->_sections['page']['index']; ?>
</a> 
            <?php endif; ?>
        <?php endfor; endif; ?>

        
        <?php if ($this->_tpl_vars['has_next_page']): ?> 
            <a href="?<?php if ($this->_tpl_vars['query'] != ''): ?><?php echo $this->_tpl_vars['query']; ?>
&amp;<?php endif; ?>page=<?php echo $this->_tpl_vars['next_page']; ?>
">Next &raquo;</a> 
        <?php else: ?> Next &raquo;<?php endif; ?>
    <?php endif; ?>
    </div>
</td>
<td class="TableSRNav-R">&nbsp;</td>
</tr>
</table>
<br />
  <table width="100%" cellpadding="5" cellspacing="1" class="tb_table">
    <tr>
      <td class="tb_col_head"><input type="checkbox" name="all_chk" onclick="checkUncheckAll(this);"  /></td>
     <!--<td class="tb_col_head">Username</td>-->
      <td class="tb_col_head">First Name</td>
      <td class="tb_col_head">Last Name</td>
      <td class="tb_col_head">Portal Name</td>
      <td class="tb_col_head">Email / Username</td>
      <td class="tb_col_head">Total CV(s)</td>
      <td class="tb_col_head">Total Standard Job(s)</td>
      <td class="tb_col_head">Total Spotlight Job(s)</td>
      
      <td class="tb_col_head">Registration Date</td>
      <td class="tb_col_head">Last Login</td>
      <td class="tb_col_head">Status</td>
      <td class="tb_col_head">Action </td>
    </tr>
<?php $_from = $this->_tpl_vars['manage_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
 
    <tr>
      <td class="tb_col_data">
        <input type="checkbox" name="employer_id[]" value="<?php echo $this->_tpl_vars['i']['id']; ?>
" 
            <?php if (isset ( $this->_tpl_vars['employer_id'] ) && is_array ( $this->_tpl_vars['employer_id'] )): ?> 
            	<?php if (in_array ( $this->_tpl_vars['i']['id'] , $this->_tpl_vars['employer_id'] )): ?> checked="checked"<?php endif; ?>
             <?php endif; ?> />
       
      </td>
      <!--<td class="tb_col_data"><?php echo $this->_tpl_vars['i']['username']; ?>
</td>-->
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['fname']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['lname']; ?>
</td>
      <td class="tb_col_data">
		<?php if ($this->_tpl_vars['i']['employer_portal_name']): ?>
			<a href="<?php echo $this->_tpl_vars['i']['employer_portal_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['i']['employer_portal_name']; ?>
</a>
		<?php endif; ?>
	  </td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['email_address']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['cv_qty']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['job_qty']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['spotlight_qty']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['date_register']; ?>
</td>
      <td class="tb_col_data"><?php echo $this->_tpl_vars['i']['last_login']; ?>
</td>
      <td class="tb_col_data"><?php if ($this->_tpl_vars['i']['is_active'] == 'Y'): ?> Active<?php else: ?>Not Active<?php endif; ?></td>
      <td class="tb_col_data">
      
		<div id="menu_nav">
            <ul>
               <li><a href="#">Action</a>
                <ul id="user_nav">
                    <?php if ($this->_tpl_vars['i']['is_active'] == 'Y'): ?>
                        <li><a href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=deactivate">Deactivate</a></li>
                    <?php else: ?>
                        <li><a href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=activate">Activate</a></li>
                    <?php endif; ?>
                    <li><a href="edit_employer.php?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=edit">Edit</a></li>
                    <li><a href="?id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;action=delete" onclick="if ( !confirm('Are you sure you want to delete this listing?') ) return false;">Delete</a></li>
                    <li><a href="new_job.php?employer_id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;username=<?php echo $this->_tpl_vars['i']['username']; ?>
">Post new job</a></li>
                    <!--
                    <li><a href="employee_view.php?employer_id=<?php echo $this->_tpl_vars['i']['id']; ?>
&amp;username=<?php echo $this->_tpl_vars['i']['username']; ?>
">View Employer Profile</a></li>
                    -->
                </ul>
               </li>
             </ul>
		 </div>
               
      </td>
    </tr>
  <?php endforeach; endif; unset($_from); ?> 
  </table>	
 </form>   
<?php else: ?>
    No Listing Found.
<?php endif; ?>
