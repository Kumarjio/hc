<table width="100%" id="contact_detail_<?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_id']; ?>">
	<tr>
		<td width="25%">Contact Name</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_fname']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Contact Email</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_email']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Contact Phone</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_contact_phone_no']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Note Title:</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_title']; ?></td>
	</tr>	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Note Date:</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_start_date']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Note Time</td>
		<td><?php echo $arrAppointmentList[0]['JstNotes']['jstnotes_start_time']; ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>Note Description:</td>
		<td><?php echo htmlspecialchars_decode(stripslashes($arrAppointmentList[0]['JstNotes']['jstnotes_description'])); ?></td>
	</tr>
</table>