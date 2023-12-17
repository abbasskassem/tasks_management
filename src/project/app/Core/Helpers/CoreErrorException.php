<?php

namespace App\Core\Helpers;


class  CoreErrorException
{

    public function __construct(public \Throwable $exception, public readonly string $messageCode, public string $messageDetails, public bool $requireLogging = false, public bool $isCritical = false)
    {
    }

    public function setMessageDetails(string $messageDetails): void
    {
        $this->messageDetails = $messageDetails;
    }


}
