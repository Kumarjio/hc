<?php echo $strActionScript;?>
<style>
.ui-dialog{
	z-index:1000;
}
</style>
<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                     <h1>Add Service Updates</h1>
						  <div id="order_detail_action_container" class="order_display_fields pull-right" style="width:25%;"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" name="back" id="back" value="Back"></input></a></div>
						  
	<div id="product_notification" class="index row"><?php echo $strMessage;?></div>

  <input type="hidden" name="service_for_comment_id" id="service_for_comment_id" value="<?php echo $intOrderId;?>" />
   <ul class="nav nav-pills tab-list">
    <li id="updatedata" class="active"><a id="js-profile" data-toggle="pill" href="#content_html">Add Updates</a></li>
	
		
    <!--<li id="filepart"><a href="#file_part" id="uploadFiles" data-toggle="pill" >Add Files</a></li>-->
  </ul>
	<div class="tab-content" style="padding-top: 20px;">
					
    <p class="tabloader" style="display:none;"></p>

	<div id="content_html" class="tab-pane fade in active">
		<?php 
			//echo "Hello";
			echo $this->element("serviceupdates");
		?>
	</div>
 
  <div id="file_part" class="tab-pane fade">
    <p class="tabloader" ></p>
    <div id="file_html">
		<?php 
			//echo $this->element("serviceupdatesfiles");
		?>
	</div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php
	echo $this->element('assign_vendor_media_modal');
?>
<script type="text/javascript">
	$(document).ready(function () {
		/*$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
		$("#txtEditorContent").Editor(); 
		$( "#tabs" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "cat")
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
