<div class="users index container-layout">
	<div id="page-title">
		<h3>Themes</h3>
		</div>
	
	
	<?php
		/*print("<pre>");
		print_r($arrPortals);*/
		
		if(is_array($arrThemeData) && (count($arrThemeData)>0))
		{
			$intForI = 0;
			$class = null;
			?>
				<div style="width:100%;float:left;">
			<?php
			$intDivWidth = (100/3);
			foreach($arrThemeData as $arrThemeDataVal)
			{
				if ($intForI++ % 2 == 0) {
					$class = ' class="altrow"';
					
				}
				
				?>
					<div style="float:left;width:<?php echo $intDivWidth;?>;">
						<span>
							<?php echo $this->Html->image(Router::url('/',true).'img/hometheme/img/'.$arrThemeDataVal['Theme']['theme_thumb'], array('width'=>'270','height'=>'160','alt' => $arrThemeDataVal['Theme']['theme_name']));?>
						</span>
						<span id="action" class="actions">
							<?php echo $this->Html->link('Edit',array('action' => 'view',$portal_id),array('target'=>'_blank')); ?>
						</span>
						
					</div>
				<?php
			}
				?>
					</div>
				<?php
		}
		else
		{
			?>
			<?php
		}
	?>
	
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('Back', array('action' => 'index')); ?></li>
	</ul>
</div>