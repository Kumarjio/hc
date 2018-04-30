<?php
if(is_array($arrContentListArticle) && (count($arrContentListArticle)>0))
{
	
	foreach($arrContentListArticle as $arrArticle)
	{
		/*$arrArticleUrl = Router::url(array('controller'=>'candidates','action'=>'articledetail',$intPortalId,$arrArticle['content']['content_id']),true);*/
		$intArticleId = $arrArticle['content']['content_id'];
		$strTarget = "";
		if($intContentonNewtab)
		{
			$strTarget = "target='_blank'";
		}
		$arrArticleUrl = $strArticleDetailUrl."/".$arrArticle['content']['content_id'];
		?>
			<div class="processstepcontainer" style="float:left;width:100%;margin-bottom:10px;" id="article_list_block_<?php echo $strTypeBlock; ?>_<?php echo $catid; ?>">
				<div id="article_head" style="float:left;width:100%;border-bottom:1px solid #44899b;margin-bottom:10px;">
					<?php
						if($arrArticle['content']['content_type'] == "1")
						{
							?>
								<a style="font-size:17px;color:#44899b;" href="javascript:void(0);"><?php
									echo stripslashes($arrArticle['content']['content_title']);
								?></a>
							<?php
						}
						else
						{
							?>
								<a <?php echo $strTarget; ?> style="font-size:17px;color:#44899b;" href="<?php echo $arrArticleUrl; ?>"><?php
									echo stripslashes($arrArticle['content']['content_title']);
								?></a>
							<?php
						}
					?>
					
				</div>
				<div id="article_body" style="float:left;width:100%;margin-bottom:10px;">
					<p class="tabloader" id="conten_loader_<?php echo $intArticleId; ?>" style="display:none;"></p>
					<div id="less_content_<?php echo $arrArticle['content']['content_id']; ?>"><?php
						echo htmlspecialchars_decode($arrArticle['content']['content_intro_text']);
					?>
					</div>
					<div id="more_content_<?php echo $arrArticle['content']['content_id']; ?>" style="display:none;"></div>
				</div>
				<div id="article_footer" style="float:left;width:100%;margin-bottom:10px;">
					<?php
						if($arrArticle['content']['content_type'] == "1")
						{
							?>
								<div id="read_more_action_<?php echo $arrArticle['content']['content_id']; ?>"><a onclick="fnLoadMoreContent('<?php echo $intArticleId; ?>','<?php echo $intPortalId; ?>','more','<?php echo $catid; ?>')" style="color:#44899b;" href="javascript:void(0);">Read More</a></div>
								<div id="read_less_action_<?php echo $arrArticle['content']['content_id']; ?>" style="display:none;"><a onclick="fnLoadMoreContent('<?php echo $intArticleId; ?>','<?php echo $intPortalId; ?>','less','<?php echo $catid; ?>')" style="color:#44899b;" href="javascript:void(0);">Read Less</a></div>
							<?php
						}
						else
						{
							?>
								<div id="read_more_action_<?php echo $arrArticle['content']['content_id']; ?>"><a <?php echo $strTarget;?> style="color:#44899b;" href="<?php echo $arrArticleUrl;?>">Read More</a></div>
							<?php
						}
					?>
				</div>
			</div>
		<?php
	}
}
else
{
	?>
		<div style="float:left;width:100%;margin-bottom:10px;" id="article_list_block_<?php echo $strTypeBlock; ?>">
			<div id="article_body" style="float:left;width:100%;margin-bottom:10px;">
				There are no Content to List.
			</div>
		</div>
	<?php
}