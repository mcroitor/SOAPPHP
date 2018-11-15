<?php

include_once './Token.interface.php';

class Timestamp implements Token {

    private $live;

    public function __construct($live = 60) {
        $this->live = $live;
    }

    public function GetSoapVar() {
        $time = time();
        $created = gmdate('Y-m-d\TH:i:s\Z', $time);
        $expires = gmdate('Y-m-d\TH:i:s\Z', $time + $this->live * 1000);
        $token = [
            "Created" => new SoapVar($created, SOAP_ENC_OBJECT, "Created", Timestamp::WSU_NS),
            "Expires" => new SoapVar($expires, SOAP_ENC_OBJECT, "Expires", Timestamp::WSU_NS)
        ];
        return new SoapVar($token, SOAP_ENC_OBJECT, "Timestamp", Timestamp::WSU_NS);
    }

}
