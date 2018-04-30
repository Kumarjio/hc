		<?php
		
					if(is_array($arrWebinarsDetails) && (count($arrWebinarsDetails)>0))
					{
					foreach($arrWebinarsDetails as $arrCourse)
							{
							$strwebinarDetailUrl = Router::url(array('controller'=>'candidates','action'=>'webinardetail',$intPortalId,$arrCourse['content']['content_id']),true);
							?>
							<div class="result-element">
								<div class="webinar-left">
									<div class="webinar-image"></div>
								</div>
								<div class="webinar-right">
									<div class="result-element-head">
                                                                            <h3><a href="<?php echo $strwebinarDetailUrl;?>"><?php echo stripslashes($arrCourse['content']['content_title']); ?></a></h3>
										<!--<div class="result-icon"></div>-->
										<p class="result-element-subheader"><?php echo date('M j, Y ',strtotime($arrCourse['content']['created_date'])); ?></p>
									</div>
                                                                    <p class="result-element-description ">
									<span id="info<?php echo $arrCourse['content']['content_id'];?>">
									<?php
									 $content = $arrCourse['content']['content'];
								
									  echo strip_tags(html_entity_decode($content));
									?>
									</span>
									</p>
								</div>
							</div>
                                                        <script type="text/javascript">
							 $('#info<?php echo $arrCourse['content']['content_id'];?>').readmore({
                                                            moreLink: '<a href="javascript:void(0);">Read More</a>',
                                                            collapsedHeight: 150,
                                                            afterToggle: function(trigger, element, expanded) {
                                                              if(! expanded) { // The "Close" link was clicked
                                                                $('html, body').animate({scrollTop: element.offset().top}, {duration: 100});
                                                              }
                                                            }
                                                          });
                                                         </script>
							<?php
							}
						}?>