<?php

/**
 * The problem of default SoapServer - it don`t analyse exists SOAP header or not.
 * if header is not defined on WSDL file. Basically WS-Security is not defined,
 * but used. This extension permits to enable SOAP header analyse.
 */
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
        if ($request === null) {
            $request = file_get_contents('php://input');
        }
        $this->log_debug("request: " . print_r($request, true));
        // TODO #: send to analyzer only SOAP header!
        $envelope = new DOMDocument();
        $envelope->loadXML($request ? $request : "<Envelope />");
        $headers = $envelope->getElementsByTagName("Header");
        $this->log_debug("headers: " . print_r($headers, true));
        $has_security = $this->check_security($headers);
        if ($has_security !== true) {
            $this->fault($has_security["code"], $has_security["message"]);
            return;
        }

        $result = parent::handle($request);
        return $result;
    }

    private function check_security($headers) {
        if ($headers->length === 0) {
            $this->log_error("[403]: No headers");
            return ["message" => "No headers", "code" => 403];
        }
        $has_security = false;
        for ($index = 0; $index != $headers->length; ++$index) {
            $current = $headers->item($index);
            $has_security = $has_security || ($current->getElementsByTagName("Security")->length !== 0);
        }
        if ($has_security === false) {
            $this->log_error("[403]: No Security in headers");
            return ["message" => "No Security in headers", "code" => 403];
        }
        return true;
    }

    private function log_message($message, $log_file = "./logs/default.log") {
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');
        file_put_contents($log_file, "[{$timestamp}]: {$message}\n", FILE_APPEND);
    }

    private function log_debug($message) {
        if ($this->__debug === true) {
            $this->log_message($message, $this->__log_path);
        }
    }

    private function log_error($message) {
        $this->log_message($message, "./logs/error.log");
    }

}
