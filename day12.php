#!/usr/bin/php
<?php

//$input = file_get_contents("day12input.txt");


$state = '#..#.#..##......###...###';
$state = '#.#.#....##...##...##...#.##.#.###...#.##...#....#.#...#.##.........#.#...#..##.#.....#..#.###';

$s = str_split($state);
//echo implode('',$s);
print_r($s);

$rules = array(
'...##' => '#',
'..#..' => '#',
'.#...' => '#',
'.#.#.' => '#',
'.#.##' => '#',
'.##..' => '#',
'.####' => '#',
'#.#.#' => '#',
'#.###' => '#',
'##.#.' => '#',
'##.##' => '#',
'###..' => '#',
'###.#' => '#',
'####.' => '#'
);

$rules = array(
'####.' => '#',
'..#..' => '.',
'#.#..' => '.',
'.##..' => '.',
'##...' => '.',
'#.##.' => '#',
'##.#.' => '.',
'##..#' => '.',
'.###.' => '.',
'.#.##' => '.',
'.#..#' => '#',
'.....' => '.',
'###..' => '#',
'#..##' => '.',
'##.##' => '.',
'#....' => '.',
'...##' => '#',
'....#' => '.',
'#.#.#' => '#',
'###.#' => '.',
'.####' => '#',
'.#...' => '#',
'#.###' => '.',
'..###' => '.',
'.#.#.' => '#',
'.##.#' => '.',
'#..#.' => '#',
'...#.' => '.',
'#...#' => '#',
'..##.' => '.',
'#####' => '#',
'..#.#' => '#'
);



$startat = 0;
$endat = count($s);
for($t=0;$t<200;$t++) {
//	echo $t . ' ' . implode('',$s) . "\n";
	echo $t . ' ';
	display($s);
	$newstate = array();

	for($p=$startat;$p<$endat;$p++) {

		$word = '';
		for ($i=-2;$i<=2;$i++) {
			if (!array_key_exists($i + $p, $s)) {
				$word .= '.';
			} else {
				$word .= $s[$i + $p];
			}
		}

//		echo $p . ' - ' . $word . "\n";

//		echo "\n";
//		echo $word;
		if (array_key_exists($word, $rules)) {
//			echo "  found ";
			$newstate[$p] = $rules[$word];
		} else {
//			echo " not found ";
			$newstate[$p] = '.';
		}
	}
	$startat = $startat - 2;
	$endat = $endat + 2;
	$s = $newstate;
}

$sum = 0;
foreach($s as $k=>$pot) {
	if ($pot == '#') {
		$sum+=$k;
	}
}
echo $sum;
echo "\n";


function display($s) {
	for ($i=-10;$i<250;$i++) {
		if (array_key_exists($i, $s)) {
			echo $s[$i];
		} else {
			echo '.';
		}
	}

	$sum = 0;
	foreach($s as $k=>$pot) {
		if ($pot == '#') {
			$sum+=$k;
		}
	}

	echo " sum: ".$sum;
	echo "\n";
}



echo amountat(111);
	echo "\n";
echo amountat(112);
	echo "\n";
echo amountat(113);
	echo "\n";
echo amountat(50000000000);
	echo "\n";

function amountat($t) {
	return 2728 + (20 * ($t - 111));
}