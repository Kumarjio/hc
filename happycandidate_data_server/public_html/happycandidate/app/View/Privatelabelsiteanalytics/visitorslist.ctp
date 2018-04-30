<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Total Unique Visitors Career Portal</h1>
                <div class="tab-row-container">
                    <p>Listed are all total unique visitors in your career portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnExportVisitors()" >Export</button>
                </div>
                <div class="tab-row-container">

                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th style="width:7%!important;">ID</th>
                                    <th style="width:25%!important;">Ip Address</th>
                                    <th style="width:15%!important;">Portal Name</th>
                                    <th style="width:25%!important;">Visits Date</th>
                                    <th style="width:7%!important;">&nbsp;</th>
                                    <th style="width:7%!important;">&nbsp;</th>
                                </tr>

                            </table>
                        </div>
                        <?php if (is_array($arrTotalVisitors) && (count($arrTotalVisitors) > 0)) { ?>
                            <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                                <table>
                                    <?php
                                    if (is_array($arrTotalVisitors) && (count($arrTotalVisitors) > 0)) {
                                        $intForI = 0;
                                        $class = null;
                                        foreach ($arrTotalVisitors as $Visitors) {
                                            if ($intForI++ % 2 == 0) {
                                                $class = ' class="altrow"';
                                            }
                                            ?>
                                            <tr <?php echo $class; ?>>
                                                <td style="width:7%!important;"><?php echo $intForI; ?></td>
                                                <td style="width:25%!important;"><?php echo $Visitors['career_portal_visitors']['ip_address']; ?></td>
                                                <td style="width:15%!important;"><?php echo $Visitors['career_portal_visitors']['portal_name']; ?></td>
                                                <td style="width:25%!important;"><?php echo date($productdateformat, strtotime($Visitors['career_portal_visitors']['visited_date'])); ?></td>
                                                <td style="width:7%!important;">&nbsp;</td>
                                                <td style="width:7%!important;height:30px!important;">&nbsp;</td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                        } else {
                            ?>
                            <table>
                                <tr>
                                    <td colspan='6' class="altrow">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan='6'><span style="margin-left:20%;">No total unique visitors in your career portal</span></td>
                                </tr>
                            </table>
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
<style>
    .export-btn {
        float: right;
        margin-bottom: 13px;
        margin-top: -37px;
    }
    .tab-row-container th:first-child, .tab-row-container th:first-child {
        padding: 6px !important;
    }
</style>
<script src="<?php echo Router::url('/', true); ?>app/webroot/js/jquery.tablesorter.js" type="text/javascript"></script>
<script type="text/javascript">
                        $(document).ready(function ()
                        {
                            $("#product_list").tablesorter({
                                headers: {4: {sorter: false}}
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

    function fnExportVisitors()
    {

        var PortalId = '<?php echo $portalId; ?>';
        var strStartDate = '<?php echo $strStartDate; ?>';
        var strEndDate = '<?php echo $strEndDate; ?>';
        var visiterType = '<?php echo $visiterType; ?>';

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "privatelabelsiteanalytics/visitorsExport",
            data: 'startDate=' + strStartDate + "&endDate=" + strEndDate + "&portalId=" + PortalId + "&visiterType=" + visiterType,
            cache: false,
            dataType: "json",
            success: function (data)
            {
                if (data.status == "success")
                {
                    if (data.file != "")
                    {
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image
                        var strFileUrl = appBaseU + data.filepath + "/" + data.file;
                        window.open(strFileUrl);
                    }
                } else
                {
                    alert(data.message);
                }
                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image
            }
        });
    }
</script>