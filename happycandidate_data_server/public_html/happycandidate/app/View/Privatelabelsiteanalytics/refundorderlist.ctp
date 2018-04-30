<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Order Refunded</h1>
                <div class="tab-row-container">
                    <p>Listed are all order refunded in your Career Portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnExportOrderRefunded()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th>&nbsp; ID &nbsp;</th>
                                    <th>Order ID</th>
                                    <th>Title</th>
                                    <th>Payment Status</th>
                                    <th>Cost</th>
                                    <th>Owner Cost</th>
                                </tr>
                            </table>
                        </div>
                            <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                                <table>
                                    <?php
                                    if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                                        $intContentCount = 0;
                                        foreach ($arrProductList as $arrContent) {
                                            $intContentCount++;
                                            $strProductEditUrl = Router::url(array('controller' => 'vendororders', 'action' => 'orderdetail', $arrContent['Resourceorderdetail']['order_detail_id']), true);
                                            $strPreviewUrl = Router::url(array('controller' => 'vendors', 'action' => 'preview', "5", $arrContent['vendors']['vendor_id']), true);
                                            $intOrderDetailId = $arrContent['Resourceorderdetail']['order_detail_id'];
                                            $arrSubVendorUser = $arrContent['vendorsuser'];
                                            ?>
                                            <tr >
                                                <td>
                                                    <?php
                                                    echo $intContentCount;
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="user-title">
                                                        <a href="#str<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" id="task1" class="username-clickable"><?php echo $arrContent['mainorder']['Resourceorder']['order_name']; ?></a>
                                                    </div>
                                                </td>
                                                <td><?php echo stripslashes($arrContent['service']['Resources']['product_name']); ?></td>
                                                <td id="order_status_payment_<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>"><?php
                                                    if ($arrContent['Resourceorderdetail']['refund_status']) {
                                                        echo "Refunded";
                                                    } else {
                                                        echo ucfirst($arrContent['Resourceorderdetail']['payment_status']);
                                                    }
                                                    ?></td>

                                                <td><?php echo "$ " . $arrContent['Resourceorderdetail']['product_unit_cost'] ?></td>

                                                <?php
                                                if ($arrContent['Resourceorderdetail']['refund_status']) {
                                                    ?>
                                                    <td><?php echo "$ 0.00"; ?></td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td><?php echo "$ " . $arrContent['Resourceorderdetail']['portal_owner_cost'] ?></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>

                                            <tr id="str<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" class="hide-str">
                                                <td>
                                                </td>
                                                <?php
                                                if (!$arrContent['Resourceorderdetail']['refund_status']) {
                                                    ?>
                                                    <td colspan="8">
                                                        <div id="task1-options" class="user-options">
                                                            <a href="javascript:void(0);" onclick="fnConfirmRefund('<?php echo $intOrderDetailId; ?> ');" class="link-primary">Cancel & Refund Order</a>
                                                        </div>
                                                    </td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td colspan="8">
                                                        <div id="task1-options" class="user-options">
                                                            Cancelled & Refunded
                                                        </div>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
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
<style>
    .export-btn {
      float: right;
      margin-bottom: 13px;
      margin-top: -37px;
    }
</style>

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
    
    function fnExportOrderRefunded()
    {
	
	var PortalId = '<?php echo $portalId;?>';
        var strStartDate = '<?php echo $strStartDate;?>';
        var strEndDate = '<?php echo $strEndDate;?>';
		
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
            type: "GET",
            url: appBaseU+"privatelabelsiteanalytics/orderRefundedExport",
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