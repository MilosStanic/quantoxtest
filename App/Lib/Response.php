<?php

namespace App\Lib;

use SimpleXMLElement;
use DOMDocument;

class Response
{
    private $status = 200;

    public function status(int $code)
    {
        $this->status = $code;
        return $this;
    }
    
    public function toJSON($data = [])
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function toXML($data = [])
    {
        http_response_code($this->status);
        header('Content-Type: text/xml');        
        return $this->simple2xml($data);
    }   

    private function simple2xml ($data){
        $xml = new SimpleXMLElement('<root />');
        array_walk_recursive($data, array ($xml,'addChild'));
        return $xml->asXML();
    }
}