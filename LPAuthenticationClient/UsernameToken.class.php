<?php

include_once './Token.interface.php';

class UsernameToken implements Token {

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function GetSoapVar() {
        $time = time();
        $created = gmdate('Y-m-d\TH:i:s\Z', $time);
        $nonce = mt_rand();
        $token = [
            new SoapVar($this->username, XSD_STRING, null, null, "Username", UsernameToken::WSSE_NS),
            new SoapVar($this->password, XSD_STRING, null, null, "Password", UsernameToken::WSSE_NS),
            new SoapVar(base64_encode(pack("H*", $nonce)), XSD_BASE64BINARY, null, null, "Nonce", UsernameToken::WSSE_NS),
            new SoapVar($created, XSD_DATETIME, null, null, "Created", UsernameToken::WSU_NS)
        ];
        
        return new SoapVar($token, SOAP_ENC_OBJECT, null, null, $this->GetName(), UsernameToken::WSSE_NS);
    }

    public function GetName() {
        return "UsernameToken";
    }

}
