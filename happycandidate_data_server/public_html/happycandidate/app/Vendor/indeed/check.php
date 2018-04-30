<?php
	require 'src/indeed.php';

	$client = new Indeed("4991231526397630");

	$params = array(
		"q" => "php",
		"l" => "austin",
		"userip" => "1.2.3.4",
		"useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"
	);

	$results = $client->search($params);
	
	print("<pre>");
	print_r($results);


	$params = array(
		"jobkeys" => array("d506d5dd7ce9cd38", "781b599b4f026eec"),
	);

	$results = $client->jobs($params);
	
	print("<pre>");
	print_r($results);

	
	exit;
?>