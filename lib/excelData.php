<?php
require_once('vendor/autoload.php');
function getDataExcel($inputFileName)
{
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
  $reader->setReadDataOnly(false);
  $reader->setReadEmptyCells(false);
  $data = $reader->load($inputFileName)->getActiveSheet()->toArray(null, true, true, false);

  unset($data[0]);
  return $data;
}
