<?php

namespace App\Domains\FirebaseIntegration\Interfaces;

use App\Domains\FirebaseIntegration\Responses\VerifyTokenResponse;
use Kreait\Firebase\Messaging\CloudMessage;

interface FirebaseWorkInterface
{
    public function verifyToken(string $firebaseToken, string $phoneNumber):VerifyTokenResponse;

    public function verifyUID(string $uid, string $phoneNumber):VerifyTokenResponse;

    public function pushNotification(CloudMessage $message):void;
}
