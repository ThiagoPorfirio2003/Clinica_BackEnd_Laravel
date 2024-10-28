<?php

namespace App\Classes;

class MyResponse
{
    private MyStatus $status;
    public $data;

    public function __construct(MyStatus $status, $data = null)
    {
        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus() : MyStatus
    {
        return $this->status;
    }

    public function setSatus(MyStatus $myStatus) : void
    {
        $this->status = $myStatus;
    }


}