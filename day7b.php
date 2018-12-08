#!/usr/bin/php
<?php

$input = file_get_contents("day7input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));


foreach($lines as $line) {
	echo $line;
	echo "\n";
	preg_match_all('|Step (.) must be finished before step (.) can begin|', $line, $matches);

	$before = $matches[1][0];
	$after = $matches[2][0];

	if (!is_array($order[$before])) {
		$order[$before] = array('dependencies' => array(), 'taken' => false);
	}
	if (!is_array($order[$after])) {
		$order[$after] = array('dependencies' => array(), 'taken' => false);
	}
	$order[$after]['dependencies'][$before] = FALSE;
}
ksort($order);
print_r($order);


$finishedstr = '';
$second = 0;
$workers = array(
	0 => array('current' => null, 'remaining' => 0),
	1 => array('current' => null, 'remaining' => 0),
	2 => array('current' => null, 'remaining' => 0),
	3 => array('current' => null, 'remaining' => 0),
	4 => array('current' => null, 'remaining' => 0)
);	

for($t=0;$t<1500;$t++) {
	echo $t . "\t"; 

	// display the current state of the workers
	// for($i=0;$i<5;$i++) {
	// 	echo '['.$i.":".$workers[$i]['current'].','.$workers[$i]['remaining'].'] ';
	// }
	// echo "\n";

	//decrement all the workers 
	for($i=0;$i<5;$i++) {
		if ($workers[$i]['remaining'] > 0) {
			$workers[$i]['remaining']--;
		}
		if ($workers[$i]['current'] != null && $workers[$i]['remaining'] == 0) {
			unset($order[$workers[$i]['current']]);
			markasdone($order, $workers[$i]['current']);
			$finishedstr .= $workers[$i]['current'];
			$workers[$i]['current'] = null;
		}
	}

	// each worker tries to grab a task
	for($i=0;$i<5;$i++) {
		if ($workers[$i]['current'] == null) {
			$next = findnext($order);
			if ($next != null) {
				echo "WORKER $i is grabbing task $next \n";
				$workers[$i]['current'] = $next;
				$workers[$i]['remaining'] = ord($next) - 4;
			} else {
//				echo 'there is no task ready for worker '.$i."\n";
				$workers[$i]['current'] = '';
			}
		}
	}

	// echo $t . "\t";
	// echo $workers[0]['current'];
	// echo $workers[1]['current'];
	// echo $workers[2]['current'];
	// echo $workers[3]['current'];
	// echo $workers[4]['current'];
	// echo $finishedstr;

	for($i=0;$i<5;$i++) {
		echo '['.$i.":".$workers[$i]['current'].','.$workers[$i]['remaining'].'] '."\t";
	}
	echo "\n";
	echo $finishedstr;
	echo "\n";

}



function markasdone(&$order, $next) {
	foreach($order as $k=>$o) {
		if (array_key_exists($next, $order[$k]['dependencies'])) {
			// echo "found $next as a dependency of $k \n";
			$order[$k]['dependencies'][$next] = TRUE;
		}
	}
	return $order;
}


function findnext(&$o) {
	foreach($o as $k =>$v) {
		$ready = true;
		if ($v['taken'] == true) {
			$ready = false;
		}
//		echo "\n\nchecking if $k is ready \n";
		foreach($v['dependencies'] as $dep=>$val) {
//			echo "dep $dep $val,";
			if ($val === FALSE) {
				$ready = false;
			}
		}
		if ($ready == true) {
//			echo "yes $k is ready to be taken\n";
			$o[$k]['taken'] = true;
			return $k;
		}		
	}
	return null;
}
