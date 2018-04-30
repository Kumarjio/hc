<?php /* Smarty version 2.6.26, created on 2017-06-28 13:06:36
         compiled from admin/left_menu_users.tpl */ ?>
<div id="left_menu">

	<div class="menu_header">&nbsp;</div>
	<ul class="menu_body">
		<div class="menu_min_header">Job Seeker</div>
			<ul class="menu_body_body">
                <!--<li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employee.php">Manage Employee's</a></li>
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employee_pending.php">Profiles for Approval</a></li>-->
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employee_active.php">Active Users</a></li>
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employee_deactive.php">Inactive Users</a></li>
                <!--<li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/new_employee.php">Add a New Employee</a></li>-->
			</ul>
		<div class="menu_min_header">Owner</div>
			<ul class="menu_body_body">
                <!--<li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employer.php">Manage Employer's</a></li>
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/employer_pending.php">Profiles for Approval</a></li>-->
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employer_active.php">Active Users</a></li>
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/manage_employer_deactive.php">Inactive Users</a></li>
                <!-- <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/#">Pending user</a></li>
                <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/new_employer.php">Add a New Employer</a></li> -->
			</ul>

		<!-- <li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/#">Overview</a></li>
		<li><a href="<?php echo $this->_tpl_vars['BASE_URL']; ?>
admin/#">Mailing</a></li> -->
	</ul>
</div>