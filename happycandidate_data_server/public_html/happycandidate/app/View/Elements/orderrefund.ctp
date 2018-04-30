<div class="tab-row-container">
	
	<div id="page-title">
		<h4>Order Refunded</h4>
	</div>
	<div class="panel panel-default hidden-xs hidden-sm vendor-orders-container">
		<div class="panel-heading vendor-orders">
			<table>
				<tr>
					<td style="padding:10px;" colspan="10"><strong>Total Sale Amount:$ <?php echo $intTotalAmount;?></strong></td>
				</tr>
			</table>
	  	</div>
		<div class="panel-heading vendor-orders">
			<table cellpadding="0" cellspacing="0" width="100%" class="privatelabelsites">
			<tr>
				<th>#ID</th>
				<th>Order ID.</th>
				<th>Title</th>
				<th>Payment Status</th>				
				<th>Cost</th>
				<th>Owner Cost</th>
				<th>&nbsp;</th>


			</tr>
			</table>
		</div>	
		<div class="panel-body vendor-orders">
							 		<table>
									<?php
			if(is_array($arrProductList) && (count($arrProductList)>0))
			{
				//echo "hi";exit;
				
				//print("<pre>");
				//print_r($arrProductList);
				
				$intContentCount = 0;
				foreach($arrProductList as $arrContent)
				{
					$intContentCount++;
					$strProductEditUrl = Router::url(array('controller'=>'vendororders','action'=>'orderdetail',$arrContent['Resourceorderdetail']['order_detail_id']),true);
					$strPreviewUrl = Router::url(array('controller'=>'vendors','action'=>'preview',"5",$arrContent['vendors']['vendor_id']),true);
					$intOrderDetailId = $arrContent['Resourceorderdetail']['order_detail_id'];
					$arrSubVendorUser = $arrContent['vendorsuser'];
					
					//echo "---".$arrContent['mainorder']['Resourceorder']['order_name'];
					?>
					<tr >
											<td>
												<?php
													echo $intContentCount;
												?>
											</td>
											<td>
												<div class="user-title">
														<a href="#str<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>" id="task1" class="username-clickable"><?php echo $arrContent['mainorder']['Resourceorder']['order_name']; ?></a>
												</div>
											</td>
											<td><?php echo stripslashes($arrContent['service']['Resources']['product_name']); ?></td>
											<td id="order_status_payment_<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>"><?php 
											if($arrContent['Resourceorderdetail']['refund_status'])
											{
												echo "Refunded";
											}
											else
											{
												echo ucfirst($arrContent['Resourceorderdetail']['payment_status']);
											}
											
											?></td>
											
											<td><?php echo "$ ".$arrContent['Resourceorderdetail']['product_unit_cost']?></td>
											
											<?php
												if($arrContent['Resourceorderdetail']['refund_status'])
												{
													
													?>
														<td><?php echo "$ 0.00";?></td>
													<?php
												}
												else
												{
													?>
														<td><?php echo "$ ".$arrContent['Resourceorderdetail']['portal_owner_cost']?></td>
													<?php
												}
											?>
											
											<!--<td><?php echo date($productdateformat,strtotime($arrContent['Resourceorderdetail']['order_confirmation_date_time'])) ?></td>-->
										</tr>
					
									<tr id="str<?php echo $arrContent['Resourceorderdetail']['order_detail_id'];?>" class="hide-str">
										<td>
										</td>
										<?php
											if(!$arrContent['Resourceorderdetail']['refund_status'])
											{
												?>
													<td colspan="8">
														<div id="task1-options" class="user-options">
															<a href="javascript:void(0);" onclick="fnConfirmRefund('<?php echo $intOrderDetailId;?> ');" class="link-primary">Cancel & Refund Order</a>
														</div>
													</td>
												<?php
											}
											else
											{
												?>
													<td colspan="8">
														<div id="task1-options" class="user-options">
															Cancelled & Refunded
														</div>
													</td>
												<?php
											}
										?>
									</tr>
					<?php
				}
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