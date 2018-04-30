<div class="page-content-wrapper">
<div class="container-fluid">
	<div class="row">
	

		<div class="steps-list">
			<div class="page-header">
				<h2>Add Job Process Phase</h2>
				 <input type="hidden" name="content_cat_added" id="content_cat_added" value="" />
			</div>

			<ul class="nav nav-pills tab-list">
				<li class="active">
					<a id="js-phase" data-toggle="pill" href="#phasepart">SubStep Panel</a>
				</li>
				<li  id="subcat" style="display:none;">
					<a id="cat-tab" data-toggle="pill" href="#subcatpanel">Subcategories Panel</a>
				</li>
			</ul>
			<div class="tab-content" style="padding-top: 20px;">
				<div id="phasepart" class="tab-pane fade in active">
		 <?php 
		   	echo $this->element("contentcat");
	     ?>
				</div>
						
				<div id="subcatpanel" class="tab-pane fade">
						<div id="content_sub_cat_html"></div>
				</div>
				
			</div>
		</div>
		
	</div>
	</div>
	</div>
	
	
<?php /*
<div class="index page-header row">
	<h1>Add Job Process Sub Step</h1>
	<!--<p class="lead">Here are the list of added contents</p>-->
</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
  <input type="hidden" name="content_cat_added" id="content_cat_added" value="" />
  <ul>
    <li><a href="#contentpart">SubStep Panel</a></li>
    <li id="subcat" style="display:none;"><a href="#contentsubcatpart">Parent Step Panel</a></li>
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
  <div id="contentsubcatpart">
    <p class="tabloader" style="display:none;"></p>
    <div id="content_sub_cat_html">
		<?php 
			//echo "Hello";
			//echo $this->element("contentcat");
		?>
	</div>
  </div>
</div> <?php */ ?>
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#phase_desc_label').text("SubStep Description");
		$('#phase_icon_label').text("SubStep Icon");
		$('#phase_introtext_label').text("SubStep Into Text");
		$('#name_label').text("SubStep Name");
		$('#user_label').text("SubStep User");
		$('#cat_type').val("Substeps");
		$('#usercont').hide();
		$('#iconcont').hide();
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
						var strParentCat;
						if($('#cat_type').val() == "Steps")
						{
							strParentCat = "Phase";
						}
						if($('#cat_type').val() == "Substeps")
						{
							strParentCat = "Steps";
						}
						fnGetParentCatContentForm(strParentCat);
					}
				}
			}
		});
	});
</script>

<style>
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
</style>