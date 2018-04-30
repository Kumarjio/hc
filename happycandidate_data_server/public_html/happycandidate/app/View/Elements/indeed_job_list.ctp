<?php
									if(is_array($indeedresults) && (count($indeedresults)>0))
									{
										?>
											<div class="results-container">
										<?php
										$intFor = 1;
										foreach($indeedresults as $arrIndeedJob)
										{
											if($intFor == "2")
											{
												$strClass = "class='result-element-favour'";
											}
											else
											{
												$strClass = "class='result-element'";
											}
											//print_r($arrIndeedJob);
											
											?>
					
								<div <?php echo $strClass;?>>
								<div class="result-element-head">
									<h3><a target="_blank" href="http://www.indeed.com/viewjob?jk=<?php echo $arrIndeedJob['jobkey'];?>"><?php echo $arrIndeedJob['jobtitle'];?></a></h3>
									
									<p class="result-element-subheader"><span>Full-time</span> - <?php echo $arrIndeedJob['city'];?>, <?php echo $arrIndeedJob['state'];?> - <!--Salary: $50k ---> Posted <?php echo date('d M Y',strtotime($arrIndeedJob['date']));?></p>
								</div>
								<p class="result-element-description"><?php echo $arrIndeedJob['snippet'];?></p>
							</div>
							
							<?php
											$intFor++;
										}
										?>
						</div>
						<?php
						}?>