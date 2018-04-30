<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php if ($payoutType == 'vendor') { ?>
                <h1>Total Paid Payout For Vendor <?php echo ucfirst(stripslashes($vendorName)); ?> </h1> 
                <?php } else { ?>
                    <h1>Total Paid Payout For Owner <?php echo ucfirst(stripslashes($ownerName)); ?> </h1> 
                <?php } ?>

                <div class="tab-row-container">
                    <?php if ($payoutType == 'vendor') { ?>
                        <p>Listed are all total paid payout for vendor <?php echo ucfirst(stripslashes($vendorName)); ?> </p>
                    <?php } else { ?>
                        <p>Listed are all total paid payout for owner <?php echo ucfirst(stripslashes($ownerName)); ?> </p>
                    <?php } ?>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnPaidPayoutsExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th style="width:7%!important;">ID</th>
                                    <?php if ($payoutType == 'vendor') { ?>
                                        <th style="width:25%!important;">Company Name</th>
                                    <?php } else { ?>
                                        <th style="width:25%!important;">Owner Name</th>
                                    <?php } ?>
                                    <th style="width:20%!important;">Payout Cost</th>
                                    <th style="width:20%!important;">Date</th>
                                    <th style="width:20%!important;">&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                        <?php if (is_array($arrPayoutDetails) && (count($arrPayoutDetails) > 0)) { ?>
                            <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                                <table>
                                    <?php
                                    if (is_array($arrPayoutDetails) && (count($arrPayoutDetails) > 0)) {
                                        $intForI = 0;
                                        $class = null;
                                        foreach ($arrPayoutDetails as $payouts) {
                                            if ($intForI++ % 2 == 0) {
                                                $class = ' class="altrow"';
                                            }
                                            ?>
                                            <tr <?php echo $class; ?>>
                                                <td style="width:7%!important;height:40px!important;"><?php echo $intForI; ?></td>
                                                <?php if ($payoutType == 'vendor') { ?>
                                                <td style="width:25%!important;height:40px!important;"><?php echo isset($payouts['company_name']) ? ucfirst($payouts['company_name']) : '-'; ?></td>
                                                <?php } else { ?>
                                                    <td style="width:25%!important;height:40px!important;"><?php echo isset($payouts['username']) ? ucfirst($payouts['username']) : '-'; ?></td>
                                                <?php } ?>
                                                    <td style="width:20%!important;height:40px!important;">$<?php echo isset($payouts['payout_payment_details']['payout_amount']) ? ($payouts['payout_payment_details']['payout_amount']) : '$0.00'; ?></td>
                                                <td style="width:20%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($payouts['payout_payment_details']['payout_date'])); ?></td>
                                                <td style="width:20%!important;height:40px!important;">&nbsp;</td>
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
                            <table>
                                <tr>
                                    <td colspan='5' class="altrow">&nbsp;</td>
                                </tr>
                                <tr>
                                    <?php if ($payoutType == 'vendor') { ?>
                                        <td colspan='5'><span style="margin-left:20%;">No total paid payout for vendor <?php echo ucfirst(stripslashes($vendorName)); ?> </span></td>
                                    <?php } else { ?>
                                        <td colspan='5'><span style="margin-left:20%;">No total paid payout for owner <?php echo ucfirst(stripslashes($ownerName)); ?> </span></td>
                                    <?php } ?>
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

    function fnPaidPayoutsExport()
    {
        var vendorId = '<?php echo $intVendorId; ?>';
        var ownerId = '<?php echo $intOwnerId; ?>';
        var payoutType = '<?php echo $payoutType; ?>';
        var strStartDate = '<?php echo $strStartDate; ?>';
        var strEndDate = '<?php echo $strEndDate; ?>';
        var vendorName = '<?php echo $vendorName; ?>';
        var ownerName = '<?php echo $ownerName; ?>';

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "managepayouts/paidPayoutsExport",
            data: 'StartDate=' + strStartDate + "&EndDate=" + strEndDate + "&vendorId=" + vendorId + "&ownerId=" + ownerId + "&payoutType=" + payoutType + "&vendorName=" + vendorName + "&ownerName=" + ownerName,
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
<style>
    .tab-row-container th:first-child, .tab-row-container td:first-child, .tab-row-container th:first-child {
        padding-left: 10px !important;
        width: 6% !important;
    }
    .export-btn {
        float: right;
        margin-bottom: 13px;
        margin-top: -37px;
    }
</style>