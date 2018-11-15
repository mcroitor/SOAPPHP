<?php

class Arithmetic {

    const WSSE_NS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

    public function Security($header) {
        $timestamp = (new Timestamp())->GetSoapVar();
        if ($header->UsernameToken->Username == "user" &&
                $header->UsernameToken->Password == "password") {
            return new SoapVar($timestamp, SOAP_ENC_OBJECT, null, null, "Security", Arithmetic::WSSE_NS);
        } else {
            throw new SoapFault("403", "invalid login and password");
        }
    }

    public function Sum($param) {
        return $param->x + $param->y;
    }

    public function Product($param) {
        return $param->x * $param->y;
    }

}
