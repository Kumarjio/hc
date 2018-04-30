<?php
	foreach($arrWebinarDetails as $arrCourse)
	{
		$objCourse = $arrCourse;
		$strCoursePageUrl = Router::url(array('controller'=>'candidates','action'=>'course',$intPortalId,$objCourse->id),true);
		?>
			<li><h3>Webinars - <a href="<?php echo $strCoursePageUrl; ?>"><?php echo $objCourse->fullname; ?></a></h3>
			<label></label>
			<p><?php echo $objCourse->summary;?></p>
			</li>
		<?php
	}
?>