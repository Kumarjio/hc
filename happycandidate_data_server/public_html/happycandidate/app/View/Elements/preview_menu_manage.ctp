<div id="dialog-form" title="Manage Menus" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->
	<div>&nbsp;</div>
	<div align='center' style="font-weight:bold;">Menu Details</div>
	<div>&nbsp;</div>
	<div id="menutablepostmessages" class="" style="width:95%;display:none;"></div>
	<div>&nbsp;</div>
	<table width="70%">
	<tr>
		<td colspan="3" align="right"><span style="cursor:pointer;font-weight:bold;" onclick="fnShowMenuForm()">Add Menu</span></td>
	</tr>
	<tr style="height:20px;">
		<!--<th align="left" style="font-weight:bold;">Sr.No.</th>-->
		<th align="left" style="font-weight:bold;">Menu Name</th>
		<th align="left" style="font-weight:bold;">Action</th>
	</tr>
	<tbody id="menu_rows">
	<?php
		$intForMenuCount = 0;
		if(is_array($arrPortalMenuDetail) && (count($arrPortalMenuDetail)>0))
		{
			foreach($arrPortalMenuDetail as $arrPortalMenu)
			{
				$intForMenuCount++;
				?>
					<tr id="menu_row_<?php echo $arrPortalMenu['TopMenu']['career_portal_menu_alloc_id'];?>">
						<!--<td><?php echo $intForMenuCount; ?></td>-->
						<td><span style="display:none;" id="menu_page_<?php echo $arrPortalMenu['TopMenu']['career_portal_menu_alloc_id']; ?>"><?php echo $arrPortalMenu['TopMenu']['career_portal_menu_page_id']; ?></span><span id="menu_name_<?php echo $arrPortalMenu['TopMenu']['career_portal_menu_alloc_id']; ?>"><?php echo $arrPortalMenu['TopMenu']['career_portal_menu_name']; ?></span></td>
						<td><span style="cursor:pointer;" onclick="fnEditMenu(<?php echo $arrPortalMenu['TopMenu']['career_portal_menu_alloc_id'];?>)">Edit</span> &nbsp; <span style="cursor:pointer;" onclick="fnDeleteMenu(<?php echo $arrPortalMenu['TopMenu']['career_portal_menu_alloc_id']; ?>)" >Delete</span></td>
					</tr>
				<?php
			}
			?>
			<?php
		}
	?>
	<span id="num_rows" style="display:none;"><?php echo $intForMenuCount; ?></span>
	</tbody>
	</table>
	
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div id="menuformdiv" style="display:none;">
	<div align="center" style="font-weight:bold;">Menu Form</div>
	<div>&nbsp;</div>
	<form id="menuform">
		<fieldset>
			<div id="postmenumessages" class="" style="width:95%;display:none;"></div>
			<span id="menuloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
			<div>&nbsp;</div>
			<label for="menu_name">Menu Name</label>
			<div>&nbsp;</div>
			<input type="text" name="menu_name" id="menu_name" class="text ui-widget-content ui-corner-all" />
			<input type="hidden" name="menu_id" id="menu_id" value="" class="text ui-widget-content ui-corner-all" />
			<div id="menunameerror" class="ui-state-error" style="width:95%;display:none;"></div>
			<div>&nbsp;</div>
			<label for="menu_page">Menu Page</label>
			<div>&nbsp;</div>

			<select id="menu_page" name="menu_page" class="text ui-widget-content ui-corner-all">
			<option value="">-- Select Page--</option>
			<?php
				foreach($arrPortalPageDetailList as $arrMenuPageKey => $arrMenuPageValue)
				{
					?>
						<option value="<?php echo $arrMenuPageKey; ?>"><?php echo $arrMenuPageValue; ?></option>
					<?php
				}
			?>
			</select>
			OR
			<a onclick="fnShowPageAddSection('1')" href="javascript:void(0);" style="color:blue;text-decoration:underline;">Create Page For Menu Linking</a>
			<div id="menupageerror" class="ui-state-error" style="width:95%;display:none;"></div>
		</fieldset>
	</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#menu_rows').children('tr').css('cursor','move');
		$('#menu_rows').children('tr').css('height','20');
		
		$('#menu_rows').sortable({
			update: function(event, ui) {
				//alert("Hello");
				var idsInOrder = $('#menu_rows').sortable("toArray");
				var result = fnUpdateMenuOrder(idsInOrder);
			}
		
		});
		
		$('#menu_name').focus(function () {
				$('#postmenumessages').fadeOut('slow');
				$('#menunameerror').fadeOut('slow');
				$('#menupageerror').fadeOut('slow');
		});
		
		$('#menu_page').focus(function () {
				$('#postmenumessages').fadeOut('slow');
				$('#menunameerror').fadeOut('slow');
				$('#menupageerror').fadeOut('slow');
		});
		
		$( "#dialog-form" ).dialog({
				autoOpen: false,
				height: 490,
				width: 500,
				modal: true,
				buttons: {
					"Change": function() {
						$('#postmenumessages').text("");
						$('#menunameerror').text("");
						$('#menupageerror').text("");
						
						var strMenuName = $('#menu_name').val();
						var strMenuPage = $('#menu_page').val();
						var strMenuId = $('#menu_id').val();
						
						if(strMenuName == "")
						{
							strErrorMessage = "Please Provide Menu Name.";
							$('#menunameerror').text("");
							$('#menunameerror').text(strErrorMessage);
							$('#menunameerror').fadeIn('slow');
							return false;
						}
						else
						{
							if(strMenuPage == "")
							{
								strErrorMessage = "Please Select Page for Menu.";
								$('#menupageerror').text("");
								$('#menupageerror').text(strErrorMessage);
								$('#menupageerror').fadeIn('slow');
								return false;
							}
							else
							{
								$('#menuloader').show();
								var menuurl = "<?php echo Router::url('/', true).$this->params['controller']."/managemenu/".$this->params['pass']['0'];?>";
								var menutype = "POST";
								var menuoptions = { 
									beforeSubmit:  function(formData, jqForm, options) {
									},
									success:function(responseText, statusText, xhr, $form) {
										//alert(responseText);
										if(responseText.status == "success")
										{
											$('#menuloader').hide();
											$('#postmenumessages').text('');
											$('#postmenumessages').removeClass('ui-state-error');
											$('#postmenumessages').addClass('ui-state-success');
											$('#postmenumessages').text(responseText.message);
											$('#postmenumessages').fadeIn('slow');
											
											if(strMenuId != "")
											{
												
												$('#menu_name').val('');
												$('#menu_page option[value=""]').attr('selected', 'selected');
												$('#menu_id').val('');
												
												$('#portal_menu_'+strMenuId).text('');
												$('#portal_menu_'+strMenuId).text(strMenuName);
												$('#portal_menu_'+strMenuId).prop('href',responseText.menulink);
												
												
												$('#menu_name_'+strMenuId).text('');
												$('#menu_name_'+strMenuId).text(strMenuName);
												$('#menu_page_'+strMenuId).text(strMenuPage);
											}
											
											if(strMenuId == "")
											{
												$('#menu_name').val('');
												$('#menu_page option[value=""]').attr('selected', 'selected');
												$('#menu_id').val('');
												
												
												
												var strPortalMenuHtml = "<li id='menu_li_"+responseText.menu_id+"'><a id='portal_menu_'"+responseText.menu_id+" href='"+responseText.menu_link+"' class='home-icon'>"+strMenuName+"</a></li>";
												$('#menusection').append(strPortalMenuHtml);
													
												var intNewRowCnt = parseInt($('#num_rows').text());
												intNewRowCnt++;
												//var strNewMenuHtml = "<tr id='menu_row_"+responseText.menu_id+"'><td>"+intNewRowCnt+"</td><td><span style='display:none;' id='menu_page_'"+responseText.menu_id+">"+strMenuPage+"</span><span id='menu_name_'"+responseText.menu_id+">"+strMenuName+"</span></td><td><span  style='cursor:pointer;' onclick='fnEditMenu("+responseText.menu_id+")'>Edit</span> &nbsp; <span style='cursor:pointer;' onclick='fnDeleteMenu("+responseText.menu_id+")' >Delete</span></td></tr>";
												var strNewMenuHtml = "<tr style='cursor:move;height:20px;' id='menu_row_"+responseText.menu_id+"'><td><span style='display:none;' id='menu_page_"+responseText.menu_id+"'>"+strMenuPage+"</span><span id='menu_name_"+responseText.menu_id+"'>"+strMenuName+"</span></td><td><span  style='cursor:pointer;' onclick='fnEditMenu("+responseText.menu_id+")'>Edit</span> &nbsp; <span style='cursor:pointer;' onclick='fnDeleteMenu("+responseText.menu_id+")' >Delete</span></td></tr>";
												$('#menu_rows').append(strNewMenuHtml);
												$('#num_rows').text(intNewRowCnt);
												$('#add_menus_option').hide();
												
												
												
											}
										}
										else
										{
											$('#menuloader').hide();
											$('#postmenumessages').text('');
											$('#postmenumessages').removeClass('ui-state-success');
											$('#postmenumessages').addClass('ui-state-error');
											$('#postmenumessages').text(responseText.message);
											$('#postmenumessages').fadeIn('slow');
										}
										
									},								
									url:       menuurl,         // override for form's 'action' attribute 
									type:      menutype,        // 'get' or 'post', override for form's 'method' attribute 
									dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
								}
								$('#menuform').ajaxSubmit(menuoptions); 
					 
								// !!! Important !!! 
								// always return false to prevent standard browser submit and page navigation 
								return false; 
							}
						}
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				},
				close: function() {
					
				}
			});
	});

</script>