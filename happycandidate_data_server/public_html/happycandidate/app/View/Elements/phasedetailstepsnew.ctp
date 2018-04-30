<?php
	if(is_array($arrPhaseStep) && (count($arrPhaseStep)>0))
	{
		//print("<pre>");
		//print_r($arrPhaseStep);
		?>
		<?php
			//print("<pre>");
			//print_r($arrPhaseStep);
			//exit;
			//echo "----".$strPhaseId;exit;
			
			if($strPhaseId == 17)
			{
				$intStepCnt = 0;
			}
			
			if($strPhaseId == 18)
			{
				$intStepCnt = 5;
			}
			
			if($strPhaseId == 19)
			{
				$intStepCnt = 10;
			}
			
			foreach($arrPhaseStep as $arrPStep)
			{
				$intStepCnt++;
				$strClassElement = "class = 'stepshead'";
				if($arrPStep['Categories']['iscompleted'])
				{
					$strClassElement = "class = 'icon-step-complete step-content-container'";
					$strStepNameContainerClass = "class = 'center65-wiz'";
					$strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
				}
				else
				{
					$strClassElement = "class = 'icon-step-inactive step-content-container'";
					$strStepNameContainerClass = "class = 'center80-wiz'";
					$strStepNameTextClass = "class = 'osb16 text-dark-grey'";
				}
				//echo "hi";exit;
				$strClass = $arrPStep['Categories']['job_process_type'];
				$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'step',$intPortalId,$arrPStep['Categories']['content_category_id'],$strPhaseId),true);
				?>
					<div <?php echo $strClassElement; ?>>
						<div class="step-content-container-left"></div>
						<div class="step-content-container-right">
							<?php
								if($arrPStep['Categories']['iscompleted'])
								{
									?>
										<a href="<?php echo $strStepUrl; ?>" class="phase-step">
											<p>Step <?php echo $intStepCnt; ?></p>
											<h3><s><?php echo $arrPStep['Categories']['content_category_name'];?></s></h3>
										</a>
									<?php
								}
								else
								{
									?>
										<a href="<?php echo $strStepUrl; ?>" class="phase-step">
											<p class="osr13 text-middle-dark-grey">Step <?php echo $intStepCnt; ?></p>
											<h3 class="osb15 text-white"><?php echo $arrPStep['Categories']['content_category_name'];?>
											</h3>
										</a>
									<?php
								}
							?>
						</div>
					</div>
				<?php
			}
		
	}
?>