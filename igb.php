<?php

ini_set('precision', 3);

$stat = array();

$iterationsCount = 1000;
$samplesCount = 1000;

if (isset($_SERVER['argv'][1])) {
    $iterationsCount = $_SERVER['argv'][1];
}

if (isset($_SERVER['argv'][2])) {
    $samplesCount = $_SERVER['argv'][2];
}

//print_r($_SERVER['argv']);

// preparing sample data
/*
$data = array();
for ($i = 0;$i < $samplesCount; ++$i) {
	$data ['test_' . $i]= $i;
}
*/


$data = array();

$point = &$data;
for ($i = 0;$i < $samplesCount; ++$i) {
    $point ['test_' . $i]= $i;

    if (!$i % 50) {
        $point = &$point['deeper'];
    }
    elseif ($i % 10) {
        $point ['test_' . $i] = md5($i);
    }
}

//$data = (object)$data;

include 'render-test.php';
include 'test.php';

echo json_encode($stat);