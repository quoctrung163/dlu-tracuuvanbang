<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
$files = ABSPATH . "/wp-content/plugins/dlu-custom-post-type/includes/converter-dlu-custom-post-type.php";
require_once($file1);
require_once($files);

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
  $result = strpos($handlestrOriginal, $handlestrChild);

  return (gettype($result) === 'integer' && $result >= 0);
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
    echo "<script type='text/javascript'>alert('Không được để trống');</script>";
    return null;
  }
  $result = $array;
  if ($hoTen != null) {
    $result = array_filter($result, function ($var) use ($hoTen) {
      return compare2Str($var[0], $hoTen);
    });
  }
  if ($CMND != null) {
    $result = array_filter($result, function ($var) use ($CMND) {
      return compare2Str($var[0], $CMND);
    });
  }
  if ($soBaoDanh != null) {
    $result = array_filter($result, function ($var) use ($soBaoDanh) {
      return compare2Str($var[0], $soBaoDanh);
    });
  }
  if ($soHieuBang != null) {
    $result = array_filter($result, function ($var) use ($soHieuBang) {
      return compare2Str($var[0], $soHieuBang);
    });
  }
  if ($soQuyetDinh != null) {
    $result = array_filter($result, function ($var) use ($soQuyetDinh) {
      return compare2Str($var[0], $soQuyetDinh);
    });
  }
  return $result;
}

function printTable2($array)
{
  echo '<div class="zui-wrapper">';
  echo '<table class="zui-table">';
  echo '<thead>';
  echo '<tr>';
  foreach (unserialize(HEADER_TABLE) as $item) {
    echo '<th>' . $item . '</th>';
  }
  echo '</tr>';
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
  echo '<tbody>';
  echo '</table>';
  echo '</div>';
}


/**
 * In bảng dưới dạng mã HTML
 */
function printTable($array)
{
  echo '<div class="table-responsive">';
  echo '<table class="table table-hover table-striped table-bordered">';
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
  echo '<div class="table-responsive">';
  echo '<table class="table table-hover table-striped table-bordered">';
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
 * Cập nhật CSDL
 */
function updateDatabase($array)
{
  return true;
}

/**
 * Truy vấn và trả về từ CSDL
 */
function getHocVien()
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
  return getAllHocVienDangKy(true, $datebegin, $dateend);
}

/**
 * Xuất dữ liệu từ mảng vào file excel và trả về đường dẫn đến file excel
 */
function exportArrayToExcel($array, $name)
{
  return setDataExcel($array, $name);
}

/**
 * Nhập dữ liệu từ excel và lưu vào CSDL
 */
function importFromExcel($inputFileName)
{
  $array = getDataExcel(($inputFileName));
  # code...
}

function showCustomAlert($content)
{
  echo "<script type='text/javascript'>alert('" . $content . "');</script>";
}
