<?php

$matrix = array(
    'compress' => array(
        'raw' => '$string',
        'snappy' => 'snappy_compress($string)',
        'gzip-9' => 'gzcompress($string, 9)',
        'gzip-6' => 'gzcompress($string, 6)',
        'gzip-3' => 'gzcompress($string, 3)',
        'gzip-1' => 'gzcompress($string, 1)',

    ),

    'decompress' => array(
        'raw' => '$string',
        'snappy' => 'snappy_uncompress($string)',
        'gzip-9' => 'gzuncompress($string)',
        'gzip-6' => 'gzuncompress($string)',
        'gzip-3' => 'gzuncompress($string)',
        'gzip-1' => 'gzuncompress($string)',
    ),

    'serialize' => array(
        'serialize' => 'serialize($data)',
        'json' => 'json_encode($data)',
        'igbinary' => 'igbinary_serialize($data)',
        'msgpack' => 'msgpack_pack($data)',
    ),

    'unserialize' => array(
        'serialize' => 'unserialize($data)',
        'json' => 'json_decode($data, true)',
        'igbinary' => 'igbinary_unserialize($data)',
        'msgpack' => 'msgpack_unpack($data)',
    ),

);

if (!function_exists('snappy_compress')) {
    unset($matrix['compress']['snappy']);
    unset($matrix['decompress']['snappy']);
}

if (!function_exists('gzcompress')) {
    unset($matrix['compress']['gzip-9']);
    unset($matrix['decompress']['gzip-9']);
    unset($matrix['compress']['gzip-6']);
    unset($matrix['decompress']['gzip-6']);
    unset($matrix['compress']['gzip-3']);
    unset($matrix['decompress']['gzip-3']);
    unset($matrix['compress']['gzip-1']);
    unset($matrix['decompress']['gzip-1']);
}

if (!function_exists('igbinary_serialize')) {
    unset($matrix['serialize']['igbinary']);
    unset($matrix['unserialize']['igbinary']);
}

if (!function_exists('msgpack_pack')) {
    unset($matrix['serialize']['msgpack']);
    unset($matrix['unserialize']['msgpack']);
}

ob_start();

$script = '<?php' . PHP_EOL;

foreach ($matrix['compress'] as $compressType => $compress) {
    foreach ($matrix['serialize'] as $serializeType => $serialize) {

        $unserialize = $matrix['unserialize'][$serializeType];
        $decompress = $matrix['decompress'][$compressType];

        ?>
        $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = <?php echo str_replace('$string', $serialize, $compress)?>;

        }
        $stat['encode']['<?php echo $compressType?>/<?php echo $serializeType?>'] = 1000 * (microtime(1) - $start);

        $tmp = <?php echo str_replace('$string', $serialize, $compress)?>;
        $stat['length']['<?php echo $compressType?>/<?php echo $serializeType?>'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = <?php echo str_replace('$data', str_replace('$string', '$tmp', $decompress), $unserialize)?>;

        }

        $stat['decode']['<?php echo $compressType?>/<?php echo $serializeType?>'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['<?php echo $compressType?>/<?php echo $serializeType?>'] = memory_get_usage() - $mem_start;
        <?php
    }
}

$script .= ob_get_clean();
file_put_contents('test.php', $script);
