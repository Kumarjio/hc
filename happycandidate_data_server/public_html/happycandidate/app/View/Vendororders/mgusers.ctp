<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<?php
	//$arrLoggedUser = $this->Auth->user();
?>

        <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>User List</h3>
						</div>
	<div class="tab-row-container ">
						
							<!--<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendors','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>-->
						
						
						<!-- USER RESUME TOP CONTROLS -->
						<div class="tab-row-container">
						
							
						</div>
						
						
			<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				//print("<pre>");
				//print_r($arrProductList);
				
				?>
				<div class="tab-row-container">
					<div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
						<div class="panel-heading vendor-orders">
							<table>
										<tr>
										
											<th>#</th>
											<th>Name</th>
											<th class="selected">Email<span></span></th>
											<th>Head</th>
											<th>Date Created</th>
										</tr>
									</table>
						</div>
						<div class="panel-body vendor-orders">
							<table>
				<?php
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendoraccount','action'=>'edituser',$arrContent['Vendors']['vendor_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendors','action'=>'preview',"5",$arrContent['Vendors']['vendor_id']),true);
					?>
										<tr>
											<td>
												
													<?php echo $intContentCount;?>
											
											</td>
											<td>
											<div class="user-title">
													<a href="#str<?php echo $arrContent['Vendors']['vendor_id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($arrContent['Vendors']['vendor_first_name']." ".$arrContent['Vendors']['vendor_last_name']); ?></a>
												</div>
											</td>
											<td><?php echo $arrContent['Vendors']['vendor_email']; ?></td>
											<td id="order_status_<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>"><?php echo $strVendorHead; ?></td>
											<td><?php echo date($productdateformat,strtotime($arrContent['Vendors']['vendor_creation_date'])) ?></td>
										</tr>
					
									<tr id="str<?php echo $arrContent['Vendors']['vendor_id'];?>" class="hide-str">
									<td>
									</td>
											<td colspan="4">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
													<a href="#" id="vendor_del_<?php echo $arrContent['Vendors']['vendor_id'];?>" onClick="return false;" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										
										
										
									
											<?php
				}
				?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			else
			{
				?>
					<div class="tab-row-container">
						<div class="col-md-12">
							There are no users created in the system by you. 
						</div>
					</div>
				<?php
			}
		?>
									
						
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
	 
	 <?php
	 /*
<div class="page-header index row">
	<h1>Vendors</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Vendor List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendors','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Vendor title" /></div>
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;">
				&nbsp;<input name="product_search" id="product_search" class="btn btn-default btn-primary" type="submit" value="Filter"></input>
			</div>
		</form>
	</div>
</div>
<?php
	echo $this->element('delete_confirmation');
?>
<div class="row index" style="width:100%;float:left;">
	<table id="product_list" class="table tablesorter" style="width:80%;">
	  <thead>
		<tr>
		  <th class="col-md-1" style="width:5%;">#</th>
		  <th class="col-md-4" style="width:26%;">Name</th>
		  <th class="col-md-1" style="width:10%;">Email</th>
		  <th class="col-md-2" style="width:12%;">Created On</th>
		  <th class="col-md-2" style="width:20%;">Action</th>
		</tr>
	  </thead>
	  <tbody>
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
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['vendors']['vendor_name']); ?></a></td>
						  <td><?php echo $arrContent['vendors']['vendor_email']; ?></td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['vendors']['vendor_creation_date'])) ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['vendors']['vendor_id'];?>')" href="javascript:void(0);">Delete</a></td>
						</tr>
					<?php
				}
			}
		?>
	  </tbody>
	</table>
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
*/?>
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
			});
	}
	);
</script>
<script type="text/javascript">
 $(".panel-body.vendor-orders .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
                                event.preventDefault();
			});
			
/*function fnDeleteSubVendor(ele)
{
	var strElement = $(ele).attr('id');
	var arrEle = strElement.split("_");
	var strId = arrEle[2];
	
	
}*/
	

</script>