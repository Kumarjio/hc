<?php
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
	$strRouter = Router::url('/',true);
	//print("<pre>");
	//print_r($current_user);exit;
	
	
?>
<div class="container-fluid wizard-content-container">
	<div class="row">
		<div class="col-md-3 sidebar-container">
			<nav class="navbar navbar-transparent sidebar-nav">
				<div class="sidebar-nav-meter">
					<p class="sidebar-nav-meter-heading">Profile completeness:</p>
					<div class="col-md-12 sidebar-nav-meter-indicator">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $current_user['jprocess_completeion_per']; ?>%">
								<span class="sr-only"><?php echo $current_user['jprocess_completeion_per']; ?>% Complete</span>
							 </div>
						</div>
						<div class="sidebar-nav-meter-value" style="">
							<span class="osr13 text-middle-dark-grey"><?php echo $current_user['jprocess_completeion_per']; ?>%</span>
						</div>
					</div>
				</div>
				<?php
				//print("<pre>");
				//print_r($arrJobSearchProcessPhases);
				//exit;
				?>
				<div class="container-fluid sidebar-main-menu-container"> 
					<?php
						//print("<pre>");
						//print_r($arrJobSearchProcessPhases);
						//exit;
						if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
						{
							?>
								<div id="mainMenu" class="sidebar-main-menu">
									<div class="list-group panel">
									<?php
										$intPhaseCnt = 0;
										foreach($arrJobSearchProcessPhases as $arrJProcess)
										{
											//print("<pre>");
											//print_r($arrJProcess);
											//continue;
											
											$intPhaseCnt++;
											$strCompleteClass = "";
											
											
											$strMainClass = $arrJProcess['Categories']['job_process_type'];
											
											$strPhaseUrl = Router::url(array('controller'=>'jsprocess','action'=>'phase',$intPortalId,$arrJProcess['Categories']['content_category_id']),true);
											?>
												<a href="#phase<?php echo $arrJProcess['Categories']['content_category_id'];?>" class="list-group-item" data-toggle="collapse" data-parent="#mainMenu">
													<div class="sidebar-menuitem-content">
														<p>Phase <?php echo $intPhaseCnt; ?></p>
														
														<?php
															if($arrJProcess['Categories']['step_completion_class'])
															{
																?>
																	<h3><s><?php echo $arrJProcess['Categories']['content_category_name'];?></s></h3>
																<?php
															}
															else
															{
																?>
																	<h3 class="menuitem-inprocess"><?php echo $arrJProcess['Categories']['content_category_name'];?></h3>
																<?php
															}
														?>
														
													</div>
													<?php
														if($arrJProcess['Categories']['step_completion_class'])
														{
															?>
																<div class="col-md-3 icon-complete"></div>
															<?php
														}
													?>
												</a>
												<?php
													if($arrJProcess['Categories']['content_category_has_child'])
													{
														?>
															<div class="collapse" id="phase<?php echo $arrJProcess['Categories']['content_category_id'];?>">
														<?php
															
															//echo "--".$strPhaseId;
															//exit;
															echo $this->element('phasedetailstepsnew',array("strAccord"=>$strAccordType,"strAccordId"=>$strAccordTypeId,"strPhaseId"=>$arrJProcess['Categories']['content_category_id'],"arrPhaseStep" => $arrJProcess['Categories']['Steps']));
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
							<?php
						}
					?>
				</div>
			</nav>
		</div>
		<div class="ol-sm-12 col-md-9 wizard-phase-steps-list">
			<?php
				if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
				{
					?>
						<div class="page-header">
							<h2>Phase 3</h2>
							<p>The following topics will help you stand out from job seekers competing for the same opportunity.</p>
						</div>
					<?php
					foreach($arrJobSearchProcessPhases as $arrJProcess)
					{
						if($arrJProcess['Categories']['content_category_id'] == $intPhaseId)
						{
								if($arrJProcess['Categories']['content_category_has_child'])
								{
									?>
											<?php
												$strAccordType = "steps";
												$strAccordTypeId = $arrJProcess['Categories']['content_category_id'];
												echo $this->element('phasestepsnewphasepage',array("strAccord"=>$strAccordType,"strPhaseId"=>$arrJProcess['Categories']['content_category_id'],"strAccordId"=>$strAccordTypeId,"arrPhaseStep" => $arrJProcess['Categories']['Steps']));
											?>
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
				}
			?>
			<footer>
				<div class="left-nav">
					<a href="#">Privacy Policy</a>
					<a href="#">Contact Us</a>
				</div>
				<div class="right-nav">
					<p>&copy; 2015 HR Search, Inc.</p>
					<img src="<?php echo $strRouter;?>images/app-store.png" alt="img description" />
					<img src="<?php echo $strRouter;?>images/google-play.png" alt="img description" />
				</div>
			</footer>
		</div>
	</div>
	</div>