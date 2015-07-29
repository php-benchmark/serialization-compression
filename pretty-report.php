<?php

$data = json_decode(file_get_contents('charts-igb.json'), 1);
$keys = array_keys($data);

print_r($keys);

$chartData = array();

$encodeKey = $keys[2];
$decodeKey = $keys[5];

$encodeSpeed = $data[$encodeKey];
$decodeSpeed = $data[$decodeKey];


$chartData[$encodeKey . ', php54 vs hhvm'] = filter_pass(array('hhvm', 'php54'), filter_pass(array('snappy', 'raw'), filter_pass(array('serialize', 'igbinary'), $encodeSpeed)));
$chartData[$decodeKey . ', php54 vs hhvm'] = filter_pass(array('hhvm', 'php54'), filter_pass(array('snappy', 'raw'), filter_pass(array('serialize', 'igbinary'), $decodeSpeed)));


//$chartData[$encodeKey . ', vs'] = filter_pass(array('php54:snappy/igbinary', 'hhvm37:snappy/serialize'), $encodeSpeed);
//$chartData[$decodeKey . ', vs'] = filter_pass(array('php54:snappy/igbinary', 'hhvm37:snappy/serialize'), $decodeSpeed);


//$chartData[$encodeKey . ', filtered'] = filter_pass(array('serialize', 'igbinary'), filter_pass(array('raw', 'snappy', 'gzip-1'), $encodeSpeed));
//$chartData[$decodeKey . ', filtered'] = filter_pass(array('serialize', 'igbinary'), filter_pass(array('raw', 'snappy', 'gzip-1'), $decodeSpeed));



$chartData[$encodeKey . ', raw'] = filter_pass('raw', $encodeSpeed);
$chartData[$decodeKey . ', raw'] = filter_pass('raw', $decodeSpeed);

$chartData[$encodeKey . ', compression'] = filter_pass(array('gzip-1', 'gzip-9', 'snappy'), filter_pass('serialize', $encodeSpeed));
$chartData[$decodeKey . ', compression'] = filter_pass(array('gzip-1', 'gzip-9', 'snappy'), filter_pass('serialize', $decodeSpeed));

$chartData[$encodeKey . ', gzip'] = filter_pass(array('gzip'), filter_pass('serialize', $encodeSpeed));
$chartData[$decodeKey . ', gzip'] = filter_pass(array('gzip'), filter_pass('serialize', $decodeSpeed));

$chartData[$encodeKey . ', gzip-1'] = filter_pass(array('gzip-1'), filter_pass('serialize', $encodeSpeed));
$chartData[$decodeKey . ', gzip-1'] = filter_pass(array('gzip-1'), filter_pass('serialize', $decodeSpeed));


$chartData[$keys[6]] = filter_pass('php54', $data[$keys[6]]); // Length, % of raw/serialize
$chartData[$encodeKey] = $encodeSpeed; // encode speed, % of php54:raw/serialize
$chartData[$decodeKey] = $decodeSpeed; // decode speed, % of php54:raw/serialize

save_report($chartData);

function filter_pass($keywords, $data) {
    if (!is_array($keywords)) {
        $keywords = array($keywords);
    }

    foreach ($data as $key => $tmp) {
        $pass = false;

        foreach ($keywords as $keyword) {
            if (strpos($key, $keyword) !== false) {
                $pass = true;
                break;
            }
        }

        if (!$pass) {
            unset($data[$key]);
        }
    }

    return $data;
}


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
    /*
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
    */


    foreach ($charts as $chartName => $series) {
        ++$i;

        $html .= <<<HTML
<div id="hc-$i"></div>
HTML;
        $hcSeries = array();
        foreach ($series as $serieName => &$values) {
            smooth_moving_average($values, 10);
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


    file_put_contents('report-igb-pretty.html', $html);

}

function save_report($charts)
{
    //file_put_contents('charts-igb.json', json_encode($charts));
    render_report($charts);
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



