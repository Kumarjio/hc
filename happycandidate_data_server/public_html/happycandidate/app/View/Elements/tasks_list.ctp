<?php
	//print("<pre>");
	//print_r($arrAppointmentList);exit;
	$intFrCnt = 0;
	foreach($arrAppointmentList as $arrAppointment)
	{
		$strContactDetailUrl = Router::url(array('controller'=>'jsttasks','action'=>'detail',$intPortalId,$arrAppointment['JstTasks']['jsttasks_id']),true);
		
		$strContactEditUrl = Router::url(array('controller'=>'jsttasks','action'=>'edit',$intPortalId,$arrAppointment['JstTasks']['jsttasks_id']),true);
		
		$intFrCnt++;
		?>
			<div style="width:95%;" class="line_up_td" id="contact_<?php echo $arrAppointment['JstTasks']['jsttasks_id'];?>">
				<div style="width:10%;height:40px;line-height:40px;" class="line_up_thumb"><a href="javascript:void(0);"><?php echo $intFrCnt;?></a></div>
				<div style="width:20%;" class="line_up_title">
					<a title="<?php echo $arrAppointment['JstTasks']['jsttasks_contact_fname']; ?>" href="javascript:void(0);"><?php echo $arrAppointment['JstTasks']['jsttasks_contact_fname']; ?></a>
				</div>
				<div style="width:20%;border:none;line-height:40px;" class="line_up_action"><?php echo $arrAppointment['JstTasks']['jsttasks_start_date']; ?></div>
				<div style="width:20%;border:none;line-height:40px;" class="line_up_action"><?php echo $arrAppointment['JstTasks']['jsttasks_start_time']; ?></div>
				<div style="width:20%;border:none;line-height:40px;" class="line_up_action">
					<a title="Detail View" class="view" href="<?php echo $strContactDetailUrl; ?>"><span class="ui-icon ui-icon-zoomin"></span></a>&nbsp;<a class="edit" title="Edit Contact" id="contact_edit_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" href="<?php echo $strContactEditUrl; ?>"><span class="ui-icon ui-icon-pencil"></span></a>
					<a title="Delete Contact" onclick="fnDeleteContact(this,'0')" class="delete" id="contact_del_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" href="javascript:void(0);"><span class="ui-icon ui-icon-minusthick"></span></a>
				</div>
			</div>
		<?php
	}
?>