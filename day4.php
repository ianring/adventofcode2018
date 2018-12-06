#!/usr/bin/php
<?php

$input = file_get_contents("day4input.txt");

$lines = preg_split('/\r\n|\n|\r/', trim($input));

$times = array();
foreach ($lines as $line) {
	$spl = explode('] ', $line);
	$t = substr($spl[0], 1);
	//$time = strtotime($t);

	$instr = $spl[1];

	$times[$t] = $instr;
}

ksort($times);

$guardsleeptime = array();
$awake = true;

$minutesasleep = array();
for($i=0;$i<60;$i++) {
	$minutesasleep[$i] = 0;
}

$winminute = -1;
$winguard = -1;
$wintimes = -1;

foreach($times as $time => $instr) {
	if (preg_match('|Guard #\d+ begins shift|', $instr)) {
		preg_match_all('|Guard #(\d+) begins shift|', $instr, $matches);
		$guard = $matches[1][0];
		echo "start of shift for guard $guard" . "\n";
	}

	if (!is_array($guardsleeptime[$guard]['minutes'])) {
		$guardsleeptime[$guard]['minutes'] = array();
		for($i=0;$i<60;$i++) {
			$guardsleeptime[$guard]['minutes'][$i] = 0;
		}
		$guardsleeptime[$guard]['total'] = 0;
	}

	if ($instr == 'falls asleep') {
		$awake = false;
		$spltime = explode(':',$time);
		$min = $spltime[1];

		$snoozetime = $min;
		echo "falls asleep at ".$time."\n";
	}

	if ($instr == 'wakes up') {
		echo "wakes up at ".$time."\n";

		$spltime = explode(':',$time);
		$min = $spltime[1];

		$wasasleep = $min - $snoozetime;
		echo "was asleep for ".$wasasleep."\n\n";

		$guardsleeptime[$guard]['total'] += $wasasleep;

			for($i = $snoozetime;$i <= $min; $i++) {
				$guardsleeptime[$guard]['minutes'][$i]++;
			}
	}

}

//print_r($guardsleeptime);
asort($guardsleeptime);
print_r($guardsleeptime);

foreach($guardsleeptime as $guardnum => $guard) {
	foreach($guard['minutes'] as $minnum => $min) {
		if ($min > $wintimes) {
			echo "\n".$min.' is higher than '.$wintimes;
			echo "\n";
			$winguard = $guardnum;
			$winminute = $minnum;
			$wintimes = $min;
		}
	}
}

echo 'winning guard is '.$winguard; 
echo ' winning minute is '.$winminute; 

print_r($guardsleeptime[733]);


// the guard who slept the most was 2851
// 
// 

//print_r($minutesasleep);


//echo 2851 * 44;
echo 733 * 25;


// print_r($times);
