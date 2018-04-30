<?php // echo '<pre>';print_r($arrVendorSaleOrders);?>
<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Total Sales For <?php echo stripslashes($vendorName);?></h1>
                <div class="tab-row-container">
                    <p>Listed are all total sales for <?php echo stripslashes($vendorName);?> in your Career Portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnVendorSalesOrderExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th style="width:7%!important;">ID</th>
                                    <th style="width:25%!important;">Order ID</th>
                                    <th style="width:32%!important;">Title</th>
                                    <th style="width:13%!important;">Cost</th>
                                    <th style="width:13%!important;">Vendor Cost</th>
                                    <th style="width:13%!important;">Owner Cost</th>
                                    <th style="width:13%!important;">HC Cost</th>
                                    <th style="width:13%!important;">Order Date</th>
                                </tr>
                            </table>
                        </div>
                        <?php 
                        
                        if (is_array($arrVendorSaleOrders) && (count($arrVendorSaleOrders) > 0)) { ?>
                            <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                                <table>
                                    <?php
                                    if (is_array($arrVendorSaleOrders) && (count($arrVendorSaleOrders) > 0)) {
                                        $intForI = 0;
                                        $class = null;
                                        foreach ($arrVendorSaleOrders as $VendorSaleOrders) {
                                            if ($intForI++ % 2 == 0) {
                                                $class = ' class="altrow"';
                                            }
                                            ?>
                                            <tr <?php echo $class; ?>>
                                                <td style="width:7%!important;height:40px!important;"><?php echo $intForI; ?></td>
                                                <td style="width:25%!important;height:40px!important;"><?php echo $VendorSaleOrders['resource_order']['order_name']; ?></td>
                                                <td style="width:32%!important;height:40px!important;"><?php echo $VendorSaleOrders['resource_order_detail']['product_name']; ?></td>
                                                <td style="width:13%!important;height:40px!important;">$<?php echo isset($VendorSaleOrders['resource_order_detail']['product_unit_cost']) ? ($VendorSaleOrders['resource_order_detail']['product_unit_cost']) : '0.00'; ?></td>
                                                <td style="width:13%!important;height:40px!important;">$<?php echo isset($VendorSaleOrders['resource_order_detail']['vendor_cost']) ? $VendorSaleOrders['resource_order_detail']['vendor_cost'] : '0.00'; ?></td>
                                                <td style="width:13%!important;height:40px!important;">$<?php echo isset($VendorSaleOrders['resource_order_detail']['portal_owner_cost']) ? $VendorSaleOrders['resource_order_detail']['portal_owner_cost'] : '0.00'; ?></td>
                                                <td style="width:13%!important;height:40px!important;">$<?php echo isset($VendorSaleOrders['resource_order_detail']['hc_profit_cost']) ? ($VendorSaleOrders['resource_order_detail']['hc_profit_cost']) : '0.00'; ?></td>
                                                <td style="width:13%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($VendorSaleOrders['resource_order_detail']['order_detail_creation_date_time'])); ?></td>
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
                                    <td colspan='5'><span style="margin-left:20%;">No total sales for <?php echo stripslashes($vendorName);?></span></td>
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
    
    function fnVendorSalesOrderExport()
    {
	var PortalId = '<?php echo $portalId;?>';
        var strStartDate = '<?php echo $strStartDate;?>';
        var strEndDate = '<?php echo $strEndDate;?>';
         var strVendor = '<?php echo $strVendorId;?>';
         var strVendorName = '<?php echo $vendorName;?>';
		
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
            type: "GET",
            url: appBaseU+"adminanalytics/vendorOrderSalesExport",
            data: 'StartDate='+strStartDate+"&EndDate="+strEndDate+"&portalId="+PortalId+"&Vendor="+strVendor+"&VendorName="+strVendorName,
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
  padding-left: 10px !important;
  width: 6% !important;
}
 .export-btn {
      float: right;
      margin-bottom: 13px;
      margin-top: -37px;
    }
</style>