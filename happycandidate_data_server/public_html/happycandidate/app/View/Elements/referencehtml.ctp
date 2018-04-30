<?php
	//print("<pre>");
	//print_r($arrCandidateCDetail);
	$strFontFamily = "font-family:".$strFont.";font-size:".$strFontSize;
	$strHeadFont = $strFontSize + 2;
?>
<div style="float:left;width:100%;<?php echo $strFontFamily; ?>" class="container">
	<div id="headcontainer" style="float:left;width:100%;text-align:center;margin-bottom:20px;">
		<div id="namecontainer" style="float:left;width:100%;">
			<span style="font-weight:bold;font-size:<?php echo $strHeadFont; ?>px;"><?php echo $arrCandDetail[0]['Candidate']['candidate_first_name']." ".$arrCandDetail[0]['Candidate']['candidate_last_name']; ?></span>
		</div>
		<div id="contactdetailcontainer" style="float:left;width:100%;">
			<?php
				if($arrCandidateCDetail[0]['Employee']['address'])
				{
					$arrAddress[] = $arrCandidateCDetail[0]['Employee']['address'];
				}
				
				
				
				
				if($arrCandidateCDetail[0]['Employee']['city'])
				{
					$arrAddress[] = $arrCandidateCDetail[0]['Employee']['city'];
				}
				if($arrCandidateCDetail[0]['Employee']['state_province'])
				{
					$arrAddress[] = $arrCandidateCDetail[0]['Employee']['state_province'];
				}
				
				/*if(is_array($arrCountry) && (count($arrCountry)>0))
				{
					$strAddressCountry = implode(", ",$arrCountry);
				}
				
				if($strAddressCountry)
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:100%"><?php 
							echo $strAddressCountry; 
							if($arrCandidateCDetail[0]['Employee']['post_code'])
							{
								echo " ".$arrCandidateCDetail[0]['Employee']['post_code'];
							}
						?></span></div>
					<?php
				}*/
				
				if(is_array($arrAddress) && (count($arrAddress)>0))
				{
					$strAddress = implode(", ",$arrAddress);
				}
				if($strAddress)
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:100%"><?php echo $strAddress; ?></span></div>
					<?php
				}
				
				$arrEmPh = array();
				
				if($arrCandidateCDetail[0]['Employee']['phone_number'])
				{
					$arrEmPh[] = "Phone: ".$arrCandidateCDetail[0]['Employee']['phone_number'];
					
					?>
						<!--<div style="float:left;width:100%;"><span style="float:left;width:100%"> Phone: <?php echo $arrCandidateCDetail[0]['Employee']['phone_number']; ?></span></div>-->
					<?php
				}
				
				if($arrCandidateCDetail[0]['Employee']['email_address'])
				{
					$arrEmPh[] = "Email: ".$arrCandidateCDetail[0]['Employee']['email_address'];
					?>
						<!--<div style="float:left;width:100%;"><span style="float:left;width:100%">" - Email" <?php echo $arrCandidateCDetail[0]['Employee']['email_address']; ?></span></div>-->
					<?php
				}
				
				if(is_array($arrEmPh) && (count($arrEmPh)>0))
				{
					$strEmPh = implode(" - ",$arrEmPh);
				}
				
				if($strEmPh)
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:100%"><?php echo $strEmPh; ?></span></div>
					<?php
				}
				
			?>
		</div>
	</div>
	<div id="separator" style="float:left;width:100%;margin-bottom:20px;">
		<hr style="margin-top:2px;border:2px solid;"/>
	</div>
	
	<?php
		if(is_array($arrCvDetail) && (count($arrCvDetail)>0))
		{
			
			?>
				<?php
					foreach($arrCvDetail as $arrCVDet)
					{
						?>
						<div style="float:left;width:100%;margin-bottom:20px;">
						<?php
							$arrRefNameTit = array();
							if($arrCVDet['CandidateReferences']['reference_name'])
							{
								$arrRefNameTit[] = $arrCVDet['CandidateReferences']['reference_name'];
							}
							
							if($arrCVDet['CandidateReferences']['reference_job_title'])
							{
								$arrRefNameTit[] = $arrCVDet['CandidateReferences']['reference_job_title'];
							}
							
							if(is_array($arrRefNameTit) && (count($arrRefNameTit)>0))
							{
								$strRefNameTit = implode(" - ",$arrRefNameTit);
							}
							
							if($strRefNameTit)
							{
								?>
									<div style="float:left;width:48%;margin-left:42%"><span style="float:left;width:100%"><?php echo $strRefNameTit; ?></span></div>
								<?php
							}
							
							if($arrCVDet['CandidateReferences']['reference_company_name'])
							{
								?>
									<div style="float:left;width:48%;margin-left:42%"><span style="float:left;width:100%"><?php echo $arrCVDet['CandidateReferences']['reference_company_name']; ?></span></div>
								<?php
							}
							
							if($arrCVDet['CandidateReferences']['address'])
							{
								$arrRefAddress[] = $arrCVDet['CandidateReferences']['address'];
							}
							
							
							if(is_array($arrRefAddress) && (count($arrRefAddress)>0))
							{
								$strRefAddress = implode(", ",$arrRefAddress);
							}
							if($strRefAddress)
							{
								?>
									<div style="float:left;width:48%;margin-left:42%;"><span style="float:left;width:100%"><?php echo $strRefAddress; ?></span></div>
								<?php
							}
							

							if($arrCVDet['CandidateReferences']['city'])
							{
								$arrRefCountry[] = $arrCVDet['CandidateReferences']['city'];
							}
							
							if($arrCVDet['CandidateReferences']['state'])
							{
								$arrRefCountry[] = $arrCVDet['CandidateReferences']['state'];
							}
							
							
							if(is_array($arrRefCountry) && (count($arrRefCountry)>0))
							{
								$strRefCountry = implode(", ",$arrRefCountry);
							}
							
							if($arrCVDet['CandidateReferences']['zipcode'])
							{
								$strRefCountry = $strRefCountry. " ".$arrCVDet['CandidateReferences']['zipcode'];
							}
							
							if($strRefCountry)
							{
								?>
									<div style="float:left;width:48%;margin-left:42%;"><span style="float:left;width:100%"><?php echo $strRefCountry; ?></span></div>
								<?php
							}


							if($arrCVDet['CandidateReferences']['reference_tele_number'])
							{
								?>
									<div style="float:left;width:48%;margin-left:42%;"><span style="float:left;width:100%"> <?php echo $arrCVDet['CandidateReferences']['reference_tele_number']; ?></span></div>
								<?php
							}
						?>
						</div>
						<?php
						
					}
				?>
			<?php
		}
	?>
		
		
	</div>
</div>