#!/usr/bin/php
<?php


$input = file_get_contents("day1input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$tracker = array();

$total = 0;
for($i=0;$i<200;$i++){
foreach($lines as $line) {
	$add = intval($line);
	$total += $add;
	if (isset($tracker[$total])) {
		echo "\n\n"." $total reached twice!"."\n\n";
		die();
	}
	$tracker[$total] = true;
}
}
echo "\n";
echo "\n";
echo $total;
echo "\n";
