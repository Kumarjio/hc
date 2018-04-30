<?php echo $this->Html->script('readmore.min');?>
<div class="container-fluid bg-lightest-grey">

		<div class="row">
			<div class="col-md-1"></div>


			<div class="col-md-10 bg-lightest-grey">
				
				<div class="find-jobs-header">
				<?php echo $this->element('webinars_search_main');?>
					<div class="col-md-9">
						<div class="result-header">
							
							<div class="result-filters">
								
								<!--<div class="tab-controls-pagination">
									<button class="btn btn-default disabled goto-beginning" type="button"><span></span></button>
									<button class="btn btn-default disabled goto-previous" type="button"><span></span></button>
									<input type="text" placeholder="1" name="input-page-number" value="">
									<button class="btn btn-default disabled pages-counter" type="button"><span>of 3</span></button>
									<button class="btn btn-default goto-next-active" type="button"><span></span></button>
									<button class="btn btn-default goto-end-active" type="button"><span></span></button>
								</div>-->
							</div>
						</div>
						<div class="results-container">
						<?php
						//echo "hi";exit;
						//print("<pre>");
						//print_r($arrWebinarsDetails);
						//exit;
					if(is_array($arrWebinarsDetails) && (count($arrWebinarsDetails)>0))
					{
					foreach($arrWebinarsDetails as $arrCourse)
							{
								$strwebinarDetailUrl = Router::url(array('controller'=>'candidates','action'=>'webinardetail',$intPortalId,$arrCourse['content']['content_id']),true);
							?>
							<div class="result-element">
								<div class="webinar-left">
									<a href="<?php echo $strwebinarDetailUrl;?>"><div class="webinar-image"></div></a>
								</div>
								<div class="webinar-right">
									<div class="result-element-head">
										<h3><a href="<?php echo $strwebinarDetailUrl;?>"><?php echo strip_tags($arrCourse['content']['content_title']); ?></a></h3>
										
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
						
						</div>
						<!--<div class="tab-controls-pagination">
								<button class="btn btn-default disabled goto-beginning" type="button"><span></span></button>
								<button class="btn btn-default disabled goto-previous" type="button"><span></span></button>
								<input type="text" placeholder="1" name="input-page-number" value="">
								<button class="btn btn-default disabled pages-counter" type="button"><span>of 3</span></button>
								<button class="btn btn-default goto-next-active" type="button"><span></span></button>
								<button class="btn btn-default goto-end-active" type="button"><span></span></button>
						</div>-->
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function () {
		
		
		/*var availableWebinarTags = <?php echo $strCourseName; ?>
		
		$("#webinar_name").autocomplete({
			source: availableWebinarTags
		});
		*/
		
		});
		
   
		</script>