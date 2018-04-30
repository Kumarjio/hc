<div>
	<div id="portal_registration">
		<!--<h2 id="jobn">
			<?php 
				if($intCatDetailId)
				{
					echo $arrContentListArticle[0]['content_category']['content_category_name']; 
				}
				else
				{
					echo "All Topics"; 
				}
			?>
		</h2>
		<div>&nbsp;</div>-->
		<?php
			$strReturnUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
		?>
		<div id="substep_action_<?php echo $intCatDetailId; ?>" style="float:right;width:100%;">
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
				
				
				if(is_array($arrStepsNavigationDetails) && (count($arrStepsNavigationDetails)>0))
				{
					if(isset($arrStepsNavigationDetails['nextnavigation']))
					{
						?>
							<input type="hidden" name="next_step_<?php echo $intCatDetailId; ?>" id="next_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['Steps']; ?>" />
							
							<input type="hidden" name="next_phase_<?php echo $intCatDetailId; ?>" id="next_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['Phase']; ?>" />
							
							<input type="hidden" name="next_substep_<?php echo $intCatDetailId; ?>" id="next_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['nextnavigation']['substep']; ?>" />
							
							<a style="float:left;margin-right:10px;" onclick="fnLoadStep(this,'next')" name="nex_button_<?php echo $intCatDetailId; ?>" id="nex_button_<?php echo $intCatDetailId; ?>" href="javascript:void(0);" class="button_class">Next</a> 
						<?php
					}
					
					if(isset($arrStepsNavigationDetails['previousnavigation']))
					{
						?>
							<input type="hidden" name="previous_step_<?php echo $intCatDetailId; ?>" id="previous_step_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Steps']; ?>" />
							
							<input type="hidden" name="previous_phase_<?php echo $intCatDetailId; ?>" id="previous_phase_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['Phase']; ?>" />
							
							<input type="hidden" name="previous_substep_<?php echo $intCatDetailId; ?>" id="previous_substep_<?php echo $intCatDetailId; ?>" value="<?php echo $arrStepsNavigationDetails['previousnavigation']['substep']; ?>" />
							
							<a style="float:left;margin-right:10px;" onclick="fnLoadStep(this,'prev')" name="prev_button_<?php echo $intCatDetailId; ?>" id="prev_button_<?php echo $intCatDetailId; ?>" href="javascript:void(0);" class="button_class">Previous</a> 
						<?php
					}
				}
			?>
			
			<a <?php echo $strCompletionevent; ?> id="<?php echo $strCompleteId; ?>" href="javascript:void(0);" style="float:left;margin-right:10px;" class="button_class <?php echo $strCompleteId; ?>"><?php echo $strActionButtonText; ?></a>
		</div>
			<input type="hidden" name="completion_criteria_<?php echo $intCatDetailId; ?>" id="completion_criteria_<?php echo $intCatDetailId; ?>" value="<?php echo $strCriteria; ?>" />
		<!--<div>&nbsp;</div>-->
		<?php
			if($intCatDetailId)
			{
				if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>1))
				{
					?>
						<div class="index row nopadding" id="newtabs" style="float:left;width:100%;">
							<ul>
								<?php
									foreach($arrCatContentTitles as $arrContTitKey => $arrContTit)
									{
										?>
											<li id="content_<?php echo $arrContTitKey; ?>"><a style="font-size:inherit;" href="#contentcontainer<?php echo $arrContTitKey; ?>">

												</a></li>
										<?php
									}
								?>
							</ul>
							<?php
								$intFrCnt = 0;
								foreach($arrCatContentTitles as $arrContTitKey => $arrContTit)
								{
									if($intFrCnt == "0")
									{
										?>
											<div id="contentcontainer<?php echo $arrContTitKey;?>">
												<p class="tabloader" id="maincontloader_<?php echo $arrContTitKey;?>" style="display:none;"></p>
												<div id="content_data<?php echo $arrContTitKey;?>">
													<?php
														echo htmlspecialchars_decode(stripslashes($arrCatContent['0']['Content']['content']));
													?>
												</div>
											</div>
										<?php
									}
									else
									{
										?>
											<div id="contentcontainer<?php echo $arrContTitKey;?>">
												<p class="tabloader" id="maincontloader_<?php echo $arrContTitKey;?>" style="display:none;"></p>
												<div id="content_data<?php echo $arrContTitKey;?>"></div>
											</div>
										<?php
									}
									$intFrCnt++;
								}
							?>
						</div>
						<script type="text/javascript">
							$(document).ready(function () {
								$( "#newtabs" ).tabs({
									beforeActivate: function( event, ui ) {
										
										var strNewTab = ui.newTab.attr('id');
										var arrNewTab = strNewTab.split("_");
										$('#maincontloader_'+arrNewTab[1]).show();
										if($('#content_data'+arrNewTab[1]).html() != "")
										{
											$('#maincontloader_'+arrNewTab[1]).hide();
										}
										else
										{
											fnGetContent(arrNewTab[1],'<?php echo $intPortalId;?>');
										}
									}
								});
							});
						</script>
					<?php
				}
				else
				{
					if(is_array($arrCatContentTitles) && (count($arrCatContentTitles)>0))
					{
						?>
							<div>
						<?php
								echo htmlspecialchars_decode($arrCatContent[0]['Content']['content']);
						?>
							</div>
						<?php
					}
				}
			}
		?>
	</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<?php
		if(is_array($arrContentListArticle) && (count($arrContentListArticle)>0))
		{
			?>
				<div class="index row nopadding" id="tabs_<?php echo $intCatDetailId; ?>" style="float:left;width:100%;">
				  <input type="hidden" name="content_catid" id="content_catid" value="<?php echo $intCatDetailId; ?>" />
				  <input type="hidden" name="portalid" id="portalid" value="<?php echo $intPortalId; ?>" />
				  <ul>
					<?php
						if($intCatDetailId)
						{
							if(is_array($arrContentTypeList) && (count($arrContentTypeList)>0))
							{
								foreach($arrContentTypeList as $arrContentTyId)
								{
									?>
										<li class="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]."_".$intCatDetailId; ?>" id="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]; ?>"><a style="font-size:inherit;" href="#contentpart<?php echo $arrContentTyId['content']['content_type'];?>"><?php echo ucfirst($arrContentType[$arrContentTyId['content']['content_type']]); ?></a></li>
									<?php
								}
							}
						}
						else
						{
							?>
								<li><a style="font-size:inherit;" href="#contentpart">Content</a></li>
							<?php
						}
					?>
				  </ul>
				  <?php
						if($intCatDetailId)
						{
							if(is_array($arrContentTypeList) && (count($arrContentTypeList)>0))
							{
								$intForCnt = 0;
								foreach($arrContentTypeList as $arrContentTyId)
								{
									?>
										<div id="contentpart<?php echo $arrContentTyId['content']['content_type'];?>">
											<p class="tabloader" style="display:none;"></p>
											<div id="content_html<?php echo $arrContentTyId['content']['content_type'];?>_<?php echo $intCatDetailId; ?>">
												<?php
													if($intForCnt == "0")
													{
														echo $this->element('article_list',array('catid'=>$intCatDetailId,'strTypeBlock'=>$arrContentType[$arrContentTyId['content']['content_type']]));
													}
												?>
											</div>
										</div>
									<?php
									$intForCnt++;
								}
							}
						}
						else
						{
							?>
								<div id="contentpart">
									<p class="tabloader" id="substep_content_loader_<?php echo $intCatDetailId; ?>" style="display:none;"></p>
									<div id="content_html">
										<?php
											echo $this->element('article_list');
										?>
									</div>
								</div>
							<?php
						}
				  ?>
					
				</div>
				<div>&nbsp;</div>
				<div style="float:right;width:100%;"><a <?php echo $strCompletionevent; ?> id="<?php echo $strCompleteId; ?>" href="javascript:void(0);" style="float:left;margin-right:10px;" class="button_class <?php echo $strCompleteId; ?>"><?php echo $strActionButtonText; ?></a></div>
				<div>&nbsp;</div>
			<?php
		}
	?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		var strTabSuff = '<?php echo $intCatDetailId; ?>';
		$( "#tabs_"+strTabSuff ).tabs({
			beforeActivate: function( event, ui ) {
				
				var strNewTab = ui.newTab.attr('id');
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
			}
		});
	});
</script>