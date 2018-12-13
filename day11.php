#!/usr/bin/php
<?php

$input = file_get_contents("day11input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$serial = 1309;

function get_grid($serial) {

	$grid = array();

	for($x=1;$x<=300;$x++){

		$grid[$x] = array();

		for($y=1;$y<=300;$y++){

			$rackid = $x + 10;
			$power = $rackid * $y;
			$power += $serial;
			$power  = $power * $rackid;

			if ($power > 99) {
				$power = substr($power, -3, 1);
			} else {
				$power = 0;
			}
			$power = $power - 5;

			$grid[$x][$y] = array(
				'power' => $power
			);
		}	
	}
	return $grid;
}
// //Fuel cell at  122,79, grid serial number 57: power level -5.
// Fuel cell at 217,196, grid serial number 39: power level  0.
// Fuel cell at 101,153, grid serial number 71: power level  4.



$grid = get_grid(57);
echo $grid[122][79]['power'];
echo "\n";

$grid = get_grid(39);
echo $grid[217][196]['power'];
echo "\n";

$grid = get_grid(71);
echo $grid[101][153]['power'];
echo "\n";

$grid = get_grid(1309);
$max = 0;
$maxx = null;
$maxy = null;
$maxs = 0;

for($s=1;$s<=300;$s++){
	echo $s . "\n";
	for($x=1;$x<=(300-$s);$x++){
		for($y=1;$y<=(300-$s);$y++){
			$total = 0;
			for($i=0;$i<$s;$i++){
				for($j=0;$j<$s;$j++){
					$total = $total + (int)$grid[$x+$i][$y+$j]['power'];
				}
			}


			if ($total > $max){
				echo "NEW MAX: $max \n";
				$max = $total;
				$maxx = $x;
				$maxy = $y;
				$maxs = $s;
				echo " $maxx,$maxy,$maxs --  $max \n";
			}

//			echo "size $s, $x, $y == total $total, max $max \n";

		}
	}
}
echo " $maxx,$maxy,$maxs --  $max";