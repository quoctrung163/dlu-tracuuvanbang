<?php
echo '<h1 style="text-align: center">Cập nhật thông tin hồ sơ từ file Excel</h1>';
echo '<h2 id="doneUploaded"></h2>';
if (isset($_POST["submit"])) {
  $file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
  require_once($file);
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

?>
<h6>Đầu tiên là hãy đảm bảo nội dung của file Excel cần nhập theo đúng mẫu sau, click vào <a href="/WebTTCNTT/wp-content/uploads/blank.xlsx" download="example.xlsx">đây</a> để tải về mẫu</h6>
<h6>Sau đó upload file có chứa thông tin kết quả vào</h6>
<form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="file">Nhấn vào đây để chọn file:</label>
    <input type="file" name="file" id="file" class="form-control-file" class="btn btn-light"><br>
    <input type="submit" name="submit" value="Upload file và cập nhật" class="btn btn-primary">
  </div>
</form>