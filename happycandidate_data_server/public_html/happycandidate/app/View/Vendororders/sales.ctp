<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });
</script>

<style>
    /* start tiny mce tabs*/
    .tinymce-tabs {
        height: 30px;
        width:970px;
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
                <h1>Service Order Report</h1>
                <div class="tab-row-container">
                    <div id="product_notification"></div>
                    <div class="tab-search">
                        <?php
                        $strProductSearchUrl = Router::url(array('controller' => 'vendororders', 'action' => 'sales'), true);
                        ?>
                        <!--<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl; ?>/" method="post" role="form">-->
                            <div class="col-md-4">
                                <?php
                                if ($arrLoggedUser['parent_vendor']) {
                                    
                                } else {
                                    ?> Vendors:
                                    <select name="vendors" id="vendors">
                                        <option value="">--Choose One--</option>
                                        <option value="">All</option>
                                        <?php foreach ($arrViewUserDetail as $vendors) { ?>
                                            <option <?php if ($selected_vendor == $vendors['Vendors']['vendor_id']) {
                                        echo 'selected=selected';
                                    } ?> value="<?php echo $vendors['Vendors']['vendor_id']; ?>"> <?php echo $vendors['Vendors']['vendor_first_name'] . " " . $vendors['Vendors']['vendor_last_name']; ?></option>
                                    <?php } ?>
                                    </select>
                            <?php } ?>
                            </div>
                            <div class="col-md-4">
                                Report Type:
                                <select name="report_type" id="report_type">
                                    <option value="">--Choose Type--</option>
                                    <option <?php if ($selected_report_type == 'New Order') { echo 'selected=selected';} ?> value="New Order">New Orders</option>
                                    <option <?php if ($selected_report_type == 'Open') { echo 'selected=selected';} ?> value="Open">Open Orders</option>
                                    <option <?php if ($selected_report_type == 'Pending') { echo 'selected=selected';} ?> value="Pending">Pending Orders</option>
                                    <option <?php if ($selected_report_type == 'Closed') { echo 'selected=selected';} ?> value="Closed">Closed Orders</option>
                                    <option <?php if ($selected_report_type == 'Earned') { echo 'selected=selected';} ?> value="Earned">Total Amount Earned</option>
                                    <option <?php if ($selected_report_type == 'Refunds') { echo 'selected=selected';} ?> value="Refunds">Total Refunds Provided</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                Filter Type:            
                                <select name="filterType" id="filterType">
                                    <option value="All">--Choose Filter Type--</option>
                                    <option <?php if ($selected_filter_type == 'curr_year') { echo 'selected=selected';} ?> value="curr_year">Year</option>
                                    <option <?php if ($selected_filter_type == '30') { echo 'selected=selected';} ?> value="30">Month</option>
                                    <option <?php if ($selected_filter_type == '7') { echo 'selected=selected';} ?> value="7">Week</option>
                                    <option <?php if ($selected_filter_type == 'zero') { echo 'selected=selected';} ?> value="zero">Today</option>
                                    <option <?php if ($selected_filter_type == 'custom') { echo 'selected=selected';} ?> value="custom">Custom</option>
                                </select>
                            </div>
                            <div id="custom_dates_input">
                                <div class="col-md-4">    
                                    From Date: 
                                    <input type="text" id="from_date" name="product_keyword" id="product_keyword" value="" name="from_date"><input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid">&nbsp;
                                </div>
                                <div class="col-md-4">   
                                    To Date
                                    <input type="text" id="to_date" name="product_keyword" id="product_keyword" value="" name="to_date"><input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid">&nbsp;
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
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
                            
                            <div class="col-md-4">
                                <button name="product_search" id="product_search" type="submit" onclick="fnGetOrdersAnalytics();" class="btn btn-default btn-md">Search</button>
                                <button name="export" id="export" type="button" class="btn btn-default btn-md" onclick="fnExportSalesOrder()" >Export</button>
                            </div>
                        <!--</form>-->
                    </div>
                    
                    <div class="emp-stat-box-container" id="statistics_count" style="display:none;margin-left:2px;">
                        <div class="emp-stat-box">
                            <div class="left-side-container" id="portal_statistics_data">

                            </div>
                        </div>
                    </div>
                    
                    <div id="graphsection">
                        <div id="analyticgraphResult" style="float:left;width:100%;margin:0;padding:0;">
                            <div class="tinymce-tabs">
                                <a id="lineevent" class="html editor1 event">Line</a>
                                <a id="barevent" class="visual editor1 event" class="active">Bar</a>
                                <div style="clear: both;"></div>
                            </div> 
                            <div id="containernew" style="width: 970px; height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
                        </div>
                        <div>&nbsp;</div>
                        <div id="analyticpropertyResult" style="display:none;float:left;width:100%;margin:0;padding:0;">
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
                    </div>
                    <!-- CONTENT -->
                </div>
            </div>
        </div>
    </div>
   <?php $strAjaxReportStatsUrl = Router::url(array('controller' => 'vendororders', 'action' => 'ordersReport'), true);?>
<script type="text/javascript">
var step = 1;
function fnGetOrdersAnalytics()
{
	var Vendors = $('#vendors').val();
	var reportType = $('#report_type').val();
	var strFromDate = $('#from_date_hid').val();
	var strToDate = $('#to_date_hid').val();
	var strFilterType = $('#filterType').val();
           
            var strPortalStatisticsUrl = "<?php echo $strAjaxReportStatsUrl; ?>/";
            var datastrj = "vendors="+Vendors+"&strFromDate="+strFromDate+"&strToDate="+strToDate+"&filterType="+strFilterType+"&reportType="+reportType;
            $.ajax({ 
                type: "POST",
                url: strPortalStatisticsUrl,
                data: datastrj,
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                        $('#loader').show();
                },
                success: function(data)
                {
                    $('#loader').hide();
                    var str ='';
                    if(data.status == "success")
                    {
                        $('#portal_stat_print').show();
                        if(data.list_link !=''){
                            str+="<a href="+data.list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue+"</h4><p id='portal_statistics_name'>"+data.chartTitle+"</p></a>";
                            $('#portal_statistics_data').html(str);
                            $('#statistics_count').show();
                            $('#themes_count').hide();
                        }

                        $('#portal_stat_actions').show();
                        if(strFilterType !='custom'){
                            $('#graphsection').show();  
                            var seriesdata = [];
                            if(data.xseries != "")
                            {
                                var xseries = data.xseries.split(",");
                                if(data.dataseries != "")
                                {
                                        dataser = data.dataseries.split("~");
                                        if(dataser.length > 0)
                                        {
                                                var seriescount = $('#containernew').highcharts().series.length;
                                                for(var j=(seriescount-1);j>=0;j--)
                                                {
                                                        $('#containernew').highcharts().series[j].remove();
                                                }

                                                $('#containernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
//                                                            $('#containernew').highcharts().xAxis[0].update ({labels: { step : iSteps }});
                                                $('#containernew').highcharts().xAxis[0].setCategories(xseries);

                                                for(var i = 0; i<dataser.length; i++)
                                                {
                                                        arrseriesdata = dataser[i].split(":");
                                                        seriesdata = JSON.parse("[" + arrseriesdata[1] + "]");

                                                        $('#containernew').highcharts().addSeries({                        
                                                                name: arrseriesdata[0],
                                                                data: seriesdata
                                                        }, false);
                                                }
                                                $('#containernew').highcharts().redraw();
                                                if(data.chartdata != "null")
                                                {
                                                        $('#property_choose').val('All');
                                                        $('#analyticpropertyResult').fadeOut('slow');
                                                        $('#property_changer_row').fadeIn('slow');
                                                }
                                                else
                                                {
                                                        $('#property_choose').val('All');
                                                        $('#property_changer_row').fadeOut('slow');
                                                        $('#analyticpropertyResult').fadeOut('slow');
                                                }
                                        }
                                } else {
                                        seriesdata = [];
                                }					
                                $('#containernew').highcharts().hideLoading();
                            }
                            }else{
                             $('#graphsection').hide();  
                            }
                    }else {
                        $('#portal_stat_print').hide();
                        $('#portal_statistics_rows').html(data.content);
                        $('#portal_statistics_rows').show();
                    }
                }
		});
}
</script>

    <script type="text/javascript">
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
        
         $(".panel-body.vendor-orders .user-title a").click(function(event) {
            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
        
        $("#filterType").change(function(){
            var anfiltertype = $('#filterType  option:selected').attr('value');
            if(anfiltertype == 'custom'){
                $("#custom_dates_input").show();
            }else{
                $("#custom_dates_input").hide(); 
            }
            fnGetOrdersAnalytics();
        });
        
        $("#report_type").change(function(){
            var reportType = $('#report_type  option:selected').attr('value');
            if(reportType == 'Earned'){
                $("#totalValueCount").show();
                $("#totalRefund").hide(); 
                $("#totalEarned").show();
                $("#tableDisplayCondition").hide();
                fnGetOrdersAnalytics();
                return false; 
                
            }else if(reportType == 'Refunds'){
                $("#totalEarned").hide();
                $("#totalRefund").show(); 
                $("#totalValueCount").show();
                $("#tableDisplayCondition").hide();
                fnGetOrdersAnalytics();
                return false; 
            }else{
                $("#totalEarned").hide();
                $("#totalRefund").hide(); 
                $("#totalValueCount").hide();
                $("#tableDisplayCondition").show();
                 fnGetOrdersAnalytics();
                return false; 
            }
        });
        
        $("#vendors").change(function(){
                fnGetOrdersAnalytics();
                return false; 
        });
        
         $(document).ready(function() {
            $('#portalstatistics').hide();
            $('#oldstatistics').hide();
            $('#portalstats').hide();
            $('#graphsection').hide();
            $('#portal_stat_actions').hide();
            $('#portal_statistics_rows').hide();
             var anfiltertype = $('#filterType  option:selected').attr('value');
            var reportType = $('#report_type  option:selected').attr('value');
            
            if(anfiltertype == 'custom'){
                $("#custom_dates_input").show();
            }else{
                $("#custom_dates_input").hide(); 
            }
             
            if(reportType == 'Earned'){
                $("#totalRefund").hide(); 
                $("#totalEarned").show();
                $("#totalValueCount").show();
                $("#tableDisplayCondition").hide();
            }else if(reportType == 'Refunds'){
                $("#totalEarned").hide();
                $("#totalRefund").show(); 
                $("#totalValueCount").show(); 
                $("#tableDisplayCondition").hide();
            }else{
                $("#totalEarned").hide();
                $("#totalRefund").hide(); 
                $("#totalValueCount").hide(); 
                $("#tableDisplayCondition").show();
            }
        });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
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
            $(lineevent).click(function() {
                    activateTinyMCETab('line', lineevent, barevent, 'event');
            });

            // Activate the html tab
            $(barevent).click(function() {
                    activateTinyMCETab('bar', lineevent, barevent, 'event');
            });

            // Activate the visual tab
            $(lineproperty).click(function() {
                    activateTinyMCETab('line', lineproperty, barproperty, 'property');
            });
            // Activate the html tab
            $(barproperty).click(function() {
                    activateTinyMCETab('bar', lineproperty, barproperty, 'property');
            });

            var strSeriesLabelSet = "<?php echo $strSeriesLabels; ?>";

                $('#containernew').highcharts({
                    title: {
                            text: 'Orders Trends',
                            x: -20 //center
                    },
                    xAxis: {
                            categories: "test",
                           // categories: <?php //echo $strSeriesLabels; ?>,
                            labels: {
                                    step: 1
                            }
                    },
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                            title: {
                                    text: ' Orders'
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
                            valueSuffix: ' Orders'
                    },
                    series: "2",
//                    series: <?php // echo $strSeriesLabelsValues; ?>,
                    exporting: {
                            enabled: false
                    }
            });
    });
    
    RenderPieChart([],"Portal Property Trends");
    
    function activateTinyMCETab(selectedTab, line, bar, elementId) 
    {
            if(selectedTab == 'bar') 
            {
                    if(elementId == "property")
                    {
                            var legendSize = $('#barlegendsize').val();
                            for(var i = 0;i<legendSize;i++)
                            {
                                    $('#propertycontainernew').highcharts().series[i].update({ type: selectedTab});
                            }
                    }
                    else
                    {
    <?php
    if (is_array($arrEvents) && (count($arrEvents) > 0)) {
        for ($i = 0; $i < count($arrEvents); $i++) {
            ?>
                                                                                                                                                                                                                                                                                                                            $('#containernew').highcharts().series[<?php echo $i; ?>].update({ type: selectedTab});
            <?php
        }
    }
    ?>
                    }
                    $(bar).addClass('active');
                    $(line).removeClass('active');
            }

            if(selectedTab == 'line') 
            {
                    if(elementId == "property")
                    {
                            var legendSize = $('#barlegendsize').val();
                            for(var i = 0;i<legendSize;i++)
                            {
                                    $('#propertycontainernew').highcharts().series[i].update({type: selectedTab});
            }
        } else
        {
    <?php
    if (is_array($arrEvents) && (count($arrEvents) > 0)) {
        for ($i = 0; $i < count($arrEvents); $i++) {
            ?>
                                                                                                                                                                                                                    $('#containernew').highcharts().series[<?php echo $i; ?>].update({type: selectedTab});
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