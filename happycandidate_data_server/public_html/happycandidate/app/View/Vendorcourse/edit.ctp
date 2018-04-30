<div class="page-header row index">
	<h1>Edit Course</h1>
	<!--<p class="lead">Here are the list of added contents</p>-->
</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
	<input type="hidden" name="content_added" id="content_added" value="<?php echo $arrProductContent['0']['content']['content_id'];?>" />
	<!-- Nav tabs -->
	<ul>
	  <li><a href="#contentpart">Services Panel</a></li>
	  <!--<li id="cat"><a href="#contentcatpart">Content Categories</a></li>
	  <li id="jbsearchcat"><a href="#contentcatjsppart">Job Search Process</a></li>-->
	  <!--<li id="contentparent"><a href="#parent_content">Sub Content</a></li>-->
	</ul>
	<div id="contentpart">
		<p class="tabloader" style="display:none;"></p>
		<div id="content_html">
		<?php 
			echo $this->element("vendorservicecourse");
		?>
		</div>
	</div>
	<!--<div id="contentcatpart">
		<p class="tabloader" style="display:none;"></p>
		<div id="content_cat_form"></div>
	</div>
	<div id="parent_content">
		<p class="tabloader" style="display:none;"></p>
		<div id="parent_content_form"></div>
	</div>
	<div id="contentcatjsppart">
		<p class="tabloader" style="display:none;"></p>
		<div id="content_jsp_cat_form"></div>
	</div>-->
</div>
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {		
		
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		
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
					}*/
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
					}*/
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
        
        .formError{
            margin-top: 0px !important;
        }   
        
        .page-content-wrapper input {
            width: 32% !important;
        }
</style>