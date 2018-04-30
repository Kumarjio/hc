<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */


App::uses('Debugger', 'Utility');
if($forService)
{
	$strFileUploadUrl = Router::url(array('controller'=>'test','action'=>'uploadfile'),true)."?uploadfor=1";
	?>
		<script type="text/javascript">
			var uploadfor = '<?php echo $forService; ?>';
		</script>
	<?php
}
else
{
	$strFileUploadUrl = Router::url(array('controller'=>'test','action'=>'uploadfile'),true);
	?>
		<script type="text/javascript">
			var uploadfor = '';
		</script>
	<?php
}
?>
<?php
	echo $this->Html->script('/js/fileuploaderjs/main');
?>
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<?php
	//echo $this->Html->css('jqueryui/themes/base/jquery-ui');
	//echo $this->Html->css('fileuploadercss/jquery.fileupload-ui');
?>
<script type="text/javascript">
	var uploadfor = '';
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$( "#mediacontainer" ).tabs({
			beforeActivate: function( event, ui ) {
				var strNewTab = ui.newTab.attr('id');
				if(strNewTab == "existing")
				{
					$('.tabloader').show();
					fnExistingMediaContent();
				}
			}
		});
	});
</script>
<div id="mediacontainer" style="float:left;overflow:scroll;overflow-x:hidden;">
  <ul>
	<?php
		if($forService)
		{
			?>
				<li id="upload"><a href="#tabs-1">Upload File</a></li>
			<?php
		}
		else
		{
			?>
				<li id="upload"><a href="#tabs-1">Upload File</a></li>
				<li id="existing"><a href="#tabs2">Choose From Existing</a></li>
			<?php
		}
	?>
   
  </ul>
  <?php
		if($forService)
		{
			?>
				<div id="tabs-1">
					<p>
						<?php
							echo $this->Html->css('http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css');
							echo $this->Html->css('fileuploadercss/jquery.fileupload');
							echo $this->Html->css('fileuploadercss/jquery.fileupload-ui');
						?>
						<div class="col-md-12">
							<!-- The file upload form used as target for the file upload widget -->
							<form id="fileupload" action="<?php echo $strFileUploadUrl; ?>" method="POST" enctype="multipart/form-data">
								<!-- Redirect browsers with JavaScript disabled to the origin page -->
								<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
								<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
								<div class="row fileupload-buttonbar">
									<div class="col-md-12">
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="fileinput-button">
											<span>Add files...</span>
											<input type="file" name="files[]" multiple>
										</span>
										<button type="submit" class="start">Start upload</button>
										<button type="reset" class="cancel">Cancel upload</button>
										<!-- The global file processing state -->
										<span class="fileupload-process"></span>
									</div>
									<div>&nbsp;</div>
									<!-- The global progress state -->
									<div class="fileupload-progress fade" style="display:none">
										<!-- The global progress bar -->
										<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
										<!-- The extended global progress state -->
										<div class="progress-extended">&nbsp;</div>
									</div>
								</div>
								<!-- The table listing the files available for upload/download -->
								<table role="presentation" style="width:100%;"><tbody class="files"></tbody></table>
							</form>
							<!-- The template to display files available for upload -->
							<script id="template-upload" type="text/x-tmpl">
							{% for (var i=0, file; file=o.files[i]; i++) { %}
								<tr class="template-upload">
									<td>
										<span class="preview"></span>
									</td>
									<td>
										<p style="width:80%;" class="name wordwrap">{%=file.name%}</p>
										<strong class="error"></strong>
									</td>
									<td>
										<p class="size">Processing...</p>
										<div class="progress"></div>
									</td>
									<td>
										{% if (!i && !o.options.autoUpload) { %}
											<button class="start" disabled>Start</button>
										{% } %}
										{% if (!i) { %}
											<button class="cancel">Cancel</button>
										{% } %}
									</td>
								</tr>
							{% } %}
							</script>
							<!-- The template to display files available for download -->
							<script id="template-download" type="text/x-tmpl">
							{% for (var i=0, file; file=o.files[i]; i++) { %}
								<tr class="template-download ">
									<td>
										<span class="preview">
											{% if (file.thumbnailUrl) { %}
												<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
											{% } %}
										</span>
									</td>
									<td>
										<p style="width:80%;" class="name wordwrap">
											{% if (file.url) { %}
												<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
											{% } else { %}
												<span>{%=file.name%}</span>
											{% } %}
										</p>
										{% if (file.error) { %}
											<div><span class="label label-danger">Error</span> {%=file.error%}</div>
										{% } %}
									</td>
									<td style="width:25%;">
										<span class="size">{%=o.formatFileSize(file.size)%}</span>
									</td>
									<td>
										{% if (file.deleteUrl) { %}
											{% if (file.thumbnailUrl) { %}
												<a onclick="fnAssignMediaToContent('{%=file.thumbnailUrl%}','{%=file.id%}')" href="javascript:void(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> <span>Add</span></a>&nbsp;
												<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
													<i class="glyphicon glyphicon-trash"></i>
													<span>Delete</span>
												</button>
												<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
											{% } else { %}
												<a onclick="fnAssignMediaToContent('{%=file.url%}','{%=file.id%}')" href="javascript:void(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> <span>Add</span></a>&nbsp;
												<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
													<i class="glyphicon glyphicon-trash"></i>
													<span>Delete</span>
												</button>
												<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
											{% } %}
											<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
										{% } else { %}
											<button class="btn btn-warning cancel">
												<i class="glyphicon glyphicon-ban-circle"></i>
												<span>Cancel</span>
											</button>
										{% } %}
									</td>
								</tr>
							{% } %}
							</script>
						
						</div>
					</p>
				</div>
			<?php
		}
		else
		{
			?>
			<div id="tabs-1">
				<p>
					<?php
						echo $this->Html->css('http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css');
						echo $this->Html->css('fileuploadercss/jquery.fileupload');
						echo $this->Html->css('fileuploadercss/jquery.fileupload-ui');
					?>
					<div class="col-md-12">
						<!-- The file upload form used as target for the file upload widget -->
						<form id="fileupload" action="<?php echo $strFileUploadUrl; ?>" method="POST" enctype="multipart/form-data">
							<!-- Redirect browsers with JavaScript disabled to the origin page -->
							<noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
							<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
							<div class="row fileupload-buttonbar">
								<div class="col-md-12">
									<!-- The fileinput-button span is used to style the file input field as button -->
									<span class="fileinput-button">
										<span>Add files...</span>
										<input type="file" name="files[]" multiple>
									</span>
									<button type="submit" class="start">Start upload</button>
									<button type="reset" class="cancel">Cancel upload</button>
									<!-- The global file processing state -->
									<span class="fileupload-process"></span>
								</div>
								<div>&nbsp;</div>
								<!-- The global progress state -->
								<div class="fileupload-progress fade" style="display:none">
									<!-- The global progress bar -->
									<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
									<!-- The extended global progress state -->
									<div class="progress-extended">&nbsp;</div>
								</div>
							</div>
							<!-- The table listing the files available for upload/download -->
							<table role="presentation" style="width:100%;"><tbody class="files"></tbody></table>
						</form>
						<!-- The template to display files available for upload -->
						<script id="template-upload" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
							<tr class="template-upload ">
								<td>
									<span class="preview"></span>
								</td>
								<td>
									<p style="width:80%;" class="name wordwrap">{%=file.name%}</p>
									<strong class="error"></strong>
								</td>
								<td>
									<p class="size">Processing...</p>
									<div class="progress"></div>
								</td>
								<td>
									{% if (!i && !o.options.autoUpload) { %}
										<button class="start" disabled>Start</button>
									{% } %}
									{% if (!i) { %}
										<button class="cancel">Cancel</button>
									{% } %}
								</td>
							</tr>
						{% } %}
						</script>
						<!-- The template to display files available for download -->
						<script id="template-download" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
							<tr class="template-download ">
								<td>
									<span class="preview">
										{% if (file.thumbnailUrl) { %}
											<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
										{% } %}
									</span>
								</td>
								<td>
									<p style="width:80%;" class="name wordwrap">
										{% if (file.url) { %}
											<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
										{% } else { %}
											<span>{%=file.name%}</span>
										{% } %}
									</p>
									{% if (file.error) { %}
										<div><span class="label label-danger">Error</span> {%=file.error%}</div>
									{% } %}
								</td>
								<td style="width:25%;">
									<span class="size">{%=o.formatFileSize(file.size)%}</span>
								</td>
								<td>
									{% if (file.deleteUrl) { %}
										{% if (file.thumbnailUrl) { %}
											<a onclick="fnAssignMediaToContent('{%=file.thumbnailUrl%}','{%=file.id%}')" href="javascript:void(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> <span>Add</span></a>&nbsp;
											<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
												<i class="glyphicon glyphicon-trash"></i>
												<span>Delete</span>
											</button>
											<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
										{% } else { %}
											<a onclick="fnAssignMediaToContent('{%=file.url%}','{%=file.id%}')" href="javascript:void(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> <span>Add</span></a>&nbsp;
											<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
												<i class="glyphicon glyphicon-trash"></i>
												<span>Delete</span>
											</button>
											<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
										{% } %}
										<!--<input type="checkbox" name="delete" value="1" class="toggle">-->
									{% } else { %}
										<button class="btn btn-warning cancel">
											<i class="glyphicon glyphicon-ban-circle"></i>
											<span>Cancel</span>
										</button>
									{% } %}
								</td>
							</tr>
						{% } %}
						</script>
					
					</div>
				</p>
			</div>
		    <div id="tabs2" style="margin-bottom:20px;">
				<p class="tabloader"></p>
				<div id="existingmediacontent"></div>
			</div>
			<?php
		}
  ?>
</div>
<style>
	.modal-content {
		float:left;
	}
	
	.files audio {
		width:200px;
	}
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
</style>