<div id="dialog-widget-form" title="Manage Widgets" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->
	<div>&nbsp;</div>
	<div align='center' style="font-weight:bold;">Widgets Details</div>
	<div>&nbsp;</div>
	<div id="widgettablepostmessages" class="" style="width:95%;display:none;"></div>
	<div>&nbsp;</div>
	<table width="70%" style="border-collapse:separate;border-spacing:1px;">
	<tr style="height:20px;">
		<!--<th align="left" style="font-weight:bold;">Sr.No.</th>-->
		<th align="left" style="font-weight:bold;">Widget Name</th>
		<th align="left" style="font-weight:bold;">Action</th>
	</tr>
	<tbody id="widget_rows">
	<?php
		$intForWidgetCount = 0;
		if(is_array($arrPortalWidgets) && (count($arrPortalWidgets)>0))
		{
			foreach($arrPortalWidgets as $arrPortalWidget)
			{
				$intForWidgetCount++;
				?>
					<tr id="widget_row_<?php echo $arrPortalWidget['W']['widget_id'];?>">
						<!--<td><?php echo $intForWidgetCount; ?></td>-->
						<td><span id="widget_<?php echo $arrPortalWidget['W']['widget_id']; ?>"><?php echo $arrPortalWidget['W']['widget_name']; ?></span></td>
						<td>
							<?php
								
								$intWidgetId = $arrPortalWidget['W']['widget_id'];
								$intPortalId = $arrPortalDetail[0]['Portal']['career_portal_id'];
								$intPageId = $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'];
								$strWidgetName = $arrPortalWidget['W']['widget_name'];
								
								if($arrPortalWidget['PW']['career_portal_id'] == $arrPortalDetail[0]['Portal']['career_portal_id'] && $arrPortalWidget['PW']['career_portal_page_id'] == $arrPortalPageDetail[0]['PortalPages']['career_portal_page_id'])
								{
									
									?>
										<!--<span id="disable_widget_<?php echo $intWidgetId; ?>" style="cursor:pointer;color:blue;text-decoration:underline;" onclick="fnDisableWidget('<?php echo $intWidgetId; ?>','<?php echo $intPortalId; ?>','<?php echo $intPageId; ?>','<?php echo $strWidgetName; ?>','page')">Remove</span>--> &nbsp;
										<span id="enable_widget_<?php echo $intWidgetId; ?>" style="cursor:pointer;display:none;color:blue;text-decoration:underline;" onclick="fnEnableThemeWidget('<?php echo $intWidgetId; ?>','<?php echo $intPortalId; ?>','<?php echo $intPageId; ?>','<?php echo $strWidgetName; ?>','page')">Add</span> &nbsp;
									<?php
								}
								else
								{
									?>
										<!--<span id="disable_widget_<?php echo $intWidgetId; ?>" style="display:none;cursor:pointer;color:blue;text-decoration:underline;" onclick="fnDisableWidget('<?php echo $intWidgetId; ?>','<?php echo $intPortalId; ?>','<?php echo $intPageId; ?>','<?php echo $strWidgetName; ?>','page')">Remove</span>--> &nbsp;
										<span id="enable_widget_<?php echo $intWidgetId; ?>" style="cursor:pointer;color:blue;text-decoration:underline;" onclick="fnEnableThemeWidget('<?php echo $intWidgetId; ?>','<?php echo $intPortalId; ?>','<?php echo $intPageId; ?>','<?php echo $strWidgetName; ?>','page')">Add</span> &nbsp;
									<?php
								}
							?>
						</td>
					</tr>
				<?php
			}
			?>
			<?php
		}
	?>
	<span id="num_rows" style="display:none;"><?php echo $intForWidgetCount; ?></span>
	</tbody>
	</table>	
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#widget_rows').children('tr').css('height','20');

		
		$( "#dialog-widget-form" ).dialog({
				autoOpen: false,
				height: 300,
				width: 500,
				modal: true,
				buttons: {
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				},
				close: function() {
					
				}
			});
	});
function fnEnableThemeWidget(intWidgetId,intPortalId,intWidgetHolderId,strWName,strWidgetHolder)
{
	// alert(intWidgetId);
	//alert(intPortalId);
	
	//var strPortalBaseUrl = <?php echo Router::url('/', true)."employers/enablewidget/";?>;
	
	var datastr = "widgetid="+intWidgetId+"&widgetholderid="+intWidgetHolderId+"&widgetholder="+strWidgetHolder;
	
	$.ajax({ 
			type: "GET",
			url: "<?php echo Router::url('/', true)."employers/enablewidget/";?>"+intPortalId,
			dataType: 'json',
			data:datastr,
			success: function(data)
			{
				//alert(data.status);
				if(data.status == "success")
				{
					var strMessage = data.message;
					$('#widgettablepostmessages').text('');
					$('#widgettablepostmessages').addClass('ui-state-success');
					$('#widgettablepostmessages').text(strMessage);
					$('#widgettablepostmessages').fadeIn('slow');
					$('#enable_widget_'+intWidgetId).hide();
					$('#disable_widget_'+intWidgetId).show();
					if(strWName == "Job Search")
					{
						$('#jopsearch-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
					}
					else
					{
						if(strWName == "Latest Jobs")
						{
							$('#latestjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
						}
						else
						{
							if(strWName == "Highlighted Jobs")
							{
								$('#highlightedjobs-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
							}
							else
							{
								if(strWName == "Contact Us")
								{
									$('#contactus-'+intPortalId+"_"+intWidgetId+"_"+intWidgetHolderId).show();
								}
							}
						}
					}
				}
			}
	});
}
</script>