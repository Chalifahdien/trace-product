<?php

namespace App\Http\Controllers;

use App\Services\BlockchainService;

class BlockchainController extends Controller
{
    public function index()
    {
        $blocks = BlockchainService::getAllBlocks();
        // $total = count($blocks);
        // dd($total);
        // dd($blocks);
        return view('blockchain', compact('blocks'));
    }
}
