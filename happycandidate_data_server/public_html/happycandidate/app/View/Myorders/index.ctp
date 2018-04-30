<div class="wrapper">
	<div class="jop_search" id="jop_search">
	<h2 style="background:none;padding:0;">My Orders</h2>
	<table class="panel-2 margin-top-5">
		<tr>
			<th><label>Sr.No.</label></th>
			<th><label>Service Name</label></th>
			<th><label>Status</label></th>
			<th><label>Date of Placement</label></th>
		</tr>
		<tr>
			<th colspan="4">&nbsp;</th>
		</tr>
		<tbody id="tletter_rows">
			<?php
				$intForCnt = 0;
				if(is_array($arrProductList) && (count($arrProductList)>0))
				{
					foreach($arrProductList as $arrTletterDetail)
					{
						$intForCnt++;
						$strProductEditUrl = Router::url(array('controller'=>'myorders','action'=>'orderdetail',$intPortalId,$arrTletterDetail['Resourceorderdetail']['order_detail_id']),true);
						?>
							<tr id="my_order_row_<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id'];?>">
								<td><?php echo $intForCnt;?></td>
								<td id="my_order_service_<?php echo $arrTletterDetail['Resourceorderdetail']['order_detail_id'];?>">
									<a href="<?php echo $strProductEditUrl; ?>"><?php 
										echo $arrTletterDetail['service']['Resources']['product_name'];
									?></a>
								</td>
								<td><?php echo $arrTletterDetail['Resourceorderdetail']['vendor_order_state'];?></td>
								<td><?php echo date($productdateformat,strtotime($arrTletterDetail['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>
							</tr>
						<?php
					}
					?>
						<tr id="no_tl_row" style="display:none;">
							<td colspan="4"><label>There are no orders placed yet</label></td>
						</tr>
					<?php
				}
				else
				{
					
					?>
						<tr id="no_tl_row">
							<td colspan="7"><label>There are no orders placed yet</label></td>
						</tr>
					<?php
				}
			?>
		</tbody>
	</table>
	</div>
</div>