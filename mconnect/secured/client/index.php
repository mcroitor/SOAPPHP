<?php

include_once './classes/autoload.php';

$wsdl = "example.wsdl";

$headers = [
    "CallingUser" => "0000000000000", // IDNP utilizatorului care procesează datele cu caracter personal
    "CallingEntity" => "1000000000000", // IDNO persoanei juridice din care face parte utilizatorul
    "CallBasis" => "testare", // Motivul apelului
    "CallReason" => "testare"   // Scopul apelului
];

$client = new MConnectClient($wsdl, []);
$client->private_key = "./cert/client.p12";
$client->passphrase = "123456";
$client->public_key = "./cert/client_certificate.pem";
$client->trusted_key = "./cert/service_certificate.pem";

$client->SetMConnectHeaders((new MConnectHeaders($headers))->GetSoapHeaders());

try {
    echo $client->GetData(["Left" => 15, "Right" => 16])->Result;
} catch (Exception $e) {
    echo "<p>interpelation error: " . $e->getMessage() . "</p>";
}