<div class="index container-layout">
	<div id="page-title">
		<h3>Welcome to your Cpanel!</h3>
	</div>
	
	<div class="row">
		<div id="dashboard_content_container" style="float:left;width:100%;padding:5px;">
			<div id="portal_statistics" style="float:left;width:60%;margin-right:3%;">
				<div id="head" style="float:left;width:100%;margin-bottom:10px;"><h3>Quick Statistics</h3></div>
				<div id="content" style="float:left;width:100%;">
					<div id="portal_details" style="float:left;width:100%;">
						<div style="float:left;width:48%;margin-right:2%;"><label>New Orders for Current Month</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								$strRegistrantsUrl = Router::url(array('controller'=>'manageseekers','action'=>'index'),true);
								if($intPortalOwners)
								{
									?>
										<a href="javascript:void(0);"><?php echo $intPortalOwners; ?></a>
									<?php
								}
								else
								{
									?>
										<label>&nbsp;</label>
									<?php
								}
							?>
						</div>
						<div style="float:left;width:100%;">&nbsp;</div>
						<div style="float:left;width:48%;margin-right:2%;"><label>Total number of New Orders</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								if($intPortalCandidates)
								{
									$strAdminManageOwnerUrl = Router::url(array('controller'=>'manageowners','action'=>'index'),true);
									?>
										<a href="javascript:void(0);"><?php echo $intPortalCandidates; ?></a>
									<?php
								}
								else
								{
									?>
										<label>&nbsp;</label>
									<?php
								}
							?>
						</div>
					</div>
				</div>
				<div id="foot"></div>
			</div>
		</div>
	</div>
	
	
	<!--<table cellpadding="0" cellspacing="0">
	<tr>
			<th>id</th>
			<th>name</th>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>
	</table>-->
</div>

<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('New User', array('action' => 'add')); ?></li>
	</ul>
</div>-->