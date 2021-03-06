<?php $strComissionPayoutUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutsComissionPayment'), true); ?>
<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div id="product_notification"></div>
        <div class="row">
            <div class="col-lg-12">
                <?php 
                    if($selectedStartDate !=''){ ?>
                       <h1>Total Comission For Owner <?php echo ucfirst(stripslashes($ownerName)); ?> <?php echo date($productdateformat, strtotime($selectedStartDate)) . " To " . date($productdateformat, strtotime($selectedEndDate)); ?></h1>  
                   <?php }else{ ?>
                    <h1>Total Comission For Owner <?php echo ucfirst(stripslashes($ownerName)); ?> </h1> 
                <?php } ?>

                <div class="tab-row-container">
                    <p>Listed are all total comission for owner <?php echo ucfirst(stripslashes($ownerName)); ?> </p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fncomissionPaidExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th style="width:10%!important;">ID</th>
                                    <th style="width:15%!important;">Offer Id</th>
                                    <th style="width:50%!important;">Offer Name</th>
                                    <th style="width:25%!important;">Owner Name</th>
                                    <th style="width:20%!important;">Comission Cost</th>
                                    <th style="width:20%!important;">Date</th>
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
                                                <td style="width:10%!important;height:40px!important;"><?php echo $intForI; ?></td>
                                                <td style="width:15%!important;height:40px!important;"><?php echo stripslashes($payouts['cpa_offers_commissions']['offer_id']); ?></td>
                                                <td style="width:50%!important;height:40px!important;"><?php echo stripslashes($payouts['cpa_offers']['offer_name']); ?></td>
                                                <td style="width:25%!important;height:40px!important;"><?php echo stripslashes($payouts['username']); ?></td>
                                                <td style="width:10%!important;height:40px!important;">$<?php echo isset($payouts[0]['commission_cost']) ? ($payouts[0]['commission_cost']) : '0.00'; ?></td>
                                                <td style="width:20%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($payouts['cpa_offers_commissions']['added_date'])); ?></td>
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
                                    <td colspan='5'><span style="margin-left:20%;">No total comission for owner <?php echo ucfirst(stripslashes($ownerName)); ?></span></td>
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
    
    function fncomissionPaidExport()
    {
        var ownerId = '<?php echo $intOwnerId; ?>';
        var payoutType = '<?php echo $payoutType; ?>';
        var strStartDate = '<?php echo $strStartDate; ?>';
        var strEndDate = '<?php echo $strEndDate; ?>';
        var ownerName = '<?php echo $ownerName; ?>';

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "managepayouts/cpaComissionPaidExport",
            data: 'StartDate=' + strStartDate + "&EndDate=" + strEndDate + "&ownerId=" + ownerId + "&payoutType=" + payoutType + "&ownerName=" + ownerName,
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