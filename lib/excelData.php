<?php
require_once('vendor/autoload.php');

$inputFileName = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/data/data.xlsx";
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

unset($data[1]);

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

function searchByParams()
{
  # code...
}

function printTable()
{
  # code...
}
