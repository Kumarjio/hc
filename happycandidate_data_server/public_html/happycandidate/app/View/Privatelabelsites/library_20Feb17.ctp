<div class="page-content-wrapper employers-type" style="min-height:500px;">
	<div class="container-fluid bg-lightest-grey">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				
				<div class="page-header">
					<h2>Library</h2>
					<p>Praesent dignissim imperdiet eros, vel condimentum nunc lobortis a. Nullam porta ultricies sodales. Nam pulvinar dui id eleifend finibus.</p>
				</div>
				<div class="library-categories">
				<?php
			if(isset($arrLibCatDetail))
			{
				if(is_array($arrLibCatDetail) && (count($arrLibCatDetail)>0))
				{
			
							foreach($arrLibCatDetail as $arrAllMaterialDetailsKey=>$arrLibCatDetailVal)
							{
								$strlibCatDetailUrl = Router::url(array('controller'=>'candidates','action'=>'webinars',$intPortalId),true);
								
					?>
					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						
<?php if($arrLibCatDetailVal['Categories']['content_category_image'] != null && $arrLibCatDetailVal['Categories']['content_category_image']!= ""){?>
						<img class="library-item" style="height: 70px;" src="<?php echo $this->webroot;?>contentcat/<?php echo $arrLibCatDetailVal['Categories']['content_category_image']; ?>">
						<?php }else{ ?>
						<div class="library-item" style="height: 70px;width: 70px;background-color: #e4d6d6;text-align: center;vertical-align: middle;padding: 13px;">No Icon</div>						<?php } ?>

						<h3><a href="javascript:void(0);" style="font-size:inherit;"><?php echo $arrLibCatDetailVal['Categories']['content_category_name']; ?></a></h3>
						
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
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.leftnavi').removeClass('active');
		$('#libnavi').addClass('active');
	});
</script>