<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')
            ->where('blockchain_hash', '!=', null)
            ->get();

        return view('distribusi.index', compact('products'));
    }

    public function show(Product $product)
    {
        $stages = $product->distributions()->orderBy('id', 'desc')->get();

        // $blockchainStages = BlockchainService::getProductionStages($product->id);
        // dd($blockchainStages);
        return view('distribusi.show', compact('product', 'stages'));
    }

    public function create(Product $product)
    {
        $users = User::where('role', 'konsumen')->get();
        return view('distribusi.create', compact('product', 'users'));
    }

    public function store(Request $request, Product $product)
    {

        $request->validate([
            'destination' => 'required|string|max:255',
            'received_by' => 'nullable|string|max:255',
            'distributed_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Simpan ke database terlebih dahulu
        $distribution = Distribution::create([
            'product_id' => $product->id,
            'user_id' => $request->user_id,
            'destination' => $request->destination,
            'received_by' => $request->received_by,
            'distributed_at' => $request->distributed_at,
            'notes' => $request->notes,
            'blockchain_hash' => null, // Akan diisi jika dicatat di blockchain
        ]);

        // (Opsional) Kirim ke blockchain, jika kamu punya method addDistributor di BlockchainService
        $txHash = BlockchainService::addDistributor($product->id, $distribution->destination);
        if ($txHash) {
            $distribution->blockchain_hash = $txHash;
            $distribution->save();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Add Distribution',
                'description' => $product->blockchain_hash,
            ]);

            return redirect()->route('distribution.show', $product)
                ->with('success', 'Distribusi berhasil ditambahkan & tercatat di blockchain!');
        }

        return redirect()->route('distribution.show', $product)
            ->with('success', 'Distribusi berhasil disimpan (tanpa blockchain).');
    }
}
