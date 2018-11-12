<?php
include './example.php';
$wsdl = "./another_example.wsdl";

if(isset($_GET["wsdl"])){
    echo file_get_contents($wsdl);
    exit();
}

function GetLocalities(){
    global $persons;
    return array_keys($persons);
}

function GetPersonsFromLocality($param){
    global $persons;
    return $persons[$param->Locality];
}

function GetNrPersonsFromLocality($param){
    global $persons;
    return count($persons[$param->Locality]);
}

$service = new SoapServer($wsdl);

$service->addFunction("GetLocalities");
$service->addFunction("GetPersonsFromLocality");
$service->addFunction("GetNrPersonsFromLocality");

$service->handle();