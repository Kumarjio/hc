<script type="text/javascript" src="/happycandidate/js/jquery/jquery.tablesorter.js"></script>
<?php $strRouter = Router::url('/',true);?>

<!-- CONTENT -->
<div class="container-fluid bg-lightest-grey">
	<!-- MODAL WELCOME -->
	<div id="welcome-modal" class="modal fade" role="dialog">
		<div class="modal-dialog-welcome">
			<!-- Modal content-->
			<div class="modal-content">
			  
				<div class="modal-body">
					
					<h1>Welcome to Job Search Tracker!</h1>
					
					<div class="row">
						<div class="col-md-1"></div>
						<p class="main col-md-10">The Job Seeker Tracker will organize your actions, retain information on your contacts and list your daily tasks and appointments.</p>
						<div class="col-md-1"></div>
					</div>
					
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<p>This tool will provide you with the following benefits:</p>
							<ul>
								<li>Greatly enhance your ability to identify and accept your next opportunity</li>
								<li>Track the level of activity necessary to obtain results</li>
								<li>Prevent you from duplicating your efforts</li>
								<li>Help you focus on best use of your time</li>
							</ul>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<p class="col-xs-12 col-sm-12 col-md-9">We have included the three phase Job Search Process which you should complete in order to conduct a successful job search.</p>
							<button type="button" class="btn btn-primary col-xs-12 col-sm-12 col-md-3" data-dismiss="modal">Let's Start</button>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL STEP 1 -->
	<div id="profile-modal" class="modal fade step-modal" role="dialog">
		<div class="modal-dialog">

			<div class="modal-content">
			  
				<div class="modal-body">
					<p id="popover" class="selected" href="#" data-toggle="popover" data-placement="right" >My Profile</p>
					<div id="popover-content" class="hide">
						<h3 class="col-md-10">Step 1</h3>
						<button type="button" class="close col-md-2" data-dismiss="modal">&times;</button>
						<p class="popover-paragraph col-md-12"><span>Click on the My Profile Tab at the top of this page and complete your information.</span></p>
						<a class="js-popup-indicator first-step col-md-8"></a>
						<a id="goto-step2" href="#" class="btn btn-primary col-md-4">Next</a>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end of modal step 1 -->

	<!-- MODAL STEP 2 -->
	<div id="job-search-modal" class="modal fade step-modal" role="dialog">
		<div class="modal-dialog">

			<div class="modal-content">
		  
				<div class="modal-body">
					<p id="popover-step2" href="#" data-toggle="popover-step2" data-placement="right" >Job Search</p>
					<div id="popover-step2-content" class="hide">
						<h3 class="col-md-10">Step 2</h3>
						<button type="button" class="close col-md-2" data-dismiss="modal">&times;</button>
						<p class="popover-paragraph col-md-12"><span>Click on the Job Search Process Tab at the top of this page and make a commitment to complete 100% of the steps under the Three Phase Process. This tab will lead to the three Phases of the Job Search with tabs for each of the 15 steps under Prepare, Search &amp; Connect and Interview.</span></p>
						<a class="js-popup-indicator second-step col-md-8"></a>
						<a id="goto-step3" href="#" class="btn btn-primary col-md-4">Next</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end of modal step 2 -->

	<div class="row">
            <!--<div id="delete_notification"></div>-->
		<div class="col-md-1"></div>

		<div class="col-md-10 bg-lightest-grey steps-list">
			<div class="page-header">
				<h2>Job Search Tracker</h2>
				<p>
					Welcome to the Job Search Tracker.  The Job Search Tracker will assist you in organizing your job search actions, retain important contact information and list your daily tasks and appointments.

					The Job Search Tracker will greatly enhance your ability to identify and accept your next opportunity, track the level of activity necessary to obtain results, prevent you from duplicating your efforts and help you focus on the best use of your time. 

				</p>
			</div>

			<ul class="nav nav-pills tab-list">
			
			
				<li class="active">
					<a id="js-contacts" data-toggle="pill" href="#tab-contacts">Contacts</a>
				</li>
				<li>
					<a id="js-appointments" data-toggle="pill" href="#tab-appointments">Appointments</a>
				</li>
				<li>
					<a id="js-calendar" data-toggle="pill" href="#tab-calendar">Calendar</a>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Tasks <span class="caret"></span></a>
					<ul class="dropdown-menu tab-dropdown">
						<li>
							<a id="js-task-all" data-toggle="pill" href="#tab-tasks" class="tab-dropdown-item">All</a><!--  -->
						</li>
						<li>
							<a id="js-task-today" data-toggle="pill" href="#tab-tasks" class="tab-dropdown-item">Today</a><!--  -->
						</li>
					</ul>
				</li>
				<!--<li>
					<a id="js-nostes" data-toggle="pill" href="#tab-notes">Notes</a>
				</li>-->
			</ul>
			<div class="tab-content" style="padding-top: 20px;">
				
				<div id="tab-contacts" class="tab-pane fade in active">
				</div>

				<div id="tab-appointments" class="tab-pane fade">
				</div>
				<div id="tab-calendar" class="tab-pane fade">
				</div>
				<div id="tab-tasks" class="tab-pane fade">
				</div>
				<div id="tab-notes" class="tab-pane fade">
					
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
<!-- END OF CONTENT -->
<script type="text/javascript">
	$(document).ready(function () {
		 fnGetContacts();
		
		$("a[data-toggle='pill']").click(function() {
		   
		   var strNewTab = $(this).attr('id');
		   
		   if(strNewTab == "js-contacts")
		   {
			 fnGetContacts();
		   }
		   
		else  if(strNewTab == "js-appointments")
		   {
			 fnGetAppointments();
		   }
		   
		  else if(strNewTab == "js-task-all")
		   {
			 fnGetAllTasks('0');
		   }
		   
		 else  if(strNewTab == "js-task-today")
		   {
			 fnGetAllTasks('1');
		   }
		   
		 else  if(strNewTab == "js-nostes")
		   {
			 fnGetNotes();
		   }
		  else  if(strNewTab == "js-calendar")
		   {
			 fnGetCalendar();
		   }
	   });
	});
	
