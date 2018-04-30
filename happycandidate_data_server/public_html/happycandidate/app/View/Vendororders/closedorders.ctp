<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });

</script>
<?php
$strAdminHomeUrl = Router::url(array('controller' => 'vendoraccount', 'action' => 'dashboard'), true);
$strVendorOrdersUrl = Router::url(array('controller' => 'vendororders', 'action' => 'index'), true);
$strAdminNewUrl = Router::url(array('controller' => 'vendororders', 'action' => 'neworders'), true);
$strAdminOpenUrl = Router::url(array('controller' => 'vendororders', 'action' => 'openorders'), true);
$strAdminPendingUrl = Router::url(array('controller' => 'vendororders', 'action' => 'pendingorders'), true);
$strAdminClosedUrl = Router::url(array('controller' => 'vendororders', 'action' => 'closedorders'), true);
?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Closed Orders</h1>
               <!-- <p>Sed cursus id libero molestie ullamcorper. Nullam cursus mauris in enim interdum varius. Integer ex risus, dignissim nec placerat ac, mattis vitae augue.</p>-->

                <div class="tab-row-container">
                    <div class="tab-filters">
                        <a class="link-primary" href="<?php echo $strVendorOrdersUrl; ?>">All</a> |
                        <a class="link-primary" href="<?php echo $strAdminNewUrl; ?>">New</a> |
                        <a class="link-primary" href="<?php echo $strAdminOpenUrl; ?>">Open</a> |
                        <a class="link-primary" href="<?php echo $strAdminPendingUrl; ?>">Pending</a> |
                        <a class=" active" href="<?php echo $strAdminClosedUrl; ?>">Closed</a>
                    </div>

                    <!-- CONTENT -->
                    <div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
                        <table class="tablesorter panel-heading vendor-orders" id="sort_list" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="header">ID</th>
                                        <th>Order ID</th>
                                        <th class="header">Item Purchased</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th>Purchase Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                        <tbody class="panel-body vendor-orders" id="sortRecords">
                                    <?php
                                    if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                                        $intContentCount = 0;
                                        foreach ($arrProductList as $arrContent) {
                                            $intContentCount++;
                                            $strProductEditUrl = Router::url(array('controller' => 'vendororders', 'action' => 'orderdetail', $arrContent['Resourceorderdetail']['order_detail_id']), true);
                                            $strPreviewUrl = Router::url(array('controller' => 'vendors', 'action' => 'preview', "5", $arrContent['vendors']['vendor_id']), true);
                                            $arrSubVendorUser = $arrContent['vendorsuser'];
                                            ?>

                                            <tr id="product_list_<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" >
                                                <td>
                                                    <?php echo $intContentCount; ?>												
                                                </td>
                                                <td>
                                                    <div class="user-title">
                                                        <a class="username-clickable" id="task1" href="#str<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>"><?php echo isset($arrContent['mainorder']['Resourceorder']['order_name']) ? $arrContent['mainorder']['Resourceorder']['order_name'] : '--'; ?></a>
                                                    </div>
                                                </td>

                                                <td><?php echo isset($arrContent['Resourceorderdetail']['product_name']) ? stripslashes($arrContent['Resourceorderdetail']['product_name']) : '--'; ?></td>
                                                <td><?php echo $arrContent['Resourceorderdetail']['vendor_order_state']; ?></td>
                                                <td>
                                                    <?php
                                                        if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                            echo $arrSubVendorUser['Vendors']['vendor_first_name'] . " " . $arrSubVendorUser['Vendors']['vendor_last_name'];
                                                        } else {
                                                            echo "Not Assigned";
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo date($productdateformat, strtotime($arrContent['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>
                                                <td>
                                                    <a class="link-primary" href="<?php echo $strProductEditUrl; ?>">View</a> |
                                                    <a class="link-primary" href="#">Close</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- SMALL TABLE -->
                    <div class="pagination pagination-large">
                        <ul class="pagination">
                            <?php
                            echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
                            echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->element('close_confirmation');
?>

<link rel="stylesheet" type="text/css" href="/happycandidate/css/website.css">
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#sort_list").tablesorter({
            headers: {1: {sorter: false},3: {sorter: false},4: {sorter: false},5: {sorter: false},6: {sorter: false}},
        });
        $('.action').removeClass('header');
    });
    $(".panel-body.vendor-orders .user-title a").click(function (event) {

        $(this.getAttribute("href")).css('display', 'table-row');
        $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
        event.preventDefault();
    });

</script>

 <style>
        .panel-heading th:nth-child(2), .panel-body td:nth-child(2), .panel-footer th:nth-child(2) {
            width: 18% !important;
        }
        .panel-heading th:nth-child(3), .panel-body td:nth-child(3), .panel-footer th:nth-child(3) {
            width: 18% !important;
        }
        .panel-heading th:nth-child(4), .panel-body td:nth-child(4), .panel-footer th:nth-child(4) {
            width: 12% !important;
        }
        .panel-heading th:nth-child(5), .panel-body td:nth-child(5), .panel-footer th:nth-child(5) {
            width: 18% !important;
        }
        .panel-heading th:nth-child(6), .panel-body td:nth-child(6), .panel-footer th:nth-child(6) {
            width: 16% !important;
        }
        .panel-heading th:nth-child(7), .panel-body td:nth-child(7), .panel-footer th:nth-child(7) {
            width: 18% !important;
        }
        
        .tab-row-container .panel-heading th, .tab-row-container .panel-body td, .tab-row-container .panel-footer th {
            line-height: 147% !important;
        }
        .admin-content tr {
            border: 1px solid #ccc !important;
        }
    </style>
