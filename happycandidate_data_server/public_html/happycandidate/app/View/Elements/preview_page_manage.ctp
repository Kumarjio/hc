<div id="dialog-page-form" title="Edit Home Page" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form id="pageform">
		<?php
			/*if(is_array($arrPortalPageDetail) && (count($arrPortalPageDetail)>0))
			{*/
				?>
					<fieldset>
						<div id="postpagemessages" class="" style="width:95%;display:none;"></div>
						<span id="pageloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
						<div>&nbsp;</div>
						<label for="add_page_content">Page Template</label><br />
						<div>&nbsp;</div>
						<select onchange="fnGetPageEditTemplate(this)" name="page_edit_template" class="text ui-widget-content ui-corner-all" id="page_edit_template">
							<option value="0">Custom</option>
							<?php
								foreach($arrPortalPageTemplates as $arrTemplate)
								{
									?>
										<option value="<?php echo $arrTemplate['Portalpagetemplates']['career_portal_page_template_id'];?>"><?php echo $arrTemplate['Portalpagetemplates']['career_portal_page_tittle'];?></option>
									<?php
								}
							?>
						</select>	
						<div>&nbsp;</div>
						<label for="page_name">Page Title</label>
						<div>&nbsp;</div>
						<input type="text" name="page_name" id="page_name" value="<?php echo $arrPortalPageDetail['0']['PortalPages']['career_portal_page_tittle'];?>" class="text ui-widget-content ui-corner-all" />
						<input type="hidden" value="<?php echo base64_encode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_id']."_".$arrPortalPageDetail['0']['PortalPages']['career_portal_id'])?>" name="pagedetail" id="pagedetail" />
						<input type="hidden" value="1" name="homepage" id="homepage" />
						<div id="pagenameerror" class="ui-state-error" style="width:95%;display:none;"></div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<label for="page_content">Page Content</label><br />
						<div>&nbsp;</div>
						<textarea name="page_content" id="page_content" class="text ui-widget-content ui-corner-all" rows="7" cols="48"><?php
								echo htmlspecialchars_decode($arrPortalPageDetail['0']['PortalPages']['career_portal_page_content']);
							?></textarea>
						<div>&nbsp;</div>
						<div id="pagecontenterror" class="ui-state-error" style="width:95%;display:none;"></div>
					</fieldset>
				<?php
			/*}
			else
			{*/
				?>
					<!--<fieldset>
						<div id="postpagemessages" class="" style="width:95%;display:none;"></div>
						<div>&nbsp;</div>
						<label for="add_page_content">Page Template</label><br />
						<div>&nbsp;</div>
						<select onchange="fnGetPageEditTemplate(this)" name="page_edit_template" class="text ui-widget-content ui-corner-all" id="page_edit_template">
							<option value="0">Custom</option>
							<?php
								/*foreach($arrPortalPageTemplates as $arrTemplate)
								{
									?>
										<option value="<?php echo $arrTemplate['Portalpagetemplates']['career_portal_page_template_id'];?>"><?php echo $arrTemplate['Portalpagetemplates']['career_portal_page_tittle'];?></option>
									<?php
								}*/
							?>
						</select>	
						<div>&nbsp;</div>
						<label for="page_name">Page Title</label>
						<div>&nbsp;</div>
						<input type="text" name="page_name" id="page_name" value="" class="text ui-widget-content ui-corner-all" />
						<input type="hidden" value="" name="pagedetail" id="pagedetail" />
						<input type="hidden" value="1" name="homepage" id="homepage" />
						<div id="pagenameerror" class="ui-state-error" style="width:95%;display:none;"></div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<label for="page_content">Page Content</label><br />
						<div>&nbsp;</div>
						<textarea name="page_content" id="page_content" class="text ui-widget-content ui-corner-all" rows="7" cols="48"></textarea>
						<div>&nbsp;</div>
						<div id="pagecontenterror" class="ui-state-error" style="width:95%;display:none;"></div>
					</fieldset>-->
					
				<?php
			//}
		?>
	</form>
</div>
<?php
		echo $this->Html->script('tinymce/tiny_mce');
