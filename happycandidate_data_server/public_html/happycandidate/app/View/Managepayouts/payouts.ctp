<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });

</script>
<?php
$strProductSearchUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payouts'), true);
$strPayoutUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutsPayment'), true);
$strComissionPayoutUrl = Router::url(array('controller' => 'managepayouts', 'action' => 'payoutsComissionPayment'), true);
?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div id="product_notification"></div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Total Payout Amounts</h1>
                <div class="form-container admin-dashboard-form">
                    <form role="form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="Payout Type">Payout For</label>
                                <select name="payout_type" id="payout_type" class="form-control">
                                    <option value="">Select Payout For</option>
                                    <option value="vendor">Vendor</option>
                                    <option value="owner">Owner</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="Vendors">
                            <div class="form-group">
                                <label class="control-label" for="Vendors">Vendors</label>
                                <select name="vendors" id="vendors" class="form-control">
                                    <option value="">Select Vendor</option>
                                    <option value="all">All Vendor</option>
                                    <?php foreach ($arrVendorDetail as $vendors) { ?>
                                        <option <?php
                                        if ($selected_vendor == $vendors['vendors']['vendor_id']) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $vendors['vendors']['vendor_id']; ?>"> <?php echo stripslashes($vendors['vendor_company_details']['company_name']); ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="Owners">
                            <div class="form-group">
                                <label class="control-label" for="Owners">Owners</label>
                                <select name="owners" id="owners" class="form-control">
                                    <option value="">Select Owner</option>
                                    <option value="all">All Owner</option>
                                    <?php foreach ($arrPortalOwnerDetail as $owners) { ?>
                                        <option <?php
                                        if ($selected_vendor == $owners['user']['id']) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $owners['user']['id']; ?>"> <?php echo stripslashes($owners['user']['username']); ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="custom_dates_cont">
                            <div class="col-md-12" >
                                <label class="control-label" for="period">Custom Dates</label>
                            </div>
                            <div class="col-md-12" style="padding: 0px">
                                <div class="form-group" id="dt-pik-height">
                                    <div class="col-md-4">
                                        From:<input style="width:100%;border-radius:4px;" name="from_date" id="from_date" class="form-control" type="text">
                                        <input id="from_date_hid" class="form-control validate[required]" name="from_date_hid" type="hidden">
                                    </div>
                                    <div class="col-md-4">
                                        To:<input style="width:100%;border-radius:4px;" name="to_date" id="to_date" class="form-control" type="text">
                                        <input id="to_date_hid" class="form-control validate[required]" name="to_date_hid" type="hidden">
                                    </div>
                                    <div class="col-md-2">
                                        &nbsp;<input style="width:100%;" name="go_button" id="go_button" value="Go" onclick="fnGetDataBetweenDates();" class="btn-primary" type="button">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="emp-stat-box-container" id="statistics_count" style="display:none;margin-left:2px;">
                                <div class="emp-stat-box">
                                    <div class="left-side-container" id="portal_statistics_data">

                                    </div>
                                </div>
                                <div class="emp-stat-box" id="ownerComission">
                                    <div class="left-side-container" id="owner_comission_data">

                                    </div>
                                </div>
                                <!--<input id="payout_cost" class="form-control" name="payout_cost" type="hidden">-->

<!--                                <div class="bor-none" id="pay-btn">
                                    <div class="left-side-container" id="payout_btn">

                                    </div>
                                </div>-->
                                
                                <div class="emp-stat-box-container" style="margin-left: 4px;">
                                    <div class="emp-box" id="pay-btn">
                                        <div class="left-side-container" id="payout_btn">
                                            
                                        </div>
                                        <input id="payout_cost" class="form-control" name="payout_cost" type="hidden">
                                    </div>
                                
                                    <div class="emp-box" id="comission_pay_btn">
                                        <div class="left-side-container" id="comission_payout_btn">
                                            
                                        </div>
                                        <input id="comission_payout_cost" class="form-control" name="comission_payout_cost" type="hidden">
                                    </div>
                                </div>
                                
                                
                                

                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#from_date').datetimepicker({
                                    format: 'MM/DD/YYYY',
                                    useCurrent: false
                                });

                                $('#from_date_hid').datetimepicker({
                                    format: 'YYYY-MM-DD'
                                });

                                $('#to_date').datetimepicker({
                                    format: 'MM/DD/YYYY',
                                    useCurrent: false
                                });

                                $('#to_date_hid').datetimepicker({
                                    format: 'YYYY-MM-DD'
                                });

                                $("#from_date").on("dp.change", function (e) {
                                    $('#to_date').data("DateTimePicker").minDate(e.date);
                                    $('#from_date_hid').data("DateTimePicker").date(e.date);
                                });

                                $("#to_date").on("dp.change", function (e) {
                                    $('#from_date').data("DateTimePicker").maxDate(e.date);
                                    $('#to_date_hid').data("DateTimePicker").date(e.date);
                                });
                            });
                        </script>
                    </form>
                </div> 
            </div>

        </div>
    </div>
