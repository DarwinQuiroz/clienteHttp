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

    public function getProducts()
    {
        return $this->makeRequest('GET', 'products');
    }

    public function getProduct($id)
    {
        return $this->makeRequest('GET', "products/{$id}");
    }

    public function getCategories()
    {
        return $this->makeRequest('GET', 'categories');
    }

    public function getCategoryProducts($id)
    {
        return $this->makeRequest('GET', "categories/{$id}/products");
    }

    public function getUserInformation()
    {
        return $this->makeRequest('GET', "users/me");
    }
}
