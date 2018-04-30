<?php
	//print("<pre>");
	//print_r($arrCvDetail);
	$strFontFamily = "font-family:".$strFont.";font-size:".$strFontSize.";";
?>
<div style="float:left;width:100%;<?php echo $strFontFamily; ?>" class="container">
	<div id="headcontainer" style="float:left;width:100%;">
		<div id="namecontainer" style="float:left;width:100%;">
			<span style="font-weight:bold;font-size:<?php echo $strHeadFont; ?>px;"><?php echo $arrCvDetail[0]['Candidate_Cv']['firstName']." ".$arrCvDetail[0]['Candidate_Cv']['lastName']; ?></span>
		</div>
		<div id="contactdetailcontainer" style="float:left;width:100%;">
			<?php
				if($arrCvDetail[0]['Candidate_Cv']['streetAddress'])
				{
					$arrAddress[] = $arrCvDetail[0]['Candidate_Cv']['streetAddress'];
				}
				
				
				if(is_array($arrAddress) && (count($arrAddress)>0))
				{
					$strAddress = implode(", ",$arrAddress);
				}
				if($strAddress)
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:90%"><?php echo $strAddress; ?></span></div>
					<?php
				}
				
				if($arrCvDetail[0]['Candidate_Cv']['city'])
				{
					$arrCountry[] = $arrCvDetail[0]['Candidate_Cv']['city'];
				}
				if($arrCvDetail[0]['Candidate_Cv']['state'])
				{
					$arrCountry[] = $arrCvDetail[0]['Candidate_Cv']['state'];
				}
				
				if(is_array($arrCvDetail[0]['Candidate_Cv']['countrydetail']) && (count($arrCvDetail[0]['Candidate_Cv']['countrydetail'])>0))
				{
					$arrCount = $arrCvDetail[0]['Candidate_Cv']['countrydetail'];
					//$arrCountry[] = $arrCount[0]['Jobberlandcountry']['name'];
				}
				if($arrCvDetail[0]['Candidate_Cv']['zipCode'])
				{
					//$arrCountry[] = $arrCvDetail[0]['Candidate_Cv']['zipCode'];
				}
				
				if(is_array($arrCountry) && (count($arrCountry)>0))
				{
					$strAddressCountry = implode(", ",$arrCountry);
				}
				
				if($strAddressCountry)
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:90%"><?php 
							echo $strAddressCountry; 
							if($arrCvDetail[0]['Candidate_Cv']['zipCode'])
							{
								echo " ".$arrCvDetail[0]['Candidate_Cv']['zipCode'];
							}
						?></span></div>
					<?php
				}
				
				if($arrCvDetail[0]['Candidate_Cv']['cellPhone'])
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:90%"> <?php echo $arrCvDetail[0]['Candidate_Cv']['cellPhone']." (Mobile)"; ?></span></div>
					<?php
				}
				
				if($arrCvDetail[0]['Candidate_Cv']['homePhone'])
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:90%"> <?php echo $arrCvDetail[0]['Candidate_Cv']['homePhone']." (Home)"; ?></span></div>
					<?php
				}
				
				if($arrCvDetail[0]['Candidate_Cv']['email_address'])
				{
					?>
						<div style="float:left;width:100%;"><span style="float:left;width:90%"> <?php echo $arrCvDetail[0]['Candidate_Cv']['email_address']; ?></span></div>
					<?php
				}
				
			?>
		</div>
	</div>
	
	<div id="cvnamesection"  style="float:left;width:100%;margin-bottom:10px;margin-left:40%;">
		<div id="carsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">CURRICULUM VITAE</h4>
		</div>
	</div>
	
	<div id="edusection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="edusectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Education</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="edusectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrEducation =  $arrCvDetail[0]['Candidate_Cv']['education'];
					if(is_array($arrEducation) && (count($arrEducation)>0))
					{
						?>
						<?php
							foreach($arrEducation as $arrEd)
							{
								?>
										<div style="float:left;width:98%;margin-right:2%;">
											<?php echo "<b>".$arrEd['Candidate_Education']['institution']."</b>"; ?>
										</div>
										<div style="float:left;width:98%;margin-right:2%;margin-bottom:10px;">
											<?php echo $arrEd['Candidate_Education']['degree']; ?>
											<?php 
												if($arrEd['Candidate_Education']['year'])
												{
													echo ", ".$arrEd['Candidate_Education']['year']; 
												}
											?>
										</div>
										
								<?php
							}
						?>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="prfexpsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="prfexpsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Professional Appointments/Employment</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="prfexpsectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfExp =  $arrCvDetail[0]['Candidate_Cv']['prof_exp'];
					if(is_array($arrPrfExp) && (count($arrPrfExp)>0))
					{
						//print("<pre>");
						//print_r($arrPrfExp);
						?>
						<?php
						$intFrCnt = 0;
						foreach($arrPrfExp as $arrExp)
						{
							$arrCompanyDetails = array();
							if($intFrCnt >= "1")
							{
								$strMarginTop = "margin-top:5px;";
							}
							if($arrExp['Candidate_prof_exp']['company'])
							{
								$arrCompanyDetails[] = "<b>".$arrExp['Candidate_prof_exp']['company']."</b>";
							}
							
							if($arrExp['Candidate_prof_exp']['city'])
							{
								$arrCompanyDetails[] = $arrExp['Candidate_prof_exp']['city'];
							}
							
							if($arrExp['Candidate_prof_exp']['state'])
							{
								$arrCompanyDetails[] = $arrExp['Candidate_prof_exp']['state'];
							}
							if(is_array($arrCompanyDetails) && (count($arrCompanyDetails)>0))
							{
								$strCompanyDetails = implode(", ",$arrCompanyDetails);
							}
							?>
									<div style="float:left;width:98%;margin-right:2%;">
										<?php echo $arrExp['Candidate_prof_exp']['company']; ?>
										<?php 
											if($arrExp['Candidate_prof_exp']['fromyear'])
											{
												echo ", ".$arrExp['Candidate_prof_exp']['fromyear']; 
											}
										?>
									</div>
									<div style="float:left;width:98%;margin-right:2%;margin-bottom:10px;">
										<?php echo $arrExp['Candidate_prof_exp']['jobTitle']; ?>
									</div>
							<?php
							$intFrCnt++;
						}
						?>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="pubsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="edusectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Publications</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="edusectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					//echo "HI";exit;
					//print("<pre>");
					//print_r($arrCvDetail);
					
					$arrPub =  $arrCvDetail[0]['Candidate_Cv']['publication'];
					if(is_array($arrPub) && (count($arrPub)>0))
					{
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
							foreach($arrPub as $arrEd)
							{
								//print("<pre>");
								//print_r($arrEd);
								
								?>
									<li>
										<div style="float:left;width:98%;margin-right:2%;">
											<?php echo $arrEd['Candidate_publications']['subheading']; ?>
										</div>
										<div style="float:left;width:48%;margin-right:2%;">
											</b><?php echo $arrEd['Candidate_publications']['publications']; ?>
										</div>
										<div style="float:left;width:48%;margin-right:2%;">
											<?php echo date("F d, Y",strtotime($arrEd['Candidate_publications']['date'])); ?>
										</div>
										
										<div style="float:left;width:48%;margin-right:2%;">
											<?php echo $arrEd['Candidate_publications']['citation']; ?>
										</div>
										<div style="float:left;width:48%;margin-right:2%;">
											<?php echo $arrEd['Candidate_publications']['page_numbers']; ?>
										</div>
									</li>
								<?php
							}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="awardssection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Awards And Honors</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">

				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['awards'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						?>
						<?php
						$intAwardCnt = 0;
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo date("F d, Y",strtotime($arrExp['Candidate_Awards']['date'])); ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_Awards']['award']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_Awards']['organization']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_Awards']['amount']; ?>
							</div>
							<?php
							
							$intAwardCnt++;
						}
						?>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="grantssection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">GRANTS AND FELLOWSHIPS</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['grants'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						$intAwardCnt = 0;
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo date("F d, Y",strtotime($arrExp['Candidate_grants']['date'])); ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_grants']['funder']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_grants']['organization']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_grants']['amount']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="invitedsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">INVITED TALKS</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['invited'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_invited']['year']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_invited']['title']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_invited']['organization']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_invited']['location']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="conferencesection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">CONFERENCE PARTICIPATION</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['conferrence'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_conference']['year']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_conference']['paper_name']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_conference']['name']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="campussection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">CAMPUS OR DEPARTMENTAL TALKS</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['campus'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_campus']['year']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_campus']['title']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_campus']['organization']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_campus']['location']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="teachingsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">TEACHING EXPERIENCE</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['teaching'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_teaching']['title']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="researchsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">RESEARCH EXPERIENCE</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['research'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_research']['research_exp']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="servicesection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">SERVICE TO PROFESSION</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['service'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_service']['company']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_service']['jobTitle']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php //echo $arrExp['Candidate_service']['date']; ?>
								<?php
									$strCompleteText = "";
									if($arrExp['Candidate_service']['frommonth'])
									{
										$arrFromDetail[] = date("F",strtotime($arrExp['Candidate_service']['frommonth']));
									}
									if($arrExp['Candidate_service']['fromyear'])
									{
										$arrFromDetail[] = $arrExp['Candidate_service']['fromyear'];
									}
									
									if(count($arrFromDetail)==2)
									{
										$strFrom = implode(" ",$arrFromDetail);
									}
									
									
									if($strFrom)
									{
										$strCompleteText = $strFrom;
										?>
											<!--<div style="float:left;width:auto%;">
												<?php 
													//echo $strFrom; 
												?>
											</i></div>-->
										<?php
									}
								?>
								
								<?php
									if($arrExp['Candidate_service']['tilldate'] == "on")
									{
										$strCompleteText .= "&nbsp;-&nbsp;Present";
										?>
											<!--<div style="float:left;width:auto;">
												<?php 
													//echo "&nbsp;-&nbsp;Present"; 
												?>
											</i></div>-->
										<?php
									}
									else
									{
										if($arrExp['Candidate_service']['tomonth'])
										{
											$arrToDetail[] = date("F",strtotime($arrExp['Candidate_service']['tomonth']));
											
										}
										if($arrExp['Candidate_service']['toyear'])
										{
											$arrToDetail[] = $arrExp['Candidate_service']['toyear'];
										}
										
										if(count($arrToDetail)==2)
										{
											$strTo = implode(" ",$arrToDetail);
										}
										
										
										if($strTo)
										{
											$strCompleteText .= "&nbsp;-&nbsp;".$strTo;
											
											?>
												<!--<div style="float:left;width:auto;">
													<?php 
														//echo "&nbsp;-&nbsp;".$strTo; 
													?>
												</i></div>-->
											<?php
										}
									}
									
									if($strCompleteText)
									{
										?>
											<div style="float:left;width:auto;">
												<?php 
													echo $strCompleteText; 
												?>
											</div>
										<?php
									}
									
								?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="uniservicesection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">DEPARTMENT/UNIVERSITY SERVICE</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['uniservice'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_uniservice']['company']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_uniservice']['jobTitle']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_uniservice']['date']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="uniservicesection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">LANGUAGES</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['lang'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_lang']['lang']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_lang']['reading']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
							<?php echo $arrExp['Candidate_lang']['speaking']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_lang']['writing']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="profasection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">PROFESSIONAL MEMBERSHIPS/AFFILIATIONS</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['porfaff'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_prof_affiliation_a']['organization_name']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_prof_affiliation_a']['year']; ?>
							</div>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div id="extrasection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">EXTRACURRICULAR SERVICE</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<div id="awardssectionbody" style="float:left;width:100%;">
			<div style="float:left;width:100%;">
				<?php 
					$arrPrfAwardds =  $arrCvDetail[0]['Candidate_Cv']['extra'];
					//print("<pre>");
					//print_r($arrPrfExp);
					//exit;
					
					if(is_array($arrPrfAwardds) && (count($arrPrfAwardds)>0))
					{
						$intAwardCnt = 0;
						?>
						<ul style="margin-top: 0px; margin-bottom: 0px;">
						<?php
						foreach($arrPrfAwardds as $arrExp)
						{
							//print("<pre>");
							//print_r($arrExp);
							
							
							?>
							<li><div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_extra']['company']; ?>
							</div>
							<div style="float:left;width:48%;margin-right:2%;">
								<?php echo $arrExp['Candidate_extra']['involvement']; ?>
							</div></li>
							<?php
							
							$intAwardCnt++;
						}
						?>
						</ul>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
</div>