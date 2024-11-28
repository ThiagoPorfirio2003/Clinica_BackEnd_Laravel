<?php

namespace App\Support;

class MyMessage
{
    public function __construct(public string $title, public string $message) 
    {}

    public function changeData(string $newTitle, string $newMessage) : void
    {
        $this->title = $newTitle;
        $this->message = $newMessage;
    }
}