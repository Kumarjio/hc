<?php

	echo $this->Html->script('changepassword');
?>

      <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Change Password</h1>
	                        <div class="form-container">
		                     <?php 
		echo $this->Form->create('User',array('inputDefaults' => array(
																		'label' => false,
																		'div' => false
																	  )
											 )
								);
	?>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-3" for="new-password"> Old Password: <span class="form-required">*</span></label>
										<?php
											echo $this->Form->input('old_pass',array('type'=>'password','class'=>'validate[required] col-xs-12 col-sm-12 col-md-9'));
										?>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-3" for="new-password"> New Password: <span class="form-required">*</span></label>
										<?php 
											echo $this->Form->input('new_password',array('type'=>'password','class'=>'validate[required] col-xs-12 col-sm-12 col-md-9'));
										?>
									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-3" for="repeat-new-password">Repeat Password: <span class="form-required">*</span></label>
										<?php
					echo $this->Form->input('new_password_again', array('type'=>'password','class'=>'validate[required,equals[UserNewPassword]] col-xs-12 col-sm-12 col-md-9'));
				?>
									</div>
									<div class="form-group">
										<div class="hidden-xs hidden-sm col-md-3"></div>
										<div class="col-xs-12 col-sm-12 col-md-9 page-content-wrapper-buttons">
											<?php
					$options = array(
						'label' => 'Change',
						'name' => 'change',
						'class' => 'btn btn-primary'
						
					);
					echo $this->Form->end($options);
				?>
										</div>
									</div>
								
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	   
	<?php /*   
<div class="users index">
	<div class="edit-panel">
<div id="page-title">
	<h3>Change Password</h3>
</div>
	<?php 
		echo $this->Form->create('User',array('inputDefaults' => array(
																		'label' => false,
																		'div' => false
																	  )
											 )
								);
	?>
	<table cellpadding="0" cellspacing="0" width="58%" style="margin:auto;">
	<tr>
			<th colspan="2"><h3 class="page_header">Old Password</h3></th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Provide Your Old Password:</td>
			<td>
				<?php
					echo $this->Form->input('old_pass',array('type'=>'password','class'=>'validate[required]','style'=>'width:50%;font-size:90%;'));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" style="border:none;height:30px;">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">New Password</th>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Provide Your New Password:</td>
			<td>
				<?php 
					echo $this->Form->input('new_password',array('type'=>'password','class'=>'validate[required]','style'=>'width:50%;font-size:90%;'));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Type New Password Again:</td>
			<td>
				<?php
					echo $this->Form->input('new_password_again', array('type'=>'password','class'=>'validate[required,equals[UserNewPassword]]','style'=>'width:50%;font-size:90%;'));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Change',
						'name' => 'change',
						
					);
					echo $this->Form->end($options);
				?>
			</td>
	</tr>
	<!--<tr>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>-->
	</table>
</div>
</div>
*/?>

<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php //echo $this->Html->link('Edit Profile', array('action' => 'edit')); ?></li>
		<li><?php //echo $this->Html->link('Change Password', array('action' => 'changepassword')); ?></li>
	</ul>
</div>-->