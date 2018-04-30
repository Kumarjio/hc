<script type="text/javascript">
	
	$(document).ready(function () {
		$('#add_parent').click(function () {
			fnSubmitParent();
			return false;
		});
	});
	
	function fnSubmitParent()
	{
		var strContentId = $('#content_cat_added').val();
		if(strContentId == "")
		{
			$('#product_notification').html('');
			$('#product_notification').html('<div role="alert" class="alert-danger"><strong>Failed !</strong> You need to add content first</div>');
			return false;
		}
		var strCurrentLocation = window.location.href;
		var arrCurrentLocationDetail = strCurrentLocation.split("/");
		if(arrCurrentLocationDetail[(arrCurrentLocationDetail.length-1)] != "add")
		{
			$('#content_parent').removeClass('validate[required]');
		}
		var isValidated = $('#contentparentform').validationEngine('validate');
		//var isValidated = true;
		if(isValidated == false)
		{
		  return false;
		}
		else
		{ 
			var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/subcatcontent/";?>";
			var pagetype = "POST";
			var pageoptions = { 
				beforeSubmit:  function(formData, jqForm, options) {
					$('.cms-bgloader-mask').show();//show loader mask
					$('.cms-bgloader').show(); //show loading image
					$('#content_sub_cat_html').hide();
					$('.tabloader').show();
				},
				success:function(responseText, statusText, xhr, $form) {
					//alert(responseText);
					if(responseText.status == "success")
					{
						$('#content_sub_cat_html').show();
						$('.tabloader').hide();
						$('#product_notification').html('');
						$('#current_parent_cat_id').val($('#content_parent_cat').val());
						$('#product_notification').html(responseText.message);
						$('#product_notification').fadeIn('slow');
					}
					else
					{
						$('#content_sub_cat_html').show();
						$('.tabloader').hide();
						$('#content_parent_cat').val('');
						$('#product_notification').html('');
						$('#product_notification').html(responseText.message);
						$('#product_notification').fadeIn('slow');
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
					fnClearMessage();
					
				},								
				url:       pageurl,         // override for form's 'action' attribute 
				type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
			}
			$('#contentcatparentform').ajaxSubmit(pageoptions);
			return false;
		}
	}
</script>
<?php
	if(is_array($arrProductParentList) && (count($arrProductParentList)>0))
	{
		?>
		<form id="contentcatparentform" name="contentcatparentform" action="" method="post" role="form">
			<div class="row nopadding nomargin">
				<div class="col-md-12 nomargin"><strong>Choose Parent Category<span style="color:red;">*</span>:</strong></div>
				<div class="col-md-9">
					<select class="form-control" name="content_parent_cat" id="content_parent_cat">
						<option value="">Choose a Parent</option>
					<?php
						foreach($arrProductParentList as $arrProductList)
						{
							if(isset($arrContentAllocatedParent) && ($arrContentAllocatedParent[0]['content_category']['content_category_parent_id']))
							{
								
								if($arrContentAllocatedParent[0]['content_category']['content_category_parent_id'] == $arrProductList['Categories']['content_category_id'])
								{
									?>
										<option selected="selected" value="<?php echo $arrProductList['Categories']['content_category_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Categories']['content_category_name']);?></option>
									<?php
								}
								else
								{
									?>
										<option value="<?php echo $arrProductList['Categories']['content_category_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Categories']['content_category_name']);?></option>
									<?php
								}
							}
							else
							{
								?>
									<option value="<?php echo $arrProductList['Categories']['content_category_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Categories']['content_category_name']);?></option>
								<?php
							}
						}
					?>
					</select>
				</div>
				<input type="hidden" name="content_id" id="content_id"  value="<?php echo $strContentId;?>" />
				<?php
					if(isset($arrContentAllocatedParent) && ($arrContentAllocatedParent[0]['content_category']['content_category_parent_id']))
					{
						?>
							<input type="hidden" name="current_parent_cat_id" id="current_parent_cat_id"  value="<?php echo $arrContentAllocatedParent[0]['content_category']['content_category_parent_id'];?>" />
						<?php
					}
					else
					{
						?>
							<input type="hidden" name="current_parent_cat_id" id="current_parent_cat_id"  value="" />
						<?php
					}
				?>
				
			</div>
			<div class="row nopadding nomargin">
				<div class="col-md-12">&nbsp;</div>
				<div class="col-md-9"><input name="add_parent" id="add_parent" class="btn btn-lg btn-primary" type="submit" value="Add" ></input>&nbsp;<input name="cancel" id="cancel" class="btn btn-lg btn-primary" type="reset" onclick="window.location='<?php echo $this->Html->url('/', true);?>contentcategories'" value="Cancel"></input></div>
			</div>
		</form>
<?php
	}
?>