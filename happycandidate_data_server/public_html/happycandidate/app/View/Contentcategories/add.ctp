<div class="page-content-wrapper">
<div class="container-fluid">
	<div class="row">
	

		<div class=" steps-list">
			<div class="page-header">
				<h2>Add Content Categories</h2>
			
			</div>
			<div id="product_notification" class="index row"></div>
			<ul class="nav nav-pills tab-list">
				<li class="active">
					<a id="js-profile" data-toggle="pill" href="#tab-profile">Content Panel</a>
				</li>
			
				<li id="subcat" style="display:none;"><a href="#contentsubcatpart">Subcategories Panel</a></li>
			
			</ul>
			<div class="tab-content" style="padding-top: 20px;">
				<div id="tab-profile" class="tab-pane fade in active">
			
	<?php 
			//echo "Hello";
			echo $this->element("contentcat");
		?>
				</div>
						
			<div id="contentsubcatpart">
				<p class="tabloader" style="display:none;"></p>
				<div id="content_sub_cat_html">
					<?php 
						//echo "Hello";
						//echo $this->element("contentcat");
					?>
				</div>
				</div>
			</div>
			
		</div>
		
	</div>
	</div>
	</div>

<?php
/*<div class="index page-header row">
	<h1>Add Content Categories</h1>
	<!--<p class="lead">Here are the list of added contents</p>-->
</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
  <input type="hidden" name="content_cat_added" id="content_cat_added" value="" />
  <ul>
    <li><a href="#contentpart">Categories Panel</a></li>
    <li id="subcat" style="display:none;"><a href="#contentsubcatpart">Subcategories Panel</a></li>
  </ul>
  <div id="contentpart">
    <p class="tabloader" style="display:none;"></p>
    <div id="content_html">
		<?php 
			//echo "Hello";
			echo $this->element("contentcat");
		?>
	</div>
  </div>
  
 
</div>*/?>
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		$("#txtEditor").Editor(); 
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "subcat")
				{
					$('.tabloader').show();
					if($('#contentcatparentform').length >0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetParentCatContentForm();
					}
				}
			}
		});
	});
</script>

