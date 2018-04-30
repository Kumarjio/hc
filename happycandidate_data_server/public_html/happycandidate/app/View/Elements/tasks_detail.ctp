<table width="100%" id="contact_detail_<?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_id']; ?>">
	<tr>
		<td width="25%">Contact Name</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_fname']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Contact Email</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_email']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Contact Phone</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_contact_phone_no']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Action Date:</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_start_date']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Action Time</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_start_time']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Action End Date</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_end_date']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Action End Time</td>
		<td><?php echo $arrAppointmentList[0]['JstTasks']['jsttasks_end_time']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Action</td>
		<td><?php echo htmlspecialchars_decode(stripslashes($arrAppointmentList[0]['JstTasks']['jsttasks_description'])); ?></td>
	</tr>
</table>