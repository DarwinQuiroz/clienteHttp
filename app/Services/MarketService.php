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

    public function publishProduct($sellerId, $productData)
    {
        return $this->makeRequest('POST', "sellers/{$sellerId}/products", [], $productData, [], true);
    }

    public function setProductCategory($productId, $categoryId)
    {
        return $this->makeRequest('PUT', "products/{$productId}/categories/{$categoryId}");
    }

    public function updateProduct($sellerId, $productId, $productData)
    {
        $productData['_method'] = 'PUT';
        return $this->makeRequest(
            'POST',
            "sellers/{$sellerId}/products/{$productId}",
            [],
            $productData,
            [],
            $hasFile = isset($productData['picture'])
        );
    }

    public function purchaseProduct($productId, $buyerId, $quantity)
    {
        return $this->makeRequest(
            'POST',
            "products/{$productId}/buyers/{$buyerId}/transactions",
            [],
            ['quantity' => $quantity]
        );
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

    public function getPurchases($buyerId)
    {
        return $this->makeRequest('GET', "buyers/$buyerId/products");
    }

    public function getPublications($sellerId)
    {
        return $this->makeRequest('GET', "sellers/$sellerId/products");
    }
}
