<!--Start Search -->
<?php
	if(isset($arrJcountry) && isset($arrJcategories) && isset($arrJobExperience))
	{
		if(isset($strHidden))
		{
			?>
				<div id="jopsearch-<?php echo $portal_id."_".$widget_id."_".$theme_id; ?>" class="jop_search" style="display:none;cursor:move;">
			<?php
		}
		else
		{
			?>
				<div id="jopsearch-<?php echo $portal_id."_".$widget_id."_".$theme_id; ?>" class="jop_search" style="cursor:move;">
			<?php
		}	
?>
					<div class="wrapper">
						<h2>Search</h2>
						<ul class="panel-2 margin-top-5">
							<li><label>Job Title, Keywords</label>
							<input type="text" name="keywords" id="keywords" placeholder="Job Title, Keywords" />
							</li>
							<li><label>Location</label>
							<input type="text" name="location" id="location" placeholder="City Name" />
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
							</li>
							<li>
								<input type="submit" value="Search"/>
							</li>
						</ul>
					</div>
				</div>
<?php
	}
?>