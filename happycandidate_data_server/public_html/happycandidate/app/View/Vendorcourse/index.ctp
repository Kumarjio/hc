<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1>Courses</h1>
				 <!-- <p>Sed cursus id libero molestie ullamcorper. Nullam cursus mauris in enim interdum varius. Integer ex risus, dignissim nec placerat ac, mattis vitae augue.</p>-->
				 <div class="tab-row-container">
					<div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
						<div class="panel-heading vendor-orders">
							<table>
								<tr>
								
									<th>Order #</th>
									<th>Name</th>
									<th>Type<span></span></th>
									<th>Created On</th>
									<th>Action</th>
								</tr>
							</table>
						</div>
						<div class="panel-body vendor-orders">
							<table>
								<?php
									if(is_array($arrProductList) && (count($arrProductList)>0))
									{
										$intContentCount = 0;
										foreach($arrProductList as $arrContent)
										{
											$intContentCount++;
											$strProductEditUrl = Router::url(array('controller'=>'vendorcourse','action'=>'edit',$arrContent['products']['productd_id']),true);
											$strPreviewUrl = Router::url(array('controller'=>'vendorcourse','action'=>'preview',"5",$arrContent['products']['productd_id']),true);
											$strProductManageUrl = Router::url(array('controller'=>'vendorcourse','action'=>'manage',$arrContent['products']['productd_id']),true);
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
												<tr id="str<?php echo $arrContent['products']['productd_id'];?>" class="hide-str">
												<td>
												</td>
														<td colspan="4">
															<div id="task1-options" class="user-options">
																<a href="<?php echo $strPreviewUrl; ?>" class="link-primary">Preview</a> |
																<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a>  |
																<a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Manage</a>  |
																<a onclick="fnConfirmInquiryDelete('<?php echo $arrContent['products']['productd_id'];?>')"  href="javascript:void(0);" class="link-primary">Delete</a>
															</div>
														</td>
													</tr>
											<?php
										}
									}
									else
									{
										
									}
								?>
							</table>
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
				 </div>
			</div>
		</div>
	</div>
</div>

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