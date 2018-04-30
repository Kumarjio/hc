<?php
	if(is_array($arrWebinarsDetails) && (count($arrWebinarsDetails)>0))
	{
		echo $this->element('webinars_search_main');
		?>
			<br class="clear"/>
				<div class="content-info">
					<div class="wrapper">		
						<ul class="service-con">
								<?php
									$strCourseName = '[';
									$intForIterateCount = 0;
									foreach($arrWebinarsDetails as $arrCourse)
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
											<li><h3>Webinars - <a href="<?php echo $strCoursePageUrl; ?>"><?php echo $objCourse->fullname; ?></a></h3>
											<label></label>
											<p><?php echo $objCourse->summary;?></p>
										<?php
									}
									$strCourseName .= ']';
								?>
							</li>
						</ul>
					</div>
				<br class="clear"/>
			</div>
		<?php
	}
?>
<script type="text/javascript">
	$(document).ready(function () {
		
		
		var availableWebinarTags = <?php echo $strCourseName; ?>
		
		$("#webinar_name").autocomplete({
			source: availableWebinarTags
		});
	});
</script>