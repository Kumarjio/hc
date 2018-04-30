<div class="index container-layout">
	<div id="page-title">
		<h3>Your Profile</h3>
	</div>
	<div class="row">
	<table cellpadding="0" cellspacing="0" class="table text-center">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td class="font-bold">User Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['username'];?></td>
	</tr>
	<tr>
			<td class="font-bold">First Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['admin_fname'];?></td>
	</tr>
	<tr>
			<td class="font-bold">Last Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['admin_lname'];?></td>
	</tr>
	<tr>
			<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Contact Information</th>
	</tr>
	<tr>
			<td class="font-bold">Email Address:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['email'];?></td>
	</tr>
	<tr>
			<td class="font-bold">Contact Number:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['admin_contact_number'];?></td>
	</tr>
	<tr>
			<td class="font-bold">Address:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['admin_address'];?></td>
	</tr>
	<tr>
			<td class="font-bold">Country:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['country_name'];?></td>
	</tr>
	<tr>
			<td class="font-bold">State:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['state_name'];?></td>
	</tr>
	<tr>
			<td class="font-bold">City:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['city_name'];?></td>
	</tr>
	<tr>
			<td class="font-bold">Zip Code:</td>
			<td>411019</td>
	</tr>
	<!--<tr>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>-->
	</table>
	</div>
</div>

<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Edit Profile', array('action' => 'edit')); ?></li>
		<li><?php echo $this->Html->link('Change Password', array('action' => 'changepassword')); ?></li>
	</ul>
</div>