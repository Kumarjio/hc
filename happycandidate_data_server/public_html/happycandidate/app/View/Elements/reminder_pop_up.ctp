<script type="text/javascript">
var strTimeInt =  "";
$(document).ready(function () {
	fnCheckReminders();
	strTimeInt = setInterval(function(){ 
		fnCheckReminders()
	}, 50000);
});

function fnCheckReminders()
{
	//alert(appBaseU);
	//clearInterval(strTimeInt);
	
	
	
	var strUrl = appBaseU+"jstappointments/checkreminders/"+<?php echo $intPortalId; ?>;
	$.ajax({ 
			type: "POST",
			url: strUrl,
			cache: false,
			dataType:"json",
			success: function(data)
			{
				if(data.status == "success")
				{
					
					if(data.notifycount != "")
					{
						$('#notificationicon').removeClass('icon-notification-empty');
						$('#notificationicon').addClass('icon-notification');
					}
					else
					{
						$('#notificationicon').removeClass('icon-notification');
						$('#notificationicon').addClass('icon-notification-empty');
					}
					if(data.notifyhtml != "")
					{
						//alert(data.notifyhtml);
					
						$('.notification-block').html(data.notifyhtml);
					}
					
					
					/*if(data.contactshtml != "")
					{
						$('#reminder_container').html(data.contactshtml);
						$('.reminders').dialog('open');
					}
					else
					{
						$('#reminder_container').html('');
					}*/
				}
			}
	});
}
</script>
<div id="reminder_container" style="display:none;"></div>