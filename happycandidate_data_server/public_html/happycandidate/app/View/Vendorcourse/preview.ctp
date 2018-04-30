<div class="wrapper">
	<div id="portal_registration">
		<div id="product_container" style="float:left;width:100%;">
			<div id="product_image_container" style="float:left;width:38%;margin-right:2%;">
				<div id="product_image" style="float:left;width:96%;padding:2%;">
					<?php
						if(is_array($arrContentDetail[0]['Resourceimages']) && (count($arrContentDetail[0]['Resourceimages'])>0))
						{
							?>
								<img name="product_image" id="product_image" src="<?php echo Router::url('/',true);?>/productfiles/<?php echo $arrContentDetail[0]['Resourceimages']['product_image'];?>" alt="Product Image Here" style="border:solid 2px grey;width:100%;" />
							<?php
						}
						else
						{
							?>
								<img name="product_image" id="product_image" src="<?php echo Router::url('/',true);?>/img/noimage.jpg" alt="Product Image Here" style="border:solid 2px grey;width:100%;" />
							<?php
						}
					?>
				</div>
			</div>
			<div id="product_intro_container" style="float:left;width:58%;margin-right:2%;">
				<div id="product_intro" style="float:left;width:96%;padding:2%;">
					<div id="product_title" style="float:left;width:100%;">
						<h2 id="jobn" style="border-bottom:1px solid #44899B;padding:0;"><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h2>
					</div>
					<div style="float:left;width:100%;">&nbsp;</div>
					<div id="product_intro_text" style="float:left;width:96%;padding:2%;">
						<?php
							echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content_intro_text']));
						?>
					</div>
				</div>
			</div>
			<div style="float:left;width:100%;">&nbsp;</div>
			<div id="product_content_container" style="float:left;width:100%;">
				<div id="product_content" style="float:left;width:96%;padding:2%;">
					<?php
						echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));
					?>
				</div>
			</div>
		</div>
	</div>	
</div>