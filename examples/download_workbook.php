<?php

require '../Excel_Xml.php';

$data = array();
for ($i = 1; $i < 200; $i++) {
    $data[] = array($i, 'My test');
}

$data_sec = array();
for ($i = 1; $i < 110; $i++) {
    $data_sec[] = array($i, '109 times my name');
}

$phpexcel = new Excel_Xml;
$phpexcel->addWorksheet('Worksheet test', $data);
$phpexcel->addWorksheet('Worksheet test 2', $data_sec);
$phpexcel->sendWorkbook('openoffice-test.xml');