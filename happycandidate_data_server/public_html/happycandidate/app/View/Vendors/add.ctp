<?php /*<div class="index page-header row">
	<h1>Add Vendors</h1>
	<!--<p class="lead">Here are the list of added contents</p>-->
</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
  <input type="hidden" name="content_added" id="content_added" value="" />
  <ul>
    <li><a href="#contentpart">Vendors Panel</a></li>
	<li id="vcomp" style="display:none;"><a href="#vendorcompany">Company Detail</a></li>
	<li id="cat" style="display:none;"><a href="#contentcatpart">Vendors Content Panel</a></li>
  </ul>
  <div id="contentpart">
    <p class="tabloader" style="display:none;"></p>
    <div id="content_html">
		<?php 
			//echo "Hello";
			echo $this->element("vendors");
		?>
	</div>
  </div>
  <div id="contentcatpart">
	<p class="tabloader"></p>
    <div id="parent_content_form"></div>
  </div>
  <div id="vendorcompany">
	<p class="tabloader"></p>
    <div id="vendorcompanycontainer"></div>
  </div>
</div>
*/
?>
 <div class="page-content-wrapper">
	            <div class="container-fluid">
<div class="row">
			
			
			<div class="page-header">
					<h2>Vendors</h2>
					<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
				</div>

				<ul class="nav nav-pills tab-list">
					<li class="active">
						<a href="#tab-vendor-panel" data-toggle="pill" id="js-vendor-panel">Vendors Panel</a>
					</li>
					
					<li>
						<a href="#tab-content-panel" style="display:none;" data-toggle="pill" id="js-content-panel">Vendors Content Panel</a>
					</li>
					<li>
						<a href="#tab-company-detail" style="display:none;" data-toggle="pill" id="js-company-detail">Vendor Company Detail</a>
					</li>
				
				</ul>
				<div style="padding-top: 20px;" class="tab-content">
					<div class="tab-pane fade in active" id="tab-vendor-panel">
						<?php 
							echo $this->element("vendors");
						?>
						

					</div>
					
						
					<div class="tab-pane fade" id="tab-content-panel">
							<div id="parent_content_form"></div>
						</div>

				<div class="tab-pane fade" id="tab-company-detail">
							
							<div id="vendorcompanycontainer"></div>
					</div>
				
					
				</div>
		
			
		</div>
		</div>
		</div>
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		
		$("a[data-toggle='pill']").click(function() {
		   
		   var strNewTab = $(this).attr('id');
		
				if(strNewTab == "js-content-panel")
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
				
				if(strNewTab == "js-company-detail")
				{
					if($('#vendorcompanydetailform').length>0)
					{
						$('.tabloader').hide();
					}
					else
					{
						fnGetCompanyDetailForm();
					}
				}
			
		});
	});
</script>

<!--<style>
	.ui-tabs {
		position: relative;/* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
		padding: .2em;

	}
	.ui-tabs .ui-tabs-nav {
		margin: 0;
		padding: .2em .2em 0;
	}
	.ui-tabs .ui-tabs-nav li {
		list-style: none;
		float: left;
		position: relative;
		top: 0;
		margin: 1px .2em 0 0;
		border-bottom-width: 0;
		padding: 0;
		white-space: nowrap;
	}
	.ui-tabs .ui-tabs-nav .ui-tabs-anchor {
		float: left;
		padding: .5em 1em;
		text-decoration: none;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active {
		margin-bottom: -1px;
		padding-bottom: 1px;
	}
	.ui-tabs .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-state-disabled .ui-tabs-anchor,
	.ui-tabs .ui-tabs-nav li.ui-tabs-loading .ui-tabs-anchor {
		cursor: text;
	}
	.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-active .ui-tabs-anchor {
		cursor: pointer;
	}
	.ui-tabs .ui-tabs-panel {
		display: block;
		border-width: 0;
		padding: 1em 1.4em;
		background: none;
	}
	#mediacontainer {
		float:left;
		width:100%;
	}
	
	#tabs2 {
		float:left;
		width:100%;
	}
</style>-->