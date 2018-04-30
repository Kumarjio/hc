<?php /* Smarty version 2.6.26, created on 2017-11-20 15:22:30
         compiled from admin/job_overview.tpl */ ?>
<div class="header">Overview</div>

<?php if ($this->_tpl_vars['message'] != ""): ?> <?php echo $this->_tpl_vars['message']; ?>
 <?php endif; ?>

<p>
    <strong>Total Job Posting:</strong>  <?php echo $this->_tpl_vars['total_posting']; ?>

</p>

<table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs approved: </strong> <?php echo $this->_tpl_vars['total_active_approved']; ?>
</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_approval_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_today']+$this->_tpl_vars['total_not_active_approval_today']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_approval_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_week']+$this->_tpl_vars['total_not_active_approval_week']; ?>
</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_approval_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_approval_month']+$this->_tpl_vars['total_not_active_approval_month']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td><?php echo $this->_tpl_vars['total_active_approved']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_approved']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_approved']+$this->_tpl_vars['total_not_active_approved']; ?>
</td>
  </tr>
  
</table>


<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Pending: </strong> <?php echo $this->_tpl_vars['total_active_pending']; ?>
</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_pending_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_today']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_pending_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_week']; ?>
</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_pending_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_pending_month']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td><?php echo $this->_tpl_vars['total_active_pending']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_pending']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_pending']; ?>
</td>
  </tr>
  
</table>  

<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Rejected: </strong> <?php echo $this->_tpl_vars['total_active_rejected']; ?>
</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_rejected_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_today']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_rejected_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_week']; ?>
</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_rejected_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected_month']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td><?php echo $this->_tpl_vars['total_active_rejected']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_rejected']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_rejected']; ?>
</td>
  </tr>
  
</table>     


<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Expired: </strong> <?php echo $this->_tpl_vars['total_active_expired']; ?>
</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_expired_today']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_today']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_expired_week']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_week']; ?>
</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_expired_month']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_expired_month']; ?>
</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td><?php echo $this->_tpl_vars['total_active_expired']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_not_active_expired']; ?>
</td>
    <td><?php echo $this->_tpl_vars['total_active_expired']; ?>
</td>
  </tr>
  
</table>  