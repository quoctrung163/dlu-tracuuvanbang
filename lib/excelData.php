<?php
require_once('vendor/autoload.php');

$inputFileName = ABSPATH . "/wp-content/plugins/dlu-tracuuvanbang/data/data.xlsx";
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
$data = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

unset($data[0]);
