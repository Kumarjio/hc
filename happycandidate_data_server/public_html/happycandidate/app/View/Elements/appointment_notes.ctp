<?php
	foreach($arrAppointmentNotes as $arrNote)
	{
		?>
			<p class="tabloader" id="note_loader_<?php echo $arrNote['JstNotes']['jstnotes_id'];?>" style="display:none;"></p>
			<div style="width:95%;" class="line_up_td" id="note_<?php echo $arrNote['JstNotes']['jstnotes_id'];?>">
				<div style="width:100%;text-align:left;margin-left:5px;height:auto;" class="line_up_title">
					<?php echo nl2br($arrNote['JstNotes']['jstnotes_description']); ?>
				</div>
				<div style="width:98%;border:none;text-align:right;margin-right:5px;" class="line_up_action">
					<a style="vertical-align:bottom;" title="Delete Note" onclick="fnDeleteAppoint(this,'0')" class="delete" id="note_del_<?php echo $arrNote['JstNotes']['jstnotes_id']; ?>" href="javascript:void(0);"><span class="ui-icon ui-icon-minusthick"></span></a>
				</div>
				<div style="width:98%;border:none;text-align:right;margin-right:5px;" class="line_up_action">
					<a style="vertical-align:bottom;font-weight:normal;font-style:italic;font-size:10px;" href="javascript:void(0);"><?php echo $arrNote['JstNotes']['jstnotes_start_date_time'];?></a>
				</div>
			</div>
		<?php
	}
?>