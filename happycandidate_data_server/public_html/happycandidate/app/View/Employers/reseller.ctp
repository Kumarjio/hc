<div class="container-fluid bg-lightest-grey">

		<div class="row">



			<div class="col-md-12 bg-lightest-grey">
				

				
				<div  class="tab-content">
					<div class="tab-pane fade <?php echo $type==''?'in active':''?>" id="tab-profile">
						<h3>Reseller</h3>
						<?php
							if($strMssg)
							{
								?>
									<div id="alertMessages">
										<div class="alert <?php echo $strMssgClass;?>">
										  <img alt="image description" src="<?php echo Router::url('/',true);?>/images/icon-alert-success.png">
										  <a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>
										  <?php echo $strMssg;?>
										</div>	
									</div>
								<?php
								
							}
						?>
						

						<!--PERSONAL INFORMATION PILL DYN-->			
						<div class="panel-slider" id="personal-info-panel-slider">
							
							<!--submenu-->			
							<div data-parent="#personal-info-panel-slider" id="personal-info" >
								<div class="col-md-12 form-container edit-profile">
										<form action="" method="post" name="contentform" enctype="multipart/form-data" id="contentform">
										
										
										
										<div class="form-group">
											<label class="control-label col-xs-12 col-sm-12 col-md-3">Domain Name: </label>
											 
											 <input type="text" placeholder="Domain Name" name="c_fname" id="c_fname"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_company_name'];?>" class="col-xs-12 col-sm-12 col-md-12 validate[required]">
											<button class="btn btn-primary" type="submit" name="domain_search" id="domain_search" style="margin-left: 50px;">Search Domain</button> 
										</div>
										
									</form>
									
									<div class="panel-heading vendor-orders">
										<table>
											<tr>
												<th>#ID</th>
												<th>Domain Name</th>
												<th>Action</th>
											</tr>
										</table>
									</div>
									<div class="panel-body vendor-orders">
										<table id="domain">
											
										</table>
									</div>	
								</div>

							</div>
						</div>
						<!--END OF PERSONAL INFORMATION PILL DYN-->		
				
					</div>
					
				</div>
			</div>
			
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function ()
{
    var c_fname = $("#c_fname").val();
	$.ajax({
	type: "GET",
	url: "https://api.ote-godaddy.com/v1/domains/suggest?query="+c_fname,
	success: function(body) 
		{ 
			
			var i=1;
			$.each( body, function( key, value ) {
				
				var toAppend = '';
				toAppend += '<tr><td>'+i+'</td>';
				toAppend += '<td>'+value.domain+'</td>';
				toAppend += '<td><button class="btn btn-primary" name="buy" id="buy" style="margin-left: 50px;" onclick=function buy_domain('+value.domain+')>Buy</button></td></tr>';
				$("#domain").append(toAppend);
			 
			  i++;
			});
		}
	});
	
	
});
$("#domain_search").click( function(event){
		$("#domain").html('');
		var c_fname = $("#c_fname").val();
		
		$.ajax({
		type: "GET",
		url: "https://api.ote-godaddy.com/v1/domains/suggest?query="+c_fname,
		success: function(body) 
			{ 
				
				var i=1;
				$.each( body, function( key, value ) {
					
					var toAppend = '';
					toAppend += '<tr><td>'+i+'</td>';
					toAppend += '<td>'+value.domain+'</td>';
					toAppend += '<td><button class="btn btn-primary" name="buy" id="buy" style="margin-left: 50px;" onclick=function buy_domain('+value.domain+')>Buy</button></td></tr>';
					$("#domain").append(toAppend);
				 
				  i++;
				});
			}
		});
		event.preventDefault();
		
	});
</script>
