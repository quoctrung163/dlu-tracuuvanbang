<?php

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
$file2 = ABSPATH . "/wp-content/plugins/dlu-custom-post-type/includes/converter-dlu-custom-post-type.php";
$file3 = ABSPATH . "/wp-content/plugins/dlu-custom-post-type/includes/generate-hocviendangky-post-type.php";
require_once($file1);
require_once($file2);
require_once($file3);

define("HEADER_TABLE", serialize(array(
	"ID", "Họ tên", "Ngày sinh", "Nơi sinh", "Số CMND", "Email", "SDT", "Số báo danh",
	"Ngày cấp", "Số hiệu bằng", "Số quyết định", "Điểm trắc nghiệm", "Điểm thực hành"
)));


/**
 * Đổi chuỗi có dấu thành không dấu
 */
function vn_to_str($str)
{
	$unicode = array(
		'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd' => 'đ',
		'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i' => 'í|ì|ỉ|ĩ|ị',
		'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
		'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D' => 'Đ',
		'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
		'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);

	foreach ($unicode as $nonUnicode => $uni) {
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
	}
	$str = str_replace(' ', '_', $str);
	return $str;
}

/**
 * So sánh chuỗi ban đầu và chuỗi con
 * - So sánh có/không dấu
 * - So sánh không phân biệt hoa/thường
 * - Kiểm tra chuỗi con
 */
function compare2Str($strOriginal, $strChild)
{
	// xoa dau va doi thanh chu thuong
	$handlestrOriginal = vn_to_str(strtolower($strOriginal));
	$handlestrChild = vn_to_str(strtolower($strChild));
	// so sanh khong phan biet chu hoa thuong
	// $result = strpos($handlestrOriginal, $handlestrChild);
	return strcmp($handlestrChild, $handlestrOriginal) == 0;
	// return (gettype($result) === 'integer' && $result >= 0);
}

/**
 * Tìm kiếm theo nhiều tiêu chí khác nhau
 * - Họ tên
 * - Số CMND
 * - Số báo danh
 * - Số hiệu bằng
 * - Số quyết định
 */
function filterByAgrs($array, $hoTen, $CMND, $soBaoDanh, $soHieuBang, $soQuyetDinh)
{
	if ($hoTen == null && $CMND == null && $soBaoDanh == null && $soHieuBang == null && $soQuyetDinh == null) {
		showAlert('Không được để trống');
		return null;
	}
	$result = $array;
	if ($hoTen != null) {
		$result = array_filter($result, function ($var) use ($hoTen) {
			return compare2Str($var["hoten"], $hoTen);
		});
	}
	if ($CMND != null) {
		$result = array_filter($result, function ($var) use ($CMND) {
			return compare2Str($var["soCMND"], $CMND);
		});
	}
	if ($soBaoDanh != null) {
		$result = array_filter($result, function ($var) use ($soBaoDanh) {
			return compare2Str($var["sobaodanh"], $soBaoDanh);
		});
	}
	if ($soHieuBang != null) {
		$result = array_filter($result, function ($var) use ($soHieuBang) {
			return compare2Str($var["sohieubang"], $soHieuBang);
		});
	}
	if ($soQuyetDinh != null) {
		$result = array_filter($result, function ($var) use ($soQuyetDinh) {
			return compare2Str($var["soquyetdinh"], $soQuyetDinh);
		});
	}
	return $result;
}

/**
 * In bảng dưới dạng mã HTML
 */
function printTable($array)
{
	echo '<div class="dlu-admin-wrapper">';
	echo '<table class="dlu-admin-table">';
	echo '<thead>';
	echo "<tr>";
	foreach (unserialize(HEADER_TABLE) as $item) {
		echo '<th>' . $item . '</th>';
	}

	echo "</tr>";
	echo '</thead>';
	echo '<tbody>';
	if ($array != null)
		foreach ($array as $item) {
			echo '<tr>';
			foreach ($item as $col) {
				echo '<td>' . $col . '</td>';
			}
			echo '</tr>';
		}
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
}

/**
 * In bảng dưới dạng mã HTML
 */
function printHeaderTable()
{
	echo '<div class="dlu-admin-wrapper">';
	echo '<table class="dlu-admin-table">';
	echo '<thead>';
	echo "<tr>";
	foreach (unserialize(HEADER_TABLE) as $item) {
		echo '<th>' . $item . '</th>';
	}
	echo '</thead>';
	echo '</table>';
	echo '</div>';
}

/**
 * Ánh xạ mảng thành đối tượng
 */
function mapArrayToObject($array)
{
	$metadata = (object)array(
		'birthday' => fixDateFormatFromExcel($array[2], 'd/m/Y'),
		'address' => $array[3],
		'cmnd' => $array[4],
		'email' => $array[5],
		'tele' => $array[6],
		'sobaodanh' => $array[7],
		'ngaycap' => fixDateFormatFromExcel($array[8], 'd/m/Y'),
		'sohieubang' => $array[9],
		'soquyetdinh' => $array[10],
		'diemtracnghiem' => $array[11],
		'diemthuchanh' => $array[12]
	);
	return $metadata;
}

/**
 * Cập nhật CSDL, trả về True nếu cập nhật thành công array, ngược lại sẽ trả về thông tin bị lỗi
 */
function updateDatabase($array)
{
	$result = array();
	foreach ($array as $item) {
		$obj = mapArrayToObject($item);
		if (!saveMetaData($item[0], $obj))
			array_push($result, $item);
	}
	if (count($result) == 0)
		return true;
	return $result;
}

/**
 * Truy vấn và trả về từ CSDL
 */
function getHocVienDaHoanThanh()
{
	return getAllHocVienDangKy(true);
}

/**
 * Truy vấn và trả về từ CSDL
 */
function getHocVienDangKy()
{
	return getAllHocVienDangKy(false);
}

/**
 * Truy vấn hồ sơ dựa trên ngày cấp bằng
 */
function getHocVienInRange($datebegin, $dateend)
{
	return getAllHocVienVanBang($datebegin, $dateend);
}

/**
 * Xuất dữ liệu từ mảng vào file excel và trả về đường dẫn đến file excel
 */
function exportArrayToExcel($array, $name)
{
	return setDataExcel($array, $name);
}

/**
 * Hiển thị một cảnh báo trên trình duyệt
 */
function showAlert($content)
{
	echo "<script type='text/javascript'>alert('" . $content . "');</script>";
}

/**
 * Chuyển đổi số ngày trong Excel sang chuỗi ngày tháng trong PHP
 */
function fixDateFormatFromExcel($EXCEL_DATE, $format)
{
	if (gettype($EXCEL_DATE) == "integer") {
		$temp = ($EXCEL_DATE - 25569) * 86400;
		return date($format, $temp);
	}
	return $EXCEL_DATE;
}