</div>
<style>
    .bor-none {
        background-color: #fff;
        display: inline-block;
        padding: 17px 20px;
        width: 24.3%;
        margin-left: 23px;
    }
    .page-content-wrapper {
        height: 682px;
        overflow-x: unset;
    }
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: unset;
    }

    .emp-stat-box-container {
        margin-top: 25px !important;
    }
    
    .emp-box {
  display: inline-block;
  margin-right: 74px;
  margin-top: -13px;
  min-width: 171px;
  vertical-align: middle;
  width: 20%;
}
</style>
<script>
    $(document).ready(function () {

        var payouttype = $('#payout_type  option:selected').attr('value');
        if (payouttype != '') {
            if (payouttype == "vendor")
            {
                $('#Vendors').show();
                $('#Owners').hide();
            } else
            {
                $('#Vendors').hide();
                $('#Owners').show();
            }
        } else {
            $('#Vendors').hide();
            $('#Owners').hide();
        }

        var vendors = $('#Vendors option:selected').attr('value');
        if (vendors != '') {
            $('#custom_dates_cont').show();
        } else {
            $('#custom_dates_cont').hide();
        }

        var owners = $('#Owners option:selected').attr('value');
        if (owners != '') {
            $('#custom_dates_cont').show();
        } else {
            $('#custom_dates_cont').hide();
        }
    });

    $('#payout_type').change(function () {
        var payouttype = $('#payout_type  option:selected').attr('value');
        if (payouttype != '') {
            if (payouttype == "vendor")
            {
                $('#Vendors').show();
                $('#Owners').hide();
            } else
            {
                $('#Vendors').hide();
                $('#Owners').show();
            }
        } else {
            $('#Vendors').hide();
            $('#Owners').hide();
        }
    });

    $('#Vendors').change(function () {
        var vendors = $('#Vendors option:selected').attr('value');
        if (vendors != '') {
            $('#custom_dates_cont').show();
        } else {
            $('#custom_dates_cont').hide();
        }
    });

    $('#Owners').change(function () {
        var owners = $('#Owners option:selected').attr('value');
        if (owners != '') {
            $('#custom_dates_cont').show();
        } else {
            $('#custom_dates_cont').hide();
        }
    });

    function fnGetDataBetweenDates()
    {
        var selectedPayoutType = $('#payout_type').val();
        var strFromDate = $('#from_date_hid').val();
        var strToDate = $('#to_date_hid').val();

        if (selectedPayoutType == 'vendor') {
            var Vendors = $('#vendors').val();
        } else {
            var Vendors = '';
        }

        if (selectedPayoutType == 'owner') {
            var Owners = $('#owners').val();
        } else {
            var Owners = '';
        }

        var strPortalStatisticsUrl = "<?php echo $strProductSearchUrl; ?>/";
        var datastrj = "Vendors=" + Vendors + "&Owners=" + Owners + "&PayoutType=" + selectedPayoutType + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate;
        $.ajax({
            type: "POST",
            url: strPortalStatisticsUrl,
            data: datastrj,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image		
            },
            success: function (data)
            {
                var str = '';
                var str1 = '';
                var btn = '';
                var btn1 = '';
                $('#loader').hide();
                if (data.status == "success")
                {
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image		

                    str += "<a href=" + data.list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>" + data.amount + "</h4><p id='portal_statistics_name'>" + data.Title + "</p></a>";
                    $('#portal_statistics_data').html(str);
                    if (selectedPayoutType == 'owner') {
                        $('#ownerComission').show();
                        str1 += "<a href=" + data.list_link1 + " target='_blank'><h4 class='box-success' id='owner_comission_count'>" + data.comission_cost + "</h4><p id='owner_comission_name'>" + data.CPA_Comission + "</p></a>";
                        $('#owner_comission_data').html(str1);
                    }else{
                        $('#ownerComission').hide();
                        
                    }
                    if (data.amount != '$0.00') {
                        btn += "<input style='width:100%;' name='go_button' id='go_button' value='Post Payment' onclick='fnGetPayout();' class='btn-primary' type='button'>";
                        $('#payout_btn').html(btn);
                        $('#payout_cost').val(data.amount);
                        $('#pay-btn').show();
                    } else {
                        btn = '';
                        $('#payout_btn').html(btn);
                        $('#payout_cost').val('$0.00');
                        $('#pay-btn').hide();
                    }
                    if (selectedPayoutType == 'owner') {
                    if (data.comission_cost != '$0.00') {
                        btn1 += "<input style='width:100%;' name='comi_pay_button' id='comi_pay_button' value='Post Comission' onclick='fnGetComissionPayout();' class='btn-primary' type='button'>";
                        $('#comission_payout_btn').html(btn1);
                        $('#comission_payout_cost').val(data.comission_cost);
                        $('#comission_pay_btn').show();
                    } else {
                        btn1 = '';
                        $('#comission_payout_btn').html(btn1);
                        $('#comission_payout_cost').val('$0.00');
                        $('#comission_pay_btn').hide();
                    }
                    }
                    
                    $('#statistics_count').show();
                } else
                {
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image
                    $('#pay-btn').hide();
                }
            }
        });
    }

    function fnGetPayout() {
        var selectedPayoutType = $('#payout_type').val();
        var strFromDate = $('#from_date_hid').val();
        var strToDate = $('#to_date_hid').val();
        var payoutCost = $('#payout_cost').val();

        if (selectedPayoutType == 'vendor') {
            var Vendors = $('#vendors').val();
        } else {
            var Vendors = '';
        }

        if (selectedPayoutType == 'owner') {
            var Owners = $('#owners').val();
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
    
    function fnGetComissionPayout() {
        var selectedPayoutType = $('#payout_type').val();
        var strFromDate = $('#from_date_hid').val();
        var strToDate = $('#to_date_hid').val();
        var payoutCost = $('#comission_payout_cost').val();

        if (selectedPayoutType == 'owner') {
            var Owners = $('#owners').val();
        } else {
            var Owners = '';
        }

        var strPayoutUrl = "<?php echo $strComissionPayoutUrl; ?>/";
        var datastrj = "OwnerId=" + Owners + "&PayoutType=" + selectedPayoutType + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&payoutCost=" + payoutCost;
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