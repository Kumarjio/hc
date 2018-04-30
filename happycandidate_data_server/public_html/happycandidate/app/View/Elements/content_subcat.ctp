<?php
	if(is_array($arrSubCatList) && (count($arrSubCatList)>0))
	{
		foreach($arrSubCatList as $arrSubCat)
		{
			$strSubCatModifiedName = str_replace(" ","_",strtolower($arrSubCat['Categories']['content_category_name']));
			$strSubCatModifiedName = str_replace("&","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace("/","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace("(","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace(")","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace(",","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace(".","",$strSubCatModifiedName);
			$strSubCatModifiedName = str_replace(";","",$strSubCatModifiedName);
			
			?>
				<?php
					
					if(isset($arrCatAssigned) && (is_array($arrCatAssigned) && (count($arrCatAssigned)>0)))
					{			
						if(in_array($arrSubCat['Categories']['content_category_id'],$arrCatAssigned))
						{
							?>
								<div class="nopadding nomargin"><input checked="checked" type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>','<?php echo $strParentElementId; ?>')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrSubCat['Categories']['content_category_id'];?>" /> <?php echo $arrSubCat['Categories']['content_category_name'];?>
								<input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrSubCat['Categories']['content_category_has_child']; ?>" />
								<!--<input type="hidden" name="<?php echo $strParentElementId;?>_parent_category_present" id="product_parent_category_present" value="" />-->
								<div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="nopadding nomargin subcategories"></div></div>
							<?php
						}
						else
						{
							?>
								<div class="nopadding nomargin"><input type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>','<?php echo $strParentElementId; ?>')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrSubCat['Categories']['content_category_id'];?>" /> <?php echo $arrSubCat['Categories']['content_category_name'];?>
								<input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrSubCat['Categories']['content_category_has_child']; ?>" />
								<!--<input type="hidden" name="<?php echo $strParentElementId;?>_parent_category_present" id="product_parent_category_present" value="" />-->
								<div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="nopadding nomargin subcategories"></div></div>
							<?php
						}
					}
					else
					{
						?>
							<div class="nopadding nomargin"><input type="checkbox" onclick="fnRegisterLoadSubCategory('<?php echo $strSubCatModifiedName; ?>','<?php echo $strParentElementId; ?>')" name="<?php echo $strSubCatModifiedName; ?>" id="<?php echo $strSubCatModifiedName; ?>" class="category" value="<?php echo $arrSubCat['Categories']['content_category_id'];?>" /> <?php echo $arrSubCat['Categories']['content_category_name'];?>
							<input type="hidden" name="<?php echo $strSubCatModifiedName; ?>_sub_category_present" id="<?php echo $strSubCatModifiedName; ?>_sub_category_present" value="<?php echo $arrSubCat['Categories']['content_category_has_child']; ?>" />
							<!--<input type="hidden" name="<?php echo $strParentElementId;?>_parent_category_present" id="product_parent_category_present" value="" />-->
							<div id="<?php echo $strSubCatModifiedName; ?>_subcat" class="nopadding nomargin subcategories"></div></div>
						<?php
					}
				?>
			<?php
		}
	}
?>