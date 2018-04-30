<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>

     <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Service List</h3>
							<?php
			$strProductaddUrl = Router::url(array('controller'=>'resource','action'=>'add'),true);
		?>
							<button onclick="javascript:location.href='<?php echo $strProductaddUrl;?>'" href="" class="btn btn-primary btn-sm">Add New</button>
						</div>

						<div class="tab-row-container ">
						
							<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'resource','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>
						<!-- USER RESUME TOP CONTROLS -->
					
						
						<div class="tab-row-container resourcetab">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table>
										<tr>
											<th>SR. ID #</th>
											<th class="selected">Name<span></span></th>
											<th>Type</th>
											<th>Date Created</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'resource','action'=>'edit',$arrContent['products']['productd_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'resource','action'=>'preview',"5",$arrContent['products']['productd_id']),true);
					$strProductManageUrl = Router::url(array('controller'=>'mylms','action'=>'manage',$arrContent['products']['productd_id']),true);
					?>
										<tr id="product_list_<?php echo $arrContent['products']['productd_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						
											<td>
												<div class="user-title">
													<a href="#str<?php echo $arrContent['products']['productd_id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($arrContent['products']['product_name']); ?></a>
												</div>
											</td>
											
											<td><?php echo $arrContent['products']['product_type'];
							?></td>
											<td><?php echo date($productdateformat,strtotime($arrContent['products']['product_creation_date'])) ?></td>
											
										</tr>
										<tr id="str<?php echo $arrContent['products']['productd_id'];?>" class="hide-str">
											<td></td>
											<td colspan="5">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
													<a href="<?php echo $strPreviewUrl ?>" class="link-primary">Preview</a> |
													<a href="#" id="resource_del_<?php echo $arrContent['products']['productd_id'];?>" onClick="return fnDeleteResource(this);" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
									
											<?php
				}
			}
		?>
									</table>
							 	</div>
							 	<div class="panel-footer admin-content">
							 		<table>
										<tr>
											<th>SR. ID #</th>
											<th class="selected">Name<span></span></th>
											<th>Type</th>
											<th>Date Created</th>
										</tr>
									</table>
							 	</div>
							</div>

							<div class="panel panel-default hidden-md hidden-lg">
							  	<div class="panel-heading">
									<table>
										<tr>
											<th><input type="checkbox" value=""></th>
											<th>Title</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body small-view">
							 		<table>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Evaluate Your Attitude</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr class="selected">
											<td><input class="small-view" type="checkbox" value="" checked></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Set Realistic Expectations</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, maxime!</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Determine Job Target Criteria</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
										<tr>
											<td><input class="small-view" type="checkbox" value=""></td>
											<td>
												<div class="user-title">
													<a class="username-clickable">Identify Specific Target Companies</a>
												</div>
											</td>
											<td>
												<div class="user-options visible">
													<a href="#" class="link-primary">Edit</a> |
													<a href="#" class="link-primary">Preview</a> |
													<a href="#" class="link-warning">Delete</a>
												</div>
											</td>
										</tr>
									</table>
							 	</div>
							 	<div class="panel-footer">
							 		<table>
										<tr>
											<th><input type="checkbox" value=""></th>
											<th>Title</th>
											<th class="disabled">Options</th>
										</tr>
									</table>
							 	</div>
							</div>
						</div>
						
						<div class="tab-row-container">
						
							<div class="tab-controls-pagination">
							<table class="table table-striped" >
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
	<h1>Services</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Service List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'resource','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Service title" /></div>
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
		  <th class="col-md-1" style="width:10%;">Type</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'resource','action'=>'edit',$arrContent['products']['productd_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'resource','action'=>'preview',"5",$arrContent['products']['productd_id']),true);
					$strProductManageUrl = Router::url(array('controller'=>'mylms','action'=>'manage',$arrContent['products']['productd_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['products']['productd_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['products']['product_name']); ?></a></td>
						  <td>
							<?php 
								echo $arrContent['products']['product_type'];
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['products']['product_creation_date'])) ?></td>
						  <!--<td><?php echo $arrContent['products']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['products']['productd_id'];?>')" href="javascript:void(0);">Delete</a></td>
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
</div>*/ ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the third column (we start counting zero)
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