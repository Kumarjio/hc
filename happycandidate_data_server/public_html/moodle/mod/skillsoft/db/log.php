<?php
/*
 * @package		mod-skillsoft
 * @author		$Author: martinholden1972@googlemail.com $
 * @version		SVN: $Header: https://moodle2-skillsoft-activity.googlecode.com/svn/trunk/skillsoft/db/log.php 148 2014-09-04 15:00:41Z martinholden1972@googlemail.com $
 * @copyright	2009-2014 Martin Holden
 * @license		http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$logs = array(
    array('module'=>'skillsoft', 'action'=>'add', 'mtable'=>'skillsoft', 'field'=>'name'),
    array('module'=>'skillsoft', 'action'=>'update', 'mtable'=>'skillsoft', 'field'=>'name'),
    array('module'=>'skillsoft', 'action'=>'view', 'mtable'=>'skillsoft', 'field'=>'name'),
	array('module'=>'skillsoft', 'action'=>'view all', 'mtable'=>'skillsoft', 'field'=>'name')
);
