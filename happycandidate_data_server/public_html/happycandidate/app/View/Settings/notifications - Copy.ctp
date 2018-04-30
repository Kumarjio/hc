<div class="wrapper">
<div id="portal_registration">
	<?php 
		//echo $this->Form->create('CandidateSettings',array('inputDefaults'=>array('label' => false,'div' => false),'onsubmit'=>'return fnSetCandidateNotification("'.$intPortalId.'");'));
		echo $this->Form->create('CandidateSettings',array('inputDefaults'=>array('label' => false,'div' => false)));
	?>
	<h2 id="jobn">
		Latest Job Listing Notifications
	</h2>
	<ul class="panel-2 margin-top-5">
		<li>
			<!--<label for="job_notifications_yes">Job Notifications?</label>-->
			<?php
				if($intCandidatesSettingsCount)
				{
					if($arrCandidatesSettings[0]['CandidatesSettings']['is_job_notification'])
					{
						?>
							<input type="checkbox" name="job_notifications" id="job_notifications" checked="checked" />&nbsp;<span for="job_notifications">Job Listings will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
							
							<!--<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_yes" value="1" checked="checked">Yes</input>&nbsp;
							<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_no" value="0">No</input>-->
						<?php
					}
					else
					{
						?>
							<input type="checkbox" name="job_notifications" id="job_notifications" />&nbsp;<span for="job_notifications">Job Listings will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
							
							<!--<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_yes" value="1">Yes</input>&nbsp;
							<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_no" value="0" checked="checked">No</input>-->
						<?php
					}
				}
				else
				{
					?>
						<input type="checkbox" name="job_notifications" id="job_notifications" checked="checked" />&nbsp;<span for="job_notifications">Job Listings will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
						
						<!--<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_yes" value="1">Yes</input>&nbsp;
						<input type="radio" name="job_notifications" class="jnotificaton" id="job_notifications_no" value="0" checked="checked">No</input>-->
					<?php
				}
			?>
			
		</li>
		<li>
			&nbsp;
		</li>
		</ul>
		<!--<h2 id="resn">
			Latest Resource Material Notifications
		</h2>
		<ul class="panel-2 margin-top-5">
			<li>
				<!--<label for="material_notifications_yes">Material Notifications?</label>-->
				<!--<?php
					if($intCandidatesSettingsCount)
					{
						if($arrCandidatesSettings[0]['CandidatesSettings']['is_material_notification'])
						{
							?>
								<input type="checkbox" name="material_notifications" class="rnotificaton" id="material_notifications" checked="checked" />&nbsp;<span for="material_notifications">Resource Material will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
								
								<!--<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_yes" value="1" checked="checked">Yes</input>&nbsp;
								<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_no" value="0">No</input>-->
							<!--<?php
						}
						else
						{
							?>
								<input type="checkbox" name="material_notifications" class="rnotificaton" id="material_notifications" />&nbsp;<span for="material_notifications">Resource Material will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
								
								<!--<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_yes" value="1">Yes</input>&nbsp;
								<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_no" value="0" checked="checked">No</input>-->
							<?php
						}
					}
					else
					{
						?>
							<input type="checkbox" name="material_notifications" class="rnotificaton" id="material_notifications" checked="checked" />&nbsp;<span for="material_notifications">Resource Material will be emailed to you from our aggregate job boards that match the search criteria you entered. If you want to change your search criteria, go to My Profile and click on Modify Search.</span>
							
							<!--<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_yes" value="1">Yes</input>&nbsp;
							<input type="radio" name="material_notifications" class="rnotificaton" id="material_notifications_no" value="0" checked="checked">No</input>-->
						<?php
					}
				?>
			</li>-->
			<!--<li>
				&nbsp;
			</li>-->
			<!--<?php
				/*echo "<li>";
				$options = array(
						'label' => 'Set',
						'name' => 'notification_set',
						'div'  => False
				);
				echo $this->Form->end($options);
				echo "</li>";*/
			?>
		</ul>-->
		<!--<h2 id="caradn">
			Career Advisor
		</h2>
		<ul class="panel-2 margin-top-5">
			<li>
				<?php
					
					if($intCandidatesSettingsCount)
					{
						if($arrCandidatesSettings[0]['CandidatesSettings']['is_career_advisor'])
						{
							?>
								<input type="checkbox" name="career_advisor" class="rnotificaton" id="career_advisor" checked="checked" />&nbsp;<span for="career_advisor">You will receive a weekly Career Advisor by email that includes: Important Announcements (about the Current Job Market),  Free Weekly LIVE Job Seekers Webinars (topics, times and sign up information) and Did you Know (trends and requests for your feedback).</span>
							<?php
						}
						else
						{
							?>
								<input type="checkbox" name="career_advisor" class="rnotificaton" id="career_advisor" />&nbsp;<span for="career_advisor">You will receive a weekly Career Advisor by email that includes: Important Announcements (about the Current Job Market),  Free Weekly LIVE Job Seekers Webinars (topics, times and sign up information) and Did you Know (trends and requests for your feedback).</span>
							<?php
						}
					}
					else
					{
						?>
							<input type="checkbox" name="career_advisor" class="rnotificaton" id="career_advisor" />&nbsp;<span for="career_advisor">You will receive a weekly Career Advisor by email that includes: Important Announcements (about the Current Job Market),  Free Weekly LIVE Job Seekers Webinars (topics, times and sign up information) and Did you Know (trends and requests for your feedback).</span>
						<?php
					}
				?>
			</li>
		</ul>-->
		<h2 id="cancan">
			Cancel Account
		</h2>
		<ul class="panel-2 margin-top-5">
			<li>
				<?php
					
					if($intCandidatesSettingsCount)
					{
						if($arrCandidatesSettings[0]['CandidatesSettings']['is_cancel_account'])
						{
							?>
								<input type="checkbox" name="cancel_account" class="rnotificaton" id="cancel_account" checked="checked" />&nbsp;<span for="cancel_account">If you decide to cancel your account, please understand that any 
		Information you have added to your account including work done in the
		Resume Builder and Assessments will be lost.  If you would prefer to keep
your free account open for future job search activities,  but wish to no longer receive any emails from thisSystem, please click to uncheck Latest Job Listings, Notifications, and System Emails
.</span>
							<?php
						}
						else
						{
							?>
								<input type="checkbox" name="cancel_account" class="rnotificaton" id="cancel_account" />&nbsp;<span for="cancel_account">If you decide to cancel your account, please understand that any 
		Information you have added to your account including work done in the
		Resume Builder and Assessments will be lost.  If you would prefer to keep
your free account open for future job search activities,  but wish to no longer receive any emails from thisSystem, please click to uncheck Latest Job Listings, Notifications, and System Emails
.</span>
							<?php
						}
					}
					else
					{
						?>
							<input type="checkbox" name="cancel_account" class="rnotificaton" id="cancel_account" />&nbsp;<span for="cancel_account">If you decide to cancel your account, please understand that any 
		Information you have added to your account including work done in the
		Resume Builder and Assessments will be lost.  If you would prefer to keep
your free account open for future job search activities,  but wish to no longer receive any emails from thisSystem, please click to uncheck Latest Job Listings, Notifications, and System Emails
.</span>
						<?php
					}
				?>
			</li>
		</ul>
		<ul>
			<li>
				&nbsp;
			</li>
			<?php
				
				echo "<li>";
				echo $this->Form->submit('SAVE',array('div'  => False,'class'=>'button_class'));
				echo "&nbsp;";
				echo $this->Form->button('CANCEL', array('type' => 'reset','div'  => False,'class'=>'button_class'));
				/*$options = array(
						'label' => 'SAVE',
						//'name' => 'notification_set',
						'name' => 'Setting',
						'div'  => False,
						'class' => 'button_class'
				);
				echo $this->Form->end($options);*/
				echo $this->Form->end();
				echo "</li>";
			?>
		</ul>
</div>
</div>