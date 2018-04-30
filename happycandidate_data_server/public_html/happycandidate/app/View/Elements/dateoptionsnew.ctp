<?php
	$strEnd = date("Y");
	$strHtm = "";
	for($i=1950;$i<=$strEnd;$i++)
	{
		if($i == "2000")
		{
			$strHtm .= trim('<option value="'.$i.'" selected="selected">'.$i.'</option>');
		}
		else
		{
			$strHtm .= trim('<option value="'.$i.'">'.$i.'</option>');
		}
	}
	echo $strHtm;
?>