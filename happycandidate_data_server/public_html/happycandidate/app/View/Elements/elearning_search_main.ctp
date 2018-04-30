<!--Start Search -->
<?php
	if(isset($strHidden))
	{
		?>
			<div id="jop_search" class="jop_search" style="display:none;">
		<?php
	}
	else
	{
		?>
			<div id="jop_search" class="jop_search">
		<?php
	}
?>
	<div class="wrapper">
		<h2>Search</h2>
		<form name="training_material_search" id="training_material_search" method="post" action="" onsubmit="return false;">
		<ul class="panel-2 margin-top-5">
			<li><label>Course Name</label>
			<input type="text" name="course_name" id="course_name" placeholder="Course Name" value="" />
			</li>
			<!--<li><label>Location</label>
			<input type="text" name="location" id="location" placeholder="City Name" value="<?php echo $strlocation; ?>" />
			</li>
			<li><label>Country</label>
				<?php 
					echo $this->Form->input('txt_country',array('label'=>false,'div'=>false,'id'=>'txt_country','options'=>$arrJcountry,'selected'=>'IN'));
				?>
			</li>
			<li><label>Job Category</label>
			<?php 
				echo $this->Form->input('category',array('label'=>false,'div'=>false,'id'=>'category','options'=>$arrJcategories,'selected'=>'0'));
			?>
			</li>
			<li><label>Exp.</label>
			<?php 
				echo $this->Form->input('experience',array('label'=>false,'div'=>false,'id'=>'experience','options'=>$arrJobExperience,'selected'=>'0'));
			?>
			</li>-->
			<li>
				<input type="submit" value="Search" onclick="fnSearchPortalCourses('<?php echo $intPortalId; ?>')"/>
			</li>
		</ul>
		</form>
	</div>
</div>