<?php $strPayoutUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutsPayment'), true); ?>
<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div id="product_notification"></div>
        <div class="row">
            <div class="col-lg-12">
                <?php if ($payoutType == 'vendor') {
                    if($selectedStartDate !=''){
                    ?>
                    <h1>Total Payout For Vendor <?php echo ucfirst(stripslashes($vendorName)); ?> <?php echo date($productdateformat, strtotime($selectedStartDate)) . " To " . date($productdateformat, strtotime($selectedEndDate)); ?>  </h1> 
                    <?php }else{ ?>
                        <h1>Total Payout For Vendor <?php echo ucfirst(stripslashes($vendorName)); ?> </h1> 
                   <?php } ?>
                <?php }else{ 
                    if($selectedStartDate !=''){ ?>
                       <h1>Total Payout For Owner <?php echo ucfirst(stripslashes($ownerName)); ?> <?php echo date($productdateformat, strtotime($selectedStartDate)) . " To " . date($productdateformat, strtotime($selectedEndDate)); ?></h1>  
                   <?php }else{ ?>
                    <h1>Total Payout For Owner <?php echo ucfirst(stripslashes($ownerName)); ?> </h1> 
                <?php } } ?>

                <div class="tab-row-container">
                    <?php if ($payoutType == 'vendor') { ?>
                        <p>Listed are all total payout for vendor <?php echo ucfirst(stripslashes($vendorName)); ?></p>
                    <?php } else { ?>
                        <p>Listed are all total payout for owner <?php echo ucfirst(stripslashes($ownerName)); ?> </p>
                    <?php } ?>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnpayoutsExport()" >Export</button>
                    <button name="add_payment" id="add_payment" type="button" class="btn btn-default btn-md export-btn" onclick="fnGetPayout()" >Add Payment</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th style="width:7%!important;">ID</th>
                                    <?php if ($payoutType == 'vendor') { ?>
                                        <th style="width:25%!important;">Vendor Name</th>
                                    <?php } else { ?>
                                        <th style="width:25%!important;">Owner Name</th>
                                    <?php } ?>
                                    <!--<th style="width:25%!important;">Product Name</th>-->
                                    <th style="width:10%!important;">Amount Owed</th>
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
                                                    <td style="width:25%!important;height:40px!important;"><?php echo stripslashes($payouts['resource_order_detail']['vendor_name']); ?></td>
                                                <?php } else { ?>
                                                    <td style="width:25%!important;height:40px!important;"><?php echo stripslashes($payouts['username']); ?></td>
                                                <?php } ?>
                                                <!--<td style="width:25%!important;height:40px!important;"><?php // echo stripslashes($payouts['resource_order_detail']['product_name']);  ?></td>-->
                                                <?php if ($payoutType == 'vendor') { ?>
                                                    <td style="width:10%!important;height:40px!important;">$<?php echo isset($payouts[0]['vendor_cost']) ? ($payouts[0]['vendor_cost']) : '0.00'; ?></td>
                                                <?php } else { ?>
                                                    <td style="width:10%!important;height:40px!important;">$<?php echo isset($payouts[0]['portal_owner_cost']) ? ($payouts[0]['portal_owner_cost']) : '0.00'; ?></td>
                                                <?php } ?>
                                                <td style="width:20%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($payouts['resource_order_detail']['order_detail_creation_date_time'])); ?></td>
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
                                        <td colspan='5'><span style="margin-left:20%;">No total payout for vendor <?php echo ucfirst(stripslashes($vendorName)); ?></span></td>
                                    <?php } else { ?>
                                        <td colspan='5'><span style="margin-left:20%;">No total payout for owner <?php echo ucfirst(stripslashes($ownerName)); ?></span></td>
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

    function fnpayoutsExport()
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
            url: appBaseU + "managepayouts/payoutsExport",
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

    function fnGetPayout() {

        var selectedPayoutType = '<?php echo ($payoutType);?>';
        var strFromDate = '<?php echo base64_decode($strStartDate);?>';
        var strToDate = '<?php echo base64_decode($strEndDate);?>';
        var payoutCost = '<?php echo "$".base64_decode($payoutsCost);?>';

        if (selectedPayoutType == 'vendor') {
            var Vendors = '<?php echo base64_decode($intVendorId); ?>';
        } else {
            var Vendors = '';
        }

        if (selectedPayoutType == 'owner') {
            var Owners = '<?php echo base64_decode($intOwnerId); ?>';
        } else {
            var Owners = '';
        }

        var strPayoutUrl = "<?php echo $strPayoutUrl; ?>/";
        var datastrj = "VendorId=" + Vendors + "&OwnerId=" + Owners + "&PayoutType=" + selectedPayoutType + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&payoutCost=" + payoutCost;
        $.ajax({
            type: "POST",
            url: strPayoutUrl,
            data: datastrj,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image		
            },
            success: function (data)
            {
                $('#loader').hide();
                var str = '';
                if (data.type == "success")
                {
                    str += "<a href=" + data.list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>$0.00</h4><p id='portal_statistics_name'>Owners Payout Details</p></a>";
                    $('#portal_statistics_data').html(str);

                    $("#product_notification").html(data.message);
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image	
                    $('#pay-btn').hide();

                } else
                {
                    $("#product_notification").html(data.message);
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image

                }
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