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
        $expires = gmdate('Y-m-d\TH:i:s\Z', $time + $this->live);
        $token = [
            new SoapVar($created, XSD_DATETIME, null, null, "Created", Timestamp::WSU_NS),
            new SoapVar($expires, XSD_DATETIME, null, null, "Expires", Timestamp::WSU_NS)
        ];
        return new SoapVar($token, SOAP_ENC_OBJECT, null, null, $this->GetName(), Timestamp::WSU_NS);
    }

    public function GetName() {
        return "Timestamp";
    }

}
