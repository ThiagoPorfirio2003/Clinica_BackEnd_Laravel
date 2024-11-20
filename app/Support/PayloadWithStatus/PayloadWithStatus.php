<?php

namespace App\Support\PayloadWithStatus;

use App\Support\Status\MyHTTPStatus;

abstract class PayloadWithStatus
{
    protected function __construct(public MyHTTPStatus $myHTTPStatus, private mixed $payload) 
    {}

    public function getPayload() : mixed
    {
        return $this->payload;
    }

    protected function setPayload(mixed $newPayload) : void
    {
        $this->payload = $newPayload;
    }
}