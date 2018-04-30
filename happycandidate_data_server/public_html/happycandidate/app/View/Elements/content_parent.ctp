<script type="text/javascript">
	
	$(document).ready(function () {
		$('#add_parent').click(function () {
			fnSubmitParent();
			return false;
		});
	});
	
	function fnSubmitParent()
	{
		var strContentId = $('#content_added').val();
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
			var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/subcontent/";?>";
			var pagetype = "POST";
			var pageoptions = { 
				beforeSubmit:  function(formData, jqForm, options) {
					$('#parent_content_form').hide();
					$('.tabloader').show();
				},
				success:function(responseText, statusText, xhr, $form) {
					//alert(responseText);
					if(responseText.status == "success")
					{
						$('#parent_content_form').show();
						$('.tabloader').hide();
						$('#product_notification').html('');
						$('#current_parent_id').val($('#content_parent').val());
						$('#product_notification').html(responseText.message);
						$('#product_notification').fadeIn('slow');
					}
					else
					{
						$('#parent_content_form').show();
						$('.tabloader').hide();
						$('#content_parent').val('');
						$('#product_notification').html('');
						$('#product_notification').html(responseText.message);
						$('#product_notification').fadeIn('slow');
					}
					
				},								
				url:       pageurl,         // override for form's 'action' attribute 
				type:      pagetype,        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
			}
			$('#contentparentform').ajaxSubmit(pageoptions);
			return false;
		}
	}
</script>
<?php

	echo "hii";
	if(is_array($arrProductParentList) && (count($arrProductParentList)>0))
	{
		?>
		<form id="contentparentform" name="contentparentform" action="" method="post" role="form">
			<div class="row">
				<div class="col-md-12"><strong>Choose Parent Content<span style="color:red;">*</span>:</strong></div>
				<div class="col-md-9">
					<select class="form-control" name="content_parent" id="content_parent">
						<option value="">Choose a Parent</option>
					<?php
						foreach($arrProductParentList as $arrProductList)
						{
							if(isset($arrContentAllocatedParent) && ($arrContentAllocatedParent[0]['content']['content_parent_id']))
							{
								
								if($arrContentAllocatedParent[0]['content']['content_parent_id'] == $arrProductList['Content']['content_id'])
								{
									?>
										<option selected="selected" value="<?php echo $arrProductList['Content']['content_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Content']['content_title']);?></option>
									<?php
								}
								else
								{
									?>
										<option value="<?php echo $arrProductList['Content']['content_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Content']['content_title']);?></option>
									<?php
								}
							}
							else
							{
								?>
									<option value="<?php echo $arrProductList['Content']['content_id'];?>"><?php echo htmlspecialchars_decode($arrProductList['Content']['content_title']);?></option>
								<?php
							}
						}
					?>
					</select>
				</div>
				<input type="hidden" name="content_id" id="content_id"  value="<?php echo $strContentId;?>" />
				<?php
					if(isset($arrContentAllocatedParent) && ($arrContentAllocatedParent[0]['content']['content_parent_id']))
					{
						?>
							<input type="hidden" name="current_parent_id" id="current_parent_id"  value="<?php echo $arrContentAllocatedParent[0]['content']['content_parent_id'];?>" />
						<?php
					}
					else
					{
						?>
							<input type="hidden" name="current_parent_id" id="current_parent_id"  value="" />
						<?php
					}
				?>
				
			</div>
			<div class="row">
				<div class="col-md-12">&nbsp;</div>
				<div class="col-md-9"><input name="add_parent" id="add_parent" type="submit" value="Add"></input>&nbsp;<input name="cancel" id="cancel" type="reset" onclick="window.location='<?php echo $this->request->referer();?>'" value="Cancel"></input></div>
			</div>
		</form>
<?php
	}
?>