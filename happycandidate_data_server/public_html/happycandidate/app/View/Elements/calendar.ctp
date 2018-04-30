<?php
	echo $this->Html->css('cal/lib/cupertino/jquery-ui.min');
	echo $this->Html->css('cal/fullcalendar');
	//echo $this->Html->css('cal/fullcalendar.print');
	echo $this->Html->script('cal/lib/moment.min');
	echo $this->Html->script('cal/fullcalendar.min');
	
	//print("<pre>");
	//print_r($arrAppointmentList['event']);
	//exit;
	
	//print("<pre>");
	//print_r($arrAppointmentList);
	//exit;
	
	
	$str = json_encode($arrAppointmentList['event']);
	
?>

<script type="text/javascript">
	
	var strDate = '<?php echo date("Y-m-d"); ?>';
	
	<?php
		if($arrPpointDate)
		{
			?>
				strDate = '<?php echo $arrPpointDate; ?>';
			<?php
		}
	
	?>
	
	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultView: 'agendaDay',
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,agendaDay'
			},
			defaultDate: strDate,
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: jQuery.parseJSON('<?php echo $str; ?>'),
			dayClick: function(date, jsEvent, view) {
				$('#calendar').fullCalendar('gotoDate', date);
				$('#calendar').fullCalendar('changeView', 'agendaDay');
			},
			eventClick: function(calEvent, jsEvent, view) {
				
				//$('#calendar').fullCalendar('gotoDate', calEvent.start.format());
				//$('#calendar').fullCalendar('changeView', 'agendaDay');
				$('#apptid').val(calEvent.id);
				fnGetAppointmentDetailFromCal();

			}
		});
		
	});
</script>
<style>

	#calendar {
		max-width: 100%;
		margin: 0 auto;
	}
	
	.fc-left h2,.fc-center h2{
		background:none !important;
		padding-left:0;
		line-height:normal;
	}
	
	.fc-title {
		white-space:normal;
		cursor:pointer;
	}
	
	.fc-view table td {
		width:auto;
	}
	
	.fc-view table th {
		width:auto;
		font-size:14px;
		line-height:normal;
	}

</style>
<input type="hidden" name="apptid" id="apptid" value="" />
<div id='calendar'></div>