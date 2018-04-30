<?php
	echo $this->Html->script('add_vendor_update');
?>
 <div class="page-content-wrapper">
	            <div class="container-fluid">
<div class="row">
			
			
				<div class="page-header">
					<h2>Vendors</h2>
					<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
				</div>

				<ul class="nav nav-pills tab-list">
					<li class="active">
						<a href="#tab-vendor-panel" data-toggle="pill" id="js-vendor-panel">Vendor Panel</a>
					</li>
					
					<li>
						<a href="#tab-content-panel" data-toggle="pill" id="js-content-panel">Vendor Content Panel</a>
					</li>
					<li>
						<a href="#tab-company-detail" data-toggle="pill" id="js-company-detail">Vendor Company Detail</a>
					</li>
				
				</ul>
				<div style="padding-top: 20px;" class="tab-content">
					<div class="tab-pane fade in active" id="tab-vendor-panel">
						<?php 
							echo $this->element("vendors");
						?>
						

					</div>
					
						
					<div class="tab-pane fade" id="tab-content-panel">
							<div id="parent_content_form"></div>
						</div>

				<div class="tab-pane fade" id="tab-company-detail">
							
							<div id="vendorcompanycontainer"></div>
					</div>
				
					
				</div>
		
			
		</div>
		</div>
		</div>

<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {

			
			
		var strVendorType = '<?php echo $arrProductContent[0]['Vendors']['vendor_type'];?>';
		$('#vendor_type').val(strVendorType);
		
		$('#add_publish').val('Edit');
		
		
		$("a[data-toggle='pill']").click(function() {
		   
		   var strNewTab = $(this).attr('id');
		
				if(strNewTab == "js-content-panel")
				{
				  
					if($('#contentparentform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
					
						fnGetParentContentForm();
					}
				}
				
				if(strNewTab == "js-company-detail")
				{
					if($('#vendorcompanydetailform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetCompanyDetailForm();
					}
				}
			
		});
	});
</script>
