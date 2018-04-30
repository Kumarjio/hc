<?php
	echo $this->element('delete_confirmation_vendor');
?>
<?php
	echo $this->element('passwordnotification_confirmation_vendor');
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>

        <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Vendor List</h3>
							
								<?php
			$strVendoraddUrl = Router::url(array('controller'=>'vendors','action'=>'add'),true);
		?>
							<button onclick="javascript:location.href='<?php echo $strVendoraddUrl;?>'" type="button" class="btn btn-primary btn-sm">Add New</button>
							<div style="margin-top:5px;" id="product_notification" class="index row"><?php echo $strMessage;?></div>
						</div>
	<div class="tab-row-container ">
						
							<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendors','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>
						
						
						<!-- USER RESUME TOP CONTROLS -->
						<div class="tab-row-container">
						
							
						</div>
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table>
										<tr>
											<th style="width:10%!important;">ID</th>
											<th class="selected" style="width:30%!important;">Name<span></span></th>
											<th style="width:20%!important;">Email</th>
											<th style="width:20%!important;">Company Name</th>
											<th style="width:20%!important;">Date Created</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body admin-content">
							 		<table>
										<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendors','action'=>'edit',$arrContent['vendors']['vendor_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendors','action'=>'preview',"5",$arrContent['vendors']['vendor_id']),true);
					?>
										<tr id="product_list_<?php echo $arrContent['vendors']['vendor_id'];?>">
											<td style="width:10%!important;">
												<?php echo $intContentCount; ?>
											</td>
											<td style="width:30%!important;">
												<div class="user-title">
													<a href="#str<?php echo $arrContent['vendors']['vendor_id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($arrContent['vendors']['vendor_first_name']." ".$arrContent['vendors']['vendor_last_name']); ?></a>
												</div>
											</td>
											
											<td style="width:20%!important;"><?php echo $arrContent['vendors']['vendor_email']; ?></td>
											<td style="width:20%!important;"><?php 
											if($arrContent['vendor_company_details']['company_name'])
											{
												echo $arrContent['vendor_company_details']['company_name']; 
											}
											else
											{
												echo "Not Provided"; 
											}
											
											
											?></td>
											
											<td style="width:20%!important;"><?php echo date($productdateformat,strtotime($arrContent['vendors']['vendor_creation_date'])) ?></td>
											
										</tr>
										<tr id="str<?php echo $arrContent['vendors']['vendor_id'];?>" class="hide-str">
											<td></td>
											<td colspan="5">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
													<a id="vendor_pass_<?php echo $arrContent['vendors']['vendor_id'];?>" href="javascript:void(0);" onClick="fnSendPassNot(this)"  class="link-primary">Notify Password</a> |
													<a href="#" id="vendor_del_<?php echo $arrContent['vendors']['vendor_id'];?>" onClick="fnDeleteVendor(this)" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
									
											<?php
				}
			}
		?>
									</table>
							 	</div>
							 	<!--<div class="panel-footer admin-content">
							 		<table>
										<tr>
											<th>ID</th>
											<th class="selected">Name<span></span></th>
											<th>Email</th>
											<th>Date Created</th>
										</tr>
									</table>
							 	</div>-->
							</div>

					</div>
						
						<div class="tab-row-container">
							<div class="tab-controls-actions">
								
								
							</div>
							<div class="tab-controls-pagination">
								<table class="table table-striped" style="width:80%;">
		<tr>
			<td colspan='6' align='left'>
				<?php
					if($this->Paginator->hasPrev())
					{
						echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					}
				?>
				&nbsp;
				<?php 
					echo $this->Paginator->numbers(array('last' => 'Last page'));
				?>
				&nbsp;
				<?php
					if($this->Paginator->hasNext())
					{
						echo $this->Paginator->next(__('next').' >> ' , array(), null, array('class' => 'next disabled'));
					}
				?>
			</td>
		</tr>
	</table>
							</div>
						</div>
	                </div>
	            </div>
	        </div>
<script src="http://www.rothrsolutions.com/happycandidate/app/webroot/js/jquery.tablesorter.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the third column (we start counting zero)
				3: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				}
			}
		});
		 
		 $(".panel-body.admin-content .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
                                event.preventDefault();
			});
	}
	);
</script>