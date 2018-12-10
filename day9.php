#!/usr/bin/php
<?php


function playgame($numplayers, $numturns) {

	echo "\n";
	$circle = array(0 => 0);
	$currentplayer = 1;
	$currentmarblepos = 0;
	$currentpos = 0;
	$players = array(
	);

	for($i=1;$i<=$numplayers;$i++) {
		$players[$i] = array('score' => 0);
	}

	echo '0' . ' - ' .'[-]'.implode(', ',$circle) . "\n";

	for ($turn = 1; $turn <= $numturns; $turn++) {

		$newpercentdone = floor($turn / $numturns * 100);
		if ($newpercentdone != $percentdone) {
			echo "$newpercentdone % ($turn / $numturns) \n";
			$percentdone = $newpercentdone;
		}

		if ($turn % 23 == 0 && $turn !== 0) {
			$players[$currentplayer]['score'] += $turn;

			$newpos = $currentpos - 7;
			if ($newpos < 0) {
				$newpos = count($circle) + $newpos;
			}

			$players[$currentplayer]['score'] += $circle[$newpos];
			array_splice($circle, $newpos, 1);

		} else {

			$newpos = $currentpos + 1;
			if (count($circle) > 0) {
				$newpos = $newpos % count($circle) + 1;
			}
			array_splice($circle, $newpos, 0, $turn);
		}

		// echo $turn . ' - ' .'['.$currentplayer.']';
		// foreach($circle as $k=>$c) {
		// 	if ($k == $newpos) {
		// 		echo '('.$c.'), ';
		// 	} else {
		// 		echo $c.', ';
		// 	}
		// }
		// echo "\n";

		$currentplayer++;
		if ($currentplayer > $numplayers) {
			$currentplayer = 1;
		}

		$currentpos = $newpos;

	}

	print_r($players);
	$highscore = 0;
	foreach($players as $player) {
		$highscore = max($highscore, $player['score']);
	}
	return $highscore;
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

$h = playgame(439, 71307);
echo "\n" . $h . "\n";

