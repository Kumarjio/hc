<style>
	/* start tiny mce tabs*/

	.tinymce-tabs {
		height: 30px;
		width:100%;
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
 <div class="page-content-wrapper employers-type">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
                            <ul class="content-controls">
					<li id="year" class="periods">
						<a href="javascript:void(0);" onClick="fnUpdateGraphData('curr_year')" class="control-button">Year</a>
					</li>
					<li id="month" class="periods">
						<a href="javascript:void(0);" onClick="fnUpdateGraphData('30')" class="control-button">Month</a>
					</li>
					<li id="week" class="periods">
						<a href="javascript:void(0);" onClick="fnUpdateGraphData('7')" class="control-button">Week</a>
					</li>
					<li id="today" class="periods active">
						<a href="javascript:void(0);" onClick="fnUpdateGraphData('zero')" class="control-button">Today</a>
					</li>
				</ul>
				<h1>Dashboard</h1>
                                <p>Hello <span style="color:blue"><?php echo $arrEmployerDetail[0]["Employer"]["employer_user_fname"]; ?>, </span>your career portal site is <?php if($arrEmployerDomain["Employerdomain"]["domain_name"] !=''){ ?><a style="color:blue" href="http://<?php echo "www.".$arrEmployerDomain["Employerdomain"]["domain_name"]; ?>" target="_blank"><?php echo "www.".$arrEmployerDomain["Employerdomain"]["domain_name"]; ?></a><?php }else{echo "--";}?></p>
				
				
				<div class="emp-stat-box-container">
					 <!--<div class="right-side-container">
						
							<div class="dropdown">
								<a href="#" class="diagr-popup dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo Router::url('/',true); ?>images/emp-diagr.png" alt="">
								</a>
								<ul class="dropdown-menu xs-border" style="margin-top: 5px;">
									<li>
										<a class="triangle-a">
											<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
										</a>
									</li>
									<li>
										<span class="indication indication-success"></span><!-- 
									 --><!--<span class="point-title">Open Jobs</span><!-- 
									 --><!--<span class="point-descr">589 (18%)</span>
									</li>
									<li>
										<span class="indication indication-warning"></span><!-- 
									 --><!--<span class="point-title">Other pages</span><!-- 
									 --><!--<span class="point-descr">2200 (82%)</span>
									</li>
								</ul>
							</div>
						
						</div>

					</div>-->
                                 <div class="emp-stat-box">
						<div class="left-side-container">
							<!--<h4>58</h4>-->
							<h4 class="box-success" id="totalusers"><?php echo $intUsersTotal; ?></h4>
							<p>Registered Users</p>
						</div>
                                     <!--<div class="right-side-container">
							<div class="dropdown">
								<a href="#" class="diagr-popup dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo Router::url('/',true); ?>images/emp-diagr2.png" alt="">
								</a>
								<ul class="dropdown-menu long xs-border" style="margin-top: 5px;">
									<li>
										<a class="triangle-a">
											<img class="triangle-img" src="<?php echo Router::url('/',true); ?>images/tooltip-triangle.png" alt="">	
										</a>
									</li>
									<li>
										<span class="indication indication-alert"></span><!-- 
									 --><!--<span class="point-title">Not started wizard</span><!-- 
									 --><!--<span class="point-descr">2 (4%)</span>
									</li>
									<li>
										<span class="indication indication-primary"></span><!-- 
									 --><!--<span class="point-title">Started wizard</span><!-- 
									 --><!--<span class="point-descr">32 (60%)</span>
									</li>
									<li>
										<span class="indication indication-success"></span><!-- 
									 --><!--<span class="point-title">Purchased services</span><!-- 
									 --><!--<span class="point-descr">10 (17%)</span>
									</li>
									<li>
										<span class="indication indication-featured"></span><!-- 
									 --><!--<span class="point-title">Wizard completed</span><!-- 
									 --><!--<span class="point-descr">14 (19%)</span>
									</li>
								</ul>
							</div>
						
						</div>-->

					</div><!-- 

                                        --><div class="emp-stat-box">
                                            <div class="left-side-container">
                                                <!--<h4 class="box-success">$21,459</h4>-->
                                                <h4 class="box-success" id="totalsale">$<?php echo $intSalesTotal; ?></h4>
                                                <p>Revenue Earned</p>
                                            </div>

                                        </div>
<!--                                 <div class="emp-stat-box">
                                     <div class="left-side-container">
                                         <h4 class="box-success">0</h4>
                                         <p>Website Unique Visitors</p>
                                     </div>
                                 </div>
                                 <div class="emp-stat-box">
                                     <div class="left-side-container">
                                         <h4 class="box-success">0</h4>
                                         <p>Job Seeker Sign Up Conversion</p>
                                     </div>
                                 </div>-->
				</div>

				<div class="emp-stat-graph-container">
					
					<div class="emp-stat-graph">
						
						<h4>Registrations</h4>
						<div id="graphsection">
							<div id="analyticgraphResult" style="float:left;width:100%;margin:0;padding:0;">
								<!--<div class="tinymce-tabs">
									<a id="lineevent" class="html editor1 event">Line</a>
									<a id="barevent" class="visual editor1 event" class="active">Bar</a>
									<div style="clear: both;"></div>
								</div>-->
								<div id="container" style="width:100%;height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
							</div>
						</div>

					</div><!-- 

				 --><div class="emp-stat-graph">
						
						<h4>Sales</h4>
						<div id="graphsection">
							<div id="analyticgraphResult" style="float:left;width:100%;margin:0;padding:0;">
								<!--<div class="tinymce-tabs">
									<a id="lineevent" class="html editor1 event">Line</a>
									<a id="barevent" class="visual editor1 event" class="active">Bar</a>
									<div style="clear: both;"></div>
								</div>-->
								<div id="containernew" style="width:100%;height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
							</div>
						</div>
					</div>

				</div>

				<!--<div class="panel panel-default hidden-xs hidden-sm">
					<div class="panel-heading emp-category">
						<h4>Registered users</h4>
					</div>
					<div class="panel-body emp-category">
						<table>
							<thead>
								<tr>
									<th>First name</th>
									<th class="selected">Last name<span></span></th>
									<th>Email</th>
									<th class="no-filter">Phone number</th>
									<th class="no-filter">Resume</th>
									<th>Registration Date</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
								<tr>
									<td>John</td>
									<td>Doe</td>
									<td>john.doe@companyname.com</td>
									<td>(555) 555 - 555 - 55</td>
									<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
									<td>Aug 23, 2015</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer emp-category">
						<a href="#" class="link-primary">Load More</a>
					</div>
				</div>-->
				<!-- SMALL TABLE -->
				<!--<div class="panel panel-default hidden-md hidden-lg">
					<div class="panel-heading emp-category">
						<h4>Registered users</h4>
					</div>
					<div class="panel-body emp-category small-view">
						<table>
							<tr>
								<td>First name</td>
								<td>John</td>
							</tr>
							<tr>
								<td>Last name</td>
								<td>Doe</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>john.doe@companyname.com</td>
							</tr>
							<tr>
								<td>Phone number</td>
								<td>(555) 555 - 555 - 55</td>
							</tr>
							<tr>
								<td>Resume</td>
								<td><a href="#" class="link-primary">resume-long-title.pdf</a></td>
							</tr>
							<tr>
								<td>Registration Date</td>
								<td>Aug 23, 2015</td>
							</tr>
						</table>
					</div>
					<div class="panel-footer emp-category">
						<a href="#" class="link-primary">Load More</a>
					</div>
				</div>-->
			</div>
		</div>
	</div>
	</div>
<?php
	$strAjaxGraphUrl = Router::url(array('controller'=>'employers','action'=>'updategraph',$current_user['portal_id']),true);
?>

<?php
	echo $this->Html->script('highcharts/js/highcharts');
	echo $this->Html->script('highcharts/js/modules/data');
	echo $this->Html->script('highcharts/js/modules/exporting');
?>
<!--<?php
	$strAjaxGraphUrl = Router::url(array('controller'=>'employers','action'=>'updategraph',$current_user['portal_id']),true);
?>
<h1 class="m-r-24">Dashboard</h1>
<ul class="nav nav-pills pills-bordered">
	<li class="active"><a data-toggle="pill" href="#overview" >Overview</a></li>
	<li><a data-toggle="pill" href="#featured">Featured</a></li>
</ul>
<div class="tab-content">
	<div id="overview" class="tab-pane fade in active">
		<form class="form-inline mr20" role="form">
			<div class="form-group form-dimens">
				<label class="control-label o-s-r-14 label-style"><span>Reporting period:</span></label>
				<div class="selectContainer">
					<select onchange="fnUpdateGraphData()" name="period" id="period" class="form-control" title="Choose a period">
						<option value="1">Last day</option>
						<option value="7">Last week</option>
						<option value="30">Last month</option>
						<option value="365">Last year</option>
					</select>
				</div>
			</div>
		</form>
		<pre><div class="statistic-block"><div><p class="xsmall-txt o-s-r-small-gr">New Users</p><p class="big-txt o-s-r-big"><?php echo $intEventTotal; ?></p></div><div style="display:none;" class="sort-side"><a href="#"><span class="arr-success"></span><span class="success small-txt">10%</span></a></div></div><div class="statistic-block"><div><p class="xsmall-txt o-s-r-small-gr">Sales</p><p class="big-txt o-s-r-big"><?php echo $intSalesTotal; ?></p></div><div style="display:none;" class="sort-side"><a href="#"><span class="arr-warning"></span><span class="warning small-txt">5%</span></a></div></div><div style="display:none;" class="statistic-block"><div><p class="xsmall-txt o-s-r-small-gr">Views</p><p class="big-txt o-s-r-big">1754</p></div><div class="sort-side"><a href="#"><span class="arr-warning"></span><span class="warning small-txt">1%</span></a></div></div><div  style="display:none;" class="statistic-block"><div><p class="xsmall-txt o-s-r-small-gr">Some value</p><p class="big-txt o-s-r-big">10</p></div><div class="sort-side"><a href="#"><span class="arr-success"></span><span class="success small-txt">17%</span></a></div></div><div style="display:none;" class="statistic-block"><div><p class="xsmall-txt o-s-r-small-gr">Some value</p><p class="big-txt o-s-r-big">32</p></div><div class="sort-side"><a href="#"><span class="arr-warning"></span><span class="warning small-txt">23%</span></a></div></div></pre>
	</div>
	<div id="featured" class="tab-pane fade">
		<h3>Featured</h3>
		<p>Some content in featured tab.</p>
	</div>
	<div id="graphsection">
		<div id="analyticgraphResult" style="float:left;width:100%;margin:0;padding:0;">
			<div class="tinymce-tabs">
				<a id="lineevent" class="html editor1 event">Line</a>
				<a id="barevent" class="visual editor1 event" class="active">Bar</a>
				<div style="clear: both;"></div>
			</div> 
			<div id="containernew" style="width:100%;height: 404px; margin: 0 auto;border:1px solid #ccc;"></div>
		</div>
	</div>
</div>-->
<script type="text/javascript">
   
	var strPeriod = '<?php echo $strPeriod; ?>';
	var step = 1;
//        alert(strPeriod);
//	if(strPeriod == "30")
//	{
//		step = 60;
//	}
	$(document).ready(function() {
		
                //fnGetAndUpdateGraphData('3');
                
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
				text: 'Portal Sale Trends',
				x: -20 //center
			},
			xAxis: {
				categories: <?php echo $strSeriesLabels; ?>,
				labels: {
					step: step
				}
			},
			yAxis: {
                            allowDecimals: false,
                            min: 0,
//                            max: 30,
				title: {
					text: 'Sale'
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
				valueSuffix: '$'
			},
			series: <?php echo $strSeriesLabelsValues; ?>,
			exporting: {
				enabled: false
			}
		});
		
		$('#container').highcharts({
			title: {
				text: 'Portal User Event Trends',
				x: -20 //center
			},
			xAxis: {
				categories: <?php echo $strSeriesLabels2; ?>,
				labels: {
					step: step
				}
			},
			yAxis: {
                            allowDecimals: false,
                            min: 0,
//                            max: 30,
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
			series: <?php echo $strSeriesLabelsValues2; ?>,
			exporting: {
				enabled: false
			}
		});
	
	});
	
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
					if(is_array($arrEvents) &&(count($arrEvents)>0))
					{
						for($i = 0; $i<count($arrEvents); $i++)
						{
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
					$('#propertycontainernew').highcharts().series[i].update({ type: selectedTab});
				}
			}
			else
			{	
				<?php
					if(is_array($arrEvents) &&(count($arrEvents)>0))
					{
						for($i = 0; $i<count($arrEvents); $i++)
						{
							?>
								$('#containernew').highcharts().series[<?php echo $i; ?>].update({ type: selectedTab});
							<?php
						}
					}
				?>
				
			}
			$(bar).removeClass('active');
			$(line).addClass('active');
		}
	}
