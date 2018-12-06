#!/usr/bin/php
<?php

$input = file_get_contents("day6input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$coords = array();
$grid = array();

foreach($lines as $line) {
	$coords[] = explode(', ',$line);
}

//print_r($coords);
//die();

$width = 0;
$height = 0;
foreach($coords as $coord) {
	$width = max($width, $coord[0]);
	$height = max($height, $coord[1]);
}

echo $width . " " . $height . "\n\n";

// make an empty grid of dots
for($i=0;$i<$height;$i++) {
	for($j=0;$j<$width;$j++) {
		$grid[$i][$j] = '.';
	}
}

//display($grid);
$areasize = 0;

foreach($grid as $x=>$col) {
	foreach($col as $y=>$cell) {

		$totaldist = 0;
		foreach($coords as $pointnum=>$coord) {
			$dist = manhattandistance($x, $y, $coord[0], $coord[1]);
			$totaldist += $dist;
		}

		if ($totaldist < 10000) {
			$grid[$x][$y] = 'X';
			$areasize++;
		} else {
			$grid[$x][$y] = '/';
		}

	}
}

display($grid);

echo "\n\n";
echo $areasize;
echo "\n\n";

function display($g) {
	foreach($g as $y=>$col) {
		foreach($col as $x=>$cell) {
			echo ' ';
			echo $g[$y][$x];
		}
		echo "\n\n";	
	}
}


function manhattandistance($x1, $y1, $x2, $y2) {
	return  abs($x2-$x1) + abs($y2-$y1);
}