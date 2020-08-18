<?php

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Đọc dữ liệu từ excel và trả về mảng
 */
function getDataExcel($inputFileName)
{
	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
	$reader->setReadDataOnly(false);
	$reader->setReadEmptyCells(false);
	$data = $reader->load($inputFileName)->getActiveSheet()->toArray(null, true, true, false);

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
	// Định dạng kiểu text cho cột E
	$spreadsheet->getActiveSheet()->getStyle('E:E')->getNumberFormat()->setFormatCode('@');
	// Thêm dữ liệu từ array
	$spreadsheet->getActiveSheet()->fromArray($array, null, 'A2');
	$writer = new Xlsx($spreadsheet);
	$filepath = ABSPATH . 'wp-content/uploads/Files/' . $name . '_' . date('d-m-Y') . '.xlsx';
	$writer->save($filepath);
	return $filepath;
}
