<?php

$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file);

echo '<h1 class="myplugin">Cập nhật thông tin văn bằng từ file Excel</h1>';
if (isset($_POST["submit"])) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    showCustomAlert('Lỗi upload file!');
  } else {
    $name = $_FILES["file"]["name"];
    // get ext file
    $ext = end(explode(".", $name));

    if ($ext != 'xlsx') {
      showCustomAlert('File upload không đúng định dạng (.xlsx)');
      return;
    }

    $newname = date('d-m-Y-H-i-s') . '.' . $ext;
    $filetoStore = "C:\\xampp\\htdocs\\WebTTCNTT\\wp-content\\uploads\\";
    $target = $filetoStore . $newname;
    move_uploaded_file($_FILES['file']['tmp_name'], $target);

    $data = getDataExcel($target);
    if (updateDatabase($data)) {
      showCustomAlert('Cập nhật thành công dữ liệu vào CSDL');
    } else {
      showCustomAlert('Cập nhật không thành công! Vui lòng kiểm tra tính hợp lệ của dữ liệu trong file Excel theo mẫu');
    }
  }
}

if (isset($_POST["getHocVien"])) {
  $array = getHocVienDangKy();
  $filename = exportArrayToExcel($array, 'Danh sach hoc vien dang ky');
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", true, 200);
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  header("Expires: 0");
}

?>
<h3 class="myplugin">Chức năng này có vai trò là lưu thông tin văn bằng của học viên vào CSDL thông qua file Excel</h3>
<p class="myplugin">
  <ul>
    <li>
      <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form-data">
        Bước 1. Click vào nút sau đây <input type="submit" name="getHocVien" value="Download" />
        để lấy file Excel danh sách học viên đăng ký.
      </form>
    </li>
    <li>Bước 2. Nhập các thông tin cần thiết vào các cột ở bên phải. Thông tin của các học viên sẽ được lưu vào CSDL, do đó cần phải đảm bảo độ chính xác của dữ liệu.</li>
    <?php printHeaderTable(); ?>
    <li>Bước 3. Nhấn nút "Choose File" và chọn file Excel cần tải lên</li>
    <li>Bước 4. Nhấn nút "Cập nhật"</li>
    <li><em>Nếu trường hợp có sai sót, thì chỉ cần nhập từ file Excel những học viên cần sửa đổi, không cần phải nhập tất cả.</em></li>
  </ul>
</p>
<form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="file">Nhấn vào đây để chọn file:</label>
    <input type="file" name="file" id="file" class="form-control-file" class="btn btn-light"><br>
    <input type="submit" name="submit" value="Cập nhật" class="btn btn-primary">
  </div>
</form>