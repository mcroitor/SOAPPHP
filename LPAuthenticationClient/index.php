<?php

$wsdl = "./arithmetic.wsdl";
$client = new SoapClient($wsdl);

$param = new stdClass;
$param->x = 5;
$param->y = 6;
$result = $client->Sum($param);

echo $result->Result;