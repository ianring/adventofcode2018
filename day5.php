#!/usr/bin/php
<?php

$input = file_get_contents("day5input.txt");

$polies = array();

for($j=97;$j<=122;$j++) {
	$poly = chr($j);
	echo 'reacting with '.strtoupper($poly).' removed:';
	echo "\n";

	$copy = $input;
	$copy = str_replace($poly,'',$copy);
	$copy = str_replace(strtoupper($poly),'',$copy);

	$found = true;

	while ($found) {
		$found = false;
		for($i=97;$i<=122;$i++) {
			$str = chr($i) . strtoupper(chr($i));

			if (strpos($copy, $str) !== FALSE) {
				$copy = str_replace($str, '', $copy);
//				echo 'found '.$str."\n";
				$found = true;
			}

			$str =  strtoupper(chr($i)) . chr($i);

			if (strpos($copy, $str) !== FALSE) {
				$copy = str_replace($str, '', $copy);
//				echo 'found '.$str."\n";
				$found = true;
			}

		}

//		echo strlen($copy) . "\n\n";
//		echo $copy . "\n\n";

	}
	
	$polies[$poly] = strlen($copy);

		echo strlen($copy) . "\n\n";
}
echo "\n\n";

echo min($polies);
echo "\n\n";
