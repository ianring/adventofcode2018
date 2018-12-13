#!/usr/bin/php
<?php

$input = file_get_contents("day13input.txt");

$lines = preg_split('/\r\n|\n|\r/', $input);

$grid = array();
$y = 0;
foreach($lines as $line) {
	$grid[$y] = str_split($line);
	$y++;
}

$cars = array();

$carchrs = array(
	'^' => 'U',
	'v' => 'D',
	'>' => 'R',
	'<' => 'L'
);

$carid = 0;
foreach($grid as $yk=>$y) {
	foreach($y as $xk=>$x) {
		if (array_key_exists($x, $carchrs)) {
			$cars[] = array(
				'id' => $carid,
				'x' => $xk,
				'y' => $yk,
				'direction' => $carchrs[$x],
				'lastturn' => null
			);
			$carid++;
			if ($x == '<' || $x == '>') {
				$grid[$yk][$xk] = '-';
			}
			if ($x == 'v' || $x == '^') {
				$grid[$yk][$xk] = '|';
			}
		}
		echo $x;
	}
	echo "\n";
}


foreach($grid as $yk=>$y) {
	foreach($y as $xk=>$x) {
		echo $x;
	}
	echo "\n";
}



print_r($cars);

for($t=0;$t<19000;$t++) {
	echo "------- tick $t --------";
	echo "\n";

	$order = get_order_of_cars($cars);
	// print_r($order);

	foreach($order as $o) {
		$car = $cars[$o];

		// check what is at the grid location
		$loc = $grid[$car['y']][$car['x']];
		// echo "car $cark is going ".$car['direction']." at position (".$car['x'].",".$car['y'].") in a position with ".$loc . "\n";

		// in case this car has been deleted in a collision
		if (!array_key_exists($o, $cars)) {
			continue;
		}

		if ($loc == '/') {
			if ($car['direction'] == 'U') {
				// echo "turning R! \n";
				$car['direction'] = 'R';
				$car['x']++;
			}
			elseif ($car['direction'] == 'D') {
				// echo "turning L! \n";
				$car['direction'] = 'L';
				$car['x']--;
			}
			elseif ($car['direction'] == 'L') {
				// echo "turning D! \n";
				$car['direction'] = 'D';
				$car['y']++;
			}
			elseif ($car['direction'] == 'R') {
				// echo "turning U! \n";
				$car['direction'] = 'U';
				$car['y']--;
			}
		}
		elseif ($loc === '\\' ) {
			if ($car['direction'] == 'L') {
				// echo "turning U! \n";
				$car['direction'] = 'U';
				$car['y']--;
			}
			elseif ($car['direction'] == 'R') {
				// echo "turning D! \n";
				$car['direction'] = 'D';
				$car['y']++;
			}
			elseif ($car['direction'] == 'U') {
				// echo "turning L! \n";
				$car['direction'] = 'L';
				$car['x']--;
			}
			elseif ($car['direction'] == 'D') {
				// echo "turning R! \n";
				$car['direction'] = 'R';
				$car['x']++;
			}
		}
		elseif ($loc == '|') {
			if ($car['direction'] == 'U') {
				$car['y']--;
			}
			elseif ($car['direction'] == 'D') {
				$car['y']++;
			}

		}
		elseif ($loc == '-') {
			if ($car['direction'] == 'L') {
				$car['x']--;
			}
			elseif ($car['direction'] == 'R') {
				$car['x']++;
			}
		}
		elseif ($loc == '+') {
			// echo "intersection! ";
			if ($car['lastturn'] == 'R' || $car['lastturn'] == null) {
				// echo "hang a LEFT! \n";
				$car['lastturn'] = 'L';
				// do a left
				if ($car['direction'] == 'U') {
					// echo "turning L! \n";
					$car['direction'] = 'L';
					$car['x']--;
				}
				elseif ($car['direction'] == 'R') {
					// echo "turning U! \n";
					$car['direction'] = 'U';
					$car['y']--;					
				}
				elseif ($car['direction'] == 'D') {
					// echo "turning R! \n";
					$car['direction'] = 'R';
					$car['x']++;					
				}
				elseif ($car['direction'] == 'L') {
					// echo "turning D! \n";
					$car['direction'] = 'D';
					$car['y']++;
				}
			}
			elseif ($car['lastturn'] == 'L') {
				// echo "going straight! \n";
				$car['lastturn'] = 'S';
				// go straight
				if ($car['direction'] == 'U') {
					$car['y']--;
				}
				elseif ($car['direction'] == 'R') {
					$car['x']++;					
				}
				elseif ($car['direction'] == 'D') {
					$car['y']++;					
				}
				elseif ($car['direction'] == 'L') {
					$car['x']--;
				}
			}
			elseif ($car['lastturn'] == 'S') {
				// echo "hang a right! \n";
				$car['lastturn'] = 'R';
				// do a right
				if ($car['direction'] == 'U') {
					// echo "turning R! \n";
					$car['direction'] = 'R';
					$car['x']++;
				}
				elseif ($car['direction'] == 'R') {
					// echo "turning D! \n";
					$car['direction'] = 'D';
					$car['y']++;					
				}
				elseif ($car['direction'] == 'D') {
					// echo "turning L! \n";
					$car['direction'] = 'L';
					$car['x']--;					
				}
				elseif ($car['direction'] == 'L') {
					// echo "turning U! \n";
					$car['direction'] = 'U';
					$car['y']--;
				}
			}
			
		}

		$collision = check_collision($cars, $car);
		if (is_array($collision)) {
			echo "COLLISION!!";
			$car1 = $collision[0];
			$car2 = $collision[1];
			echo "removing cars ".$car1.' and '.$car2;
			unset($cars[$car1]);
			unset($cars[$car2]);

			echo "\n";
				print_r($cars);


			echo "there are ".count($cars).'left'."\n";

			if (count($cars) == 1) {
				echo "ONLY ONE REMAINS ";
				print_r($cars);
				die();
			}

		} else {
			$cars[$o] = $car;
		}
	}
}

function get_order_of_cars($cars) {
	global $grid;
	$order = array();
	foreach($grid as $yk=>$y) {
		foreach($y as $xk=>$x) {
			foreach($cars as $car) {
				if ($car['x'] == $xk && $car['y'] == $yk) {
					$order[] = $car['id'];
				}
			}
		}
	}
	return $order;
}

function dieoncollision($cars, $car) {
	if (check_collision($cars, $car)) {
		die('COLLISION');
	}
}

function check_collision($cars, $car) {
	foreach($cars as $ck => $c) {
		if ($c['id'] != $car['id'] && $c['x'] == $car['x'] && $c['y'] == $car['y']) {
			echo "COLLISION WITH CAR $ck";
			return array($car['id'], $c['id']);
		}
	}
	return false;
}

