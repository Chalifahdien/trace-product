<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductionStage;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Auth;

class ProductionStageController extends Controller
{
    public function index(Product $product)
    {
        $stages = $product->stages()->orderBy('performed_at', 'desc')->get();
        $distribution = $product->distributions()->orderBy('id', 'desc')->get();

        $blockchainStages = BlockchainService::getProductionStages($product->id);
        // dd($blockchainStages);
        return view('tahapan.index', compact('product', 'stages', 'blockchainStages', 'distribution'));
    }

    public function create(Product $product)
    {
        if ($product->blockchain_hash != null) {
            return redirect()->route('stage.index', $product->id)->with('error', 'Tahapan produksi sudah ada di blockchain.');
        }
        return view('tahapan.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'stage_name' => 'required',
            'location' => 'nullable',
            'performed_by' => 'nullable',
            'notes' => 'nullable',
            'performed_at' => 'required|date',
        ]);

        ProductionStage::create([
            'product_id' => $product->id,
            'stage_name' => $request->stage_name,
            'location' => $request->location,
            'performed_by' => $request->performed_by,
            'notes' => $request->notes,
            'performed_at' => $request->performed_at,
            'blockchain_hash' => null,
        ]);

        return redirect()->route('stage.index', $product)->with('success', 'Tahapan tersimpan');
    }
    public function distribution(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->blockchain_hash != null) {
            return redirect()->route('stage.index', $product->id)->with('error', 'Tahapan produksi sudah ada di blockchain.');
        }

        // 1. Simpan produk ke blockchain jika belum
        if (!$product->blockchain_hash) {
            $txHash = BlockchainService::storeProduct($product);
            if ($txHash) {
                $product->blockchain_hash = $txHash;
                $product->save();

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'Add Product',
                    'description' => $product->blockchain_hash,
                ]);
            }
        }

        // 2. Kirim semua tahapan produksi ke blockchain yang belum tercatat
        $stages = ProductionStage::where('product_id', $product->id)->get();
        foreach ($stages as $stage) {
            if (!$stage->blockchain_hash) {
                $txHash = BlockchainService::addProductionStage($product->id, $stage->stage_name);
                if ($txHash) {
                    $stage->blockchain_hash = $txHash;
                    $stage->save();

                    ActivityLog::create([
                        'user_id' => Auth::id(),
                        'action' => 'Add Stage',
                        'description' => $stage->blockchain_hash,
                    ]);
                }
            }
        }

        return redirect()->route('stage.index', $product)
            ->with('success', 'Semua tahapan produksi berhasil dicatat di blockchain.');
    }
}
