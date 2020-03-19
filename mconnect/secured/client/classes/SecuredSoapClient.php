<?php

class SecuredSoapClient extends SoapClient {

    private $headers = [];
    public $private_key;
    public $public_key;
    public $passphrase;
    public $trusted_key; // trusted certificate

    public function __construct($wsdl, $options) {
        $this->debug = false;
        parent::__construct($wsdl, $options);
    }

    public function SetHeaders($headers) {
        if (is_array($headers)) {
            $this->headers = array_merge($this->headers, $headers);
        } else {
            $this->headers[] = $headers;
        }
        $this->__setSoapHeaders($this->headers);
    }

    public function SetAuthentication($authentication) {
        $this->headers[] = $authentication;
        $this->__setSoapHeaders($this->headers);
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0) {

        $signature = new XMLSignature([
            "private_key_path" => $this->private_key,
            "public_key_path" => $this->public_key,
            "passkey" => $this->passphrase,
            "trusted_key_path" => [$this->trusted_key]
        ]);

        $signed_request = $signature->apply($request);
        return parent::__doRequest($signed_request->C14N(), $location, $action, $version, $one_way);
    }

}
