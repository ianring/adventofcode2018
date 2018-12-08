#!/usr/bin/php
<?php

$input = file_get_contents("day8input.txt");

$nums = explode(" ", $input);

$tree = array();

$tree = build($tree);

function build($tree) {
	global $nums;
	global $metasum;
	$children = array_shift($nums);
	$metalength = array_shift($nums);

	$tree['children'] = array();
	$tree['meta'] = array();

	for($i=0;$i<$children;$i++){
		$tree['children'][] = build($tree);
	}

	for($i=0;$i<$metalength;$i++){
		$meta = array_shift($nums);
		$tree['meta'][] = $meta;
		$metasum += $meta;
	}
	return $tree;
} 

//print_r($tree);


$value = get_value($tree);
echo "\n\n\n";
echo "value is ".$value;
echo "\n\n\n";

function get_value($t) {
	echo "\n";
	$value = 0;
	if (count($t['children']) > 0) {
//		print_r($t);
		foreach($t['meta'] as $k=>$meta) {
//			echo $meta;
			if (array_key_exists(($meta-1), $t['children'])) {
				$value += get_value($t['children'][$meta - 1]);
			}
		}	

	} else {
		echo "this node has no children, so its sum is the metas \n";
		$value = array_sum($t['meta']);
	}
	echo "value is ".$value . "\n";
	return $value;
}


