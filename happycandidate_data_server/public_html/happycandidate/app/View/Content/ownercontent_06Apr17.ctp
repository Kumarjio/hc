<?php echo $this->Html->script('jquery.tablesorter');?>
<script type="text/javascript">

	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
		$(".panel-body .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
				event.preventDefault();
			});
			$("#product_list").tablesorter({
				// pass the headers argument and assing a object
				headers: {
					// assign the secound column (we start counting zero)
					0: {
						// disable it by setting the property sorter to false
						sorter: false
					},
					// assign the third column (we start counting zero)
					3: {
						// disable it by setting the property sorter to false
						sorter: false
					}
				}
			});
	});

</script>

      <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>All Content</h3>
							<?php $contentadd = Router::url(array('controller'=>'content','action'=>'add'),true);?>
							<button class="btn btn-primary btn-sm" onclick="javascript:window.location='<?php echo $contentadd;?>'">Add New</button>
								<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'content','action'=>'ownercontent'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>

					<!--	<div class="tab-row-container">
							<div class="tab-filters">
								<a href="#" class="active">All <span>(6)</span></a> |
								<a href="#" class="link-primary">Published <span>(4)</span></a> |
								<a href="#" class="link-primary">Drafted <span>(1)</span></a> |
								<a href="#" class="link-warning">Trashed <span>(1)</span></a>
							</div>
							<div class="tab-search">
								<input type="text" value="" name="search" placeholder="Search">
								<button type="button" class="btn btn-default btn-md">Search</button>
							</div>
						</div>-->
						<!-- USER RESUME TOP CONTROLS -->
							<!--<div class="tab-row-container">
							<div class="tab-controls-actions">
								<div class="form-group">
									<select name="bulk-actions" title="Bulk Actions">
										<option value="value1">Bulk Action1</option>
										<option value="value2">Bulk Action2</option>
										<option value="value3">Bulk Action3</option>
										<option value="value4">Bulk Action4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Apply</button>
								</div>
								<div class="form-group">
									<select name="date-filter" title="Date Filter">
										<option value="value1">Date Filter1</option>
										<option value="value2">Date Filter2</option>
										<option value="value3">Date Filter3</option>
										<option value="value4">Date Filter4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Filter</button>
								</div>
							</div>
							<div class="tab-controls-pagination">
								<button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
								<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
								<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
								<input type="text" value="" name="input-page-number" placeholder="1">
								<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
								<button type="button" class="btn btn-default goto-next-active"><span></span></button>
								<button type="button" class="btn btn-default goto-end-active"><span></span></button>
							</div>
						</div>-->
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table id="product_list">
										<tr>
											<th>ID #</th>
											<th class="selected">Title<span></span></th>
											<th>Content User</th>
											<th>Content Type</th>
											<th>Status</th>
											<th>Date Created</th>
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body admin-content">
							 		<table >
									<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
				
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'content','action'=>'edit',$arrContent['content']['content_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'content','action'=>'preview',"5",$arrContent['content']['content_id']),true);
					?>
										<tr id="product_list_<?php echo $arrContent['content']['content_id'];?>">
											<td>
												<?php echo $intContentCount; ?>
											</td>
											<td>
											 
												<div class="user-title">
													<a href="#str<?php echo $arrContent['content']['content_id'];?>" id="task1" class="username-clickable"><?php echo stripslashes($arrContent['content']['content_title']); ?></a>
												</div>
											</td>
											
											<td>
											<?php
								if($arrContent['content']['content_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['content']['content_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?></td>
							<td >
											<?php echo $arrContent['content_type']['content_type_name'];?>
											</td>
											<td id="status_<?php echo $arrContent['content']['content_id'];?>"><?php echo ucfirst($arrContent['content']['content_status'])=="Published"?"Active":"Inactive"; ?></td>
											<td><?php echo date($productdateformat,strtotime($arrContent['content']['created_date'])) ?></td>
										</tr>
										<tr id="str<?php echo $arrContent['content']['content_id'];?>" class="hide-str">
											<td></td>
											<td colspan="5">
												<div id="task1-options" class="user-options">
													<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
													<a href="<?php echo $strPreviewUrl; ?>" class="link-primary">Preview</a> |
													<a href="javascript:void(0);" id="content_delete_<?php echo $arrContent['content']['content_id'];?>" onclick="return fnDeleteContent(this);" class="link-warning">Delete</a>|
													<a href="javascript:void(0);" id="content_status_<?php echo $arrContent['content']['content_id'];?>" onclick="return fnchanagecontentstatus(this);" class="link-primary">Change Status</a> 
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
											<th>ID #</th>
											<th class="selected">Title<span></span></th>
											
											<th>Content User</th>
											<th>Status</th>
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
							<div class="pagination pagination-large">
					<ul class="pagination">
							<?php
								echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
								echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
								echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
							?>
						</ul>
					</div>
						<!--<div class="tab-row-container">
							<div class="tab-controls-actions">
								<div class="form-group">
									<select name="bulk-actions" title="Bulk Actions">
										<option value="value1">Bulk Action1</option>
										<option value="value2">Bulk Action2</option>
										<option value="value3">Bulk Action3</option>
										<option value="value4">Bulk Action4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Apply</button>
								</div>
								<div class="form-group">
									<select name="date-filter" title="Date Filter">
										<option value="value1">Date Filter1</option>
										<option value="value2">Date Filter2</option>
										<option value="value3">Date Filter3</option>
										<option value="value4">Date Filter4</option>
									</select>
									<button type="button" class="btn btn-default btn-md">Filter</button>
								</div>
							</div>
							<div class="tab-controls-pagination">
								<button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
								<button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
								<button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
								<input type="text" value="" name="input-page-number" placeholder="1">
								<button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
								<button type="button" class="btn btn-default goto-next-active"><span></span></button>
								<button type="button" class="btn btn-default goto-end-active"><span></span></button>
							</div>-->
						</div>
	                </div>
	            </div>
	        </div>
	   
<?php /*
<div class="page-header index row">
	<h1>Content</h1>
</div>
<div>&nbsp;</div>
<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Content List</h2></div>
<div class="row index" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'content','action'=>'index'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Content title" /></div>
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
		  <th class="col-md-4" style="width:26%;">Title</th>
		  <th class="col-md-1" style="width:10%;">Status</th>
		  <!--<th class="col-md-2" style="width:14%;">Sub Pages</th>-->
		  <th class="col-md-2" style="width:13%;">Content User</th>
		  <th class="col-md-2" style="width:12%;">Created On</th>
		  <!--<th class="col-md-2">Last Modified</th>-->
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
					$strProductEditUrl = Router::url(array('controller'=>'content','action'=>'edit',$arrContent['content']['content_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'content','action'=>'preview',"5",$arrContent['content']['content_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['content']['content_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['content']['content_title']); ?></a></td>
						  <td><?php echo ucfirst($arrContent['content']['content_status']); ?></td>
						   <!--<td>
							<?php 
								if($arrContent['haschild'])
								{
									$strProductSubpagesUrl = Router::url(array('controller'=>'content','action'=>'subcontentlist',$arrContent['content']['content_id']),true);
									?>
										<a href="<?php echo $strProductSubpagesUrl;?>">View Subpages</a>
									<?php
								}
							?>
						  </td>-->
						  <td>
							<?php
								if($arrContent['content']['content_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['content']['content_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['content']['created_date'])) ?></td>
						  <!--<td><?php echo $arrContent['content']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['content']['content_id'];?>')" href="javascript:void(0);">Delete</a></td>
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
