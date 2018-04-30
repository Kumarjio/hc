<?php
echo $this->element('delete_confirmation_jst_task');
?>
<?php
echo $this->element('complete_confirmation_jst_task');
?>

<div class="tab-header">
    <h3>Tasks</h3>
    <button type="button" onclick="fnLoadTaskAdder()" class="btn btn-primary btn-sm">Add New</button>
</div>
<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />
<div id="delete_notification"></div>
<div class="tab-row-container">
    <!--<div class="tab-filters">
            <a href="#" class="active">All <span>(5)</span></a> |
            <a href="#" class="link-primary">New <span>(1)</span></a> |
            <a href="#" class="link-primary">Completed <span>(1)</span></a> |
            <a href="#" class="link-warning">Trashed <span>(4)</span></a>
    </div>
    <div class="tab-search">
            <input type="text" value="" name="search" placeholder="Search">
            <button type="button" class="btn btn-default btn-md">Search</button>
    </div>-->
</div>
<!-- TASKS TOP CONTROLS -->
<div class="tab-row-container">

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
     <!--Extra add button here-->
    <div class="tab-contacts-controls"> 
        <div class="tab-controls-actions">
            <div class="form-group">
                <button type="button" class="btn btn-default btn-md" onclick="fnDeleteAllTasks();">Delete</button>
            </div>
        </div>
    </div> 
