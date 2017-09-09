<?php
namespace App\Classes;

/*
This class is used for API responses
This is a custom made class

Guidelines:

$status = ['UNSPECIFIED', 'OK', 'BAD']
$body = any
$message = any string related to the status
$code = [0 = Unspecified, 200 = Success, 400 = Error]
*/
class Response{
    private $status;
    private $body;
    private $message;
    private $code;
    public function __construct($code = 0, $status = 'UNSPECIFIED', $body = null, $message = 'Unspecified Message'){
        $this->status = $status;
        $this->body = $body;
        $this->message = $message;
        $this->code = $code;
    }

    public function make(){
        return [
            "status" => $this->status,
            "body" => $this->body,
            "message" => $this->message,
            "code" => $this->code
        ];
    }
}