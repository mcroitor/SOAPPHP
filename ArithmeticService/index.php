<?php

$wsdl = "./arithmetic.wsdl";

if(isset($_GET["wsdl"])){
	header('Content-Type: text/xml');
    echo file_get_contents($wsdl);
    exit();
}

function Sum($param){
    return $param->x + $param->y;
}

function Product($param){
    return $param->x * $param->y;
}

$service = new SoapServer($wsdl, array('cache_wsdl' => WSDL_CACHE_NONE));

$service->addFunction("Sum");
$service->addFunction("Product");

$service->handle();