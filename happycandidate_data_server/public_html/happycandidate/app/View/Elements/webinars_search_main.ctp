<!--Start Search -->
	<div class="col-md-3">
						<h2>Find Webinars</h2>
					</div>
					
					
				</div>
				<div class="find-jobs-body">
					<div class="col-md-3">
						<div class="job-search-options-container">
						<form role="form" name="webinar_search" id="webinar_search" method="post" >
										<div class="form-group">
								<label for="category">Title</label>
										<div class="inner-addon left-addon" style="width:100%;margin:0px;">
									<i class="glyphicon glyphicon-search"></i>
									<input type="text" placeholder="Ex. Resume / CV Tips" class="form-control" name="webinar_name" id="webinar_name">
								</div>
						</div>
								<div class="form-group">
									<label for="category">Category</label>
									<?php 
				echo $this->Form->input('category',array('label'=>false,'div'=>false,'id'=>'category','options'=>$arrCatDetail,'selected'=>'0','empty'=>'Select','class'=>'form-control'));
			?>		
								</div>
					
								<!--<div class="form-group">
									<label for="category">Date</label>
									<div class="checkbox-container">
										<input type="checkbox" checked="" value="">
										<p>Today <span>(2)</span></p>
									</div>
									<div class="checkbox-container">
										<input type="checkbox" value="">
										<p>This week <span>(56)</span></p>
									</div>
									<div class="checkbox-container">
										<input type="checkbox" value="">
										<p>This month <span>(200)</span></p>
									</div>
								</div>-->
								<div class="form-group">
								<button class="btn btn-primary btn-md-pad" type="button" onclick="return fnSearchPortalWebinars('<?php echo $intPortalId; ?>')">Search</button>
								</div>
							</form>
						</div>
					</div>
					
	<!--<div class="wrapper">
		<h2>Search</h2>
		<form name="webinar_search" id="webinar_search" method="post" action="" onsubmit="return false;">
		<ul class="panel-2 margin-top-5">
			<li><label>Webinar Name</label>
			<input type="text" name="webinar_name" id="webinar_name" placeholder="Webinar Name" value="" />
			</li>
			<li><label>Location</label>
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
			</li>
			<li>
				<input type="submit" value="Search" onclick="fnSearchPortalWebinars('<?php echo $intPortalId; ?>')"/>
			</li>
		</ul>
		</form>
	</div>
</div>-->