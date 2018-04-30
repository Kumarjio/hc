<?php
	if(is_array($arrPhaseStep) && (count($arrPhaseStep)>0))
	{
		//print("<pre>");
		//print_r($arrPhaseStep);
		?>
			<div id="<?php echo $strAccord; ?>_<?php echo $strAccordId; ?>accordion">
		<?php
			foreach($arrPhaseStep as $arrPStep)
			{
				$strClassElement = "class = 'stepshead'";
				if($arrPStep['Categories']['iscompleted'])
				{
					$strClassElement = "class = 'stepshead stepcomplete'";
				}
				
				$strClass = $arrPStep['Categories']['job_process_type'];
				?>
					<h4 onclick="fnLoadJsSteps(this,'<?php echo $intPortalId; ?>')" <?php echo $strClassElement; ?> id="<?php echo $strAccord."_".$arrPStep['Categories']['content_category_id'];?>"><?php echo $arrPStep['Categories']['content_category_name'];?></h4>
					<div class="stepdetail <?php echo $strClass; ?>" id="<?php echo $strAccord; ?>detail_<?php echo $arrPStep['Categories']['content_category_id'];?>">
						<p style="margin-bottom:20px;">
							<?php
								echo htmlspecialchars_decode(stripslashes($arrPStep['Categories']['content']));
							?>
						</p>
						<?php
							?>
								<div style="margin-bottom:10px;" id="<?php echo $strAccord;?>message_<?php echo $arrPStep['Categories']['content_category_id'];?>"></div>
								<p class="tabloader" id="<?php echo $strAccord;?>loader_<?php echo $arrPStep['Categories']['content_category_id'];?>" style="display:none;"></p>
								<div id="<?php echo $strAccord;?>container_<?php echo $arrPStep['Categories']['content_category_id'];?>"></div>
							<?php
								/*if($arrPStep['Categories']['content_category_has_child'] || $arrPStep['Categories']['category_has_content'])
								{
									?>
										<!--<div id="<?php echo $strAccord;?>container_<?php echo $arrPStep['Categories']['content_category_id'];?>"></div>-->
									<?php
								}*/
						?>
					</div>
				<?php
			}
		?>
			</div>
		<?php
		
	}
?>