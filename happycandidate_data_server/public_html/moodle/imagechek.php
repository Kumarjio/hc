<?php
	require_once("config.php");
	//require_once($CFG->libdir. '/datalib.php');
	//require_once($CFG->dirroot.'/course/lib.php');
	require_once($CFG->libdir. '/accesslib.php');
	
	global $DB;
	$context = context_course::instance("15");
	//echo "--".$context->id;
	
	$url = $CFG->wwwroot."/pluginfile.php/136/badges/badgeimage/1/f1";
?>
<img class="badge-image" src="<?php echo $url; ?>">