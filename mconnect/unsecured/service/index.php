<?php
include './classes/example.php';

$wsdl = "example.wsdl";
$server = new SoapServer($wsdl);
$server->setClass("example");

$server->handle();