<?php

class Timestamp {

    const WSU_NS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd";

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
        return new SoapVar($token, SOAP_ENC_OBJECT, null, null, "Timestamp", Timestamp::WSU_NS);
    }

}
