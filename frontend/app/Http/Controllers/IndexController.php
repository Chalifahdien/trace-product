<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Models\ProductionStage;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // Admin
        $blocks = BlockchainService::getAllBlocks();
        $totalBlocks = count($blocks);
        $totalUsers = User::count();
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();

        // Produsen
        $totalProducts = Product::where('blockchain_hash', '!=', null)->count();
        $totalStages = ProductionStage::where('blockchain_hash', '!=', null)->count();
        $products = Product::where('blockchain_hash', '=', null)->get();
        // dd($total);

        // Distributor
        $totalDistributions = Distribution::count();
        $totalProductsNotDistributed = Product::whereNotNull('blockchain_hash')
            ->whereDoesntHave('distributions')
            ->count();
        $productsblmkirim = Product::whereNotNull('blockchain_hash')
            ->whereDoesntHave('distributions')
            ->get();

        $productsKonsumen = Product::whereHas('distributions', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->get();


        return view('beranda.index', compact('totalBlocks', 'blocks', 'logs', 'totalUsers', 'totalProducts', 'totalStages', 'products', 'totalDistributions', 'totalProductsNotDistributed', 'productsblmkirim', 'productsKonsumen'));
    }

    public function detail($id)
    {
        $product = Product::find($id);
        $stages = ProductionStage::where('product_id', $id)->get();
        $distributions = Distribution::where('product_id', $id)->get();
        return view('detail', compact('product', 'stages', 'distributions'));
    }
}
