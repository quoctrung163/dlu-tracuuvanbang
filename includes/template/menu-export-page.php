<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/common.php";
require_once($file1);

if (isset($_POST["Xuat"]) || isset($_POST["XuatTatCa"])) {
	if (isset($_POST["Xuat"])) {
		if ($_POST["ngaybatdau"] == null || $_POST["ngayketthuc"] == null) {
			showAlert("Không được để trống các trường bắt buộc");
		} else {
			$begin = (new DateTime($_POST["ngaybatdau"]))->format('d/m/Y');
			$end = (new DateTime($_POST["ngayketthuc"]))->format('d/m/Y');
			$array = getHocVienInRange($begin, $end);
			$filepath = exportArrayToExcel($array, 'Danh sach van bang theo thoi gian');
			if ($filepath != null)
				showDownloadDialog($filepath);
		}
	} else {
		$array = getHocVienDaHoanThanh();
		$filepath = exportArrayToExcel($array, 'Danh sach van bang tat ca');
		if ($filepath != null)
			showDownloadDialog($filepath);
	}
}

function showDownloadDialog($filepath)
{
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

<h1 class="myplugin">Xuất thông tin văn bằng ra file Excel</h1>
<h3 class="myplugin">Vui lòng chọn khoảng thời gian ngày cấp bằng của hồ sơ để xuất ra file:</h6>
	<div>
		<form action="<?php $_self ?>" method="POST" enctype="multipart/form-data">
			<label for="ngaybatdau" class="mr-sm-2">Thời gian bắt đầu:</label>
			<input type="date" id="ngaybatdau" name="ngaybatdau" class="form-control mb-2 mr-sm-2">
			<label for="ngayketthuc" class="mr-sm-2">Thời gian kết thúc:</label>
			<input type="date" id="ngayketthuc" name="ngayketthuc" class="form-control mb-2 mr-sm-2">
			<input type="submit" class="btn btn-success" value="Xuất theo khoảng thời gian" name="Xuat"> hoặc
			<input type="submit" class="btn btn-success" value="Xuất tất cả thời gian" name="XuatTatCa">
		</form>
	</div>