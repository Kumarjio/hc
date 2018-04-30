<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Money that Owner Have Made OverTime</h1>
                <div class="tab-row-container">
                    <p>Listed are all money that owner have made overtime in your Career Portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnOverTimeMoneyExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Portal Name</th>
                                    <th>Product Name</th>
                                    <th>Over Time Money</th>
                                    <th>Order Date</th>
                                    <th>&nbsp;&nbsp;</th>
                                    <th>&nbsp;&nbsp;</th>
                                    <th>&nbsp;&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                        <?php if (is_array($arrOverTimeMoneyList) && (count($arrOverTimeMoneyList) > 0)) { ?>
                            <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                                <table>
                                    <?php
                                    if (is_array($arrOverTimeMoneyList) && (count($arrOverTimeMoneyList) > 0)) {
                                        $intForI = 0;
                                        $class = null;
                                        foreach ($arrOverTimeMoneyList as $arrJob) {
                                            if ($intForI++ % 2 == 0) {
                                                $class = ' class="altrow"';
                                            }

                                            $monery = $arrJob[0]['OverTimeMonery'];
                                            $portal = $arrJob['career_portal']['career_portal_name'];
                                            $product_name = $arrJob['resource_order_detail']['product_name'];
                                            $order_date = $arrJob['resource_order_detail']['order_detail_creation_date_time'];
                                            ?>
                                            <tr <?php echo $class; ?>>
                                                <td><?php echo $intForI; ?></td>
                                                <td><div class="user-title"><?php echo $portal; ?></div></td>
                                                <td><?php echo $product_name; ?></td>
                                                <td><?php echo "$".$monery; ?></td>
                                                <td><?php echo date($productdateformat, strtotime($order_date)); ?></td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td colspan='6' class="altrow">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan='6'><span style="margin-left:20%;">No Job Seeker(s) Applied For Owner Jobs</span></td>
                            </tr>
                            <?php
                        }
                        ?>
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
    
    function fnOverTimeMoneyExport()
    {
	var PortalId = '<?php echo $portalId;?>';
        var strStartDate = '<?php echo $strStartDate;?>';
        var strEndDate = '<?php echo $strEndDate;?>';
		
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
            type: "GET",
            url: appBaseU+"privatelabelsiteanalytics/overTimeMoneyExport",
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
        width: 10% !important;
    }
    .emp-dashboard-pages th:nth-child(2), .emp-dashboard-pages td:nth-child(2), .emp-dashboard-jobs th:nth-child(2) {
        width: 70%!important;
    }
    .emp-dashboard-pages th:nth-child(3), .emp-dashboard-pages td:nth-child(3), .emp-dashboard-jobs th:nth-child(3) {
        width: 50%!important;
    }
    .emp-dashboard-pages th:nth-child(4), .emp-dashboard-pages td:nth-child(4), .emp-dashboard-jobs th:nth-child(4) {
        width: 50%!important;
    }
    .emp-dashboard-pages th:nth-child(5), .emp-dashboard-pages td:nth-child(5), .emp-dashboard-jobs th:nth-child(5) {
        width: 30%!important;
    }
    .emp-dashboard-pages th:nth-child(6), .emp-dashboard-pages td:nth-child(6), .emp-dashboard-jobs th:nth-child(6) {
        width: 1%!important;
    }
    .emp-dashboard-pages th:nth-child(7), .emp-dashboard-pages td:nth-child(7), .emp-dashboard-jobs th:nth-child(7) {
        width: 1%!important;
    }
    .export-btn {
      float: right;
      margin-bottom: 13px;
      margin-top: -37px;
    }
</style>