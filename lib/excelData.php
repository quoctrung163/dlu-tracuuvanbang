<?php

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Đọc dữ liệu từ excel và trả về mảng
 */
function getDataExcel($inputFileName)
{
	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$reader->setReadDataOnly(false);
	// Bỏ qua những ô trống trong Excel
	$reader->setReadEmptyCells(false);
	$data = $reader->load($inputFileName)->getActiveSheet()->toArray(null, true, true, false);
	// Loại bỏ dòng tiêu đề
	unset($data[0]);
	return $data;
}

/**
 * Chuyển dữ liệu từ array vào file excel với tên file cho trước và trả về đường dẫn đầy đủ của file trên server
 */
function setDataExcel($array, $name)
{
	$spreadsheet = new Spreadsheet();
	// Thêm tên cột
	$temp = unserialize(HEADER_TABLE);
	for ($i = 0; $i < count($temp); ++$i) {
		$spreadsheet->getActiveSheet()->setCellValue(chr(ord('A') + $i) . 1, $temp[$i]);
	}
	// Đọc dữ liệu từ array
	$spreadsheet->getActiveSheet()->fromArray($array, null, 'A2');
	// Định dạng kiểu text cho cột E
	$spreadsheet->getActiveSheet()->getStyle('E:E')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
	// Định dạng kiểu DateTime d/m/Y cho ngày sinh và ngày cấp
	$spreadsheet->getActiveSheet()->getStyle('C:C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
	$spreadsheet->getActiveSheet()->getStyle('I:I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
	// Ghi vào file Excel
	$writer = new Xlsx($spreadsheet);
	// Lưu vào server
	$filepath = ABSPATH . 'wp-content/uploads/Files/' . $name . '_' . date('d-m-Y') . '.xlsx';
	$writer->save($filepath);
	return $filepath;
}
