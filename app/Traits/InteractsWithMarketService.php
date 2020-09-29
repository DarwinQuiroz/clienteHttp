<?php

namespace App\Traits;

trait InteractsWithMarketService
{
    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response);

        return $decodedResponse->data ?? $decodedResponse;
    }

    public function checkIfErrorResponse($response)
    {
        if(isset($response->error))
        {
            throw new \Exception("Algo ha ido mal: {$response->error}");
        }
    }
}