</script>
<script type="text/javascript">
	function fnUpdateGraphData(strPeriod)
	{
		$('.periods').removeClass('active');
		if(strPeriod == "7")
		{
			$('#week').addClass('active');
		}
		if(strPeriod == "30")
		{
			$('#month').addClass('active');
		}
		if(strPeriod == "1")
		{
			$('#today').addClass('active');
		}
		if(strPeriod == "365")
		{
			$('#year').addClass('active');
		}
		if(strPeriod == "curr_year")
		{
			$('#year').addClass('active');
		}
		//var strPeriod = $('#period').val();
		fnGetAndUpdateGraphData(strPeriod);
	}
	
	function fnGetAndUpdateGraphData(strPeriodToView)
	{
		var strGraphDataUrl = "<?php echo $strAjaxGraphUrl; ?>";
		var datastrj = "periodtoviewfrm="+strPeriodToView;
		$.ajax({ 
				type: "POST",
				url: strGraphDataUrl,
				data: datastrj,
				cache: false,
				dataType: 'json',
				beforeSend: function(){
					$('#containernew').highcharts().showLoading();
					$('#container').highcharts().showLoading();
				},
				success: function(data)
				{
					var intTotalVals = data.totlavals.split("~");
					$('#totalusers').text(intTotalVals[0]);
					$('#totalsale').text("$"+intTotalVals[1]);
					
					var seriesdata = [];
					if(data.xseries != "")
					{
						var xseries = data.xseries.split(",");
                                                
						if(data.dataseries != "")
						{
							dataser = data.dataseries.split("~");

							
							if(dataser.length > 0)
							{
								for(var i = 0; i<dataser.length; i++)
								{
									arrseriesdata = dataser[i].split(":");
									var strCont = "containernew";

									if(arrseriesdata[0] == "Monster Registered Users")
									{
										strCont = "container";
									}
									else
									{
										strCont = "containernew";
									}
									var seriescount = $('#'+strCont).highcharts().series.length;
									for(var j=(seriescount-1);j>=0;j--)
									{
										$('#'+strCont).highcharts().series[j].remove();
									}
//									var iSteps = 10;
//									if(strPeriodToView == "curr_year" && strPeriodToView == "30")
//									{
//										iSteps = 30;
//									}
									
//									switch(data.monhtsdata)
//									{
//										case 1: iSteps = 5;
//												break;
//										case 2: iSteps = 5;
//												break;
//										case 3: iSteps = 10;
//												break;
//										case 4: iSteps = 50;
//												break;
//										case 12: iSteps = 30;
//												break;
//									}
                                                                        
									$('#'+strCont).highcharts().setTitle({ text: data.chartTitle+' Trends '});
//									$('#'+strCont).highcharts().xAxis[0].update ({labels: { step : iSteps }});
									$('#'+strCont).highcharts().xAxis[0].setCategories(xseries);
									
									seriesdata = JSON.parse("[" + arrseriesdata[1] + "]");
									
									$('#'+strCont).highcharts().addSeries({                        
										name: arrseriesdata[0],
										data: seriesdata
									}, false);
									
									$('#'+strCont).highcharts().redraw();
									$('#'+strCont).highcharts().hideLoading();
								}
								
							}
							
							
							/*dataser = JSON.parse("[" + data.dataseries + "]");	
							seriesdata = dataser;
							$('#containernew').highcharts().setTitle({ text: data.chartTitle+' Trends '});
							$('#containernew').highcharts().xAxis[0].setCategories(xseries);
							$('#containernew').highcharts().series[0].setData(seriesdata);*/
						}
						else
						{
							seriesdata = [];
						}				
						$('#containernew').highcharts().hideLoading();
						$('#container').highcharts().hideLoading();
					}
					
				}
		});
	}
</script>

