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
				//echo "hello";
				
				$intStepCnt++;
				$strClassElement = "class = 'stepshead'";
				if($arrPStep['Categories']['iscompleted'])
				{
					$strClassElement = "class = 'step-content-container'";
					$strStepNameContainerClass = "class = 'center65-wiz'";
					$strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
				}
				else
				{
					$strClassElement = "class = 'step-content-container'";
					$strStepNameContainerClass = "class = 'center80-wiz'";
					$strStepNameTextClass = "class = 'osb16 text-dark-grey'";
				}
				
				$strClass = $arrPStep['Categories']['job_process_type'];
				$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrPStep['Categories']['content_category_id'],$arrPStep['Categories']['content_category_parent_id'],$intPhaseId),true);
				?>
				
					<div <?php echo $strClassElement; ?>>
						<div class="step-content-container-left"></div>
						<div class="step-content-container-right">
							<?php
								if($arrPStep['Categories']['iscompleted'])
								{
									?>
										<a href="javascript:void(0);" class="phase-step" id="phase-step<?php echo $arrPStep['Categories']['content_category_id'];?>" onclick="return fnGetSubstepDetail(<?php echo $intPortalId;?>,<?php echo $arrPStep['Categories']['content_category_id'];?>,<?php echo $arrPStep['Categories']['content_category_parent_id'];?>,<?php echo $intPhaseId;?>);">
											<p>Sub Step <?php echo $arrPStep['Categories']['job_search_order']; ?></p>
											<h3>
												<s><?php echo $arrPStep['Categories']['content_category_name'];?></s>
											</h3>
										</a>
									<?php
								}
								else
								{
									?>
										<a href="javascript:void(0);" class="phase-step"  id="phase-step<?php echo $arrPStep['Categories']['content_category_id'];?>" onclick="return fnGetSubstepDetail(<?php echo $intPortalId;?>,<?php echo $arrPStep['Categories']['content_category_id'];?>,<?php echo $arrPStep['Categories']['content_category_parent_id'];?>,<?php echo $intPhaseId;?>);">
											<p>Sub Step <?php echo $arrPStep['Categories']['job_search_order']; ?></p>
											<h3>
												<?php echo $arrPStep['Categories']['content_category_name'];?>
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