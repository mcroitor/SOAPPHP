<?php

include_once './classes/XMLSignature.class.php';
include_once './classes/SecuredSoapServer.class.php';
include_once './classes/example.class.php';

$wsdl = "example.wsdl";
$server = new SecuredSoapServer($wsdl);
$server->private_key = "./cert/service.p12";
$server->passkey = "123456";
$server->public_key = "./cert/service_certificate.pem";
$server->trusted_key = "./cert/client_certificate.pem";

$server->setClass("example");

$server->handle();