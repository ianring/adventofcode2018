#!/usr/bin/php
<?php

$input = file_get_contents("day1input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$tracker = array();

$total = 0;
for($i=0;$i<200;$i++){
	foreach($lines as $line) {
		$total += intval($line);
		if (isset($tracker[$total])) {
			echo "\n\n"." $total reached twice!"."\n\n";
			die();
		}
		$tracker[$total] = true;
	}
}
echo $total;
