<?php

namespace App\Support\PayloadWithStatus;

use App\Support\Status\MyHTTPStatus;

class StringWithStatus extends PayloadWithStatus
{
    public function __construct(MyHTTPStatus $myHTTPStatus, string $payload = '')
    {
        parent::__construct($myHTTPStatus, $payload);
    }

    public function getPayload() : string
    {
        return parent::getPayload();
    }

    public function setPayloadStrict(string $newPayload) : void
    {
        parent::setPayload($newPayload);
    }
}