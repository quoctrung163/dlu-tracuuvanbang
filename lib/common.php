<?php

$file1 = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/lib/excelData.php";
require($file1);

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

/**
 * In bảng dưới dạng mã HTML
 */
function printTable($array)
{
  echo '<div class="table-responsive">';
  echo '<table class="table table-hover table-striped table-bordered">';
  echo '<thead>';
  echo "<tr>";
  echo "
  <th>ID</th>
  <th>Họ tên</th>
  <th>Ngày sinh</th>
  <th>Nơi sinh</th>
  <th>Số CMND</th>
  <th>Email</th>
  <th>SDT</th>
  <th>Số báo danh</th>
  <th>Ngày cấp</th>
  <th>Số hiệu bằng</th>
  <th>Số quyết định</th>
  <th>Điểm trắc nghiệm</th>
  <th>Điểm thực hành</th>
  ";
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
  echo "
  <th>ID</th>
  <th>Họ tên</th>
  <th>Ngày sinh</th>
  <th>Nơi sinh</th>
  <th>Số CMND</th>
  <th>Email</th>
  <th>SDT</th>
  <th>Số báo danh</th>
  <th>Ngày cấp</th>
  <th>Số hiệu bằng</th>
  <th>Số quyết định</th>
  <th>Điểm trắc nghiệm</th>
  <th>Điểm thực hành</th>
  ";
  echo "</tr>";
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
function getAll()
{
  $array = null;
  return $array;
}

/**
 * Xuất dữ liệu từ mảng vào file excel
 */
function exportArrayToExcel($array)
{
  # code...
}

/**
 * Nhập dữ liệu từ excel và lưu vào CSDL
 */
function importFromExcel($inputFileName)
{
  $array = getDataExcel(($inputFileName));
  # code...
}

/**
 * Truy vấn hồ sơ dựa trên ngày cấp bằng
 */
function getDataInRange($datebegin, $dateend)
{
}

function showCustomAlert($content)
{
  echo "<script type='text/javascript'>alert('" . $content . "');</script>";
}
