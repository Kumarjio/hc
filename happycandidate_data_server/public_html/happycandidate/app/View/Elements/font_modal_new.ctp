<!-- Modal -->
<div id="fontNewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Font</h3>
				<input type="hidden" name="request_media_from" id="request_media_from" value="" />
			</div>
			<div class="modal-body media_modal col-md-12">
				<div class="alert alert-info fade" id="mssg" style="display:none;">
					<a href="#" class="close" aria-label="close">&times;</a>
				  <strong>Info! </strong><span id="mssgtext"></span>
				</div>
				<form id="fontform" name="fontform">
					<div class="form-group">
						<label>Font Size</label>
						<div class="col-md-12">
							<div class="col-md-3">
								Choose Size:
							</div>
							<div class="col-md-9">
								<select class="form-control" name="fontsize" id="fontsize">
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="14">14</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Font Style:</label>
						<div class="col-md-12">
							<div class="col-md-3">
								Calibri
							</div>
							<div class="col-md-9" style="font-family:calibri;">
								<input checked="checked" type="radio" name="font" id="font1" value="calibri" style="width:auto;height:auto;"/><span style="float:left;">Excellent option for a safe, universally readable font.  This font is the default Microsoft Word font and is familiar to most readers and renders well on computer screens.</span>
							</div>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-12">
							<div class="col-md-3">
								Arial
							</div>
							<div class="col-md-9" style="font-family:arial;">
								<input type="radio" name="font" id="font2" value="arial" style="width:auto;height:auto;" /> <span style="float:left;">Lines are clean and it's easy to read.  This font is a classic and has become a standard and  safe  choice.</span>
							</div>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-12">
							<div class="col-md-3">
								Garamond
							</div>
							<div class="col-md-9" style="font-family:garamond;">
								<input type="radio" name="font" id="font3" value="garamond" style="width:auto;height:auto;"  /> <span style="float:left;">This timeless typeface conveys "a sense of fluidity and delicacy, and has a simple elegance that looks polished in print or on computer screens.</span>
							</div>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-12">
							<div class="col-md-3">
								Georgia
							</div>
							<div class="col-md-9" style="font-family:georgia;">
								<input type="radio" name="font" id="font4" value="georgia" style="width:auto;height:auto;" />  <span style="float:left;">Traditional-looking alternative to the oft-overused Times New Roman, consider switching to the Georgia font. The font was designed to be read on screens and is available on computer screens</span>
							</div>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="col-md-12">
							<div class="col-md-3">
								Times New Roman
							</div>
							<div class="col-md-9" style="font-family:times new roman;">
								<input type="radio" name="font" id="font4" value="times" style="width:auto;height:auto;" /> <span style="float:left;">This universal font remains a popular résumé choice and is a safe choice and highly readable in print and on computer screens.</span>
							</div>
						</div>
						<input type="hidden" id="resumeid" name="resumeid" value="" />
						<input type="hidden" id="portalid" name="portalid" value="" />
						<input type="hidden" id="seekerid" name="seekerid" value="" />
						<!--<div class="col-md-12">
							Calibri<input type="radio" name="font" id="font1" value="calibri" style="width:auto;">asdads</input>
						</div>
						<div class="col-md-12">
							Arial <input type="radio" name="font" id="font2" value="arial" style="width:auto;">asdasdasd</input>
						</div>
						<div class="col-md-12">
							Garamond <input type="radio" name="font" id="font3" value="garamond" style="width:auto;">sdadsasd</input>
						</div>
						<div class="col-md-12">
							Georgia<input type="radio" name="font" id="font4" value="georgia" style="width:auto;">asdasdasd</input>
						</div>
						<div class="col-md-12">
							Times New Roman <input type="radio" name="font" id="font4" value="times" style="width:auto;">adasdasd</input>
						</div>-->
					</div>
				</form>
			</div>
			<?php
				//echo "---".$seekerid;
			?>
			<div class="modal-footer">
				<button class="btn btn-primary" onclick="return submitToResumeView('<?php echo $intPortalId?>','<?php echo $seekerid?>');">Open</button> &nbsp;
				
				<button class="btn btn-primary" onclick="return submitToResumeViewSaveFont('<?php echo $intPortalId?>','<?php echo $seekerid?>');">Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.close').click(function () {
			$('#mssg').hide();
		});
	});
</script>