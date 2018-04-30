<?php
	foreach($arrContactDetail as $arrContact)
	{
		$strContactDetailUrl = Router::url(array('controller'=>'jstcontacts','action'=>'contactdetail',$intPortalId,$arrContact['JstContacts']['jstcontacts_id']),true);
		$strAddAppointmentUrl = Router::url(array('controller'=>'jstappointments','action'=>'add',$intPortalId,$arrContact['JstContacts']['jstcontacts_id']),true);
		
		$strAddTaskUrl = Router::url(array('controller'=>'jsttasks','action'=>'add',$intPortalId,$arrContact['JstContacts']['jstcontacts_id']),true);
		
		$strAddNoteUrl = Router::url(array('controller'=>'jstnote','action'=>'add',$intPortalId,$arrContact['JstContacts']['jstcontacts_id']),true);
		
		?>
			<div class="line_up_td" id="contact_<?php echo $arrContact['JstContacts']['jstcontacts_id'];?>">
				<div class="line_up_thumb">
					<a href="javascript:void(0);">
						<img width="200" height="200" alt="Contact Pic"  src="<?php echo Router::url('/',true)."img/default.png";?>">
					</a>
				</div>
				<div class="line_up_title">
					<a title="<?php echo $arrContact['JstContacts']['jstcontacts_fname']; ?>" href="javascript:void(0);"><?php echo $arrContact['JstContacts']['jstcontacts_fname']." ".$arrContact['JstContacts']['jstcontacts_lname']; ?></a>
				</div>
				<div class="line_up_action">
					<a title="Detail View" class="view" href="<?php echo $strContactDetailUrl; ?>"><span class="ui-icon ui-icon-zoomin"></span></a>&nbsp;<a class="edit" title="Edit Contact" id="contact_edit_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" onclick="fnGetContactDetail(this,'0')" href="javascript:void(0);"><span class="ui-icon ui-icon-pencil"></span></a>
					<a title="Delete Contact" onclick="fnDeleteContact(this,'0')" class="delete" id="contact_del_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" href="javascript:void(0);"><span class="ui-icon ui-icon-minusthick"></span></a>&nbsp;<a class="addappointment" title="Add Appointment" href="<?php echo $strAddAppointmentUrl; ?>"><span class="ui-icon ui-icon-calendar"></span></a>&nbsp;<a class="addtask" title="Add Task" href="<?php echo $strAddTaskUrl; ?>"><span class="ui-icon ui-icon-gear"></span></a>&nbsp;<a class="addnote" title="Add Note" href="<?php echo $strAddNoteUrl; ?>"><span class="ui-icon ui-icon-note"></span></a>
				</div>
			</div>
		<?php
	}
?>