<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GeoIP\GeoIP;

echo new GeoIP('177.7.3.53') . PHP_EOL;