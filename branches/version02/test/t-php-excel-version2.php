<?php

require '../php-excel.class.php';

$doc = array (
    1 => array ("Oliver & Schwarz", "Peter", "Paul", "01234"),
         array ("Marlene", "Lucy", "Lina", "2,512")
    );

$xls = new Excel_XML('UTF-8', false, 'Names');
$xls->addArray ( $doc );
$xls->generateXML ("mytest");

?>