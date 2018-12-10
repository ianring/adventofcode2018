#!/usr/bin/php
<?php

$input = file_get_contents("day10input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$minx = 0;
$maxx = 0;
$miny = 0;
$maxy = 0;

$points = array();
foreach($lines as $line) {
	preg_match_all('|position=<([\s\-0-9]+), ([\s\-0-9]+)> velocity=<([\s\-0-9]+), ([\s\-0-9]+)>|', $line, $matches);

	$minx = min($minx, $matches[1][0]);
	$maxx = max($maxx, $matches[1][0]);

	$miny = min($miny, $matches[2][0]);
	$maxy = max($maxy, $matches[2][0]);

	$points[] = array(
	 	'x' => $matches[1][0],
	 	'y' => $matches[2][0],
	 	'velx' => $matches[3][0],
	 	'vely' => $matches[4][0],
	);
}

for ($t=10941;$t<10950;$t++) {

echo "\n";
echo "\n";
echo $t;
echo "\n";

	$minx = 0;
	$maxx = 0;
	$miny = 0;
	$maxy = 0;

	for ($i=0;$i<count($points);$i++) {
		$newx = $points[$i]['x'] + ($points[$i]['velx'] * $t);
		$newy = $points[$i]['y'] + ($points[$i]['vely'] * $t);

		$minx = min($minx, $newx);
		$maxx = max($maxx, $newx);

		$miny = min($miny, $newy);
		$maxy = max($maxy, $newy);

		$width = $maxx - $minx;
		$height = $maxy - $miny;
	}

	$grid = array();
	for($i=$minx;$i<$maxx;$i++) {		
		$grid[$i] = array();
		for($j=$minx;$j<$maxx;$j++) {
			$grid[$i][$j] = '.';
		}
	}
	for ($i=0;$i<count($points);$i++) {
		$newx = $points[$i]['x'] + ($points[$i]['velx'] * $t);
		$newy = $points[$i]['y'] + ($points[$i]['vely'] * $t);
		$grid[$newx][$newy] = '#';
	}

	foreach($grid as $x) {
		foreach($x as $c) {
			echo $c;
		}
		echo "\n";
	}


	// echo "$t : $width, $height \n";
}

