<script>
$(document).ready(function () {
		$("#selectperiod").change(function () {
			//alert("hi");return false;
		   var selectedText = $(this).val();    
		   var reviewtype = $("#selecttype").val();
		   	if(selectedText == "custom")
			{
				$('#custom_dates_cont').show();
				//fnGetDataBetweenDates();
				return false;
			}
			else
			{
				$('#custom_dates_cont').hide();
				$.ajax({ 

						type: "GET",

						url: strBaseUrl+"vendoraccount/getVendorOrderCountHtml/"+selectedText+"/"+reviewtype,

						dataType: 'json',

						data:"",

						cache:false,

						success: function(data)

						{

							if(data.status == "success")

							{

								if(reviewtype == 'Order')
								{
									$('#vendorstatictics').html(data.html);
								}
								else
								{
									$('#vendorrevenue').html(data.html);
								}
								$('.cms-bgloader-mask').hide();//show loader mask
								$('.cms-bgloader').hide(); //show loading image
				
								//$('.tabloader').hide();

								

							}

							else

							{
								$('.cms-bgloader-mask').hide();//show loader mask
								$('.cms-bgloader').hide(); //show loading image

							}

						}

				});
			}
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
        });
		$("#selecttype").change(function () {
			//alert("hi");//return false;
		    var selectedText = $(this).val();  
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
		   	if(selectedText == "Order")
			{
				$('#vendorstatictics').show();
				$('#vendorrevenue').hide();
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide();
				//fnGetDataBetweenDates();
				//return false;
			}
			else
			{
				$('#vendorstatictics').hide();
				$('#vendorrevenue').show();
				$('.cms-bgloader-mask').hide();//show loader mask
				$('.cms-bgloader').hide();
			}
			
        });
});

