<?php

$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
// echo ABSPATH;
echo '<h1 style="text-align: center">Xem danh sách hồ sơ</h1>';
require($file);
printTable($data);
