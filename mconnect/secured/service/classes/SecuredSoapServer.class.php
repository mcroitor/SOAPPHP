<?php

class SecuredSoapServer extends SoapServer {

    // for validating requests
    var $trusted_key; // cer
    // for signing responses
    var $private_key; // pem
    var $public_key; // cer
    var $passkey; // password for pem

    public function __construct($wsdl = NULL) {
        parent::__construct($wsdl);
    }

    public function handle($request = null) {
        $clear_request = null;
// check variable HTTP_RAW_POST_DATA
        if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents('php://input');
        }

// check input param
        if (is_null($request)) {
            $request = $GLOBALS['HTTP_RAW_POST_DATA'];
        }

        if ($request) {
            error_log($request);
            try {
                $signature = new XMLSignature([
                    "private_key_path" => $this->private_key,
                    "public_key_path" => $this->public_key,
                    "passkey" => $this->passkey,
                    "trusted_key_path" => [$this->trusted_key]
                ]);
                $clear_request = $signature->validate($request);
            } catch (Exception $fault) {
                parent::fault($fault->getCode(), $fault->getMessage());
            }
        }

        ob_start();
        parent::handle($clear_request->C14N());
        $xml = ob_get_contents();
        ob_end_clean();
        try {
            $signature = new XMLSignature([
                "private_key_path" => $this->private_key,
                "public_key_path" => $this->public_key,
                "passkey" => $this->passkey,
                "trusted_key_path" => [$this->trusted_key]
            ]);
            $signedXml = $signature->apply($xml);
            header("Content-Length: " . strlen($signedXml->C14N()), true);
            echo $signedXml->C14N();
        } catch (Exception $fault) {
            parent::fault($fault->getCode(), $fault->getMessage());
        }
    }

}