function fnGetNotes(strToday)
{
$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	var strContentId = "<?php echo $intPortalId;?>";
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"jstnote/getNoteshtml/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('#tab-notes').html(data.html);
				}
				else
				{
					
				}
					$('.cms-bgloader-mask').hide();//show loader mask
	 	  $('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnGetCalendar()
{
$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	var strContentId = "<?php echo $intPortalId;?>";
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"jstnote/calendar/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('#tab-calendar').html(data.html);
				}
				else
				{
					
				}
					$('.cms-bgloader-mask').hide();//show loader mask
	 	  $('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnGetAllTasks(strToday)
{
$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	var strContentId = "<?php echo $intPortalId;?>";
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"jsttasks/getalltaskshtml/"+strContentId+"/"+strToday,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('#tab-tasks').html(data.html);
				}
				else
				{
					
				}
					$('.cms-bgloader-mask').hide();//show loader mask
                                        $('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnGetContacts()
{
	var strContentId = "<?php echo $intPortalId;?>";
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"jstcontacts/getcontactshtml/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('#tab-contacts').html(data.html);
				}
				else
				{
					
				}
				$('.cms-bgloader-mask').hide();//show loader mask
	 	  $('.cms-bgloader').hide(); //show loading image
			}
	});
}

function fnGetAppointments()
{
	var strContentId = "<?php echo $intPortalId;?>";
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"jstappointments/getappointmentshtml/"+strContentId,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
					//alert(data.content)
					$('#tab-appointments').html(data.html);
				}
				else
				{
					
				}
					$('.cms-bgloader-mask').hide();//show loader mask
	 	  $('.cms-bgloader').hide(); //show loading image
			}
	});
}
</script>