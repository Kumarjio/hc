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


Hi There ,<br>

<p>Look what I found at&nbsp; <a href="<?php echo $link;?>">Click Here</a> I thought this might help you with your job searching. I think you might find this job of interest.</p>
<p>Comments: <?php echo $comments;?></p><p><br /> NOTE: You received this message because your friend shared this job with you from <a href="<?php echo Router::url('/', true); ?>"><?php echo Router::url('/', true); ?></a>.</p>
<b>Thanks</b>
<b>Hc Team</b>
