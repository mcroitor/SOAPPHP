<?php

class ExtSoapServer extends SoapServer {

    private $__debug = false;
    private $__log_path = "./logs/debug.log";

    public function __construct($wsdl, $options = array()) {
        parent::__construct($wsdl, $options);
    }

    public function EnableDebug($debug = true): void {
        $this->__debug = $debug;
    }

    public function SetLogPath($log_path) {
        $this->__log_path = $log_path;
    }

    public function handle($request = null) {
        if ($this->__debug === true) {
            if ($request === null) {
                $soap_request = file_get_contents('php://input');
            }
            else {
                $soap_request = $soap_request;
            }
            $timestamp = gmdate('Y-m-d\TH:i:s\Z');
            file_put_contents($this->__log_path, "[{$timestamp}] request: " . print_r($soap_request, true) . "\n", FILE_APPEND);
        }
        if(empty($request)){
            $result = parent::handle();
        }
        else{
            $result = parent::handle($request);
        }
        return $result;
    }

}
