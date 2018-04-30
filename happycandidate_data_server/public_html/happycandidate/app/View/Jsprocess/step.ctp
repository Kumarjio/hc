<?php
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
	$strRouter = Router::url('/',true);
	//print("<pre>");
	//print_r($current_user);exit;
	
	
?>
<div class="container-fluid wizard-content-container">
	<div class="row">
		<div class="col-md-3 sidebar-container wizard-step-v3">
			<div class="container-fluid sidebar-main-menu-container wizard-version"> 
				<div class="sidebar-nav-meter">
					<p class="sidebar-nav-meter-heading">Profile completeness:</p>
					<div class="col-md-12 sidebar-nav-meter-indicator">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $current_user['jprocess_completeion_per']; ?>%">
								<span class="sr-only"><?php echo $current_user['jprocess_completeion_per']; ?>% Complete</span>
							 </div>
						</div>
						<div class="sidebar-nav-meter-value" style="">
							<span><?php echo round($current_user['jprocess_completeion_per']); ?>%</span>
						</div>
					</div>
				</div>
				<?php
						/*print("<pre>");
						print_r($arrJobSearchProcessPhases);
						exit;*/
						if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
						{
							?>
							<div id="mainMenu" class="sidebar-main-menu job-search-style wizard-version">
						<div class="list-group panel">
							<?php
										if($intPhaseId == 17)
										{
											$intPhaseCnt = 0;
										}
										
										if($intPhaseId == 18)
										{
											$intPhaseCnt = 5;
										}
										
										if($intPhaseId == 19)
										{
											$intPhaseCnt = 10;
										}
										
										foreach($arrJobSearchProcessPhases as $arrJProcess)
										{
											$intPhaseCnt++;
											$strCompleteClass = "";
											
											
											$strMainClass = $arrJProcess['Categories']['job_process_type'];
											
											$strPhaseUrl = Router::url(array('controller'=>'jsprocess','action'=>'phase',$intPortalId,$arrJProcess['Categories']['content_category_id']),true);
											?>
												<?php
												
											
												if($intStepId==$arrJProcess['Categories']['content_category_id'])
													{
													    $collpased= "collapsed";
													   $collapsein= "collapse in";
													}
													else
													{ 
														$collpased = "";
														 $collapsein= "collapse";
													}
													if($arrJProcess['Categories']['step_completion_class'])
													{
													
														?>
						
						
													<a href="#demo<?php echo $arrJProcess['Categories']['content_category_id'];?>" class="list-group-item <?php echo $collpased?>" data-toggle="collapse" data-parent="#mainMenu" id="step<?php echo $arrJProcess['Categories']['content_category_id'];?>">
																<div class="sidebar-menuitem-content">
																	<p>Step <?php echo $intPhaseCnt; ?></p>
																	<h3><s><?php echo $arrJProcess['Categories']['content_category_name'];?></s></h3>
																</div>
																<div class="col-md-3 icon-complete"></div>
															</a>
													<?php 
													}													
													else
													{
														?>
															<a href="#demo<?php echo $arrJProcess['Categories']['content_category_id'];?>" class="list-group-item <?php echo $collpased?>" data-toggle="collapse" data-parent="#mainMenu" id="step<?php echo $arrJProcess['Categories']['content_category_id'];?>">
																<div class="sidebar-menuitem-content">
																	<p>Step <?php echo $intPhaseCnt; ?></p>
																	<h3 class="menuitem-inprocess">
																		<?php echo $arrJProcess['Categories']['content_category_name'];?>
																	</h3>
																</div>
															</a>
														<?php
													}
															?>
												<?php
													if($arrJProcess['Categories']['content_category_has_child'])
													{
														?>
															<div class="<?php echo $collapsein;?>" id="demo<?php echo $arrJProcess['Categories']['content_category_id'];?>">
														<?php
															echo $this->element('phasedetailsubstepsnew',array("strAccord"=>$strAccordType,"strAccordId"=>$strAccordTypeId,"arrPhaseStep" => $arrJProcess['Categories']['Substeps']));
														?>
														</div>
														<?php
														}
												
												
										}
										?>
														</div>
								</div>
							<?php
						}
					?>
											
					
						</div>
					</div>
			
				
		
		<div class="col-md-9 wizard-right-side-container wizard-step-v3">
			<?php
				//print("<pre>");
				//print_r($arrJobSearchProcessPhases);
				//exit;
				if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
				{
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 wizard-step-content-container wizard-step-v3" id="substepcontentcontainer">
					<?php
					if($intPhaseId == 17)
					{
						$intPhaseCnt = 0;
					}
					
					if($intPhaseId == 18)
					{
						$intPhaseCnt = 5;
					}
					
					if($intPhaseId == 19)
					{
						$intPhaseCnt = 10;
					}
					foreach($arrJobSearchProcessPhases as $arrJProcess)
					{
						$intFrCnt++;
						if($arrJProcess['Categories']['content_category_id'] == $intStepId)
						{
								//echo "hi";exit;
								?>
									<div class="page-header">
										<h2>Step <?php echo $intFrCnt; ?>: <?php echo $arrJProcess['Categories']['content_category_name']; ?></h2>
										<p><?php echo strip_tags(htmlspecialchars_decode($arrJProcess['Categories']['content'])); ?></p>
									</div>
								<?php
								
								if($arrJProcess['Categories']['content_category_has_child'])
								{
									?>
										<div id="<?php echo strtolower($arrJProcess['Categories']['job_process_type']);?>container_<?php echo $arrJProcess['Categories']['content_category_id'];?>">
											<?php
												$strAccordType = "steps";
												$strAccordTypeId = $arrJProcess['Categories']['content_category_id'];
												$strAccordTypeTitle = $arrJProcess['Categories']['content_category_name'];
												echo $this->element('phasesubstepsnewphasepage',array("strAccord"=>$strAccordType,"strAccordId"=>$strAccordTypeId,"strAccordTitle"=>$strAccordTypeTitle,"arrPhaseStep" => $arrJProcess['Categories']['Substeps']));
											?>
										</div>
									<?php
								}
							?>
							<?php
						}
						else
						{
							continue;
						}
					}
					
				?></div>
				<?php
				}
			?>
		
		</div>
	</div>
	</div>
	<?php echo $this->element('phasefooter',array('strRouter'=>$strRouter)); ?>
<script type="text/javascript">
	$(document).ready(function () {

		var header_height = $('.top-menu-container').height();
		var footer_height = $('footer').height();
		$('footer').css("position", "fixed");
		$('footer').css("bottom", 0);
		$('footer').css("width", "100%");

		var current_window_height = (($( window ).height() - header_height) - footer_height);
		//alert(header_height);
		//alert(current_window_height);
		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-right-side-container.wizard-step-v3').css("top", header_height + "px");
		
		//$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-right-side-container.wizard-step-v3').css("top","60px");

		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-step-content-container.wizard-step-v3').css("height", current_window_height + "px");
		
		//$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-step-content-container.wizard-step-v3').css("height"," 480 px");
	});
</script>

<style>
    .sidebar-container {
      background-color: #f9f9f9 !important;
    }
</style>
