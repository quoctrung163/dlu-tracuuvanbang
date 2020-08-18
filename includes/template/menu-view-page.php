<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file1);

echo '<h1 class="myplugin">Xem danh sách văn bằng học viên</h1>';
echo '<h3 class="myplugin">Dưới đây là toàn bộ thông tin văn bằng của các học viên trong trung tâm và được lưu trữ trong cơ sở dữ liệu</h3>';
$data = getHocVienDaHoanThanh();
printTable($data);
