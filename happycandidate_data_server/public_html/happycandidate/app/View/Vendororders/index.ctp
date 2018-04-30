<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });

</script>
<?php
$columnName = $_SESSION['productcolumn'];
$sort = $_SESSION['productsort']; 

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
                <h1>My Orders</h1>
                <div class="tab-row-container">
                    <div class="tab-filters">
                        <a href="<?php echo $strVendorOrdersUrl; ?>" class="active">All </a> |
                        <a href="<?php echo $strAdminNewUrl; ?>"  class="link-primary">New </a> |
                        <a href="<?php echo $strAdminOpenUrl; ?>" class="link-primary">Open</a> |
                        <a href="<?php echo $strAdminPendingUrl; ?>" class="link-primary">Pending</a> |
                        <a href="<?php echo $strAdminClosedUrl; ?>" class="link-primary">Closed</a>
                    </div>

                    <!-- CONTENT -->
                    <div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
                        <div class="panel-heading vendor-orders">
                            <table class="tablesorter panel-heading admin-content" id="sort_list">
                                <input type="hidden" id="sort" value="desc">
                        <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th class="header">Item Purchased<span></span></th>
                                    <!--<th class="header headerSortDown" onclick="sortTable('product_name');">Item Purchased<span></span></th>-->
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <!--<th>Assigned Date</th>-->
                                    <!--<th style="width:61px !important">Closed Date</th>-->
                                    <!--<th style="width:80px !important">Purchase Date</th>-->
                                    <th class="action">Action</th>

                                </tr>
                        </thead>
                        <tbody class="panel-body admin-content" id="sortRecords">
                                <?php
                                if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                                    $intContentCount = 0;
                                    foreach ($arrProductList as $arrContent) {
//                                        echo '<pre>';print_r($arrContent);
                                        $intContentCount++;
                                        $strProductEditUrl = Router::url(array('controller' => 'vendororders', 'action' => 'orderdetail', $arrContent['Resourceorderdetail']['order_detail_id']), true);
                                        $strPreviewUrl = Router::url(array('controller' => 'vendors', 'action' => 'preview', "5", $arrContent['vendors']['vendor_id']), true);
                                        $arrSubVendorUser = $arrContent['vendorsuser'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $intContentCount; ?>
                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>" id="task1" class="username-clickable"><?php echo isset($arrContent['mainorder']['Resourceorder']['order_name']) ? $arrContent['mainorder']['Resourceorder']['order_name'] : '--'; ?></a>
                                                </div>
                                            </td>
                                            <td><?php echo isset($arrContent['Resourceorderdetail']['product_name']) ? stripslashes($arrContent['Resourceorderdetail']['product_name']) : '--'; ?></td>
                                            <td id="order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>"><?php echo $arrContent['Resourceorderdetail']['vendor_order_state']; ?></td>
                                            <td><?php
                                                if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                    echo $arrSubVendorUser['Vendors']['vendor_first_name'] . " " . $arrSubVendorUser['Vendors']['vendor_last_name'];
                                                } else {
                                                    echo "Not Assigned";
                                                }
                                                ?>
                                            </td>
<!--                                            <td>
                                                <?php
                                                if (is_array($arrSubVendorUser) && (count($arrSubVendorUser) > 0)) {
                                                    echo date($productdateformat, strtotime($arrSubVendorUser['Subvendororders']['inserted_date_time']));
                                                } else {
                                                    echo "NA";
                                                }
                                                ?>
                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                <?php
                                                if ($arrContent['Resourceorderdetail']['vendor_order_close_date'] != '0000-00-00') {
                                                    echo date($productdateformat, strtotime($arrContent['Resourceorderdetail']['vendor_order_close_date']));
                                                } else {
                                                    echo "NA";
                                                }
                                                ?>
                                            </td>-->
                                            <!--<td style="width:80px !important"><?php echo date($productdateformat, strtotime($arrContent['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>-->
                                            <td>
                                                <a href="<?php echo $strProductEditUrl; ?>" class="link-primary">View</a> |
                                                    <a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a>  |
                                                    <?php
                                                    if ($arrLoggedUser['parent_vendor']) {
                                                        
                                                    } else {
                                                        ?>
                                                        <a id="vendor_order_<?php echo $arrContent['Resourceorderdetail']['order_id']; ?>" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_<?php echo $arrContent['Resourceorderdetail']['order_id']; ?>" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                        <?php
                                                    }
                                                    ?>
                                                    <a onclick="fnConfirmInquiryClose('<?php echo $arrContent['Resourceorderdetail']['order_detail_id']; ?>')" href="javascript:void(0);" class="link-primary">Close</a>
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
                    <div class="pagination pagination-large">
                        <ul class="pagination">
                            <?php
                            if($columnName !='' && $sort !=''){
                                $this->Paginator->options['url'] = array('controller' => 'resource', 'action' => 'index',"?Sort=".$sort."&Column=".($columnName).""); 
                            }
                            echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 12));
                            echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo $this->element('subvendor_assign_modal');
    ?>	  
   <link rel="stylesheet" type="text/css" href="/happycandidate/css/website.css">
    <script type="text/javascript">
        $(".panel-body.vendor-orders .user-title a").click(function (event) {
            event.preventDefault();
            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
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
    </script>
    
    <script type="text/javascript">
    $(document).ready(function ()
    {
        $("#sort_list").tablesorter({
            headers: {1: {sorter: false},3: {sorter: false},4: {sorter: false},5: {sorter: false},6: {sorter: false}},
        });
        $('.action').removeClass('header');
        
//        var sort = '<?php echo $sort;?>';
//        var columnName = '<?php echo $columnName;?>';
//        if(sort == "asc"){
//          $("#sort").val("desc");
//        }else if(sort == "desc"){
//          $("#sort").val("asc");
//        }
    });
    
//    Pending work sort with ajax all pages
//    function sortTable(columnName){
//    var sort = $("#sort").val();
//    $.ajax({
//     url:strBaseUrl+"resource/index",
//     type:'post',
//     data:{columnName:columnName,sort:sort},
//     dataType: 'json',
//     success: function(response){
//        if(response.count.length > 20){   
//            $(".pagination ul li").next().removeAttr("class");
//            $(".pagination ul li:nth-child(2)").attr("class",'active');
//        }
//        $("#sortRecords").html('');
//        $("#sortRecords").html(response.content);
//        $("#sort_pagi").html('');
//        $("#sort_pagi").html(response.pagidiv);
//      if(sort == "asc"){
//        $("#sort").val("desc");
//      }else{
//        $("#sort").val("asc");
//      }
//
//     }
//    });
//   }
</script>
    
    <style>
/*        .panel-heading th:nth-child(2), .panel-body td:nth-child(2), .panel-footer th:nth-child(2) {
            width: 15% !important;
        }*/
        .panel-heading th:nth-child(2), .panel-body td:nth-child(2), .panel-footer th:nth-child(2) {
            width: 18% !important;
        }
        .panel-heading th:nth-child(3), .panel-body td:nth-child(3), .panel-footer th:nth-child(3) {
            width: 22% !important;
        }
        .panel-heading th:nth-child(4), .panel-body td:nth-child(4), .panel-footer th:nth-child(4) {
            width: 12% !important;
        }
        .panel-heading th:nth-child(5), .panel-body td:nth-child(5), .panel-footer th:nth-child(5) {
            width: 16% !important;
        }
        .panel-heading th:nth-child(6), .panel-body td:nth-child(6), .panel-footer th:nth-child(6) {
            width: 35% !important;
        }
        
        .tab-row-container .panel-heading th, .tab-row-container .panel-body td, .tab-row-container .panel-footer th {
            line-height: 147% !important;
        }
        .admin-content tr {
            border: 1px solid #ccc !important;
        }
    </style>