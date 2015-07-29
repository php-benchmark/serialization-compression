<?php

set_time_limit(0);
ini_set('precision', 3);


$workerExtPath = array(
    'php54' => '/home/ubuntu/php54/lib/php/extensions/no-debug-non-zts-20100525/',
    'php55' => '/home/ubuntu/php55/lib/php/extensions/no-debug-non-zts-20121212/',
    'php56' => '/home/ubuntu/php56/lib/php/extensions/no-debug-non-zts-20131226/',
);

$workerExt = array(
    'php54' => array('snappy.so', 'igbinary.so', 'msgpack.so'),
    'php55' => array('snappy.so', 'igbinary.so', 'msgpack.so'),
    'php56' => array('snappy.so', 'igbinary.so', 'msgpack.so'),
);

$workers = array(
    'php53' => '~/php53/bin/php',
    'php54' => '~/php54/bin/php',
    'php55' => '~/php55/bin/php',
    'php56' => '~/php56/bin/php',
    //'php56' => '/opt/php-5.6.6/bin/php',
    'php7' => '~/php7b1/bin/php',
    'hhvm39' => 'hhvm',
    //'hhvm36' => '/usr/bin/hhvm --config /etc/hhvm/server.ini --config /etc/hhvm/php.ini',
);

/*
foreach ($workerExt as $worker => $extensions) {
    foreach ($extensions as $ext) {
        $workers[$worker] .= ' -dextension=' . $workerExtPath[$worker] . $ext;
    }
}
*/

/*
$workers = array(
    'php' => 'php',
);
*/

$series = array();

$compressionOptions = array('raw', 'snappy', 'gzip', 'deflate');

$iterationsCount = 1000;

/*
$samplesCounts = array(
	50,
	100,
	200,
	300,
	400,
	500,
	700,
	1000,
	2000,
	3000,
	5000
);
*/

$samplesCounts = array_merge(range(10, 700, 20), range(700, 3000, 100), range(3500, 50000, 1000));


foreach ($samplesCounts as $samplesCount) {
    $normResult = false;


    foreach ($workers as $workerName => $worker) {
        echo "$workerName $samplesCount\n";

        $iterationsCount = round(10000 / $samplesCount);
        if ($iterationsCount < 10) {
            $iterationsCount = 10;
        }


	    $command = $worker . ' igb.php ' . $iterationsCount . ' ' . $samplesCount;
	    //echo $command . PHP_EOL;
            $result = exec($command);

	    echo $result . PHP_EOL;
            $result = json_decode($result, 1);


            if (!$result) {
                continue;
            }

                if (!$normResult) {
                    $mainWorker = $workerName;
                    $normResult = $result;
                    $normTest = key($normResult['encode']);
                }
            /*
                    foreach ($result['length'] as $test => length) {

                    }
            */

            $length = $result['length'];
            unset($result['length']);

            foreach ($result as $direction => $stat) {
                foreach ($stat as $test => $time) {
                    $norm = $normResult[$direction][$normTest];

                    $l = $length[$test];
                    $normLen = $normResult['length'][$normTest];

                    $charts [$direction . ' speed, b/s'][$workerName . ':' . $test] [] = array($normLen, $iterationsCount * $l / $time);
                    $charts [$direction . ' speed, elements/s'][$workerName . ':' . $test] [] = array($normLen, $iterationsCount * $samplesCount / $time);
                    $charts [$direction . ' speed, % of ' . $mainWorker . ':' . $normTest][$workerName . ':' . $test] [] = array($normLen, 100 * $norm / $time);
                }
            }

            foreach ($length as $test => $l) {
                //$charts['Length, b'][$workerName . ':' . $test] [] = array($samplesCount, $l);
                $charts['Length, % of ' . $normTest][$workerName . ':' . $test] [] = array($samplesCount, 100 * $l / $length[$normTest]);

            }

    }
    save_report($charts);
}

save_report($charts);


function render_report($charts)
{

    $html = <<<HTML
<html>
<head>
<title>Report</title>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
</head>
<body>
HTML;

    $i = 0;
    foreach ($charts as $chartName => $series) {
        ++$i;

        $html .= <<<HTML
<div id="hc-$i"></div>
HTML;
        $hcSeries = array();
        foreach ($series as $serieName => &$values) {
            $hcSeries [] = array('name' => $serieName, 'data' => $values);
        }
        $hcSeries = json_encode($hcSeries);


        $html .= <<<HTML
<script type="text/javascript">
$(function () {
    $('#hc-$i').highcharts({
        chart: {
            type: 'line',
            zoomType: 'xy'
        },

        title:false,
        credits:{enabled:false},
        plotOptions:{series:{marker:{enabled:false}}},
        yAxis:{title:{text:"$chartName"}},
        series: $hcSeries
    });
});
</script>
HTML;

    }


    foreach ($charts as $chartName => $series) {
        ++$i;

        $html .= <<<HTML
<div id="hc-$i"></div>
HTML;
        $hcSeries = array();
        foreach ($series as $serieName => &$values) {
            smooth_moving_average($values, 12);
            $hcSeries [] = array('name' => $serieName, 'data' => $values);
        }
        $hcSeries = json_encode($hcSeries);


        $html .= <<<HTML
<script type="text/javascript">
$(function () {
    $('#hc-$i').highcharts({
        chart: {
            type: 'line',
            zoomType: 'xy'
        },

        title:false,
        credits:{enabled:false},
        plotOptions:{series:{marker:{enabled:false}}},
        yAxis:{title:{text:"$chartName"}},
        series: $hcSeries
    });
});
</script>
HTML;

    }


    $html .= <<<HTML
</body>
</html>
HTML;


    file_put_contents('report-igb.html', $html);

}

function save_report($charts)
{
    file_put_contents('charts-igb.json', json_encode($charts));
    render_report($charts);
}

function prepare_report($charts)
{

}


function smooth_moving_average(&$data, $width = 5)
{
    for ($i = 0; $i < $width; ++$i) {
        $avg [] = $data[0][1];
    }

    foreach ($data as &$item) {
        array_shift($avg);
        $value = $item[1];
        array_push($avg, $value);
        $item[1] = array_sum($avg) / $width;

    }
}

