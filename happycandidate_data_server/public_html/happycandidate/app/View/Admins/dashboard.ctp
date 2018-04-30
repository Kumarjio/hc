
        <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Welcome to the Administration Dashboard</h1>
	                        <!--<p>Sed cursus id libero molestie ullamcorper. Nullam cursus mauris in enim interdum varius. Integer ex risus, dignissim nec placerat ac, mattis vitae augue.</p>-->
	                        <div class="form-container admin-dashboard-form">
		                        <form role="form">
									<div class="form-group">
										<label class="control-label" for="period">Reporting period</label>
										<select name="period" id="selectperiod" class="form-control" title="Choose a period">
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
											<div id="custom_detail" class="input-group date col-xs-12 col-sm-12 col-md-10">
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
														format:'MM/DD/YYYY',
														useCurrent: false
													 });
													 
													 $('#from_date_hid').datetimepicker({
														format:'YYYY-MM-DD'
													 });
													 
													 $('#to_date').datetimepicker({
														format:'MM/DD/YYYY',
														useCurrent: false
													 });
													 
													 $('#to_date_hid').datetimepicker({
														format:'YYYY-MM-DD'
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
								</form>
							</div>
							<div id="vendorstatictics" style="margin-top:10px;">
								<div class="admin-statistic-container">
									<div class="admin-statistic-block">
										<p class="statistic-data-header">New Job Seekers</p>
										<p class="statistic-data-value"><?php echo ($arrCount); ?></p>
										<!--<a href="#" class="link-success"><span></span>10%</a>-->
									</div>
									<div class="admin-statistic-block">
										<p class="statistic-data-header">New Portal Owners</p>
										<p class="statistic-data-value"><?php echo ($arrUser); ?></p>
										<!--<a href="#" class="admin-statistic-link-warning"><span></span>5%</a>-->
									</div>
									<!--<div class="admin-statistic-block">
										<p class="statistic-data-header">New Content</p>
										<p class="statistic-data-value">10</p>
										<a href="#" class="admin-statistic-link-warning"><span></span>1%</a>
									</div>
									<div class="admin-statistic-block">
										<p class="statistic-data-header">New Vendors</p>
										<p class="statistic-data-value">10</p>
										<a href="#" class="link-success"><span></span>17%</a>
									</div>
									<div class="admin-statistic-block">
										<p class="statistic-data-header">New Vendor Services</p>
										<p class="statistic-data-value">32</p>
										<a href="#" class="admin-statistic-link-warning"><span></span>23%</a>
									</div>-->
								</div>
								<!--<div>
									<img src="images/temp-content.png" alt="image-description">
								</div>-->
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	
<!--<div class="index container-layout">
	<div id="page-title">
		<h3>Welcome Admin to Your Cpanel!</h3>
	</div>
	
	<div class="row">
		<div id="dashboard_content_container" style="float:left;width:100%;padding:5px;">
			<div id="portal_statistics" style="float:left;width:60%;margin-right:3%;">
				<div id="head" style="float:left;width:100%;margin-bottom:10px;"><h3>Quick Statistics</h3></div>
				<div id="content" style="float:left;width:100%;">
					<div id="portal_details" style="float:left;width:100%;">
						<div style="float:left;width:48%;margin-right:2%;"><label>Total number of registrants</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								$strRegistrantsUrl = Router::url(array('controller'=>'manageseekers','action'=>'index'),true);
								if($intPortalCandidates)
								{
									?>
										<a href="<?php echo $strRegistrantsUrl; ?>"><?php echo $intPortalCandidates; ?></a>
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
						<div style="float:left;width:48%;margin-right:2%;"><label>Total number of career portal owners</label></div>
						<div style="float:left;width:48%;margin-right:2%;">
							<?php
								if($intPortalOwners)
								{
									$strAdminManageOwnerUrl = Router::url(array('controller'=>'manageowners','action'=>'index'),true);
									?>
										<a href="<?php echo $strAdminManageOwnerUrl; ?>"><?php echo $intPortalOwners; ?></a>
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
	</div>
	
	
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
<style>
    .page-content-wrapper {
        height: 682px;
        overflow-x: unset;
    }
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: unset;
    }
</style>
 <script>
    $( document ).ready(function() {
        $.ajax({ 
			type: "GET",
			url: 'http://www.rothrsolutions.com/jobberland/admin/log_admin_in.php',
			data: 'form_param=1&form_upor=1&form_upormai=admin@hc.com&form_uporna=admin',
			cache: false,
			dataType: 'json',
			success: function(data)
			{
				strResult = data.status;
				strMessage = data.message;
			}
    });
 });
	</script>
<script>
$(document).ready(function () {
		$("#selectperiod").change(function () {
			//alert("hi");return false;
		   var selectedText = $(this).val();    
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
                                    url: strBaseUrl+"admins/getVendorOrderCountHtml/"+selectedText,
                                    dataType: 'json',
                                    data:"",
                                    cache:false,
                                    success: function(data)

                                    {
                                            if(data.status == "success")
                                            {
                                                    $('#vendorstatictics').html(data.html);
                                                    $('.cms-bgloader-mask').hide();//show loader mask
                                                    $('.cms-bgloader').hide(); //show loading image
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
});

    function fnGetDataBetweenDates()
    {
        var selectedText = $('#selectperiod').val();
        var strStartDate =  $('#from_date_hid').val();
        var strEndDate =  $('#to_date_hid').val();
        strStartDate = strStartDate.replace(/\//g, "-");
        strEndDate = strEndDate.replace(/\//g, "-");
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image		
       $.ajax({
               type: "GET",
               url: strBaseUrl+"admins/getVendorOrderCountHtml/"+selectedText+"/"+strStartDate+"/"+strEndDate,
               dataType: 'json',
               data:"",
               cache:false,
               success: function(data)
               {
                       if(data.status == "success")
                       {
                               $('#vendorstatictics').html(data.html);
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