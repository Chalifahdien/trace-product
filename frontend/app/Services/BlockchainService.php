<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlockchainService
{
    protected static $baseUrl = 'http://localhost:3001';

    public static function storeProduct($product)
    {
        $response = Http::post(self::$baseUrl . '/store-product', [
            'productId' => (string) $product->id,
            'name' => $product->name,
            'material' => $product->material,
        ]);

        if ($response->successful()) {
            return $response->json()['txHash'];
        }

        Log::error('Store Product Failed', ['error' => $response->body()]);
        return null;
    }

    public static function getProduct($productId)
    {
        $response = Http::get(self::$baseUrl . "/get-product/{$productId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Get Product Failed', ['productId' => $productId, 'error' => $response->body()]);
        return null;
    }

    public static function getAllProducts()
    {
        $response = Http::get(self::$baseUrl . '/products');

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Get All Products Failed', ['error' => $response->body()]);
        return [];
    }

    public static function addProductionStage($productId, $stageName)
    {
        $response = Http::post(self::$baseUrl . '/add-stage', [
            'productId' => (string) $productId,
            'stageName' => $stageName,
        ]);

        Log::info('Add Stage Response: ' . $response->body());

        if ($response->successful()) {
            return $response->json()['txHash'];
        }

        Log::error('Add Stage Failed', ['error' => $response->body()]);
        return null;
    }

    public static function getProductionStages($productId)
    {
        $response = Http::get(self::$baseUrl . "/get-stages/{$productId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Get Stages Failed', ['productId' => $productId, 'error' => $response->body()]);
        return [];
    }

    public static function addDistributor($productId, $destination)
    {
        $response = Http::post(self::$baseUrl . '/add-distributor', [
            'productId' => (string) $productId,
            'destination' => $destination,
        ]);

        Log::info('Add Distributor Response: ' . $response->body());

        if ($response->successful()) {
            return $response->json()['txHash'];
        }

        Log::error('Add Distributor Failed', ['error' => $response->body()]);
        return null;
    }

    public static function getDistributors($productId)
    {
        $response = Http::get(self::$baseUrl . "/get-distributors/{$productId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Get Distributors Failed', ['productId' => $productId, 'error' => $response->body()]);
        return [];
    }

    public static function getAllBlocks()
    {
        $response = Http::get('http://localhost:3001/get-all-blocks');

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Gagal mengambil semua block', ['error' => $response->body()]);
        return [];
    }
}
