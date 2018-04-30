<h2 style="background:none;">Order Information</h2>
<?php
	$arrProducts = $arrContentDetail;
	//print("<pre>");
	//print_r($arrProducts);
	if(is_array($arrProducts[0]['order_detail']) && (count($arrProducts[0]['order_detail'])>0))
	{
		$intTotal = "";
		$strCartProductStrngs = "<div style='float:left;width:100%;'>&nbsp;</div><table width='100%'><tr><td> Order Id : ".$arrProducts[0]['Resourceorder']['order_name']." <input type='hidden' name='order_id' id='order_id' value='".$arrProducts[0]['Resourceorder']['resource_order_id']."' /></td></tr><tr><tr><td>&nbsp;</td></tr><tr><td>";
		$strCartProductStrngs .= "<table width='100%'><thead><tr><th align='left'><b>Product Name</b></th><th align='left'><b>Vendor Name</b></th><th align='left'><b>Unit Price</b></th><th align='left'><b>Qty</b></th><th align='left'><b>Amount</b></th><th align='left'><b>Action</b></th></tr><tr><th colspan='4'>&nbsp;</th></tr></thead><tbody>";
		$intForCnt = 0;
		foreach($arrProducts[0]['order_detail'] as $arrProduct)
		{
			$strCartProductStrngs .= "<tr id='".$arrProduct['resource_order_detail']['order_id']."_".$arrProduct['resource_order_detail']['order_detail_id']."'><td>".$arrProduct['resource_order_detail']['product_name']."</td><td>".$arrProduct['resource_order_detail']['vendor_name']."</td><td>".$arrProduct['resource_order_detail']['product_unit_cost']."</td><td>1</td><td>&nbsp;&nbsp;&nbsp;".($arrProduct['resource_order_detail']['product_unit_cost'] * 1)."</td><td><a href='javascript:void(0);' id='remove_".$arrProduct['resource_order_detail']['order_id']."_".$arrProduct['resource_order_detail']['order_detail_id']."_".$intPortalId."' onclick='fnRemoveItemFromOrder(this)'>Remove</a></td></tr>";
			$intTotal = $intTotal + ($arrProduct['resource_order_detail']['product_unit_cost'] * 1);
			$intForCnt++;
		}
		$strCartProductStrngs .= "<tr><td colspan='4'>&nbsp;</td></tr><tr><td colspan='4'>Total</td><td>$&nbsp;".$intTotal."<input type='hidden' name='total_amount' id='total_amount' value='".$intTotal."' /></td></tr>";
		$strCartProductStrngs .= "</tbody></table></td></tr></table>";
		
		if($strCartProductStrngs)
		{
			echo $strCartProductStrngs;
		}
	}

?>