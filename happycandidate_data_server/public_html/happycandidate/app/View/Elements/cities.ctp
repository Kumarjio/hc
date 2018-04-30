<?php
	if($intWithHtml)
	{
		?>
			<label for="city" class="control-label col-xs-12 col-sm-12 col-md-4">City / Town:</label>
			<?php 
				echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','label'=>false,'div'=>false,'options'=>$arrCityList));
			?>
		<?php
	}
	else
	{
		?>
			<td>City:</td>
			<td>
				<?php 
					echo $this->Form->input('User.city', array('div'=>false,'label'=>false,'style'=>'font-size:90%;','options'=>$arrCityList));
				?>
			</td>
		<?php
	}
?>
