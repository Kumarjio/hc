<script type="text/javascript">
$(document).ready(function () {
	$('#add_category').click(function () {
		fnSubmitAssignCategory();
		return false;
	});
});


function fnSubmitAssignCategory()
{
	var strContentId = $('#content_added').val();
	if(strContentId == "")
	{
		$('#product_notification').html('');
		$('#product_notification').html('<div role="alert" class="alert-danger"><strong>Failed !</strong> You need to add product first</div>');
		return false;
	}
	var isValidated = $('#contentcategoryform').validationEngine('validate');
	//var isValidated = true;
	if(isValidated == false)
	{
	  return false;
	}
	else
	{ 
		var pageurl = "<?php echo Router::url('/', true).$this->params['controller']."/setcategory/";?>";
		var pagetype = "POST";
		var pageoptions = { 
			beforeSubmit:  function(formData, jqForm, options) {
				$('#content_cat_form').hide();
				$('.cms-bgloader-mask').show();//show loader mask
				$('.cms-bgloader').show(); //show loading image
			},
			success:function(responseText, statusText, xhr, $form) {
				//alert(responseText);
				if(responseText.status == "success")
				{
					$('#content_cat_form').show();
					$('.tabloader').hide();
					$('#product_notification').html('');
					$('#product_notification').html(responseText.message);
					$('#product_notification').fadeIn('slow');
				}
				else
				{
					$('#content_cat_form').show();
					$('.tabloader').hide();
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
		$('#contentcategoryform').ajaxSubmit(pageoptions);
		return false;
	}
}
</script>
<form id="contentcategoryform" name="contentcategoryform" action="" method="post" role="form">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9">
                <div class="col-md-12"><strong>Choose Categories:</strong></div>
                <div class="col-md-12">
                    <p id="cat_loader"></p>
                    <div class="catcontainer">
                        <?php
                        if (is_array($arrCatList) && (count($arrCatList) > 0)) {
                            foreach ($arrCatList as $arrCat) {
                                $strSubCatModifiedName = str_replace(" ", "_", strtolower($arrCat['Categories']['content_category_name']));
                                $strSubCatModifiedName = str_replace("&", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace("/", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace("(", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace(")", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace(",", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace(".", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace(";", "", $strSubCatModifiedName);
                                $strSubCatModifiedName = str_replace("|", "", $strSubCatModifiedName);
                                ?>
                                <div class="nopadding nomargin category-chk">
                                    <?php
                                    if (isset($arrCatAssigned) && (is_array($arrCatAssigned)) && (count($arrCatAssigned) > 0)) {
                                        if (in_array($arrCat['Categories']['content_category_id'], $arrCatAssigned)) {
                                            ?>
                                            <input checked="checked" type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>','')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrCat['Categories']['content_category_id']; ?>" /><?php echo $arrCat['Categories']['content_category_name']; ?>
                                            <input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrCat['Categories']['content_category_has_child']; ?>" />
                                            <div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="subcategories nopadding nomargin"></div>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>', '')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrCat['Categories']['content_category_id']; ?>" /> <?php echo $arrCat['Categories']['content_category_name']; ?>
                                            <input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrCat['Categories']['content_category_has_child']; ?>" />
                                            <div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="subcategories nopadding nomargin"></div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <input type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>', '')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrCat['Categories']['content_category_id']; ?>" /> <?php echo $arrCat['Categories']['content_category_name']; ?> 
                                        <input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrCat['Categories']['content_category_has_child']; ?>" />
                                        <div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="subcategories nopadding nomargin"></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $intProductId; ?>"/>
            <input type="hidden" name="category_for" id="category_for"  value="product"/>
            <?php
            if (isset($arrCatAssigned) && (is_array($arrCatAssigned)) && (count($arrCatAssigned) > 0)) {
                $strSetCategories = implode(",", $arrCatAssigned) . ",";
                ?>
                <input type="hidden" name="maincategoryselected" id="maincategoryselected" value="<?php echo $strSetCategories; ?>" />
                <?php
            } else {
                ?>
                <input type="hidden" name="maincategoryselected" id="maincategoryselected" value="" />
                <?php
            }
            ?>
            <input type="hidden" name="defaultcategory" id="defaultcategory" value="4" /></div>
        <div class="col-md-9"><input name="add_category" id="add_category" type="submit" value="Assign Category" class="btn btn-success"></input>&nbsp;<input name="cancel" class="btn btn-default" id="cancel" type="reset" onclick="window.location = '<?php echo $this->request->referer(); ?>'" value="Cancel"></input></div>
    </div>
</form>

<style>
.category-chk input, select {
  height: auto !important;
}
.nopadding.nomargin.category-chk {
  margin-top: 25px;
  margin-left: 92px;
  margin-right: 92px;
  margin-bottom: 25px;
  /*padding: 16px 0 0 7px;*/
}
</style>