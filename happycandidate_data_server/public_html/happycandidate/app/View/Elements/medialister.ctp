<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */
 
 
?>
<script type="text/javascript">
$(document).ready(function () {
	$('.thumbnail').click(function () {
		$('.thumbnail').removeClass('mediathumbselected');
		$(this).addClass('mediathumbselected');
		strMediaTLocation = $(this).attr('src');
		if(strMediaTLocation.indexOf("pdf_icon").toString() != "-1")
		{
			var strPdfFile = $(this).attr('alt');
			strMediaTLocation = strMediaTLocation.replace("/img/pdf_icon.jpg","/files/"+strPdfFile);
			//fnShowSubjectPath('media',strMediaTLocation);
		}
		else
		{
			if(strMediaTLocation.indexOf("mp3_icon").toString() != "-1")
			{
				var strMp3File = $(this).attr('alt');
				strMediaTLocation = strMediaTLocation.replace("/img/mp3_icon.jpg","/files/"+strMp3File);
				//fnShowSubjectPath('media',strMediaTLocation);
			}
			else
			{
				strMediaTLocation = strMediaTLocation.replace("thumbnail/","");
				//fnShowSubjectPath('media',strMediaTLocation);
			}
		}
	});
});
</script>
<div id="medialister" class="col-md-12 nopadding">
	<?php
		$strDirectoryPath = WWW_ROOT."files\\thumbnail";
		$arrDirectoryListing = scandir($strDirectoryPath);
		/*print("<pre>");
		print_r($arrDirectoryListing);
		exit;*/
		
		if(is_array($arrMediaList) && (count($arrMediaList)>0))
		{
			foreach($arrMediaList as $arrMedia)
			{
				
				
				if(strpos($arrMedia['ContentMedia']['content_media_type'],"image") !== false)
				{
					?>
						<div style="float:left;width:16%;height:100px;margin-left:3%;margin-right:3%;">
							<img id="<?php echo $arrMedia['ContentMedia']['content_media_id'];?>" class="thumbnail img-responsive" src="<?php echo ROUTER::url('/',true)."files/thumbnail/".$arrMedia['ContentMedia']['content_media_name'];?>" alt="<?php echo$arrMedia['ContentMedia']['content_media_name'];?>" title="Media Image" />
							<div class="wordwrap" style="float:left;width:100%;font-size:10px;"><?php echo $arrMedia['ContentMedia']['content_media_name'];?></div>
						</div>
					<?php
				}
				else
				{
					if(strpos($arrMedia['ContentMedia']['content_media_type'],"pdf"))
					{
						?>
							<div style="float:left;width:16%;height:100px;margin-left:3%;margin-right:3%;">
								<img id="<?php echo $arrMedia['ContentMedia']['content_media_id'];?>" class="thumbnail img-responsive" src="<?php echo ROUTER::url('/',true)."img/pdf_icon.jpg";?>" alt="<?php echo$arrMedia['ContentMedia']['content_media_name'];?>" title="Media Image" />
								<div class="wordwrap" style="float:left;width:100%;font-size:10px;"><?php echo $arrMedia['ContentMedia']['content_media_name'];?></div>
							</div>
						<?php
					}
					else
					{
						if(strpos($arrMedia['ContentMedia']['content_media_type'],"audio") !== false)
						{
							?>
								<div style="float:left;width:16%;height:100px;margin-left:3%;margin-right:3%;">
									<img id="<?php echo $arrMedia['ContentMedia']['content_media_id'];?>" class="thumbnail img-responsive" src="<?php echo ROUTER::url('/',true)."img/mp3_icon.jpg";?>" alt="<?php echo$arrMedia['ContentMedia']['content_media_name'];?>" title="Media Image" />
									<div class="wordwrap" style="float:left;width:100%;font-size:10px;"><?php echo $arrMedia['ContentMedia']['content_media_name'];?></div>
								</div>
							<?php
						}
					}
				}
			}
		}
		else
		{
		
		}
	?>
</div>
