<?php
	//print("<pre>");
	//print_r($arrCandidateCDetail);
	$strFontFamily = "font-family:".$strFont.";font-size:".$strFontSize;
	$strHeadFont = $strFontSize + 2;
	//print("<pre>");
	//print_r($arrCvDetail);
	$strImageUrl = Router::url('/',true)."images/search-item.png";
	$arrMainOrder = $arrCvDetail[0]['mainorder'];
	
				//exit;
	
?>
<div style="float:left;width:100%;<?php echo $strFontFamily; ?>" class="container">
	<div id="headcontainer" style="float:left;width:100%;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:50%;">
			<div style="float:left;width:100%">
				<img style="width:50px" alt="logo description" src="http://www.rothrsolutions.com/happycandidate/images/search-item.png">
			</div>
			<div style="float:left;width:100%;font-weight:bold;">
				<?php echo $arrCandDetail['0']['Portal']['career_portal_name']; ?>
			</div>
		</div>
		<div id="contactdetailcontainer" style="float:right;width:50%;">
			<div style="font-weight:bold;font-size:20px;float:left;">Invoice</div>
			<div style="float:right;width:100%;">
				<div style="float:left;width:48%;border:1px solid;">Date</div>
				<div style="float:left;width:48%;border:1px solid;">Invoice #</div>
				<div style="float:left;width:48%;border:1px solid;"><?php echo date("F d, Y",strtotime($arrCvDetail[0]['Resourceorderdetail']['order_detail_creation_date_time']));?></div>
				<div style="float:left;width:48%;border:1px solid;"><?php echo $arrMainOrder[0]['Resourceorder']['order_name'];?></div>
			</div>
		</div>
	</div>
	
	<div id="headcontainer" style="float:left;width:100%;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:50%;">
			<div style="float:left;width:100%">
				To
			</div>
			<div style="float:left;width:100%">
				<div style="float:left;width:100%;"><?php echo $arrCandidateECDetail['0']['Employee']['fname']." ".$arrCandidateECDetail['0']['Employee']['sname']; ?></div>
				<?php
					if($arrCandidateECDetail['0']['Employee']['address'])
					{
						?>
							<div style="float:left;width:100%;"><?php echo $arrCandidateECDetail['0']['Employee']['address']; ?></div>
						<?php
					}
				?>
				<?php
					if($arrCandidateECDetail['0']['Employee']['address2'])
					{
						?>
							<div style="float:left;width:100%;"><?php echo $arrCandidateECDetail['0']['Employee']['address2']; ?></div>
						<?php
					}
				?>
				<?php
				$arrEEmPh = array();
				
				if($arrCandidateECDetail[0]['Employee']['city'])
				{
					$arrEEmPh[] = $arrCandidateECDetail[0]['Employee']['city'];
				}
				if($arrCandidateECDetail[0]['Employee']['state_province'])
				{
					$arrEEmPh[] = $arrCandidateECDetail[0]['Employee']['state_province'];
				}
				
				if($arrCandidateECDetail[0]['Employee']['post_code'])
				{
					$arrEEmPh[] = $arrCandidateECDetail[0]['Employee']['post_code'];
				}
				
				if(is_array($arrEEmPh) && (count($arrEEmPh)>0))
				{
					$strEEmPh = implode(", ",$arrEEmPh);
				}
				
				if($strEEmPh)
				{
					?>
						<div style="float:left;width:100%;"><?php echo $strEEmPh; ?></div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	
	<div id="headcontainer" style="float:left;width:100%;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:100%;font-weight:bold;">
			<div style="float:left;width:10%;">Sr.No.</div>
			<div style="float:left;width:50%;">Product Name</div>
			<div style="float:left;width:10%;">Cost</div>
			<div style="float:left;width:10%;">Total</div>
		</div>
		
		<?php
			if(is_array($arrCvDetail) && (count($arrCvDetail)>0))
			{
				$intFrCnt = 1;
				$intTotalCost = 0;
				foreach($arrCvDetail as $arrCv)
				{
					$intTotalCost = $intTotalCost + $arrCv['Resourceorderdetail']['product_unit_cost'];
					
					?>
						<div id="namecontainer" style="float:left;width:100%;">
							<div style="float:left;width:10%;"><?php echo $intFrCnt;?></div>
							<div style="float:left;width:50%;"><?php echo $arrCv['Resourceorderdetail']['product_name']; ?></div>
							<div style="float:left;width:10%;"><?php echo $arrCv['Resourceorderdetail']['product_unit_cost']; ?></div>
							<div style="float:left;width:10%;"><?php echo $arrCv['Resourceorderdetail']['product_unit_cost']; ?></div>
						</div>
					<?php
					$intFrCnt++;
				}
			}
		?>
		
		<div id="namecontainer" style="float:left;width:100%;">
			<div style="float:left;width:10%;">&nbsp;</div>
			<div style="float:left;width:50%;">&nbsp;</div>
			<div style="float:left;width:10%;font-weight:bold;">Total: $</div>
			<div style="float:left;width:10%;"><?php echo number_format((float)$intTotalCost, 2, '.', ''); ?></div>
		</div>
	</div>
	
	<div id="headcontainer" style="float:left;width:100%;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:100%;font-weight:bold;">
			<div style="float:left;width:30%;">Payment Mode:</div>
			<div style="float:left;width:10%;">Credit Card</div>
		</div>
	</div>
	
	<div id="headcontainer" style="float:left;width:100%;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:100%;font-weight:bold;">
			<div style="float:left;width:30%;">Payment Status:</div>
			<div style="float:left;width:10%;"><?php 
			$strPayStat = $arrCvDetail[0]['Resourceorderdetail']['payment_status'];
			if($strPayStat == "captured")
			{
				echo  "Paid";
			}
			else
			{
				echo "Pending";
			}
			?>
			</div>
		</div>
	</div>
</div>