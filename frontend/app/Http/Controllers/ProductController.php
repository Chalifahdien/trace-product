<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')
            ->get();


        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'material' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Simpan gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produk', 'public');
        }

        // Generate QR Code unik (misalnya UUID)


        // Simpan ke database lokal
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'material' => $request->material,
            'image' => $imagePath,
            'qr_code' => null,
            'blockchain_hash' => null
        ]);

        // Buat UUID untuk nama file QR code
        $uuid = (string) Str::uuid();
        $qrFileName = "qr_$uuid.png";

        // Buat URL tujuan QR code
        $qrUrl = url("/product/detail/" . $product->id); // full URL, misalnya http://localhost:8000/product/detail/5
        $qrPath = public_path('storage/qrcodes');

        // Cek jika folder belum ada, maka buat
        if (!File::exists($qrPath)) {
            File::makeDirectory($qrPath, 0755, true);
        }
        // Generate QR code yang mengarah ke URL
        QrCode::format('png')
            ->size(200)
            ->generate($qrUrl, public_path("storage/qrcodes/$qrFileName"));

        // Simpan nama file QR code ke database
        $product->qr_code = $qrFileName;
        $product->save();

        // (Opsional) Hash lokal, bisa dipakai untuk pengecekan internal
        // $localHash = sha1($product->id . $product->name . now());
        // dd($product->id);
        // Kirim ke Blockchain melalui Node.js
        // $txHash = BlockchainService::storeProduct($product);

        // // Simpan hash dari Blockchain (txHash)
        // if ($txHash) {
        //     $product->blockchain_hash = $txHash;
        //     $product->save();

        //     return redirect()->route('product.create')
        //         ->with('success', 'Produk berhasil ditambahkan & tercatat di blockchain!');
        // }

        return redirect()->route('product.create')
            ->with('success', 'Produk tersimpan');
    }
}
