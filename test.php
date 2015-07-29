<?php
        $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = serialize($data);

        }
        $stat['encode']['raw/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = serialize($data);
        $stat['length']['raw/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize($tmp);

        }

        $stat['decode']['raw/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['raw/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = json_encode($data);

        }
        $stat['encode']['raw/json'] = 1000 * (microtime(1) - $start);

        $tmp = json_encode($data);
        $stat['length']['raw/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode($tmp, true);

        }

        $stat['decode']['raw/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['raw/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = igbinary_serialize($data);

        }
        $stat['encode']['raw/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = igbinary_serialize($data);
        $stat['length']['raw/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize($tmp);

        }

        $stat['decode']['raw/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['raw/igbinary'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = snappy_compress(serialize($data));

        }
        $stat['encode']['snappy/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = snappy_compress(serialize($data));
        $stat['length']['snappy/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize(snappy_uncompress($tmp));

        }

        $stat['decode']['snappy/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['snappy/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = snappy_compress(json_encode($data));

        }
        $stat['encode']['snappy/json'] = 1000 * (microtime(1) - $start);

        $tmp = snappy_compress(json_encode($data));
        $stat['length']['snappy/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode(snappy_uncompress($tmp), true);

        }

        $stat['decode']['snappy/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['snappy/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = snappy_compress(igbinary_serialize($data));

        }
        $stat['encode']['snappy/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = snappy_compress(igbinary_serialize($data));
        $stat['length']['snappy/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize(snappy_uncompress($tmp));

        }

        $stat['decode']['snappy/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['snappy/igbinary'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(serialize($data), 9);

        }
        $stat['encode']['gzip-9/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(serialize($data), 9);
        $stat['length']['gzip-9/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-9/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-9/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(json_encode($data), 9);

        }
        $stat['encode']['gzip-9/json'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(json_encode($data), 9);
        $stat['length']['gzip-9/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode(gzuncompress($tmp), true);

        }

        $stat['decode']['gzip-9/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-9/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(igbinary_serialize($data), 9);

        }
        $stat['encode']['gzip-9/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(igbinary_serialize($data), 9);
        $stat['length']['gzip-9/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-9/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-9/igbinary'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(serialize($data), 6);

        }
        $stat['encode']['gzip-6/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(serialize($data), 6);
        $stat['length']['gzip-6/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-6/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-6/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(json_encode($data), 6);

        }
        $stat['encode']['gzip-6/json'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(json_encode($data), 6);
        $stat['length']['gzip-6/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode(gzuncompress($tmp), true);

        }

        $stat['decode']['gzip-6/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-6/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(igbinary_serialize($data), 6);

        }
        $stat['encode']['gzip-6/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(igbinary_serialize($data), 6);
        $stat['length']['gzip-6/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-6/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-6/igbinary'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(serialize($data), 3);

        }
        $stat['encode']['gzip-3/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(serialize($data), 3);
        $stat['length']['gzip-3/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-3/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-3/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(json_encode($data), 3);

        }
        $stat['encode']['gzip-3/json'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(json_encode($data), 3);
        $stat['length']['gzip-3/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode(gzuncompress($tmp), true);

        }

        $stat['decode']['gzip-3/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-3/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(igbinary_serialize($data), 3);

        }
        $stat['encode']['gzip-3/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(igbinary_serialize($data), 3);
        $stat['length']['gzip-3/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-3/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-3/igbinary'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(serialize($data), 1);

        }
        $stat['encode']['gzip-1/serialize'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(serialize($data), 1);
        $stat['length']['gzip-1/serialize'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-1/serialize'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-1/serialize'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(json_encode($data), 1);

        }
        $stat['encode']['gzip-1/json'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(json_encode($data), 1);
        $stat['length']['gzip-1/json'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = json_decode(gzuncompress($tmp), true);

        }

        $stat['decode']['gzip-1/json'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-1/json'] = memory_get_usage() - $mem_start;
                $start = microtime(1);
        //$mem_start = memory_get_usage();

        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp = $compress($serialize($data)));
            $tmp = gzcompress(igbinary_serialize($data), 1);

        }
        $stat['encode']['gzip-1/igbinary'] = 1000 * (microtime(1) - $start);

        $tmp = gzcompress(igbinary_serialize($data), 1);
        $stat['length']['gzip-1/igbinary'] = strlen($tmp);


        $start = microtime(1);
        for ($i = 0;$i < $iterationsCount;++$i) {
            //$tmp2 = $unserialize($decompress($tmp));
            $tmp2 = igbinary_unserialize(gzuncompress($tmp));

        }

        $stat['decode']['gzip-1/igbinary'] = 1000 * (microtime(1) - $start);
        //$stat['mem_usage']['gzip-1/igbinary'] = memory_get_usage() - $mem_start;
        