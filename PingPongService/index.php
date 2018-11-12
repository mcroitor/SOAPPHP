<?php

$wsdl = "./pingpong.wsdl";

if (isset($_GET["wsdl"])) {
    echo file_get_contents($wsdl);
    exit();
}

function PingPong() {
    return "pong";
}

$service = new SoapServer($wsdl);

$service->addFunction("PingPong");

$service->handle();
