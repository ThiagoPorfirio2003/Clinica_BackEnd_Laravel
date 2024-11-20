<?php

namespace App\Support\PayloadWithStatus;

use App\Entities\Credentials\UserCredentialModel;
use App\Support\Status\MyHTTPStatus;

class UserCredentialsReturnDTO extends PayloadWithStatus
{
    public function __construct(MyHTTPStatus $myHTTPStatus, UserCredentialModel | null $userCredentials = null)
    {
        parent::__construct($myHTTPStatus, $userCredentials);
    }

    public function getPayload() : UserCredentialModel | null
    {
        return parent::getPayload();
    }

    public function setPayloadStrict(UserCredentialModel | null $userCredentials) : void
    {
        parent::setPayload($userCredentials);
    }   
}