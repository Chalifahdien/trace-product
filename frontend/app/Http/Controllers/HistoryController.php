<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BlockchainService;

class HistoryController extends Controller
{
    public function index(Product $product)
    {
        // Ambil histori tahapan dari database lokal
        $localStages = $product->stages()->orderBy('performed_at')->get();

        // Ambil histori tahapan dari blockchain
        $blockchainStages = BlockchainService::getProductionStages($product->id);
        dd($blockchainStages);
        return view('history', compact('product', 'localStages', 'blockchainStages'));
    }
}
