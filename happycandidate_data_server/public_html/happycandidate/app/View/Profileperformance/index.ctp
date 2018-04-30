<div class="wrapper">
<div id="portal_registration">
	<h2 style="padding:0;">Profile Performance</h2>
	<div style="width:100%;float:left;" class="panel-2 margin-top-5">
			<?php
				if(is_array($arrProfilePerfomance) && (count($arrProfilePerfomance)>0))
				{
					?>
						<div id="perfomancewrapper">
							<?php
								foreach($arrProfilePerfomance as $arrPerformanceFactor => $arrPerformanceFactorValue)
								{
									?>
										<div class="panel_box">
										<div class="half"><span><?php echo $arrPerformanceFactor;?></span></div>
										<div class="half small"><span><?php echo $arrPerformanceFactorValue['count']; ?></span></div>
										</div>
									<?php
								}
							?>
						</div>
					<?php
				}
			?>
	</div>
</div>
</div>