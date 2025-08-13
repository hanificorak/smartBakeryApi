<?php

namespace App\Http\Classes\Tools;

class ResultClass
{
    public  $status = false;
    public  $message = '';
    public  $obj = '';
    public  $error_message = '';
    public  $sub_info = '';
    public $count = 0;


    public function __construct($status = null, $message = null, $obj = null, $error_message = null, $sub_info = null, $count = 0)
    {
        if (!is_null($status) && $status != null) {
            $this->status = $status;
        }
        if (!is_null($message) && $message != null) {
            $this->message = $message;
        }
        if (!is_null($obj) && $obj != null) {
            $this->obj = $obj;
        }
        if (!is_null($error_message) && $error_message != null) {
            $this->error_message = $error_message;
        }
        if (!is_null($sub_info) && $sub_info != null) {
            $this->sub_info = $sub_info;
        }
        if (!is_null($count) && $count != null) {
            $this->count = $count;
        }
    }
}
