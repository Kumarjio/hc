
<div class="page-content-wrapper">
	            <div class="container-fluid">
<div class="row">
			
			
				<div class="page-header">
					<h2>Upload Service Images</h2>
					
				</div>
				<div id="product_notification"></div>
				<ul class="nav nav-pills tab-list">
					<li class="active">
						<a href="#js-vendor-panel" data-toggle="pill" id="js-vendor-panel">Services Image Panel</a>
					</li>
					
				
				</ul>
				<div style="padding-top: 20px;" class="tab-content">
					<div class="tab-pane fade in active" id="tab-vendor-panel">
						<?php 
			echo $this->element("serviceimages");
		?>
						

					</div>
					
				
				
					
				</div>
		
			
		</div>
		</div>
		</div>
		<?php
	echo $this->element('assign_media_modal');
?>
<?php /*
<div class="index page-header row">
	<h1>Upload Service Images</h1>
	<!--<p class="lead">Here are the list of added contents</p>-->
</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
  <input type="hidden" name="content_added" id="content_added" value="" />
  <ul>
    <li><a href="#contentpart">Services Image Panel</a></li>
    <!--<li id="cat" style="display:none;"><a href="#contentcatpart">Content Categories</a></li>-->
  </ul>
  <div id="contentpart">
    <p class="tabloader" style="display:none;"></p>
    <div id="content_html">
		<?php 
			echo $this->element("serviceimages");
		?>
	</div>
  </div>
  <!--<div id="contentcatpart">
	<p class="tabloader" style="display:none;"></p>
    <div id="content_cat_form"></div>
  </div>-->
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "cat")
				{
					$('.tabloader').show();
					$('#content_jsp_cat_form').html('');
					fnGetContentCategoryForm('0');
					/*if($('#contentcategoryform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetContentCategoryForm();
					}
				}
				
				if(strNewTab == "jbsearchcat")
				{
					$('.tabloader').show();
					$('#content_cat_form').html('');
					fnGetContentCategoryForm("1");
					/*if($('#contentcategoryform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetContentCategoryForm();
					}
				}
				
				if(strNewTab == "contentparent")
				{
					if($('#contentparentform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetParentContentForm();
					}
				}
			}
		});
	});
</script>


*/?>