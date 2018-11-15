<?php

/**
 * HOWTO:
 *   1. Define class that will handle client requests.
 *   2. Implement HeaderAnalyzer interface that will handle headers 
 *      from SOAP envelope.
 *      You can implement it on client request handler.
 */
function lib_autoloader($class) {
    if (file_exists("./lib/{$class}.class.php")) {
        include_once "./lib/{$class}.class.php";
    }
}

spl_autoload_register("lib_autoloader");

include_once './Arithmetic.class.php';

$wsdl = "./arithmetic.wsdl";

if (isset($_GET["wsdl"])) {
    echo file_get_contents($wsdl);
    exit();
}

$service = new ExtSoapServer($wsdl);
$service->EnableDebug();

$service->setClass("Arithmetic");

$service->handle();
