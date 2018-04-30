<?php
	echo $this->Html->script('vendor_payment_edit');
	
	//print("<pre>");
	//print_r($arrCompleteLoggedInUserDetail);
?>

<div class="users index">
<div class="edit-panel">
<div id="page-title">
	<h3>Edit Vendor Payment Details</h3>
</div>
	<?php 
		echo $this->Form->create('User',array('inputDefaults' => array(
		'label' => false,
		'div' => false
		)
		)
		);
	?>
	<table cellpadding="0" cellspacing="0" width="90%" style="margin:auto;">
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Payment Should Be Made Out To:</td>
			<td>
				<?php
					echo $this->Form->input('payoutto',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorpayout']['payout_to']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;">Tax ID Number:</td>
			<td>
				<?php
					echo $this->Form->input('taxid',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorpayout']['tax_id']));
				?>
			</td>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Minimum Check Amount:</td>
			<td>
				<?php
					echo $this->Form->input('minamt',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorpayout']['minimum_check_amt']));
				?>
			</td>
	</tr>
	<tr>
			<td>Commission Pct:</td>
			<td>
				<?php
					echo $this->Form->input('compct',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorpayout']['commission_pct']));
				?>
			</td>
	</tr>
	<tr>
			<td>Indeed Registration:</td>
			<td>
				<?php
					echo $this->Form->input('inreg',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['Vendorpayout']['indeed_registration']));
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