<style>
    .user-orders th:nth-child(2), .user-orders td:nth-child(2)
    {
        width:25% !important;
    }
    .user-orders th:nth-child(3), .user-orders td:nth-child(3)
    {
        width:11% !important;
    }
</style>
<div class="tab-header">
    <h3>My Orders</h3>
</div>

<!-- USER ORDERS CONTENT -->
<div class="tab-row-container">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-heading user-orders">
            <table>
                <tr>
                    <th>Order #</th>
                    <th>Service Title</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Purchase Date</th>
                </tr>
            </table>
        </div>
        <div class="panel-body user-orders">
            <table>

                <?php
//                print("<pre>");
//                print_r($arrProductList);
                $intForCnt = 0;
                if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                    foreach ($arrProductList as $arrTletterDetail) {
                        //echo "---". $intPid = $arrTletterDetail['Resourceorderdetail']['product_id'];
                        //echo "<pre>";
                        //print_r($arrTletterDetail);
                        $intForCnt++;
                        $strProductDownloadUrl = Router::url(array('controller' => 'myorders', 'action' => 'downloaddetail', $intPortalId, $arrTletterDetail['Resourceorderdetail']['order_detail_id']), true);
                        $strProductEditUrl = Router::url(array('controller' => 'myorders', 'action' => 'orderdetail', $intPortalId, $arrTletterDetail['Resourceorderdetail']['order_detail_id']), true);
                        $producttype = $arrTletterDetail['service']['Resources']['product_type'];
                        $strProductUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $arrTletterDetail['Resourceorderdetail']['vendor_service_id']), true);
                        $intProdId = $arrTletterDetail['Resourceorderdetail']['order_detail_id'];


                        $strProductAccessUrl = $arrTletterDetail['service']['Resources']['product_access_link'];
                        //echo "<pre>";
                        //print_r($arrTletterDetail);
                        ?>

                        <tr id="my_order_row_<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id']; ?>">
                            <td class="td-tall"><?php echo $intForCnt; ?></td>
                            <td id="my_order_service_<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id']; ?>">
                                <div class="user-title">
                                    <a class="username-clickable" id="order1" href="#order1-options<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id']; ?>"><?php
                                        echo $arrTletterDetail['service']['Resources']['product_name'];
                                        ?>
                                    </a>
                                </div>
                                <div class="user-options" id="order1-options<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id']; ?>">
                                    <a class="link-primary" href="<?php echo $strProductUrl; ?>">View</a> |
                                    <a class="link-primary" href="javascript:void(0);" onclick="fnPrintInvoice('<?php echo $intProdId; ?>')">Print Invoice</a> |
                                    <a class="link-primary" href="mailto:support@careersupportnetwork.com" target="_top">Contact Support</a>
                                </div>
                            </td>
                            <td>
                                <?php
                                if ($producttype != "SkillSoftcourse") {
                                    if ($producttype != "Course") {
                                        ?>

                                        <?php echo $arrTletterDetail['Resourceorderdetail']['vendor_order_state']; ?></td>
                                    <?php
                                }
                            }
                            ?> 
                            </td>
                            <?php
                            if ($producttype == "Course") {

                                $username = $vendoraccountdetail['CandidateVendorAccount']['candidate_vendor_account_uname'];
                                $password = $vendoraccountdetail['CandidateVendorAccount']['candidate_vendor_account_pass'];
                                $linkbest = "https://www.interviewbest.com/login?user=" . $username . "&pass=" . $password;

                                $linkbest = Router::url(array('controller' => 'candidates', 'action' => 'course', $intPortalId, $arrTletterDetail['Resourceorderdetail']['product_id']), true);

                                if ($arrTletterDetail['Resourceorderdetail']['refund_status']) {
                                    echo "<td>Cancelled & Refunded</td>";
                                } else {
                                    ?>
                                    <td><button class="btn btn-access"  target="_blank" onclick="javascript:window.open('<?php echo $linkbest; ?>', 'windowname', ' width=800,height=400')" type="button">Access My Purchase</button></td>
                                    <?php
                                }
                            } else if ($producttype == "SkillSoftcourse") {
                                $linkbest = Router::url(array('controller' => 'candidates', 'action' => 'course', $intPortalId, $arrTletterDetail['Resourceorderdetail']['product_id']), true);

                                //$linkbest = $arrTletterDetail['Resourceorderdetail']['accessLink'];

                                if ($arrTletterDetail['Resourceorderdetail']['refund_status']) {
                                    echo "<td>Cancelled & Refunded</td>";
                                } else {
                                    ?>
                                    <td><button class="btn btn-access"  target="_blank" onclick="javascript:window.open('<?php echo $linkbest; ?>', 'windowname', ' width=800,height=400')" type="button">Access My Purchase</button></td>
                                    <?php
                                }
                            } else {
                                if ($arrTletterDetail['Resourceorderdetail']['refund_status']) {
                                    echo "<td>Cancelled & Refunded</td>";
                                } else {
//                                    if ($arrTletterDetail['service']['Resources']['product_access_link']) {
                                        ?>
                                        <!--<td><a href="<?php echo $strProductAccessUrl; ?>" target="_blank"><button class="btn btn-access" type="button">Access My Purchase</button></a></td>-->
                                        <?php
//                                    } else {
                                        ?>
                                        <?php if($arrTletterDetail['Resourceorderdetail']['order_detail_id'] !='' && $arrTletterDetail['service']['Resources']['product_file'] !='' ){?>
                                            <td><button class="btn btn-access" onclick="javascript:location.href = '<?php echo $strProductDownloadUrl; ?>'" type="button">Access My Purchase</button></td>
                                        <?php }else{ ?>
                                             <td><button class="btn btn-access" onclick="javascript:location.href = '<?php echo $strProductEditUrl; ?>'" type="button">Access My Purchase</button></td> 
                                       <?php } ?>
                                        <?php
//                                    }
                                }
                            }
                            ?>
                             
                            <td><?php echo date($productdateformat, strtotime($arrTletterDetail['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>
                        </tr>


                        <?php
                    }
                } else {
                    ?>
                    <tr id="no_tl_row">
                        <td colspan="7">There are no orders placed yet</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <!--<div class="panel-footer user-orders">
                                <table>
                                        <tr>
                                                <th>Order #</th>
                                                <th>Service Title</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th>Purchase Date</th>
                                        </tr>
                                </table>
                        </div>
                </div>

                <div class="panel panel-default hidden-md hidden-lg">
                        <div class="panel-heading small">
                                <table>
                                        <tr>
                                                
                                                <th class="sorting-able col-xs-6 col-sm-6">Service Title</th>
                                                <th class="col-xs-6 col-sm-6">Options</th>
                                        </tr>
                                </table>
                        </div>
                        <div class="panel-body small">
                                <table>
                                        <tr>
                                                <td>
                                                        <div class="user-title">
                                                                <a class="username-clickable">Service Title</a>

                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="user-options visible">
                                                                <a href="#" class="link-primary">View</a> |
                                                                <a href="#" class="link-primary">Print Invoice</a> |
                                                                <a href="#" class="link-primary">Contact Support</a>
                                                        </div>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <div class="user-title">
                                                                <a class="username-clickable">Service Title</a>

                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="user-options visible">
                                                                <a href="#" class="link-primary">View</a> |
                                                                <a href="#" class="link-primary">Print Invoice</a> |
                                                                <a href="#" class="link-primary">Contact Support</a>
                                                        </div>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <div class="user-title">
                                                                <a class="username-clickable">Service Title</a>

                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="user-options visible">
                                                                <a href="#" class="link-primary">View</a> |
                                                                <a href="#" class="link-primary">Print Invoice</a> |
                                                                <a href="#" class="link-primary">Contact Support</a>
                                                        </div>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <div class="user-title">
                                                                <a class="username-clickable">Service Title</a>

                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="user-options visible">
                                                                <a href="#" class="link-primary">View</a> |
                                                                <a href="#" class="link-primary">Print Invoice</a> |
                                                                <a href="#" class="link-primary">Contact Support</a>
                                                        </div>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <div class="user-title">
                                                                <a class="username-clickable">Service Title</a>

                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="user-options visible">
                                                                <a href="#" class="link-primary">View</a> |
                                                                <a href="#" class="link-primary">Print Invoice</a> |
                                                                <a href="#" class="link-primary">Contact Support</a>
                                                        </div>
                                                </td>
                                        </tr>
                                </table>
                        </div>
                        <div class="panel-footer small">
                                <table>
                                        <tr>
                                                
                                                <th class="sorting-able col-xs-6 col-sm-6">Service Title</th>
                                                <th class="col-xs-6 col-sm-6">Options</th>
                                        </tr>
                                </table>

                        </div>
                </div>
        </div>-->





        <script type="text/javascript">
            $(document).ready(function () {
                $('.username-clickable').click(function () {
                    var strDestLoc = $(this).attr('href');
                    //alert("hello");
                    $(strDestLoc).toggle();
                });
            });

            function fnPrintInvoice(intProdId)
            {
                //alert("Hi");
                //return false;

                var intPortalId = "<?php echo $intPortalId; ?>";
                $('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image
                $.ajax({
                    type: "GET",
                    url: strBaseUrl + "candidates/getinvoice/" + intPortalId + "/" + intProdId,
                    dataType: 'json',
                    data: "",
                    async: false,
                    cache: false,
                    success: function (data)
                    {
                        if (data.status == "success")
                        {
                            var strFname = data.filename;
                            var strUrlTOpen = appBaseU + "candidate_invoice/" + strFname;
                            window.open(strUrlTOpen);
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