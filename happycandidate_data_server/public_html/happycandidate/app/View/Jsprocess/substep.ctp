<?php
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
	$strRouter = Router::url('/',true);
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
							<span><?php echo $current_user['jprocess_completeion_per']; ?>%</span>
						</div>
					</div>
				</div>
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
											
											$strStepUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrJProcess['Categories']['content_category_id'],$intStepId,$intPhaseId),true);
											?>
												<?php
													if($arrJProcess['Categories']['step_completion_class'])
													{
														?>
															<a href="<?php echo $strStepUrl; ?>" class="list-group-item">
																<div class="sidebar-menuitem-content">
																	<p>Step <?php echo $intPhaseCnt; ?></p>
																	<h3><s><?php echo $arrJProcess['Categories']['content_category_name'];?></s></h3>
																</div>
																<div class="col-md-3 icon-complete flr"></div>
															</a>
														<?php
													}
													else
													{
														?>
															<a href="<?php echo $strStepUrl; ?>" class="list-group-item" data-toggle="collapse" data-parent="#mainMenu">
																<div class="sidebar-menuitem-content">
																	<p>Step <?php echo $intPhaseCnt; ?></p>
																	<h3>
																	<?php echo $arrJProcess['Categories']['content_category_name'];?></h3>
																	
																</div>
															</a>
														<?php
													}
												?>
												<?php
													if($arrJProcess['Categories']['content_category_has_child'])
													{
														?>
															<div class="collapse" id="phase<?php echo $arrJProcess['Categories']['content_category_id'];?>">
														<?php
															echo $this->element('phasedetailsubstepsnew',array("strAccord"=>$strAccordType,"strAccordId"=>$strAccordTypeId,"arrPhaseStep" => $arrJProcess['Categories']['Substeps']));
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
		<div class="col-md-9 wizard-right-side-container">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 wizard-step-content-container">
				<div class="row">
				<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
				<input type="hidden" name="currentstep" id="currentstep" value="<?php echo $intCatDetailId; ?>"" />
				<input type="hidden" name="completion_criteria_<?php echo $intCatDetailId; ?>" id="completion_criteria_<?php echo $intCatDetailId; ?>" value="<?php echo $strCriteria; ?>" />
				<?php
					//print("<pre>");
					//print_r($arrStepsNavigationDetails);
					if(is_array($arrCurrentLocation) && (count($arrCurrentLocation)>0))
					{
						if(isset($arrCurrentLocation['currentposition']))
						{
							?>
								<input type="hidden" name="curr_step_<?php echo $intCatDetailId; ?>" id="curr_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrCurrentLocation['currentposition']['Steps']; ?>" />
								
								<input type="hidden" name="curr_phase_<?php echo $intCatDetailId; ?>" id="curr_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrCurrentLocation['currentposition']['Phase']; ?>" />
								
								<input type="hidden" name="curr_substep_<?php echo $intCatDetailId; ?>" id="curr_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrCurrentLocation['currentposition']['substep']; ?>" />
							<?php
						}
					}
					//print("<pre>");
					//print_r($arrStepsNavigationDetails);
					//exit;
					if(is_array($arrStepsNavigationDetails) && (count($arrStepsNavigationDetails)>0))
					{
						if(isset($arrStepsNavigationDetails['nextnavigation']))
						{
							//$strNextUrl = Router::url('/',true)
							$strNextUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrStepsNavigationDetails['nextnavigation']['substep'],$arrStepsNavigationDetails['nextnavigation']['Steps'],$arrStepsNavigationDetails['nextnavigation']['Phase']),true);
							?>
								<input type="hidden" name="next_step_<?php echo $intCatDetailId; ?>" id="next_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['Steps']; ?>" />
								
								<input type="hidden" name="next_phase_<?php echo $intCatDetailId; ?>" id="next_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['Phase']; ?>" />
								
								<input type="hidden" name="next_substep_<?php echo $intCatDetailId; ?>" id="next_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['substep']; ?>" />
								
								<h4 class="osr14 text-middle-dark-grey"><a style="float:left;margin-right:10px;" onclick="fnLoadStep(this,'next')" name="nex_button_<?php echo $intCatDetailId; ?>" id="nex_button_<?php echo $intCatDetailId; ?>" href="<?php echo $strNextUrl; ?>" class="btn">Next</a></h4>
							<?php
						}
						
						if(isset($arrStepsNavigationDetails['previousnavigation']))
						{
							$strprevUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrStepsNavigationDetails['previousnavigation']['substep'],$arrStepsNavigationDetails['previousnavigation']['Steps'],$arrStepsNavigationDetails['previousnavigation']['Phase']),true);
							?>
								<input type="hidden" name="previous_step_<?php echo $intCatDetailId; ?>" id="previous_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Steps']; ?>" />
								
								<input type="hidden" name="previous_phase_<?php echo $intCatDetailId; ?>" id="previous_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Phase']; ?>" />
								
								<input type="hidden" name="previous_substep_<?php echo $intCatDetailId; ?>" id="previous_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['substep']; ?>" />
								
								<h4 class="osr14 text-middle-dark-grey"><a style="float:left;margin-right:10px;" name="prev_button_<?php echo $intCatDetailId; ?>" id="prev_button_<?php echo $intCatDetailId; ?>" href="<?php echo $strprevUrl; ?>" class="btn">Previous</a></h4>
							<?php
						}
					}
				?>
					<h4 class="osr14 text-middle-dark-grey"><a <?php echo $strCompletionevent; ?> id="<?php echo $strCompleteId; ?>" href="javascript:void(0);" style="float:left;margin-right:10px;" class="btn <?php echo $strCompleteId; ?>"><?php echo $strActionButtonText; ?></a></h4>
					
					<?php
						if($intBackStepId)
						{
							?>
								<h4 class="osr14 text-middle-dark-grey"><a style="float:left;margin-right:10px;" name="back_<?php echo $intBackStepId; ?>" id="back_button_<?php echo $intBackStepId; ?>" href="<?php echo $strCompleteBackUrl; ?>" class="btn">Back</a></h4>
							<?php
						}
					?>
				</div>
				<div class="row">&nbsp;</div>
						<?php
						//echo $intSbStepId;
						//exit;
						
						if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
						{
							
							foreach($arrJobSearchProcessPhases as $arrJProcess)
							{
								if($arrJProcess['Categories']['content_category_id'] == $intSbStepId)
								{
									//print("<pre>");
									//print_r($arrJProcess);
									//continue;
								?>
									<h4>SubStep <?php echo $arrJProcess['Categories']['job_search_order']; ?></h4>
									<h2><?php echo $arrJProcess['Categories']['content_category_name']; ?></h2>
									<p>The following topics will help you stand out from job seekers competing for the same opportunity.</p>
									<?php
									//print("<pre>");
									//print_r($arrCatContentTitles);
									
									if(is_array($arrContentListArticle) && (count($arrContentListArticle)>0))
									{
										?>
											<input type="hidden" name="content_catid" id="content_catid" value="<?php echo $intCatDetailId; ?>" />
											<input type="hidden" name="portalid" id="portalid" value="<?php echo $intPortalId; ?>" />
											<ul class="nav nav-pills">
												<?php
													if($intCatDetailId)
													{
														if(is_array($arrContentTypeList) && (count($arrContentTypeList)>0))
														{
															$intArticleTypeCnt = 0;
															foreach($arrContentTypeList as $arrContentTyId)
															{
																if($intArticleTypeCnt == 0)
																{
																	?>
																		<li class="active <?php echo $arrContentType[$arrContentTyId['content']['content_type']]."_".$intCatDetailId; ?>">
																			<a data-toggle="pill" id="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]; ?>"  style="font-size:inherit;" href="#contentpart<?php echo $arrContentTyId['content']['content_type'];?>"><?php echo ucfirst($arrContentType[$arrContentTyId['content']['content_type']]); ?></a>
																		</li>
																	<?php
																}
																else
																{
																	?>
																		<li class="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]."_".$intCatDetailId; ?>">
																			<a data-toggle="pill" id="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]; ?>"  style="font-size:inherit;" href="#contentpart<?php echo $arrContentTyId['content']['content_type'];?>"><?php echo ucfirst($arrContentType[$arrContentTyId['content']['content_type']]); ?></a>
																		</li>
																	<?php
																}
																$intArticleTypeCnt++;
															}
														}
													}
													else
													{
														?>
															<li class="active"><a data-toggle="pill" style="font-size:inherit;" href="#contentpart">Content</a></li>
														<?php
													}
												?>
											</ul>
											<div class="tab-content">
												<?php
													if($intCatDetailId)
													{
														if(is_array($arrContentTypeList) && (count($arrContentTypeList)>0))
														{
															$intFrCnt = 0;
															foreach($arrContentTypeList as $arrContentTyId)
															{
																//print("<pre>");
																//print_r($arrContentListArticle);
																//exit;
																?>
																	<div id="contentpart<?php echo $arrContentTyId['content']['content_type'];?>" class="tab-pane fade in active">
																		<p class="tabloader" style="display:none;"></p>
																		<div id="content_html<?php echo $arrContentTyId['content']['content_type'];?>_<?php echo $intCatDetailId; ?>">
																			<?php
																				if($intFrCnt == "0")
																				{
																					echo $this->element('article_list_new',array('catid'=>$intCatDetailId,'strTypeBlock'=>$arrContentType[$arrContentTyId['content']['content_type']]));
																				}
																				else
																				{
																				?>
																				<div class="library-container">
																				</div>
																				<?php
																				}
																			?>
																			
																		</div>
																	</div>
																<?php
																$intFrCnt++;
															}
														}
													}
													else
													{
														?>
															<div id="contentpart" class="tab-pane fade in active">
																<p class="tabloader" id="substep_content_loader_<?php echo $intCatDetailId; ?>" style="display:none;"></p>
																<div id="content_html">
																	<?php
																		echo $this->element('article_list_new');
																	?>
																</div>
															</div>
														<?php
													}
												?>
											</div>
											<?php
									}
								}
							}
						}
					?>
			</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 wizard-step-aside-container">
		<?php if(count($arrsubstepproducts)>0)
		{?>
					<div class="wizard-aside-inside-container">
						<div class="wizard-aside-button-container">
						<?php $productd_id = $arrsubstepproducts[0]['products']['productd_id'];
							$product_name = $arrsubstepproducts[0]['products']['product_name'];
							$product_cost = $arrsubstepproducts[0]['products']['product_cost'];
							$vendor_service_id =$arrsubstepproducts[0]['substepProducts']['vendor_service_id'];
						
						?>
							<h5><?php echo $product_name;?></h5>
							
							<p class="wizard-price">Regular Prices <s>$<?php echo $product_cost;?></s></p>
							<p class="wizard-price-today">Today $<?php echo $product_cost;?></p>
							<button class="btn btn-custom" id="add_to_cart_<?php echo $vendor_service_id."_".$intPortalId;?>"  href="javascript:void(0);" onclick="fnAddtocart(this);"><span class="osb21 text-dark-grey">Add To Cart</span></button>

							<div class="credit-cards-icons">
								<a href="#" class="icon-visa">&nbsp;</a>
								<a href="#" class="icon-paypal">&nbsp;</a>
								<a href="#" class="icon-master-card">&nbsp;</a>
								<a href="#" class="icon-discover">&nbsp;</a>
								<a href="#" class="icon-american-express">&nbsp;</a>
							</div>
						</div>
						<div class="wizard-aside-resources-container">
							<h3>Resources</h3>
							<ul class="resources-list">
								<li><a href="#">Text document [txt]</a></li>
								<li><a href="#">Template [pdf]</a></li>
								<li><a href="#">Audio file [mp3]</a></li>
							</ul>
						</div>
					</div>
					<?php 
					}
?>
				</div>
				<?php echo $this->element('phasefooter',array('strRouter'=>$strRouter)); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		var strTabSuff = '<?php echo $intCatDetailId; ?>';
		$("a[data-toggle='pill']").click(function() {
		   var strNewTab = $(this).attr('id');
		   var strLoaderEle = "substep_content_loader_"+strTabSuff;
		   $('#'+strLoaderEle).show();
		   if($('#article_list_block_'+strNewTab).length>0)
		   {
				$('#'+strLoaderEle).show();
		   }
		   else
		   {
				fnGetContentWebinars($('#portalid').val(),<?php echo $intCatDetailId; ?>,strNewTab,'<?php echo $intContentonNewtab; ?>',strLoaderEle);
		   }
	   });
	});
</script>
