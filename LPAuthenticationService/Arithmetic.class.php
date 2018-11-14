<?php

class Arithmetic {

    public function Security($header) {
        if ($header->UsernameToken->Username == "user" &&
                $header->UsernameToken->Password == "password") {
            return true;
        } else {
            throw new SoapFault("invalid login and password");
        }
    }

    public function Sum($param) {
        return $param->x + $param->y;
    }

    public function Product($param) {
        return $param->x * $param->y;
    }

}
