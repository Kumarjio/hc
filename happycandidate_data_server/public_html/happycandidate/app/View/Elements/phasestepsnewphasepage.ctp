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
					$strClassElement = "class = 'wizard-step-done'";
					$strStepNameContainerClass = "class = 'center65-wiz'";
					$strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
				}
				else
				{
					$strClassElement = "class = 'wizard-step-inactive'";
					$strStepNameContainerClass = "class = 'center80-wiz'";
					$strStepNameTextClass = "class = 'osb16 text-dark-grey'";
				}
				
				$strClass = $arrPStep['Categories']['job_process_type'];
				$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'step',$intPortalId,$arrPStep['Categories']['content_category_id'],$strPhaseId),true);
				?>					
					<div <?php echo $strClassElement; ?>>
						<div class="wizard-step-leftside-10">
							<h3>
								Step <?php echo $intStepCnt; ?>
							</h3>
						</div>
						<div class="wizard-step-centerside-65">
							<?php
								if($arrPStep['Categories']['iscompleted'])
								{
									?>
										<h3><a href="<?php echo $strStepUrl;?>"><s><?php echo $arrPStep['Categories']['content_category_name'];?></s></a></h3>
									<?php
								}
								else
								{
									?>
										<h3><a href="<?php echo $strStepUrl;?>"><?php echo $arrPStep['Categories']['content_category_name'];?></a></h3>
									<?php
								}
							?>
							
							<p>duration 2 minutes</p>
						</div>
						<?php
							if($arrPStep['Categories']['iscompleted'])
							{
								?>
									<div class="wizard-step-rightside-25">
										<p class="icon-step-completed"><span>COMPLETED</span></p>
									</div>
								<?php
							}
						?>
					</div>
				<?php
			}
		
	}
?>