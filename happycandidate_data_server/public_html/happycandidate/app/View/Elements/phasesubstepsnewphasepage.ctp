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
			$intStepCnt = 0;
			foreach($arrPhaseStep as $arrPStep)
			{
				$intStepCnt++;
				$strClassElement = "class = 'stepshead'";
				if($arrPStep['Categories']['iscompleted'])
				{
					$strClassElement = 'class="wizard-step-done"';
					$strStepNameContainerClass = "class = 'center65-wiz'";
					$strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
					$strStepDetailClass = 'class="wizard-step-centerside-65"';
				}
				else
				{
					$strClassElement = 'class="wizard-step-inactive"';
					$strStepNameContainerClass = "class = 'center80-wiz'";
					$strStepNameTextClass = "class = 'osb16 text-dark-grey'";
					$strStepDetailClass = 'class="wizard-step-centerside-80"';
				}
				
				$strClass = $arrPStep['Categories']['job_process_type'];
				$strSbStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrPStep['Categories']['content_category_id'],$intStepId,$intPhaseId),true);
				?>					
					<div <?php echo $strClassElement; ?>> <!-- step-done -->
						<div class="wizard-step-leftside-10">
							<h3>SubStep <?php echo $arrPStep['Categories']['job_search_order']; ?></h3>
						</div>
						<div <?php echo $strStepDetailClass; ?>>
							<a href="javascript:void(0);" onclick="return fnGetSubstepDetail(<?php echo $intPortalId;?>,<?php echo $arrPStep['Categories']['content_category_id'];?>,<?php echo $intStepId;?>,<?php echo $intPhaseId;?>)"><h3>
								<?php
									if($arrPStep['Categories']['iscompleted'])
									{
										?>
											<s><?php echo $arrPStep['Categories']['content_category_name'];?></s>
										<?php
									}
									else
									{
										echo $arrPStep['Categories']['content_category_name'];
									}
								?>
							</h3></a>
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