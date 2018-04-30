<?php
	$strVendorServiceUrl = Router::url(array('controller'=>'vendorservicehoster','action'=>'index',$intPortalId,"interviewbest"),true);
	$strRouter = Router::url('/',true);
?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 wizard-step-content-container wizard-step-v3" id="dooms">
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
								
								<h4 class="osr14 text-middle-dark-grey"><a style="float:left;margin-right:10px;"  name="nex_button_<?php echo $intCatDetailId; ?>" id="nex_button_<?php echo $intCatDetailId; ?>" href="javascript:void(0);" onclick="return fnGetSubstepNext(<?php echo $intPortalId;?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['substep'];?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['Steps'];?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['Phase'];?>)" class="btn btn-primary">Next</a></h4>
							<?php
						}
						
						if(isset($arrStepsNavigationDetails['previousnavigation']))
						{
							$strprevUrl = Router::url(array('controller'=>'jsprocess','action'=>'substep',$intPortalId,$arrStepsNavigationDetails['previousnavigation']['substep'],$arrStepsNavigationDetails['previousnavigation']['Steps'],$arrStepsNavigationDetails['previousnavigation']['Phase']),true);
							?>
								<input type="hidden" name="previous_step_<?php echo $intCatDetailId; ?>" id="previous_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Steps']; ?>" />
								
								<input type="hidden" name="previous_phase_<?php echo $intCatDetailId; ?>" id="previous_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Phase']; ?>" />
								
								<input type="hidden" name="previous_substep_<?php echo $intCatDetailId; ?>" id="previous_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['substep']; ?>" />
								
								<h4 class="osr14 text-middle-dark-grey"><a style="float:left;margin-right:10px;" name="prev_button_<?php echo $intCatDetailId; ?>" id="prev_button_<?php echo $intCatDetailId; ?>" href="" onclick="return fnGetSubstepDetail(<?php echo $intPortalId;?>,<?php echo $arrStepsNavigationDetails['previousnavigation']['substep'];?>,<?php echo $arrStepsNavigationDetails['previousnavigation']['Steps'];?>,<?php echo $arrStepsNavigationDetails['previousnavigation']['Phase'];?>)" class="btn btn-default">Previous</a></h4>
							<?php
						}
					}
				?>
					
					
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
				<input type="hidden" name="substepProducts" id="substepProducts" value="<?php echo count($arrsubstepproducts);?>"/>
						<?php
						//echo $intSbStepId;
						//exit;
						
						if(is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases)>0))
						{
							
							foreach($arrJobSearchProcessPhases as $arrJProcess)
							{
								if($arrJProcess['Categories']['content_category_id'] == $intSbStepId)
								{
									/*print("<pre>");
									print_r($arrJProcess);
									continue;*/
								?>
									<h4>SubStep <?php echo $arrJProcess['Categories']['job_search_order']; ?></h4>
									<h2><?php echo $arrJProcess['Categories']['content_category_name']; ?></h2>
									<p><?php echo   htmlspecialchars_decode(stripslashes($arrJProcess['Categories']['content'])); ?></p>
							
					<div class="tab-content wizard-step-v2-style">
						<div id="example1" class="tab-pane fade in active">
							
							

							<hr>
							
							<div class="text-right wizard-version">
							<h4 class="osr14"><a <?php echo $strCompletionevent; ?> id="<?php echo $strCompleteId; ?>" href="javascript:void(0);"  class="btn btn-primary stepbutton <?php echo $strCompleteId; ?>"><?php echo $strActionButtonText; ?></a></h4>
								<!--<button class="btn btn-primary">Complete &gt;</button>-->
							</div>
						</div>
					</div>
									<?php
									//print("<pre>");
									//print_r($arrCatContentTitles);
									/*
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
														//	print_r($arrContentListArticle);
															//	exit;
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
									}*/
								}
							}
						}
					?>
			</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 wizard-step-aside-container wizard-step-v3">
		<div class="wizard-aside-inside-container">
		<?php if(count($arrsubstepproducts)>0)
		{?>
					
						
						<?php foreach($arrsubstepproducts as $arrsubstepproduct)
							{
								
								$productd_id = $arrsubstepproduct['products']['productd_id'];
								$product_name = $arrsubstepproduct['products']['product_name'];
								$product_cost = $arrsubstepproduct['products']['product_cost'];
								$discount_cost = $arrsubstepproduct['products']['discount_cost'];
								$vendor_service_id =$arrsubstepproduct['substepProducts']['vendor_service_id'];
						
						?>
						<div class="wizard-aside-button-container">
							<h5><?php echo $product_name;?></h5>
							
							<?php if($discount_cost !=''){ ?>
								<span class="wizard-price">Regular Price <s>$<?php echo $product_cost;?></s></span>
							<?php }else{ ?>
								<span class="wizard-price">Regular Price $<?php echo $product_cost;?></span>
							<?php } ?>
							<?php if($discount_cost !=''){ ?>
							<span class="wizard-price-today">Today $<?php echo $discount_cost;?></span>
							<?php } ?>
							<button class="btn btn-custom" id="add_to_cart_<?php echo $vendor_service_id."_".$intPortalId;?>"  href="javascript:void(0);" onclick="fnAddtocart(this);"><span class="osb21 text-dark-grey">Add To Cart</span></button>
					
						</div>
					
							<?php }
					}
