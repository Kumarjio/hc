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
                <h1>Open Orders</h1>
                <div class="tab-row-container">
                    <div class="tab-filters">
                        <a class="link-primary" href="<?php echo $strVendorOrdersUrl; ?>">All </a> |
                        <a class="link-primary" href="<?php echo $strAdminNewUrl; ?>">New </a> |
                        <a class="active" href="<?php echo $strAdminOpenUrl; ?>">Open </a> |
                        <a class="link-primary" href="<?php echo $strAdminPendingUrl; ?>">Pending </a> |
                        <a class="link-primary" href="<?php echo $strAdminClosedUrl; ?>">Closed </a>
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
                        <tbody class="panel-body admin-content" id="sortRecords">
                                                                        <tr>
                                            <td>
                                                1                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str223" id="task1" class="username-clickable">OD001505461766</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_223"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                September 15, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/223" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/223" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_279" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_279" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('223')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                2                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str200" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_200">Closed</td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 31, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                November 28, 2017                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/200" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/200" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_258" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_258" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('200')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                3                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str196" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_196"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/196" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/196" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_254" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_254" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('196')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                4                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str189" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_189"></td>
                                            <td>Herb Cogliano                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/189" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/189" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_250" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_250" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('189')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                5                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str190" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_190"></td>
                                            <td>Herb Cogliano                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/190" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/190" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_250" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_250" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('190')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                6                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str183" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_183"></td>
                                            <td>Herb Cogliano                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/183" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/183" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_248" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_248" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('183')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                7                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str184" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_184"></td>
                                            <td>Herb Cogliano                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/184" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/184" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_248" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_248" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('184')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                8                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str181" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_181"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/181" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/181" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_247" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_247" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('181')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                9                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str180" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_180"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/180" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/180" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_246" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_246" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('180')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                10                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str179" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_179"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/179" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/179" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_245" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_245" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('179')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                11                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str178" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_178"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/178" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/178" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_244" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_244" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('178')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                12                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str177" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_177"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/177" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/177" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_243" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_243" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('177')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                13                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str176" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_176"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/176" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/176" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_242" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_242" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('176')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                14                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str175" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_175"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/175" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/175" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_241" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_241" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('175')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                15                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str174" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_174"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/174" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/174" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_240" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_240" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('174')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                16                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str173" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_173"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/173" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/173" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_239" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_239" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('173')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                17                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str172" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_172"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/172" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/172" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_238" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_238" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('172')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                18                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str171" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_171"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/171" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/171" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_237" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_237" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('171')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                19                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str170" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_170"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/170" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/170" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_236" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_236" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('170')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                20                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str169" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_169"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/169" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/169" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_235" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_235" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('169')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                21                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str168" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_168"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/168" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/168" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_234" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_234" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('168')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                22                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str163" id="task1" class="username-clickable">--</a>
                                                </div>
                                            </td>
                                            <td>New Test One Course</td>
                                            <td id="order_status_163"></td>
                                            <td>R Course Vendor                                            </td>
<!--                                            <td>
                                                August 30, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">January 01, 1970</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/163" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/163" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_229" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_229" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('163')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                23                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str99" id="task1" class="username-clickable">OD001493971068</a>
                                                </div>
                                            </td>
                                            <td>Testing Latest Course New</td>
                                            <td id="order_status_99">Closed</td>
                                            <td>Not Assigned                                            </td>
<!--                                            <td>
                                                NA                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                November 23, 2017                                            </td>-->
                                            <!--<td style="width:80px !important">May 05, 2017</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/99" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/99" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_168" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_168" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('99')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                24                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str84" id="task1" class="username-clickable">OD001472108413</a>
                                                </div>
                                            </td>
                                            <td>course testing</td>
                                            <td id="order_status_84">In-Process</td>
                                            <td>Employee One 1                                            </td>
<!--                                            <td>
                                                May 23, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">August 25, 2016</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/84" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/84" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_154" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_154" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('84')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                25                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str83" id="task1" class="username-clickable">OD001472107262</a>
                                                </div>
                                            </td>
                                            <td>Latest test course</td>
                                            <td id="order_status_83">New Order</td>
                                            <td>Not Assigned                                            </td>
<!--                                            <td>
                                                NA                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">August 25, 2016</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/83" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/83" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_153" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_153" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('83')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                26                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str82" id="task1" class="username-clickable">OD001472033872</a>
                                                </div>
                                            </td>
                                            <td>Testing Latest Course New</td>
                                            <td id="order_status_82">Closed</td>
                                            <td>Not Assigned                                            </td>
<!--                                            <td>
                                                NA                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                November 23, 2017                                            </td>-->
                                            <!--<td style="width:80px !important">August 24, 2016</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/82" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/82" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_152" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_152" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('82')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
                                                                                <tr>
                                            <td>
                                                27                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <a href="#str81" id="task1" class="username-clickable">OD001472033444</a>
                                                </div>
                                            </td>
                                            <td>Testing Latest Course New</td>
                                            <td id="order_status_81">Pending</td>
                                            <td>Employee One 1                                            </td>
<!--                                            <td>
                                                November 23, 2017                                            </td>-->
<!--                                            <td style="width:61px !important">
                                                NA                                            </td>-->
                                            <!--<td style="width:80px !important">August 24, 2016</td>-->
                                            <td>
                                                <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/81" class="link-primary">View</a> |
                                                    <a href="http://www.rothrsolutions.com/happycandidate/vendororders/orderdetail/81" class="link-primary">Edit</a>  |
                                                                                                            <a id="vendor_order_151" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Assign</a>  |

                                                        <a id="vendorua_order_151" href="javascript:void(0);" onclick="fnLoadSubVendorList(this)" class="link-primary">Unassign</a>  |
                                                                                                            <a onclick="fnConfirmInquiryClose('81')" href="javascript:void(0);" class="link-primary">Close</a>
                                            </td>
                                        </tr>
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
