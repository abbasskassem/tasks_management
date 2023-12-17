<?php

namespace App\Core\Helpers;


class  ErrorTemplate
{

    public function __construct(public readonly string $errorCode, public readonly string $errorMessage, public ?string $errorMessageDetails = null, public ?int $errorHTTPResponseCode = null, protected bool $displayErrorMessageDetailsInResponse = false)
    {

    }

    public static function fromException(CoreErrorException $coreErrorException): self
    {
        return new self($coreErrorException->messageCode, $coreErrorException->exception->getMessage(), $coreErrorException->messageDetails);
    }

    public function setDisplayErrorMessageDetailsInResponse(bool $displayErrorMessageDetailsInResponse): self
    {
        $this->displayErrorMessageDetailsInResponse = $displayErrorMessageDetailsInResponse;
        return $this;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getHttpResponseCode(): ?int
    {
        return $this->errorHTTPResponseCode;
    }

    public function getErrorMessageDetails(): ?string
    {
        return $this->errorMessageDetails;
    }


}
