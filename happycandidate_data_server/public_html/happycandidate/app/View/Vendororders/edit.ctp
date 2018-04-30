<?php
	echo $this->Html->script('admin_edit');
	
	//print("<pre>");
	//print_r($arrCompleteLoggedInUserDetail);
?>

<div class="users index">
<div class="edit-panel">
<div id="page-title">
	<h3>Edit Profile</h3>
</div>
	<?php 
		echo $this->Form->create('User',array('inputDefaults' => array(
		'label' => false,
		'div' => false
		)
		)
		);
	?>
	<table cellpadding="0" cellspacing="0" width="80%" style="margin:auto;">
	<tr>
			<td style="width:27%;">Vendor First Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorfname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_first_name']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Vendor Last Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorlname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_last_name']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Email Address:</td>
			<td>
				<?php echo $arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_email']; ?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Vendor Phone:</td>
			<td>
				<?php
					echo $this->Form->input('vendorphone',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_phone']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Vendor Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_name']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Password:</td>
			<td>
				<?php
					echo $this->Form->input('vendor_pass',array('type'=>'password','class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_password']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Confirm Password:</td>
			<td>
				<?php
					echo $this->Form->input('vendor_conf_pass',array('type'=>'password','class'=>'validate[required,equals[UserVendorPass]]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendors']['vendor_password']));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Edit',
						'name' => 'edit',
						
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