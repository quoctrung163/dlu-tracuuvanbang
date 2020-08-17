<?php

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function getDataExcel($inputFileName)
{
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
  $reader->setReadDataOnly(false);
  $reader->setReadEmptyCells(false);
  $data = $reader->load($inputFileName)->getActiveSheet()->toArray(null, true, true, false);

  unset($data[0]);
  return $data;
}

function setDataExcel($array, $name)
{
  $spreadsheet = new Spreadsheet();
  $temp = unserialize(HEADER_TABLE);
  for ($i = 0; $i < count($temp); ++$i) {
    $spreadsheet->getActiveSheet()->setCellValue(chr(ord('A') + $i) . 1, $temp[$i]);
  }
  $spreadsheet->getActiveSheet()->getStyle('E:E')->getNumberFormat()->setFormatCode('@');
  $spreadsheet->getActiveSheet()->fromArray($array, null, 'A2');
  $writer = new Xlsx($spreadsheet);
  $filename = ABSPATH . 'wp-content/uploads/' . $name . '_' . date('d-m-Y') . '.xlsx';
  $writer->save($filename);
  return $filename;
}
