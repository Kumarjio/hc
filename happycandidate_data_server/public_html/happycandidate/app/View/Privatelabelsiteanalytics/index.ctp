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
?>

<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Portal Analytics</h3>
            </div>
        </div>
        <div id="analyticsfilter" style="width:100%;float:left;margin-bottom:50px;padding:0;">
            <div class="analytics-panel">
                <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                    <label>Analytic Type:</label>
                </div>
                <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                    <select name="analytic_chooser" id="analytic_chooser">
                        <option value="All">--Choose Statistics--</option>
                        <!--<option value="events">Event Analytics</option>
                        <option value="portal">Portal Analytics</option>-->
<!--                        <option data-name ="events" value="Logged In Users">Logged In Users</option>
                        <option data-name ="events" value="Logged Out Users">Logged Out Users</option>-->
                        <!--<option data-name ="events" value="Registered Users">Registered Job Seekers</option>-->
                        <!--<option data-name ="events" value="Confirmed Users">Confirmed Job Seekers</option>-->
                        <!--<option data-name ="portal" value="14">Confirmed Job Seekers</option>-->
<!--                        <option data-name ="events" value="Basic Search">Basic Search</option>
                        <option data-name ="events" value="Advance Search">Advance Search</option>-->
                        <option data-name ="portal" value="1">View Job Seekers</option>
<!--                        <option data-name ="portal" value="2">Portal Owner</option>
                        <option data-name ="portal" value="3">Active Portal Owner</option>
                        <option data-name ="portal" value="4">InActive Portal Owner</option>-->
                        <option data-name ="portal" value="5">Active Job Seekers</option>
                        <option data-name ="portal" value="6">InActive Job Seekers</option>
                        <option data-name ="portal" value="7">Order Refunded</option>
                        <option data-name ="portal" value="8">Job Seekers Completed 15 Steps Process</option>
                        <option data-name ="portal" value="9">Job Seekers Applied for Owner’s jobs</option>
                        <option data-name ="portal" value="10">Job Seekers purchased products, services or courses</option>
                        <option data-name ="portal" value="11">(Owners), have made over time</option>
                        <option data-name ="portal" value="12">Theme Register Job Seeker</option>
                        <option data-name ="portal" value="13">Phase Completed Job Seeker</option>
                        <option data-name ="portal" value="15">Total Unique Visitors Career Portal</option>
                        <option data-name ="portal" value="16">Total Unique Visitors Registered Career Portal</option>
                    </select>
                </div>
            </div>
            
            <div class="analytics-panel">
                <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                    <label>Analytic Filter Type:</label>
                </div>
                <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                    <select name="analytic_filter_type" id="analytic_filter_type">
                        <!--<option value="All">--Choose Statistics--</option>-->
                        <option data-name ="events" value="curr_year">Year</option>
                        <option data-name ="events" value="30">Month</option>
                        <option data-name ="events" value="7">Week</option>
                        <option data-name ="events" value="zero">Today</option>
                        <option data-name ="events" value="custom">Custom</option>
                    </select>
                </div>
            </div>
            <div id="oldstatistics">
                <div class="analytics-panel">
                    <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                        <label>Date Range:</label>
                    </div>
                    <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                        From Date:
                        <input type="text" id="from_date" value="" name="from_date" style="width:160px;"><input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid">&nbsp;
                        To Date
                        <input type="text" id="to_date" value="" name="to_date" style="width:160px;"><input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid">&nbsp;
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
                                    fnUpdateGraphData();
                                });

                                $("#to_date").on("dp.change", function (e) {
                                    $('#from_date').data("DateTimePicker").maxDate(e.date);
                                    $('#to_date_hid').data("DateTimePicker").date(e.date);
                                    fnUpdateGraphData();
                                });
                            });
                        </script>

                    </div>
                </div>
                <!--<div class="analytics-panel">
                        <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                                <label>Select Event:</label>
                        </div>
                        <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                                <select onchange="fnUpdateGraphData()" name="property_chooser" id="property_chooser">
                                        <option value="All">--Choose Event--</option>
                                        <option value="Logged In Users">Logged In Users</option>
                                        <option value="Logged Out Users">Logged Out Users</option>
                                        <option value="Registered Users">Registered Users</option>
                                        <option value="Confirmed Users">Confirmed Users</option>
                                        <option value="Basic Search">Basic Search</option>
                                        <option value="Advance Search">Advance Search</option>
                                </select>
                        </div>
                </div>-->
                <!--<div class="analytics-panel" id="property_changer_row" style="display:none;">
                        <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                                <label>Choose Property:</label>
                        </div>
                        <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                                <select onchange="fnUpdatePropertyGraphData()" name="property_choose" id="property_choose">
                                        <option value="All">--Choose Property--</option>
                                        <option value="Country">Country</option>
                                        <option value="Region">Region</option>
                                        <option value="City">City</option>
                                        <option value="Browser">Browser</option>
                                        <option value="OS">Operating System</option>
                                        <option value="Device">Device</option>
                                </select>
                        </div>
                </div>-->
                <!--<div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;text-align:center;">
                        <input type="submit" style="margin-top:4px;width:160px;" onclick="fnUpdateGraphData();" name="getanalytics" id="getanalytics" value="Get Analytics" />
                </div>	-->
            </div>

            <div class="analytics-panel" id="portalstatistics" style="display:none;">
                <!--<div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;">
                        <label>Portal Statistics:</label>
                </div>
                <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;">
                        <select name="statistic_chooser" id="statistic_chooser">
                                <option value="All">--Choose Statistics--</option>
                                <option value="1">View Job Seekers</option>
                        </select>
                </div>-->

                <div id="analyticslabel" style="width:18%;float:left;margin-right:2%;padding:4px;display:none;">
                    <label>&nbsp;</label>
                </div>
                <div id="analyticslabelfield" style="width:80%;float:left;margin:0;padding:4px;text-align:center;">
                    <input type="submit" style="width:160px;" onclick="fnGetEmployerAnalytics(); return false;" name="getanalytics" id="getanalytics" value="Get Analytics" />
                    <span id="portal_stat_actions" style="display:none;">&nbsp;<input style="display:none;width:160px;" id="portal_stat_print" onclick="window.print();return false;" type="submit" name="print" id="print" value="Print" /></span>
                </div>
            </div>
        </div>
        <?php
        /* }
          else
          {
          ?>
          <!--<div id="analyticsfilter" style="width:100%;float:left;margin-bottom:50px;padding:0;">
          <div id="analyticslabel" style="width:98%;float:left;margin-right:2%;padding:4px;">
          <label>No User Activity Recorded For the Portal</label>
          </div>
          </div>-->
          <?php
          } */
        ?>
        <div id="portalstats" style="float:left;width:100%;">
            <img src="<?php echo Router::url('/', true); ?>img/loader.gif" name="loader" id="loader" style="display:none;margin-left:40%;">
            
            <div class="" id="portal_statistics_rows" style="display:none;margin-left:2px;"></div>
            <div>&nbsp;</div>

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
            
            <div id="portal_statistics_graph" style="display:none;width: 970px; height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
        </div>
        
        <!-- arjun comment code 19-05-2017 -->
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
        <!-- arjun comment code 19-05-2017 -->
    </div>
