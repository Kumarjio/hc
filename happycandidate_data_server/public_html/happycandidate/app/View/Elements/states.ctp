<?php
	if($intWithHtml)
	{
		?>
			<div class="form-group">
				<label for="state" class="control-label col-xs-12 col-sm-12 col-md-4">State:</label><!--
				--><?php 
					echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','label'=>false,'div'=>false,'style'=>'font-size:90%;','options'=>$arrStateList));
				?>
			</div>
			<div id="city" class="form-group">
				<label for="city" class="control-label col-xs-12 col-sm-12 col-md-4">City:</label><!--
				--><?php 
						echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','div'=>false,'label'=>false,'options'=>$arrCityList));
					?>
			</div>
			<!--<li style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>State / Province / Region:</label>
				<?php 
					echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','label'=>false,'div'=>false,'style'=>'font-size:90%;','options'=>$arrStateList));
				?>
			</li>
			<li id="city" style="width:30%;display:inline-block;margin-right:3%;" class="advance_search"><label>City / Town:</label>
				<?php 
					echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','div'=>false,'label'=>false,'options'=>$arrCityList));
				?>
			</li>-->
		<?php
	}
	else
	{
		?>
			<tr>
					<td><span id="madatsym" class="madatsym">*</span>State / Province / Region:</td>
					<td>
						<?php 
							echo $this->Form->input('User.state', array('div'=>false,'label'=>false,'onChange'=>'fnGetCityList(this.value)','style'=>'font-size:90%;','options'=>$arrStateList));
						?>
					</td>
			</tr>
			<tr id="city">
					<td>City:</td>
					<td>
						<?php 
							echo $this->Form->input('User.city', array('div'=>false,'label'=>false,'style'=>'font-size:90%;','options'=>$arrCityList));
						?>
					</td>
			</tr>
		<?php
	}
?>