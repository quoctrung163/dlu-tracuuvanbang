<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
$file2 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
require_once($file1);
require_once($file2);
// echo ABSPATH;
echo '<h1 style="text-align: center">Xem danh sách tất cả hồ sơ</h1>';

$data = getDataExcel(ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/data/data.xlsx");

printTable($data);
