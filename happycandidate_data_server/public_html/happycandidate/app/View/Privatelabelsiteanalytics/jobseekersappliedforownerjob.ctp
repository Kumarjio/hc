<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Job Seeker(s) Applied For Owner Jobs</h1>
                <div class="tab-row-container">
                    <p>Listed are all order refunded in your Career Portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnAppliedForOwnerJobExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Title</th>
                                    <th>Candidate</th>
                                    <th>Phone Number</th>
                                    <th>Resume | CV</th>
                                    <th>Application date</th>
                                    <!--<th>&nbsp;</th>-->
                                </tr>
                            </table>
                        </div>
                        <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <?php
                                if (is_array($arrApplications) && (count($arrApplications) > 0)) {
                                    $intForI = 0;
                                    $class = null;
                                    foreach ($arrApplications as $arrJob) {
                                        if ($intForI++ % 2 == 0) {
                                            $class = ' class="altrow"';
                                        }

                                        $arrJobD = $arrJob['JobsApplied']['jobdetail'];
                                        $arrCandD = $arrJob['JobsApplied']['candtail'];
                                        $arrCVD = $arrJob['JobsApplied']['candcvdetail'];
                                        $intJId = $arrJob['JobsApplied']['job_application_id'];
                                        $intPortalId = $arrJob['JobsApplied']['job_portal_id'];
                                        $seekerid = $arrJob['JobsApplied']['candidate_id'];
                                        $cv_id = $arrJob['JobsApplied']['candidate_cv_id'];
                                        ?>
                                        <tr >
                                            <td>
                                                <?php
                                                echo $intForI;
                                                ?>
                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <?php echo $arrCandD[0]['Candidate']['candidate_email']; ?>
                                                </div>
                                            </td>
                                            <td><?php echo $arrJobD[0]['Job']['job_title']; ?></td>
                                            <td><?php echo $arrCandD[0]['Candidate']['candidate_first_name'] . " " . $arrCandD[0]['Candidate']['candidate_last_name']; ?></td>
                                            <td><?php echo $arrCVD[0]['Candidate_Cv']['homePhone']; ?></td>
                                            <td><a href="javascript:void(0);" onclick="submitToResumeViewForOwner('<?php echo $intPortalId ?>', '<?php echo $seekerid ?>', '<?php echo $cv_id; ?>');" class="link-primary editable"><?php echo $arrCVD[0]['Candidate_Cv']['resume_title']; ?></a></td>
                                            <td><?php echo date($productdateformat, strtotime($arrJob['JobsApplied']['job_application_datetime'])); ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan='8' class="altrow">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan='8'><span style="margin-left:20%;">No Job Seeker(s) Applied For Owner Jobs</span></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-row-container">
                    <div class="tab-controls-pagination">
                        <div class="pagination pagination-large">
                            <ul class="pagination">
                                <?php
                                if ($this->Paginator->hasPrev()) {
                                    echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                }
                                ?>
                                &nbsp;
                                <?php
                                echo $this->Paginator->numbers(array('last' => 'Last page'));
                                ?>
                                &nbsp;
                                <?php
                                if ($this->Paginator->hasNext()) {
                                    echo $this->Paginator->next(__('next') . ' >> ', array(), null, array('class' => 'next disabled'));
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- del -->

            </div>
        </div>
    </div>
</div>
<script src="<?php echo Router::url('/', true); ?>app/webroot/js/jquery.tablesorter.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#product_list").tablesorter({
           headers : { 4 : { sorter: false }} 
        }); 
        $('.action').removeClass('header');
    }
    );
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.leftnavi').removeClass('active');
        $('#candnavi').addClass('active');

        //TABS - CLICKING ON THE USERS
        $(".panel-body.emp-dashboard-jobs .user-title a").click(function (event) {

            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
    });
    
    function fnAppliedForOwnerJobExport()
    {
	var PortalId = '<?php echo $portalId;?>';
        var strStartDate = '<?php echo $strStartDate;?>';
        var strEndDate = '<?php echo $strEndDate;?>';
		
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
            type: "GET",
            url: appBaseU+"privatelabelsiteanalytics/appliedforOwnerJobExport",
            data: 'StartDate='+strStartDate+"&EndDate="+strEndDate+"&portalId="+PortalId,
            cache: false,
            dataType:"json",
            success: function(data)
            {
                    if(data.status == "success")
                    {
                            if(data.file !="")
                            {
                                    $('.cms-bgloader-mask').hide();//show loader mask
                                    $('.cms-bgloader').hide(); //show loading image
                                    var strFileUrl = appBaseU+data.filepath+"/"+data.file;
                                    window.open(strFileUrl);
                            }
                    }
                    else
                    {
                            alert(data.message);
                    }
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image
            }
	});
 }
 
</script>
<style>
    .tab-row-container th:first-child, .tab-row-container td:first-child, .tab-row-container th:first-child {
  padding-left: 10px;
  width: 6% !important;
}
.emp-dashboard-pages th:nth-child(2), .emp-dashboard-pages td:nth-child(2), .emp-dashboard-jobs th:nth-child(2) {
  width: 30%!important;
}
.emp-dashboard-pages th:nth-child(3), .emp-dashboard-pages td:nth-child(3), .emp-dashboard-jobs th:nth-child(3) {
  width: 20%!important;
}
.emp-dashboard-pages th:nth-child(4), .emp-dashboard-pages td:nth-child(4), .emp-dashboard-jobs th:nth-child(4) {
  width: 20%!important;
}
.emp-dashboard-pages th:nth-child(5), .emp-dashboard-pages td:nth-child(5), .emp-dashboard-jobs th:nth-child(5) {
  width: 20%!important;
}
.emp-dashboard-pages th:nth-child(6), .emp-dashboard-pages td:nth-child(6), .emp-dashboard-jobs th:nth-child(6) {
  width: 20%!important;
}

.export-btn {
      float: right;
      margin-bottom: 13px;
      margin-top: -37px;
    }
</style>