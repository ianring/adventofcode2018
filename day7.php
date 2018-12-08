#!/usr/bin/php
<?php

$input = file_get_contents("day7input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$order = array();


foreach($lines as $line) {
	echo $line;
	echo "\n";
	preg_match_all('|Step (.) must be finished before step (.) can begin|', $line, $matches);

	$before = $matches[1][0];
	$after = $matches[2][0];

	if (!is_array($order[$before])) {
		$order[$before] = array();
	}
	if (!is_array($order[$after])) {
		$order[$after] = array();
	}
	$order[$after][$before] = 'FALSE';
}

ksort($order);
print_r($order);

$str = '';
while(count($order) > 0) {
	$next = findnext($order);

	echo "NEXT ONE IS ".$next."\n\n";

	$str .= $next;
	unset($order[$next]);
	$order = markasdone($order, $next);
//	print_r($order);
//	
	echo "\n\n\n";
}

echo "\n\n\n\n";
echo $str;
echo "\n\n\n\n";


function markasdone($order, $next) {
	echo "marking $next as done \n";
	foreach($order as $k=>$o) {
		if (array_key_exists($next, $order[$k])) {
			echo "found $next as a dependency of $k \n";
			$order[$k][$next] = 'TRUE';
		}
	}
	return $order;
}

function findnext($o) {
	foreach($o as $k =>$v) {
		$ready = 'TRUE';
//		echo "\n\nchecking if $k is ready \n";
		foreach($v as $dep=>$val) {
//			echo "dep $dep $val,";
			if ($val === 'FALSE') {
				$ready = 'FALSE';
			}
		}
		if ($ready == 'TRUE') {
			echo "yes $k is ready \n";
			return $k;
		}		
	}
}

		// echo implode('',$order);
		// echo "\n";
		// echo "\n";


// 	// test it
// 	// 
// 	echo "\n";
// 	echo "========== TESTING =========";
// 	echo "\n";

// 	foreach($lines as $line) {
// 		preg_match_all('|Step (.) must be finished before step (.) can begin|', $line, $matches);

// 		$before = $matches[1][0];
// 		$after = $matches[2][0];

// 		$beforepos = $pos = array_search($before, $order);
// 		$afterpos = $pos = array_search($after, $order);

// 		if ($beforepos > $afterpos) {
// 			echo "\n\n";
// 			echo "FAIL!!! ".$before." ".$after;
// 			echo "\n\n";
// 			echo "\n\n";
// 			echo "\n\n";
// 		}
// 	}
// }

