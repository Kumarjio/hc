<?php
/*
 * @package		mod-skillsoft
 * @author		$Author: martinholden1972@googlemail.com $
 * @version		SVN: $Header: https://moodle2-skillsoft-activity.googlecode.com/svn/trunk/skillsoft/db/access.php 148 2014-09-04 15:00:41Z martinholden1972@googlemail.com $
 * @copyright	2009-2014 Martin Holden
 * @license		http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$capabilities = array(

    'mod/skillsoft:viewreport' => array(

        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'admin' => CAP_ALLOW
	)
	),

    'mod/skillsoft:addinstance' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    ),

);