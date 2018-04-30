<div id="dialog-add-page-form" title="Add Page" style="display:none;">
	<!--<p class="validateTips">All form fields are required.</p>-->

	<form id="addpageform">
		<?php
			if(is_array($arrPortalPageDetail) && (count($arrPortalPageDetail)>0))
			{
				?>
					<fieldset>
						<div id="postaddpagemessages" class="" style="width:95%;display:none;"></div>
						<span id="addpageloader" style="display:none;"><img src='<?php echo Router::url('/', true);?>img/loader.gif'/></span>
						<div>&nbsp;</div>
						<label for="add_page_content">Page Template</label><br />
						<div>&nbsp;</div>
						<select onchange="fnGetPageTemplate(this)" name="page_template" class="text ui-widget-content ui-corner-all" id="page_template">
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
						<label for="add_page_name">Page Title</label>
						<div>&nbsp;</div>
						<input type="text" name="add_page_name" id="add_page_name" class="text ui-widget-content ui-corner-all" />
						<input type="hidden" value="<?php echo base64_encode($arrPortalPageDetail['0']['PortalPages']['career_portal_id'])?>" name="portid" id="portid" />
						<div id="addpagenameerror" class="ui-state-error" style="width:95%;display:none;"></div>
						<div>&nbsp;</div>
						<div>&nbsp;</div>
						<label for="add_page_content">Page Content</label><br />
						<div>&nbsp;</div>
						<textarea name="add_page_content" id="add_page_content" class="text ui-widget-content ui-corner-all" rows="7" cols="48"></textarea>
						<div>&nbsp;</div>
						<div id="addpagecontenterror" class="ui-state-error" style="width:95%;display:none;"></div>
					</fieldset>
				<?php
			}
		?>
	</form>
</div>
<?php
		echo $this->Html->script('tinymce/tiny_mce');
?>
<script type="text/javascript">
function fnGetPageTemplate(ele)
{
	var intPageTemplateId = $(ele).val();
	
	if(intPageTemplateId != 0)
	{
		$('#addpageloader').show();
		$.ajax({
				type: "GET",
				url: appBaseU+"privatelabelsites/gettemplatecontent/"+intPageTemplateId,
				dataType: 'json',
				success: function(data)
				{
					//alert(data.status);
					if(data.status == "success")
					{
						$('#add_page_name').val(data.templatetitle);
						tinymce.editors[0].setContent(data.templatecontent);
						$('#addpageloader').hide();
					}
					else
					{
						$('#addpageloader').hide();
						$('#postaddpagemessages').text('');
						$('#postaddpagemessages').addClass('ui-state-error');
						$('#postaddpagemessages').text(responseText.message);
						$('#postaddpagemessages').fadeIn('slow');
					}
				}
		});
	}
	else
	{
		$('#add_page_name').val("");
		tinymce.editors[0].setContent("");
	}
}


$(document).ready(function () {
	$('#page_name').focus(function () {
			$('#addpagenameerror').fadeOut('slow');
			$('#addpagecontenterror').fadeOut('slow');
			$('#postaddpagemessages').fadeOut('slow');
	});
	
	$('#add_page_content').focus(function () {
			$('#addpagenameerror').fadeOut('slow');
			$('#addpagecontenterror').fadeOut('slow');
			$('#postaddpagemessages').fadeOut('slow');
	});
		
	$( "#dialog-add-page-form" ).dialog({
			autoOpen: false,
			height: 590,
			width: 710,
			modal: true,
			buttons: {
				"Save": function() {
					$('#addpagenameerror').text("");
					$('#addpagecontenterror').text("");
					
					var strPagename = $('#page_name').val();
					/*var strPageContent = $('#add_page_content').val();*/
					//var strAddPageContent = tinyMCE.get('add_page_content').getContent();
					var strAddPageContent = tinyMCE.activeEditor.getContent();
					if(strPagename == "")
					{
						strErrorMessage = "Please Provide Page Name.";
						$('#addpagenameerror').text("");
						$('#addpagenameerror').text(strErrorMessage);
						$('#addpagenameerror').fadeIn('slow');
						return false;
					}
					else
					{
						$('#addpageloader').show();
						var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/addnewpage/".$this->params['pass']['0'];?>";
						var pagetype = "POST";
						var pageoptions = { 
							beforeSubmit:  function(formData, jqForm, options) {
								
								formData.push({name:'add_new_page_data', value:strAddPageContent});
							},
							success:function(responseText, statusText, xhr, $form) {
								//alert(responseText);
								if(responseText.status == "success")
								{
									$('#addpageloader').hide();
									$('#postaddpagemessages').text('');
									$('#postaddpagemessages').addClass('ui-state-success');
									$('#postaddpagemessages').text(responseText.message);
									$('#postaddpagemessages').fadeIn('slow');
									$strSelectPageOptionTag = "<option value='"+responseText.createdPageId+"'>"+responseText.createdpageName+"</option>";
									$('#menu_page').append($strSelectPageOptionTag);
									
									//var strTobeReturned = $("#dialog-add-page-form").data('returnvalue');
								}
								else
								{
									$('#addpageloader').hide();
									$('#postaddpagemessages').text('');
									$('#postaddpagemessages').addClass('ui-state-error');
									$('#postaddpagemessages').text(responseText.message);
									$('#postaddpagemessages').fadeIn('slow');
								}
								
							},								
							url:       pageurl,         // override for form's 'action' attribute 
							type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
							dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
						}
						$('#addpageform').ajaxSubmit(pageoptions);
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
