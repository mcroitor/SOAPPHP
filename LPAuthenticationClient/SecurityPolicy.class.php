<?php

include_once './Token.interface.php';
include_once './Timestamp.class.php';

class SecurityPolicy {

    const WSSE_NS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

    private $securityToken;

    public function __construct(Token $secutiryToken) {
        $this->securityToken = $secutiryToken;
    }

    public function GetSoapHeader() {
        $timestamp = new Timestamp();
        $tokens = [
            $timestamp->GetSoapVar(),
            $this->securityToken->GetSoapVar()
        ];
        $soapvar = new SoapVar($tokens, SOAP_ENC_OBJECT, null, null, "Security", SecurityPolicy::WSSE_NS);
        return new SoapHeader(SecurityPolicy::WSSE_NS, "Security", $soapvar);
    }

}
