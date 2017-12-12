<?php

/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 11/12/2017
 * Time: 21:12
 */
class Response
{

    public $_allow = array();
    public $_content_type = "application/json";
    public $_request = array();

    private $_code = 200;



    public function __construct(){
    }

    public function response($data,$status,$state){
        $this->_code = ($status)?$status:200;
        $this->set_headers();

        echo $this->request($this->_code.' '.$this->get_status_message(), $state ,$data);

        exit;
    }


    // For a list of http codes checkout http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    private function get_status_message(){
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[$this->_code])?$status[$this->_code]:$status[500];
    }

    private function request($status, $state ,$data){
        $request = array('status' => '','state' => 0,'result' => '');
        $request["status"] = $status;
        $request["state"] = $state;
        $request["result"] = $data ;

        return $this->json($request);
    }
    /*
       *	Encode array into JSON
      */
    public function json($data){
        if(is_array($data)){
            return json_encode($data);
        }
    }
    public function encodeHtml($responseData) {

        $htmlResponse = "<table border='1'>";
        foreach($responseData as $key=>$value) {
            $htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }


    public function encodeXml($responseData) {
        // creating object of SimpleXMLElement
        $xml = new SimpleXMLElement('<?xml version="1.0"?><api></api>');
        foreach($responseData as $key=>$value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }

    private function set_headers(){
        //  header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
        header("Content-Type:".$this->_content_type);
    }
    private function set_cross(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
    }

}