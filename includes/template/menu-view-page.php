<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file1);

echo '<h1 class="myplugin">Xem danh sách văn bằng học viên</h1>';
echo '<h3 class="myplugin">Toàn bộ thông tin hồ sơ văn bằng của các học viên trong cơ sở dữ liệu sẽ được hiển thị ở đây</h3>';
$data = getHocVien();
printTable($data);