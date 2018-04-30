<?php
	$strEnd = date("Y");
	for($i=1950;$i<=$strEnd;$i++)
	{
		if($i == "2000")
		{
			?>
				<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
			<?php
		}
		else
		{
			?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php
		}
	}
?>