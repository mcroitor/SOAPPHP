<?php

$wsdl = "example.wsdl";

$client = new SoapClient($wsdl);

echo $client->GetData(["Left" => 15, "Right" => 16])->Result;
