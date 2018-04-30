<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-header index row">
	<h1>Courses</h1>
</div>
<div id="product_list_notification"><?php echo $strMessage;?></div>
<div class="sub-header index row"><h2>Drafted Courses</h2></div>
<div class="index row" style="width:100%;float:left;">
	<div class="col-md-12" style="width:100%;float:left;">
		<?php
			$strProductSearchUrl = Router::url(array('controller'=>'vendorcourse','action'=>'drafted'),true);
		?>
		<form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl;?>" method="post" role="form">
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;"><input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" /><input type="text" value="<?php echo $strKeywordSearch;?>" class="form-control validate[required]" name="product_keyword" id="product_keyword" placeholder="Content title" /></div>
			<div class="col-md-3 nopadding" style="float:left;width:20%;clear:none;">&nbsp;<input name="product_search" id="product_search" type="submit" value="Filter"></input></div>
		</form>
	</div>
</div>
<?php
	echo $this->element('delete_confirmation');
?>
<div class="index row" style="width:100%;float:left;">
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
					$strProductEditUrl = Router::url(array('controller'=>'vendorcourse','action'=>'edit',$arrContent['products']['productd_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendorcourse','action'=>'preview',"5",$arrContent['products']['productd_id']),true);
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
						  <td><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a href="<?php echo $strProductManageUrl;?>">Manage</a>&nbsp;|&nbsp;<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['products']['productd_id'];?>')" href="javascript:void(0);">Delete</a></td>
						</tr>
					<?php
				}
			}
		?>
	  </tbody>
	</table>
	<table class="table table-striped">
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
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#product_list").tablesorter({
			// pass the headers argument and assing a object
			headers: {
				// assign the secound column (we start counting zero)
				4: {
					// disable it by setting the property sorter to false
					sorter: false
				}
			}
		});
	}
	);
</script>

<style>
        .panel-heading th:nth-child(1), .panel-body td:nth-child(1), .panel-footer th:nth-child(1) {
            width: 10% !important;
        }
        .panel-heading th:nth-child(2), .panel-body td:nth-child(2), .panel-footer th:nth-child(2) {
            width: 25% !important;
        }
        .panel-heading th:nth-child(3), .panel-body td:nth-child(3), .panel-footer th:nth-child(3) {
            width: 15% !important;
        }
        .panel-heading th:nth-child(4), .panel-body td:nth-child(4), .panel-footer th:nth-child(4) {
            width: 22% !important;
        }
        .panel-heading th:nth-child(5), .panel-body td:nth-child(5), .panel-footer th:nth-child(5) {
            width: 28% !important;
        }
                
        .tab-row-container .panel-heading th, .tab-row-container .panel-body td, .tab-row-container .panel-footer th {
            line-height: 250% !important;
        }
        .admin-content tr {
            border: 1px solid #ccc !important;
        }
</style>