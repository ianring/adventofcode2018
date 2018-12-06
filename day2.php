#!/usr/bin/php
<?php

$input = file_get_contents("day2input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$twos = 0;
$threes = 0;

foreach($lines as $line) {
	$letters = str_split($line);

	$count = array();
	foreach($letters as $letter) {
		$count[$letter]++;
	}	

	if (in_array(2, $count)) {
		$twos++;
	}
	if (in_array(3, $count)) {
		$threes++;
	}

}

echo "\n";
echo $twos * $threes;
echo "\n";



foreach($lines as $line1) {
	foreach($lines as $line2) {

		if (levenshtein($line1, $line2) == 1) {
		echo $line1 . "\n";
		echo $line2 . "\n";
		echo levenshtein($line1, $line2);
		echo "\n";

		echo countdiff($line1, $line2);
		echo "\n";
		}

	}
}


function countdiff($s1, $s2) {
	$diff = 0;
	for ($i=0;$i<strlen($s1);$i++){
		if ($s1[$i] != $s2[$i]) {
			$diff++;
		}
	}
	return $diff;
}

//
// wmlnjevbfodamyiqpucrhsukg
// wmlnjevbfodamyiqpucrhsukg