<?php

require_once '../vendor/kohana-assets/vendor/jsminplus.php';

$file = $argv[1];

$content = file_get_contents($file);

echo JsMinPlus::minify($content).';';

