<?php
	echo $this->Html->script('portalpages_edit');
	echo $this->Html->script('tinymce/tiny_mce');
?>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		elements : "elm1",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
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
<!-- /TinyMCE -->
<div class="users index">
	<h2>Add Page</h2>
	<div style="height:20px;">
		&nbsp;
	</div>
	<?php 
		echo $this->Form->create('PortalPages',array('inputDefaults' => array(
																		'label' => false,
																		'div' => false,
																	  ),
												'type'=>'file'
											 )
								);
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th colspan="2">Basic Information</th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>Page Title:</td>
			<td>
				<?php
					echo $this->Form->input('portal_page_title',array('value'=>$arrPortalsPage['0']['PortalPages']['career_portal_page_tittle'],'style'=>'width:50%;font-size:90%;','type'=>'text','class'=>'validate[required]'));
				?>
			</td>
	</tr>
	<tr>
			<td>Page Content:</td>
			<td>
				<?php 
					echo $this->Form->input('portal_page_content',array('value'=>htmlspecialchars_decode($arrPortalsPage['0']['PortalPages']['career_portal_page_content']),'rows' => '5', 'cols' => '5','style'=>'width:50%;font-size:90%;','class'=>'validate[required]'));
				?>
				<?php echo $this->Form->hidden('portal_page_id',array('value'=>$portal_page_id));?>
			</td>
	</tr>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Update',
						'name' => 'update',
						'div' => array(
							'style' => 'padding-left:50%;',
						)
					);
					echo $this->Form->end($options);
				?>
			</td>
	</tr>
	</table>
</div>

<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Add Pages', array('action' => 'add',$portal_id)); ?></li>
		<li><?php echo $this->Html->link('Back', array('action' => 'index',$portal_id)); ?></li>
	</ul>
</div>