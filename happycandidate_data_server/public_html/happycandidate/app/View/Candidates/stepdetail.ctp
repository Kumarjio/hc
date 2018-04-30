<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn">
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
		<div>&nbsp;</div>
		<?php
			$strReturnUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
		?>
		<div style="float:right;width:100%;"><a href="<?php echo $strReturnUrl; ?>" style="float:right;" class="button_class">Back</a></div>
		<div>&nbsp;</div>
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
												<?php 
													switch($arrContTit)
													{
														case"1": echo "Article";
																break;
														case"2": echo "Webinar";
																break;
													}
												?>
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
				<div class="index row nopadding" id="tabs" style="float:left;width:100%;">
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
										<li id="<?php echo $arrContentType[$arrContentTyId['content']['content_type']]; ?>"><a style="font-size:inherit;" href="#contentpart<?php echo $arrContentTyId['content']['content_type'];?>"><?php echo ucfirst($arrContentType[$arrContentTyId['content']['content_type']]); ?></a></li>
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
											<div id="content_html<?php echo $arrContentTyId['content']['content_type'];?>">
												<?php
													if($intForCnt == "0")
													{
														echo $this->element('article_list',array('strTypeBlock'=>$arrContentType[$arrContentTyId['content']['content_type']]));
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
									<p class="tabloader" style="display:none;"></p>
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
				<div style="float:right;width:100%;"><a href="<?php echo $strReturnUrl; ?>" style="float:right;" class="button_class">Back</a></div>
				<div>&nbsp;</div>
			<?php
		}
	?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				
				var strNewTab = ui.newTab.attr('id');
				$('.tabloader').show();
				if($('#article_list_block_'+strNewTab).length>0)
				{
					$('.tabloader').hide();
				}
				else
				{
					fnGetContentWebinars($('#portalid').val(),$('#content_catid').val(),strNewTab);
				}
			}
		});
	});
</script>
<style>
	.ui-tabs {
		position: relative;/* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
		padding: .2em;

	}
	.ui-tabs .ui-tabs-nav {
		margin: 0;
		padding: .2em .2em 0;
	}
	.ui-tabs .ui-tabs-nav li {
		list-style: none;
		float: left;
		position: relative;
		top: 0;
		margin: 1px .2em 0 0;
		border-bottom-width: 0;
		padding: 0;
		white-space: nowrap;
	}
	.ui-tabs .ui-tabs-nav .ui-tabs-anchor {
		float: left;
		padding: .5em 1em;
		text-decoration: none;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active {
		margin-bottom: -1px;
		padding-bottom: 1px;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-state-disabled .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-tabs-loading .ui-tabs-anchor {
		cursor: text;
	}
	.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor {
		cursor: pointer;
	}
	.ui-tabs .ui-tabs-panel {
		display: block;
		border-width: 0;
		padding: 1em 1.4em;
		background: none;
	}
	#mediacontainer {
		float:left;
		width:100%;
	}
	
	#tabs2 {
		float:left;
		width:100%;
	}
</style>