<?php
echo '<h1 style="text-align: center">Cập nhật thông tin hồ sơ</h1>';
if (isset($_POST["submit"])) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }
}
?>
<h6>Đầu tiên là hãy đảm bảo nội dung của file Excel cần nhập theo đúng mẫu sau, click vào <a href="/WebTTCNTT/wp-content/uploads/blank.xlsx" download="example.xlsx">đây</a> để tải về mẫu</h6>
<h6>Sau đó upload file có chứa thông tin kết quả vào</h6>
<form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="file">Nhấn vào đây để chọn file:</label>
        <input type="file" name="file" id="file" class="form-control-file"><br>
        <input type="submit" name="submit" value="Submit">
    </div>
</form>