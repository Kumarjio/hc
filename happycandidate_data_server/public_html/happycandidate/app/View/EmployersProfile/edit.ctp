<?php

	echo $this->Html->script('employer_edit');
?>
<div class="users index  container-layout">
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
	<table cellpadding="0" cellspacing="0" width="58%" style="margin:auto;">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>User Name:</td>
			<td>
				<?php
					echo $this->Form->input('username',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['username']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>First Name:</td>
			<td>
				<?php 
					echo $this->Form->input('firstname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['employer_user_fname']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span> Last Name:</td>
			<td>
				<?php 
					echo $this->Form->input('lastname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['employer_user_lname']));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" style="border:none;height:30px;">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Company Information</th>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Company Name:</td>
			<td>
				<?php 
					echo $this->Form->input('company_name',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['employer_company_name']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Industry Type:</td>
			<td>
				<?php
					echo $this->Form->input('industry_type', array('class'=>'validate[required]','style'=>'font-size:90%;','options'=>$arrIndustryList,'selected'=>$arrCompleteLoggedInUserDetail[0]['employer_industry_type']));
				?>
			</td>
	</tr>
	<tr>
			<td colspan="2" style="border:none;height:30px;">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Contact Information</th>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Email Address:</td>
			<td>
				<?php 
					echo $this->Form->input('emailaddress',array('class'=>'validate[required,custom[email]]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['email']));
				?>
			</td>
	</tr>
	<tr>
			<td>Contact Number:</td>
			<td>
				<?php 
					echo $this->Form->input('contact_number',array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['employer_contact_number']));
				?>
			</td>
	</tr>
	<tr>
			<td>Address:</td>
			<td>
				<?php 
					echo $this->Form->input('address', array('style'=>'width:50%;font-size:90%;','rows' => '5', 'cols' => '5','value'=>$arrCompleteLoggedInUserDetail[0]['employer_address']));
				?>
			</td>
	</tr>
	<tr>
			<td>Country:</td>
			<td>
				<?php 
					echo $this->Form->input('country', array('onChange'=>'fnGetStateList(this.value)','style'=>'font-size:90%;','options'=>$arrCountryList,'selected'=>$arrCompleteLoggedInUserDetail[0]['country_id']));
				?>
			</td>
	</tr>
	<tbody id="state_city">
	<tr>
			<td>State:</td>
			<td>
				<?php 
					echo $this->Form->input('state', array('onChange'=>'fnGetCityList(this.value)','style'=>'font-size:90%;','options'=>$arrStateList,'selected'=>$arrCompleteLoggedInUserDetail[0]['state_id']));
				?>
			</td>
	</tr>
	<tr id="city">
			<td>City:</td>
			<td>
				<?php 
					echo $this->Form->input('city', array('style'=>'font-size:90%;','options'=>$arrCityList,'selected'=>$arrCompleteLoggedInUserDetail[0]['city_id']));
				?>
			</td>
	</tr>
	</tbody>
	<tr>
			<td>Zip Code:</td>
			<td>
				<?php 
					echo $this->Form->input('zipcode', array('style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['employer_pin']));
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

<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Edit Profile', array('action' => 'edit')); ?></li>
		<li><?php echo $this->Html->link('Change Password', array('action' => 'changepassword')); ?></li>
	</ul>
</div>-->