?>
<script type="text/javascript">
function fnGetPageEditTemplate(ele)
{
	var intPageTemplateId = $(ele).val();
	
	if(intPageTemplateId != 0)
	{
		$('#pageloader').show();
		$.ajax({
				type: "GET",
				url: appBaseU+"privatelabelsites/gettemplatecontent/"+intPageTemplateId,
				dataType: 'json',
				success: function(data)
				{
					if(data.status == "success")
					{
						$('#page_name').val(data.templatetitle);
						tinymce.editors[1].setContent(data.templatecontent);
						$('#pageloader').hide();
					}
					else
					{
						$('#pageloader').hide();
						$('#postpagemessages').text('');
						$('#postpagemessages').addClass('ui-state-error');
						$('#postpagemessages').text(responseText.message);
						$('#postpagemessages').fadeIn('slow');
					}
				}
		});
	}
	else
	{
		$('#add_page_name').val("");
		tinymce.editors[1].setContent("");
	}
}
$(document).ready(function () {

	var strPageTemplate = '<?php echo $arrPortalPageDetail['0']['PortalPages']['career_portal_page_template'];?>';
	$('#page_edit_template').val(strPageTemplate);
	
	$('#page_name').focus(function () {
			$('#pagenameerror').fadeOut('slow');
			$('#pagecontenterror').fadeOut('slow');
			$('#postpagemessages').fadeOut('slow');
	});
	
	$('#page_content').focus(function () {
			$('#pagenameerror').fadeOut('slow');
			$('#pagecontenterror').fadeOut('slow');
			$('#postpagemessages').fadeOut('slow');
	});
		
	$( "#dialog-page-form" ).dialog({
			autoOpen: false,
			height: 590,
			width: 710,
			modal: true,
			buttons: {
				"Save": function() {
					$('#pagenameerror').text("");
					$('#pagecontenterror').text("");
					
					var strPagename = $('#page_name').val();
					/*var strPageContent = $('#page_content').val();*/
					var strPageContent = tinyMCE.activeEditor.getContent();
					
					if(strPagename == "")
					{
						strErrorMessage = "Please Provide Page Name.";
						$('#pagenameerror').text("");
						$('#pagenameerror').text(strErrorMessage);
						$('#pagenameerror').fadeIn('slow');
						return false;
					}
					else
					{
						$('#pageloader').show();
						var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/updatepagedata/".$arrPortalDetail['0']['Portal']['career_portal_id']?>";
						var pagetype = "POST";
						var pageoptions = { 
							beforeSubmit:  function(formData, jqForm, options) {
								formData.push({name:'page_data', value:strPageContent});
							},
							success:function(responseText, statusText, xhr, $form) {
								//alert(responseText);
								if(responseText.status == "success")
								{
									$('#pageloader').hide();
									$('#postpagemessages').text('');
									$('#postpagemessages').addClass('ui-state-success');
									$('#postpagemessages').text(responseText.message);
									$('#postpagemessages').fadeIn('slow');
									$('#page_title').text('');
									$('#page_title').text(strPagename);
									//alert(strPageContent);
									$('#page_content_div').html("");
									$('#page_content_div').html(strPageContent);
									if(responseText.pagedetail)
									{
										$('#pagedetail').val(responseText.pagedetail);
									}
								}
								else
								{
									$('#pageloader').hide();
									$('#postpagemessages').text('');
									$('#postpagemessages').addClass('ui-state-error');
									$('#postpagemessages').text(responseText.message);
								}
								
							},								
							url:       pageurl,         // override for form's 'action' attribute 
							type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
							dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
						}
						$('#pageform').ajaxSubmit(pageoptions);
						return false;
					}
				},
				"Add New Page": function() {
					$( this ).dialog( "close" );
					fnShowPageAddSection();
				},
				"Remove This Content": function() {
					$('#pagenameerror').text("");
					$('#pagecontenterror').text("");
					
					var strPagename = $('#page_name').val();
					var strPageContent = tinyMCE.activeEditor.getContent();
					if(strPagename == "")
					{
						strErrorMessage = "Please Provide Page Name.";
						$('#pagenameerror').text("");
						$('#pagenameerror').text(strErrorMessage);
						$('#pagenameerror').fadeIn('slow');
						return false;
					}
					else
					{
						$('#pageloader').show();
						var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/removeportalpage/".$arrPortalDetail['0']['Portal']['career_portal_id']?>";
						var pagetype = "POST";
						var pageoptions = { 
							beforeSubmit:  function(formData, jqForm, options) {
								formData.push({name:'page_data', value:strPageContent});
							},
							success:function(responseText, statusText, xhr, $form) {
								//alert(responseText);
								if(responseText.status == "success")
								{
									$('#pageloader').hide();
									$('#postpagemessages').text('');
									$('#postpagemessages').addClass('ui-state-success');
									$('#postpagemessages').text(responseText.message);
									$('#postpagemessages').fadeIn('slow');
									$('#page_title').text('');
									//alert(strPageContent);
									$('#page_content_div').html("");
									$('#page_name').val('');
									//alert(tinyMCE.activeEditor.getContent());
									tinyMCE.activeEditor.setContent('');
									//alert(tinyMCE.activeEditor.getContent());
									if(responseText.pagedetail)
									{
										$('#pagedetail').val(responseText.pagedetail);
									}
								}
								else
								{
									$('#pageloader').hide();
									$('#postpagemessages').text('');
									$('#postpagemessages').addClass('ui-state-error');
									$('#postpagemessages').text(responseText.message);
								}
								
							},								
							url:       pageurl,         // override for form's 'action' attribute 
							type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
							dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
						}
						$('#pageform').ajaxSubmit(pageoptions);
						return false;
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

tinyMCE.init({
		// General options
		mode : "textareas",
		editor_deselector : "basiceditor",
		elements : "elm1",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "<?php echo Router::url('/', true); ?>css/tinymce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/template_list.js",
		external_link_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/link_list.js",
		external_image_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/image_list.js",
		media_external_list_url : "<?php echo Router::url('/', true); ?>js/tinymce/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

</script>
