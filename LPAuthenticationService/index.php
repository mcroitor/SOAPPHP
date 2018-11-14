<?php

include_once './Arithmetic.class.php';
include_once './ExtSoapServer.class.php';

$wsdl = "./arithmetic.wsdl";

if (isset($_GET["wsdl"])) {
    echo file_get_contents($wsdl);
    exit();
}

$service = new ExtSoapServer($wsdl);
$service->EnableDebug();

$service->setClass("Arithmetic");

$service->handle();
