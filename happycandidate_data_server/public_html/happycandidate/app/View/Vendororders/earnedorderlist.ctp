<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Total Amount Earned Order(s)</h1>
                <div class="tab-row-container">
                    <p>Listed are all total amount earned order(s)</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fnExportSalesOrder()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading vendor-orders">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Item Purchased</th>
                                    <th>Order Status</th>
                                    <th>Assigned To</th>
                                    <th>Assigned Date</th>
                                    <th>Closed Date</th>
                                    <th>Amount Earned</th>
                                </tr>
                            </table>
                        </div>
                        <?php if (is_array($arrProductList) && (count($arrProductList) > 0)) { ?>
                            <div class="panel-body vendor-orders">
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
                                                    <a href="#order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" id="task1" class="username-clickable"><?php echo $arrContent['mainorder']['Resourceorder']['order_name']; ?></a>
                                                </div>
                                            </td>
                                            <td><?php echo stripslashes($arrContent['service']['Resources']['product_name']); ?></td>
                                            <td ><?php echo $arrContent['Resourceorderdetail']['vendor_order_state']; ?></td>
                                            <?php
                                            if ($arrContent['Resourceorderdetail']['vendor_type'] == 'vendor') {
                                                ?>
                                                <td><?php
                                                    if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                        echo $arrSubVendorUser['Vendors']['vendor_first_name'] . " " . $arrSubVendorUser['Vendors']['vendor_last_name'];
                                                    } else {
                                                        echo "Not Assigned";
                                                    }
                                                    ?></td>

                                                <?php
                                            } else {
                                                ?>
                                                <td><?php
                                                    if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                        echo $arrSubVendorUser['Vendors']['vendor_first_name'] . " " . $arrSubVendorUser['Vendors']['vendor_last_name'];
                                                    } else {
                                                        echo "Not Assigned";
                                                    }
                                                    ?></td>

                                                <?php
                                            }
                                            ?>
                                            <td><?php
                                                if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                    echo date($productdateformat, strtotime($arrSubVendorUser['Subvendororders']['inserted_date_time']));
                                                } else {
                                                    echo "NA";
                                                }
                                                ?></td>
                                            <td><?php
                                                if ($arrContent['Resourceorderdetail']['vendor_order_close_date'] != '0000-00-00') {
                                                    echo date($productdateformat, strtotime($arrContent['Resourceorderdetail']['vendor_order_close_date']));
                                                } else {
                                                    echo "NA";
                                                }
                                                ?></td>
                                            <?php
                                            if ($arrContent['Resourceorderdetail']['refund_status']) {
                                                ?>
                                                <td><?php echo "$ 0.00"; ?></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td><?php echo "$ " . $arrContent['Resourceorderdetail']['vendor_cost'] ?></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>

                                        <tr id="order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" class="hide-str">
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
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td colspan='6' class="altrow">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan='6'><span style="margin-left:40%;">No Earned Order(s)</span></td>
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
    <?php
    echo $this->element('refund_confirmation');
    echo $this->element('close_confirmation');
    ?>

<style>
    .export-btn {
      float: right;
      margin-bottom: 13px;
      margin-top: -37px;
    }
</style>
<script src="http://www.rothrsolutions.com/happycandidate/app/webroot/js/jquery.tablesorter.js" type="text/javascript"></script>
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
    
    function fnLoadSubVendorList(ele)
    {
        var strVDetail = $(ele).attr('id');
        var strAction = $(ele).text();

        var arrVDetail = strVDetail.split("_");
        var intOrderId = arrVDetail[2];
        $('#vendor_order_id').val(intOrderId);
        $('#action').val(strAction);

        if (strAction == "Assign")
        {
            $('#assignbtn').show();
            $('#unassignbtn').hide();
        } else
        {
            $('#unassignbtn').show();
            $('#assignbtn').hide();
        }


        $('#subvendorModal').modal('show');
    }

    function fnConfirmRefund(intInquiryId)
    {
        $('#refund_for').val(intInquiryId);
        $("#refund_order").modal('show');
    }

    function fnExportSalesOrder()
    {
        var strStartDate = $('#from_date_hid').val();
        var strEndDate = $('#to_date_hid').val();
        var vendors = $("#vendors").val();
        var filterType = $("#filterType").val();
        var reportType = $("#report_type").val();

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "vendororders/salesexport?",
            data: 'StartDate=' + strStartDate + "&EndDate=" + strEndDate + "&Vendors=" + vendors+"&reportType="+reportType+"&filterType="+filterType,
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

                //alert(data);
                //$("#state_city").html();
                //$("#state_city").html(data);
            }
        });
    }

        
    function fnExportSalesOrder()
        {
            var strStartDate = '<?php echo $selected_start_date; ?>';
            var strEndDate = '<?php echo $selected_end_date;?>';
            var vendors = '<?php echo $selected_vendor;?>'
            var filterType = '<?php echo $selected_filter_type;?>';
            var reportType = '<?php echo $selected_report_type;?>';

            $('.cms-bgloader-mask').show();//show loader mask
            $('.cms-bgloader').show(); //show loading image
            $.ajax({
                type: "GET",
                url: appBaseU + "vendororders/salesexport?",
                data: 'StartDate=' + strStartDate + "&EndDate=" + strEndDate + "&Vendors=" + vendors+"&reportType="+reportType+"&filterType="+filterType,
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

                    //alert(data);
                    //$("#state_city").html();
                    //$("#state_city").html(data);
                }
            });
        }
</script>