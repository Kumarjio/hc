<?php
			$strReturnUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);
		?>		
	<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>

			<div class="col-md-10 bg-lightest-grey">
				<input type="hidden" name="content_catid" id="content_catid" value="<?php echo $intCatDetailId; ?>" />
				  <input type="hidden" name="portalid" id="portalid" value="<?php echo $intPortalId; ?>" />
				<div class="page-header">
					<a href="<?php echo $strReturnUrl; ?>" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span> Back to Library</a>
					<h2>		<?php 
				if($intCatDetailId)
				{
					echo $arrContentListArticle[0]['content_category']['content_category_name']; 
				}
				else
				{
					echo "All Topics"; 
				}
			?></h2>
					<p>The following topics will help you stand out from job seekers competing for the same opportunity.</p>
				</div>

				<div class="library-body">
				<ul class="nav nav-pills tab-list">
					<li class="active">
						<a id="library-articles" data-toggle="pill" href="#tab-library-articles">Articles</a>
					</li>
					
					<li>
						<a id="library-webinars" data-toggle="pill" href="#tab-library-webinars">Webinars</a>
					</li>
				</ul>
				<div class="top-border" style="padding-top: 20px;">
					<div id="tab-library-articles" class="tab-pane fade in active tab-container">
					<?php
								echo $this->element('article_list_new');
										?>
					
						
					</div>
					
					<div id="tab-library-webinars" class="tab-pane fade"></div>
				</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("a[data-toggle='pill']").click(function() {
		   
		   var strNewTab = $(this).attr('id');
		   
		   if(strNewTab == "library-webinars")
		   {
			 fnGetContentWebinars($('#portalid').val(),$('#content_catid').val(),strNewTab);
		   }
		 
		  
	   });
	});
</script>