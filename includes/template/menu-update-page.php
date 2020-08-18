<?php

$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file);

if (isset($_POST["CapNhatTT"])) {
	// Lỗi upload file
	if ($_FILES["file"]["error"] > 0) {
		echo "Error: " . $_FILES["file"]["error"] . "<br>";
		showCustomAlert('Lỗi upload file!');
	} else { // Upload file thành công
		$name = $_FILES["file"]["name"];
		// get extension of file
		$ext = end(explode(".", $name));
		if ($ext != 'xlsx') {
			showCustomAlert('File upload không đúng định dạng (.xlsx)');
			return;
		}
		// Lưu vào server
		$newname = date('d-m-Y-H-i-s') . '.' . $ext;
		$filetoStore = ABSPATH . 'wp-content/uploads/Files';
		$target = $filetoStore . $newname;
		move_uploaded_file($_FILES['file']['tmp_name'], $target);
		// Đọc dữ liệu và tiến hành cập nhật thông tin
		$data = getDataExcel($target);
		$result = updateDatabase($data);
		if ($result != true) {
			echo '<h2>Đã có lỗi khi cập nhật những dòng sau</h2>';
			printTable($result);
		} else {
			showCustomAlert('Cập nhật thành công dữ liệu vào CSDL');
		}
	}
}

if (isset($_POST["XuatHocVienDK"])) {
	$array = getHocVienDangKy();
	$filepath = exportArrayToExcel($array, 'Danh sach hoc vien dang ky');
	$filename = basename($filepath);
	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=$filename");
	header("Expires: 0");
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	ob_end_clean();
	ob_clean();
	flush();
	readfile($filepath);
	wp_die();
}
?>

<h1 class="myplugin">Cập nhật thông tin văn bằng học viên</h1>
<h3 class="myplugin">Để cập nhật thông tin văn bằng, vui lòng thực hiện theo các thao tác dưới đây:</h3>
<p class="myplugin">
	<ul class="dlu-admin-menu-update">
		<li>
			<form action="<?php $_self ?>" method="post" enctype="multipart/form-data">
				Bước 1. Click vào nút sau đây <input type="submit" class="btn btn-secondary" name="XuatHocVienDK" value="Tải về" />
				để lấy file Excel danh sách học viên đăng ký.
			</form>
		</li>
		<li>Bước 2. Nhập các thông tin cần thiết vào các cột ở bên phải. Thông tin của các học viên sẽ được lưu vào CSDL, do đó cần phải đảm bảo độ chính xác của dữ liệu.
			Ngoài ra không được thay đổi ID ở cột đầu tiên.</li>
		<?php printHeaderTable(); ?>
		<li>
			<form action="<?php $_self ?>" method="post" enctype="multipart/form-data">
				Bước 3. Nhấn nút sau, chọn file Excel cần tải lên rồi nhấn nút "Cập nhật"
				<input type="file" name="file" id="file" class="form-control-file btn btn-light"><br>
				<input type="submit" name="CapNhatTT" value="Cập nhật" class="btn btn-primary">
			</form>
		</li>
	</ul>
</p>
<h3 class="myplugin">Lưu ý:</h3>
<ul class="dlu-admin-menu-update">
	<li><em>Nếu trường hợp có sai sót, thì chỉ cần nhập từ file Excel những học viên cần sửa đổi, không cần phải nhập tất cả.</em></li>
</ul>