</div>
<!--<div class="actions">
        <h3>Actions</h3>
        <ul>
                <li><?php echo $this->Html->link('Post Jobs', array('action' => 'add', $portal_id)); ?></li>
        </ul>
</div>-->

<?php
$strAjaxGraphUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'updategraph', $portal_id), true);
$strAjaxPropertyGraphUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'updatepropertygraph', $portal_id), true);
$strAjaxPortalStatsUrl = Router::url(array('controller' => 'privatelabelsiteanalytics', 'action' => 'userstatistics', $portal_id), true);
?>

<script type="text/javascript">
var step = 1;
function fnGetEmployerAnalytics()
{
	//var strStatisticsRequest = $('#statistic_chooser').val();
	var strStatisticsRequest = $('#analytic_chooser').val();
	var strFromDate = $('#from_date_hid').val();
	var strToDate = $('#to_date_hid').val();
	var strFilterType = $('#analytic_filter_type').val();
           
	if(strStatisticsRequest == "All")
	{
		return false;
	}
	else
	{
            var strPortalStatisticsUrl = "<?php echo $strAjaxPortalStatsUrl; ?>/";
            var datastrj = "requestid="+strStatisticsRequest+"&strFromDate="+strFromDate+"&strToDate="+strToDate+"&filterType="+strFilterType;
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
                    var theme1 ='';
                    var theme2 ='';
                    var theme3 ='';
                    if(data.status == "success")
                    {
                        $('#portal_stat_print').show();
//						$('#portal_statistics_count').html(data.graphseariesvalue);
//						$('#portal_statistics_name').html(data.chartTitle);
                        if(data.list_link !=''){
                            str+="<a href="+data.list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue+"</h4><p id='portal_statistics_name'>"+data.chartTitle+"</p></a>";
                            $('#portal_statistics_data').html(str);
                            $('#statistics_count').show();
                            $('#themes_count').hide();
                        }else{
                            $('#statistics_count').hide();
                            theme1+="<a href="+data.theme1_list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue1+"</h4><p id='portal_statistics_name'>"+data.title1+"</p></a>"; 
                            theme2+="<a href="+data.theme2_list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue2+"</h4><p id='portal_statistics_name'>"+data.title2+"</p></a>"; 
                            theme3+="<a href="+data.theme3_list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue3+"</h4><p id='portal_statistics_name'>"+data.title3+"</p></a>"; 

                            $('#portal_theme1_data').html(theme1);
                            $('#portal_theme2_data').html(theme2);
                            $('#portal_theme3_data').html(theme3);
                            $('#themes_count').show();
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


                                        /*dataser = JSON.parse("[" + data.dataseries + "]");	
                                        seriesdata = dataser;
                                        $('#containernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
                                        $('#containernew').highcharts().xAxis[0].setCategories(xseries);
                                        $('#containernew').highcharts().series[0].setData(seriesdata);*/
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
        //                                        $('#graphsection').show();
        //                                        fnUpdateGraphData();
                }
		});
	}	

}

    $(document).ready(function() {
            $('#portalstatistics').hide();
            $('#oldstatistics').hide();
            $('#portalstats').hide();
            $('#graphsection').hide();
            $('#portal_stat_actions').hide();
            $('#portal_statistics_rows').hide();
            $('#analytic_chooser').change(function () {
                    //var anchooser = $('#analytic_chooser').val();
                    var anchooser = $('#analytic_chooser  option:selected').attr('data-name');
                    //console.log(anchooser)

                    if(anchooser == "portal")
                    {
                            $('#portalstatistics').show();
//                            $('#oldstatistics').show();
                            $('#portalstats').show();
                            $('#graphsection').hide();
                            $('#portal_stat_actions').hide();
                            $('#portal_statistics_rows').hide();
                            $("#from_date").val('');
                            $("#to_date").val('');
                            fnGetEmployerAnalytics();
//                            fnUpdateGraphData();
                            return false;
                    }
                    else
                    {
                            $('#portalstatistics').hide();
//                            $('#oldstatistics').show();
                            $('#portalstats').show();
                            $('#graphsection').show();
                            $('#portal_stat_actions').hide();
                            $('#portal_statistics_rows').hide();
                            $("#from_date").val('');
                            $("#to_date").val('');
                            fnUpdateGraphData();
                    }


            });
            
            $('#analytic_filter_type').change(function () {
                    var anfiltertype = $('#analytic_filter_type  option:selected').attr('value');
                    var anchooser = $('#analytic_chooser  option:selected').attr('data-name');
                    if(anfiltertype == "custom")
                    {
                        if(anchooser == "portal")
                        {
                                $('#portalstatistics').show();
                                $('#oldstatistics').show();
                                $('#portalstats').show();
                                $('#portal_stat_actions').hide();
                                $('#portal_statistics_rows').hide();
                                
                                fnGetEmployerAnalytics();
//                                fnUpdateGraphData();
                                return false;
                        }
                        else
                        {
                                $('#portalstatistics').hide();
                                $('#oldstatistics').show();
                                $('#portalstats').show();
//                                $('#graphsection').show();
                                $('#portal_stat_actions').hide();
                                $('#portal_statistics_rows').hide();
//                                fnUpdateGraphData();
                        }
                    }
                    else
                    {
                            if(anchooser == "portal")
                        {
                            $('#oldstatistics').hide();
                            $("#from_date").val('');
                            $("#to_date").val('');
                            fnGetEmployerAnalytics(); return false;
                        }else{
                            fnUpdateGraphData(); return false; 
                        }
                    }
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
                            text: 'Portal User Event Trends',
                            x: -20 //center
                    },
                    xAxis: {
                            categories: <?php echo $strSeriesLabels; ?>,
                            labels: {
                                    step: 1
                            }
                    },
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                            title: {
                                    text: ' Users'
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

            $('#propertycontainernew').highcharts({
                    title: {
                            text: 'Portal Property Trends',
                            x: -20 //center
                    },
                    xAxis: {
                            categories: "",
                            labels: {
                                    step: step
                            }
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
                    series: "",
                    exporting: {
                            enabled: false
                    }
            });
    });

    RenderPieChart([],"Portal Property Trends");

    function fnUpdatePropertyGraphData()
    {
        
            var strEventRequest = $('#property_choose').val();
            var strSelectedText = $("#property_choose option:selected").text();
            var strFromDate = $('#from_date_hid').val();
            var strToDate = $('#to_date_hid').val();
            var strProperty = $('#property_choose').val();
            //console.log(strEventRequest+","+strFromDate+","+strToDate+","+strProperty)
            if(strProperty == "All")
            {
                    return false;
            }
            else
            {
                    fnGetAndUpdatePropertyGraphData(strEventRequest,strFromDate,strToDate,strProperty);
            }
    }

    function fnGetAndUpdatePropertyGraphData(strRequest,frmdate,todate,strProperty)
    {
            var strPropertyGraphDataUrl = "<?php echo $strAjaxPropertyGraphUrl; ?>";
            var datastrj = "eventrequest="+strRequest+"&frmdate="+frmdate+"&todate="+todate+"&property="+strProperty;
            $.ajax({ 
                            type: "POST",
                            url: strPropertyGraphDataUrl,
                            data: datastrj,
                            cache: false,
                            dataType: 'json',
                            beforeSend: function(){
                                    $('#propertycontainernew').highcharts().showLoading();
                                    $('#propertycontainernewpie').highcharts().showLoading();
                            },
                            success: function(data)
                            {
                                    var seriesdata = [];
                                    var xseries = data.xseries.split(",");
                                    if(data.dataseries != "")
                                    {
                                            dataser = data.dataseries.split("~");
                                            if(dataser.length > 0)
                                            {
                                                    var seriescount = $('#propertycontainernew').highcharts().series.length;
                                                    for(var j=(seriescount-1);j>=0;j--)
                                                    {
                                                            $('#propertycontainernew').highcharts().series[j].remove();
                                                    }
                                                    var iSteps = 10;
                                                    switch(data.monhtsdata)
                                                    {
                                                            case 1: iSteps = 5;
                                                                            break;
                                                            case 2: iSteps = 5;
                                                                            break;
                                                            case 3: iSteps = 10;
                                                                            break;
                                                            case 4: iSteps = 20;
                                                                            break;
                                                    }
                                                    $('#propertycontainernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
//                                                    $('#propertycontainernew').highcharts().xAxis[0].update ({labels: { step : iSteps }});
                                                    $('#propertycontainernew').highcharts().xAxis[0].setCategories(xseries);

                                                    for(var i = 0; i<dataser.length; i++)
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
                                                    for(var l=0;l<pieCompleteData.length;l++)
                                                    {
                                                            if(pieCompleteData[l] !="")
                                                            {
                                                                    pieDataCount++;
                                                                    var pdata = pieCompleteData[l].split(',');
                                                                    var plabel = JSON.stringify(pdata[0]);
                                                                    var plabelcount = parseInt(pdata[1]);
                                                                    pieData = [plabel,plabelcount];
                                                                    cPieData.push(pieData);
                                                            }
                                                    }
                                                    $('#propertycontainernewpie').highcharts().setTitle({ text: data.chartTitle+' Trends '});
                                                    $('#propertycontainernewpie').highcharts().series[0].setData(cPieData, true);
                                                    $('#propertycontainernewpie').highcharts().redraw();
                                                    $('#barlegendsize').val(data.legendsize);

                                                    if(data.chartdata != "null")
                                                    {
                                                            $('#analyticpropertyResult').fadeIn('slow');
                                                    }
                                                    else
                                                    {
                                                            $('#analyticpropertyResult').fadeOut('slow');
                                                    }
                                            }


                                            /*dataser = JSON.parse("[" + data.dataseries + "]");	
                                            seriesdata = dataser;
                                            $('#propertycontainernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
                                            $('#propertycontainernew').highcharts().xAxis[0].setCategories(xseries);
                                            $('#propertycontainernew').highcharts().series[0].setData(seriesdata);*/
                                    }
                                    else
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
            //var strEventRequest = $('#property_chooser').val();
            var strEventRequest = $('#analytic_chooser').val();
            var strFilterType = $('#analytic_filter_type').val();
            //var strSelectedText = $("#property_chooser option:selected").text();
            var strSelectedText = $("#analytic_chooser option:selected").text();

            var strFromDate = $('#from_date_hid').val();
            var strToDate = $('#to_date_hid').val();

            fnGetAndUpdateGraphData(strEventRequest,strFromDate,strToDate,strFilterType);
    }

    function fnGetAndUpdateGraphData(strRequest,frmdate,todate,strFilterType)
    {
            var strGraphDataUrl = "<?php echo $strAjaxGraphUrl; ?>";
            var datastrj = "eventrequest="+strRequest+"&frmdate="+frmdate+"&todate="+todate+"&filterType="+strFilterType;
            $.ajax({ 
                type: "POST",
                url: strGraphDataUrl,
                data: datastrj,
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                        $('#containernew').highcharts().showLoading();
                },
                success: function(data)
                {
                    var str ='';
        //              if(data.list_link != ''){
                            str+="<a href="+data.list_link+" target='_blank'><h4 class='box-success' id='portal_statistics_count'>"+data.graphseariesvalue+"</h4><p id='portal_statistics_name'>"+data.chartTitle+"</p></a>";
                            $('#portal_statistics_data').html(str);
                            $('#statistics_count').show();
                            $('#themes_count').hide();
        //              }
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
                                }
                                else
                                {
                                        seriesdata = [];
                                }					
                                $('#containernew').highcharts().hideLoading();
                        }
                }
            });
    }

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