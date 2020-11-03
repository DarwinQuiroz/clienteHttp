<?php

namespace App\Services;

use App\Traits\ComsumesExternalServices;
use App\Traits\InteractsWithMarketService;

class MarketAuthenticationService
{
    use ComsumesExternalServices, InteractsWithMarketService;

    protected $baseUri;
    protected $clientId;
    protected $clientSecret;
    protected $passwordClientId;
    protected $passwordClientSecret;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
        $this->clientId = config('services.market.client_id');
        $this->clientSecret = config('services.market.client_secret');
        $this->passwordClientId = config('services.market.password_client_id');
        $this->passwordClientSecret = config('services.market.password_client_secret');
    }

    public function getClientCredentialsToken()
    {
        if($token = $this->existingValidClientCredentialsToken())
        {
            return $token;
        }

        $formParams = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'client_credentials');

        return $tokenData->access_token;
    }

    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = now()->addSeconds($tokenData->expires_in - 5);
        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";
        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData]);
    }

    public function existingValidClientCredentialsToken()
    {
        if(session()->has('current_token'))
        {
            $tokenData = session()->get('current_token');
            if(now()->lt($tokenData->token_expires_at))
            {
                return $tokenData->access_token;
            }
        }

        return false;
    }
}