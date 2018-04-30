<div style="margin:auto;width:960px;">
	<?php
		if(isset($arrCandidatesBadges))
		{
			if(is_array($arrCandidatesBadges['badgedetail']) && (count($arrCandidatesBadges['badgedetail'])>0))
			{
				/*print("<pre>");
				print_r($arrCandidatesBadges);*/
				?>
					<div id="product_container" style="float:left;width:100%;">
						<div style="float:left;width:100%;margin-right:1%;" id="product_block">
								<div id="product_head" style="float:left;width:100%;font-size:22px;border-bottom:1px solid #ccc;padding-bottom: 15px;">Badges</div>
								<?php
									foreach($arrCandidatesBadges['badgedetail'] as $arrBadges)
									{
										?>
											<table id="product_body" style="float:left;width:80%;margin-top:10px;">
												<tr>
													<td>
													<a href="javascript:void(0);"><img src="<?php echo $arrBadges['badgeImageUrl']; ?>" alt="<?php echo $arrBadges['name']; ?>" /></a>
													<div class="clear"></div>
													<a href="javascript:void(0);" style=" display: inline-block;padding-left:2%;padding-top: 8px;"><?php echo $arrBadges['name']; ?></a>
													</td>
												<td>
													<span class="Badges_field"><label style="font-weight:bold;">Course:</label>&nbsp;<a href="javascript:void(0);"><?php echo $arrBadges['fullname']; ?></a></span>
												</td>	
												</tr>
												
											</table>
										<?php
									}
								?>
								<div id="product_foot" style="float:left;width:80%;margin-top:30px;"><span>&nbsp;<span></div>
								</div>
						</div>
					</div>
				<?php
			}
		}
	?>
</div>