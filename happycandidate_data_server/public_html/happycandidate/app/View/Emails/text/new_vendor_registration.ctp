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
<?php
	if($editmode)
	{
		?>
			<p align="justify"> Your Account details were just updated by HC.</p>
		<?php
	}
	else
	{
		?>
			<p align="justify"> Your Account has just been created by HC.</p>
		<?php
	}
?>
<p align="justify"> Here are your account details; -.</p>
<p align="justify"> Username / Email: <?php echo $username;?></p>
<p align="justify"> Password: <?php echo $password;?></p>
<p><b>Thanks</b></p>