function fnGetDataBetweenDates()
{
	 var selectedText = $('#selectperiod').val();
	 var reviewtype = $("#selecttype").val();
	 var strStartDate =  $('#from_date_hid').val();
	 var strEndDate =  $('#to_date_hid').val();
	 strStartDate = strStartDate.replace(/\//g, "-");
	 strEndDate = strEndDate.replace(/\//g, "-");
	 $('.cms-bgloader-mask').show();//show loader mask
	 $('.cms-bgloader').show(); //show loading image		
	$.ajax({
				type: "GET",
				url: strBaseUrl+"vendoraccount/getVendorOrderCountHtml/"+selectedText+"/"+reviewtype+"/"+strStartDate+"/"+strEndDate,
				dataType: 'json',
				data:"",
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						if(reviewtype == 'Order')
						{
							$('#vendorstatictics').html(data.html);
						}
						else
						{
							$('#vendorrevenue').html(data.html);
						}
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image		
						//$('.tabloader').hide();						
					}
					else
					{
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
					}
				}
		});
}
</script>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Dashboard</h1>
                <p>Welcome <?php echo $arrLoggedVendor['vendor_name']; ?> to your Career Portal Vendor Management Resource.</p>
                <div class="form-container vendor-dashboard-form">
                    <form role="form">
                        <div class="form-group" style="overflow:unset;">
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <label class="control-label" for="period">Type:</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <select name="type"  id="selecttype" class="form-control" title="Choose a type">
                                    <option value="Order">By Order</option>
                                    <option value="Revenue">By Revenue</option>

                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <label class="control-label" for="period">Reporting period:</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-10">
                                <select name="period"  id="selectperiod" class="form-control" title="Choose a period">
                                    <option value="select">Select Period</option>
                                    <option value="day">Last day</option>
                                    <option value="week">Last week</option>
                                    <option value="month">Last month</option>
                                    <option value="year">Last year</option>
                                    <option value="custom">Custom Dates</option>
                                </select>
                            </div>
                            <div style="display:none;" id="custom_dates_cont">
                                <div class="col-xs-12 col-sm-12 col-md-2">
                                    <label class="control-label" for="period">Custom Dates:</label>
                                </div>
                                <div id="custom_detail" lass="input-group date col-xs-12 col-sm-12 col-md-10">
                                    <div class="col-md-4">
                                        From:<input style="width:100%;border-radius:4px;"  type="text" name="from_date" id="from_date" class="form-control" />
                                        <input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid">
                                    </div>
                                    <div class="col-md-4">
                                        To:<input style="width:100%;border-radius:4px;" type="text" name="to_date" id="to_date" class="form-control" />
                                        <input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid">
                                    </div>
                                    <div class="col-md-2">
                                        &nbsp;<input type="button" style="width:100%;" name="go_button" id="go_button" value="Go" onclick="fnGetDataBetweenDates();" class="btn-primary" />
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
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">&nbsp;</div>
                <div id="vendorstatictics" style="margin-top:10px;">
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">New Orders</p>
                            <p class="statistic-data-value"><?php
                                if ($intPortalCandidates) {
                                    echo $intPortalCandidates;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                            <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">Open Orders</p>
                            <p class="statistic-data-value"><?php
                                if ($intOpenPortalCandidates) {
                                    echo $intOpenPortalCandidates;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                    <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">Pending Orders</p>
                            <p class="statistic-data-value"><?php
                                if ($intPendingPortalCandidates) {
                                    echo $intPendingPortalCandidates;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                            <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">Closed Orders</p>
                            <p class="statistic-data-value"><?php
                                if ($intClosedPortalCandidates) {
                                    echo $intClosedPortalCandidates;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                            <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div><!-- For revenue-->
                <div id="vendorrevenue" style="margin-top:10px;display:none;">
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">Amount Earned</p>
                            <p class="statistic-data-value"><?php
                                if ($intClosedOrderTotal) {
                                    echo $intClosedOrderTotal;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                            <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>
                    <div class="vendor-statistic-container">
                        <div class="admin-statistic-block">
                            <p class="statistic-data-header">Refunds</p>
                            <p class="statistic-data-value"><?php
                                if ($intRefundOrderTotal) {
                                    echo $intRefundOrderTotal;
                                } else {
                                    echo "0";
                                }
                                ?></p>
                            <!--<a href="#" class="link-success"><span></span>10%</a>-->
                        </div>
                    </div>

                </div>
                <div>
                        <!--<img src="<?php echo Router::url('/', true); ?>images/temp-content.png" alt="image-description">-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!--<div class="index container-layout">
	<div id="page-title">
		<h3>Welcome to your Cpanel!</h3>
	</div>
	
	<div class="row">
		<div id="dashboard_content_container" style="float:left;width:100%;padding:5px;">
			<div id="portal_statistics" style="float:left;width:60%;margin-right:3%;">
				<div id="head" style="float:left;width:100%;margin-bottom:10px;"><h3>Quick Statistics</h3></div>
				<div id="content" style="float:left;width:100%;">
					<div id="portal_details" style="float:left;width:100%;">
						<div style="float:left;width:48%;margin-right:2%;"><label>New Orders for Current Month</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								$strRegistrantsUrl = Router::url(array('controller'=>'manageseekers','action'=>'index'),true);
								if($intPortalOwners)
								{
									?>
										<a href="javascript:void(0);"><?php echo $intPortalOwners; ?></a>
									<?php
								}
								else
								{
									?>
										<label>&nbsp;</label>
									<?php
								}
							?>
						</div>
						<div style="float:left;width:100%;">&nbsp;</div>
						<div style="float:left;width:48%;margin-right:2%;"><label>Total number of New Orders</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								if($intPortalCandidates)
								{
									$strAdminManageOwnerUrl = Router::url(array('controller'=>'manageowners','action'=>'index'),true);
									?>
										<a href="javascript:void(0);"><?php echo $intPortalCandidates; ?></a>
									<?php
								}
								else
								{
									?>
										<label>&nbsp;</label>
									<?php
								}
							?>
						</div>
					</div>
				</div>
				<div id="foot"></div>
			</div>
		</div>
	</div>-->
	
	
	<!--<table cellpadding="0" cellspacing="0">
	<tr>
			<th>id</th>
			<th>name</th>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>
	</table>-->
</div>

<!--<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('New User', array('action' => 'add')); ?></li>
	</ul>
</div>-->
