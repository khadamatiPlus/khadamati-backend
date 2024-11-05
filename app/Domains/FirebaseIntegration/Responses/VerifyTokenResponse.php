<?php

namespace App\Domains\FirebaseIntegration\Responses;

class VerifyTokenResponse
{
    /**
     * @var bool $verified
     */
    public $verified;

    /**
     * @var string $message
     */
    public $message;

    /**
     * VerifyTokenResponse constructor.
     * @param bool $verified
     * @param string $message
     */
    public function __construct(bool $verified, string $message)
    {
        $this->verified = $verified;
        $this->message = $message;
    }
}
