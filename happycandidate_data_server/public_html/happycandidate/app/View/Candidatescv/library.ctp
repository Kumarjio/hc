<div style="float:left;width:90%;padding:5%;">
	<?php
		if(isset($arrAllMaterialDetails))
		{
			if(is_array($arrAllMaterialDetails) && (count($arrAllMaterialDetails)>0))
			{
				?>
					<div id="product_container" style="float:left;width:100%;">
				<?php
				foreach($arrAllMaterialDetails as $arrAllMaterialDetailsKey=>$arrAllMaterialDetailsVal)
				{
					$strPassedPortalName = ucfirst($strPortalName);
					if($arrAllMaterialDetailsKey == $strPassedPortalName)
					{
						$arrAllMaterialDetailsKey = "Training Programs";
					}
					
					$arrAllMaterialDetailsVal = (array) $arrAllMaterialDetailsVal;
					if(is_array($arrAllMaterialDetailsVal) && (count($arrAllMaterialDetailsVal)>0))
					{
						?>
							<div style="float:left;width:28%;margin-right:1%;" id="product_block">
								<div id="product_head" style="font-size:22px;border-bottom:1px solid #44899B;"><?php echo $arrAllMaterialDetailsKey; ?></div>
						<?php
						foreach($arrAllMaterialDetailsVal as $arrProducts)
						{
							//$arrProducts = (array) $arrProducts;
							$strProductUrl = Router::url(array('controller'=>'candidates','action'=>'course',$intPortalId,$arrProducts->id),true);
							?>
								<div id="product_body" style="margin-top:10px;"><span><a href="javascript:void(0);"><?php echo $arrProducts->fullname; ?></a><span></div>
							<?php
						}
						?>
								<div id="product_foot" style="margin-top:30px;"><span>&nbsp;<span></div>
							</div>
						<?php
					}
				}
				?>
					</div>
				<?php
			}
		}
	?>
</div>