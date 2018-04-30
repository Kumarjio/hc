<?php
	/*print("<pre>");
	print_r($arrCompleteLoggedInUserDetail);*/
?>

<div class="users index container-layout">

	<div id="page-title">	<h3>My Profile</h3></div>
	
	<iframe style="width:100%;height:1200px;border:none;" src="<?php echo $strEmployerProfileUrl;?>" ></iframe>
	
	<!--<table cellpadding="0" cellspacing="0">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td>User Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['username'];?></td>
	</tr>
	<tr>
			<td>First Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_user_fname'];?></td>
	</tr>
	<tr>
			<td>Last Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_user_lname'];?></td>
	</tr>
	<tr>
			<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Company Information</th>
	</tr>
	<tr>
			<td>Company Name:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_company_name'];?></td>
	</tr>
	<tr>
			<td>Industry Type:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['industry_name'];?></td>
	</tr>
	<tr>
			<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Contact Information</th>
	</tr>
	<tr>
			<td>Email Address:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['email'];?></td>
	</tr>
	<tr>
			<td>Contact Number:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_contact_number'];?></td>
	</tr>
	<tr>
			<td>Address:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_address'];?></td>
	</tr>
	<tr>
			<td>Country:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['country_name'];?></td>
	</tr>
	<tr>
			<td>State:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['state_name'];?></td>
	</tr>
	<tr>
			<td>City:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['city_name'];?></td>
	</tr>
	<tr>
			<td>Zip Code:</td>
			<td><?php echo $arrCompleteLoggedInUserDetail[0]['employer_pin'];?></td>
	</tr>
	<!--<tr>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>-->
	<!--</table>-->
</div>

<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Edit Profile', array('action' => 'edit')); ?></li>
		<li><?php echo $this->Html->link('Change Password', array('action' => 'changepassword')); ?></li>
	</ul>
</div>-->