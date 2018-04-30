<?php
	if(is_array($arrCoursesDetails) && (count($arrCoursesDetails)>0))
	{
		?>
			<div class="courses">
				<div class="wrapper">
					<h2 id="coursesh2">Training Programs</h2>
					<ul>
						<?php
							foreach($arrCoursesDetails as $arrCourse)
							{
								$objCourse = $arrCourse;
								$strCoursePageUrl = Router::url(array('controller'=>'candidates','action'=>'course',$intPortalId,$objCourse->id),true);
								?>
									<li><h3><a href="<?php echo $strCoursePageUrl; ?>"><?php echo $objCourse->fullname; ?></a></h3>
										<!--<label></label>-->
										<p><?php echo $objCourse->summary;?></p>
									</li>
								<?php
							}
						?>
					</ul>
				</div>
			</div>
		<?php
	}
?>