<?php

include_once './Token.interface.php';
include_once './Timestamp.class.php';
include_once './UsernameToken.class.php';
include_once './SecurityPolicy.class.php';

$wsdl = "./arithmetic.wsdl";
$client = new SoapClient($wsdl);

$usernameToken = new UsernameToken("user", "password");
$policy = new SecurityPolicy($usernameToken);
$client->__setSoapHeaders($policy->GetSoapHeader());

$param = new stdClass;
$param->x = 5;
$param->y = 6;
try {
    $result = $client->Sum($param);
    echo print_r($result, true);
} catch (Exception $e) {
    echo "exception: " . $e->getMessage();
}