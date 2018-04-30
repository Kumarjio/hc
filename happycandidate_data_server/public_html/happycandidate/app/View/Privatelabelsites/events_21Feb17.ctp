<?php
//print("<pre>");
//print_r($arrContentListArticle);
?>

<div class="page-content-wrapper employers-type">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Events</h1>
							<!--<div class="tab-row-container">
								<div class="tab-filters">
									<a href="#" class="active">Upcoming <span>(7)</span></a> |
									<a href="#" class="link-primary">Archived <span>(1)</span></a>
								</div>
							</div>-->
							<?php
								if(is_array($arrContentListArticle) && (count($arrContentListArticle)>0))
								{
									foreach($arrContentListArticle as $arrWebinar)
									{
										?>
											<div class="tab-row-container emp-dashboard-events">
												<div class="emp-dashboard-events-container">
													<div class="emp-dashboard-events-image"></div>
													<div class="col-lg-8">
														<div class="emp-dashboard-events-content">
															<h4><?php echo $arrWebinar['Content']['content_title'];?></h4>
															<p>Start on <?php echo date('M d, Y',strtotime($arrWebinar['Content']['content_published_date']));?>EST</p>
															<p><?php echo htmlspecialchars_decode($arrWebinar['Content']['content_intro_text']); ?></p>
															<?php
																$strWebRegLink = "javascript:void(0);";
																if($arrWebinar['Content']['webinarRegisterLink'])
																{
																	$strWebRegLink = $arrWebinar['Content']['webinarRegisterLink'];
																}
															?>
															<a target="_blank" href="<?php echo $strWebRegLink; ?>"><button type="button" class="btn btn-primary btn-sm">Register Now</button></a>
														</div>
													</div>
												</div>	
											</div>
										<?php
									}
								}
							?>
							
							
							<!--<div class="tab-row-container emp-dashboard-events">
								<div class="emp-dashboard-events-container">
									<div class="emp-dashboard-events-image"></div>
									<div class="col-lg-8">
										<div class="emp-dashboard-events-content">
											<h4>Webinar Title</h4>
											<p>Start on April 27, 2016 12:00 EST</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
											<p class="emp-dashboard-events-reg">Registered</p>
										</div>
									</div>
								</div>	
							</div>

							<div class="tab-row-container emp-dashboard-events">
								<div class="emp-dashboard-events-container">
									<div class="emp-dashboard-events-image"></div>
									<div class="col-lg-8">
										<div class="emp-dashboard-events-content">
											<h4>Webinar Title</h4>
											<p>Start on April 27, 2016 12:00 EST</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
											<button type="button" class="btn btn-primary btn-sm">Register Now</button>
										</div>
									</div>
								</div>	
							</div>-->
	                        
	                    </div>
	                </div>
	            </div>
	        </div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.leftnavi').removeClass('active');
		$('#eventsnavi').addClass('active');
	});
</script>