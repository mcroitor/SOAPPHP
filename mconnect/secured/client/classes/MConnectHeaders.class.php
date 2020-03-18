<?php

class MConnectHeaders {

    const NAMESPACE = "https://mconnect.gov.md";
    var $_headers = [
        "CallingUser" => "",
        "CallingEntity" => "",
        "CallBasis" => "",
        "CallReason" => ""
    ];

    public function __construct(array $headers) {
        $this->_headers["CallingUser"] = $headers["CallingUser"];
        $this->_headers["CallingEntity"] = $headers["CallingEntity"];
        $this->_headers["CallBasis"] = $headers["CallBasis"];
        $this->_headers["CallReason"] = $headers["CallReason"];
    }

    public function GetSoapHeaders() {
        $result = [];
        foreach ($this->_headers as $key => $value) {
            $result[] = new SoapHeader(self::NAMESPACE, $key, $value);
        }
        return $result;
    }

}
