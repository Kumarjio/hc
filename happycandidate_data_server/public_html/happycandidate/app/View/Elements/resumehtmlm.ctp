<?php
	//print("<pre>");
	//print_r($arrCvDetail);
	$strFontFamily = "font-family:".$strFont.";font-size:".$strFontSize;
	$strHeadFont = $strFontSize + 2;
?>
<?php
	//print("<pre>");
	//print_r($arrCvDetail);
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
	<!--<div id="separator" style="float:left;width:100%;">
		<hr/>
	</div>-->
	
	<!--<div id="gap" style="float:left;width:100%;height:10px;">&nbsp;</div>-->
	
	<!--<div id="expsection"  style="float:left;width:100%;margin-bottom:30px;">
		<div id="expsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Experience & Level</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr/>
		</div>
		<div id="expsectionbody" style="float:left;width:100%;">
			<div><?php echo $arrCvDetail[0]['Candidate_Cv']['experience_level']." - ".$arrCvDetail[0]['Candidate_Cv']['work_history']; ?></div>
		</div>
	</div>-->
	<div id="carsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="carsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Career Summary</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;border:2px;solid;"/>
		</div>
		<div id="carsectionbody" style="float:left;width:100%;">
			<div><?php echo $arrCvDetail[0]['Candidate_Cv']['Career_Summary']; ?></div>
		</div>
	</div>
	<div id="compsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="compsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Core Competancies</h4>
		</div>
		<div id="separator" style="float:left;width:100%;">
			<hr style="margin-top:2px;"/>
		</div>
		<?php
			//echo "HI";exit;
			$arrCompet = explode(",",$arrCvDetail[0]['Candidate_Cv']['keywords']);
			//$arrCompet = array('asdasdasd','adasdsad','gfhffhjggjyhg','jhhghj');
			
			if(is_array($arrCompet) && (count($arrCompet)>0))
			{
				?>
					<div id="compsectionbody" style="float:left;width:100%;">
						<div>
							<ul style="margin-top: 0px; margin-bottom: 0px;">
								<?php
									foreach($arrCompet as $arrCompt)
									{
										?>
											<li style="float:left;width:30%;"><?php echo $arrCompt; ?></li>
										<?php
									}
								?>
							</ul>
						</div>
					</div>
				<?php
			}				
		?>
		<!--<div id="compsectionbody" style="float:left;width:100%;">
			<div>
				<ul>
					<li><?php echo $arrCvDetail[0]['Candidate_Cv']['keywords']; ?></li>
				</ul>
			</div>
		</div>-->
	</div>
	
	
	<div id="prfexpsection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="prfexpsectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Professional Experience</h4>
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
						?>
						<?php
						$intFrCnt = 0;
						foreach($arrPrfExp as $arrExp)
						{
							?>
							<?php
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
							
							
							if($strCompanyDetails)
							{
								?>
									<div style="float:left;width:100%;<?php echo $strMarginTop; ?>">
										<?php 
												echo $strCompanyDetails;
										?>
									</div>
								<?php
							}
							
							?>
							<?php
								if($arrExp['Candidate_prof_exp']['jobTitle'])
								{
									?>
										<div style="float:left;width:100%;"><i>
											<?php 
												if($arrExp['Candidate_prof_exp']['jobTitle'])
												{
													echo $arrExp['Candidate_prof_exp']['jobTitle']; 
												}
											?>
										</i></div>
									<?php
								}
							?>
							
							<?php
								$strCompleteText = "";
								$arrFromDetail = array();
								if($arrExp['Candidate_prof_exp']['frommonth'])
								{
									$arrFromDetail[] = date("F",strtotime($arrExp['Candidate_prof_exp']['frommonth']));
								}
								if($arrExp['Candidate_prof_exp']['fromyear'])
								{
									$arrFromDetail[] = $arrExp['Candidate_prof_exp']['fromyear'];
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
								if($arrExp['Candidate_prof_exp']['tilldate'] == "on")
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
									$arrToDetail = array();
									if($arrExp['Candidate_prof_exp']['tomonth'])
									{
										$arrToDetail[] = date("F",strtotime($arrExp['Candidate_prof_exp']['tomonth']));
										
									}
									if($arrExp['Candidate_prof_exp']['toyear'])
									{
										$arrToDetail[] = $arrExp['Candidate_prof_exp']['toyear'];
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
							
							<?php
								if($arrExp['Candidate_prof_exp']['description'])
								{
									?>
										<div style="float:left;width:100%;">
											<?php 
												echo $arrExp['Candidate_prof_exp']['description']; 
											?>
										</div>
									<?php
								}
								$arrAcmp = $arrExp['Candidate_prof_exp']['acc'];
								if(is_array($arrAcmp) && (count($arrAcmp)>0))
								{
									?>
									<ul style="margin-top: 0px; margin-bottom: 0px;">
										<?php
											foreach($arrAcmp as $arrVal)
											{
												?>
												<li style="float:left;width:100%;">
													<div style="float:left;width:100%;">
														<?php 
															echo $arrVal['Candidate_prof_exp_acc']['acc']; 
														?>
													</div>
												</li>
												<?php
											}
										?>
									</ul>
									<?php
								}
							?>
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
									<!--<div style="float:left;width:50%;">
										Name of Institution:
									</div>-->
									<div style="float:left;width:100%;">
										<?php echo "<b>".$arrEd['Candidate_Education']['institution']."</b>, ".$arrEd['Candidate_Education']['city'].", ".$arrEd['Candidate_Education']['state']; ?>
									</div>
									<!--<div style="float:left;width:50%;">
										Degree or Certification Earned:
									</div>-->
									<div style="float:left;width:100%;">
										<?php echo $arrEd['Candidate_Education']['degree']; ?>
									</div>
									<!--<div style="float:left;width:50%;">
										City:
									</div>
									<div style="float:left;width:50%;">
										<?php echo $arrEd['Candidate_Education']['city']; ?>
									</div>
									<div style="float:left;width:50%;">
										Percentage of Tuition Paid by Self:
									</div>
									<div style="float:left;width:50%;">
										<?php echo $arrEd['Candidate_Education']['tution_percentage']; ?>
									</div>-->
							<?php
						}
						?>
						<?php
					}
				?>
			</div>
		</div>
	</div>

	<div id="awardssection"  style="float:left;width:100%;margin-bottom:10px;">
		<div id="awardssectionhead" style="float:left;width:100%;">
			<h4 style="margin-bottom:0px;text-transform:uppercase;">Awards</h4>
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
							?>
							<?php
							$arrAward = array();
							if($intPAffFrCnt >= "1")
							{
								$strAwardMarginTop = "margin-top:5px;";
							}
							if($arrExp['Candidate_Awards']['award'])
							{
								$arrAward[] = "<b>".$arrExp['Candidate_Awards']['award']."</b>";
							}
							
							if($arrExp['Candidate_Awards']['organization'])
							{
								//$arrAward[] = "<b>".$arrExp['Candidate_Awards']['organization']."</b>";
							}
							
							if(is_array($arrAward) && (count($arrAward)>0))
							{
								$strAward = implode(", ",$arrAward);
							}
							
							if($strAward)
							{
								?>
									<div style="float:left;width:98%;margin-right:2%;<?php echo $strAwardMarginTop; ?>"><b>
										<?php 
											echo $strAward;
										?></b>
										<?php
											if($arrExp['Candidate_Awards']['organization'])
											{
												echo ", ".$arrExp['Candidate_Awards']['organization'];
											}
										?>
									</div>
								<?php
							}
							
							/*if($arrExp['Candidate_Awards']['organization'])
							{
								?>
									<div style="float:left;width:48%;margin-right:2%;"><b>
										<?php 
											echo $arrExp['Candidate_Awards']['organization'];
										?>
										</b>
									</div>
								<?php
							}*/
							
							if($arrExp['Candidate_Awards']['description'])
							{
								?>
									<div style="float:left;width:98%;margin-right:2%;">
										<?php 
											echo $arrExp['Candidate_Awards']['description'];
										?>
									</div>
								<?php
							}
							?>
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
</div>