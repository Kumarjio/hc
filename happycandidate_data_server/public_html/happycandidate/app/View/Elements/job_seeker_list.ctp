<div class="form-group"  >
	<label class="control-label col-xs-12 col-sm-12 col-md-4" style="text-align:left;">Choose Users:</label><!--
	-->	
	<select name="users[]" id="users" multiple style="height:100px !important;">
		<option value="all">--All Seekers--</option>
		<?php
			if(is_array($arrRelatedProductList)  && (count($arrRelatedProductList)>0))
			{
				
				foreach($arrRelatedProductList as $arrPortalKey => $arrPortalName)
				{
					?>
						<option value="<?php echo $arrPortalName['Candidate']['candidate_id'];?>"><?php echo $arrPortalName['Candidate']['candidate_first_name']." ".$arrPortalName['Candidate']['candidate_last_name'];?></option>
					<?php
				}
			}
		?>
	</select>
</div>