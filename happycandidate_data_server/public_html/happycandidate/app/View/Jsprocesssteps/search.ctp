<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="tab-header">
							<h3>Steps List</h3>
						</div>
						
<div class="tab-row-container ">
						
							<div class="tab-search">
							<?php
			$strProductSearchUrl = Router::url(array('controller'=>'jsprocesssteps','action'=>'index'),true);
		?>
							<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>/" method="post" role="form">
								<input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
								<input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
								<button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
								</form>
							</div>
						</div>
						
<?php
	echo $this->element('delete_confirmation');
?>
<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading admin-content">
									<table>
										<tr>
											<th>ID</th>
											<th class="selected">Title<span></span></th>
											<th>Content User</th>
											<th>Created On</th>
											<th>Action</th>
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
					$strProductEditUrl = Router::url(array('controller'=>'jsprocesssteps','action'=>'edit',$arrContent['Categories']['content_category_id']),true);
					?>
						<tr id="product_list_<?php echo $arrContent['Categories']['content_category_id'];?>">
						  <td><?php echo $intContentCount; ?></td>
						  <td><div class="user-title"><a href="<?php echo $strProductEditUrl; ?>"><?php echo $arrContent['Categories']['content_category_name']; ?></a></div></td>
						  <td>
							<?php 
								if($arrContent['Categories']['content_cat_for_user'] == "3")
								{
									echo "Job Seeker";
								}
								else
								{
									if($arrContent['Categories']['content_cat_for_user'] == "2")
									{
										echo "Portal Owner";
									}
								}
							?>
						  </td>
						  <td><?php echo date($productdateformat,strtotime($arrContent['Categories']['content_cat_created_date'])) ?></td>
						  <!--<td><?php echo $arrContent['content']['modified_date']; ?></td>-->
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a></td>
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
											<th>ID</th>
											<th class="selected">Title<span></span></th>
											<th>Content User</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</table>
							 	</div>
							</div>

					</div>
						
						<div class="tab-row-container">
							<div class="tab-controls-actions">
								
								
							</div>
							<div class="tab-controls-pagination">
								<div class="pagination pagination-large">
									<ul class="pagination">
										<?php
											echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
											echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
											echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
										?>
									</ul>
								</div>
							</div>
						</div>
	                </div>
	            </div>
	        </div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the secound column (we start counting zero)
				2: {
					// disable it by setting the property sorter to false
					sorter: false
				},
				// assign the third column (we start counting zero)
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				}
				
			}
		});
	}
	);
</script>