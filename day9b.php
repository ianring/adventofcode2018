#!/usr/bin/php
<?php

ini_set('memory_limit','3000M');

function playgame($numplayers, $numturns) {

	$deque = array(
		0 => array('next' => 0, 'prev' => 0)
	);


	echo "\n";
	$currentplayer = 1;
	$currentmarble = 0;
	$players = array();

	for($i=1;$i<=$numplayers;$i++) {
		$players[$i] = array('score' => 0);
	}

	for ($turn = 1; $turn <= $numturns; $turn++) {

		if ($turn % 23 == 0 && $turn !== 0) {
			$players[$currentplayer]['score'] += $turn;

			// go back 7 steps
			for($i=0;$i<7;$i++) {
				$currentmarble = $deque[$currentmarble]['prev'];
			}

			$players[$currentplayer]['score'] += $currentmarble;

			// delete that one
			$prev = $deque[$currentmarble]['prev'];
			$next = $deque[$currentmarble]['next'];
			unset($deque[$currentmarble]);
			$deque[$prev]['next'] = $next;
			$deque[$next]['prev'] = $prev;

			$currentmarble = $next;

		} else {

			$currentmarble = $deque[$currentmarble]['next'];
			$aftermarble = $deque[$currentmarble]['next']; 
			$deque[$currentmarble]['next'] = $turn;
			$deque[$aftermarble]['prev'] = $turn;
			$deque[$turn] = array(
				'next' => $aftermarble, 
				'prev' => $currentmarble
			);
			$currentmarble = $turn;			
		}

		// display($deque, $currentmarble);

		$currentplayer++;
		if ($currentplayer > $numplayers) {
			$currentplayer = 1;
		}

		$currentpos = $newpos;

	}

	$highscore = 0;
	foreach($players as $player) {
		$highscore = max($highscore, $player['score']);
	}
	return $highscore;
}

function display($deque, $current = 0) {
	echo '0, ';
	$next = $deque[0]['next'];
	while($next != 0) {
		if ($next == $current) {
			echo '('.$next.'), ';
		} else {
			echo $next . ', ';
		}
		$next = $deque[$next]['next'];
	}
	echo "\n";
}



// test cases
// 
// 10 players; last marble is worth 1618 points: high score is 8317
// 13 players; last marble is worth 7999 points: high score is 146373
// 17 players; last marble is worth 1104 points: high score is 2764
// 21 players; last marble is worth 6111 points: high score is 54718
// 30 players; last marble is worth 5807 points: high score is 37305

// $h = playgame(9, 25);
// echo "\n" . $h . "\n";

// $h = playgame(9, 50);
// echo "\n" . $h . "\n";

// $h = playgame(9, 100);
// echo "\n" . $h . "\n";

// $h = playgame(10, 1618);
// echo "\n" . $h . "\n";

// $h = playgame(13, 7999);
// echo "\n" . $h . "\n";

// $h = playgame(17, 1104);
// echo "\n" . $h . "\n";

// $h = playgame(21, 6111);
// echo "\n" . $h . "\n";

// $h = playgame(30, 5807);
// echo "\n" . $h . "\n";

// part 1 is this
// $h = playgame(439, 71307);
// echo "\n" . $h . "\n";

// part 2
$h = playgame(439, 7130700);
echo "\n" . $h . "\n";


