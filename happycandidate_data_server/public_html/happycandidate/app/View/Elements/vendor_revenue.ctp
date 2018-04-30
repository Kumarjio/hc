	<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">Vendor Owed</p>
									<p class="statistic-data-value"><?php 
										if($intClosedOrderTotal)
										{
											echo $intClosedOrderTotal;
										}
										else
										{
											echo "0";
										}
										?></p>
									<!--<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>
							<div class="vendor-statistic-container">
								<div class="admin-statistic-block">
									<p class="statistic-data-header">Refunds</p>
									<p class="statistic-data-value"><?php 
										if($intRefundOrderTotal)
										{
											echo $intRefundOrderTotal;
										}
										else
										{
											echo "0";
										}
										?></p>
									<!--<a href="#" class="link-success"><span></span>10%</a>-->
								</div>
							</div>