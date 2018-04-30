<!--<script type="text/javascript" src="/happycandidate/js/jquery/jquery.tablesorter.js"></script>-->
<div class="tab-header">
    <h3>Appointments</h3><!--
    --><button type="button" onclick="fnLoadAppointmentAdder()" class="btn btn-primary btn-sm">Add New</button>
</div>
<?php echo $this->Session->flash(); ?>
<div id="delete_notification"></div>
<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
<div class="tab-row-container">
    <!--<div class="tab-filters">
            <a href="#" class="active">All <span>(5)</span></a> |
            <a href="#" class="link-primary">New <span>(1)</span></a> |
            <a href="#" class="link-primary">Completed <span>(4)</span></a> |
            <a href="#" class="link-primary">Drafted <span>(1)</span></a> |
            <a href="#" class="link-warning">Trashed <span>(4)</span></a>
    </div>
    <div class="tab-search">
            <input type="text" value="" name="search" placeholder="Search">
            <button type="button" class="btn btn-default btn-md">Search</button>
    </div>-->
</div>
<!-- APPOINTMENTS TOP CONTROLS -->
<div class="tab-row-container">
    <!-- <div class="tab-contacts-controls"> -->
    <!--<div class="tab-controls-actions">
            <div class="form-group">
                    <select name="bulk-actions" title="Bulk Actions">
                            <option value="value1">Bulk Action1</option>
                            <option value="value2">Bulk Action2</option>
                            <option value="value3">Bulk Action3</option>
                            <option value="value4">Bulk Action4</option>
                    </select>
                    <button type="button" class="btn btn-default btn-md">Apply</button>
            </div>
            <div class="form-group">
                    <select name="date-filter" title="Date Filter">
                            <option value="value1">Date Filter1</option>
                            <option value="value2">Date Filter2</option>
                            <option value="value3">Date Filter3</option>
                            <option value="value4">Date Filter4</option>
                    </select>
                    <button type="button" class="btn btn-default btn-md">Filter</button>
            </div>
    </div>
    <div class="tab-controls-pagination">
            <button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
            <button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
            <button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
            <input type="text" value="" name="input-page-number" placeholder="1">
            <button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
            <button type="button" class="btn btn-default goto-next-active"><span></span></button>
            <button type="button" class="btn btn-default goto-end-active"><span></span></button>
    </div>-->
    <!-- </div> -->
    
    <!--Extra add button here-->
    <div class="tab-contacts-controls"> 
        <div class="tab-controls-actions">
            <div class="form-group">
                <button type="button" class="btn btn-default btn-md" onclick="fnDeleteAllAppointments();">Delete</button>
            </div>
        </div>
    </div> 
