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
		$grid[$i][$j] = '-';
	}
}

//display($grid);

foreach($grid as $x=>$col) {
	foreach($col as $y=>$cell) {
		$pointdists = array();
		foreach($coords as $pointnum=>$coord) {
			$dist = manhattandistance($x, $y, $coord[0], $coord[1]);
			$pointdists[$pointnum] = $dist;
//			echo $dist . "\n";
		}
		asort($pointdists);
//		echo "point distances: \n\n";
//		print_r($pointdists);
		$d = array_keys($pointdists);
		if ($pointdists[$d[0]] == $pointdists[$d[1]]) {
			$grid[$x][$y] = '.';
			echo 'two are the same distance!' . "\n";
		} else {
			$grid[$x][$y] = $d[0];
		}

	}
	echo '.';
}

display($grid);

$counts = array();
$infinites = array();
$firstrow = true;
foreach($grid as $x=>$col) {
	$firstcol = true;
	$val = -1;
	foreach($col as $y=>$cell) {
		$val = $grid[$x][$y];
		if ($firstrow) {
			$infinites[$val] = true;
			$firstrow = false;
		}
		if ($firstcol) {
			$infinites[$val] = true;
			$firstcol = false;
		}
		$counts[$val]++;
	}
	$lastcol = $val;
	$infinites[$lastcol] = true;
}

print_r($counts);
print_r($infinites);

foreach(array_keys($infinites) as $inf) {
	unset($counts[$inf]);
}

asort($counts);
print_r($counts);

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