<?php

include_once './Token.interface.php';

class SecurityPolicy {

    private $securityToken;

    public function __construct(Token $secutiryToken) {
        $this->securityToken = $secutiryToken;
    }

    public function GetSoapHeader() {
        
    }

}
