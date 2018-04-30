<?php		
	$strOrderList = Router::url(array('controller'=>'candidates','action'=>'profile',$intPortalId,'orders'),true);
?>
	
	<div class="container-fluid bg-lightest-grey">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
			<h3 class="thankyou-main-heading">THANK YOU!</h3>
                        <p class="error-description">We appreciate your business!<br>Your order was successfully processed.<br>If you have any questions, let us know how we can help <br> <a href="mailto:support@careersupportnetwork.com">support@careersupportnetwork.com</a> <br> Your Career Support Network Team</p>
			<div class="goto-from-error">
				<a href="<?php echo $strOrderList; ?>"><button type="button" class="btn btn-primary btn-md">View My Orders<span class="glyphicon glyphicon-chevron-right"></span></button></a>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
	<?php
		//echo "--".$portalpwnersale;
	?>
<!--<div class="wrapper">
	<div id="jop_search" class="jop_search">
		<h2 id="jobn" style="padding:0;margin-bottom:30px;background:none;padding:none;">Checkout Success</h2>
		<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
		<!--<div style="float:left;width:100%;">
			<a style="float:right;" onclick="fnShowContactFilter()" href="javascript:void(0);" name="filter_contacts" id="filter_contacts" class="button_class">Filter Contacts</a>
			<a style="float:right;margin-right:10px;" onclick="fnLoadConatctAdder()" href="javascript:void(0);" name="add_contact_but" id="add_contact_but" class="button_class">Add Contact</a>
		</div>
		<?php
			//echo $this->element('filter_contact');
		?>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div style="float:left;width:100%;">&nbsp;</div>
		<div id="contacts_container" class="line_up_table" style="float:left;width:100%;margin-top:15px;">
			Thank You for placing the order, we will soon get in touch with you with updates for you
		</div>
	</div>
</div>-->
<script type="text/javascript">
	mixpanel.track("<?php echo $arrPortalDetail[0]['Portal']['career_portal_name']; ?> Sale", {
		"Services": "Yes",
//		"Sale amount": "15.00"
		"Sale amount": "<?php echo $portalpwnersale; ?>"
	});
</script>
<style>
    .thankyou-main-heading {
    
    font-size: 35px !important;
   
}
</style>