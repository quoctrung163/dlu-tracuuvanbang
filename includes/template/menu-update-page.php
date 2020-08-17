<?php

$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file);

if (isset($_POST["CapNhatTT"])) {
	if ($_FILES["file"]["error"] > 0) {
		echo "Error: " . $_FILES["file"]["error"] . "<br>";
		showCustomAlert('Lỗi upload file!');
	} else {
		$name = $_FILES["file"]["name"];
		// get extension of file
		$ext = end(explode(".", $name));

		if ($ext != 'xlsx') {
			showCustomAlert('File upload không đúng định dạng (.xlsx)');
			return;
		}

		$newname = date('d-m-Y-H-i-s') . '.' . $ext;
		$filetoStore = ABSPATH . 'wp-content/uploads/';
		$target = $filetoStore . $newname;
		move_uploaded_file($_FILES['file']['tmp_name'], $target);

		$data = getDataExcel($target);
		if (updateDatabase($data)) {
			showCustomAlert('Cập nhật thành công dữ liệu vào CSDL');
		} else {
			showCustomAlert('Cập nhật không thành công');
		}
	}
}

if (isset($_POST["XuatHocVienDK"])) {
	$array = getHocVienDangKy();
	$filename = exportArrayToExcel($array, 'Danh sach hoc vien dang ky');
	header("Content-type: application/vnd.ms-excel", true, 200);
	header("Content-disposition: attachment; filename=$filename");
	//header("Pragma: no-cache");
	header("Expires: 0");
	ob_clean();
	flush();
	readfile($filename);
	wp_die();
}
?>

<h1 class="myplugin">Cập nhật thông tin văn bằng từ file Excel</h1>
<h3 class="myplugin">Chức năng này có vai trò là lưu thông tin văn bằng của học viên vào CSDL thông qua file Excel</h3>
<p class="myplugin">
	<ul class="dlu-admin-menu-update">
		<li>
			<form action="<?php $_self ?>" method="post" enctype="multipart/form-data">
				Bước 1. Click vào nút sau đây <input type="submit" class="btn btn-secondary" name="XuatHocVienDK" value="Download" />
				để lấy file Excel danh sách học viên đăng ký.
			</form>
		</li>
		<li>Bước 2. Nhập các thông tin cần thiết vào các cột ở bên phải. Thông tin của các học viên sẽ được lưu vào CSDL, do đó cần phải đảm bảo độ chính xác của dữ liệu.</li>
		<?php printHeaderTable(); ?>
		<li>
			<form action="<?php $_self ?>" method="post" enctype="multipart/form-data">
				Bước 3. Nhấn nút sau, chọn file Excel cần tải lên rồi nhấn nút "Cập nhật"
				<input type="file" name="file" id="file" class="form-control-file btn btn-light"><br>
				<input type="submit" name="CapNhatTT" value="Cập nhật" class="btn btn-primary">
			</form>
		</li>
		<li><em>Nếu trường hợp có sai sót, thì chỉ cần nhập từ file Excel những học viên cần sửa đổi, không cần phải nhập tất cả.</em></li>
	</ul>
</p>