<style>
    /* start tiny mce tabs*/
    .tinymce-tabs {
        height: 30px;
        width:960px;
        margin: 0 auto;
    }
    .tinymce-tabs .html, .tinymce-tabs .visual {
        background-color: #f1f1f1;
        border-color: #dfdfdf #dfdfdf #dfdfdf;
        color: #999999;
        border-style: solid;
        border-width: 1px;
        cursor: pointer;
        float: right;
        height: 26px;
        margin: 5px 0px 0px 0px;
        padding: 4px 5px 2px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        -moz-border-radius-topleft: 3px;
        -moz-border-radius-topright: 3px;
        -webkit-border-top-left-radius: 3px;
        -webkit-border-top-right-radius: 3px;
        text-decoration:none;
    }

    .tinymce-tabs .active {
        background-color: #e9e9e9;
        border-color: #cccccc #cccccc #e9e9e9;
        color: #333333;
    }
    /* end tiny mce tabs*/
</style>
<?php
echo $this->Html->script('highcharts/js/highcharts');
echo $this->Html->script('highcharts/js/modules/data');
echo $this->Html->script('highcharts/js/modules/exporting');
?>
<div class="index container-layout">
    <div id="page-title" class="noprint">
        <h3>Analytics</h3>
    </div>
    <div class="row">
        <table cellpadding="0" cellspacing="0" id="analytic_filter" class="table text-center">
            <tr>
                <th colspan="2">Portals Statistics</th>
            </tr>
            <tr id="portal_chooser">
                <td class="font-bold">Choose Portal:</td>
                <td>
                    <select name="portal_chooser" id="portal_chooser">
                        <option value="all">--All Portals--</option>
                        <?php
                        if (is_array($arrPortalList) && (count($arrPortalList) > 0)) {

                            foreach ($arrPortalList as $arrPortalKey => $arrPortalName) {
                                ?>
                                <option value="<?php echo $arrPortalKey; ?>"><?php echo $arrPortalName; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
<!--            <tr>
                <td class="font-bold">Statistics Type:</td>
                <td>
                    <select name="analytic_type" id="analytic_type">
                        <option value="1">Portal Events Statistics</option>
                        <option value="2">Portal Statistics</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>-->
            <input type="hidden" name="analytic_type" id="analytic_type" value="2">
            <tr id="date_filter_chooser">
                <td class="font-bold">Statistics Filter Type:</td>
                <td>
                    <select name="analytic_filter_type" id="analytic_filter_type">
                        <!--<option value="All">--Choose Statistics--</option>-->
                        <option value="curr_year">Year</option>
                        <option value="30">Month</option>
                        <option value="7">Week</option>
                        <option value="zero">Today</option>
                        <option value="custom">Custom</option>
                    </select>
                </td>
            </tr>
            <tr id="date_filter_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>
<!--            <tr>
                <th colspan="2">Filteration Criteria</th>
            </tr>
            <tr id="event_chooser">
                <td class="font-bold">Choose Event:</td>
                <td>
                    <select name="property_chooser" id="property_chooser">
                        <option value="Registered Users">Registered User</option>
                        <option value="Logged In Users">User Logged In</option>
                        <option value="Logged Out Users">User Logged Out</option>
                        <option value="Confirmed Users">Unconfirmed User</option>
                        <option value="Basic Search">Basic Search</option>
                        <option value="Advance Search">Advance Search</option>
                    </select>
                </td>
            </tr>
            <tr id="event_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>-->
            <tr id="portal_statistics" style="display:none;">
                <td class="font-bold">Choose Portal Statistics:</td>
                <td>
                    <select name="statistic_chooser" id="statistic_chooser">
                        <option value="All">--Choose Statistics--</option>
                        <option value="1">Registered Seekers</option>
                        <option value="5">Active Job Seekers</option>
                        <option value="6">Inactive Job Seekers</option>
                        <option value="2">Portal Owners</option>
                        <option value="3">Active Portal Owners</option>
                        <option value="4">Inactive Portal Owners</option>
                        <option value="15">Last Login Users</option>
                        <option value="7">Job Seekers Completed 15 Steps Process</option>
                        <option value="8">Job Seekers Total Refunded Purchased Products,Services Or Courses</option>
                        <option value="9">Job Seekers Total Sales Purchased Products,Services Or Courses</option>
                        <option value="10">Theme Register Job Seekers</option>
                        <option value="11">Portals Bought And Purchased</option>
                        <option value="12">Portals Sales Cost</option>
                        <option value="13">Total Refunds For Each Vendor</option>
                        <option value="14">Total Sale For Each Vendor</option>
                        <option value="16">Utilizing The CRM Job Seekers</option>
                        <option value="17">Job Boards Using Job Seekers</option>
                        <option value="18">Owners Jobs Posted View Job Seekers</option>
                        <option value="19">New Vendors Added Career Portal</option>
                        <option value="20">Total Paid To Vendor Companies</option>
                        <option value="21">Total Paid To Career Portal Owners</option>
                        <option value="22">Total Unique Visitors Career Portal</option>
                        <option value="23">Total Unique Visitors Registered Career Portal</option>
                        <option value="24">Total Sale For Each Portal Owners</option>
                        <option value="25">Total Refunds For Each Portal Owners</option>
                    </select>
                </td>
            </tr>
            <tr id="portal_statistics_spacer" style="display:none;">
                <td colspan="2">&nbsp;</td>
            </tr>


            <tr id="sale_purchase_filter">
                <td class="font-bold">Sales Filter Type:</td>
                <td>
                    <select name="sales_filter_type" id="sales_filter_type">
                        <option value="All">--Choose Sales Filter Type--</option>
                        <option value="Product">Products</option>
                        <option value="Services">Services</option>
                        <option value="Course">Course</option>
                        <option value="SkillSoftcourse">Skill Soft Course</option>
                    </select>
                </td>
            </tr>
            <tr id="sale_purchase_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr id="vendors_list">
                <td class="font-bold">Vendors:</td>
                <td>
                    <select name="vendors" id="vendors">
                        <option value="">--Choose One--</option>
                        <?php foreach ($arrViewUserDetail as $vendors) { ?>
                            <option <?php
                            if ($selected_vendor == $vendors['Vendors']['vendor_id']) {
                                echo 'selected=selected';
                            }
                            ?> value="<?php echo $vendors['Vendors']['vendor_id']; ?>"> <?php echo $vendors['Vendors']['vendor_first_name'] . " " . $vendors['Vendors']['vendor_last_name']; ?></option>
                            <?php } ?>
                    </select>
                </td>
            </tr>
            <tr id="vendors_list_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr id="vendors_company">
                <td class="font-bold">Choose Vendors Company:</td>
                <td>
                    <select name="vendor_company" id="vendor_company">
                        <option value="">Select Vendor</option>
                        <?php foreach ($arrVendorDetail as $vendors) { ?>
                            <option <?php
                            if ($selected_vendor == $vendors['vendors']['vendor_id']) {
                                echo 'selected=selected';
                            }
                            ?> value="<?php echo $vendors['vendors']['vendor_id']; ?>"> <?php echo stripslashes($vendors['vendor_company_details']['company_name']); ?></option>
                            <?php } ?>
                    </select>
                </td>
            </tr>
            <tr id="vendors_company_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr id="owners_list">
                <td class="font-bold">Choose Owners:</td>
                <td>
                    <select name="owners" id="owners">
                        <option value="">Select Owner</option>
                        <?php foreach ($arrPortalOwnerDetail as $owners) { ?>
                            <option <?php
                            if ($selected_vendor == $owners['user']['id']) {
                                echo 'selected=selected';
                            }
                            ?> value="<?php echo $owners['user']['id']; ?>"> <?php echo stripslashes($owners['user']['username']); ?></option>
                            <?php } ?>
                    </select>
                </td>
            </tr>
            <tr id="owners_list_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr id="date_range">
                <td class="font-bold">Date Range:</td>
                <td>
                    <?php
                    $strFromDate = date('Y-m-d', strtotime('-19 days', strtotime(date('Y-m-d'))));
                    $strTodate = date('Y-m-d');
                    ?>

                    From Date: <input value="<?php echo $strFromDate; ?>" style="width:15%;" type="text" name="from_date" id="from_date" readonly />&nbsp; To Date: <input value="<?php echo $strTodate; ?>" style="width:15%;" type="text" name="to_date" id="to_date" readonly />
                </td>
            </tr>
            <tr id="date_range_spacer">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="font-bold" colspan="2" align="center">
                    <!--<input id="event_button" onclick="fnUpdateGraphData();return false;" type="submit" name="go" id="go" value="GO" />-->
                    <span id="portal_stat_actions" style="display:none;"><input id="portal_stat_button" onclick="return false;" type="submit" name="go" id="go" value="GO" />&nbsp;<input style="display:none;" id="portal_stat_print" onclick="window.print();return false;" type="submit" name="print" id="print" value="Print" /></span>
                </td>
            </tr>
<!--            <tbody id="property_changer_row" style="display:none;">
                <tr>
                    <th colspan="2">Property Wise Filteration</th>
                </tr>
                <tr>
                    <td class="font-bold">Choose Property:</td>
                    <td>
                        <select onchange="fnUpdatePropertyGraphData()" name="property_choose" id="property_choose">
                            <option value="All">--Choose Property--</option>
                            <option value="Country">Country</option>
                            <option value="Region">Region</option>
                            <option value="City">City</option>
                            <option value="Browser">Browser</option>
                            <option value="OS">Operating System</option>
                            <option value="Device">Device</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </tbody>-->
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </div>

    <div class="emp-stat-box-container" id="statistics_count" style="display:none;margin-left:2px;">
        <div class="emp-stat-box">
            <div class="left-side-container" id="portal_statistics_data">

            </div>
        </div>
    </div>

    <div class="emp-stat-box-container" id="themes_count"  style="display:none;margin-left:2px;">

        <div class="emp-stat-box" id="theme1_count">
            <div class="left-side-container" id="portal_theme1_data">

            </div>
        </div>
        <div class="emp-stat-box" id="theme1_count">
            <div class="left-side-container" id="portal_theme2_data">

            </div>
        </div>

        <div class="emp-stat-box" id="theme1_count">
            <div class="left-side-container" id="portal_theme3_data">

            </div>
        </div>
    </div>


    <div class="row" id="analyticevent">
        <div class="tinymce-tabs">
            <a id="lineevent" class="html editor1 event">Line</a>
            <a id="barevent" class="visual editor1 event" class="active">Bar</a>
            <div style="clear: both;"></div>
        </div>
        <div id="admin_graph_container" style="width: 960px; height: 400px; margin: 0 auto"></div>
    </div>
    <div>&nbsp;</div>
    <div id="analyticpropertyResult" class="row" style="display:none;float:left;width:100%;margin:0;padding:0;">
        <div class="tinymce-tabs">
            <a id="lineproperty" class="html editor2 property">Line</a>
            <a id="barproperty" class="visual editor2 property" class="active">Bar</a>
            <div style="clear: both;"></div>
            <input type="hidden" name="barlegendsize" id="barlegendsize" value="" />
        </div>
        <div id="propertycontainernew" style="width: 970px; height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
        <div>&nbsp;</div>
        <div id="propertycontainernewpie" style="width: 970px; height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
    </div>
    <div id="graphsection">
        <img src="<?php Router::url('/', true) ?>img/loader.gif" name="loader" id="loader" style="display:none;margin-left:40%;">
        <div class="row" id="portal_statistics_rows" style="display:none;"></div>
        <div>&nbsp;</div>
        <div id="portal_statistics_graph" style="display:none;width: 970px; height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
    </div>



</div>

<?php
//$strAjaxGraphUrl = Router::url(array('controller'=>'adminanalytics','action'=>'updategraph'),true);
$strAjaxGraphUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'updategraph'), true);
$strAjaxPropertyGraphUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'updatepropertygraph'), true);
$strAjaxPortalStatsUrl = Router::url(array('controller' => 'adminanalytics', 'action' => 'userstatistics'), true);
?>
<script type="text/javascript">
    $(document).ready(function () {
        var anfiltertype = $('#analytic_filter_type  option:selected').attr('value');
        if (anfiltertype != "custom")
        {
            $('#from_date').val('');
            $('#to_date').val('');
        }

//        var strAnalyticType = $('#analytic_type').val();
//        if (strAnalyticType == "2")
//        {
//            $('#date_filter_chooser').show();
//            $('#date_filter_spacer').show();
//        } else {
//            $('#date_filter_chooser').hide();
//            $('#date_filter_spacer').hide();
//        }

        var statisticChooser = $('#statistic_chooser').val();
        if (statisticChooser == "8" || statisticChooser == "9")
        {
            $('#sale_purchase_filter').show();
            $('#sale_purchase_spacer').show();
        } else {
            $('#sale_purchase_filter').hide();
            $('#sale_purchase_spacer').hide();
        }


        if (statisticChooser == "13" || statisticChooser == "14") {
            $('#vendors_list').show();
            $('#vendors_list_spacer').show();
        } else {
            $('#vendors_list').hide();
            $('#vendors_list_spacer').hide();
        }

        if (statisticChooser == "20") {
            $('#vendors_company').show();
            $('#vendors_company_spacer').show();
            $('#portal_chooser').hide();
        } else {
            $('#vendors_company').hide();
            $('#vendors_company_spacer').hide();
            $('#portal_chooser').show();
        }
        
        
        if (statisticChooser == "21") {
            $('#owners_list').show();
            $('#owners_list_spacer').show();
            $('#portal_chooser').hide();
        } else {
            $('#owners_list').hide();
            $('#owners_list_spacer').hide();
            $('#portal_chooser').show();
        }
        
        if (statisticChooser == "24" || statisticChooser == "25") {
            $('#owners_list').show();
            $('#owners_list_spacer').show();
//            $('#portal_chooser').hide();
        } else {
            $('#owners_list').hide();
            $('#owners_list_spacer').hide();
//            $('#portal_chooser').show();
        }

//        $('#analytic_type').change(function () {
            var strAnalyticType = $('#analytic_type').val();
            if (strAnalyticType == "2")
            {
                $('#event_chooser').hide();
                $('#event_spacer').hide();
                $('#analyticevent').hide();
                $('#property_changer_row').hide();
                $('#analyticpropertyResult').hide();
                $('#date_range').hide();
                $('#date_range_spacer').hide();
                $('#event_button').hide();
                $('#portal_stat_actions').show();
                $('#property_choose').val('All');
                $('#portal_statistics').show();
                $('#portal_statistics_spacer').show();
                $('#date_filter_chooser').show();
                $('#date_filter_spacer').show();
            } else
            {
                $('#event_chooser').show();
                $('#event_spacer').show();
                $('#analyticevent').show();
                //$('#property_changer_row').show();
                $('#date_range').show();
                $('#date_range_spacer').show();
                $('#portal_statistics').hide();
                $('#event_button').show();
                $('#portal_stat_actions').hide();
                $('#portal_statistics_spacer').hide();
                $('#portal_statistics_rows').hide();
                $('#portal_statistics_graph').hide();
                $('#portal_stat_print').hide();
                $('#date_filter_chooser').hide();
                $('#date_filter_spacer').hide();
                $('#sale_purchase_filter').hide();
                $('#sale_purchase_spacer').hide();
            }
//        });

        $('#analytic_filter_type').change(function () {
            var anfiltertype = $('#analytic_filter_type  option:selected').attr('value');
            if (anfiltertype == "custom")
            {
                $('#date_range').show();
                $('#date_range_spacer').show();
            } else
            {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#date_range').hide();
                $('#date_range_spacer').hide();
            }
        });

        $('#statistic_chooser').change(function () {
            var SaleFilterType = $('#statistic_chooser option:selected').attr('value');
            if (SaleFilterType == "8" || SaleFilterType == "9")
            {
                $('#sale_purchase_filter').show();
                $('#sale_purchase_spacer').show();
            } else
            {
                $('#sale_purchase_filter').hide();
                $('#sale_purchase_spacer').hide();
            }

            if (SaleFilterType == "13" || SaleFilterType == "14") {
                $('#vendors_list').show();
                $('#vendors_list_spacer').show();
            } else {
                $('#vendors_list').hide();
                $('#vendors_list_spacer').hide();
            }

            if (SaleFilterType == "20") {
                $('#vendors_company').show();
                $('#vendors_company_spacer').show();
                $('#portal_chooser').hide();
            } else {
                $('#vendors_company').hide();
                $('#vendors_company_spacer').hide();
                $('#portal_chooser').show();
            }

            if (SaleFilterType == "21") {
                $('#owners_list').show();
                $('#owners_list_spacer').show();
                $('#portal_chooser').hide();
            } else {
                $('#owners_list').hide();
                $('#owners_list_spacer').hide();
                $('#portal_chooser').show();
            }

            if (SaleFilterType == "24" || SaleFilterType == "25") {
                $('#owners_list').show();
                $('#owners_list_spacer').show();
//                $('#portal_chooser').hide();
            } else {
                $('#owners_list').hide();
                $('#owners_list_spacer').hide();
//                $('#portal_chooser').show();
            }

        });


        $('#portal_stat_button').click(function () {
            var strStatisticsRequest = $('#statistic_chooser').val();
            var strPortalFor = $('#portal_chooser option:selected').attr('value');
            var strSalesFilterType = $('#sales_filter_type').val();
            var strFilterType = $('#analytic_filter_type').val();
            var strFromDate = $('#from_date').val();
            var strToDate = $('#to_date').val();
            var Vendors = $('#vendors').val();
            var VendorCompany = $('#vendor_company').val();
            var OwnerId = $('#owners').val();
            var strPortalStatisticsUrl = "<?php echo $strAjaxPortalStatsUrl; ?>/" + strPortalFor;
            if (strStatisticsRequest == '8' || strStatisticsRequest == '9') {
                var datastrj = "requestid=" + strStatisticsRequest + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&filterType=" + strFilterType + "&ProductType=" + strSalesFilterType;
            } else if (strStatisticsRequest == '13' || strStatisticsRequest == '14') {
                var datastrj = "requestid=" + strStatisticsRequest + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&filterType=" + strFilterType + "&vendors=" + Vendors;
            } else if (strStatisticsRequest == '20') {
                var datastrj = "requestid=" + strStatisticsRequest + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&filterType=" + strFilterType + "&VendorCompany=" + VendorCompany;
            } else if (strStatisticsRequest == '21' || strStatisticsRequest == "24" || strStatisticsRequest == "25") {
                var datastrj = "requestid=" + strStatisticsRequest + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&filterType=" + strFilterType + "&OwnerId=" + OwnerId;
            } else {
                var datastrj = "requestid=" + strStatisticsRequest + "&strFromDate=" + strFromDate + "&strToDate=" + strToDate + "&filterType=" + strFilterType;
            }

            $.ajax({
                type: "POST",
                url: strPortalStatisticsUrl,
                data: datastrj,
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $('#loader').show();
                },
                success: function (data)
                {
                    var str = '';
                    var theme1 = '';
                    var theme2 = '';
                    var theme3 = '';
                    $('#loader').hide();
                    if (data.status == "success")
                    {
                        $('#property_changer_row').hide();
                        $('#portal_stat_print').show();
                        $('#portal_statistics_rows').html(data.content);
                        $('#portal_statistics_graph').show();

                        if (data.list_link != '') {
                            str += "<a href=" + data.list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>" + data.graphseariesvalue + "</h4><p id='portal_statistics_name'>" + data.chartTitle + "</p></a>";
                            $('#portal_statistics_data').html(str);
                            $('#statistics_count').show();
                            $('#themes_count').hide();
                        } else {
                            $('#statistics_count').hide();
                            theme1 += "<a href=" + data.theme1_list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>" + data.graphseariesvalue1 + "</h4><p id='portal_statistics_name'>" + data.title1 + "</p></a>";
                            theme2 += "<a href=" + data.theme2_list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>" + data.graphseariesvalue2 + "</h4><p id='portal_statistics_name'>" + data.title2 + "</p></a>";
                            theme3 += "<a href=" + data.theme3_list_link + " target='_blank'><h4 class='box-success' id='portal_statistics_count'>" + data.graphseariesvalue3 + "</h4><p id='portal_statistics_name'>" + data.title3 + "</p></a>";

                            $('#portal_theme1_data').html(theme1);
                            $('#portal_theme2_data').html(theme2);
                            $('#portal_theme3_data').html(theme3);
                            $('#themes_count').show();
                        }

                        if (strFilterType != 'custom') {
                            $('#graphsection').show();
                            var seriesdata = [];
                            if (data.xseries != "")
                            {
                                var xseries = data.xseries.split(",");
                                if (data.dataseries != "")
                                {
                                    dataser = data.dataseries.split("~");
                                    if (dataser.length > 0)
                                    {
                                        var seriescount = $('#portal_statistics_graph').highcharts().series.length;
                                        for (var j = (seriescount - 1); j >= 0; j--)
                                        {
                                            $('#portal_statistics_graph').highcharts().series[j].remove();
                                        }

                                        $('#portal_statistics_graph').highcharts().setTitle({text: data.chartTitle + ' Trends '});
//                                                            $('#containernew').highcharts().xAxis[0].update ({labels: { step : iSteps }});
                                        $('#portal_statistics_graph').highcharts().xAxis[0].setCategories(xseries);

                                        for (var i = 0; i < dataser.length; i++)
                                        {
                                            arrseriesdata = dataser[i].split(":");
                                            seriesdata = JSON.parse("[" + arrseriesdata[1] + "]");

                                            $('#portal_statistics_graph').highcharts().addSeries({
                                                name: arrseriesdata[0],
                                                data: seriesdata
                                            }, false);
                                        }
                                        $('#portal_statistics_graph').highcharts().redraw();
                                    }
                                } else {
                                    seriesdata = [];
                                }
                                $('#portal_statistics_graph').highcharts().hideLoading();
                            }
                        } else {
                            $('#graphsection').hide();
                        }
                    } else
                    {
                        $('#portal_stat_print').hide();
                        $('#portal_statistics_rows').html(data.content);
                        $('#portal_statistics_rows').show();
                    }
                }
            });
        });


        var lineevent = '#lineevent';
        var barevent = '#barevent';

        // Enforce initial active selection
        $(barevent).addClass('active');
        $(lineevent).removeClass('active');

        var lineproperty = '#lineproperty';
        var barproperty = '#barproperty';

        // Enforce initial active selection
        $(barproperty).addClass('active');
        $(lineproperty).removeClass('active');

        // Activate the visual tab
        $(lineevent).click(function () {
            activateTinyMCETab('line', lineevent, barevent, 'event');
        });

        // Activate the html tab
        $(barevent).click(function () {
            activateTinyMCETab('bar', lineevent, barevent, 'event');
        });

        // Activate the visual tab
        $(lineproperty).click(function () {
            activateTinyMCETab('line', lineproperty, barproperty, 'property');
        });

        // Activate the html tab
        $(barproperty).click(function () {
            activateTinyMCETab('bar', lineproperty, barproperty, 'property');
        });


        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd',
//            minDate: -90,
//            maxDate: 0,
            onClose: function (selectedDate) {
                $("#to_date").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0,
            onClose: function (selectedDate) {
                $("#from_date").datepicker("option", "maxDate", selectedDate);
            }
        });

        $("#to_date").change(function () {
            $('#property_chooser').val('All');
            $('#property_choose').val('All');
            $('#property_changer_row').fadeOut('slow')
            $('#analyticpropertyResult').fadeOut('slow');
        });

        var strSeriesLabelSet = "<?php echo $strSeriesLabels; ?>";

        $('#admin_graph_container').highcharts({
            title: {
                text: 'Portals Trends',
                x: -20 //center
            },
            xAxis: {
                categories: <?php echo $strSeriesLabels; ?>,
            },
            yAxis: {
                title: {
                    text: 'Users'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },
            credits: {
                enabled: false
            },
            chart: {
                // Explicitly tell the width and height of a chart
                //width: 960,
                //height: 500
                type: 'column'
            },
            tooltip: {
                valueSuffix: ' Users'
            },
            series: <?php echo $strSeriesLabelsValues; ?>,
            exporting: {
                enabled: false
            }
        });

        $('#portal_statistics_graph').highcharts({
            title: {
                text: 'Portals Statistics',
                x: -20 //center
            },
            xAxis: {
                categories: [],
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Users'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },
            credits: {
                enabled: false
            },
            chart: {
                // Explicitly tell the width and height of a chart
                //width: 960,
                //height: 500
                type: 'column'
            },
            tooltip: {
                valueSuffix: ' Users'
            },
            series: [],
            exporting: {
                enabled: false
            }
        });

        $('#propertycontainernew').highcharts({
            title: {
                text: 'Portal Property Trends',
                x: -20 //center
            },
            xAxis: {
                categories: "",
                labels: {
                    step: 2
                }
            },
            yAxis: {
                title: {
                    text: 'Users'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },
            credits: {
                enabled: false
            },
            chart: {
                // Explicitly tell the width and height of a chart
                //width: 960,
                //height: 500
                type: 'column'
            },
            tooltip: {
                valueSuffix: ' Users'
            },
            series: "",
            exporting: {
                enabled: false
            }
        });
    });

    RenderPieChart([], "Portal Property Trends");

    function fnUpdatePropertyGraphData()
    {
        var strEventRequest = $('#property_chooser').val();
        var strSelectedText = $("#property_chooser option:selected").text();
        var strFromDate = $('#from_date').val();
        var strToDate = $('#to_date').val();
        var strProperty = $('#property_choose').val();
        if (strProperty == "All")
        {
            return false;
        } else
        {
            fnGetAndUpdatePropertyGraphData(strEventRequest, strFromDate, strToDate, strProperty);
        }
    }

    function fnGetAndUpdatePropertyGraphData(strRequest, frmdate, todate, strProperty)
    {
        var strPortalFor = $('#portal_chooser').val();
        var strPropertyGraphDataUrl = "<?php echo $strAjaxPropertyGraphUrl; ?>/" + strPortalFor;
        var datastrj = "eventrequest=" + strRequest + "&frmdate=" + frmdate + "&todate=" + todate + "&property=" + strProperty;
        $.ajax({
            type: "POST",
            url: strPropertyGraphDataUrl,
            data: datastrj,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('#propertycontainernew').highcharts().showLoading();
                $('#propertycontainernewpie').highcharts().showLoading();
            },
            success: function (data)
            {
                var seriesdata = [];
                var xseries = data.xseries.split(",");
                if (data.dataseries != "")
                {
                    dataser = data.dataseries.split("~");
                    if (dataser.length > 0)
                    {
                        var seriescount = $('#propertycontainernew').highcharts().series.length;
                        for (var j = (seriescount - 1); j >= 0; j--)
                        {
                            $('#propertycontainernew').highcharts().series[j].remove();
                        }
                        var iSteps = 10;
                        switch (data.monhtsdata)
                        {
                            case 1:
                                iSteps = 5;
                                break;
                            case 2:
                                iSteps = 5;
                                break;
                            case 3:
                                iSteps = 10;
                                break;
                            case 4:
                                iSteps = 20;
                                break;
                        }
                        $('#propertycontainernew').highcharts().setTitle({text: data.chartTitle + ' Trends '});
                        $('#propertycontainernew').highcharts().xAxis[0].update({labels: {step: iSteps}});
                        $('#propertycontainernew').highcharts().xAxis[0].setCategories(xseries);

                        for (var i = 0; i < dataser.length; i++)
                        {
                            arrseriesdata = dataser[i].split(":");
                            seriesdata = JSON.parse("[" + arrseriesdata[1] + "]");

                            $('#propertycontainernew').highcharts().addSeries({
                                name: arrseriesdata[0],
                                data: seriesdata
                            }, false);
                        }
                        $('#propertycontainernew').highcharts().redraw();

                        var pieCompleteData = data.PieData.split("~");
                        var pieDataCount = 0;
                        var pieData = [];
                        var cPieData = [];
                        for (var l = 0; l < pieCompleteData.length; l++)
                        {
                            if (pieCompleteData[l] != "")
                            {
                                pieDataCount++;
                                var pdata = pieCompleteData[l].split(',');
                                var plabel = JSON.stringify(pdata[0]);
                                var plabelcount = parseInt(pdata[1]);
                                pieData = [plabel, plabelcount];
                                cPieData.push(pieData);
                            }
                        }
                        $('#propertycontainernewpie').highcharts().setTitle({text: data.chartTitle + ' Trends '});
                        $('#propertycontainernewpie').highcharts().series[0].setData(cPieData, true);
                        $('#propertycontainernewpie').highcharts().redraw();
                        $('#barlegendsize').val(data.legendsize);

                        if (data.chartdata != "null")
                        {
                            $('#analyticpropertyResult').fadeIn('slow');
                        } else
                        {
                            $('#analyticpropertyResult').fadeOut('slow');
                        }
                    }


                    /*dataser = JSON.parse("[" + data.dataseries + "]");	
                     seriesdata = dataser;
                     $('#propertycontainernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
                     $('#propertycontainernew').highcharts().xAxis[0].setCategories(xseries);
                     $('#propertycontainernew').highcharts().series[0].setData(seriesdata);*/
                } else
                {
                    seriesdata = [];
                }
                $('#propertycontainernew').highcharts().hideLoading();
                $('#propertycontainernewpie').highcharts().hideLoading();
            }
        });
    }

    function fnUpdateGraphData()
    {
        var strEventRequest = $('#property_chooser').val();
        var strSelectedText = $("#property_chooser option:selected").text();
        var strFromDate = $('#from_date').val();
        var strToDate = $('#to_date').val();
        $('#analyticpropertyResult').fadeOut('slow');
        $('#property_choose').val('All');

        fnGetAndUpdateGraphData(strEventRequest, strFromDate, strToDate);

        //var intPortal = $('#portal_chooser').val();		
        //fnGetAndUpdateGraphData(strEventRequest);
    }

    function fnGetAndUpdateGraphData(strRequest, frmdate, todate)
    {
        var strPortalFor = $('#portal_chooser').val();
        var strGraphDataUrl = "<?php echo $strAjaxGraphUrl; ?>/" + strPortalFor;
        var datastrj = "eventrequest=" + strRequest + "&frmdate=" + frmdate + "&todate=" + todate;
        $.ajax({
            type: "POST",
            url: strGraphDataUrl,
            data: datastrj,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('#admin_graph_container').highcharts().showLoading();
            },
            success: function (data)
            {
                var seriesdata = [];
                var xseries = data.xseries.split(",");
                if (data.dataseries != "")
                {
                    dataser = data.dataseries.split("~");
                    if (dataser.length > 0)
                    {
                        var seriescount = $('#admin_graph_container').highcharts().series.length;
                        for (var j = (seriescount - 1); j >= 0; j--)
                        {
                            $('#admin_graph_container').highcharts().series[j].remove();
                        }
                        var iSteps = 10;
                        switch (data.monhtsdata)
                        {
                            case 1:
                                iSteps = 5;
                                break;
                            case 2:
                                iSteps = 5;
                                break;
                            case 3:
                                iSteps = 10;
                                break;
                            case 4:
                                iSteps = 20;
                                break;
                        }
                        $('#admin_graph_container').highcharts().setTitle({text: data.chartTitle + ' Trends '});
                        $('#admin_graph_container').highcharts().xAxis[0].update({labels: {step: iSteps}});
                        $('#admin_graph_container').highcharts().xAxis[0].setCategories(xseries);

                        for (var i = 0; i < dataser.length; i++)
                        {
                            arrseriesdata = dataser[i].split(":");
                            seriesdata = JSON.parse("[" + arrseriesdata[1] + "]");

                            $('#admin_graph_container').highcharts().addSeries({
                                name: arrseriesdata[0],
                                data: seriesdata
                            }, false);
                        }
                        $('#admin_graph_container').highcharts().redraw();
                        if (data.chartdata != "null")
                        {
                            if (strPortalFor != "all")
                            {
                                $('#property_changer_row').fadeIn('slow');
                            }
                        } else
                        {
                            $('#property_changer_row').fadeOut('slow');
                        }
                    }

                    /*dataser = JSON.parse("[" + data.dataseries + "]");	
                     seriesdata = dataser;
                     $('#admin_graph_container').highcharts().setTitle({ text: data.chartTitle+' Trends '});
                     $('#admin_graph_container').highcharts().xAxis[0].setCategories(xseries);
                     $('#admin_graph_container').highcharts().series[0].setData(seriesdata);*/
                } else
                {
                    seriesdata = [];
                }
                $('#admin_graph_container').highcharts().hideLoading();
            }
        });
    }

    function activateTinyMCETab(selectedTab, line, bar, elementId)
    {
        if (selectedTab == 'bar')
        {
            if (elementId == "property")
            {
                var legendSize = $('#barlegendsize').val();
                for (var i = 0; i < legendSize; i++)
                {
                    $('#propertycontainernew').highcharts().series[i].update({type: selectedTab});
                }
            } else
            {
<?php
if (is_array($arrPortals) && (count($arrPortals) > 0)) {
    for ($i = 0; $i < count($arrPortals); $i++) {
        ?>
                        $('#admin_graph_container').highcharts().series[<?php echo $i; ?>].update({type: selectedTab});
        <?php
    }
}
?>
            }
            $(bar).addClass('active');
            $(line).removeClass('active');
        }

        if (selectedTab == 'line')
        {
            if (elementId == "property")
            {
                var legendSize = $('#barlegendsize').val();
                for (var i = 0; i < legendSize; i++)
                {
                    $('#propertycontainernew').highcharts().series[i].update({type: selectedTab});
                }
            } else
            {
<?php
if (is_array($arrPortals) && (count($arrPortals) > 0)) {
    for ($i = 0; $i < count($arrPortals); $i++) {
        ?>
                        $('#admin_graph_container').highcharts().series[<?php echo $i; ?>].update({type: selectedTab});
        <?php
    }
}
?>

            }
            $(bar).removeClass('active');
            $(line).addClass('active');
        }
    }

    function RenderPieChart(piedata, chartTitle)
    {
        var dataList = piedata;
        new Highcharts.Chart({
            chart: {
                renderTo: "propertycontainernewpie",
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            }, title: {
                text: chartTitle
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.point.name + '</b>: ' + this.point.y;
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function () {
                            return '<b>' + this.point.name + '</b>: ' + this.point.y;
                        }
                    }
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                    type: 'pie',
                    name: chartTitle,
                    data: dataList
                }]
        });
    }
</script>