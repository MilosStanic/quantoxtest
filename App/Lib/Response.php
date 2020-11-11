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
        header('Content-Type: application/xml');
        /* $xml = new SimpleXMLElement('<root/>');
        $result = $this->generateXML($xml, $data);
        print_r( $xml->asXML()); */
        // print_r($data);
        return $this->arrayToXML($data, new SimpleXMLElement('<root/>'), 'child');
    }   

    /**
* Converts an array to XML
*
* @param array $array
* @param SimpleXMLElement $xml
* @param string $child_name
*
* @return SimpleXMLElement $xml
*/
public function arrayToXML($array, SimpleXMLElement $xml, $child_name)
{
    foreach ($array as $k => $v) {
        if(is_array($v)) {
            (is_int($k)) ? $this->arrayToXML($v, $xml->addChild($child_name), $v) : $this->arrayToXML($v, $xml->addChild(strtolower($k)), $child_name);
        } else {
            (is_int($k)) ? $xml->addChild($child_name, $v) : $xml->addChild(strtolower($k), $v);
        }
    }

    return $xml->asXML();
}
}