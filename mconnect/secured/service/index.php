<?php
include './classes/autoload.php';

$wsdl = "example.wsdl";
$server = new MConnectServer($wsdl);
$server->private_key = "./cert/service.p12";
$server->passkey = "123456";
$server->public_key = "./cert/service_certificate.pem";
$server->trusted_key = "./cert/client_certificate.pem";

$server->setClass("example");

$server->handle();