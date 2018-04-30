<?php
	if(isset($arrPortalHJobDetail))
	{
		if(is_array($arrPortalHJobDetail) && (count($arrPortalHJobDetail)>0))
		{
			?>
				<!--Start latest job -->
				<?php
					if(isset($strHidden))
					{
						?>
							<div class="latest-jobs" style="display:none;">
						<?php
					}
					else
					{
						?>
							<div class="latest-jobs">
						<?php
					}
				?>
					<div class="wrapper">
						<h2>Highlighted Jobs</h2>
					<div id="ca-containernew" class="ca-container">
								<div class="ca-wrapper">
									<?php
										//print("<pre>");
										//print_r($arrPortalHJobDetail);
										//exit;
										
										foreach($arrPortalHJobDetail as $arrLatestJob)
										{
											?>
												<div class="ca-item ca-item-1">
													<div class="ca-item-main">
														<div class="ca-icon"></div>
														<?php
															$strJobDetailUrl = Router::url(array('controller'=>'portal','action'=>'jobdetail',$intPortalId,$arrLatestJob['jobberland_job']['id']),true);
														?>
														<h3><a href="<?php echo $strJobDetailUrl; ?>"><?php echo $arrLatestJob['jobberland_job']['job_title']; ?></a></h3>
														<em><?php echo $arrLatestJob['jobberland_category']['cat_name']; ?></em>
															<a href="javascript:void(0);" class="ca-more">Post Date: <label><?php echo date('d M Y',strtotime($arrLatestJob['jobberland_job']['created_at']));?></label> >></a>
													</div>
													<div class="ca-content-wrapper">
														<div class="ca-content">
															<h6>Jobs Complete Details</h6>
															<a href="javascript:void(0);" class="ca-close">close</a>
															<div class="ca-content-text">
																<p><?php echo $arrLatestJob['jobberland_job']['job_description']; ?></p>
															</div>
															<ul>
																<li><a href="javascript:void(0);">Share this</a></li>
																<li><a href="javascript:void(0);">Become a member</a></li>
																<li><a href="javascript:void(0);">Donate</a></li>
															</ul>
														</div>
													</div>
												</div>
											<?php
										}
									?>
									<!--<div class="ca-item ca-item-1">
										<div class="ca-item-main">
											<div class="ca-icon"></div>
											<h3>Product Software</h3>
											<em>BPO Jobs </em>
												<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
										</div>
										<div class="ca-content-wrapper">
											<div class="ca-content">
												<h6>Jobs Complete Details</h6>
												<a href="javascript:void(0);" class="ca-close">close</a>
												<div class="ca-content-text">
													<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
													
												</div>
												<ul>
													<li><a href="javascript:void(0);">Share this</a></li>
													<li><a href="javascript:void(0);">Become a member</a></li>
													<li><a href="javascript:void(0);">Donate</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="ca-item ca-item-2">
										<div class="ca-item-main">
											<div class="ca-icon"></div>
											<h3>Product Software</h3>
											<em>BPO Jobs </em>
												<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
										</div>
										<div class="ca-content-wrapper">
											<div class="ca-content">
												<h6>Jobs Complete Details</h6>
												<a href="javascript:void(0);" class="ca-close">close</a>
												<div class="ca-content-text">
													<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
													
												</div>
												<ul>
													<li><a href="javascript:void(0);">Share this</a></li>
													<li><a href="javascript:void(0);">Become a member</a></li>
													<li><a href="javascript:void(0);">Donate</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="ca-item ca-item-3">
										<div class="ca-item-main">
											<div class="ca-icon"></div>
											<h3>Product Software</h3>
											<em>BPO Jobs </em>
												<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
										</div>
										<div class="ca-content-wrapper">
											<div class="ca-content">
												<h6>Jobs Complete Details</h6>
												<a href="javascript:void(0);" class="ca-close">close</a>
												<div class="ca-content-text">
													<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
													
												</div>
												<ul>
													<li><a href="javascript:void(0);">Share this</a></li>
													<li><a href="javascript:void(0);">Become a member</a></li>
													<li><a href="javascript:void(0);">Donate</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="ca-item ca-item-4">
										<div class="ca-item-main">
											<div class="ca-icon"></div>
											<h3>Product Software</h3>
											<em>BPO Jobs </em>
												<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
										</div>
										<div class="ca-content-wrapper">
											<div class="ca-content">
												<h6>Jobs Complete Details</h6>
												<a href="javascript:void(0);" class="ca-close">close</a>
												<div class="ca-content-text">
													<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
													
												</div>
												<ul>
													<li><a href="javascript:void(0);">Share this</a></li>
													<li><a href="javascript:void(0);">Become a member</a></li>
													<li><a href="javascript:void(0);">Donate</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="ca-item ca-item-5">
										<div class="ca-item-main">
											<div class="ca-icon"></div>
											<h3>Product Software</h3>
											<em>BPO Jobs </em>
												<a href="javascript:void(0);" class="ca-more">Post Date: <label>21 sep. - 30 Dec.</label> >></a>
										</div>
										<div class="ca-content-wrapper">
											<div class="ca-content">
												<h6>Jobs Complete Details</h6>
												<a href="javascript:void(0);" class="ca-close">close</a>
												<div class="ca-content-text">
													<p>I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</p>
													
												</div>
												<ul>
													<li><a href="javascript:void(0);">Share this</a></li>
													<li><a href="javascript:void(0);">Become a member</a></li>
													<li><a href="javascript:void(0);">Donate</a></li>
												</ul>
											</div>
										</div>
									</div>-->
								</div>
							</div>
					</div>
				</div>
				
				
				
			<?php
		}
	}
?>