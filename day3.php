#!/usr/bin/php
<?php
//ini_set('memory_limit', '500M');

$input = file_get_contents("day3input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$fabric = array();
for($i=0;$i<1000;$i++){
	for($j=0;$j<1000;$j++){
		$fabric[$i][$j] = false;	
	}
}

$nonoverlapper = 0;

$overlaps = array();

foreach($lines as $line) {

	$parts = explode(' @ ', $line);
	$num = substr($parts[0], 1);
	echo $num;
	echo "\n";

//	print_r($parts);
	$dims = explode(': ', $parts[1]);
//	print_r($dims);

	list($left, $top) = explode(',',$dims[0]);
	list($width, $height) = explode('x',$dims[1]);

	// echo $left . "  ";
	// echo $top . "  ";
	// echo $width . "  ";
	// echo $height . "  ";
	// echo "\n";

	$doesoverlap = false;
	for($x = $left; $x<($left+$width);$x++){
		for($y = $top; $y<($top+$height);$y++){
			if ($fabric[$x][$y] == false) {
				$fabric[$x][$y] = $num;
			} else {
				$doesoverlap = true;
				$prev = $fabric[$x][$y];
				$overlaps[$prev] = 'Y';
				$fabric[$x][$y] = 'X';
			}
		}
	}
	if ($doesoverlap) {
		$overlaps[$num] = 'Y';
	} else {
		$overlaps[$num] = 'N';		
	}

}



print_r($overlaps);

//$nonoverlapper = array_search(false, $overlaps);

$total = 0;
foreach($fabric as $line) {
	foreach($line as $cell) {
		if ($cell == 'X') {
			$total++;
		}
	}
}
	echo "\n";
echo $total;
	echo "\n";

//	echo "\n";
// echo $nonoverlapper;
	// echo "\n";

// drawfabric($fabric);

function drawfabric($fabric) {
	foreach($fabric as $line) {
		echo implode('',$line);
		echo "\n";
	}

}