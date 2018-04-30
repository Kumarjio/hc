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
			$intStepCnt = (($intPhaseCnt-1)*5);
			foreach($arrPhaseStep as $arrPStep)
			{
				$intStepCnt++;
				$strClassElement = "class = 'stepshead'";
				if($arrPStep['Categories']['iscompleted'])
				{
					$strClassElement = "class = 'step-done-job-search'";
					$strStepNameContainerClass = "class = 'wizard-step-leftside-10'";
					$strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
				}
				else
				{
					$strClassElement = "class = 'step-inactive-job-search'";
					$strStepNameContainerClass = "class = 'wizard-step-centerside-65'";
					$strStepNameTextClass = "class = 'osb16 text-dark-grey'";
				}
				$strClass = $arrPStep['Categories']['job_process_type'];
				$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'step',$intPortalId,$arrPStep['Categories']['content_category_id'],$strAccordId),true);
				?>
					<div <?php echo $strClassElement; ?>>
						<div class="jobsearch-step-leftside-20">
							<h3>Step <?php echo $intStepCnt; ?></h3>
						</div>
						
								<?php
									if($arrPStep['Categories']['iscompleted'])
									{
										?>
											<div class="jobsearch-step-centerside-55">
												<h3>
													<a href="<?php echo $strStepUrl;?>"><s><?php echo $arrPStep['Categories']['content_category_name'];?></s></a>
												</h3>
												<p>duration 2 minutes</p>
											</div>
										<?php
									}
									else
									{
										?>
											<div class="jobsearch-step-centerside-85">
												<h3>
													<a href="<?php echo $strStepUrl;?>"><?php echo $arrPStep['Categories']['content_category_name'];?></a>
												</h3>
												<p>duration 2 minutes</p>
											</div>
										<?php
									}
								?>
								<?php
								if($arrPStep['Categories']['iscompleted'])
								{
									?>
										<div class="jobsearch-step-rightside-25">
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