<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h3>Order Detail</h3>
							<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
	                        <div class="row">
	                      	<input type="hidden" name="order_id" id="order_id" value="<?php echo $intOrderMId; ?>" />
							</div>
	                        <div class="tab-row-container">
						
							<div class="row-container">
									
									<form role="form">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label " for="select-type">Customer Name:</label>
											<?php echo $arrProductList[0]['customer']['Candidate']['candidate_first_name']." ".$arrProductList[0]['customer']['Candidate']['candidate_last_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-name">Order(Service Request): <span class="form-required">*</span></label><!--
												--> <?php echo $arrProductList[0]['service']['Resources']['product_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-email">Consultant: <span class="form-required">*</span></label><!--
												--> <?php echo $arrCurrentUser['vendor_first_name']." ".$arrCurrentUser['vendor_last_name'];?>
											</div>
											
											
										</div>

										<div class="col-md-6">
											<div class="form-group" >
												<label  class="control-label " for="select-type">Order Status:</label>
											<span id="right_label_answer_order_status" class="order_display_fields"><?php echo $arrProductList[0]['Resourceorderdetail']['vendor_order_state'];?></span>
													<div id="right_label_answer" class="order_editable_fields" style="display:none;">
														<select id="order_status" name="order_status">
															<option value="Open">Open</option>
															<option value="In-Process">In-Process</option>
															<option value="Closed">Closed</option>
														</select>
													</div>
											</div>
												
											<div class="form-group">
												<label class="control-label " for="person-name">Order Name: <span class="form-required">*</span></label><!--
												--> <?php echo $arrProductList[0]['mainorder']['Resourceorder']['order_name'];?>
											</div>
											<div class="form-group">
												<label class="control-label " for="person-email">Order Placed Date: <span class="form-required">*</span></label><!--
												-->	<?php echo date($productdateformat,strtotime($arrProductList[0]['Resourceorderdetail']['order_confirmation_date_time'])); ;?>
											</div>
											
										</div>

									</form>
								
			</div>

							<!-- CONTENT -->
							<div class="clear"></div>
							
							<?php
			
			$strUpdatesUrl = Router::url(array('controller'=>'myorders','action'=>'addupdates',$intPortalId,$intOrderMId),true);
		?>
							<h3 >Order Updates</h3>
							<div class="col-md-12">
								<div class="form-group">
												<label class="control-label " for="person-name">Subject : </label><!--
												--><?php echo $arrServiceUpdateDetails[0]['Serviceupdates']['order_service_subject'];?>
											</div>
							
							<div class="form-group">
												<label class="control-label " for="person-name">Note : </label><!--
												--><?php
								echo htmlspecialchars_decode(stripslashes($arrServiceUpdateDetails[0]['Serviceupdates']['order_updated_text']));
							?>
								</div>
						
						<div class="form-group">
												<label class="control-label " for="person-name">Files : </label><!--
												-->
												
												<?php
								//print("<pre>");
								//print_r($arrServiceUpdateDetails);
								//exit;
								foreach($arrServiceUpdateDetails[0]['files'] as $arrFiles)
								{
									//print("<pre>");
									//print_r($arrFiles);
									$strFileDownloadUrl = Router::url("/",true)."vendorupdates/".$arrFiles['Vendorfiles']['vendor_updates_file'];
									
									?>
										<div id="fileslister" >
											<a href="<?php echo $strFileDownloadUrl; ?>"><?php echo $arrFiles['Vendorfiles']['vendor_updates_file'];?></a>
										</div>
									<?php
								}
							?>
								</div>
						</div>
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
			<?php
	echo $this->element('delete_confirmation');
?>
<?php /*
<div class="wrapper">
	<div class="jop_search" id="jop_search">
		<div id="product_list_notification" class="index row"><?php echo $strMessage;?></div>
		
		<?php
			$strMyOredersUrl = Router::url(array('controller'=>'myorders','action'=>'orderdetail',$intPortalId,$intOrderId),true);
		?>
		
		<?php
			echo $this->element('delete_confirmation');
		?>
	
		
		<div class="row index" style="float:left;width:100%;">
			<div id="order_detail_container" style="width:100%;float:left;">
				<div id="order_left_detail_container" style="width:98%;float:left;margin-right:2%;">
					<div id="order_left_container" style="width:100%;float:left;">
						<div id="left_label" style="width:48%;float:left;">
							<label>Subject:</label>
						</div>
						<div id="right_label_answer" style="width:48%;float:left;">
							<?php echo $arrServiceUpdateDetails[0]['Serviceupdates']['order_service_subject'];?>
						</div>
					</div>
					<div id="order_left_container" style="width:100%;float:left;">
						<div id="left_label" style="width:48%;float:left;">
							<label>Note:</label>
						</div>
						<div id="right_label_answer" style="width:48%;float:left;">
							<?php
								echo htmlspecialchars_decode(stripslashes($arrServiceUpdateDetails[0]['Serviceupdates']['order_updated_text']));
							?>
						</div>
					</div>
					<div id="order_left_container" style="width:100%;float:left;">
						<div id="left_label" style="width:48%;float:left;">
							<label>Files:</label>
						</div>
						<div id="right_label_answer" style="width:48%;float:left;">					
							<?php
								//print("<pre>");
								//print_r($arrServiceUpdateDetails);
								//exit;
								foreach($arrServiceUpdateDetails[0]['files'] as $arrFiles)
								{
									//print("<pre>");
									//print_r($arrFiles);
									$strFileDownloadUrl = Router::url("/",true)."vendorupdates/".$arrFiles['Vendorfiles']['vendor_updates_file'];
									
									?>
										<div id="fileslister" style="float:left;width:100%;">
											<a href="<?php echo $strFileDownloadUrl; ?>"><?php echo $arrFiles['Vendorfiles']['vendor_updates_file'];?></a>
										</div>
									<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div style="float:left;width:100%;border-bottom:1px solid;">&nbsp;</div>
		</div>
	</div>
</div> */?>