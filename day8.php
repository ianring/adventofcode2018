#!/usr/bin/php
<?php

$input = file_get_contents("day8input.txt");

$nums = explode(" ", $input);

print_r($nums);

$tree = array();

$tree = build($tree);

function build($tree) {
	global $nums;
	global $metasum;
	echo "new child \n";
	$children = array_shift($nums);
echo "node children: ".$children . "\n";
	$metalength = array_shift($nums);
echo "meta length: ".$children . "\n";

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

print_r($tree);

echo "\n\n\n";
echo $metasum;
echo "\n\n\n";

