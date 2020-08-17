<?php
$file = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file);
if (isset($_POST["Xuat"]) || isset($_POST["XuatTatCa"])) {
	if (isset($_POST["Xuat"])) {
		if ($_POST["ngaybatdau"] == null || $_POST["ngayketthuc"] == null) {
			showCustomAlert("Không được để trống các trường bắt buộc");
			return;
		}
		$begin = date_format($_POST["ngaybatdau"], "d/m/Y");
		$end = date_format($_POST["ngayketthuc"], "d/m/Y");
		$array = getHocVienInRange($begin, $end);
		$filename = exportArrayToExcel($array, 'Danh sach van bang theo thoi gian');
	} else {
		$array = getHocVienDaHoanThanh();
		$filename = exportArrayToExcel($array, 'Danh sach van bang tat ca');
	}
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

<h1 class="myplugin">Xuất thông tin văn bằng ra file Excel</h1>
<h3 class="myplugin">Vui lòng chọn khoảng thời gian ngày cấp bằng của hồ sơ để xuất ra file:</h6>

	<form action="<?php $_self ?>" method="POST" enctype="multipart/form-data">
		<label for="ngaybatdau" class="mr-sm-2">Thời gian bắt đầu:</label>
		<input type="date" id="ngaybatdau" name="ngaybatdau" class="form-control mb-2 mr-sm-2">
		<label for="ngayketthuc" class="mr-sm-2">Thời gian kết thúc:</label>
		<input type="date" id="ngayketthuc" name="ngayketthuc" class="form-control mb-2 mr-sm-2">
		<input type="submit" class="btn btn-success" value="Xuất file" name="Xuat"> hoặc
		<input type="submit" class="btn btn-success" value="Xuất tất cả" name="XuatTatCa">
	</form>