?>
<?php
						if($intCatDetailId)
						{
						if(is_array($arrContentListArticle) && (count($arrContentListArticle)>0))
							{
								
							?>
							<div class="wizard-aside-resources-container">
							<h3>Resources</h3>
							<ul class="resources-list">
								<?php
								$intFrCnt = 0;
								foreach($arrContentListArticle as $arrListArticle)
								{
								//	echo "<pre>";
								//print_R($arrListArticle);
								$arrArticleUrl = Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId,$arrListArticle['content']['content_id']),true);
								?>
					
								
								
									<li><a href="<?php echo $arrArticleUrl;?>" target="_blank"><?php echo $arrListArticle['content']['content_title'];?></a></li>
								
									
									<?php
								}
								?>
								<?php
								
								/*foreach($arrContentListWebinars as $arrListWebinars)
								{
								//echo "<pre>";
								//print_R($arrListWebinars);
								$arrWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinardetail',$intPortalId,$arrListWebinars['content']['content_id']),true);
								?>
							
								<li><a target="_blank" href="<?php echo $arrWebinarUrl;?>"><?php echo $arrListWebinars['content']['content_title'];?></a></li>
								<?php 
								}*/
								?>
							</ul>
						</div>
						<?php 
							}
						}?>
					
					<?php
					if(is_array($arrContentListWebinars) && (count($arrContentListWebinars)>0))
							{
							?>
					<!--<div class="wizard-aside-resources-container webinars-bottom">
							<h3>Webinars</h3>
							<ul class="resources-list">
								<?php
								
								/*foreach($arrContentListWebinars as $arrListWebinars)
								{
							//	echo "<pre>";
							//	print_R($arrListWebinars);
								$arrWebinarUrl = Router::url(array('controller'=>'candidates','action'=>'webinardetail',$intPortalId,$arrListWebinars['content']['content_id']),true);
								?>
							
								<li><a target="_blank" href="<?php echo $arrWebinarUrl;?>"><?php echo $arrListWebinars['content']['content_title'];?></a></li>
								<?php 
								}*/
								?>
							</ul>
						</div>-->
						<?php 
						}?>
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
<script type="text/javascript">
	$(document).ready(function () {

		var header_height = $('.top-menu-container.wizard-step-v3').height();
		var footer_height = $('footer').height();
		$('footer').css("position", "fixed");
		$('footer').css("bottom", 0);
		$('footer').css("width", "100%");
		
		var current_window_height = $( window ).height() - header_height - footer_height;
		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-right-side-container.wizard-step-v3').css("top", header_height + "px");

		$('.sidebar-container.wizard-step-v3, .wizard-step-aside-container.wizard-step-v3, .wizard-step-content-container.wizard-step-v3').css("height", current_window_height + "px");
	});
</script>
<div id="addtocart" class="modal fade">
		  	<div class="modal-dialog-share" >
			    <div class="modal-content">
			    	<div class="modal-header">
			    		
						<button type="button" class="close" data-dismiss="modal">&times;</button>
			    		<h3>Add To Cart</h3>

			    	</div>

				    <div class="modal-body">
				      
				      		<?php if(count($arrsubstepproducts)>0)
							{?>
					
						<div class="wizard-aside-button-container" style="padding: 20px;">
						
						<h6 style="font-size:14px;"> You have successfully completed this substep. To purchase the resource listed below, click on Add To Cart. Or click on Next Step to continue. To learn more about all the resources, click on the Resources tab</h6>
							<?php 
							foreach($arrsubstepproducts as $arrsubstepproduct)
							{
							$productd_id = $arrsubstepproduct['products']['productd_id'];
							$product_name = $arrsubstepproduct['products']['product_name'];
							$product_cost = $arrsubstepproduct['products']['product_cost'];
							$vendor_service_id =$arrsubstepproduct['substepProducts']['vendor_service_id'];
						
						?>
							<p><br/></p>
							<h4 style="margin-bottom:10px"><?php echo $product_name;?></h4>
							
							<p class="wizard-price">Price <s>$<?php echo $product_cost;?></s></p>
							<p class="wizard-price-today">&nbsp;&nbsp;</p>
							<p><br/></p>
							<button class="btn btn-primary" style="float: left;margin-right: 10px;" id="add_to_cart_<?php echo $vendor_service_id."_".$intPortalId;?>"  href="javascript:void(0);" onclick="fnAddtocart(this);"><span class="osb21 text-dark-grey">Add To Cart</span></button>
							<?php }
						}
						else
						{?>
							<h5>No Products found</h5>
					
						<?php
						}?>
				      	
						<?php
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
								
								<h4 class="osr14 text-middle-dark-grey"><button  name="nex_button_<?php echo $intCatDetailId; ?>" id="nex_button_<?php echo $intCatDetailId; ?>" href="javascript:void(0);" onclick="return fnGetSubstepNext(<?php echo $intPortalId;?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['substep'];?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['Steps'];?>,<?php echo $arrStepsNavigationDetails['nextnavigation']['Phase'];?>)" class="btn btn-default">Next Step</button></h4>
							<?php
						}
						
					}
?>
				    </div>
		    	</div>
		  	</div>
		</div>
</div>