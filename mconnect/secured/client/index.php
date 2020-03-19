<?php

include_once './classes/XMLSignature.class.php';
include_once './classes/SecuredSoapClient.class.php';

$wsdl = "example.wsdl";

$client = new SecuredSoapClient($wsdl, []);
$client->private_key = "./cert/client.p12";
$client->passphrase = "123456";
$client->public_key = "./cert/client_certificate.pem";
$client->trusted_key = "./cert/service_certificate.pem";

try {
    echo $client->GetData(["Left" => 15, "Right" => 16])->Result;
} catch (Exception $e) {
    echo "<p>interpelation error: " . $e->getMessage() . "</p>";
}