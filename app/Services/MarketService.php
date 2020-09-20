<?php

namespace App\Services;

use App\Traits\AuthorizesMarketRequest;
use App\Traits\ComsumesExternalServices;
use App\Traits\InteractsWithMarketService;

class MarketService
{
    use ComsumesExternalServices, InteractsWithMarketService, AuthorizesMarketRequest;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
    }
}
