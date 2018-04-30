<div class="page-content-wrapper">
<div class="container-fluid">
	<div class="row">
	

		<div class="steps-list">
			<div class="page-header">
				<h2>Job Search Tracker</h2>
				<p>
					The following topics will help you stand out from job seekers competing for the same opportunity.
				</p>
			</div>
			<input type="hidden" name="content_added" id="content_added" value="<?php echo $arrProductContent['0']['content']['content_id'];?>" />
			<div id="product_notification"></div>
			<ul class="nav nav-pills tab-list">
				<li class="active">
					<a id="js-profile" data-toggle="pill" href="#tab-profile">Content Panel</a>
				</li>
				<li>
					<a id="cat-tab" data-toggle="pill" href="#tab_cat">Content Categories</a>
				</li>
				<li>
					<a id="jb-searchcat" data-toggle="pill" href="#tab_jsp_cat">Job Search Process</a>
				</li>
				
			
			</ul>
			<div class="tab-content" style="padding-top: 20px;">
				<div id="tab-profile" class="tab-pane fade in active">
			
		<?php 
			//echo "Hello";
			echo $this->element("content");
		?>
				</div>
						
				<div id="tab_cat" class="tab-pane fade">
						<div id="content_cat_form"></div>
				</div>
				<div id="tab_jsp_cat" class="tab-pane fade">
					<div id="content_jsp_cat_form"></div>
				</div>
			</div>
		</div>
		
	</div>
	</div>
	</div>

<!--<div class="page-header row index">
	<h1>Edit Content</h1>-->
	<!--<p class="lead">Here are the list of added contents</p>-->
<!--</div>
<div>&nbsp;</div>
<div id="product_notification" class="index row"><?php echo $strMessage;?></div>
<div class="index row nopadding" id="tabs">
	<input type="hidden" name="content_added" id="content_added" value="<?php echo $arrProductContent['0']['content']['content_id'];?>" />
	
	<ul>
	  <li><a href="#contentpart">Content Panel</a></li>
	  <li id="cat"><a href="#contentcatpart">Content Categories</a></li>
	  <li id="jbsearchcat"><a href="#contentcatjsppart">Job Search Process</a></li>
	  <!--<li id="contentparent"><a href="#parent_content">Sub Content</a></li>-->
	<!--</ul>
	<div id="contentpart">
		<p class="tabloader" style="display:none;"></p>
		<div id="content_html">
		<?php 
			//echo "Hello";
			//echo $this->element("content");
		?>
		</div>
	</div>
	<div id="contentcatpart">
		<p class="tabloader" style="display:none;"></p>
		<div id="content_cat_form"></div>
	</div>-->
	<!--<div id="parent_content">
		<p class="tabloader" style="display:none;"></p>
		<div id="parent_content_form"></div>
	</div>-->
	<!--<div id="contentcatjsppart">
		<p class="tabloader" style="display:none;"></p>
		
	</div>
</div>-->
<?php
	echo $this->element('assign_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
	/*$("#txtEditor").Editor(); 
	var content_intro_text = '<?php echo trim(stripslashes(htmlspecialchars_decode($arrProductContent['0']['content']['content_intro_text']))); ?>';
	$("#txtEditor").Editor("setText" , content_intro_text);
	$("#txtEditorContent").Editor();
	var content =  "<?php echo stripslashes(htmlspecialchars_decode($arrProductContent['0']['content']['content'])); ?>";
	$("#txtEditorContent").Editor("setText" , content);*/
			
	$("a[data-toggle='pill']").click(function() {
		   
		   var strNewTab = $(this).attr('id');
		   
		   if(strNewTab == "cat-tab")
		   {
				fnGetContentCategoryForm('0');
		   }
		   
		   if(strNewTab == "jb-searchcat")
		   {
		   	 fnGetContentCategoryForm("1");
		   }
		   
		  
		  
	   });
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
	/*	
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "cat")
				{
					$('.tabloader').show();
					$('#content_jsp_cat_form').html('');
					fnGetContentCategoryForm('0');
					
				}
				
				if(strNewTab == "jbsearchcat")
				{
					$('.tabloader').show();
					$('#content_cat_form').html('');
					fnGetContentCategoryForm("1");
					
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
		});*/
	});
</script>

<!--style>
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