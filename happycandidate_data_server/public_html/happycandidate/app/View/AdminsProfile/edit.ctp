<?php
	echo $this->Html->script('admin_edit');
?>
	
	        <div class="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Edit My Profile</h1>
	                        <div class="form-container">
		                        <?php 
								echo $this->Form->create('User',array('inputDefaults' => array(
								'label' => false,
								'div' => false
								)
								)
								);
							?>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="name">User Name: <span class="form-required">*</span></label>
															
										<?php
					echo $this->Form->input('username',array('class'=>'validate[required] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['username']));
				?>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="username">First Name: <span class="form-required">*</span></label>
										<?php 
										 echo $this->Form->input('firstname',array('class'=>'validate[required] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['admin_fname']));
										?>									
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Last Name: <span class="form-required">*</span></label>
										<?php 
												echo $this->Form->input('lname',array('class'=>'validate[required] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['admin_lname']));
										?>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Last Name: <span class="form-required">*</span></label>
										<?php 
												echo $this->Form->input('lname',array('class'=>'validate[required] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['admin_lname']));
										?>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Email Address: <span class="form-required">*</span></label>
										<?php 
										echo $this->Form->input('emailaddress',array('class'=>'validate[required,custom[email]] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['email']));
										?>
										
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Phone Number: <span class="form-required">*</span></label>
										<?php 
										echo $this->Form->input('contactnumber',array('class'=>'validate[required] col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['admin_contact_number']));
										?>
										
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Address Line1: </label>
										<?php 
										echo $this->Form->input('address', array('class'=>'col-xs-12 col-sm-12 col-md-10', 'rows' => '5', 'cols' => '5','value'=>$arrCompleteLoggedInUserDetail[0]['admin_address']));
										?>
										
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Address Line2: </label>
										<?php 
										echo $this->Form->input('address1', array('class'=>'col-xs-12 col-sm-12 col-md-10', 'rows' => '5', 'cols' => '5','value'=>$arrCompleteLoggedInUserDetail[0]['admin_address']));
										?>
										
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Postal / Zip Code: </label>
										<?php 
									echo $this->Form->input('zipcode', array('class'=>'col-xs-12 col-sm-12 col-md-10','value'=>$arrCompleteLoggedInUserDetail[0]['admin_pin'],'onchange'=>'fnGetLocationDetailFromZip()'));
									?>									
									</div>
									<input type='hidden' name='pstate' id='pstate' value='' /> 
								<input type='hidden' name='pcity' id='pcity' value='' /> 
									
								<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">Country: </label>
									<?php 
								echo $this->Form->input('country', array('class'=>'col-xs-12 col-sm-12 col-md-10','onChange'=>'fnGetStateList(this.value)','options'=>$arrCountryList,'selected'=>$arrCompleteLoggedInUserDetail[0]['country_id']));
									?>								
								</div>
								
								
								<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">State / Province / Region: </label>
								<?php 
									echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','class'=>'col-xs-12 col-sm-12 col-md-10','options'=>$arrStateList,'selected'=>$arrCompleteLoggedInUserDetail[0]['state_id']));
									?>							
								</div>
								<div class="form-group">
										<label class="control-label col-xs-12 col-sm-12 col-md-2" for="lname">City / Town: </label>
								<?php 
						echo $this->Form->input('UserCity', array('class'=>'col-xs-12 col-sm-12 col-md-10','options'=>$arrCityList,'selected'=>$arrCompleteLoggedInUserDetail[0]['city_id']));
					?>						
								</div>	
								
									<div class="form-group">
										<div class="hidden-xs hidden-sm col-md-2"></div>
										<div class="col-xs-12 col-sm-12 col-md-10 page-content-wrapper-buttons">
											
											<?php
					$options = array(
						'label' => 'Edit',
						'name' => 'edit',
						'class' => 'btn btn-primary'
					);
					echo $this->Form->end($options);
				?>
											
										</div>
									</div>
								
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
<?php /*	
<div class="users index">
<div class="edit-panel">
<div id="page-title">
	<h3>Edit Profile</h3>
</div>
	<?php 
		echo $this->Form->create('User',array('inputDefaults' => array(
		'label' => false,
		'div' => false
		)
		)
		);
	?>
	<table cellpadding="0" cellspacing="0" width="80%" style="margin:auto;">
	<tr>
			<th colspan="2"><h3 class="page_header">Basic Information</h3></th>
	</tr>
	<tr>
			<td style="width:27%;"><span id="madatsym" class="madatsym">*</span>User Name:</td>
			<td>
				<?php
					echo $this->Form->input('username',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['username']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>First Name:</td>
			<td>
				<?php 
					echo $this->Form->input('firstname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['admin_fname']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Last Name:</td>
			<td>
				<?php 
					echo $this->Form->input('lname',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['admin_lname']));
				?>
			</td>
	</tr>
	<tr>
		<td colspan="2" style="border:none;height:30px;">&nbsp;</td>
	</tr>
	<tr>
			<th colspan="2">Contact Information</th>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Email Address:</td>
			<td>
				<?php 
					echo $this->Form->input('emailaddress',array('class'=>'validate[required,custom[email]]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['email']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Phone Number:</td>
			<td>
				<?php 
					echo $this->Form->input('contactnumber',array('class'=>'validate[required]','style'=>'width:50%;font-size:90%;','value'=>$arrCompleteLoggedInUserDetail[0]['admin_contact_number']));
				?>
			</td>
	</tr>
	<tr>
			<td>Address Line1:</td>
			<td>
				<?php 
					echo $this->Form->input('address', array('style'=>'width:50%;font-size:90%;','rows' => '5', 'cols' => '5','value'=>$arrCompleteLoggedInUserDetail[0]['admin_address']));
				?>
			</td>
	</tr>
	<tr>
			<td>Address Line2:</td>
			<td>
				<?php 
					echo $this->Form->input('address1', array('style'=>'width:50%;font-size:90%;','rows' => '5', 'cols' => '5','value'=>$arrCompleteLoggedInUserDetail[0]['admin_address1']));
				?>
			</td>
	</tr>
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>Zip / Postal Code:</td>
			<td>
				<?php 
					echo $this->Form->input('zipcode', array('style'=>'width:50%;font-size:90%;','class'=>'validate[required]','value'=>$arrCompleteLoggedInUserDetail[0]['admin_pin'],'onchange'=>'fnGetLocationDetailFromZip()'));
				?>
				<input type='hidden' name='pstate' id='pstate' value='' /> 
				<input type='hidden' name='pcity' id='pcity' value='' /> 
				&nbsp;<img style="display:none;" id="loader" name="loader" src="<?php echo ROUTER::URL('/',true);?>img/loader.gif" />
			</td>
	</tr>
	<tr id="country_row">
			<td><span id="madatsym" class="madatsym">*</span>Country:</td>
			<td>
				<?php 
					echo $this->Form->input('country', array('onChange'=>'fnGetStateList(this.value)','style'=>'font-size:90%;','options'=>$arrCountryList,'selected'=>$arrCompleteLoggedInUserDetail[0]['country_id']));
				?>
			</td>
	</tr>
	<tbody id="state_city" >
	<tr>
			<td><span id="madatsym" class="madatsym">*</span>State / Province / Region:</td>
			<td>
				<span id="statespan">
					<?php 
						echo $this->Form->input('UserState', array('onChange'=>'fnGetCityList(this.value)','style'=>'font-size:90%;','options'=>$arrStateList,'selected'=>$arrCompleteLoggedInUserDetail[0]['state_id']));
					?>
				</span>
			</td>
	</tr>
	<tr id="city">
			<td>City / Town:</td>
			<td>
				<span id="cityspan">
					<?php 
						echo $this->Form->input('UserCity', array('style'=>'font-size:90%;','options'=>$arrCityList,'selected'=>$arrCompleteLoggedInUserDetail[0]['city_id']));
					?>
				</span>
			</td>
	</tr>
	</tbody>
	<tr>
			<td colspan="2" align='center'>
				<?php
					$options = array(
						'label' => 'Edit',
						'name' => 'edit',
						
					);
					echo $this->Form->end($options);
				?>
			</td>
	</tr>
	<!--<tr>
			<th>username</th>
			<th>email</th>
			<th class="actions">Actions</th>
	</tr>-->
	</table>
</div>
</div>*/?>