</div>
<!-- TASKS CONTENT -->
<div class="tab-row-container">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-heading">
            <table class="tablesorter" id="task_list">
                <thead>
                <tr>
                    <th style="width:1px !important"><input id="selectallTaskbtn" type="checkbox"></th>
                    <th style="width:160px !important" class="header">Title</th>
                    <th style="width:60px !important">Status<span></span></th>
                    <!--<th>Notes</th>-->
                    <th style="width:80px !important">Action date</th>
                    <th style="width:54px !important">Action time</th>
                    <th style="width:149px !important" class="action">Action</th>
                </tr>
            </thead>
        </div>
        <tbody class="panel-body">
                <?php
                if (is_array($arrAppointmentList) && (count($arrAppointmentList) > 0)) {

                    foreach ($arrAppointmentList as $arrAppointment) {
                        $strContactDetailUrl = Router::url(array('controller' => 'jstappointments', 'action' => 'detail', $intPortalId, $arrAppointment['JstAppointments']['jstappointments_id']), true);

                        $strContactEditUrl = Router::url(array('controller' => 'jstappointments', 'action' => 'edit', $intPortalId, $arrAppointment['JstAppointments']['jstappointments_id']), true);

                        $intContactId = $arrAppointment['JstTasks']['jsttasks_id'];
                        ?>
                        <tr id="task_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>">
                            <td><input type="checkbox" class="case2" name="task_check[]" value="<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" ></td>
                            <td style="width:40px !important">
                                <div class="user-title">
                                    <a href="#app<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>-options" id="task<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" class="username-clickable">
                                        <?php
                                        if ($arrAppointment['JstTasks']['jsttasks_title']) {
                                            echo $arrAppointment['JstTasks']['jsttasks_title'];
                                        } else {
                                            echo "New task";
                                        }
                                        ?>
                                    </a>
                                </div>

<!--                                <div id="app<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>-options" class="user-options">
                                    <a href="#" id="task_edit_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnGetTaskDetail(this, '0')" class="link-primary">Edit / View</a> |
                                    <a href="#" class="link-warning" id="task_del_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onClick="fnDeleteContactPop('<?php echo $intContactId; ?>')">Delete</a>
                                    <?php
                                    if ($arrAppointment['JstTasks']['jsttasks_status'] == "Completed") {
                                        ?>
                                        |
                                        <a href="javascript:void(0);" class="link-primary" id="task_comp_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnConfirmCompletion('<?php echo $intContactId; ?>');">Incomplete task</a> 
                                        <?php
                                    } else {
                                        ?>
                                        |
                                        <a href="javascript:void(0);" class="link-primary" id="task_comp_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnConfirmCompletion('<?php echo $intContactId; ?>');">Complete task</a> 
                                        <?php
                                    }
                                    ?>											

                                </div>-->
                            </td>
                            <!--<td><span class="status-indicator status-success">New</span></td>-->
                            <td id="task_status_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>"><?php echo ucfirst($arrAppointment['JstTasks']['jsttasks_status']); ?></td>
                            <td><?php echo date($productdateformatnew, strtotime($arrAppointment['JstTasks']['jsttasks_start_date'])); ?></td>
                            <td><?php echo date("H:i", strtotime($arrAppointment['JstTasks']['jsttasks_start_time'])); ?></td>
                            <td>
                                    <a href="#" id="task_edit_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnGetTaskDetail(this, '0')" class="link-primary">Edit / View</a> |
                                    <a href="#" class="link-warning" id="task_del_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onClick="fnDeleteContactPop('<?php echo $intContactId; ?>')">Delete</a>
                                    <?php
                                    if ($arrAppointment['JstTasks']['jsttasks_status'] == "Completed") {
                                        ?>
                                        |
                                        <a href="javascript:void(0);" class="link-primary" id="task_comp_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnConfirmCompletion('<?php echo $intContactId; ?>');">Incomplete task</a> 
                                        <?php
                                    } else {
                                        ?>
                                        |
                                        <a href="javascript:void(0);" class="link-primary" id="task_comp_<?php echo $arrAppointment['JstTasks']['jsttasks_id']; ?>" onclick="fnConfirmCompletion('<?php echo $intContactId; ?>');">Complete task</a> 
                                        <?php
                                    }
                                    ?>	
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr style="height:50px;">
                        <td colspan="6">There are no tasks recorded</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <input type="hidden" name="deleteTaskIds" id="deleteTaskIds" value="">
        </div>
        <!--<div class="panel-footer">
                <table>
                        <tr>
                                <th><input type="checkbox" value=""></th>
                                <th>Title</th>
                                <!--<th class="selected">Status<span></span></th>
                                <th>Notes</th>-->
                                <!--<th>Action date</th>
                                <th>Action time</th>
        <!--th>Completion date</th>-->
        <!--</tr>
</table>
</div>-->
    </div>
</div>
<!-- TASKS BOTTOM CONTROLS -->
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
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.username-clickable').click(function () {
            var strDestLoc = $(this).attr('href');
            //alert("hello");
            $(strDestLoc).toggle();
        });
        
        $("#task_list").tablesorter({
                    headers : { 0 : { sorter: false },2 : { sorter: false },3 : { sorter: false },4 : { sorter: false },5 : { sorter: false } }
                });
        
                $('.action').removeClass('header');   
    });

    function fnLoadTaskAdder()
    {
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        var intPortalId = "<?php echo $intPortalId; ?>";
        $.ajax({
            type: "GET",
            url: strBaseUrl + "jsttasks/gettaskform/" + intPortalId,
            dataType: 'json',
            data: "",
            async: false,
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    $('.tabloader').hide();
                    $('#tab-appointments').html('');
                    $('#tab-tasks').html(data.contactshtml);
                } else
                {
                    alert("fail");
                }
                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image
            }
        });
    }

    function fnDeleteContactPop(intContactId)
    {
        $('#delete_for').val(intContactId);
        $('#confirm_delete_jst_task').modal('show');
    }

    function fnConfirmCompletion(intContactId)
    {
        var strCurrentStatus = $('#task_status_' + intContactId).text();
        if (strCurrentStatus == "Completed")
        {
            strCurrentStatus = "Incomplete"
            $('#complete_confirmation_text').text("Are you sure, you want to mark this task as Incomplete?");
        } else
        {
            strCurrentStatus = "Completed"
            $('#complete_confirmation_text').text("Are you sure, you want to mark this task as Complete?");
        }

        $('#complete_for').val(intContactId);
        $('#action_for').val(strCurrentStatus);
        $('#confirm_complete_jst_task').modal('show');
    }
    
     function fnDeleteAllTasks()
	{
		$('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image
		
                var favorite = [];
                $.each($("input[name='task_check[]']:checked"), function(){            
                    favorite.push($(this).val());
                });
                $('#deleteTaskIds').val(favorite.join(","));
                var intPortalId = "<?php echo $intPortalId; ?>";
                var intTaskId = $('#deleteTaskIds').val();
		$.ajax({ 
                    type: "POST",
                    url: strBaseUrl+"jsttasks/deletealltasks",
                    dataType: 'json',
                    data:'inttaskId=' + intTaskId + "&PortalId=" + intPortalId,
                    async:false,
                    cache:false,
                    success: function(data)
                    {
                            if(data.status == "success")
                            {
                                $('.tabloader').hide();
                                $('#tab-contacts').html(data.contactshtml);
                                $('#delete_notification').html(data.message);
                                var Ids = data.intTaskId.split(",");
                                jQuery.each(Ids, function( i, val ) {
                                    $( "#task_" + val ).remove();
                                });
                                
                                $("#selectallTaskbtn").removeAttr("checked");
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
	$("#selectallTaskbtn").click(function () {
//		  $('.case').attr('checked', this.checked);
                  $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
	});

	$(".case2").click(function(){

		if($(".case2").length == $(".case2:checked").length) {
			$("#selectallTaskbtn").attr("checked", "checked");
		} else {
			$("#selectallTaskbtn").removeAttr("checked");
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

/*    .tab-row-container .panel-heading table, .tab-row-container .panel-body table, .tab-row-container .panel-footer table
    {
        table-layout:auto;
    }*/
</style>