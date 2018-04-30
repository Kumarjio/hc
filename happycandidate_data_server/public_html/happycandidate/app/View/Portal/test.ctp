<?php
	if(is_array($arrPortalPageDetail) && (count($arrPortalPageDetail)>0))
	{
		?>
			<h2 id="page_title">
				<?php
					echo $arrPortalPageDetail['0']['PortalPages']['career_portal_page_tittle'];
				?>
			</h2>
			<div>&nbsp;</div>
			<div id="page_content_div">
					<?php
						echo htmlspecialchars_decode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content']);
					?>
			</div>
		<?php
	}
	else
	{
		?>
			<h2 id="page_title">
			</h2>
			<div>&nbsp;</div>
			<div id="page_content_div"></div>
		<?php
	}
?>