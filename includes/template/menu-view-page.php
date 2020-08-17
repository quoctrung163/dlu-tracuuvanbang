<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
$file2 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
require_once($file1);
require_once($file2);

echo '<h1 class="myplugin">Xem danh sách văn bằng học viên</h1>';
echo '<h3 class="myplugin">Toàn bộ thông tin hồ sơ văn bằng của các học viên trong cơ sở dữ liệu sẽ được hiển thị ở đây</h3>';
$data = getDataExcel(ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/data/form-example.xlsx");

printTable($data);