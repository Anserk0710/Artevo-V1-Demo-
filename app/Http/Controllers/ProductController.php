<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

use App\Http\Resources\ProductResource;
use App\Helpers\ActivityLogger;
use App\Models\ProductLike;

class ProductController extends Controller
{
    // Daftar aturan validasi yang digunakan untuk store dan update
    protected $validationRules = [
        'name' => 'required|string',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'size' => 'nullable|string',
        'material' => 'nullable|string',
    ];

    // Daftar field produk yang sering digunakan
    protected $productFields = ['name', 'price', 'description', 'image', 'size', 'material'];

    public function welcome()
    {
        $products = Product::latest()->take(6)->get();
        return Inertia::render('Welcome', [
            'products' => $products,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return Inertia::render('Admin/Products/Index', [
            'products' => ProductResource::collection($products)->response()->getData(true),
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function edit(Product $product)
        {
        \Log::info('Editing product:', ['product' => $product]);
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
    $validated = $request->validate($this->validationRules);

    // Handle image upload - PENTING: Jangan update image jika tidak ada file baru
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        
        $path = $request->file('image')->store('product-images', 'public');
        $validated['image'] = '/storage/' . $path;
    } else {
        // PERBAIKAN: Hapus field image dari validated data jika tidak ada file baru
        // Ini akan mempertahankan gambar yang sudah ada
        unset($validated['image']);
    }

    $originalData = $product->only($this->productFields);
    $product->update($validated);
    $updatedData = $product->fresh()->only($this->productFields); // Gunakan fresh() untuk data terbaru

    $changes = [];
    foreach ($originalData as $field => $originalValue) {
        if ($originalValue != $updatedData[$field]) {
            $changes[] = ucfirst($field) . ": '$originalValue' => '{$updatedData[$field]}'";
        }
    }

    if (!empty($changes)) {
        $description = $this->getAdminName() . " mengupdate produk ID {$product->id} dengan perubahan: " . implode(', ', $changes) . ".";
        $this->logActivity('Mengupdate Produk', $description);
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $description = 'ID: ' . $product->id . ' - Nama: ' . $product->name;
        $this->logActivity('Menghapus Produk', $description);

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product-images', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $product = Product::create($validated);

        $description = $this->getAdminName() . " menambahkan produk: Nama Produk: {$product->name}, Harga: {$product->price}, Ukuran: {$product->size}, Material: {$product->material}.";
        $this->logActivity('Menambah Produk', $description);

        // Return Inertia redirect to admin.products.index with success message
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function showByCode($code)
    {
        $product = Product::where('product_code', $code)->firstOrFail();
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    public function like(Request $request, $code)
    {
        $product = Product::where('product_code', $code)->firstOrFail();
        $ipAddress = $request->ip();

        // Cek apakah IP sudah pernah like produk ini
        $existingLike = ProductLike::where('product_id', $product->id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingLike) {
            return response()->json(['message' => 'Anda sudah memberikan like untuk produk ini.'], 429);
        }

        // Simpan like baru
        ProductLike::create([
            'product_id' => $product->id,
            'ip_address' => $ipAddress,
        ]);

        // Tambah jumlah likes di produk
        $product->increment('likes');

        return response()->json(['message' => 'Terima kasih telah memberikan like!', 'likes' => $product->likes]);
    }

    // Mendapatkan nama admin yang sedang login
    private function getAdminName()
    {
        return auth()->user()->name ?? 'Admin';
    }

    // Fungsi untuk mencatat aktivitas dengan ActivityLogger
    private function logActivity($action, $description)
    {
        ActivityLogger::log($action, $description);
    }
}
