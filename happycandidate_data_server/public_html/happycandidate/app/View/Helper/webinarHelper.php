<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class webinarHelper extends AppHelper {
	
	

	public function fnGetLatestWebinar()
	{
		      App::import('Model', 'Content'); 
			 $Content = new Content();
			$today = "'".date('Y-m-d')."'";
			

 $latestwebinar = $Content->find('first', array(
			'fields' => array('Content.content_id'),
				'joins' => array(
				array(
					'table' => 'content_category_assignment',
					'alias' => 'content_category_assignment',
					'type' => 'left',
					'recursive' => -1,
					'conditions'=> array('Content.content_id = content_category_assignment.content_id')
			  ),
				array(
				'table' => 'content_category',
				'alias' => 'content_category',
				'type' => 'left',
				'recursive' => -1,
				'conditions'=> array('content_category.content_category_id = content_category_assignment.category_id')
				)),
			'conditions' =>array('date(Content.created_date)>='.$today,'content_type=2')));			
			//echo $strContentQuery =" SELECT distinct content.* FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_status = 'published'  and content.content_type= 2 and date(content_published_date)>= '".$today."' ORDER BY content.content_id ASC limit 1";
			//exit();
			//$strContentAsPerCat = $this->query($strContentQuery);
			return $latestwebinar;
			
	
			
	}
}
