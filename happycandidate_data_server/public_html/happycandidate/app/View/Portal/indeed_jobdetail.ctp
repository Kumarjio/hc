	<div class="container-fluid bg-lightest-grey">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				
				<div class="page-header">
					<a href="<?php echo Router::url('/', true)?>portal/index/<?php echo $intPortalId;?>" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span> Back to Jobs</a>
				</div>
				<div class="find-jobs-body">
					<div class="col-md-12">
						<div class="job-details-container">
							<?php // print_R($indeedresults);
							?>
							<h2><?php echo $indeedresults[0]['jobtitle']?></h2>
							
							<p class="job-details-subheader">
								<span>Full-time</span> - <?php echo $indeedresults[0]['formattedLocation']?> - Experienced level - Salary: $50k - Posted <?php echo $indeedresults[0]['formattedRelativeTime']?> - 357 views - <?php echo $indeedresults[0]['indeedApply']?> applicants
							</p>

							<hr>
							<div class="description-table-container">
								<table>
									<tr>
										
										<td>
											Date:
										</td>
										<td>
										<?php echo $indeedresults[0]['date'];?>
											
										</td>
									</tr>
								
								</table>
							</div>
							<hr>

							<?php echo $indeedresults[0]['snippet'];?>
							
							<div class="social-dropdown-container">
								<button class="btn btn-primary social-dropdown" id="social-dropdown">Share <span class="glyphicon glyphicon-chevron-down"></span></button>
							
								<script>
									$("#social-dropdown").click(function(e) {
										$(".social-dropdown-menu").css("display", "block");
										$(".social-dropdown-menu").css("position", "absolute");
										$(".social-dropdown-menu").css("bottom", "45px");
										$(".social-dropdown-menu").css("right", "0");

										$( "#social-dropdown-menu" ).mouseleave(function() {
											$(this).css("display", "none");
										});
									});
								</script>

								<div class="social-dropdown-menu" id="social-dropdown-menu">
									<ul>
										<li>
											<a href="#" class="social social-twitter">Share on Twitter</a>
										</li>
										<li>
											<a href="https://www.facebook.com/sharer.php?t='<?php  echo $indeedresults[0]['jobtitle'];?>'" class="social social-facebook">Share on Facebook</a>
										</li>
										<li>
											<a href="#" class="social social-linkedin">Share on LinkedIn</a>
										</li>
										<li>
											<a href="#" class="social social-email">Share by email</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

					</div>

			<!--		<div class="col-md-3">
						<div class="buttons-container">
							<button type="button" class="btn btn-primary btn-large">Apply Now <span class="glyphicon glyphicon-chevron-right"></span></button><br>
							<button type="button" class="btn btn-default btn-large"><span class="glyphicon glyphicon-heart"></span> Save Job</button>
						</div><br>
						<div class="actions-link-container">
							<a href="#" class="link-options">
								<span class="glyphicon glyphicon-plus"></span> Add Note &amp; Set Reminder
							</a>
						</div>
						<div class="job-details-info-block">
							<h3>Contact Information</h3>
						</div>
						
						<div class="job-search-options-container">
							
							<div class="job-details-description">
								<h4>Company name:</h4>
								<p>Hidentica</p>
								<hr>
								<h4>Contact name:</h4>
								<p>Anton</p>
								<hr>
								<h4>Telephone Number:</h4>
								<p>N/A</p>
								<hr>
								<h4>Site Link:</h4>
								<p><a href="#">http://hidentica.com</a></p>
							</div>
						</div>
					</div>
				--></div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
