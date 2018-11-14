<?php

include_once './SecurityToken.interface.php';

class UsernameToken implements Token {

    const WSSE_NS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";
    const WSU_NS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd";

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function GetSoapVar() {
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $nonce = mt_rand();
        $token = [
            "Username" => $this->username,
            "Password" => $this->password,
            "Nonce" => base64_encode(pack("H*", $nonce)),
            "Created" => new SoapVar($timestamp, SOAP_ENC_OBJECT, "Created", UsernameToken::WSU_NS)
        ];
        return new SoapVar($token, SOAP_ENC_OBJECT, "UsernameToken", UsernameToken::WSSE_NS);
    }

}