</div>
<!-- APPOINTMENTS CONTENT -->
<div class="tab-row-container">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-heading appointments">
           <table class="tablesorter" id="appointment_list">
                <thead>
                <tr>
                    <th><input type="checkbox" id="selectallbtn"></th>
                    <th style="width:73px !important">Title</th>
                    <th style="width:10px !important">Status<span></span></th>
                    <th style="width:40px !important">Contact</th>
                    <th style="width:50px !important">Date</th>
                    <th style="width:10px !important">Time</th>
                    <th style="width:95px !important" class="action">Action</th>
                </tr>
            </thead>
        </div>
        <tbody class="panel-body">
                <?php
                if (is_array($arrAppointmentList) && (count($arrAppointmentList) > 0)) {
                    foreach ($arrAppointmentList as $arrAppointment) {
                        $strContactDetailUrl = Router::url(array('controller' => 'jstappointments', 'action' => 'detail', $intPortalId, $arrAppointment['JstAppointments']['jstappointments_id']), true);

                        $strContactEditUrl = Router::url(array('controller' => 'jstappointments', 'action' => 'edit', $intPortalId, $arrAppointment['JstAppointments']['jstappointments_id']), true);

                        $intAppointmentId = $arrAppointment['JstAppointments']['jstappointments_id'];
                        ?>
                        <tr id="appointment_<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>">
                            <td><input type="checkbox" class="case1" name="appointment_check[]" value="<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>" ></td>
                            <td>
                                <div class="user-title">
                                    <a href="#app<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>-options" id="app1" class="username-clickable"><?php echo $arrAppointment['JstAppointments']['jstappointments_title']; ?></a>
                                </div>
<!--                                <div id="app<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>-options" class="user-options">
                                    <a href="#" id="appoint_edit_<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>" onclick="fnGetAppointmentDetail(this, '0')" class="link-primary">Edit / View</a> |
                                    <a href="#" class="link-warning" id="appoint_delete_<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>" onclick="fnDeleteAppointmentNew(this, '0')">Delete</a> |
                                    <a href="javascript:void(0);" onclick="fnGetOnCalendar('<?php echo $intAppointmentId; ?>')" class="link-primary">View in Calendar</a>
                                </div>-->
                            </td>
                            <td><span class="status-indicator status-success">New</span></td>
                            <td><?php echo $arrAppointment['JstAppointments']['jstappointments_contact_fname']; ?></td>
                            <td><?php echo date($productdateformatnew, strtotime($arrAppointment['JstAppointments']['jstappointments_start_date'])); ?></td>
                            <td><?php echo date("H:i", strtotime($arrAppointment['JstAppointments']['jstappointments_start_time'])); ?></td>
                            <td><a href="#" id="appoint_edit_<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>" onclick="fnGetAppointmentDetail(this, '0')" class="link-primary">Edit / View</a> | <a href="#" class="link-warning" id="appoint_delete_<?php echo $arrAppointment['JstAppointments']['jstappointments_id']; ?>" onclick="fnDeleteAppointmentNew(this, '0')">Delete</a> | <a href="javascript:void(0);" onclick="fnGetOnCalendar('<?php echo $intAppointmentId; ?>')" class="link-primary">View in Calendar</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr style="height:50px;">
                        <td colspan="6">There are no appointments recorded</td>
                    </tr>
                    <?php
                }
                ?>
                    </tbody>
            </table>
        </div>
    <input type="hidden" name="deleteAppointmentIds" id="deleteAppointmentIds" value="">
        <!--<div class="panel-footer appointments">
                <table>
                        <tr>
                                <th><input type="checkbox" value=""></th>
                                <th>Title</th>
                                <th class="selected">Status<span></span></th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Time</th>
                        </tr>
                </table>
        </div>-->
    </div>
</div>
<!-- APPOINTMENTS BOTTOM CONTROLS -->
<div class="tab-row-container">
    <!-- <div class="tab-contacts-controls"> -->
    <!--<div class="tab-controls-actions">
            <div class="form-group">
                    <select name="bulk-actions" title="Bulk Actions">
                            <option value="value1">Bulk Action1</option>
                            <option value="value2">Bulk Action2</option>
                            <option value="value3">Bulk Action3</option>
                            <option value="value4">Bulk Action4</option>
                    </select>
                    <button type="button" class="btn btn-default btn-md">Apply</button>
            </div>
            <div class="form-group">
                    <select name="date-filter" title="Date Filter">
                            <option value="value1">Date Filter1</option>
                            <option value="value2">Date Filter2</option>
                            <option value="value3">Date Filter3</option>
                            <option value="value4">Date Filter4</option>
                    </select>
                    <button type="button" class="btn btn-default btn-md">Filter</button>
            </div>
    </div>
    <div class="tab-controls-pagination">
            <button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
            <button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
            <button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
            <input type="text" value="" name="input-page-number" placeholder="1">
            <button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
            <button type="button" class="btn btn-default goto-next-active"><span></span></button>
            <button type="button" class="btn btn-default goto-end-active"><span></span></button>
    </div>-->
    <!-- </div> -->
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.username-clickable').click(function () {
			var strDestLoc = $(this).attr('href');
			//alert("hello");
			$(strDestLoc).toggle();
		});
            $("#appointment_list").tablesorter({
                    headers : { 0 : { sorter: false },2 : { sorter: false },3 : { sorter: false },4 : { sorter: false },5 : { sorter: false } }
                });
        
                $('.action').removeClass('header');    
	});
	
	function fnLoadAppointmentAdder()
	{
	$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"jstappointments/getapptform/"+intPortalId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('.tabloader').hide();
						$('#tab-appointments').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
		});
	}
	
	function fnGetOnCalendar(intAppointmentId)
	{
		$('.cms-bgloader-mask').show();//show loader mask
	 	$('.cms-bgloader').show(); //show loading image
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"jstappointments/getApptOnCal/"+intPortalId+"/"+intAppointmentId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('#tab-appointments').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
		});
	}
        
        function fnDeleteAllAppointments()
	{
		$('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image
		
                var favorite = [];
                $.each($("input[name='appointment_check[]']:checked"), function(){            
                    favorite.push($(this).val());
                });
                $('#deleteAppointmentIds').val(favorite.join(","));
                var intPortalId = "<?php echo $intPortalId; ?>";
                var intAppointmentId = $('#deleteAppointmentIds').val();
		$.ajax({ 
                    type: "POST",
                    url: strBaseUrl+"jstappointments/deleteallappointments",
                    dataType: 'json',
                    data:'appointmentId=' + intAppointmentId + "&PortalId=" + intPortalId,
                    async:false,
                    cache:false,
                    success: function(data)
                    {
                            if(data.status == "success")
                            {
                                $('.tabloader').hide();
                                $('#tab-contacts').html(data.contactshtml);
                                $('#delete_notification').html(data.message);
//                                window.location.href = window.location.href;
                                var Ids = data.intAppointmentId.split(",");
                                jQuery.each(Ids, function( i, val ) {
                                    $( "#appointment_" + val ).remove();
                                });
                                $("#selectallbtn").removeAttr("checked");
                            }
                            else
                            {
                                alert("fail");
                            }
                            $('.cms-bgloader-mask').hide();//show loader mask
                            $('.cms-bgloader').hide(); //show loading image
                    }
		});
	}
        
      $(function(){
	$("#selectallbtn").click(function () {
//		  $('.case').attr('checked', this.checked);
                  $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
	});

	$(".case1").click(function(){

		if($(".case1").length == $(".case1:checked").length) {
			$("#selectallbtn").attr("checked", "checked");
		} else {
			$("#selectallbtn").removeAttr("checked");
		}

	});
        });
        
</script>

<style>
    .tab-row-container .panel-heading, .tab-row-container .panel-body, .tab-row-container .panel-footer {
  background-color: white;
  border: 1px solid #ccc;
  padding: 0;
}
.admin-content tr {
  border: 1px solid #ccc !important;
}
</style>