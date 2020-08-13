<?php

// Load dữ liệu từ excel
// include '../../lib/excelData.php';
// require_once('../../lib/excelData.php');

$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
// echo ABSPATH;
require($file);
echo $data;
