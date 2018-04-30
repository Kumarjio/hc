<?php
	echo $this->Html->script('vendor_company_edit');
	
	//print("<pre>");
	//print_r($arrCompleteLoggedInUserDetail);
?>

<div class="users index">
<div class="edit-panel">
<div id="page-title">
	<h3>Edit Vendor Company Details</h3>
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
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Company Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorcname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['company_name']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>First Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorfname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_f_name']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Last Name:</td>
			<td>
				<?php
					echo $this->Form->input('vendorlname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_l_name']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Email Address:</td>
			<td>
				<?php
					echo $this->Form->input('vendorcemail',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_email']));
				?>
			</td>
	</tr>
	<tr>
			<td>Address:</td>
			<td>
				<textarea name="vendor_company_address" id="vendor_company_address"><?php echo stripslashes($arrProductContent['0']['Vendorcompany']['address']); ?></textarea>
			</td>
	</tr>
	<tr>
			<td>City:</td>
			<td>
				<?php
					echo $this->Form->input('city',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['city']));
				?>
			</td>
	</tr>
	<tr>
			<td>State:</td>
			<td>
				<?php
					echo $this->Form->input('state',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['state']));
				?>
			</td>
	</tr>
	<tr>
			<td>Zip:</td>
			<td>
				<?php
					echo $this->Form->input('zip',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['zip']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Phone:</td>
			<td>
				<?php
					echo $this->Form->input('vendorcphone',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['phone']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Fax:</td>
			<td>
				<?php
					echo $this->Form->input('vendorfax',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['fax']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Web Address:</td>
			<td>
				<?php
					echo $this->Form->input('vendorwaddress',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['vendor_phone']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Billing Phone:</td>
			<td>
				<?php
					echo $this->Form->input('vendorbphone',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorcompany']['billing_phone']));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Save',
						'name' => 'edit',
						
					);
					echo $this->Form->end($options);
				?>
			</td>
	</tr>
	</table>
</div>
</div>