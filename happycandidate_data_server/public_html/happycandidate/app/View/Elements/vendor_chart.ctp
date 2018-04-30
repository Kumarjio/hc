<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">New Orders</p>
									<p class="statistic-data-value"><?php 
										if($intPortalCandidates)
										{
											echo $intPortalCandidates;
										}
										else
										{
											echo "0";
										}
										;?></p>
									<!--<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>
							<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">Open Orders</p>
									<p class="statistic-data-value"><?php 
										if($intOpenPortalCandidates)
										{
											echo $intOpenPortalCandidates;
										}
										else
										{
											echo "0";
										}
										
									?></p>
								<!--	<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>
							<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">Pending Orders</p>
									<p class="statistic-data-value"><?php 
										
										
										if($intPendingPortalCandidates)
										{
											echo $intPendingPortalCandidates;
										}
										else
										{
											echo "0";
										}
										
									?></p>
								<!--	<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>
							<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">Closed Orders</p>
									<p class="statistic-data-value"><?php 
										if($intClosedPortalCandidates)
										{
											echo $intClosedPortalCandidates;
										}
										else
										{
											echo "0";
										}
										?></p>
									<!--<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>
							