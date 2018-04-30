<?php
	if(is_array($arrCoursesDetails) && (count($arrCoursesDetails)>0))
	{
		echo $this->element('elearning_search_main');
		
		?>
			<br class="clear"/>
			<div class="content-info">
				<div class="wrapper">		
					<ul class="service-con">
							<?php
								$strCourseName = '[';
								$intForIterateCount = 0;
								foreach($arrCoursesDetails as $arrCourse)
								{
									$intForIterateCount++;
									$objCourse = $arrCourse;
									$strCoursePageUrl = Router::url(array('controller'=>'candidates','action'=>'course',$intPortalId,$objCourse->id),true);
									if($intForIterateCount == 1)
									{
										$strCourseName .= '"'.$objCourse->fullname.'"';
									}
									else
									{
										$strCourseName .= ",".'"'.$objCourse->fullname.'"';
									}
									?>
										<li><h3>Elearning - <a href="<?php echo $strCoursePageUrl; ?>"><?php echo $objCourse->fullname; ?></a></h3>
										<label></label>
										<p><?php echo $objCourse->summary;?></p>
										</li>
									<?php
								}
								$strCourseName .= ']';
							?>
					</ul>
				</div>
				<br class="clear"/>
			</div>
		<?php
	
	}
?>
<script type="text/javascript">
	$(document).ready(function () {
		
		
		var availableTags = <?php echo $strCourseName; ?>
		
		$("#course_name").autocomplete({
			source: availableTags
		});
	});
</script>