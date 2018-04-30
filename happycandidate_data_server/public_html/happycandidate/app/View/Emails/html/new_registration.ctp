<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>


<p> Hi There <?php echo $first_name;?>,</p>
<p align="justify"> Thanks for registering with Happy Candidates.</p>
<?php
	if($userpassword)
	{
		?>
			<p align="justify"> Your User name is your email.</p>
			<p align="justify"> Your Password is <?php echo $userpassword;?>.</p>
		<?php
	}
	else
	{
		?>
			<p align="justify"> Inorder to complete and confirm you Registration, Please click <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'confirmation',base64_encode($user_id)),true); ?>">Here</a>.</p>
			
			<p align="justify"> You will also have to activate your subscription inorder to access the account, Please click <a href='<?php echo $this->Html->url(array('controller'=>'users','action'=>'confirmation',base64_encode($user_id),base64_encode("subscribe")),true); ?>'>Here</a> for activating subscription</p>
			
		<?php
	}
?>
<p><b>Thanks</b></p>