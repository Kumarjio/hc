	<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>


			<div class="col-md-10 bg-lightest-grey">
				
				<div class="page-header">
					<h2>Library</h2>
					<p>Welcome to the Career Portal Library!  Here you will find the resources necessary to conduct a successful job search.</p>
				</div>
				<div class="library-categories">
				<?php //echo '<pre>';print_r($arrLibCatDetail);exit();////item-<?php echo strtolower(str_replace(' ','-',$arrLibCatDetailVal['Categories']['content_category_name'])); 
			if(isset($arrLibCatDetail))
			{
				if(is_array($arrLibCatDetail) && (count($arrLibCatDetail)>0))
				{
			
							foreach($arrLibCatDetail as $arrAllMaterialDetailsKey=>$arrLibCatDetailVal)
							{
								$strlibCatDetailUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId,$arrLibCatDetailVal['Categories']['content_category_id']),true);
								
					?>
					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						
						<?php if($arrLibCatDetailVal['Categories']['content_category_image'] != null && $arrLibCatDetailVal['Categories']['content_category_image']!= ""){?>
						<img class="library-item" style="height:70px" src="<?php echo $this->webroot;?>contentcat/<?php echo $arrLibCatDetailVal['Categories']['content_category_image'];?>">
						<?php }else{ ?>
						<div class="library-item" style="height: 70px;width: 70px;background-color: #e4d6d6;text-align: center;vertical-align: middle;padding: 13px;">No Icon</div>
						<?php } ?>
						<h3><a href="<?php echo $strlibCatDetailUrl; ?>" style="font-size:inherit;"><?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?></a></h3>
						
					</div>
					
					<?php
					}
				}
			}?>
					
				</div>	
				</div>

			</div>
			<div class="col-md-1"></div>
		</div>
	</div>


<!---<div class="wrapper">
	<div id="portal_registration">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;">Library</h2>
		<?php
			if(isset($arrLibCatDetail))
			{
				if(is_array($arrLibCatDetail) && (count($arrLibCatDetail)>0))
				{
					?>
						<div id="product_container" style="float:left;width:100%;">
							<?php
							foreach($arrLibCatDetail as $arrAllMaterialDetailsKey=>$arrLibCatDetailVal)
							{
								$strlibCatDetailUrl = Router::url(array('controller'=>'candidates','action'=>'libcatdetail',$intPortalId,$arrLibCatDetailVal['Categories']['content_category_id']),true);
								?>
								<div style="float:left;width:28%;margin-right:1%;height:100px;" id="product_block">
									<div id="product_head">
										<?php
											if($arrLibCatDetailVal['Categories']['content_cat_icon'])
											{
												$strCatImageUrl = Router::url('/',true)."files/thumbnail/".$arrLibCatDetailVal['content_media']['content_media_title'];
												?>
													<div>
														<a href="<?php echo $strlibCatDetailUrl; ?>"><img src="<?php echo $strCatImageUrl; ?>" title="Category Image" alt="<?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?>"></img></a>
													</div>
												<?php
											}
											else
											{
												$strCatImageUrl = Router::url('/',true)."img/folder.png";
												?>
													<div>
														<a href="<?php echo $strlibCatDetailUrl; ?>"><img src="<?php echo $strCatImageUrl; ?>" title="Category Image" alt="<?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?>"></img></a>
													</div>
												<?php
											}
										?>
										<div><a href="<?php echo $strlibCatDetailUrl; ?>" style="font-size:inherit;"><?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?></a></div>
									</div>
								</div>
								<?php
							}
							?>
							<div style="float:left;width:28%;margin-right:1%;" id="product_block">
								<div id="product_head">
									<?php
										$strCatImageUrl = Router::url('/',true)."img/folder.png";
										$strlibCatDetailUrl = Router::url(array('controller'=>'candidates','action'=>'libcatdetail',$intPortalId),true);
									?>
									<div>
										<a href="<?php echo $strlibCatDetailUrl; ?>"><img src="<?php echo $strCatImageUrl; ?>" title="Category Image" alt="<?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?>"></img></a>
									</div>
									<div><a href="<?php echo $strlibCatDetailUrl; ?>" style="font-size:inherit;">All Content</a></div>
								</div>
							</div>
						</div>
					<?php
				}
			}
		?>
	</div>
</div>-->